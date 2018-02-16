<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.02.2018
 * Time: 12:06
 */

class Collection extends Base {

    public function getCollection() {
        $ch = curl_init('https://api.webflow.com/collections/5a7f1b73d2e04c0001f4553b');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $this->token,
                'accept-version: 1.0.0')
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $collections = curl_exec($ch);
        curl_close($ch);

        echo '<hr>';
        echo 'getCollection:';
        echo '<br>';
        //print_r($collections);

        return json_decode($collections);
    }
}