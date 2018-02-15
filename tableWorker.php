<?php

function setDataInGoogleTable($spreadsheetId, $service, $DataFoGoogleTable) {

    $range = 'Лист1!A1:N';

    foreach ($result as $res) {
        $values[] = $res;
    }

    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);
    $params = [
        'valueInputOption' => 'RAW'
    ];
    $result = $service->spreadsheets_values->update($spreadsheetId, $range,
        $body, $params);
    printf("%d cells updated.", $result->getUpdatedCells());

}

function getDataInGoogleTable($spreadsheetId, $service, $title_array) {

    $range = 'Лист1!A2:N';

    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    $changed_data = [];
    if (count($values) == 0) {
        print "No data found\n";
    } else {

        $new_arr = [];
        $id_item_arr = [];

        foreach ($values as $val) {
            $count = count($val) - 1;
            $id_item_arr[] = $val[1];
            $new_arr['_archived'] = false;
            $new_arr['_archived'] = false;
            $new_arr['_draft'] = false;

            for ($i = 5; $i <= $count; $i++) {
                $new_arr[$title_array[$i]] = $val[$i];
            }
            $changed_data[] = $new_arr;
        }

        echo '<pre>';
        print_r($changed_data);
        echo '</pre>';
        $arr['changed_data'] = $changed_data;
        $arr['id_item_arr'] = $id_item_arr;
        return $arr;
    }
}

//setDataInGoogleTable($spreadsheetId, $service, $DataFoGoogleTable);
$table_data = getDataInGoogleTable($spreadsheetId, $service, $title_array);

function updateItemInWebflow($token, $table_data) {

    $i = 0;
    $tab_data = $table_data['changed_data'];
    $id_item_arr = $table_data['id_item_arr'];

    foreach ($tab_data as $data) {

        $arr = array('fields' => $data);
        $arr = json_encode($arr);
        //print_r($arr);

        $ch = curl_init('https://api.webflow.com/collections/5a7f1b73d2e04c0001f4553b/items/' . $id_item_arr[$i]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $token,
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

//updateItemInWebflow($token, $table_data);