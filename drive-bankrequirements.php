<?php
require_once "db.php";

$sql = "SELECT * FROM blood_bank_requests ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Blood Bank Requirements</title>

<style>
/* ---------- RESET ---------- */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"Segoe UI", sans-serif;
}

/* ---------- BODY ---------- */
body{
    min-height:100vh;
    background:linear-gradient(135deg,#1b0000,#300000,#4d0000);
    padding:40px 20px;
    color:white;
    text-align:center;
}

/* ---------- HEADING ---------- */
h1{
    color:#ff4d4d;
    margin-bottom:35px;
    font-size:30px;
    animation:fadeIn 1s ease;
}

/* ---------- TABLE ---------- */
table{
    width:95%;
    margin:auto;
    border-collapse:separate;
    border-spacing:0;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(10px);
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 25px 45px rgba(0,0,0,0.45);
}

/* ---------- TABLE HEADER ---------- */
th{
    padding:16px 12px;
    background:rgba(255,0,0,0.35);
    color:white;
    font-size:15px;
    letter-spacing:0.4px;
    text-transform:uppercase;
}

/* ---------- TABLE CELLS ---------- */
td{
    padding:14px 12px;
    font-size:14px;
    border-bottom:1px solid rgba(255,255,255,0.15);
}

/* ---------- ROW HOVER ---------- */
tr:hover td{
    background:rgba(255,255,255,0.05);
}

/* ---------- STATUS ---------- */
.pending{
    color:#ff4d4d;
    font-weight:bold;
}

.completed{
    color:#4dff88;
    font-weight:bold;
}

/* ---------- EMPTY ROW ---------- */
td[colspan="7"]{
    padding:25px;
    font-style:italic;
    color:#ffb3b3;
}

/* ---------- BACK BUTTON ---------- */
.back-btn{
    display:inline-block;
    margin-top:35px;
    padding:12px 28px;
    background:rgba(255,255,255,0.1);
    color:white;
    text-decoration:none;
    border-radius:24px;
    border:1px solid rgba(255,255,255,0.25);
    font-size:15px;
    transition:0.3s;
}

.back-btn:hover{
    background:#ff4d4d;
    border-color:#ff4d4d;
}

/* ---------- ANIMATION ---------- */
@keyframes fadeIn{
    from{opacity:0; transform:translateY(30px)}
    to{opacity:1; transform:translateY(0)}
}

/* ---------- RESPONSIVE ---------- */
@media(max-width:900px){
    table{
        font-size:13px;
    }
    th, td{
        padding:10px 8px;
    }
}

@media(max-width:600px){
    table{
        display:block;
        overflow-x:auto;
        white-space:nowrap;
    }
}
</style>

</head>

<body>

<h1>Blood Bank Requirements</h1>

<table>
<tr>
    <th>Blood Bank</th>
    <th>Hospital</th>
    <th>Blood Group</th>
    <th>Quantity</th>
    <th>Purpose</th>
    <th>Required Date</th>
    <th>Status</th>
</tr>

<?php if(mysqli_num_rows($result) > 0): ?>
<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= htmlspecialchars($row['bank_username']) ?></td>
    <td><?= htmlspecialchars($row['hospital_name']) ?></td>
    <td><?= $row['blood_group'] ?></td>
    <td><?= $row['quantity'] ?></td>
    <td><?= htmlspecialchars($row['purpose']) ?></td>
    <td><?= $row['required_date'] ?></td>
    <td class="<?= strtolower($row['status']) ?>">
        <?= $row['status'] ?>
    </td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="7">No requirements raised yet</td>
</tr>
<?php endif; ?>

</table>

<a href="drive-main.php" class="back-btn">⬅ Back</a>

</body>
</html>
