<?php
    //open the file CryptoStamp.csv and create a logchange file
    $fh = fopen('cryptostamptest.csv','r');
    $fh2 = fopen('logchange.csv','w');
    $headerS = array('Tokenid','csvcolor','changecolor');
    fputcsv($fh2, $headerS);
    fclose($fh2);


    while (($csv = fgetcsv ($fh)) !== FALSE ) {
        //csv[0] all tokenid numbers and $csv[6] all color value
         $data[] = array($csv[0],$csv[6]);

    }

    $max = sizeof($data); // to the end of the array
    for($counter=1;$counter<$max;$counter++){

        //$data[$counter][0] = TokenID
        //$data[$counter][1] = colorvalue
        ////URL to send the request to
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://crypto.post.at/CS1/meta/'.$data[$counter][0]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //Execute the request and fetch the response. Reset cURL. Check for Errors
        $output = curl_exec($ch);
        curl_reset($ch);
        $ch = curl_close($ch);

        if($output === FALSE){
            echo "cURL ERROR: ".curl_error($ch);
        }
        $jsondecode = json_decode($output, true);

        if ($data[$counter][1]==$jsondecode['properties'][2]['value']){
            print_r($data[$counter][0].',');

        }else {
            $fh2=fopen('logchange.csv', 'a');
            $csvwrite = array($data[$counter][0],$data[$counter][1],$jsondecode['properties'][2]['value']);
            fputcsv($fh2, $csvwrite,",",'"');
            fclose($fh2);
        }

    }

fclose($fh);


?>