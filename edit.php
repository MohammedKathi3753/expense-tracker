<?php
require 'db.php';
$id = new MongoDB\BSON\ObjectId($_GET['id']);
$expense = $expenses->findOne(['_id' => $id]);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expenses->updateOne(['_id' => $id], ['$set' => [
        'amount' => (float)$_POST['amount'],
        'category' => $_POST['category'],
        'description' => $_POST['description'],
        'date' => new MongoDB\BSON\UTCDateTime((new DateTime($_POST['date']))->getTimestamp() * 1000)
    ]]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modify Entry</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h1>Modify Entry</h1>
<p class="subtitle">Update your spending record</p>
<div class="card">
<form method="POST">
<input type="number" name="amount" value="<?= $expense['amount'] ?>" step="0.01" required>
<select name="category" required>
<option <?= $expense['category'] === 'Food' ? 'selected' : '' ?>>Food</option>
<option <?= $expense['category'] === 'Travel' ? 'selected' : '' ?>>Travel</option>
<option <?= $expense['category'] === 'Shopping' ? 'selected' : '' ?>>Shopping</option>
<option <?= $expense['category'] === 'Bills' ? 'selected' : '' ?>>Bills</option>
<option <?= $expense['category'] === 'Entertainment' ? 'selected' : '' ?>>Entertainment</option>
<option <?= $expense['category'] === 'Health' ? 'selected' : '' ?>>Health</option>
<option <?= $expense['category'] === 'Education' ? 'selected' : '' ?>>Education</option>
<option <?= $expense['category'] === 'Other' ? 'selected' : '' ?>>Other</option>
</select>
<input type="date" name="date" value="<?= $expense['date']->toDateTime()->format('Y-m-d') ?>" required>
<input type="text" name="description" value="<?= htmlspecialchars($expense['description']) ?>" required>
<button type="submit">Update Entry</button>
</form>
</div>
</div>
</body>
</html>