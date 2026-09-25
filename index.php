<?php
require 'db.php';
$expenses = $expenses->find([], ['sort' => ['date' => -1]]);
$total = $db->expenses->aggregate([['$group' => ['_id' => null, 'total' => ['$sum' => '$amount']]]])->toArray();
$total = $total[0]['total'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Expense Tracker</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h1>Expense Tracker</h1>
<p class="subtitle">Track every rupee with clarity</p>
<div class="summary">
<div><span>Overall Spend</span><strong>₹<?= number_format($total, 2) ?></strong></div>
<div><span>Entries</span><strong><?= $db->expenses->countDocuments() ?></strong></div>
</div>
<div class="card">
<h2>New Entry</h2>
<form action="add.php" method="POST">
<input type="number" name="amount" placeholder="Spent" step="0.01" required>
<select name="category" required>
<option value="">Type</option>
<option>Food</option>
<option>Travel</option>
<option>Shopping</option>
<option>Bills</option>
<option>Entertainment</option>
<option>Health</option>
<option>Education</option>
<option>Other</option>
</select>
<input type="date" name="date" required>
<input type="text" name="description" placeholder="Memo" required>
<button type="submit">Save Entry</button>
</form>
</div>
<div class="card">
<h2>Recent Activity</h2>
<table>
<tr><th>Date</th><th>Type</th><th>Memo</th><th>Spent</th><th>Action</th></tr>
<?php foreach ($expenses as $expense): ?>
<tr>
<td><?= $expense['date']->toDateTime()->format('d M Y') ?></td>
<td><?= htmlspecialchars($expense['category']) ?></td>
<td><?= htmlspecialchars($expense['description']) ?></td>
<td>₹<?= number_format($expense['amount'], 2) ?></td>
<td><a href="edit.php?id=<?= $expense['_id'] ?>">Modify</a> <a href="delete.php?id=<?= $expense['_id'] ?>">Remove</a></td>
</tr>
<?php endforeach; ?>
</table>
</div>
</div>
</body>
</html>