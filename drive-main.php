<?php
session_start();

// Check if blood drive user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: drive-login.php");
    exit();
}

$driveUsername = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blood Drive - Main Page</title>
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
    display:flex;
    flex-direction:column;
    align-items:center;
    color:white;
    text-align:center;
}

/* ---------- HEADING ---------- */
h1{
    margin-top:70px;
    color:#ffffff;
    font-size:30px;
    letter-spacing:0.4px;
    animation:fadeIn 1s ease;
}

/* ---------- CONTAINER ---------- */
.container{
    margin-top:55px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(10px);
    padding:45px 50px;
    border-radius:18px;
    box-shadow:0 25px 45px rgba(0,0,0,0.45);
    animation:fadeIn 1.2s ease;
}

/* ---------- BUTTONS ---------- */
.btn{
    display:block;
    width:260px;
    margin:18px auto;
    padding:16px;
    background:linear-gradient(135deg,#ff0000,#b30000);
    color:white;
    border:none;
    border-radius:30px;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
    text-decoration:none;
    transition:0.3s;
}

.btn:hover{
    transform:translateY(-3px) scale(1.03);
    box-shadow:0 12px 25px rgba(255,0,0,0.35);
}

/* ---------- LOGOUT BUTTON ---------- */
.back-btn{
    margin-top:40px;
    background:rgba(255,255,255,0.1);
    padding:12px 28px;
    border-radius:24px;
    text-decoration:none;
    color:white;
    display:inline-block;
    font-size:15px;
    border:1px solid rgba(255,255,255,0.25);
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
@media(max-width:420px){
    .container{
        width:90%;
        padding:35px 25px;
    }
    .btn{
        width:100%;
    }
    h1{
        font-size:24px;
        padding:0 15px;
    }
}
</style>

</head>
<body>

<h1>Welcome, <?php echo htmlspecialchars($driveUsername); ?> </h1>

<div class="container">
    <a href="drive-signups.php" class="btn">Sign Up Sheet</a>
    <a href="drive-bankrequirements.php" class="btn">Blood Bank Requests</a>
    <a href="drive-bloodtracker.php" class="btn">Blood Tracker</a>
</div>

<a href="logout.php" class="back-btn">⬅ Log Out</a>

</body>
</html>
