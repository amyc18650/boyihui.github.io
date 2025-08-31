<?php
header("Content-Type: application/json");

$apiKey = "c55bdf268950426faf49aff8c9aca36f"; // 替换成你的 football-data.org Key

// 判断请求类型
if ($_GET['type'] === 'matches') {
    $url = "https://api.football-data.org/v4/matches?competitions=PL&status=FINISHED&limit=5";
} else if ($_GET['type'] === 'standings') {
    $url = "https://api.football-data.org/v4/competitions/PL/standings";
} else {
    echo json_encode(["error" => "Unknown type"]);
    exit;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-Auth-Token: $apiKey"]);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
