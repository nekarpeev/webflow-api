<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.02.2018
 * Time: 16:30
 */

class ProcessorData {

    public static function actionPrepareData($items_array, $valid_name_array, $collection_name) {

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
}