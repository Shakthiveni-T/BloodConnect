<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hospital = $_POST['hospital'];
    $doctor = $_POST['doctor'];
    $blood = $_POST['blood'];
    $units = $_POST['units'];
    $purpose = $_POST['purpose'];
    $status = $_POST['status'];

    $stmt = $conn->prepare(
        "INSERT INTO hospital_requests 
        (hospital_name, doctor_name, blood_group, units, purpose, status)
        VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssiss", $hospital, $doctor, $blood, $units, $purpose, $status);
    $stmt->execute();

    header("Location: bank-hospitalrequests.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Raise Hospital Request</title>
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

/* ---------- FORM BOX ---------- */
.box{
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(15px);
    width:420px;
    padding:35px 32px;
    border-radius:18px;
    box-shadow:0 25px 45px rgba(0,0,0,0.45);
    animation:fadeUp 0.6s ease;
}

/* ---------- HEADING ---------- */
h2{
    text-align:center;
    color:#ff9999;
    margin-bottom:22px;
    font-size:26px;
}

/* ---------- INPUTS ---------- */
input, select{
    width:100%;
    padding:12px 14px;
    margin:12px 0;
    border-radius:8px;
    border:none;
    outline:none;
    background:rgba(255,255,255,0.2);
    color:white;
    font-size:15px;
}

input::placeholder{
    color:#ffd6d6;
}

/* ---------- BUTTON ---------- */
button{
    width:100%;
    padding:14px;
    margin-top:18px;
    background:#ff4d4d;
    color:white;
    border:none;
    border-radius:30px;
    font-size:17px;
    cursor:pointer;
    transition:0.3s;
}

.back-btn{
    display:inline-block;
    margin:25px auto;
    padding:12px 26px;
    background:rgba(255,255,255,0.15);
    color:white;
    text-decoration:none;
    border-radius:30px;
    font-size:15px;
    transition:0.3s;
    border:1px solid rgba(255,255,255,0.35);
}

button:hover{
    background:#ff1a1a;
    transform:translateY(-2px);
}

/* ---------- ANIMATION ---------- */
@keyframes fadeUp{
    from{opacity:0; transform:translateY(25px)}
    to{opacity:1; transform:translateY(0)}
}
</style>

</head>

<body>
<div class="box">
<h2>Hospital Raise Request</h2>

<form method="POST">
    <!--input name="hospital" placeholder="Hospital Name" required-->
    <input name="doctor" placeholder="Doctor Name" required>

    <select name="blood" required>
        <option>A+</option><option>A-</option>
        <option>B+</option><option>B-</option>
        <option>AB+</option><option>AB-</option>
        <option>O+</option><option>O-</option>
    </select>

    <input type="number" name="units" placeholder="Units Required" required>
    <input name="purpose" placeholder="Purpose" required>

    <select name="status">
        <option value="urgent">Urgent</option>
        <option value="pending">Pending</option>
    </select>

    <button type="submit">Submit Request</button>
</form>

<a href="bank-main.php" class="back-btn">⬅ Back</a>

</div>
</body>
</html>
