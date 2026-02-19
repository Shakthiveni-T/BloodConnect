<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $bank_name = trim($_POST['bank_name']);
    $email = trim($_POST['email']);
    $location = trim($_POST['location']);

    if (empty($username) || empty($password)) {
        $message = "Username and password are required.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM blood_banks WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Username already exists. Please choose another.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare("INSERT INTO blood_banks (username, password, bank_name, email, location) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("sssss", $username, $hashed_password, $bank_name, $email, $location);

            if ($insert->execute()) {
                $message = "Signup successful! You can now <a href='bank-login.php'>login</a>.";
            } else {
                $message = "Error: " . $conn->error;
            }

            $insert->close();
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
<title>Blood Bank Signup</title>
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

/* ---------- SIGNUP BOX ---------- */
.box{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(10px);
    padding:40px 35px;
    border-radius:16px;
    width:360px;
    box-shadow:0 20px 40px rgba(0,0,0,0.45);
    text-align:center;
    animation:fadeIn 1s ease;
}

h2{
    color:#ff4d4d;
    margin-bottom:20px;
    font-size:26px;
}

/* ---------- INPUTS ---------- */
input{
    width:100%;
    padding:14px;
    margin:10px 0;
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

/* ---------- SIGNUP BUTTON ---------- */
.btn{
    background:linear-gradient(135deg,#ff0000,#b30000);
    color:white;
    padding:14px;
    border:none;
    width:100%;
    border-radius:25px;
    cursor:pointer;
    font-size:16px;
    font-weight:bold;
    margin-top:15px;
    transition:0.3s;
}

.btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(255,0,0,0.35);
}

/* ---------- MESSAGE ---------- */
.message{
    margin-top:12px;
    font-size:14px;
    color:#ffb3b3;
}

.message a{
    color:#ff4d4d;
    font-weight:bold;
}

/* ---------- LINKS ---------- */
a{
    color:#ff4d4d;
    text-decoration:none;
}

a:hover{
    text-decoration:underline;
}

/* ---------- BACK BUTTON ---------- */
form[action="home.php"] button{
    background:rgba(255,255,255,0.1);
    border:1px solid rgba(255,255,255,0.25);
    color:white;
    padding:10px 22px;
    border-radius:20px;
    cursor:pointer;
    font-size:14px;
    transition:0.3s;
}

form[action="home.php"] button:hover{
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
    .box{
        width:90%;
        padding:30px 22px;
    }
}
</style>

</head>
<body>
<div class="box">
<h2>Blood Bank Signup</h2>
<form action="" method="post">
<input type="text" name="bank_name" placeholder="Bank Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="location" placeholder="Location" required>
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" class="btn">Signup</button>
<p class="message"><?php echo $message; ?></p>
<p>Already have an account? <a href="bank-login.php">Login</a></p>
</form>
</div>

<!-- Back Button -->
<form action="home.php" method="get" style="text-align:center; margin-top: 30px;">
    <button type="submit" style="
        background: #990000;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-bottom: 16px;
    ">
        &larr; Back
    </button>
</form>

</body>
</html>
