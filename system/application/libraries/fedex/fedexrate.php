<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class FedexRate extends FedexAPI
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function rateRequest($aryRecipient, $aryOrder, $aryPackage)
        {
            $request['WebAuthenticationDetail'] = $this->getAuthenticationDetail();
            $request['ClientDetail']            = $this->getClientDetail();

            $request['TransactionDetail']       = array('CustomerTransactionId' => ' *** Rate Request v22 using PHP ***');
            $request['Version']                 = $this->getServiceVersion();

            $request['ReturnTransitAndCommit']  = true;

            $request['RequestedShipment']['DropoffType']    = $aryOrder['DropoffType'];
            $request['RequestedShipment']['ShipTimestamp']  = date('c');
            if(IS_FEDEX_ONE_RATE_ENABLED){
                $request['RequestedShipment']['ServiceType']    = $aryOrder['ServiceType'];
                $request['RequestedShipment']['PackagingType']  = $aryOrder['PackageType'];
                $request['RequestedShipment']['SpecialServicesRequested']['SpecialServiceTypes'] = 'FEDEX_ONE_RATE';
            }else{
                $request['RequestedShipment']['PackagingType'] = $aryOrder['PackageType'];
            }

            $request['International']['TermsOfSaleType']    = $aryOrder['TermsOfSaleType'];

            //$request['RequestedShipment']['TotalInsuredValue'] = array('Ammount'=>100,'Currency'=>'USD');//No Need

            $request['RequestedShipment']['Shipper']        = $this->addShipper();
            $request['RequestedShipment']['Recipient']      = $aryRecipient;
            //$request['RequestedShipment']['ShippingChargesPayment'] = $this->addShippingChargesPayment(); //No Need
            $request['RequestedShipment']['RateRequestTypes']   = 'ACCOUNT';
            $request['RequestedShipment']['RateRequestTypes']   = 'LIST';
            $request['RequestedShipment']['PackageCount']       = $aryOrder['TotalPackages'];
            $request['RequestedShipment']['RequestedPackageLineItems'] = $aryPackage;

            return $request;

        }/*end of rateRequest()*/

        public function rateRequestOLD($aryRecipient, $aryOrder, $aryPackage)
        {            
            $request['WebAuthenticationDetail'] = $this->getAuthenticationDetail();            
            $request['ClientDetail'] = $this->getClientDetail();

            $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request v10 using PHP ***');
            $request['Version'] = $this->getServiceVersion();
            
            $request['ReturnTransitAndCommit'] = true;

            $request['RequestedShipment']['DropoffType'] = $aryOrder['DropoffType'];
            $request['RequestedShipment']['ShipTimestamp'] = date('c');
            //$request['RequestedShipment']['ServiceType'] = $aryOrder['ServiceType'];
            $request['RequestedShipment']['PackagingType'] = $aryOrder['PackageType'];
            
            $request['International']['TermsOfSaleType'] = $aryOrder['TermsOfSaleType'];
            
            //$request['RequestedShipment']['TotalInsuredValue'] = array('Ammount'=>100,'Currency'=>'USD');//No Need
            
            $request['RequestedShipment']['Shipper'] = $this->addShipper();
            $request['RequestedShipment']['Recipient'] = $aryRecipient;
            //$request['RequestedShipment']['ShippingChargesPayment'] = $this->addShippingChargesPayment(); //No Need
            $request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
            $request['RequestedShipment']['RateRequestTypes'] = 'LIST'; 
            $request['RequestedShipment']['PackageCount'] = $aryOrder['TotalPackages'];
            $request['RequestedShipment']['RequestedPackageLineItems'] = $aryPackage;

            return $request;

        }/*end of rateRequest()*/
    }
?>