<?php
/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2014, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */

/**
 * Debugging and Logging manager
 */
class Hybrid_Logger
{


    /**
     * Constructor
     */
    function __construct()
    {
        // if debug mode is set to true, then check for the writable log file
        if (Hybrid_Auth::$config['debug_mode']) {
            if (! isset(Hybrid_Auth::$config['debug_file'])) {
                throw new Exception("'debug_mode' is set to 'true' but no log file path 'debug_file' is set.", 1);
            } else if (! file_exists(Hybrid_Auth::$config['debug_file']) && ! is_writable(Hybrid_Auth::$config['debug_file'])) {
                if (! touch(Hybrid_Auth::$config['debug_file'])) {
                        throw new Exception("'debug_mode' is set to 'true', but the file ".Hybrid_Auth::$config['debug_file']." in 'debug_file' can not be created.", 1);
                }
            } else if (! is_writable(Hybrid_Auth::$config['debug_file'])) {
                throw new Exception("'debug_mode' is set to 'true', but the given log file path 'debug_file' is not a writable file.", 1);
            }
        }

    }//end __construct()


    /**
     * Debug
     *
     * @param string $message
     * @param object $object
     */
    public static function debug($message, $object=null)
    {
        if (Hybrid_Auth::$config['debug_mode']) {
            $datetime = new DateTime();
            $datetime = $datetime->format(DATE_ATOM);

            file_put_contents(
                Hybrid_Auth::$config['debug_file'],
                'DEBUG -- '.$_SERVER['REMOTE_ADDR'].' -- '.$datetime.' -- '.$message.' -- '.print_r($object, true)."\n",
                FILE_APPEND
            );
        }

    }//end debug()


    /**
     * Info
     *
     * @param string $message
     */
    public static function info($message)
    {
        if (in_array(Hybrid_Auth::$config['debug_mode'], [ true, 'info' ], true)) {
            $datetime = new DateTime();
            $datetime = $datetime->format(DATE_ATOM);

            file_put_contents(
                Hybrid_Auth::$config['debug_file'],
                'INFO -- '.$_SERVER['REMOTE_ADDR'].' -- '.$datetime.' -- '.$message."\n",
                FILE_APPEND
            );
        }

    }//end info()


    /**
     * Error
     *
     * @param string $message Error message
     * @param object $object
     */
    public static function error($message, $object=null)
    {
        if (isset(Hybrid_Auth::$config['debug_mode']) && in_array(Hybrid_Auth::$config['debug_mode'], [ true, 'info', 'error' ], true)) {
            $datetime = new DateTime();
            $datetime = $datetime->format(DATE_ATOM);

            file_put_contents(
                Hybrid_Auth::$config['debug_file'],
                'ERROR -- '.$_SERVER['REMOTE_ADDR'].' -- '.$datetime.' -- '.$message.' -- '.print_r($object, true)."\n",
                FILE_APPEND
            );
        }

    }//end error()


}//end class
