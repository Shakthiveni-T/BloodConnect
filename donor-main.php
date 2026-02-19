<?php
session_start();

// Check if donor is logged in
if (!isset($_SESSION['username'])) {
    header("Location: donor-login.php");
    exit();
}

// Optional: Get donor username to display
$donorUsername = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Donor Main Page</title>
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
    justify-content:center;
    align-items:center;
    color:white;
}

/* ---------- CONTAINER ---------- */
.container{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(10px);
    padding:50px 45px;
    border-radius:18px;
    box-shadow:0 25px 45px rgba(0,0,0,0.45);
    text-align:center;
    animation:fadeIn 1s ease;
}

/* ---------- HEADING ---------- */
h1{
    color:#ffffff;
    margin-bottom:35px;
    font-size:30px;
    letter-spacing:0.5px;
}

/* ---------- MAIN BUTTONS ---------- */
.btn{
    display:block;
    width:280px;
    padding:16px;
    margin:18px auto;
    background:linear-gradient(135deg,#ff0000,#b30000);
    color:white;
    text-decoration:none;
    border-radius:30px;
    font-size:18px;
    font-weight:bold;
    transition:0.3s;
}

.btn:hover{
    transform:translateY(-3px) scale(1.03);
    box-shadow:0 12px 25px rgba(255,0,0,0.35);
}

/* ---------- LOGOUT BUTTON ---------- */
.back-btn{
    margin-top:35px;
    padding:12px 26px;
    background:rgba(255,255,255,0.1);
    color:white;
    text-decoration:none;
    border-radius:22px;
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
}
</style>

</head>
<body>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($donorUsername); ?></h1>

    <!-- Replace # with actual pages -->
    <a href="donor-enroll.php" class="btn">Enroll for Donation</a>
    <a href="donor-map.php" class="btn">Map of Drives Near You</a>
    <a href="donor-history.php" class="btn">Donation History</a>
</div>

<!-- Logout / Back button -->
<a href="logout.php" class="back-btn">⬅ Log Out</a>

</body>
</html>
