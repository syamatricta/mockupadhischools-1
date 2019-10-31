<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin Examination Controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Manu
 * @link		http://ahischools.com/admin/
 */

// ------------------------------------------------------------------------

class Admin_legacy_student extends Controller {
		
        /**
         * General contents
         *
         * @var Array
         */
        var $gen_contents	=	array();

        /**
         * Admin constructor
         * 
         */
        function Admin_legacy_student() {            
            parent::Controller();
            
            $this->load->helper(array('form', 'url', 'file'));
            $this->load->library('session');

            $this->load->library('authentication');
            $this->load->model('common_model');
            $this->load->model('admin_legacy_student_model');

            $this->gen_contents["js"]	= array('prototype.js', 'popup.js', 'effects.js', 'dragdrop.js');	
            $this->gen_contents['css']	= array('admin_style.css','calendar_style.css','dhtmlgoodies_calendar.css');
            $this->gen_contents['title']    = 'Legacy Students Management';
            //$this->output->enable_profiler(TRUE);
            if($this->authentication->logged_in ("admin") === "sub"){
                redirect("admin/noaccess");
                exit;
            }
        }


        function index() {
            //if($this->authentication->logged_in("admin")){redirect("admin_legacy_student/list_alls");}
            //redirect(c('admin_login_url'));
        }
        function list_all(){
            $this->gen_contents['page_title']   = 'Legacy Students';

            $this->load->library('pagination');
            $config['base_url']     = base_url().'admin_legacy_student/list_all/';
            $config['per_page']     = '10';
            $config['uri_segment']  = 3;

            $search         = array(
                                'first_name'=> '',
                                'last_name' => '',
                                'email_id'  => '',
                                'phone'     => '',
                                'address'   => '',
                                'first_name_null'=> '',
                                'last_name_null' => '',
                                'email_id_null'  => '',
                                'phone_null'     => '',
                                'address_null'   => '',
                                'day_rule_failed'=> '',
                                'course_not_found'=> '',
                                'validation'=> '',
                            );
            
            if(!empty($this->input->post('search'))) {
                //$search = $this->input->post('search');                
                $search = array_merge($search, $this->input->post('search'));
            }else if(!empty($this->session->flashdata('search')) && count($this->session->flashdata('search')) > 0){
                //$search = $this->session->flashdata('search');
            }

            //$this->session->set_flashdata('search', $search);

            $search['first_name']   = $this->common_model->safe_html($search['first_name']);
            $search['last_name']    = $this->common_model->safe_html($search['last_name']);
            $search['email_id']     = $this->common_model->safe_html($search['email_id']);
            $search['phone']        = $this->common_model->safe_html($search['phone']);
            $search['address']      = $this->common_model->safe_html($search['address']);
            $search['first_name_null']   = $this->common_model->safe_html($search['first_name_null']);
            $search['last_name_null']    = $this->common_model->safe_html($search['last_name_null']);
            $search['email_id_null']     = $this->common_model->safe_html($search['email_id_null']);
            $search['phone_null']        = $this->common_model->safe_html($search['phone_null']);
            $search['address_null']      = $this->common_model->safe_html($search['address_null']);
            $search['day_rule_failed']   = $this->common_model->safe_html($search['day_rule_failed']);
            $search['course_not_found']   = $this->common_model->safe_html($search['course_not_found']);
            $search['validation']   = $this->common_model->safe_html($search['validation']);

            $this->gen_contents['search']   = $search;
            $this->gen_contents["students"] = $this->admin_legacy_student_model->getAll($search, 'list', 10, $this->uri->segment(3));
            
            $config['total_rows']   = $this->admin_legacy_student_model->getAll($search, 'count');

            $this->pagination->initialize($config);
            $this->gen_contents['paginate']     = $this->pagination->create_links(true);
            $this->gen_contents['total_rows']   = $config['total_rows'];
            $this->_template('list_all', $this->gen_contents);
        }

        function _template ($page,$contents, $admin_folder='admin/legacy_student/'){
            $this->load->helper('form');
            $this->load->view("admin_header", $contents);
            $this->load->view($admin_folder.$page, $contents);
            $this->load->view("admin_footer");
        }


