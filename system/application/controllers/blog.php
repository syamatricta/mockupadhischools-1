
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->library("session");
        $this->load->model('blog_model');
        $this->gen_contents['css'] = array('client_style.css', 'style.css');
        $this->gen_contents['js'] = array('client_login.js');
    }
    
    function index(){
        $url = $this->uri->segment(2);
        
        if("" != $url && !is_numeric($url)){
            $this->gen_contents['blog'] = $this->blog_model->blog_content($url);
            $this->gen_contents['meta_title'] = '';
            $this->gen_contents['meta_description'] = '';
            $this->gen_contents['meta_keywords'] = '';
            
            if(!empty($this->gen_contents['blog'])){
                $blog_meta = $this->blog_model->blog_meta($this->gen_contents['blog']->ID);
                $category = $this->gen_contents['blog']->category;
                $this->gen_contents['related'] = $this->blog_model->get_related_blog($category,$this->gen_contents['blog']->ID);
                
                if(!empty($blog_meta)){
                    foreach($blog_meta as $meta){
                        
                        if(isset($meta->_aioseop_title)){
                            $this->gen_contents['meta_title'] =  $meta->_aioseop_title;
                        }
                        
                        if(isset($meta->_aioseop_description)){
                            $this->gen_contents['meta_description'] =  $meta->_aioseop_description;
                        }
                        
                        if(isset($meta->_aioseop_keywords)){
                            $this->gen_contents['meta_keywords'] =  $meta->_aioseop_keywords;
                        }
                    }
                }
                $this->gen_contents['recent']  = $this->blog_model->get_recent_blog_content($this->gen_contents['blog']->ID);
                $this->load->view('blog/blog_page', $this->gen_contents);
            }else{
                redirect("error/error_404");
            }
        }else{
            $this->gen_contents['meta_title'] = 'Real Estate Blog | ADHI Schools';
            $this->gen_contents['meta_description'] = "For up-to-date news and helpful information on all things real estate, make sure to follow and share our ";
            $this->gen_contents['meta_keywords'] = '';
            $this->gen_contents['recent']  = $this->blog_model->get_recent_blog_content(0);


            $this->load->library('pagination');
            $config['base_url'] 		= base_url().'blog/';
            $config['per_page'] 		= '10';
            $config['uri_segment']              = 2;


            $config['total_rows']           = $this->blog_model->all_blog_content("count","");
            $this->gen_contents['blog']     = $this->blog_model->all_blog_content("data","",$config['per_page'], $this->uri->segment(3));
            $this->pagination->initialize($config);

            $this->gen_contents['paginate']     =   $this->pagination->create_links(true);
            $this->load->view('blog/main_page', $this->gen_contents);
        }
    }
    
    function category(){
        $cat1 = $this->uri->segment(3);
        
        if("" != $cat1){
            $cat = str_replace("-"," ",$cat1);
            $this->gen_contents['meta_title'] = 'AdhiSchools - California Real Estate License Training | AdhiSchools Blog';
            $this->gen_contents['meta_description'] = "There are many different groups of people that like to buy real estate. One of them is single mothers.Find out more at Adhi Schools online blog.";
            $this->gen_contents['meta_keywords'] = '';
            $this->gen_contents['recent']  = $this->blog_model->get_recent_blog_content(0);


            $this->load->library('pagination');
            $config['base_url'] 		= base_url().'blog/category/'.$cat1.'/';
            $config['per_page'] 		= '10';
            $config['uri_segment']              = 4;


            $config['total_rows']           = $this->blog_model->all_blog_content("count",$cat);
            $this->gen_contents['blog']     = $this->blog_model->all_blog_content("data",$cat,$config['per_page'], $this->uri->segment(4));
            $this->pagination->initialize($config);

            $this->gen_contents['paginate']     =   $this->pagination->create_links(true);
            $this->load->view('blog/main_page', $this->gen_contents);
        }else{
            redirect("error/error_404");
        }
    }

}
