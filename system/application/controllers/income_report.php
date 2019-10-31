<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Project				-	Adhischools
 * Language				-	PHP 5 & above
 * Database				-	Mysql
 * Author				-	Syama S
 * Created On                            -	March 29, 2016
 * Modified On                           -	March 29, 2016
 * Development Center                    -	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
 */
// ------------------------------------------------------------------------
class Income_report extends Controller {

    /**
     * General contents
     *
     * @var Array
     */
    var $gen_contents = array();
    var $datefrom = '';
    var $dateto = '';

    /**
     * Admin constructor
     *
     */
    function Income_report() {
        parent::Controller();
        
        $this->load->library('authentication');
        $this->load->helper(array('form', 'url', 'file'));
        
        if (!$this->authentication->logged_in("admin")) {
            redirect("admin");
        } else if ($this->authentication->logged_in("admin") === "sub") {
            redirect("admin/noaccess");
            exit;
        }
        $this->load->library(array('form_validation'));
        $this->load->model('income_report_model');
        $this->load->model('admin_user_model');
        $this->gen_contents['css']   =   array('admin_style.css', 'dhtmlgoodies_calendar.css');
        $this->gen_contents['js']    =   array('admin_report_js.js', 'popcalendar.js');
        $this->gen_contents['title'] =   'Enrollment Report';
    }

    /**
     * function to load the template (header, body and footer)
     *
     * @param string $page
     * @param array $contents
     */
    function _template($page, $contents) {
        $this->load->view("admin_header", $contents);
        $this->load->view('admin/report/' . $page, $contents);
        $this->load->view("admin_footer");
    }

    /**
     * Index
     *
     * @access	public
     */
    function index() {
        $this->list_report_details();
    }

    /**
     * function to list the report details
     *
     */
    function list_report_details() {
      
        if (isset($_POST['date_from']) && '' != $_POST['date_from']) {
            $this->gen_contents['datefrom'] = formatDate_search($this->input->post('date_from'));
        } else if ('' != $this->uri->segment(3)) {
            $this->gen_contents['datefrom'] = $this->uri->segment(3);
        } else if ('' != $this->uri->segment(3) && 0 == $this->uri->segment(3)) {
            $this->gen_contents['datefrom'] = '';
        } else {
            if(array_key_exists('ajax',$_POST)){
                $this->gen_contents['datefrom'] = '';
            } else {
                $this->gen_contents['datefrom'] = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
            }
        }
        if (isset($_POST['date_to']) && '' != $_POST['date_to']) {
            $this->gen_contents['dateto'] = formatDate_search($this->input->post('date_to'));
        } else if ('' != $this->uri->segment(4)) {
            $this->gen_contents['dateto'] = $this->uri->segment(4);
        } else {
            $this->gen_contents['dateto'] = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
        }
        
        $this->gen_contents['reg_type']   = ($this->uri->segment(5) == "") ? 3 : $this->uri->segment(5);
        $this->gen_contents['course_type']= ($this->uri->segment(6) == "") ? 3 : $this->uri->segment(6);
        $this->gen_contents['page_title'] = 'Enrollment Report';
        
        $datefrom = $this->gen_contents['datefrom'] == "" ? 0 : $this->gen_contents['datefrom'];
        $this->load->library('pagination');
        $config['base_url']               = base_url() . 'index.php/income_report/list_report_details/' . $datefrom . '/' . $this->gen_contents['dateto']. '/' . $this->gen_contents['reg_type']. '/' . $this->gen_contents['course_type'];
        $config['per_page']               = '10';
        $config['uri_segment']            = 7;
        $this->gen_contents["reports"]    = $this->income_report_model->select_reports($config['per_page'], $this->uri->segment(7), $this->gen_contents);
        $config['total_rows']             = $this->income_report_model->qry_count_reportdetails($this->gen_contents);
        
        $this->pagination->initialize($config);
        $this->gen_contents['paginate']   = $this->pagination->create_links(true);
        $this->_template('list_report_details', $this->gen_contents);
    }
    
