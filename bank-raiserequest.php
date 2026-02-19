<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: bank-login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bank = $_SESSION['username'];
    $hospital = $_POST['hospital'];
    $blood = $_POST['blood'];
    $qty = $_POST['quantity'];
    $purpose = $_POST['purpose'];
    $date = $_POST['required_date'];

    $sql = "INSERT INTO blood_bank_requests 
            (bank_username, hospital_name, blood_group, quantity, purpose, required_date) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssiss",
        $bank, $hospital, $blood, $qty, $purpose, $date
    );

    if (mysqli_stmt_execute($stmt)) {
        $message = "✅ Request raised successfully!";
    } else {
        $message = "❌ Error raising request.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Raise Blood Request</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"Segoe UI", sans-serif;
}

body{
    background:linear-gradient(135deg,#3b0000,#6b0000,#990000);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* ---------- CARD ---------- */
.box{
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(14px);
    width:420px;
    padding:32px;
    border-radius:18px;
    box-shadow:0 25px 50px rgba(0,0,0,0.45);
    animation:slideUp 0.8s ease;
}

/* ---------- HEADING ---------- */
h2{
    color:#ff6666;
    margin-bottom:20px;
    font-size:24px;
}

/* ---------- INPUTS ---------- */
input, select{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid rgba(255,255,255,0.35);
    background:rgba(255,255,255,0.15);
    color:white;
    font-size:15px;
}

input::placeholder{
    color:#f2cfcf;
}

select option{
    color:black;
}

/* ---------- BUTTON ---------- */
button{
    margin-top:10px;
    background:#ff4d4d;
    color:white;
    padding:13px;
    border:none;
    width:100%;
    border-radius:30px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#ff1a1a;
    transform:translateY(-2px);
}

/* ---------- MESSAGE ---------- */
.msg{
    font-weight:bold;
    margin-bottom:12px;
    color:#00ff99;
}

/* ---------- BACK BUTTON ---------- */
.back-btn{
    display:block;
    margin-top:18px;
    padding:11px;
    background:rgba(255,255,255,0.15);
    color:white;
    text-decoration:none;
    border-radius:30px;
    font-size:14px;
    transition:0.3s;
}

.back-btn:hover{
    background:#ff4d4d;
}

/* ---------- ANIMATION ---------- */
@keyframes slideUp{
    from{opacity:0; transform:translateY(30px)}
    to{opacity:1; transform:translateY(0)}
}
</style>

</head>

<body>

<div class="box">
    <h2>Raise Blood Request</h2>

    <?php if($message) echo "<p class='msg'>$message</p>"; ?>

    <form method="post">
        <input type="text" name="hospital" placeholder="Hospital Name" required>

        <select name="blood" required>
            <option value="">Select Blood Group</option>
            <option>A+</option><option>A-</option>
            <option>B+</option><option>B-</option>
            <option>AB+</option><option>AB-</option>
            <option>O+</option><option>O-</option>
        </select>

        <input type="number" name="quantity" placeholder="Quantity (units)" required>
        <input type="text" name="purpose" placeholder="Purpose (optional)">
        <input type="date" name="required_date" required>

        <button type="submit">Raise Request</button>
    </form>

    <!-- BACK BUTTON -->
    <a href="bank-main.php" class="back-btn">⬅ Back</a>
</div>

</body>
</html>
