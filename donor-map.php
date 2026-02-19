<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: donor-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Drives Near You</title>
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
    justify-content:center;
    align-items:center;
    color:white;
}

/* ---------- MAIN BOX ---------- */
.box{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(10px);
    padding:35px 40px;
    width:600px;
    max-width:95%;
    height:460px;
    border-radius:18px;
    text-align:center;
    box-shadow:0 25px 45px rgba(0,0,0,0.45);
    animation:fadeIn 1s ease;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

/* ---------- HEADING ---------- */
h2{
    color:#ff4d4d;
    margin-bottom:18px;
    font-size:26px;
}

/* ---------- MAP ---------- */
iframe{
    width:100%;
    height:350px;
    border-radius:14px;
    border:none;
    box-shadow:0 10px 25px rgba(0,0,0,0.35);
}

/* ---------- BACK BUTTON ---------- */
.back-btn{
    margin-top:18px;
    display:inline-block;
    background:rgba(255,255,255,0.1);
    color:white;
    padding:12px 26px;
    border-radius:24px;
    text-decoration:none;
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
@media(max-width:600px){
    .box{
        height:auto;
        padding:25px 20px;
    }
    iframe{
        height:300px;
    }
}
</style>

</head>
<body>

<div class="box">
<h2 style="color:#b30000;">Blood Drives Near You</h2>

<iframe 
width="100%" height="350" style="border-radius:10px;border:0"
src="https://www.openstreetmap.org/export/embed.html?bbox=77.5946%2C12.9716%2C77.6046%2C12.9816&layer=mapnik&marker=12.976%2C77.599">
</iframe>

<a href="donor-main.php" class="back-btn">⬅ Back</a>
</div>

</body>
</html>