    /**
     * function to list the report details excel
     *
     */
    function list_report_details_excel() {
        
        if (isset($_POST['date_from']) && '' != $_POST['date_from']) {
            $this->gen_contents['datefrom'] = formatDate_search($this->input->post('date_from'));
            $dt_from = date('m/d/Y',strtotime($this->gen_contents['datefrom']));
        } else if ('' != $this->uri->segment(3)) {
            $this->gen_contents['datefrom'] = $this->uri->segment(3);
            $dt_from = 'Beginning';
        } else if ('' != $this->uri->segment(3) && 0 == $this->uri->segment(3)) {
            $this->gen_contents['datefrom'] = '';
            $dt_from = 'Beginning';
        } else {
            $this->gen_contents['datefrom'] = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
            $dt_from = date('m/d/Y',strtotime($this->gen_contents['datefrom']));
        }
        
        if (isset($_POST['date_to']) && '' != $_POST['date_to']) {
            $this->gen_contents['dateto'] = formatDate_search($this->input->post('date_to'));
        } else if ('' != $this->uri->segment(4)) {
            $this->gen_contents['dateto'] = $this->uri->segment(4);
        } else {
            $this->gen_contents['dateto'] = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
        }
        
        $this->gen_contents['reg_type']   = ($this->uri->segment(5) == "") ? 3 : $this->uri->segment(5);
        $this->gen_contents['course_type']= ($this->uri->segment(6) == "") ? 3 : $this->uri->segment(6);
        $reports                          = $this->income_report_model->select_reports("", "", $this->gen_contents);
        
        //Show table values
        
        if(!empty($reports)){
            $row = 5;
            $no = 1;
            
            $this->load->library('Excel');
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Enrollment Report');  
            //set cell A1 content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', 'Enrollment Report ('.$dt_from.' - '. date('m/d/Y',strtotime($this->gen_contents['dateto'])).')');
            $this->excel->getActiveSheet()->setCellValue('A4', 'Sl.no.');
            $this->excel->getActiveSheet()->setCellValue('B4', 'Name');
            $this->excel->getActiveSheet()->setCellValue('C4', 'Email');
            $this->excel->getActiveSheet()->setCellValue('D4', 'Phone');
            $this->excel->getActiveSheet()->setCellValue('E4', 'Enrolled Date');
            $this->excel->getActiveSheet()->setCellValue('F4', 'Package');
            $this->excel->getActiveSheet()->setCellValue('G4', 'Created By');
            $this->excel->getActiveSheet()->setCellValue('H4', 'Reference');

            $this->excel->getActiveSheet()->mergeCells('A1:H1');
            //set aligment to center for that merged cell
            $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A4:H4')->getFont()->setBold(true);
            //make the font become bold
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
            $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

            for($col = ord('A'); $col <= ord('H'); $col++){
               //set column dimension
               $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                //change the font size
               $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

               $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            }
            
            foreach ($reports as $data){
                            switch($data->created_by){
                                case 1:
                                    $by =  'Admin';
                                    break;
                                case 2:
                                    $by =  'Sub-Admin';
                                    break;
                                default:
                                    $by =  'Student';
                                    break;
                            } 

                            if(($data->admin_fname != "" && $data->created_by != 1)){ 
                                $by.= "(".ucfirst($data->admin_fname)." ".ucfirst($data->admin_lname).")"; 
                            }

                            $tst = "";
                            if(($data->testimonial != "")){ 
                                $tst =  $data->testimonial;
                            }

                            if(($data->reason != "")){ 
                                $tst.="(".$data->reason.")";
                            }

                            $this->excel->getActiveSheet()->setCellValue('A'.$row,$no);
                            $this->excel->getActiveSheet()->setCellValue('B'.$row,ucfirst($data->firstname)." ".ucfirst($data->lastname));  
                            $this->excel->getActiveSheet()->setCellValue('C'.$row,$data->emailid);
                            $this->excel->getActiveSheet()->setCellValue('D'.$row,$data->phone);
                            $this->excel->getActiveSheet()->setCellValue('E'.$row,formatDate($data->enrolled_date));
                            $this->excel->getActiveSheet()->setCellValue('F'.$row,$data->course_type);
                            $this->excel->getActiveSheet()->setCellValue('G'.$row,$by);
                            $this->excel->getActiveSheet()->setCellValue('H'.$row,$tst); 

                            $row++;
                            $no++;
            }
            
            $filename = 'Enrollment_Report_'.date('m_d_Y').'_'.time().'.xls';       //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel');                   //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0');                                 //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //ob_end_clean();
            $objWriter->save('php://output');
        }
    }
    

}

/* End of file income_report.php */
/* Location: ./system/application/controllers/income_report.php */