<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.02.2018
 * Time: 12:18
 */


class Item extends Base {

    const LIMIT = 10;

    public function getItems($limit = self::LIMIT) {

        $ch = curl_init('https://api.webflow.com/collections/5a7f1b73d2e04c0001f4553b/items?limit='. $limit);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $this->token,
                'accept-version: 1.0.0')
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $items = curl_exec($ch);
        curl_close($ch);

        echo '<hr>';
        echo 'getItems:';
        echo '<br>';
        //print_r($items);

        return json_decode($items);
    }

    public static function getValidNames($collections) {

        foreach ($collections as $items) {

            if (is_array($items)) {
                $valid_name_array = self::inspector($items);
            }
        }

        return $valid_name_array;
    }

    public static function inspector($items) {
        $array = [];
        foreach ($items as $item) {

            if ($item->type === 'ImageRef' || $item->type === 'PlainText' || $item->type === 'RichText') {
                $array[] = strtolower($item->name);
            }
        }
        return $array;
    }
}