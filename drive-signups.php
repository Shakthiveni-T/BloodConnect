<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: drive-login.php");
    exit();
}

$sql = "SELECT donation_date, full_name, age, blood_group, location 
        FROM donor_donations
        ORDER BY donation_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Drive Sign-Up Sheet</title>
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
    margin-bottom:30px;
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
    background:rgba(255,0,0,0.35);
    color:white;
    padding:16px 12px;
    font-size:15px;
    text-transform:uppercase;
    letter-spacing:0.4px;
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

/* ---------- EMPTY STATE ---------- */
td[colspan="5"]{
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
    th, td{
        padding:10px 8px;
        font-size:13px;
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

<h1 style="color:#b30000;">Drive Sign-Up Sheet</h1>

<table>
<tr>
<th>Date</th>
<th>Donor Name</th>
<th>Age</th>
<th>Blood Group</th>
<th>Location</th>
</tr>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['donation_date']}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['age']}</td>
                <td>{$row['blood_group']}</td>
                <td>{$row['location']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No signups yet</td></tr>";
}
?>

</table>

<a href="drive-main.php" class="back-btn">⬅ Back</a>

</body>
</html>
