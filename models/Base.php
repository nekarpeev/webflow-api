<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.02.2018
 * Time: 12:04
 */

class Base {
    public $token = '75c7ce700ce1821e33f2fb42eb567bc32d0676d460701777a8257ad2ebc39240';

    public function __construct() {
        //authorization

        $ch = curl_init('https://api.webflow.com/info');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $this->token,
                'accept-version: 1.0.0')
        );
        //echo 'authorization:';
        //echo '<hr>';
        $html = curl_exec($ch);
        curl_close($ch);
    }
}