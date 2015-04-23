<?php

/*
 * Collect Pins from Pinterest
 * Copyright (C) Guru
 * http://www.jafaloo.com
 */

class myPinterestBadge {

    // Pinterest Base URL
    public $pinterest_url = 'http://www.pinterest.com';
    public $cache_time = 5400; // 1.5*60*60;
    // set a plausible user agent
    public $user_agent = 'Mozilla/5.0 (X11; Linux x86_64; rv:5.0) Gecko/20100101 Firefox/5.0';
    private $pinurl;
    private $userId;
    private $pinsize;
    private $pincounts;
    private $devcredit;
    private $cache_directory;
    private $cacheFile;
    private $pins;
    private $pinboard = '';
    private $pinboard_url = '';
    private $pinit_button = '';

    // constructor

    function __construct($pinid = '', $pinsize = '', $pincounts = '', $devcredit = '', $pinboard = '', $cache_time = '') {
        if (!empty($pinid)) {
            // Build The Pin URL for the user
            $this->pinurl = $this->pinterest_url . '/' . trim($pinid) . '/feed.rss';
            $this->userId = trim($pinid);
            $this->pinsize = $pinsize;
            $this->pincounts = $pincounts;
            $this->devcredit = $devcredit;
            $this->cache_directory = WP_CONTENT_DIR . "/cache";
            $this->cacheFile = WP_CONTENT_DIR . "/cache/my-pinterest-badge.cache";
            $this->pinboard = trim($pinboard);
            $this->pinboard_url = $this->pinterest_url . '/' . $pinid . '/' . trim($pinboard) . '/rss';
            if (!empty($cache_time)) {
                $this->cache_time = $cache_time * 60 * 60;
            }
            $this->pinit_button = plugins_url() . '/my-pinterest-badge/css/pinit.png';
        }
    }

    protected function myPinterestBadge() {
        # don't forget the library - The main html parser library.
        include('simple_html_dom.php');
        $strdata = $this->getCurlData($this->pinurl);

        //Check for any Errors
        if ($strdata == 'Error') {
            return 'Error';
        }
        if ($strdata == '404') {
            return '404';
        }

        //Check if Pin board is mentioned
        if (!empty($this->pinboard)) {
            $strdata_from_pinboard = $this->getCurlData($this->pinboard_url);
            if ($strdata_from_pinboard == 'Error') {
                return 'Error';
            }
            if ($strdata_from_pinboard == '404') {
                return 'invalid_pinboard';
            }
            $html_pinboard_temp = html_entity_decode($strdata_from_pinboard);
            $html_pinboard = str_get_html($html_pinboard_temp);
        }
        $temphtml = html_entity_decode($strdata);
        $html = str_get_html($temphtml);
        if (!empty($this->pinboard)) {
            $items = $html_pinboard->find('a');
        } else {
            $items = $html->find('a');
        }

//        $acntdetails = $html->find('ul[class=links]');
//        $follow = $html->find('ul[class=follow]');
//        //Set Account details like #Followers, #pins, #boards etc.
//        foreach ($acntdetails as $acnt) {
//            $this->numberOfBoards = $acnt->children(0)->children(0)->children(0)->innertext; //Set no of boards
//            $this->numberOfPins = $acnt->children(1)->children(0)->children(0)->innertext; //Set no of Pins
//            $this->numberOfLikes = $acnt->children(2)->children(0)->children(0)->innertext; //Set no of Likes                        
//        }
//        foreach ($follow as $follower) {
//            $this->numberOfFollower = $follower->children(0)->children(0)->children(0)->innertext; //Set no of followers
//            $this->following = $follower->children(1)->children(0)->children(0)->innertext; //Set following                                   
//        }

        foreach ($items as $post) {
            $url = $post->href;
            $img_src = $post->children(0)->src;
            //Form the pins array
            $this->pins[] = array("pin_url" => $this->pinterest_url . $url, "img_url" => $img_src);
        }
    }

