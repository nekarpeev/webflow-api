<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.02.2018
 * Time: 16:26
 */

class GoogleTable {

    public function setData($spreadsheetId, $service, $DataFoGoogleTable) {

        $range = 'Лист1!A1:N';

        foreach ($DataFoGoogleTable as $row) {
            $values[] = $row;
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

    public function getData($spreadsheetId, $service, $title_array) {

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

            $arr['changed_data'] = $changed_data;
            $arr['id_item_arr'] = $id_item_arr;
            return $arr;
        }
    }

//setDataInGoogleTable($spreadsheetId, $service, $DataFoGoogleTable);
//$table_data = getDataInGoogleTable($spreadsheetId, $service, $title_array);


}