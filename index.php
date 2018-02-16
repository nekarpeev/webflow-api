<?php
//$site_id = '5a7f1b31d2e04c0001f454a3';
//$ch = curl_init('https://api.webflow.com/info');
//$ch = curl_init('https://api.webflow.com/sites/5a7f1b31d2e04c0001f454a3/collections');
//$ch = curl_init('https://api.webflow.com/collections/5a7f1b73d2e04c0001f4553b/items?limit=1');
//sites/:site_id/collections

define('ROOT', dirname(__FILE__));


include_once(ROOT . '/components/Autoload.php');

$collections_object = new Collection();
$collections = $collections_object->getCollection();
$collection_name = $collections->name;

$items_object = new Item();
$items = $items_object->getItems();
$valid_name_array = $items_object->getValidNames($collections);

$items_array = $items->items;
$fields_array = [];

$DataFoGoogleTable = ProcessorData::actionPrepareData($items_array, $valid_name_array, $collection_name);
$title_array = $DataFoGoogleTable[0];

$google_table_object = new GoogleTable();

require_once 'api_config.php';

$google_table_object->setData($spreadsheetId, $service, $DataFoGoogleTable);

$getData = $google_table_object->getData($spreadsheetId, $service, $title_array);

//print_r($getData);

$updateItem = new WebFlow();
$updateItem->updateItem($getData);