    //For the html data for the cache
    protected function formCacheData() {

        $widget_html = '';
        $count = 0;
        $imgclass = 'pins-small';
        $showcredit = 'none';
        if ($this->devcredit === true) {
            $showcredit = 'block';
        }
        if (empty($this->pincounts)) {
            $this->pincounts = 9;
        }
        if (empty($this->userId)) {
            $widget_html = $widget_html . '<div style="margin:8px;">Please Provide a valid pinterest id.</div>';
        } else {
            $call_response = $this->myPinterestBadge();
            if ($call_response == 'Error') {
                return 'There was error in connecting to your Pinterest account. Either Pinterest.com is down or you have an error in widget configuration.';
            }
            if ($call_response == '404') {
                return 'Please Enter correct Pinterest UserId. The entered ID is incorrect';
            }
            if ($call_response == 'invalid_pinboard') {
                return 'Please Enter Valid Pinboard URL Name in the widget configuration';
            }
            if ($this->pinsize === 'small') {
                $imgclass = 'pins-small';
            } else if ($this->pinsize === 'mid') {
                $imgclass = 'pins-mid';
            } else if ($this->pinsize === 'big') {
                $imgclass = 'pins-big';
            }

            $widget_html = $widget_html . '<div class="topwrapper">';
            $widget_html = $widget_html . '<div class="middlewrapper">';
            $widget_html = $widget_html . '<div class="bottomwrapper">';
            //$widget_html = $widget_html . '<div style="clear: both;">';
            //$widget_html = $widget_html . 'Followed by: <b>' . $this->numberOfFollower . '</b> people, Likes: <b>' . $this->numberOfLikes . '</b></div>';
            $widget_html = $widget_html . '<div style="clear:both"><a href="http://pinterest.com/' . $this->userId . '" target="_blank"><img src="http://passets-lt.pinterest.com/images/about/buttons/follow-me-on-pinterest-button.png" width="150" height="28" alt="Follow Me on Pinterest" /></a>';
            $widget_html = $widget_html . '&nbsp;<a href="javascript:mypinterestpinit();"><img src="'.$this->pinit_button.'" width="" height="28"></a></div>';
            $widget_html = $widget_html . '<div class="pinwidget"><div class="myimgs"><!-- Pinterest Recent Widget By Jafaloo.com -->';
            foreach ($this->pins as $data) {
                if ($count > (intval($this->pincounts) - 1))
                    break;
                $widget_html = $widget_html . '<a href="' . $data["pin_url"] . '" target="_blank">';
                $widget_html = $widget_html . '<img src="' . $data["img_url"] . '" class="' . $imgclass . '"></a>';
                $count++;
            }
            $widget_html = $widget_html . '</div></div>';
            $widget_html = $widget_html . '<div style="clear: both; display:' . $showcredit . ' ">';
            $widget_html = $widget_html . 'My Pinterest Badge by: <a href="http://www.jafaloo.com">Jafaloo</a>. For Support visit: <a href="http://www.protechblog.com/tools/my-pinterest-badge.php">My Pinterest Badge</a></div>';
            $widget_html = $widget_html . '</div></div></div>';
        }

        return $widget_html;
    }

    //Write the data to the cache file
    protected function writeToCache($data) {

        //Create cache directory if it does not exist
        if (!file_exists($this->cache_directory)) {
            mkdir($this->cache_directory);
        }

        $file = $this->cacheFile;
        // open the file
        $handle = fopen($file, 'w') or die("Please check write access permission on wp-contet directory.");
        // write data to file
        fwrite($handle, $data);
        // close file
        fclose($handle);
    }

    //Read the cache data and return the string of html data
    public function readCacheData() {
        if (!empty($this->userId)) {

            //First check if cache is valid
            if (!$this->isValidCache()) {
                $this->initializeCache();
            }

            $file = $this->cacheFile;
            //open cached file in read mode..
            $handle = fopen($file, "r") or die("Please check write access permission on wp-contet directory.");
            //read it
            $pinsdata = fgets($handle);
            //close it
            fclose($handle);
            return $pinsdata;
        } else {
            return 'Please provide a valid pinterest id';
        }
    }

    //Check if the cache is still valid and return true or false
    protected function isValidCache() {
        if (!file_exists($this->cacheFile)) {
            return false;
        } else if ((time() - filemtime($this->cacheFile)) > $this->cache_time) {
            return false;
        } else {
            return true;
        }
    }

    //Initialize Cache for the first time.. 
    //This should be called everytime the settings are saved.
    public function initializeCache() {

        if (!empty($this->userId)) {
            $data = $this->formCacheData();
            $this->writeToCache($data);
        }
    }

    //Curl Data (Use wp_remote_get to get remote data)
    protected function getCurlData($url) {

        if (!empty($url)) {
            $remotedata = wp_remote_get($url);
            if (is_wp_error($remotedata)) {
                return 'Error';
            }
            if (wp_remote_retrieve_response_code($remotedata) == 404) {
                return '404';
            }
            $curldata = wp_remote_retrieve_body($remotedata);
        } else {
            $curldata = 'Error';
        }

        return $curldata;
    }

}

?>
