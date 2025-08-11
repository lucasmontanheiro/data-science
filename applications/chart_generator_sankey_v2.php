<?php
// sankey_chart.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Sankey Chart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            margin-top: 20px;
        }
        .chart-container {
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        google.charts.load("current", {packages:["sankey"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'From');
            data.addColumn('string', 'To');
            data.addColumn('number', 'Weight');

            let rows = document.querySelectorAll('.data-row');
            let sankeyData = [];

            rows.forEach(row => {
                let from = row.querySelector('.from').value;
                let to = row.querySelector('.to').value;
                let value = parseInt(row.querySelector('.value').value) || 0;
                if (from && to && value > 0) {
                    sankeyData.push([from, to, value]);
                }
            });

            data.addRows(sankeyData);

            var chart = new google.visualization.Sankey(document.getElementById('sankey_chart'));
            chart.draw(data, {
                width: 750,
                height: 400,
                sankey: {link: {color: {fill: '#007bff', fillOpacity: 0.4}}}
            });
        }

        function updateChart() {
            drawChart();
        }

        function addRow() {
            let container = document.getElementById("dataRows");
            let rowCount = container.childElementCount + 1;

            let row = document.createElement("div");
            row.classList.add("row", "g-3", "data-row");
            row.innerHTML = `
                <div class='col-md-3'>
                    <input type='text' class='form-control from' placeholder='From' oninput='updateChart()'>
                </div>
                <div class='col-md-3'>
                    <input type='text' class='form-control to' placeholder='To' oninput='updateChart()'>
                </div>
                <div class='col-md-3'>
                    <input type='number' class='form-control value' placeholder='Value' min='1' oninput='updateChart()'>
                </div>
                <div class='col-md-3'>
                    <button type='button' class='btn btn-danger' onclick='removeRow(this)'>Remove</button>
                </div>
            `;
            container.appendChild(row);
            updateChart();
        }

        function removeRow(button) {
            button.parentElement.parentElement.remove();
            updateChart();
        }
    </script>
</head>
<body>

<div class="container">
    <h2 class="text-center">Dynamic Sankey Chart</h2>
    <p class="text-center">Add or modify connections dynamically.</p>

    <div class="chart-container">
        <div id="sankey_chart" style="width: 100%; height: 400px;"></div>
    </div>

    <h4 class="mt-4">Edit Data</h4>
    <div id="dataRows">
        <div class="row g-3 data-row">
            <div class="col-md-3">
                <input type="text" class="form-control from" value="A" oninput="updateChart()">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control to" value="X" oninput="updateChart()">
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control value" value="10" min="1" oninput="updateChart()">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button>
            </div>
        </div>
        <div class="row g-3 data-row">
            <div class="col-md-3">
                <input type="text" class="form-control from" value="B" oninput="updateChart()">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control to" value="Y" oninput="updateChart()">
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control value" value="15" min="1" oninput="updateChart()">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button>
            </div>
        </div>
    </div>

    <button class="btn btn-primary mt-3" onclick="addRow()">Add Row</button>
</div>

</body>
</html>
