<?php


$data = file_get_contents('php://input');



 $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,'https://api.telegram.org/bot418800539:AAEL8EIbOfvIDTHbMLiib7LgJ7nk6PGFibs/sendMessage?chat_id=-246486526&text=' . var_export($data,true));
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Slurx API requester');
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);