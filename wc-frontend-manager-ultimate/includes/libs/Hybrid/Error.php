<?php
/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2014, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */

/**
 * Errors manager
 *
 * HybridAuth errors are stored in Hybrid::storage() and not displayed directly to the end user
 */
class Hybrid_Error
{


    /**
     * Store error in session
     *
     * @param string $message
     * @param Number $code
     * @param string $trace
     * @param string $previous
     */
    public static function setError($message, $code=null, $trace=null, $previous=null)
    {
        Hybrid_Logger::info("Enter Hybrid_Error::setError( $message )");

        Hybrid_Auth::storage()->set('hauth_session.error.status', 1);
        Hybrid_Auth::storage()->set('hauth_session.error.message', $message);
        Hybrid_Auth::storage()->set('hauth_session.error.code', $code);
        Hybrid_Auth::storage()->set('hauth_session.error.trace', $trace);
        Hybrid_Auth::storage()->set('hauth_session.error.previous', $previous);

    }//end setError()


    /**
     * Clear the last error
     */
    public static function clearError()
    {
        Hybrid_Logger::info('Enter Hybrid_Error::clearError()');

        Hybrid_Auth::storage()->delete('hauth_session.error.status');
        Hybrid_Auth::storage()->delete('hauth_session.error.message');
        Hybrid_Auth::storage()->delete('hauth_session.error.code');
        Hybrid_Auth::storage()->delete('hauth_session.error.trace');
        Hybrid_Auth::storage()->delete('hauth_session.error.previous');

    }//end clearError()


    /**
     * Checks to see if there is a an error.
     *
     * @return boolean True if there is an error.
     */
    public static function hasError()
    {
         return (bool) Hybrid_Auth::storage()->get('hauth_session.error.status');

    }//end hasError()


    /**
     * return error message
     */
    public static function getErrorMessage()
    {
        return Hybrid_Auth::storage()->get('hauth_session.error.message');

    }//end getErrorMessage()


    /**
     * return error code
     */
    public static function getErrorCode()
    {
         return Hybrid_Auth::storage()->get('hauth_session.error.code');

    }//end getErrorCode()


    /**
     * return string detailed error backtrace as string.
     */
    public static function getErrorTrace()
    {
        return Hybrid_Auth::storage()->get('hauth_session.error.trace');

    }//end getErrorTrace()


    /**
     * @return string detailed error backtrace as string.
     */
    public static function getErrorPrevious()
    {
         return Hybrid_Auth::storage()->get('hauth_session.error.previous');

    }//end getErrorPrevious()


}//end class
