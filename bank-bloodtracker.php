<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: bank-login.php");
    exit();
}

$sql = "
SELECT 
    blood_group,
    MONTH(collected_date) AS month,
    SUM(units) AS total_units
FROM drive_blood_tracker
GROUP BY blood_group, MONTH(collected_date)
";

$result = $conn->query($sql);

$bloodData = [];
$groups = ["A+","A-","B+","B-","AB+","AB-","O+","O-"];
foreach ($groups as $g) {
    $bloodData[$g] = array_fill(1, 12, 0);
}
while ($row = $result->fetch_assoc()) {
    $bloodData[$row['blood_group']][$row['month']] = (int)$row['total_units'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Blood Tracker</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI, sans-serif;
}
body{
    background: linear-gradient(135deg,#1b0000,#300000,#4d0000);
    color:white;
    text-align:center;
    padding:30px 10px 50px 10px;
}
h1{
    color:#ffffff;
    font-size:2.2rem;
    margin-bottom:30px;
}
.grid{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:20px;
}
.chart-container{
    background: rgba(255, 255, 255, 1);
    padding:20px;
    border-radius:12px;
    width:400px;
    min-width:300px;
    /*box-shadow: 0 0 15px rgba(0,0,0,0.3);*/
    box-shadow: 0 0 8px #313030ff;
    transition:0.3s;
}
.chart-container:hover{
    transform: translateY(-6px);
}
.chart-container h2{
    margin-bottom:15px;
    color:#990000;
}
.back-btn{
    margin-top:30px;
    display:inline-block;
    padding:12px 20px;
    background:#990000;
    color:white;
    text-decoration:none;
    border-radius:25px;
    font-weight:bold;
    transition:0.4s;
}
.back-btn:hover{
    background:white;
    color:red;
}
@media(max-width:800px){
    .chart-container{
        width:90%;
    }
}
</style>
</head>
<body>

<h1>Blood Tracker – Monthly Overview</h1>

<div class="grid">
<?php foreach ($groups as $g): 
    $id = str_replace(['+','-'], ['pos','neg'], $g);
?>
    <div class="chart-container">
        <h2><?= $g ?></h2>
        <canvas id="<?= $id ?>"></canvas>
    </div>
<?php endforeach; ?>
</div>

<a href="bank-main.php" class="back-btn">⬅ Back</a>

<script>
const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

function makeChart(id, data){
    new Chart(document.getElementById(id), {
        type: "bar",
        data: {
            labels: months,
            datasets:[{
                label:"Units Collected",
                data:data,
                backgroundColor:"#990000"  // bars remain red
            }]
        },
        options:{
            responsive:true,
            plugins:{legend:{display:false}},
            scales:{ y:{ beginAtZero:true }},
            layout:{
                padding:0
            },
            backgroundColor: 'white'  // <-- this alone doesn't work in Chart.js v3+
        },
        plugins: [{
            beforeDraw: (chart) => {
                const ctx = chart.ctx;
                ctx.save();
                ctx.fillStyle = 'white'; // canvas background
                ctx.fillRect(0,0,chart.width, chart.height);
                ctx.restore();
            }
        }]
    });
}

<?php foreach ($groups as $g):
    $id = str_replace(['+','-'], ['pos','neg'], $g);
    $data = array_values($bloodData[$g]);
?>
makeChart("<?= $id ?>", <?= json_encode($data) ?>);
<?php endforeach; ?>
</script>

</body>
</html>
