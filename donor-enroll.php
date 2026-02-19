<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: donor-login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $name = $_POST['name'];
    $age = (int) $_POST['age'];
    $blood = $_POST['blood'];
    $date = $_POST['date'];
    $location = $_POST['location'];

    // AGE VALIDATION (SERVER-SIDE)
    if ($age < 18) {
        $error = "You must be at least 18 years old to donate blood.";
    } else {

        $sql = "INSERT INTO donor_donations 
                (donor_username, full_name, age, blood_group, donation_date, location)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisss", $username, $name, $age, $blood, $date, $location);

        if ($stmt->execute()) {
            header("Location: donor-history.php");
            exit();
        } else {
            $error = "Something went wrong. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Enroll for Donation</title>
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"Segoe UI", sans-serif;
}

body{
    background:linear-gradient(135deg,#1b0000,#330000,#4d0000);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(10px);
    padding:40px;
    width:380px;
    border-radius:18px;
    box-shadow:0 25px 45px rgba(0,0,0,0.45);
    animation:fadeIn 1s ease;
}

h2{
    color:#ff4d4d;
    margin-bottom:20px;
}

label{
    font-weight:600;
    color:#ffb3b3;
    font-size:14px;
}

input, select{
    width:100%;
    padding:12px;
    margin:8px 0 18px;
    border:none;
    border-radius:8px;
    outline:none;
    background:rgba(255,255,255,0.15);
    color:white;
}

input::placeholder{
    color:#ffd6d6;
}

.btn{
    width:100%;
    padding:14px;
    background:#ff4d4d;
    color:white;
    border:none;
    border-radius:10px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    background:#ff1a1a;
}

.back-btn{
    display:block;
    margin-top:18px;
    text-align:center;
    padding:12px;
    background:rgba(255,255,255,0.12);
    color:white;
    text-decoration:none;
    border-radius:22px;
    font-size:14px;
    border:1px solid rgba(255,255,255,0.25);
    transition:0.3s;
}

.back-btn:hover{
    background:#ff4d4d;
    border-color:#ff4d4d;
}

p{
    text-align:center;
    margin-bottom:12px;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(30px)}
    to{opacity:1; transform:translateY(0)}
}
</style>
</head>

<body>

<div class="box">
<h2 style="text-align:center;color:#b30000;">Enroll for Donation</h2>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <label>Full Name</label>
    <input type="text" name="name" required>

    <label>Age</label>
    <input type="number" name="age" min="18" max="65" required>

    <label>Blood Group</label>
    <select name="blood" required>
        <option value="">Select</option>
        <option>A+</option><option>A-</option>
        <option>B+</option><option>B-</option>
        <option>AB+</option><option>AB-</option>
        <option>O+</option><option>O-</option>
    </select>

    <label>Preferred Date</label>
    <input type="date" name="date" required>

    <label>Location</label>
    <input type="text" name="location" required>

    <button class="btn">Submit</button>
</form>

<a href="donor-main.php" class="back-btn">⬅ Back</a>

</div>

</body>
</html>