        function import(){

            if(!$this->authentication->logged_in("admin")){
                redirect(c('admin_login_url'));
            }else{
                $file_path = '/home/sreeraj/Project-Docs/Adhischools/legacy-students.xls';
                
                $this->load->plugin('exel_reader');
                $this->load->helper('remote_file_exists');

                // throw exception if file is missing
                if($file_path == null || file_exists($file_path) == FALSE) {
                    echo('Invalid file path!');exit;
                }

                //Read excel
                $data = new Spreadsheet_Excel_Reader();
                $data->setOutputEncoding('CP1251');
                //$data->setOutputEncoding('UTF8');
                $data->read($file_path);

                error_reporting(E_ALL);

                $courses    = $this->admin_legacy_student_model->getCourses();
                $course_arr = array();
                foreach ($courses as $course){
                    $course_arr[$course->id]    = strtolower(trim($course->course_name));
                }
                // Get the sheet data
                $sheet_data     = $data->sheets[0]['cells'];
                $sheet_raw_data = $data->sheets[0]['cellsInfo'];
                $student_count= 0;
                $column     = 0;
                $error_str  = '';
                $student_id = NULL;
                $courses    = array();
                
                //echo '<pre>';print_r($data->sheets[0]['cellsInfo']);echo '</pre>';exit;
                //echo '<pre>';print_r($sheet_data);echo '</pre>';exit;
                foreach($sheet_data as $key => $row_data) {
                    //echo '<pre>';print_r($row_data);echo '</pre>';
                    //echo '==============================='.$key.'=========================<br/>';
                    if(1 == $key){continue;}//Skip headings
                    
                    $data_validation_errors = array('warning' => array(), 'fatal' => array());
                    
                    if(isset($row_data[1]) && '' != $row_data[1] && (is_numeric($row_data[1]) || intval($row_data[1]) > 0)){
                        $previous_exam_date = NULL;
                        $rule_18day_rule_breaks_count   = 0;
                        $course_not_found_count         = 0;
                        
                        $phone = NULL;                        
                        if(isset($row_data[5])){
                            $phone = preg_replace('/\s+/', '', trim($row_data[5]));
                        }
                        $student   = array(
                            'first_name'        => trim($row_data[2]),
                            'last_name'         => (isset($row_data[3])) ? trim($row_data[3]) : NULL,
                            'email_id'          => (isset($row_data[4])) ? trim($row_data[4]) : NULL,
                            'phone'             => $phone,
                            'address'           => (isset($row_data[6])) ? trim($row_data[6]) : NULL,
                            'status'            => 1,
                            'validation_success'=> TRUE,
                            'created_at'        => date('Y-m-d H:i:s')
                        );
                        $student_id = $this->admin_legacy_student_model->insertStudent($student);
                        $student_count++;
                    }
                    
                    //Course details                    
                    if(isset($row_data[7]) && !empty(trim($row_data[7]))){
                        $rule_18day_status = 0;
                        $course_validation_errors   = array('warning' => array(), 'fatal' => array());
                        $course_name    = trim($row_data[7]);
                        if(strtolower('Real Estate Law') == strtolower($course_name) 
                                || strtolower('Legal Apects Real Estate') == strtolower($course_name)
                                || strtolower('Legal Aapests of Real Estate') == strtolower($course_name)
                        ){
                            $course_name    = strtolower('Legal Aspects of Real Estate');
                        }
                        if(strtolower('Real Estate Escrows') == strtolower($course_name) 
                                || strtolower('Real Estate Escrow') == strtolower($course_name)
                                || strtolower('Real Estate Esrcows') == strtolower($course_name)
                        ){
                            $course_name    = strtolower('Escrows');
                        }
                        if(strtolower('Real Estate Prcatice') == strtolower($course_name)
                                || strtolower('Real Estate Prctice') == strtolower($course_name)
                        ){
                            $course_name    = strtolower('Real Estate Practice');
                        }
                        if(strtolower('Real Estate Finnace') == strtolower($course_name)){
                            $course_name    = strtolower('Real Estate Finance');
                        }
                        if(strtolower('Real Estate Priciples') == strtolower($course_name)){
                            $course_name    = strtolower('Real Estate Principles');
                        }
                        if(strtolower('Real Estate Appriasal') == strtolower($course_name)){
                            $course_name    = strtolower('Real Estate Appraisal');
                        }
                        if(strtolower('Real Estate Property Management') == strtolower($course_name)
                                || strtolower('Proprty Managment') == strtolower($course_name)
                                || strtolower('Property Managment') == strtolower($course_name)
                        ){
                            $course_name    = strtolower('Property Management');
                        }
                        $course_id      = array_search(strtolower($course_name), $course_arr);
                        $course_id      = (FALSE === $course_id) ? NULL : $course_id;
                        if(NULL == $course_id){
                            $course_not_found_count++;
                            array_push($data_validation_errors['fatal'], 'Course name <i><b>'.$course_name.'</b></i> is not found on master database');
                            array_push($course_validation_errors['fatal'], 'Course name <i><b>'.$course_name.'</b></i> is not found on master database');
                        }
                        
                        $enrolled_date= NULL; 
                        if(isset($sheet_raw_data[$key][8])){
                            if('date' != $sheet_raw_data[$key][8]['type']){
                               array_push($data_validation_errors['fatal'], 'Enrolled date <i><b>'.trim($row_data[8]).'</b></i> is not valid for the <i><b>'.$course_name.'</b></i>'); 
                               array_push($course_validation_errors['fatal'], 'Enrolled date <i><b>'.trim($row_data[8]).'</b></i> is not valid');
                            }else{
                               $enrolled_date  = date('Y-m-d', $sheet_raw_data[$key][8]['raw']);
                            }
                        }else{
                            array_push($data_validation_errors['warning'], 'Enrolled date is not found for the course <i><b>'.$course_name.'</b></i>');
                            array_push($course_validation_errors['warning'], 'Enrolled date is not found');
                        }
                        
                        $exam_date= NULL;
                        if(isset($sheet_raw_data[$key][9])){
                            if('date' != $sheet_raw_data[$key][9]['type']){
                               array_push($data_validation_errors['fatal'], 'Final Exam Date <i><b>'.trim($row_data[9]).'</b></i> is not valid for the <i><b>'.$course_name.'</b></i>'); 
                               array_push($course_validation_errors['fatal'], 'Final Exam Date <i><b>'.trim($row_data[9]).'</b></i> is not valid');
                            }else{
                                $exam_date  = date('Y-m-d', $sheet_raw_data[$key][9]['raw']);
                                if(NULL !== $enrolled_date){
                                    $date_diff = $this->dateDifference($exam_date, $enrolled_date);
                                    if($date_diff < 17){
                                        $rule_18day_status = 2;
                                        $rule_18day_rule_breaks_count++;
                                        array_push($data_validation_errors['fatal'], 'Failed 18day Rule for the course <i><b>'.$course_name.'</b></i>. The difference between Enrolled date and Exam date is <i><b>'.$date_diff.' day(s)</b></i>'); 
                                        array_push($course_validation_errors['fatal'], 'Failed 18day Rule. The difference between Enrolled date and Exam date is <i><b>'.$date_diff.' day(s) </b></i>');
                                    }else{
                                        $rule_18day_status = 1;
                                    }
                                }
                            }
                        }else{
                            array_push($data_validation_errors['warning'], 'Final Exam Date is not found for the course <i><b>'.$course_name.'</b></i>');
                            array_push($course_validation_errors['warning'], 'Final Exam Date is not found');
                        }
                        
                        $score  = NULL;
                        if(isset($row_data[10])){
                            $score  = trim($row_data[10]);
                            $score= rtrim($score, '%');
                        }else{
                            array_push($data_validation_errors['warning'], 'Exam score is not found for the course <i><b>'.$course_name.'</b></i>');
                            array_push($course_validation_errors['warning'], 'Exam score is not found');
                        }
                        if(count($course_validation_errors['warning']) == 0 && count($course_validation_errors['fatal']) == 0){
                            $course_validation_errors   = NULL;
                        }else{
                            $course_validation_errors   = json_encode($course_validation_errors);
                        }
                        $course = array(
                            'student_id'                => $student_id,
                            'course_id'                 => $course_id,
                            'course_name_from_excel'    => $course_name,
                            'enrolled_date'             => $enrolled_date,
                            'exam_date'                 => $exam_date,
                            'score'                     => $score,
                            '18day_rule_status'         => $rule_18day_status,
                            'validation_errors'         => $course_validation_errors,
                            'created_at'                => date('Y-m-d H:i:s')
                        );
                        $this->admin_legacy_student_model->insertStudentCourse($course);
                        
                        
                    }else if(isset($row_data[8]) && !empty(trim($row_data[8]))){
                        array_push($data_validation_errors['warning'], 'No course name found but date of enrolled date found');
                    }else{
                        array_push($data_validation_errors['warning'], 'No course name found for this user');
                    }
                    $this->admin_legacy_student_model->updateStudentValidation($student_id, $data_validation_errors, $rule_18day_rule_breaks_count, $course_not_found_count);
                }
                
                $this->session->set_flashdata ('success', 'Successfully added '.$student_count.' student details');
                redirect('admin_legacy_student/list_all');
                
            }
        }
        
