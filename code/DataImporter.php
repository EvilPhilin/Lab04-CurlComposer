<?php
require_once __DIR__ . '/../vendor/autoload.php';

$client = new \Google_Client();
$client->setApplicationName('Lab04');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);
$spreadsheetId = "16ZlxzUOs9ZHrljjA3QGAUk8oClkfBhsSbXiAuW5hmrM";

$range = 'Ads!A1:A1';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$newPos = $response->getValues();
$newPos = $newPos[0][0] + 2;

$newCount = $newPos - 1;

$body = new Google_Service_Sheets_ValueRange(['values' => array([$newCount])]);
$options = array('valueInputOption' => 'RAW');
$service->spreadsheets_values->update($spreadsheetId, "Ads!A1", $body, $options);

$values =
    [
        [$_POST['mail'],
        $_POST['title'],
        $_POST['category'],
        $_POST['description']]
    ];

$body = new Google_Service_Sheets_ValueRange(['values' => $values]);
$options = array('valueInputOption' => 'RAW');
$service->spreadsheets_values->update($spreadsheetId, "Ads!A{$newPos}", $body, $options);
?>
<DOCTYPE! html>
<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
    <form action="index.php" method="post">
        <input type="submit" value="Your ad was successfully added!">
    </form>
</body>
</html>