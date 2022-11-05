<?php
require_once __DIR__ . '/../vendor/autoload.php';

$client = new \Google_Client();
$client->setApplicationName('Lab04');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);
$spreadsheetId = "16ZlxzUOs9ZHrljjA3QGAUk8oClkfBhsSbXiAuW5hmrM";
?>

<DOCTYPE! html>
<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
<p>
    Написать доску объявлений. Пользователь указывает свой
    email, текст объявления, заголовок объявления (форма),
    категория. Для хранения объявлений использовать Google sheets.<br/>
</p>
<form action="DataImporter.php" method="post">
    <textarea name="mail">Enter your email here</textarea>
    <textarea name="title">Enter your title here</textarea>
    <textarea name="category">Enter your category</textarea>
    <textarea name="description">Enter your description here</textarea>

    <input type="submit" value="Add your ad">
</form>
<div>
    <table>
        <tr>
            <th>E-mail</th>
            <th>Title</th>
            <th>Category</th>
            <th>Description</th>
        </tr>
        <?php
        $range = 'Ads!A1:A1';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $adsCounter = $response->getValues();
        $adsCounter = $adsCounter[0][0] + 1;

        $range = "Ads!A2:D{$adsCounter}";
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        foreach($values as $row)
        {
            echo "<tr>";
            foreach($row as $item)  echo "<td>{$item}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>