<?php
// donor-signup.php
include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $blood_group = trim($_POST['blood_group']);

    if (empty($username) || empty($password)) {
        $message = "Username and password are required.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM donors WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Username already exists. Please choose another.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare(
                "INSERT INTO donors (username, password, name, email, blood_group)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $insert->bind_param("sssss",
                $username, $hashed_password, $name, $email, $blood_group
            );

            if ($insert->execute()) {
                $message = "Signup successful! You can now <a href='donor-login.php'>login</a>.";
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
<title>Donor Signup</title>

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

/* ---------- SIGNUP CARD ---------- */
.box{
    background:rgba(0,0,0,0.35);
    backdrop-filter:blur(10px);
    padding:45px 40px;
    border-radius:20px;
    width:380px;
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
input, select{
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
.message a{
    color:#ff4d4d;
    font-weight:bold;
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
    <h2>Blood <span>Donor</span> Signup</h2>

    <form action="" method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <select name="blood_group" required>
            <option value="">Select Blood Group</option>
            <option>A+</option><option>A-</option>
            <option>B+</option><option>B-</option>
            <option>O+</option><option>O-</option>
            <option>AB+</option><option>AB-</option>
        </select>

        <button type="submit" class="btn">Signup</button>

        <p class="message"><?php echo $message; ?></p>

        <p style="margin-top:15px;">
            Already have an account?
            <a href="donor-login.php">Login</a>
        </p>
    </form>
</div>

<!-- Back Button -->
<form action="home.php" method="get">
    <button type="submit" class="back-btn">⬅ Back</button>
</form>

</body>
</html>
