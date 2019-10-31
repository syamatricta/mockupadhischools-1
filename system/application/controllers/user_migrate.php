<?php
class User_migrate extends Controller {

       function User_migrate()
       {
            parent::Controller();
            $this->load->model('user_migrate_forum');
       }
       
       function migrate(){

       		//echo 'access denied'; die();
			require_once $this->config->item('site_basepath').'system/application/libraries/vbintegration.php';

       		$result = $this->user_migrate_forum->dbSelectAdhiusers();
                
            $count=0;
            
            $arr_user = $this->getUserArray();
            
       		foreach($result as $value){
       			if(!in_array($value['emailid'],$arr_user)){
	                $this->vbulletin = new xvbIntegration();
	       		
	                $vbInsert['username'] 	= $value['firstname'].$value['lastname'];
					$vbInsert['email'] 		= $value['emailid'];
					$vbInsert['password'] 	= $value['password'];
	                                
					$this->vbulletin->xvbRegister($vbInsert);
	                $count++;
       			}
       		 }
       		 
			 if($count>0){
       		 	echo "Data migrated :".$count;
			 }else{
			 	echo 'Error';
			 }
       }
       
       function getUserArray(){
       	
       		$result = $this->user_migrate_forum->dbSelectForumUsers();
       		$arr_user = array();
       		foreach($result as $value){
       			$arr_user[] = $value['email'];
       		}
       		return $arr_user;
       }
      
       function migrate_old(){

       		//echo 'access denied'; die();
			require_once $this->config->item('site_basepath').'system/application/libraries/vbintegration.php';

           //require_once '/var/www/html/adhischools/trunk/system/application/libraries/vbintegration.php';
       		$result = $this->user_migrate_forum->dbSelectAdhiusers();
                
                    $count=0;

                //print_r($result);
 
//       		 echo '<br/>'.$counterFail.' applicant login records failed';
       		

       		foreach($result as $value){
                $this->vbulletin = new xvbIntegration();
       		

                                //$vbInsert['username'] = $value['emailid'];
               $vbInsert['username'] = $value['firstname'].$value['lastname'];

               // $vbInsert['username'] = $value['emailid'];
                //$vbInsert['username'] = $value['forum_alias'];

				$vbInsert['email'] = $value['emailid'];
				$vbInsert['password'] = $value['password'];
                                

                              // $userfield['firstname'] = $value['firstname'];
                              //  $userfield['lastname'] = $value['lastname'];

                                
				//$this->vbulletin->xvbUpdate($vbInsert);
                              // $this->vbulletin->xvbRegister($vbInsert);

                              // $userfield['firstname'] = $value['firstname'];
                              //  $userfield['lastname'] = $value['lastname'];
				$this->vbulletin->xvbRegister($vbInsert);
                               // $this->vbulletin->xvbRegister($vbInsert,'','',$userfield);

				//$this->vbulletin->xvbRegister($vbInsert,'','',$userfield);
                            $count++;
       		 	}
       		 

       		 echo "Data migrated :".$count;
       }
}

       
