<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: donor-login.php");
    exit();
}

$username = $_SESSION['username'];

$sql = "SELECT donation_date, location, status 
        FROM donor_donations 
        WHERE donor_username = ?
        ORDER BY donation_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Donation History</title>
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"Segoe UI", sans-serif;
}

body{
    background:linear-gradient(135deg,#2b0000,#4d0000,#800000);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

/* ---------- CONTAINER ---------- */
.box{
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(12px);
    padding:30px;
    width:750px;
    border-radius:18px;
    box-shadow:0 25px 50px rgba(0,0,0,0.45);
    animation:fadeIn 0.9s ease;
}

/* ---------- HEADING ---------- */
h2{
    margin-bottom:25px;
    font-size:26px;
    color:#ff6666;
}

/* ---------- TABLE ---------- */
table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:12px;
}

th{
    background:#cc0000;
    color:white;
    padding:14px;
    font-size:16px;
}

td{
    text-align:center;
    padding:12px;
    color:white;
    border-bottom:1px solid rgba(255,255,255,0.15);
}

tr:nth-child(even){
    background:rgba(255,255,255,0.08);
}

tr:hover{
    background:rgba(255,255,255,0.15);
}

/* ---------- BACK BUTTON ---------- */
.back-btn{
    margin-top:25px;
    display:inline-block;
    background:rgba(255,255,255,0.15);
    color:white;
    padding:12px 22px;
    border-radius:30px;
    text-decoration:none;
    font-size:15px;
    border:1px solid rgba(255,255,255,0.3);
    transition:0.3s;
}

.back-btn:hover{
    background:#ff4d4d;
    border-color:#ff4d4d;
}

/* ---------- ANIMATION ---------- */
@keyframes fadeIn{
    from{opacity:0; transform:translateY(25px)}
    to{opacity:1; transform:translateY(0)}
}
</style>

</head>
<body>

<div class="box">
<h2 style="color:#b30000;text-align:center;">Your Donation History</h2>

<table>
<tr>
<th>Date</th>
<th>Location</th>
<th>Status</th>
</tr>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['donation_date']}</td>
                <td>{$row['location']}</td>
                <td>{$row['status']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No records found</td></tr>";
}
?>

</table>

<a href="donor-main.php" class="back-btn">⬅ Back</a>
</div>

</body>
</html>
