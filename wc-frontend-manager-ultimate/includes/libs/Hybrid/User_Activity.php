<?php
/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2014, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */

/**
 * Hybrid_User_Activity
 *
 * used to provider the connected user activity stream on a standardized structure across supported social apis.
 *
 * http://hybridauth.sourceforge.net/userguide/Profile_Data_User_Activity.html
 */
class Hybrid_User_Activity
{

    /**
     * activity id on the provider side, usually given as integer
     *
     * @var Numeric/String
     */
    public $id = null;

    /**
     * activity date of creation
     *
     * @var timestamp
     */
    public $date = null;

    /**
     * activity content as a string
     *
     * @var string
     */
    public $text = null;

    /**
     * user who created the activity
     *
     * @var object
     */
    public $user = null;


    /**
     * Constructor
     */
    public function __construct()
    {
         $this->user = new stdClass();

        // typically, we should have a few information about the user who created the event from social apis
        $this->user->identifier  = null;
        $this->user->displayName = null;
        $this->user->profileURL  = null;
        $this->user->photoURL    = null;

    }//end __construct()


}//end class
