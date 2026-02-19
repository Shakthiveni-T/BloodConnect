<?php
session_start();
include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $message = "Please enter both username and password.";
    } else {
        $stmt = $conn->prepare("SELECT password FROM blood_banks WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                header("Location: bank-main.php");
                exit();
            } else {
                $message = "Incorrect password. Please try again.";
            }
        } else {
            $message = "Username not found. Please signup first.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blood Bank Login</title>

<style>

/* ---------- RESET ---------- */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI, sans-serif;
}

/* ---------- BACKGROUND ---------- */
body{
    height:100vh;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#1b0000,#300000,#4d0000);
    color:white;
}

/* ---------- LOGIN CARD ---------- */
.box{
    background:rgba(0,0,0,0.35);
    backdrop-filter:blur(10px);
    padding:45px 40px;
    border-radius:20px;
    width:360px;
    text-align:center;
    box-shadow:0 20px 40px rgba(0,0,0,0.5);
    animation:fadeIn 1.2s ease;
}

/* ---------- HEADING ---------- */
h2{
    font-size:1.9rem;
    margin-bottom:25px;
}
h2 span{color:red}

/* ---------- INPUTS ---------- */
input{
    width:100%;
    padding:14px;
    margin:12px 0;
    border:none;
    border-radius:10px;
    outline:none;
    font-size:15px;
}

/* ---------- BUTTON ---------- */
.btn{
    background:red;
    color:white;
    padding:14px;
    border:none;
    width:100%;
    border-radius:30px;
    cursor:pointer;
    font-size:17px;
    font-weight:bold;
    margin-top:18px;
    transition:0.4s;
}
.btn:hover{
    background:white;
    color:red;
    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(255,0,0,0.4);
}

/* ---------- MESSAGE ---------- */
.message{
    margin-top:12px;
    color:#ffb3b3;
    font-size:14px;
}

/* ---------- LINKS ---------- */
a{
    color:#ff4d4d;
    text-decoration:none;
    font-weight:bold;
}
a:hover{text-decoration:underline}

/* ---------- BACK BUTTON ---------- */
.back-btn{
    margin-top:25px;
    background:rgba(255,255,255,0.15);
    color:white;
    padding:10px 22px;
    border:none;
    border-radius:20px;
    cursor:pointer;
    font-size:14px;
    transition:0.3s;
}
.back-btn:hover{
    background:white;
    color:red;
}

/* ---------- ANIMATION ---------- */
@keyframes fadeIn{
    from{opacity:0; transform:translateY(40px)}
    to{opacity:1; transform:translateY(0)}
}

/* ---------- RESPONSIVE ---------- */
@media(max-width:500px){
    .box{
        width:90%;
        padding:35px 25px;
    }
}

</style>
</head>

<body>

<div class="box">
    <h2>Blood <span>Bank</span> Login</h2>

    <form action="" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" class="btn">Login</button>

        <p class="message"><?php echo $message; ?></p>

        <p style="margin-top:15px;">
            Don't have an account?
            <a href="bank-signup.php">Signup</a>
        </p>
    </form>
</div>

<!-- Back Button -->
<form action="home.php" method="get">
    <button type="submit" class="back-btn">⬅ Back</button>
</form>

</body>
</html>