        function view_courses(){
            $student_id = $this->input->post('id');
            $courses    = $this->admin_legacy_student_model->getStudentCourses($student_id);
            if($courses){
                $courses     = array_map(function ($course){
                    $validation_errors = json_decode($course['validation_errors'], TRUE);
                    $course['validation_errors'] = (0 == count($validation_errors['warning']) && 0 == count($validation_errors['fatal'])) ? FALSE : $validation_errors;
                    return $course;
                }, $courses);
            }
            $view       = $this->load->view('admin/legacy_student/list_courses', array('courses' => $courses), TRUE);
            $this->load->view('dsp_show_ajax', array('return_value' => $view));
        }

        function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' ){
            $datetime1 = date_create($date_1);
            $datetime2 = date_create($date_2);

            $interval = date_diff($datetime1, $datetime2);

            return $interval->format($differenceFormat);

        }
        
        public function download_certificate(){
            $student_id = $this->uri->rsegment(3);
            $course_id  = $this->uri->rsegment(4);
            $details    = $this->admin_legacy_student_model->getPassedCourseDetails($student_id, $course_id);
            if($details){
                $this->_create_pdf($details);
            }else{
                $this->session->set_flashdata ('error', 'No details found');
                redirect('admin_legacy_student/list_all');
            }
        }
        private function _create_pdf($data){
            error_reporting(0);
            $filename   = $data->full_name.'-'.$data->course_name;
            $length     = strlen ($data->course_name);
            $this->load->library('fpdf');
            define('FPDF_FONTPATH',$this->config->item('fonts_path'));
            $this->fpdf->Open();
            $this->fpdf->AddPage('P','mm','A4');
            /*$this->fpdf->SetFont('Arial','B',14);
            $this->fpdf->SetY(30);
            $this->fpdf->Cell(40,10,'Hello World!');*/
            $cr_date=convert_UTC_to_PST_date_slash_pdf(date('d/m/Y H:i:s'));

            $this->fpdf->SetFont('Arial','B','11');
            $this->fpdf->Cell(100);
            $this->fpdf->cell(100,10,"1063 West 6th Street",0,0,'C');

            $this->fpdf->Ln(5);				
            $this->fpdf->Cell(100);
            $this->fpdf->SetFont('Arial','B','11');
            $this->fpdf->cell(100,10,"Second floor",0,0,'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(100);				
            $this->fpdf->cell(100,10,"Ontario, CA 91762",0,0,'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(100);				
            $this->fpdf->cell(100,10,"Tel : (888) 768-5285",0,0,'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(100);				
            $this->fpdf->cell(100,10,"Fax : (800) 598-3258",0,0,'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Image($this->config->item('site_basepath').'images/adhi_logo.jpg',10,12,30,0,'','https://www.adhischools.com');
            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('Arial','B','11');
            $this->fpdf->SetX(20);
            $this->fpdf->SetY(45); 
            $this->fpdf->cell(30,10,"Since 2003",0,0,'C');
            $this->fpdf->SetDrawColor(255,255,255);
            $this->fpdf->SetFillColor(255,255,255);
            $this->fpdf->SetFont('Arial','B','13');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(100);
            $this->fpdf->SetX(20);
            $this->fpdf->SetY(55); 
            $heading="Statutory Course Completion Certificate for CalBRE Approved Courses";

            $this->fpdf->printMiddle($heading);
            $this->fpdf->Ln(6);

            $this->fpdf->SetFont('Times','','11');
            $this->fpdf->Cell(20);
            $this->fpdf->cell(20,10,"Student Information:",0,0,'L');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            //$this->fpdf->cell(20,10,$userarray->firstname." ".$userarray->lastname,0,0,'L');
            $this->fpdf->cell(20,10,$data->full_name,0,0,'L');

            $this->fpdf->Ln(5);
            
            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x, $this->fpdf->GetY()+3);
            
            $this->fpdf->Cell(20);
            //MultiCell($w,$h,$txt,$border=0,$align='J',$fill=0)
            $this->fpdf->Multicell(60,5, trim($data->address),0,'L');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->cell(20,10,"Record of Course Completed:",0,0,'L');
            $this->fpdf->Ln(10);
            $this->fpdf->SetFillColor(255,0,0);
            $this->fpdf->SetTextColor(255);
            $this->fpdf->SetDrawColor(128,0,0);


            $this->fpdf->Ln(2);
            $this->fpdf->SetFont('Times','','9');
            $this->fpdf->SetFillColor(255,255,255);
            $this->fpdf->SetDrawColor(0,0,0);
            $this->fpdf->SetTextColor(0,0,0);
            $this->fpdf->Cell(20);
            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $y1 = $this->fpdf->GetY();
            $this->fpdf->MultiCell(25, 4, 'Date of Registration', 1,1);		
            $y2 = $this->fpdf->GetY();
            $yH = $y2 - $y1;
            $this->fpdf->SetXY($x + 25, $this->fpdf->GetY() - $yH);

            $this->fpdf->Cell(20, $yH, 'Live/Corr.', 1,1);			
            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x + 65, $this->fpdf->GetY()-$yH);
            $this->fpdf->MultiCell(18, 4, 'CalBRE Approval', 1,1);
            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x + 83, $this->fpdf->GetY()-$yH);
            $this->fpdf->Cell(20, $yH, 'Course Name', 1,1);	

            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x + 103, $this->fpdf->GetY()-$yH);
            $this->fpdf->MultiCell(18, 4, 'Date Started      ', 1,1);	

            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x + 121, $this->fpdf->GetY()-$yH);
            $this->fpdf->MultiCell(20, 4, 'Date Final Exam Taken', 1,1);	

            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x + 141, $this->fpdf->GetY()-$yH);
            $this->fpdf->MultiCell(20, 4, 'Number of Course Hours', 1,1);	

            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x + 161, $this->fpdf->GetY()-$yH);
            $this->fpdf->MultiCell(15, 4, 'Final Grade', 1,1);	
            $this->fpdf->SetFont('Times','','8');
            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $y1 = $this->fpdf->GetY();
            $this->fpdf->SetXY(30, $this->fpdf->GetY());
            $this->fpdf->MultiCell(25, 8, formatDate($data->enrolled_date) , 1,1);		

        $y2 = $this->fpdf->GetY();
            $yH = $y2 - $y1;

            $x = $this->fpdf->GetX();
            $x4=$x;
            $y = $this->fpdf->GetY();
            $y4 = $y;
            $this->fpdf->SetFont('Times','','8');
            $this->fpdf->SetXY($x + 35, $this->fpdf->GetY()-$yH);
            $this->fpdf->Cell(5, $yH-4, '1', 0,0);

            $this->fpdf->SetXY($x4 +45, $y4 - $yH);				
            $this->fpdf->Cell(20, $yH, 'Corr.', 1,1);		

            $x = $this->fpdf->GetX();
            $x3=$x;
            $y = $this->fpdf->GetY();
            $y3 = $y;
            $this->fpdf->SetFont('Times','','8');
            $this->fpdf->SetXY($x + 52, $this->fpdf->GetY()-$yH);
            $this->fpdf->Cell(5, $yH-4, '2', 0,0);

            $this->fpdf->SetXY($x3 +65, $y3 - $yH);				
            $this->fpdf->Cell(18, $yH, $data->course_code, 1,1);			

            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x + 83, $this->fpdf->GetY()-$yH);
            if($length<10)
                $this->fpdf->Cell(20, $yH, $data->course_name, 1,1);	
            else
                $this->fpdf->MultiCell(20, 4, $data->course_name, 1,1);	

            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x + 103, $this->fpdf->GetY()-$yH);
            $this->fpdf->Cell(18, $yH, formatDate($data->enrolled_date) , 1,1);	

            $x = $this->fpdf->GetX();
            $x2=$x;
            $y = $this->fpdf->GetY();
            $y2 = $y;
            $this->fpdf->SetFont('Times','','8');
            $this->fpdf->SetXY($x + 118, $this->fpdf->GetY()-$yH);
            $this->fpdf->Cell(5, $yH-4, '3', 0,0);

            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x2 + 121, $y2-$yH);
            $this->fpdf->Cell(20, $yH, formatDate($data->exam_date) , 1,1);	

            $x = $this->fpdf->GetX();
            $x1=$x;
            $y = $this->fpdf->GetY();
            $y1 = $y;
            $this->fpdf->SetFont('Times','','8');
            $this->fpdf->SetXY($x + 135, $this->fpdf->GetY()-$yH);
            $this->fpdf->Cell(5, $yH-4, '4', 0,0);

            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x1 + 141, $y1-$yH);
            $this->fpdf->Cell(20, $yH, '45' , 1,1);	
            $x = $this->fpdf->GetX();

            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x + 161, $this->fpdf->GetY()-$yH);
            $this->fpdf->Cell(15, $yH, $this->get_grade($data->score), 1,1);	
            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetFont('Times','','8');
            $this->fpdf->SetXY($x + 163, $this->fpdf->GetY()-$yH);
            $this->fpdf->Cell(5, $yH-4, '5', 0,0);

            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Times','','10');
            $this->fpdf->Cell(20);
            $this->fpdf->MultiCell(155, 4, "This Certificate contains the information needed for submittal to the California Bureau of Real Estate.",0,1,'L');


            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->cell(100,5,"Legend:",0,0,'L');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(15,4,"1"); 
            $this->fpdf->MultiCell(120,4,"The date the course was received by ADHI Schools LLC.",0,1,'L');
            $this->fpdf->Ln(2);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(15,4,"2"); 
            $this->fpdf->MultiCell(120,4,"Whether the course was live instruction or correspondence in nature.",0,1,'L');
            $this->fpdf->Ln(2);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(15,4,"3"); 
            $this->fpdf->MultiCell(120,4,"The date the student started the class, or in the case of correspondence, the date the student received materials.",0,1,'L');

            $this->fpdf->Ln(2);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(15,4,"4"); 
            $this->fpdf->MultiCell(120,4,"The date the final exam was administered to the student. This is not necessarily the date the exam was graded by ADHI Schools LLC.",0,1,'L');

            $this->fpdf->Ln(2);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(15,4,"5"); 
            $this->fpdf->MultiCell(120,4,"A Score of 60% or greater is required to credit. The grade given is based solely on the student's perfomance on the final exam.",0,1,'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->cell(100,5,"Below is how we calculated your grade:",0,0,'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->MultiCell(100,5,"100% - 90%          - A",0,1,'L');
            $this->fpdf->Cell(20);
            $this->fpdf->MultiCell(100,5,"89% - 80%            - B",0,1,'L');
            $this->fpdf->Cell(20);
            $this->fpdf->MultiCell(100,5,"79% - 70%            - C",0,1,'L');
            $this->fpdf->Cell(20);
            $this->fpdf->MultiCell(100,5,"69% - 60%            - D",0,1,'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->cell(100,5,"School Certification:",0,0,'L');

            $this->fpdf->Ln(8);
            $this->fpdf->Cell(25);
            $this->fpdf->MultiCell(150,4,"I hereby certify that this Certificate reflects the permanent record of the above named student.",0,1,'L');

            $this->fpdf->Ln(8);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(80,4,"Signature of authorized individual:");
            $this->fpdf->Cell(60,4,"Date Signed:",0,1,'L');

            $this->fpdf->Ln(5);

            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->SetXY($x,$y);

            $this->fpdf->Image($this->config->item('site_basepath').'images/adhi_sign.jpg',40,$y-5,20,20,'');
            $this->fpdf->Cell(45);
            $this->fpdf->Cell(80,4, formatDate($data->enrolled_date),0,1,'R');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(35,4,"Kartik Subramaniam");
            $this->fpdf->Ln(3);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(35,4,"ADHI Schools LLC");

            $this->fpdf->Ln(10);

            $this->fpdf->Cell(10);
            $this->fpdf->SetFont('Times','IB','8');
            $this->fpdf->Cell(180,2,"La Jolla  . Inland Empire  . Santa Monica ",0,1,'C');
            $this->fpdf->Ln(1);
            $this->fpdf->SetFillColor(0,0,0);
            $this->fpdf->SetDrawColor(0,0,0);

            $this->fpdf->SetTextColor(255);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(180,4,"www.adhischools.com",1,1,'C',true);
            if($filename !=''){
                $this->fpdf->Output($filename.'.pdf','D');
            }else{
                 $this->fpdf->Output('output.pdf','D');
            }
	}
        
        function get_grade($score){
            if($score<= 100 and $score >=90){
                return 'A';
            }
            else if($score<= 89 and $score >=80){
                return 'B';
            }
            else if($score<= 79 and $score >=70){
                return 'C';
            }
            else if($score<= 69 and $score >=60){
                return 'D';
            }
            else 	
            return FALSE;
	
	}
}