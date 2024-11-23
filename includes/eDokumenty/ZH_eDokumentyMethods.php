<?php

namespace Develtio\ZonesHewalex\eDokumenty;

use SoapClient;
use SoapFault;
use WP_REST_Response;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_eDokumentyMethods
 */
class ZH_eDokumentyMethods
{
    public static function getContext()
    {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);

        return $context;
    }

    public static function getOps() : array
    {
        $ops = array(
            'location' => 'https://dev-edokumenty.hewalex.net/api.php/SOAP/custom?a1=' . EDOK_API_LOGIN . '&a2=' . md5(md5(EDOK_API_PASSWORD) . '_SOAP_eDok_api') . '&a3=' . DEFAULT_ENTITY_SYMBOL . '',
            "uri" => "Contacts",
            'encoding' => 'UTF-8',
            'stream_context' => self::getContext()
        );
        return $ops;
    }

    public function contactsFilter($attribute){
        try {
            $client = $this->connectClient();
          	$response = $client->installers();
   
            $installers_json = [];
            $result = [];

            foreach ($response as $contact_details)
            {
                foreach($contact_details['features'] as $val => $feature) {
                  
                    if( $feature['featid']=== $attribute && $feature['txtval']=== 'Tak' ){
             
                    $installers_json['ID'] = $contact_details['contid'];
                    $installers_json['Name'] = $contact_details['name_1'];
                    $installers_json['BusinessName'] = $contact_details['name_2'];
                    $installers_json['Email'] = $contact_details['email_'];
                    $installers_json['Phone'] = $contact_details['ph_num'];
                    $installers_json['Website'] = $contact_details['websit'];
                    $installers_json['Features']['Type'] = $contact_details['type'];
                    $installers_json['Dystrybutor']['Dystrybutor'] = "Nie";
                    $installers_json['Addresses'] = [
                        'City' => $contact_details['city__'],
                        'Code' => $contact_details['code__'],
                        'Street' => $contact_details['street'],
                        'Province' => $contact_details['woj___'],
                        'Lat' => $contact_details['lat___'],
                        'Long' => $contact_details['lng___'],
                    ];
             

            $result[] = $installers_json;// ENDIF
         }
       
        }
        
    }

        $response = new WP_REST_Response($result);
        } catch (SoapFault $e) {
            $response = new WP_REST_Response('connection failed');
        }
        return $response;
    }



    public function getPompHeat(){
        return $this->contactsFilter('394');
    }


    /* Kolektory słoneczne */

    public function getCollectorSun(){
         return $this->contactsFilter('392');
    }


    /* Pompy ciepła do wody użytkowej */

    public function getPompHeatWater()
    {
        return $this->contactsFilter('393');   
    }
   

    /* Pompy ciepła do basenów kąpielowych */

    public function getPompHeatPool(){
        return $this->contactsFilter('395');
    }

    /* OptiEner */

    public function getOptiEner(){
        return $this->contactsFilter('397');
    }

    /* Fotowoltaika */

    public function getSunHeat()
    {
        return $this->contactsFilter('396');   
    }
   






    /* @DISTRIBUTOR */

        
    public function contactsFilterDistributor($attribute_distributor){
        try {
            
            $client = $this->connectClient();
            $response_distributors = $client->distributors();
            // print_r($response_distributors);
            $distributors_json = [];
            $result = [];

            foreach ($response_distributors as $contact_details)
            {
                    
                foreach($contact_details['features'] as $val => $feature) {
                if( $feature['featid']=== $attribute_distributor && $feature['txtval']=== 'Tak' ){
                      
             
                   $distributors_json['ID'] = $contact_details['contid'];
                   $distributors_json['Name'] = $contact_details['name_1'];
                   $distributors_json['BusinessName'] = $contact_details['name_2'];
                   $distributors_json['Email'] = $contact_details['email_'];
                   $distributors_json['Phone'] = $contact_details['ph_num'];
                   $distributors_json['Website'] = $contact_details['websit'];
                   $distributors_json['Features']['Type'] = $contact_details['type'];
                
                   $distributors_json['Addresses'] = [
                        'City' => $contact_details['city__'],
                        'Code' => $contact_details['code__'],
                        'Street' => $contact_details['street'],
                        'Province' => $contact_details['woj___'],
                        'Lat' => $contact_details['lat___'],
                        'Long' => $contact_details['lng___'],
                    ];
                 
            $result[] = $distributors_json;// ENDIF
        
         }
         
        }
        
    }

        $response_distributors = new WP_REST_Response($result);
        } catch (SoapFault $e) {
            $response_distributors = new WP_REST_Response('connection failed');
        }
        return $response_distributors;
  
    }
    
    public function getPompHeatDistributor(){
        return $this->contactsFilterDistributor('394');
    }


    /* Kolektory słoneczne */

    public function getCollectorSunDistributor(){
         return $this->contactsFilterDistributor('392');
    }


    /* Pompy ciepła do wody użytkowej */

    public function getPompHeatWaterDistributor()
    {
        return $this->contactsFilterDistributor('393');   
    }
   

    /* Pompy ciepła do basenów kąpielowych */

    public function getPompHeatPoolDistributor(){
        return $this->contactsFilterDistributor('395');
    }

    /* OptiEner */

    public function getOptiEnerDistributor(){
        return $this->contactsFilterDistributor('397');
    }

    /* Fotowoltaika */

    public function getSunHeatDistributor()
    {
        return $this->contactsFilterDistributor('396');   
    }
   




    public function getContactfromEdokById($edok_id)
    {
        try {
            $client2 = $this->connectClient();
            $response = $client2->getContact($edok_id, false);

        } catch (SoapFault $e) {
            $response = $e->getMessage();
            $response = wp_send_json('connection failed', 400);
        }

        return $response;
    }

    public function connectClient()
    {
        $client = new SoapClient(null, self::getOps());
        return $client;
    }
}