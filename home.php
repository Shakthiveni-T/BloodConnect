<?php
// db.php - reusable database connection

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodconnect";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome to BloodConnect</title>

<style>

/* ---------- RESET ---------- */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Segoe UI, sans-serif;
}

/* ---------- BACKGROUND ---------- */
body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#1b0000,#300000,#4d0000);
    color:white;
}

/* ---------- CONTAINER ---------- */
.container{
    background:rgba(0,0,0,0.35);
    backdrop-filter:blur(10px);
    padding:50px 60px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 20px 40px rgba(0,0,0,0.4);
    animation:fadeIn 1.2s ease;
}

/* ---------- HEADINGS ---------- */
h1{
    font-size:2.6rem;
    margin-bottom:10px;
}
h2{
    font-size:1.3rem;
    margin-bottom:35px;
    opacity:0.9;
}

/* ---------- BUTTONS ---------- */
.btn{
    display:block;
    width:280px;
    padding:16px;
    margin:16px auto;
    background:red;
    color:white;
    text-decoration:none;
    border-radius:30px;
    font-size:18px;
    font-weight:bold;
    transition:0.4s;
}

.btn:hover{
    background:white;
    color:red;
    transform:translateY(-4px);
    box-shadow:0 10px 20px rgba(255,0,0,0.4);
}

/* ---------- ANIMATION ---------- */
@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(40px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* ---------- RESPONSIVE ---------- */
@media(max-width:600px){
    .container{
        width:90%;
        padding:40px 20px;
    }
    .btn{
        width:100%;
    }
}

</style>
</head>

<body>

<div class="container">
    <h1>Welcome to Blood<span style="color:red">Connect</span></h1>
    <h2>Sign In As</h2>

    <a href="donor-login.php" class="btn">Blood Donor</a>
    <a href="drive-login.php" class="btn">Blood Drive</a>
    <a href="bank-login.php" class="btn">Blood Bank</a>
</div>

</body>
</html>

<?php
$conn->close();
?>
