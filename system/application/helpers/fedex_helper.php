<?php

function getRate($aryRecipient, $aryOrder, $aryPackage){
    $CI->this = &get_instance();

    $aryResponse = array('status' => 0);

    $CI->this -> load -> library('fedex/fedexapi');
    $CI->this -> load -> library('fedex/fedexrate');

    $CI->this->fedexrate->requestType("rate");

    $CI->this->fedexrate->wsdl_root_path = c('wsdl_folder');

    $client = new SoapClient($CI->this->fedexrate->wsdl_root_path.$CI->this->fedexrate->wsdl_path, array('trace' => 1));

    $request = $CI->this->fedexrate->rateRequest($aryRecipient, $aryOrder, $aryPackage);

    try
    {
        if($CI->this->fedexrate->setEndpoint('changeEndpoint'))
        {
            $newLocation = $client->__setLocation(setEndpoint('endpoint'));
        }

        $response = $client->getRates($request);
        //p($response->HighestSeverity);exit;
        // && $response->HighestSeverity != 'WARNING'
        if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR'){

            $success = $CI->this->fedexrate->showResponseMessage($response);

            $rateReply = (!empty($response -> RateReplyDetails)) ? $response -> RateReplyDetails : array();

            $aryResponse['rateReply'] = $rateReply;
        }else{
            $error = $CI->this->fedexrate->showResponseMessage($response);
            $aryResponse['error'] = $error;
        }

    }
    catch (SoapFault $exception)
    {
        $aryResponse['error'] = $CI->this->fedexrate->requestError($exception, $client);
    }
    //p($request);

    return $aryResponse;


}



function getPackage($packageDetails = array()){
    $CI->this = &get_instance();
    $packages = array();
    $aryPackage = array();

    $total_packages = count($packageDetails);

    $pcnt = 0;
    foreach ($packageDetails as $package){
        $pno = $pcnt + 1;

        $packetDescription = (@$package['ItemDescription']) ? $package['ItemDescription'] : "FEDEX Package # $pno";

        $package_config = array('ItemDescription' => $packetDescription,'GroupPackageCount' => $total_packages, 'SequenceNumber' => 1);
        $CI->this -> load -> library('fedex/fedexpackage',$package_config);
        $CI->this->fedexpackage->setPackageWeight($package['weight']);     //Package Actual Weight
        //if(!IS_FEDEX_ONE_RATE_ENABLED){
            $CI->this->fedexpackage->setPackageDimensions($package['length'], $package['width'], $package['height']);       //Package (Length x Width x Height)
        //}
        $aryPackage[$pcnt] = $CI->this->fedexpackage->getObjectArray();

        $pcnt++;
    }

    return $aryPackage;
}


