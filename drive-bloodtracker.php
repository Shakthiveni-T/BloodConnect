<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: drive-login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drive = $_SESSION['username'];
    $blood = $_POST['blood'];
    $units = $_POST['units'];
    $date = $_POST['date'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare(
        "INSERT INTO drive_blood_tracker 
        (drive_username, blood_group, units, collected_date, notes)
        VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("ssiss", $drive, $blood, $units, $date, $notes);
    $stmt->execute();
}

$data = $conn->query("SELECT * FROM drive_blood_tracker ORDER BY collected_date DESC");
// Blood group totals
$totals = $conn->query(
    "SELECT blood_group, SUM(units) AS total_units
     FROM drive_blood_tracker
     GROUP BY blood_group"
);

?>

<!DOCTYPE html>
<html>
<head>
<title>Drive Blood Tracker</title>
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
    text-align:center;
    padding:40px 20px;
    color:white;
}

/* ---------- HEADING ---------- */
h1{
    color:#ff4d4d;
    margin-bottom:30px;
    font-size:30px;
    animation:fadeIn 1s ease;
}

/* ---------- INPUT BOX ---------- */
.input-box{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(10px);
    width:500px;
    max-width:95%;
    margin:25px auto 40px;
    padding:25px 30px;
    border-radius:18px;
    box-shadow:0 20px 40px rgba(0,0,0,0.45);
    animation:fadeIn 1.1s ease;
}

/* ---------- FORM ELEMENTS ---------- */
input, select{
    width:100%;
    padding:14px;
    margin-bottom:14px;
    border:none;
    border-radius:10px;
    outline:none;
    background:rgba(255,255,255,0.15);
    color:white;
    font-size:14px;
}

input::placeholder{
    color:#e6b3b3;
}

/* ---------- BUTTON ---------- */
button{
    width:100%;
    padding:14px;
    background:linear-gradient(135deg,#ff0000,#b30000);
    color:white;
    border:none;
    border-radius:30px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(255,0,0,0.35);
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
    animation:fadeIn 1.2s ease;
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

<h1 style="color:#b30000;">Blood Tracker – Drive Summary</h1>

<div class="input-box">
<form method="POST">
<select name="blood" required>
<option value="">Select Blood Group</option>
<option>A+</option><option>A-</option>
<option>B+</option><option>B-</option>
<option>AB+</option><option>AB-</option>
<option>O+</option><option>O-</option>
</select>

<input type="number" name="units" placeholder="Units Collected" required>
<input type="date" name="date" required>
<input type="text" name="notes" placeholder="Notes / Location" required>

<button>Add Entry</button>
</form>
</div>

<table>
<tr>
<th>Blood Group</th>
<th>Units</th>
<th>Date</th>
<th>Notes</th>
</tr>

<?php
while ($row = $data->fetch_assoc()) {
    echo "<tr>
            <td>{$row['blood_group']}</td>
            <td>{$row['units']}</td>
            <td>{$row['collected_date']}</td>
            <td>{$row['notes']}</td>
          </tr>";
}
?>

</table>

<a href="drive-main.php" class="back-btn">⬅ Back</a>

</body>
</html>
