<?php

$token = 'e63a3c313ae2aa15713bc12600c5c95bc5a3b2b59a9ca3724fdf25bdd2e24db7';

function authorization($token) {
    $ch = curl_init('https://api.webflow.com/info');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token,
            'accept-version: 1.0.0')
    );
    $html = curl_exec($ch);
    curl_close($ch);

    return json_decode($html);
}

//authorization($token);

function getCollection($token) {
    $ch = curl_init('https://api.webflow.com/collections/5a7f1b73d2e04c0001f4553b');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token,
            'accept-version: 1.0.0')
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($ch);
    curl_close($ch);

    return json_decode($html);
}

function getItems($token) {
    $ch = curl_init('https://api.webflow.com/collections/5a7f1b73d2e04c0001f4553b/items?limit=4');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token,
            'accept-version: 1.0.0')
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($ch);
    curl_close($ch);

    return json_decode($html);
}

$collection = getCollection($token);
$collection_name = $collection->name;

function getValidNames($collection) {
    foreach ($collection as $items) {

        if (is_array($items)) {
            $valid_name_array = inspector($items);
        }
    }

    return $valid_name_array;
}

$valid_name_array = getValidNames($collection);

function inspector($items) {
    $array = [];
    foreach ($items as $item) {

        if ($item->type === 'ImageRef' || $item->type === 'PlainText' || $item->type === 'RichText') {
            $array[] = strtolower($item->name);
        }
    }
    return $array;
}

$items = getItems($token);

$items_array = $items->items;
$fields_array = [];
$title_array = [];

function getDataFoGoogleTable($items_array, $valid_name_array, $collection_name) {

    foreach ($items_array as $item) {
        $field = [];
        $title_array = array('Collections', 'Item_id', 'Item_name');
        $field[] = $collection_name;
        $field[] = $item->_id;
        $field[] = $item->name;

        foreach ($valid_name_array as $name) {

            if ($name === 'igm') {
                $igm = $item->igm;
                $title_array[] = 'fileId';
                $field[] = $igm->fileId;
                $title_array[] = 'url';
                $field[] = $igm->url;
            } else {
                $title_array[] = $name;
                $field[] = $item->$name;
            }
        }
        $result[] = $field;
    }

    $result[] = $title_array;
    $DataFoGoogleTable = array_reverse($result);
    return $DataFoGoogleTable;
}

getDataFoGoogleTable($items_array, $valid_name_array, $collection_name);



/*
echo '<pre>';
print_r( $valid_name_array );
echo '</pre><hr>';
*/