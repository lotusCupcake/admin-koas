<?php

function getLokasi($latlong = '')
{
    $position = explode(",", $latlong);
    $lat = $position[0];
    $long = $position[1];

    $client = \Config\Services::curlrequest();

    $response = $client->request("GET", "https://api.geoapify.com/v1/geocode/reverse?lat=" . $lat . "&lon=" . $long . "&apiKey=f50d1bba003041789e5b7cfeb1eb9c6c", [
        "headers" => [
            "Accept" => "application/json"
        ],
    ]);
    // dd(json_decode($response->getBody())->features[0]->properties->formatted);
    return json_decode($response->getBody())->features[0]->properties->formatted;
}
