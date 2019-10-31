<?php //if (!defined('BASEPATH')) exit('No direct script access allowed');

class FedexAPI
{
    protected $ship_account;
    protected $bill_account;
    protected $duty_account;
    protected $account_to_validate;
    protected $track_account;
    protected $account;

    protected $ServiceId;
    protected $Major;

    protected $meter;
    protected $key;
    protected $password;

    public $wsdl_root_path;
    public $wsdl_path;

    public function FedexAPI($mode = "test")
    {
        if('production' == ENVIRONMENT)
        {
            $this->ship_account         = "112117431";
            $this->bill_account         = "112117431";
            $this->duty_account         = "112117431";
            $this->account_to_validate  = "XXXXXXXXX";
            $this->track_account        = "XXXXXXXXX";
            $this->account              = "XXXXXXXXX";                  //FEDEX Account Number
            $this->meter                = "105248760";                  //Production Meter Number
            $this->key                  = "age39EEOVVORB5vu";           //Production Key
            $this->password             = "gUP5QM63ezwm7wYdROKP7g0I7";  //Production Password

            $this->setWSDLRoot("wsdl/");

        }else{

            $this->ship_account         = "510087860";
            $this->bill_account         = "510087860";
            $this->duty_account         = "510087860";
            $this->account_to_validate  = "XXXXXXXXX";
            $this->track_account        = "XXXXXXXXX";
            $this->account              = "XXXXXXXXX";
            $this->meter                = "118580829";
            $this->key                  = "TP0j47p1E8CvIRwA";
            $this->password             = "HnPfzLJPkeoLouQIZlBF4AcKI";

            $this->setWSDLRoot("wsdl-test/");

        }
    }

    public function setWSDLRoot($root = "wsdl/"){
        $this->wsdl_root_path = $root;
    }

    public function requestError($exception, $client){
        $str = "";
        $str .= '<h2>Fault: </h2>';
        $str .= "<b>Code:</b>{$exception->faultcode}<br>\n";
        $str .= "<b>String:</b>{$exception->faultstring}<br>\n";
        return $str;
    }

    public function getAuthenticationDetail(){
        $aryAuthentication = array(
            'UserCredential' =>array(
                'Key' => $this->key,
                'Password' => $this->password
            )
        );
        return $aryAuthentication;
    }

    public function getClientDetail(){
        $aryClient = array(
            'AccountNumber' => $this->ship_account,
            'MeterNumber' => $this->meter
        );

        return $aryClient;
    }

    public function getServiceVersion(){
        $aryVersion = array(
            'ServiceId' => $this->ServiceId,
            'Major'     => $this->Major,
            'Intermediate' => '0',
            'Minor'     => 0
        );
        return $aryVersion;
    }

    function addShippingChargesPayment()
    {
        if(IS_FEDEX_ONE_RATE_ENABLED){
            $shippingChargesPayment = array
            (
                'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
                'Payor' => array(
                    'ResponsibleParty' => array(
                        'AccountNumber' => $this->bill_account,
                        'Contact' => null,
                        'Address' => array(
                            'CountryCode' => 'US'
                        )
                    )
                )
            );
        }else{
            $shippingChargesPayment = array
            (
                'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
                'Payor' => array
                (
                    'AccountNumber' => $this->bill_account,
                    'CountryCode' => 'US'
                )
            );
        }
        return $shippingChargesPayment;
    }

    function addSpecialServices()
    {
        $specialServices = array(
            'SpecialServiceTypes' => array('COD'),
            'CodDetail' => array(
                'CodCollectionAmount' => array('Currency' => 'USD', 'Amount' => 150),
                'CollectionType' => 'ANY')// ANY, GUARANTEED_FUNDS
        );
        return $specialServices;
    }

    public function requestType($type)
    {
        switch($type)
        {
            case "address":
                $this->wsdl_path = "AddressValidationService_v2.wsdl";
                $this->Major = 10;
                break;
            case "package":
                $this->wsdl_path = "PackageMovementInformationService_v5.wsdl";
                $this->Major = 10;
                break;
            case "close":
                $this->wsdl_path = "CloseService_v2.wsdl";
                $this->Major = 10;
                break;
            case "locator":
                $this->wsdl_path = "LocatorService_v2.wsdl";
                $this->Major = 10;
                break;
            case "pickup":
                $this->wsdl_path = "PickupService_v3.wsdl";
                $this->ServiceId = "disp";
                $this->Major = 3;
                break;
            case "rate":
                if(IS_FEDEX_ONE_RATE_ENABLED){
                    $this->wsdl_path = "RateService_v22.wsdl";
                    $this->Major     = 22;
                }else{
                    $this->wsdl_path = "RateService_v10.wsdl";
                    $this->Major     = 10;
                }
                $this->ServiceId = "crs";
                break;
            case "return":
                $this->wsdl_path = "ReturnTagService_v1.wsdl";
                $this->Major = 10;
                break;
            case "shipment":
                if(IS_FEDEX_ONE_RATE_ENABLED) {
                    $this->wsdl_path = "ShipService_v21.wsdl";
                    $this->Major = 21;
                }else{
                    $this->wsdl_path = "ShipService_v10.wsdl";
                    $this->Major = 10;
                }
                $this->ServiceId = "ship";
                break;
            case "track":
                $this->wsdl_path = "TrackService_v5.wsdl";
                $this->ServiceId = "trck";
                $this->Major = 5;
                break;
            case "upload":
                $this->wsdl_path = "UploadDocumentService_v1.wsdl";
                $this->Major = 10;
                break;
            default:
                $this->wsdl_path = "";
                $this->Major = 10;
                break;
        }
    }

    function setEndpoint($var)
    {
        if($var == 'changeEndpoint')
            return false;

        if($var == 'endpoint')
            return '';
    }


    public function addShipper()
    {
        $shipper = array
        (
            'Contact' => array
            (
                'PersonName' => 'Kartik',
                'CompanyName' => 'Adhi Schools',
                'PhoneNumber' => '888-768-5285'
            ),
            'Address' => array
            (
                'StreetLines' => array
                (
                    '1063 West 6th Street, Second floor' //3350 Shelby Street, Suite 200
                ),
                'City' => 'Ontario',//Ontario
                'StateOrProvinceCode' => 'CA',
                'PostalCode' => '91762',// 91764
                'CountryCode' => 'US'
            )
        );

        return $shipper;
    }

    public function showResponseMessage($response)
    {
        if(isset($response->Notifications->Message))
            return $response->Notifications->Message;
        else
            return $response->Notifications[0]->Message;
    }

    public function getServiceTypeName($service_type)
    {
        $s_type = "";
        if(trim($service_type) == "")
            return false;
        switch($service_type)
        {
            case "INTERNATIONAL_ECONOMY":
                $s_type = "International Economy";
                break;
            case "INTERNATIONAL_PRIORITY":
                $s_type = "International Priority";
                break;
            case "EUROPE_FIRST_INTERNATIONAL_PRIORITY":
                $s_type = "International Priority (Europe First)";
                break;
            case "INTERNATIONAL_FIRST":
                $s_type = "International First";
                break;
            default:
                $s_type = "";
        }
        return $s_type;
    }

}
?>