<?php
$client_id = 'ab223317ee964b54b2a0ed33ae6b62b8';
$client_secret = 'c72c1300d7314000994dded1a3ac8b21';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Basic ' . base64_encode($client_id . ':' . $client_secret),
    'Content-Type: application/x-www-form-urlencoded',
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$token = $data['access_token'];

$artistName = 'Trivium';
$query = urlencode($artistName);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?q={$query}&type=artist&limit=1");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token"
]);

$response = curl_exec($ch);
curl_close($ch);

$artistData = json_decode($response, true);
echo "<h1>" . $artistData['artists']['items'][0]['name'] . "</h1>";
echo "<img src='" . $artistData['artists']['items'][0]['images'][0]['url'] . "' width='300'/>";
echo "<p>Popularidade: " . $artistData['artists']['items'][0]['popularity'] . "</p>";
echo "<p>Gêneros: " . implode(', ', $artistData['artists']['items'][0]['genres']) . "</p>";


