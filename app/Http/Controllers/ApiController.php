<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ApiController extends Controller
{
	public $_apiVersion;
	public $_apiUrl;

    public function __construct()
    {
    	$this->_apiVersion = 'v1';
    	$devDomains = array('api' => 'beachvolleybalbladel.app');

        // Default          
        $this->_apiUrl = 'https://api.vcbladel.nl';
        // Dev domain
    	if( isset($_SERVER['HTTP_HOST']) && in_array($_SERVER['HTTP_HOST'], $devDomains)) {
    		$this->_apiUrl = 'vcb-api.app';
        }
    }

    /**
     * Public function that makes the curl request to the api
     * @param  string $endpoint endpoint url
     * @param  string $type     request type
     * @param  [type] $headers  request headers
     * @param  [type] $fields   additional fields
     * @return array            response from api
     */
    public function apiCall($endpoint = NULL, $type = 'get', $headers = NULL, $fields = NULL)
    {
    	$url = $this->_apiUrl . '/' . $this->_apiVersion;
    	$endpointUrl = $url . $endpoint;

    	$response = $this->curlRequest($endpointUrl, $type, $headers, $fields);
    	return $response;
    }

    /**
     * Execute curl request
     * @param  $url     Full API url
     * @param  $type    Request type
     * @param  $headers Request headers
     * @param  $fields  Additional fields
     * @return array
     */
    private function curlRequest($url = NULL, $type = NULL, $headers = NULL, $fields = NULL)
    {
    	$ch = curl_init();

    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 3);

    	if(strstr($url, 'https')) {
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    	} else {
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	}

    	if($type == 'post' || $type == 'delete' || $type == 'put') {
    		if($type == 'post') {
    			curl_setopt($ch, CURLOPT_POST, 1);
    		} elseif($type == 'delete') {
    			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    		} elseif($type == 'put') {
    			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    		}

            if($fields != NULL && is_array($fields)) {
                $fieldsString = http_build_query($fields);

                curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);
            }
    	}

    	if($headers != NULL) {
    		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	}

    	$result = curl_exec($ch);
    	$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    	if($result !== FALSE) {
	    	if($this->isJson($result)) {
	    		return json_decode($result);
	    	}
	    }

    }

    /**
     * Checks if result from curl request is a JSON
     * @param  $string JSON string
     * @return boolean
     */
    private function isJson($string)
    {
    	json_decode($string);
    	return (json_last_error() == JSON_ERROR_NONE);
    }
}