function setShipment($aryOrder,$aryRecipient,$realPackages,$est_amount,$package_weight){

    $CI->this = &get_instance();

    $CI->this->load->library('fedex/fedexapi');
    $CI->this->load->library('fedex/fedexrate');
    $CI->this->load->library('fedex/fedexshipment');

    if(empty($aryOrder)){
        $aryOrder = array(
            'TotalPackages' => 1,
            'PackageType' => 'YOUR_PACKAGING',        //FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
            'ServiceType' => 'INTERNATIONAL_PRIORITY',
            'TermsOfSaleType' => "DDU",         #    DDU/DDP
            'DropoffType' => 'REGULAR_PICKUP'         // BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
            //'TotalWeight' => array('Value' => 50.0, 'Units' => 'LB'), // valid values LB and KG
        );
    }
    $CI->this->fedexshipment->requestType("shipment");

    $CI->this->fedexrate->wsdl_root_path = c('wsdl_folder');

    $client = new SoapClient($CI->this->fedexshipment->wsdl_root_path . $CI->this->fedexshipment->wsdl_path, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

    //$realTotalPackages = count($realPackages);
    $realTotalPackages = 1;
    $est_amount = $est_amount;


    $tracking_id = "";
    $form_id = "";
    for($main_loop = 0;$main_loop<$realTotalPackages;$main_loop++)
    {

        $packages = array();
        $aryPackage = array();

        $packageDetails = $realPackages[$main_loop]['packageDetails'];

        $aryPackage = getPackage($packageDetails);

        $aryPackageItems = $realPackages[$main_loop]['aryPackageItems'];

        $package_amount = $realPackages[$main_loop]['package_amount'];

        $aryCustomClearance = $CI->this->fedexshipment->addCustomClearanceDetail($aryPackageItems, $package_amount);

        //echo '--Request---<br/>';
        /*if($main_loop>0)
        {
            $is_first_package['master_tracking_id'] = $tracking_id;
            $is_first_package['form_id'] = $form_id;
            $request = $CI->this->fedexshipment->requestShipment($aryRecipient, $aryOrder, $aryPackage, $aryCustomClearance, $is_first_package);
        }
        else*/
        //{
            $request = $CI->this->fedexshipment->requestShipment($aryRecipient, $aryOrder, $aryPackage, $aryCustomClearance);
            //echo '<pre>';print_r($request);exit;
        //}

        //  echo "<pre>";
        //  print_r($request);
        //  echo "</pre>";
        //p($request);
        try
        {
            if ($CI->this->fedexshipment->setEndpoint('changeEndpoint'))
            {
                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }

            $response = $client->processShipment($request); // FedEx web service invocation
            //p($response);exit;
            //echo '<pre>';
            //echo $client->__getLastRequest();
            //echo $client->__getLastResponse();exit;

            /* Logging the request response */
            $log_file_name_part = date('d-m-Y_h-i-s-A_').str_replace(' ', '-', $aryRecipient['Contact']['PersonName']);
            file_put_contents(c('site_basepath').'logs/fedex/shipment-request-'.$log_file_name_part.'.xml', $client->__getLastRequest(), FILE_APPEND);

            file_put_contents(c('site_basepath').'logs/fedex/shipment-response-'.$log_file_name_part.'.xml', $client->__getLastResponse(), FILE_APPEND);


            if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR')
            {
                $success = $CI->this->fedexshipment->showResponseMessage($response);

                //echo $success;

//                echo "<pre>";
//                print_r($response);
//                echo "</pre>";

                // Create PNG or PDF label
                // Set LabelSpecification.ImageType to 'PDF' for generating a PDF label

                $time= time();

                //$file_name = 'fedex-package_no_Helper_'.($main_loop+1).'.png';
                $file_name = $time.'mylabel.png';;
                $fp = fopen('./tmp/'.$file_name, 'wb');
                fwrite($fp, ($response->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image));
                fclose($fp);

                //echo 'Label <a href="' . $file_name . '">' . $file_name . '</a> was generated.';

                /*
                 * Store Master Tracking Number for First Package only
                 */
                //if($main_loop == 0)
                ///{
                    $tracking_id = $response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->TrackingNumber;
                    //$form_id = $response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->FormId;
                ///}

                $shipRet['label'] = $file_name;
                $shipRet['trackingno'] = $tracking_id;

                return $shipRet;
            }
            else
            {
//                echo "<pre>";
//                print_r($response);
//                echo "</pre>";
                $error = $CI->this->fedexrate->showResponseMessage($response);
                //echo $error;
                return 'error';
            }
        }
        catch (SoapFault $exception)
        {
            //echo $CI->this->fedexshipment->requestError($exception, $client);
            return 'error';

        }

        return 'error';

    }

}

function get_fedex_order_array($book_count){
    if(IS_FEDEX_ONE_RATE_ENABLED) {
        $package_type = get_fedex_packaging_type($book_count);

        $aryOrder = array(
            'TotalPackages'     => 1,
            'PackageType'       => $package_type,
            'ServiceType'       => c('fedex_one_rate_service_type'),
            'TermsOfSaleType'   => "DDU",               # DDU/DDP
            'DropoffType'       => 'REGULAR_PICKUP'     # BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
        );
    }else{
        $aryOrder = array(
            'TotalPackages'     => 1,
            'PackageType'       => c('fedex_packaging_type'), # FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
            'ServiceType'       => c('fedex_service_type'),
            'TermsOfSaleType'   => "DDU",                   # DDU/DDP
            'DropoffType'       => 'REGULAR_PICKUP'         # BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
        );
    }
    return $aryOrder;
}

function get_fedex_packaging_type($book_count){
    if(IS_FEDEX_ONE_RATE_ENABLED) {
        if ($book_count <= 2) {
            $package_type = 'FEDEX_PAK';
        } else if ($book_count == 3) {
            $package_type = 'FEDEX_MEDIUM_BOX';
        } else if ($book_count > 3 && $book_count <= 5) {
            $package_type = 'FEDEX_LARGE_BOX';
        } else if ($book_count > 5) {
            $package_type = 'FEDEX_EXTRA_LARGE_BOX';
        }
    }else{
        $package_type = c('fedex_packaging_type');
    }
    return $package_type;
}


function get_fedex_packaging_dimension($packaging){
    $dimensionArr = c('fedex_packaging_dimensions');
    if(isset($dimensionArr[$packaging])){
        $dimension = $dimensionArr[$packaging];
    }else{
        $dimension = $dimensionArr['DEFAULT'];
    }
    return $dimension;
}


/**
 * to access config settings easily
 *
 */
if( !function_exists('c')){
    function c($setting_name){
        $CI = &get_instance();
        return $CI->config->item($setting_name);
    }
}

function p($str){
    print('<pre>');
    print_r($str);
    print('<pre>');
}
