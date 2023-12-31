<?php
/*
    !
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */

/**
 * Yahoo OAuth Class
 *
 * @package HybridAuth providers package
 * @author  Lukasz Koprowski <azram19@gmail.com>
 * @version 0.2
 * @license BSD License
 */

/**
 * Hybrid_Providers_Yahoo - Yahoo provider adapter based on OAuth1 protocol
 */
class Hybrid_Providers_Yahoo extends Hybrid_Provider_Model_OAuth1
{


    function initialize()
    {
         parent::initialize();

        // Provider api end-points
        $this->api->api_base_url      = 'https://social.yahooapis.com/v1/';
        $this->api->authorize_url     = 'https://api.login.yahoo.com/oauth/v2/request_auth';
        $this->api->request_token_url = 'https://api.login.yahoo.com/oauth/v2/get_request_token';
        $this->api->access_token_url  = 'https://api.login.yahoo.com/oauth/v2/get_token';

    }//end initialize()


    function getUserProfile()
    {
         $userId = $this->getCurrentUserId();

        $parameters           = [];
        $parameters['format'] = 'json';

        $response = $this->api->get('user/'.$userId.'/profile', $parameters);

        if (! isset($response->profile)) {
            throw new Exception("User profile request failed! {$this->providerId} returned an invalid response.", 6);
        }

        $data = $response->profile;

        $this->user->profile->identifier  = ( property_exists($data, 'guid') ) ? $data->guid : '';
        $this->user->profile->firstName   = ( property_exists($data, 'givenName') ) ? $data->givenName : '';
        $this->user->profile->lastName    = ( property_exists($data, 'familyName') ) ? $data->familyName : '';
        $this->user->profile->displayName = ( property_exists($data, 'nickname') ) ? trim($data->nickname) : '';
        $this->user->profile->profileURL  = ( property_exists($data, 'profileUrl') ) ? $data->profileUrl : '';
        $this->user->profile->gender      = ( property_exists($data, 'gender') ) ? $data->gender : '';

        if ($this->user->profile->gender == 'F') {
            $this->user->profile->gender = 'female';
        }

        if ($this->user->profile->gender == 'M') {
            $this->user->profile->gender = 'male';
        }

        if (isset($data->emails)) {
            $email = '';
            foreach ($data->emails as $v) {
                if (isset($v->primary) && $v->primary) {
                    $email = ( property_exists($v, 'handle') ) ? $v->handle : '';

                    break;
                }
            }

            $this->user->profile->email         = $email;
            $this->user->profile->emailVerified = $email;
        }

        $this->user->profile->age      = ( property_exists($data, 'displayAge') ) ? $data->displayAge : '';
        $this->user->profile->photoURL = ( property_exists($data, 'image') ) ? $data->image->imageUrl : '';

        $this->user->profile->address  = ( property_exists($data, 'location') ) ? $data->location : '';
        $this->user->profile->language = ( property_exists($data, 'lang') ) ? $data->lang : '';

        return $this->user->profile;

    }//end getUserProfile()


    /**
     * load the user contacts
     */
    function getUserContacts()
    {
        $userId = $this->getCurrentUserId();

        $parameters           = [];
        $parameters['format'] = 'json';
        $parameters['count']  = 'max';

        $response = $this->api->get('user/'.$userId.'/contacts', $parameters);

        if ($this->api->http_code != 200) {
            throw new Exception('User contacts request failed! '.$this->providerId.' returned an error: '.$this->errorMessageByStatus($this->api->http_code));
        }

        if (! isset($response->contacts) || ! isset($response->contacts->contact) || ( isset($response->errcode) && $response->errcode != 0 )) {
            return [];
        }

        $contacts = [];

        foreach ($response->contacts->contact as $item) {
            $uc = new Hybrid_User_Contact();

            $uc->identifier  = $this->selectGUID($item);
            $uc->email       = $this->selectEmail($item->fields);
            $uc->displayName = $this->selectName($item->fields);
            $uc->photoURL    = $this->selectPhoto($item->fields);

            $contacts[] = $uc;
        }

        return $contacts;

    }//end getUserContacts()


    /**
     * return the user activity stream
     */
    function getUserActivity($stream)
    {
        $userId = $this->getCurrentUserId();

        $parameters           = [];
        $parameters['format'] = 'json';
        $parameters['count']  = 'max';

        $response = $this->api->get('user/'.$userId.'/updates', $parameters);

        if (! $response->updates || $this->api->http_code != 200) {
            throw new Exception('User activity request failed! '.$this->providerId.' returned an error: '.$this->errorMessageByStatus($this->api->http_code));
        }

        $activities = [];

        foreach ($response->updates as $item) {
            $ua = new Hybrid_User_Activity();

            $ua->id   = ( property_exists($item, 'collectionID') ) ? $item->collectionID : '';
            $ua->date = ( property_exists($item, 'lastUpdated') ) ? $item->lastUpdated : '';
            $ua->text = ( property_exists($item, 'loc_longForm') ) ? $item->loc_longForm : '';

            $ua->user->identifier  = ( property_exists($item, 'profile_guid') ) ? $item->profile_guid : '';
            $ua->user->displayName = ( property_exists($item, 'profile_nickname') ) ? $item->profile_nickname : '';
            $ua->user->profileURL  = ( property_exists($item, 'profile_profileUrl') ) ? $item->profile_profileUrl : '';
            $ua->user->photoURL    = ( property_exists($item, 'profile_displayImage') ) ? $item->profile_displayImage : '';

            $activities[] = $ua;
        }

        if ($stream == 'me') {
            $userId        = $this->getCurrentUserId();
            $my_activities = [];

            foreach ($activities as $a) {
                if ($a->user->identifier == $userId) {
                    $my_activities[] = $a;
                }
            }

            return $my_activities;
        }

        return $activities;

    }//end getUserActivity()


    // --
    function select($vs, $t)
    {
        foreach ($vs as $v) {
            if ($v->type == $t) {
                return $v;
            }
        }

        return null;

    }//end select()


    function selectGUID($v)
    {
         return ( property_exists($v, 'id') ) ? $v->id : '';

    }//end selectGUID()


    function selectName($v)
    {
         $s = $this->select($v, 'name');

        if (! $s) {
            $s = $this->select($v, 'nickname');
            return ( $s ) ? $s->value : '';
        } else {
            return ( $s ) ? $s->value->givenName.' '.$s->value->familyName : '';
        }

    }//end selectName()


    function selectNickame($v)
    {
        $s = $this->select($v, 'nickname');
        return ( $s ) ? $s : '';

    }//end selectNickame()


    function selectPhoto($v)
    {
        $s = $this->select($v, 'guid');
        return ( $s ) ? ( property_exists($s, 'image') ) : '';

    }//end selectPhoto()


    function selectEmail($v)
    {
        $s = $this->select($v, 'email');
        if (empty($s)) {
            $s = $this->select($v, 'yahooid');
            if (! empty($s) && isset($s->value) && strpos($s->value, '@') === false) {
                $s->value .= '@yahoo.com';
            }
        }

        return ( $s ) ? $s->value : '';

    }//end selectEmail()


    public function getCurrentUserId()
    {
        $parameters           = [];
        $parameters['format'] = 'json';

        $response = $this->api->get('me/guid', $parameters);

        if (! isset($response->guid->value)) {
            throw new Exception("User id request failed! {$this->providerId} returned an invalid response.");
        }

        return $response->guid->value;

    }//end getCurrentUserId()


}//end class
