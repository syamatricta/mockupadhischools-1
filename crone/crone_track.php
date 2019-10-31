<?php

include('/home/adhischools/public_html/system/application/libraries/fedex/fedexapi.php');
include('/home/adhischools/public_html/system/application/libraries/fedex/fedextrack.php');
include("dbconfig.php");
include("time_helper.php");


$query = "SELECT o.trackingno,o.id,u.id as user_id,u.emailid
            FROM adhi_orderdetails AS o JOIN adhi_user as u on u.id = o.userid where o.status ='S' and delivered_date  ='0000-00-00' ";

$resul = mysql_query($query);

if ($resul) {
    while ($row = mysql_fetch_array($resul)) {
        $result_array[] = $row;
    }

    if (count($result_array) > 0) {
        foreach ($result_array as $result_array) {
	
            $aryTrackDetails = getTrack($result_array['trackingno']);


            $current_location = @$aryTrackDetails['ArrivalLocation'];
            $delivered_date = @$aryTrackDetails['DeleveryDate'];
            $status_code = @$aryTrackDetails['StatusCode'];

            if ($status_code == 'DL' or !empty($current_location)) {
                $arrSetOrder = " current_location = '" . $current_location . "'";

                if ($status_code == 'DL') {
                    $arrSetOrder .= " , status ='C', delivered_date = '{$delivered_date}'";
                }

                update_track($result_array['id'], $arrSetOrder, $delivered_date);
            }
            
        }
    }
}

function getTrack($track_id = '') {
    $strPath = "/home/adhischools/public_html/";

    $objTrack = new fedexTrack();
    $objTrack->requestType("track");
    $objTrack->wsdl_root_path = $strPath . "wsdl/";
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
            $aryTrackDetails['StatusCode'] = @$response->TrackDetails->StatusCode;
            $aryTrackDetails['StatusDescription'] = @$response->TrackDetails->StatusDescription;
            $aryTrackDetails['ActualDeliveryTimestamp'] = @$response->TrackDetails->ActualDeliveryTimestamp;
            $aryTrackDetails['ArrivalLocation'] = @$response->TrackDetails->Events->Address->ArrivalLocation;

            $deldate = $aryTrackDetails['ActualDeliveryTimestamp'];
            $delverydate = $deldate ? substr($deldate, 0, 10) : '';

            $aryTrackDetails['DeleveryDate'] = $delverydate;


        } else {
            //echo $objTrack->showResponseMessage($response);
//                echo "<pre>";
//                print_r($response);
//                echo "</pre>";
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

    $query = "UPDATE adhi_orderdetails set $arrSetOrder where id = '$order_id' ";
    $resul = mysql_query($query);
    if ($resul) {
        if ($delverydate != '') {
            $query = "select effective_date from adhi_user_course where orderid ='$order_id'";
            $resul = mysql_query($query);
            if ($resul) {

                while ($row = mysql_fetch_array($resul)) {
                    $effective_date = $row['effective_date'];
                    if ($effective_date == '0000-00-00') {
                        // pls note there is no effective date manually overide by admin
                        $query = "UPDATE  adhi_user_course set delivered_date  ='$delverydate',effective_date = DATE_ADD(delivered_date, INTERVAL 17 DAY) where orderid ='$order_id'";
                        //echo "jii";				
                        $resul = mysql_query($query);
                        if ($resul) {
                            $Email_Body = '';

                            $Email_Body = "<pre>";
                            $Email_Body = $Email_Body . "Exam Schedule" . " \n";
                            $Email_Body = $Email_Body . "--------------------------------------" . " \n";
                            $Email_Body .=
                                    '<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
                                                <tr>
                                                <td align="left"  width="150" >Course Name</td>
                                                <td align="left"  width="150" >Exam Date</td>
                                                </tr>';
                            $query = "select  date_format(u.effective_date,'%m/%d/%Y')as effectivedate,c.course_name
                                from  adhi_user_course as u join adhi_courses as c  on c.id = u.courseid where u.orderid ='$order_id'";
                            $resul = mysql_query($query);
                            if ($resul) {
                                while ($row = mysql_fetch_array($resul)) {

                                    $Email_Body .=
                                            '
                                                <tr>
                                                <td align="left"  width="150" >' . $row['course_name'] . '</td>
                                                <td align="left"  width="150" >' . $row['effectivedate'] . '</td>
                                                </tr>';
                                }
                            }
                            $Email_Body .= '</table>';
                            //echo $Email_Body	;

                            $to = $result_array['emailid'];
                            include_once('class.phpmailer.php');
                            include_once('mailconfig.php');
                            $mail = new PHPMailer();
                            $mail->From = constant('_SMTP_FROM');
                            $mail->FromName = constant('_SMTP_FROMNAME');
                            $mail->Subject = 'Exam Schedule';
                            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

                            $mail->MsgHTML($Email_Body);
                            $mail->AddAddress($result_array['emailid'], $result_array['firstname']);

                            $mail->IsSMTP();
                            $mail->Host = constant('_SMTP_HOST');
                            $mail->SMTPAuth = true;
                            $mail->Username = constant('_SMTP_USER');
                            $mail->Password = constant('_SMTP_PASS');
				$mail->Port = 465;
//                            if (!$mail->Send()) {
//                                echo "mail not delivered";
//                            } else {
//
//                                echo 'Mail successfully sent!';
//                            }
                        }
                    }
                }
            }
        }
    }
}

?>
