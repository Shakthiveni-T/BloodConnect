<?php
require 'db.php';

/* HANDLE COMPLETION */
if (isset($_POST['complete_id'])) {
    $id = $_POST['complete_id'];
    $conn->query(
        "UPDATE hospital_requests 
         SET status='completed' 
         WHERE request_id=$id"
    );
}

/* FETCH REQUESTS */
$result = $conn->query(
    "SELECT * FROM hospital_requests ORDER BY request_date DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Hospital Requests</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"Segoe UI", sans-serif;
}

body{
    background:linear-gradient(135deg,#2b0000,#4d0000,#800000);
    min-height:100vh;
}

/* ---------- HEADING ---------- */
h1{
    text-align:center;
    color:#ff6666;
    margin:30px 0;
    font-size:30px;
}

/* ---------- CONTAINER ---------- */
.container{
    width:90%;
    max-width:950px;
    margin:0 auto 40px;
}

/* ---------- CARD ---------- */
.card{
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(14px);
    padding:22px;
    margin-bottom:22px;
    border-radius:18px;
    box-shadow:0 25px 45px rgba(0,0,0,0.45);
    border-left:8px solid #ff4d4d;
    color:white;
    animation:fadeUp 0.6s ease;
}

.card.completed{
    opacity:0.75;
    border-left-color:#00cc66;
}

/* ---------- TEXT ---------- */
.card h3{
    color:#ff9999;
    margin-bottom:10px;
}

.card p{
    margin:6px 0;
    font-size:15px;
}

.status{
    margin-top:8px;
    font-weight:bold;
}

/* ---------- COMPLETE BOX ---------- */
.complete-box{
    margin-top:14px;
}

.complete-box label{
    cursor:pointer;
    font-size:14px;
}

.complete-box input[type="checkbox"]{
    transform:scale(1.2);
    margin-right:6px;
}

/* ---------- BACK BUTTON ---------- */
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

.back-btn:hover{
    background:#ff4d4d;
    border-color:#ff4d4d;
}

/* ---------- ANIMATION ---------- */
@keyframes fadeUp{
    from{opacity:0; transform:translateY(25px)}
    to{opacity:1; transform:translateY(0)}
}
</style>

</head>

<body>

<h1>Hospital Requests</h1>

<div class="container">

<?php while($row = $result->fetch_assoc()): ?>

<div class="card <?= $row['status']=='completed' ? 'completed' : '' ?>">
    <h3><?= $row['purpose'] ?></h3>

    <p><strong>Hospital:</strong> <?= $row['hospital_name'] ?></p>
    <p><strong>Doctor:</strong> <?= $row['doctor_name'] ?></p>
    <p><strong>Blood:</strong> <?= $row['blood_group'] ?> (<?= $row['units'] ?> units)</p>
    <p><strong>Date:</strong> <?= $row['request_date'] ?></p>

    <p class="status">
        <strong>Status:</strong>
        <?= ucfirst($row['status']) ?>
    </p>

    <!-- ✔ COMPLETION CHECKBOX -->
    <?php if ($row['status'] != 'completed'): ?>
        <form method="POST" class="complete-box">
            <input type="hidden" name="complete_id" value="<?= $row['request_id'] ?>">
            <label>
                <input type="checkbox" onchange="this.form.submit()">
                Mark as Completed
            </label>
        </form>
    <?php else: ?>
        ✅ Completed
    <?php endif; ?>

</div>

<?php endwhile; ?>

</div>

<div style="text-align:center;">
    <a href="bank-main.php" class="back-btn">⬅ Back</a>
</div>

</body>
</html>
