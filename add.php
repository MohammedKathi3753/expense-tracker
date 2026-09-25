<?php
require 'db.php';
$date = new DateTime($_POST['date']);
$expenses->insertOne([
    'amount' => (float)$_POST['amount'],
    'category' => $_POST['category'],
    'description' => $_POST['description'],
    'date' => new MongoDB\BSON\UTCDateTime($date->getTimestamp() * 1000)
]);
header('Location: index.php');
exit;
?>