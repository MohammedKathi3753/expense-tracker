<?php
require 'db.php';
$id = new MongoDB\BSON\ObjectId($_GET['id']);
$expenses->deleteOne(['_id' => $id]);
header('Location: index.php');
exit;
?>