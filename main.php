<?php

// get an api key from https://beta.openai.com/

define('OPENAI_API_KEY', 'you-api-key');

function generate_image_from_text($text) {
    $url = 'https://api.openai.com/v1/images/generations';
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . OPENAI_API_KEY
    );
    $data = array(
        'model' => 'image-alpha-001',
        'prompt' => $text,
        'num_images' => 1,
        'size' => '512x512',
        'response_format' => 'url'
    );
    $options = array(
        'http' => array(
            'header'  => implode("\r\n", $headers),
            'method'  => 'POST',
            'content' => json_encode($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result, true);
    $image_url = $response['data'][0]['url'];
    $image_data = file_get_contents($image_url);
    return $image_data;
}

$text = "Image of a cat and a banana";
$image_data = generate_image_from_text($text);
file_put_contents("cat_image.jpg", $image_data);

?>
