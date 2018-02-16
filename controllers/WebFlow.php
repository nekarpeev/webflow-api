<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.02.2018
 * Time: 17:06
 */

class WebFlow extends Base {

    public function updateItem($getData) {

        $i = 0;
        $tab_data = $getData['changed_data'];
        $id_item_arr = $getData['id_item_arr'];

        foreach ($tab_data as $data) {

            $arr = array('fields' => $data);
            $arr = json_encode($arr);
            //print_r($arr);

            $ch = curl_init('https://api.webflow.com/collections/5a7f1b73d2e04c0001f4553b/items/' . $id_item_arr[$i]);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer ' . $this->token,
                    'accept-version: 1.0.0',
                    'Content-Type: application/json'
                )
            );
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
            $html = curl_exec($ch);
            curl_close($ch);

            $i++;
        }
    }
}