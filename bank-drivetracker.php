<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive Tracker</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffe6e6;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #b30000;
            margin-bottom: 20px;
        }

        table {
            width: 95%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 0 10px #ff9999;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ffcccc;
            text-align: center;
        }

        th {
            background-color: #cc0000;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #ffe6e6;
        }

        tfoot tr {
            background-color: #ffcccc;
            font-weight: bold;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 18px;
            background: #444;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .back-btn:hover {
            background: black;
        }
    </style>
</head>

<body>

<h1>Drive Tracker</h1>

<table id="driveTable">
    <thead>
        <tr>
            <th>Drive Name</th>
            <th>A+</th>
            <th>A−</th>
            <th>B+</th>
            <th>B−</th>
            <th>O+</th>
            <th>O−</th>
            <th>AB+</th>
            <th>AB−</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>City Hospital Mega Drive</td>
            <td>12</td>
            <td>4</td>
            <td>9</td>
            <td>3</td>
            <td>15</td>
            <td>6</td>
            <td>2</td>
            <td>1</td>
        </tr>

        <tr>
            <td>Red Cross Community Drive</td>
            <td>8</td>
            <td>2</td>
            <td>10</td>
            <td>1</td>
            <td>13</td>
            <td>5</td>
            <td>3</td>
            <td>0</td>
        </tr>
    </tbody>

    <tfoot>
        <tr>
            <td>Total Units</td>
            <td id="tApos">0</td>
            <td id="tAneg">0</td>
            <td id="tBpos">0</td>
            <td id="tBneg">0</td>
            <td id="tOpos">0</td>
            <td id="tOneg">0</td>
            <td id="tABpos">0</td>
            <td id="tABneg">0</td>
        </tr>
    </tfoot>
</table>

<a href="bank-main.html" class="back-btn">⬅ Back</a>

<script>
function calculateTotals() {
    const totals = [0,0,0,0,0,0,0,0];
    const rows = document.querySelectorAll("#driveTable tbody tr");

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        for (let i = 1; i <= 8; i++) {
            totals[i - 1] += parseInt(cells[i].innerText) || 0;
        }
    });

    document.getElementById("tApos").innerText = totals[0];
    document.getElementById("tAneg").innerText = totals[1];
    document.getElementById("tBpos").innerText = totals[2];
    document.getElementById("tBneg").innerText = totals[3];
    document.getElementById("tOpos").innerText = totals[4];
    document.getElementById("tOneg").innerText = totals[5];
    document.getElementById("tABpos").innerText = totals[6];
    document.getElementById("tABneg").innerText = totals[7];
}

calculateTotals();
</script>

</body>
</html>

