<?php

function getRandomQuote()
{
    $url = "https://api.quotable.io/random?tags=inspirational|success|motivational";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        return [
            'text'   => 'Small steps every day lead to big results.',
            'author' => 'Nimbus'
        ];
    }

    $data = json_decode($response, true);

    return [
        'text'   => $data["content"] ?? 'Stay focused and keep moving forward.',
        'author' => $data["author"] ?? 'Unknown'
    ];
}
