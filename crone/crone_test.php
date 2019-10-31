<?php
#FOR TEST PURPOSE

include('/home/adhischools/public_html/system/application/libraries/fedex/fedexapi.php');
include('/home/adhischools/public_html/system/application/libraries/fedex/fedextrack.php');
include("dbconfig.php");
include("time_helper.php");



$current_location = '';
$delivered_date = '2014-08-03';
$status_code = 'DL';

if ($status_code == 'DL' or !empty($current_location)) {
    $arrSetOrder = " current_location = '" . $current_location . "'";

    if ($status_code == 'DL') {
        $arrSetOrder .= " , status ='C', delivered_date = '{$delivered_date}'";
    }

    update_track(5134, $arrSetOrder, $delivered_date);
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
                    }
                }
            }
        }
    }
}

?>
