<?php 

    $api_key = "5f0b554d60ea4341b26164613221405";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,
    "http://api.weatherapi.com/v1/current.json?key=".$api_key."&q=Catania&aqi=no&lang=it");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);

    echo $result
?>