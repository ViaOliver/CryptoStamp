<?php

    //$headers = array("TokenID", "description","name", "home_url", "shopstatusvalue", "deliverablevalue", "colorvalue");
    //Open/create the file
   // $fh = fopen("cryptostamp.csv","w");
    //Create the headers
    //fputcsv($fh, $headers);
    //fclose($fh);

    for($counter = 0; $counter <= 149999; $counter++) {
        //sleep(1);

        //URL to send the request to
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://crypto.post.at/CS1/meta/'.$counter);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //Execute the request and fetch the response.Reset cURL. Check for Errors
        $output = curl_exec($ch);

        curl_reset($ch);
        $ch = curl_close($ch);

        if($output === FALSE){
            echo "cURL ERROR: ".curl_error($ch);
        }


        $jsondata = json_decode($output, true);

        /*print_r($jsondata);
        print_r($counter);
        print_r($jsondata['description']);
        print_r($jsondata['home_url']);
        print_r($jsondata['name']);
        print_r($jsondata['properties'][0]['value']);
        print_r($jsondata['properties'][1]['value']);
        print_r($jsondata['properties'][2]['value']);*/

        echo $counter;
        echo ",";



        $data = array(
            "TokenID" => $counter,
            "description" => $jsondata['description'],
            "name" => $jsondata['name'],
            "home_url" => $jsondata['home_url'],
            "shopstatusvalue" => $jsondata['properties'][0]['value'],
            "deliverablevalue" => $jsondata['properties'][1]['value'],
            "colorvalue" =>  $jsondata['properties'][2]['value'],
        );


        $fh = fopen("cryptostamp.csv","a");
        fputcsv($fh, $data,",",'"');
        fclose($fh);
    }
?>
