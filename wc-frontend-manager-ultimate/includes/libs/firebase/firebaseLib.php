<?php

/**
 * Firebase PHP Client Library
 *
 * @author Squiz Pty Ltd <products@squiz.net>
 * @url    https://github.com/ktamas77/firebase-php/
 * @link   https://www.firebase.com/docs/rest-api.html
 */

/**
 * Firebase PHP Class
 *
 * @author Tamas Kalman <ktamas77@gmail.com>
 * @link   https://www.firebase.com/docs/rest-api.html
 */
class FirebaseLib implements FirebaseInterface
{

    private $_baseURI;

    private $_timeout;

    private $_token;


    /**
     * Constructor
     *
     * @param string $baseURI
     * @param string $token
     */
    function __construct($baseURI='', $token='')
    {
        if ($baseURI == '') {
            trigger_error('You must provide a baseURI variable.', E_USER_ERROR);
        }

        if (! extension_loaded('curl')) {
            trigger_error('Extension CURL is not loaded.', E_USER_ERROR);
        }

        $this->setBaseURI($baseURI);
        $this->setTimeOut(10);
        $this->setToken($token);

    }//end __construct()


    /**
     * Sets Token
     *
     * @param string $token Token
     *
     * @return void
     */
    public function setToken($token)
    {
        $this->_token = $token;

    }//end setToken()


    /**
     * Sets Base URI, ex: http://yourcompany.firebase.com/youruser
     *
     * @param string $baseURI Base URI
     *
     * @return void
     */
    public function setBaseURI($baseURI)
    {
        $baseURI       .= ( substr($baseURI, - 1) == '/' ? '' : '/' );
        $this->_baseURI = $baseURI;

    }//end setBaseURI()


    /**
     * Returns with the normalized JSON absolute path
     *
     * @param string $path to data
     *
     * @return string
     */
    private function _getJsonPath($path)
    {
        $url  = $this->_baseURI;
        $path = ltrim($path, '/');
        $auth = ( $this->_token == '' ) ? '' : '?auth='.$this->_token;
        return $url.$path.'.json'.$auth;

    }//end _getJsonPath()


    /**
     * Sets REST call timeout in seconds
     *
     * @param integer $seconds Seconds to timeout
     *
     * @return void
     */
    public function setTimeOut($seconds)
    {
        $this->_timeout = $seconds;

    }//end setTimeOut()


    /**
     * Writing data into Firebase with a PUT request
     * HTTP 200: Ok
     *
     * @param string $path Path
     * @param mixed  $data Data
     *
     * @return array Response
     */
    public function set($path, $data)
    {
        return $this->_writeData($path, $data, 'PUT');

    }//end set()


    /**
     * Pushing data into Firebase with a POST request
     * HTTP 200: Ok
     *
     * @param string $path Path
     * @param mixed  $data Data
     *
     * @return array Response
     */
    public function push($path, $data)
    {
        return $this->_writeData($path, $data, 'POST');

    }//end push()


    /**
     * Updating data into Firebase with a PATH request
     * HTTP 200: Ok
     *
     * @param string $path Path
     * @param mixed  $data Data
     *
     * @return array Response
     */
    public function update($path, $data)
    {
        return $this->_writeData($path, $data, 'PATCH');

    }//end update()


    /**
     * Reading data from Firebase
     * HTTP 200: Ok
     *
     * @param string $path Path
     *
     * @return array Response
     */
    public function get($path)
    {
        try {
            $ch     = $this->_getCurlHandler($path, 'GET');
            $return = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            $return = null;
        }

        return $return;

    }//end get()


    /**
     * Deletes data from Firebase
     * HTTP 204: Ok
     *
     * @param type $path Path
     *
     * @return array Response
     */
    public function delete($path)
    {
        try {
            $ch     = $this->_getCurlHandler($path, 'DELETE');
            $return = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            $return = null;
        }

        return $return;

    }//end delete()


    /**
     * Returns with Initialized CURL Handler
     *
     * @param string $mode Mode
     *
     * @return CURL Curl Handler
     */
    private function _getCurlHandler($path, $mode)
    {
        $url = $this->_getJsonPath($path);
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->_timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $mode);
        return $ch;

    }//end _getCurlHandler()


    private function _writeData($path, $data, $method='PUT')
    {
        $jsonData = ( is_array($data) ) ? json_encode($data) : $data;
        // If not json, encode it
        $header = [
            'Content-Type: application/json',
            'Content-Length: '.strlen($jsonData),
        ];
        try {
            $ch = $this->_getCurlHandler($path, $method);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            $return = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            $return = null;
        }

        return $return;

    }//end _writeData()


}//end class
