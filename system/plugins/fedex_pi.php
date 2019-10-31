<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * fedex Plugin
 *
 * @package		CodeIgniter
 * @subpackage	Plugin
 * @category	Plugin
 * @author		soumya
 * @link		http://ahischools.com/user/course
 */

// ------------------------------------------------------------------------

/*********Create Function listing shipping rates and services*********************/

function rateservices($arr){
	include('fedexdc.php');
	
	// create new FedExDC object
	$fed = new FedExDC(constant ('FEDEX_ACCNO'),constant ('FEDEX_METERNO'));
	
	// rate services example
	// You can either pass the FedEx tag value or the field name in the
	// $FE_RE array
	$rate_Ret = $fed->services_rate ($arr);
	
	  $rarray = array();
			
		$j=0;
		$arkeys=array_keys($rate_Ret);
		
		if(!(in_array(2,$arkeys))){
			 for ($i=1; $i<=$rate_Ret[1133]; $i++) {
				$rarray[$j]['service']=$fed->service_type($rate_Ret['1274-'.$i]);
				$rarray[$j]['fedexno']=$rate_Ret['1273-'.$i];
				$rarray[$j]['methodno']=$rate_Ret['1274-'.$i];
				$rarray[$j]['rate']=$rate_Ret['1419-'.$i];
				$j++;
			}
			return $rarray;
		}	else{
			$error ='error';
			$rate_Ret['error'] ='error';
			return $rate_Ret;
		}
		
			
	

}

function ship($arr){
	include('fedexdc.php');
	
	// create new FedExDC object
	$fed = new FedExDC(constant ('FEDEX_ACCNO'),constant ('FEDEX_METERNO'));
	if($arr[1274]!=90 and $arr[1274]!=92 ){
		
		$ship_Ret = $fed->ship_express($arr);
	}else{
		$arr[3025]='FDXG';
		//print_r($arr); die();
		$ship_Ret = $fed->ship_ground($arr);
	}
	if ( $fed->getError()) {
		$error= 'error';
		return $error;
	} 
	else {
		$time= time();
		$file = $time.'mylabel.png';
		$fed->label('./tmp/'.$file);
		$ship_Ret['label'] = $file;
		return $ship_Ret;
	}

}

?>