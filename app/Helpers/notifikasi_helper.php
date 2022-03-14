<?php

function initNotification($message = '', $user = '', $title = '')
{
    $content = array("en" => $message);
    $headings = array("en" => $title);
    $hashes_array = array();

    $fields = array(
        'app_id' => "43946382-87c5-455d-9045-a1eb1c4e1f74",
        'include_player_ids' => $user,
        'data' => array("foo" => "bar"),
        'large_icon' => "ic_launcher_round.png",
        'headings' => $headings,
        'contents' => $content,
        'web_buttons' => $hashes_array
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic YjBmY2RiZWUtZDMxNS00OTYwLThkYmMtZDlkZGNkNGRlYzk2'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function initNotificationBulk($message = '', $title = '')
{
    $content = array("en" => $message);
    $headings = array("en" => $title);
    $hashes_array = array();
    $fields = array(
        'app_id' => "43946382-87c5-455d-9045-a1eb1c4e1f74",
        'included_segments' => array(
            'All'
        ),
        'data' => array(
            "foo" => "bar"
        ),
        'headings' => $headings,
        'contents' => $content,
        'web_buttons' => $hashes_array
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic YjBmY2RiZWUtZDMxNS00OTYwLThkYmMtZDlkZGNkNGRlYzk2'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function sendNotification($data)
{

    $title = $data['title'];
    $user = $data['user'];
    $message = $data['message'];
    $response = initNotification($message, $user, $title);
    $return["allresponses"] = $response;
    $return = json_encode($return);

    $data = json_decode($response, true);
    if (isset($data['errors'][0])) {
        dd($data);
        return $data["errors"][0];
    } else {
        return 'Success..!';
    }
}

function sendNotificationBulk($data)
{
    $title = $data['title'];
    $message = $data['message'];
    $response = initNotificationBulk($message, $title);
    $return["allresponses"] = $response;
    $return = json_encode($return);

    $data = json_decode($response, true);
    if (isset($data['errors'][0])) {
        return $data["errors"][0];
    } else {
        return 'Success..!';
    }
}
