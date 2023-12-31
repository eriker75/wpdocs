<?php

if (! defined('ABSPATH')) {
    exit;
    // Exit if accessed directly
}

class FBC_User
{

    private $agent;

    private $info = [];


    function __construct()
    {
        $this->agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
        $this->get_browser();
        $this->get_OS();

    }//end __construct()


    /**
     * Get browser info
     *
     * @return string
     */
    function get_browser()
    {
        $browser = [
            'Navigator'         => '/Navigator(.*)/i',
            'Firefox'           => '/Firefox(.*)/i',
            'Internet Explorer' => '/MSIE(.*)/i',
            'Chrome'            => '/chrome(.*)/i',
            'MAXTHON'           => '/MAXTHON(.*)/i',
            'Opera'             => '/Opera(.*)/i',
        ];

        // Find browser
        foreach ($browser as $key => $value) {
            if (preg_match($value, $this->agent)) {
                $this->info = array_merge($this->info, [ 'Browser' => $key ]);
                $this->info = array_merge($this->info, [ 'Version' => $this->get_version($key, $value, $this->agent) ]);
                break;
            } else {
                $this->info = array_merge($this->info, [ 'Browser' => 'N/A' ]);
                $this->info = array_merge($this->info, [ 'Version' => 'N/A' ]);
            }
        }

        return $this->info['Browser'];

    }//end get_browser()


    /**
     * Get OS info
     *
     * @return string
     */
    function get_OS()
    {
        $this->info['OS'] = 'N/A';

        $OS = [

            '/windows nt 6.2/i'     => 'Windows 8',
            '/windows nt 6.1/i'     => 'Windows 7',
            '/windows nt 6.0/i'     => 'Windows Vista',
            '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     => 'Windows XP',
            '/windows xp/i'         => 'Windows XP',
            '/windows nt 5.0/i'     => 'Windows 2000',
            '/windows me/i'         => 'Windows ME',
            '/win98/i'              => 'Windows 98',
            '/win95/i'              => 'Windows 95',
            '/win16/i'              => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i'        => 'Mac OS 9',
            '/linux/i'              => 'Linux',
            '/ubuntu/i'             => 'Ubuntu',
            '/iphone/i'             => 'iPhone',
            '/ipod/i'               => 'iPod',
            '/ipad/i'               => 'iPad',
            '/android/i'            => 'Android',
            '/blackberry/i'         => 'BlackBerry',
            '/webos/i'              => 'Mobile',

        ];

        foreach ($OS as $regex => $v) {
            if (preg_match($regex, $this->agent) && $this->info['OS'] == 'N/A') {
                $this->info['OS'] = $v;
            }
        }

        return $this->info['OS'];

    }//end get_OS()


    /**
     * Get version
     *
     * @return string
     */
    function get_version($browser, $search, $string)
    {
        $browser = $this->info['Browser'];
        $version = '';
        $browser = strtolower($browser);
        preg_match_all($search, $string, $match);

        switch ($browser) {
            case 'firefox':
                $version = str_replace('/', '', $match[1][0]);
                break;

            case 'internet explorer':
                $version = substr($match[1][0], 0, 4);
                break;

            case 'opera':
                $version = str_replace('/', '', substr($match[1][0], 0, 5));
                break;

            case 'navigator':
                $version = substr($match[1][0], 1, 7);
                break;

            case 'maxthon':
                $version = str_replace(')', '', $match[1][0]);
                break;

            case 'chrome':
                $version = substr($match[1][0], 1, 10);
        }//end switch

        return $version;

    }//end get_version()


    /**
     * Show user info
     *
     * @return mixed
     */
    function info($switch)
    {
        $switch = strtolower($switch);

        switch ($switch) {
            case 'browser':
                return $this->info['Browser'];

                break;

            case 'os':
                return $this->info['OS'];

                break;

            case 'version':
                return $this->info['Version'];

                break;

            case 'all':
                return [
                $this->info['Version'],
                $this->info['OS'],
                $this->info['Browser'],
            ];

                break;

            default:
                return 'N/A';
                break;
        }//end switch

    }//end info()


}//end class
