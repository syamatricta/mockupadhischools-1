<?php
$base_path = dirname(dirname(__FILE__));

include($base_path.'/system/application/libraries/fedex/fedexapi.php');
include($base_path.'/system/application/libraries/fedex/fedextrack.php');
include($base_path."/crone/db.php");
include($base_path."/crone/config.php");
include($base_path."/crone/time_helper.php");
$ENABLE_LOG     = true;
$log_file       = $base_path.'/crone/logs/cron_track-'.date('m-Y').'.txt';

$start_time     = time();
if($ENABLE_LOG){ file_put_contents($log_file, "=======================================".date('dS M H:i:s')."=======================================\n" , FILE_APPEND);}
$query = "SELECT o.trackingno,o.id,u.id as user_id,u.emailid, o.orderdate
            FROM adhi_orderdetails AS o JOIN adhi_user as u on u.id = o.userid where o.status ='S' 
            and delivered_date  ='0000-00-00' AND o.orderdate > '".date('Y-m-d', strtotime('-6 month'))."' ORDER BY o.orderdate ASC";

$resul = mysqli_query($mysql_con, $query);

//For loging
$total          = 0;
$success_count  = 0;
$error_count    = 0;
$result_array   = array();
if(mysqli_affected_rows($mysql_con)){
    while ($row = mysqli_fetch_assoc($resul)) {
        $result_array[] = $row;
    }
    $total =count($result_array);
    if (count($result_array) > 0) {
        foreach ($result_array as $result_array) {
            if($ENABLE_LOG){
                $string = $result_array['id']." | ".$result_array['orderdate']." | ".$result_array['trackingno']."\n";
                file_put_contents($log_file, $string , FILE_APPEND);
            }

            $aryTrackDetails = getTrack($result_array['trackingno']);


            $current_location   = @$aryTrackDetails['ArrivalLocation'];
            $delivered_date     = @$aryTrackDetails['DeleveryDate'];
            $status_code        = @$aryTrackDetails['StatusCode'];

            if($ENABLE_LOG){
                $string = $status_code;
                if(isset($aryTrackDetails['Message'])){ $string .= " - ".$aryTrackDetails['Message'];};
                $string .= "\n";
                file_put_contents($log_file, $string , FILE_APPEND);

            }

            if ($status_code == 'DL' or !empty($current_location)) {
                $arrSetOrder = " current_location = '" . $current_location . "'";

                if ($status_code == 'DL') {
                    $arrSetOrder .= " , status ='C', delivered_date = '{$delivered_date}'";
                }

                update_track($result_array['id'], $arrSetOrder, $delivered_date);

                $success_count++;

            }else if($status_code == 'ERROR'){
                $query = "UPDATE adhi_orderdetails SET status='E', tracking_update_error = '".$aryTrackDetails['Message']."' WHERE id = ".$result_array['id'];
                $resul = mysqli_query($mysql_con, $query);
                $error_count++;
                if($ENABLE_LOG) {
                    $string = "DB Updated\n-----------------------------------------\n";
                    file_put_contents($log_file, $string, FILE_APPEND);
                }
            }

        }
    }
}
if($ENABLE_LOG){
    $time_taken = time_diff_conv( $start_time, time());
    $string = "/////////////////////////////////////////////\n";
    $string .= "TOTAL : ".$total
        ." | SUCCESS : ".$success_count
        ." | ERROR : ".$error_count
        ." | NO DB CHANGE : ".($total-$success_count+$error_count)
        ." | TIME TAKEN : ".$time_taken."\n";
    $string .= "/////////////////////////////////////////////\n\n";

    file_put_contents($log_file, $string , FILE_APPEND);
}
mysqli_close($mysql_con);

function getTrack($track_id = '') {
    global $wsdl_path;

    $objTrack = new fedexTrack();
    $objTrack->requestType("track");
    $objTrack->wsdl_root_path = $wsdl_path;
    $client = new SoapClient($objTrack->wsdl_root_path . $objTrack->wsdl_path, array('trace' => 1));
    $request = $objTrack->trackRequest($track_id);

    $aryTrackDetails = array();
    try {
        if ($objTrack->setEndpoint('changeEndpoint')) {
            $newLocation = $client->__setLocation(setEndpoint('endpoint'));
        }

        $response = $client->track($request);

        if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') {
            //success
            //echo $response->TrackDetails->StatusDescription;
            $aryTrackDetails['StatusCode']              = @$response->TrackDetails->StatusCode;
            $aryTrackDetails['StatusDescription']       = @$response->TrackDetails->StatusDescription;
            $aryTrackDetails['ActualDeliveryTimestamp'] = @$response->TrackDetails->ActualDeliveryTimestamp;
            $aryTrackDetails['ArrivalLocation']         = @$response->TrackDetails->Events->Address->ArrivalLocation;

            $deldate        = $aryTrackDetails['ActualDeliveryTimestamp'];
            $delverydate    = $deldate ? substr($deldate, 0, 10) : '';

            $aryTrackDetails['DeleveryDate'] = $delverydate;


        } else if($response->HighestSeverity == 'FAILURE' || $response->HighestSeverity == 'ERROR'){
            $aryTrackDetails['StatusCode'] = 'ERROR';
            $aryTrackDetails['Message'] = $response->Notifications->Message;
        }
    } catch (SoapFault $exception) {
        //echo $objTrack->requestError($exception, $client);
//            echo "<pre>";
//            print_r($response);
//            echo "</pre>";
    }

    return $aryTrackDetails;
}

function update_track($order_id, $arrSetOrder, $delverydate) {
    global $mysql_con;
    global $ENABLE_LOG;
    global $log_file;

    $query = "UPDATE adhi_orderdetails set $arrSetOrder where id = '$order_id' ";
    if($ENABLE_LOG) {
        $string = "Status Updated in db\n";
        file_put_contents($log_file, $string, FILE_APPEND);
    }
    $resul = mysqli_query($mysql_con, $query);
    if ($resul) {
        if ($delverydate != '') {
            $query = "select effective_date from adhi_user_course where orderid ='$order_id'";
            $resul = mysqli_query($mysql_con, $query);
            if ($resul) {
                $effective_date_string = '';
                while ($row = mysqli_fetch_assoc($resul)) {
                    $effective_date = $row['effective_date'];
                    if ($effective_date == '0000-00-00') {
                        // pls note there is no effective date manually overide by admin
                        $query = "UPDATE  adhi_user_course set delivered_date  ='$delverydate', 
                                  effective_date = DATE_ADD(delivered_date, INTERVAL 17 DAY) where orderid ='$order_id'";
                        $resul = mysqli_query($mysql_con, $query);
                        $effective_date_string = 'Modified Effective date\n';
                    }
                }
                if($ENABLE_LOG) {
                    $string = $effective_date_string."\n-----------------------------------------\n";
                    file_put_contents($log_file, $string, FILE_APPEND);
                }
            }
        }
    }
}


?>