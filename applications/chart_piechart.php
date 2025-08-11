<?php
// chart_editor.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editable Exploding Pie Chart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        let chartData = [
            ['Language', 'Speakers (in millions)'],
            ['Hindi', 500],
            ['Bengali', 200],
            ['Telugu', 150],
            ['Marathi', 120],
            ['Tamil', 100]
        ];

        function drawChart() {
            let data = google.visualization.arrayToDataTable(chartData);

            let options = {
                title: document.getElementById("chartTitle").value,
                is3D: true,
                slices: { 0: { offset: 0.2 } }
            };

            let chart = new google.visualization.PieChart(document.getElementById("chart_div"));
            chart.draw(data, options);
        }

        function updateData() {
            chartData = [];
            let rows = document.querySelectorAll(".data-row");
            chartData.push(['Language', 'Speakers']);

            rows.forEach(row => {
                let label = row.querySelector(".label").value;
                let value = parseFloat(row.querySelector(".value").value) || 0;
                if (label) chartData.push([label, value]);
            });

            drawChart();
        }

        function addRow() {
            let table = document.getElementById("dataTable");
            let row = table.insertRow();
            row.classList.add("data-row");

            let labelCell = row.insertCell(0);
            let valueCell = row.insertCell(1);
            let removeCell = row.insertCell(2);

            labelCell.innerHTML = `<input type="text" class="form-control label" oninput="updateData()">`;
            valueCell.innerHTML = `<input type="number" class="form-control value" oninput="updateData()">`;
            removeCell.innerHTML = `<button class="btn btn-danger" onclick="removeRow(this)">Remove</button>`;
        }

        function removeRow(button) {
            button.parentElement.parentElement.remove();
            updateData();
        }

        function downloadChart() {
            let chartElement = document.getElementById("chart_div").getElementsByTagName("svg")[0];
            let svgData = new XMLSerializer().serializeToString(chartElement);
            let canvas = document.createElement("canvas");
            let ctx = canvas.getContext("2d");

            let img = new Image();
            img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
                let link = document.createElement("a");
                link.href = canvas.toDataURL("image/png");
                link.download = "chart.png";
                link.click();
            };
        }
    </script>
</head>
<body class="container py-4">
    <h2 class="text-center mb-4">Editable Exploding Pie Chart</h2>

    <div class="mb-3">
        <label class="form-label"><strong>Chart Title:</strong></label>
        <input type="text" id="chartTitle" class="form-control" value="Indian Language Use" oninput="drawChart()">
    </div>

    <table class="table table-bordered" id="dataTable">
        <thead>
            <tr>
                <th>Language</th>
                <th>Speakers (in millions)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="data-row">
                <td><input type="text" class="form-control label" value="Hindi" oninput="updateData()"></td>
                <td><input type="number" class="form-control value" value="500" oninput="updateData()"></td>
                <td><button class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
            </tr>
            <tr class="data-row">
                <td><input type="text" class="form-control label" value="Bengali" oninput="updateData()"></td>
                <td><input type="number" class="form-control value" value="200" oninput="updateData()"></td>
                <td><button class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
            </tr>
            <tr class="data-row">
                <td><input type="text" class="form-control label" value="Telugu" oninput="updateData()"></td>
                <td><input type="number" class="form-control value" value="150" oninput="updateData()"></td>
                <td><button class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
            </tr>
            <tr class="data-row">
                <td><input type="text" class="form-control label" value="Marathi" oninput="updateData()"></td>
                <td><input type="number" class="form-control value" value="120" oninput="updateData()"></td>
                <td><button class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
            </tr>
            <tr class="data-row">
                <td><input type="text" class="form-control label" value="Tamil" oninput="updateData()"></td>
                <td><input type="number" class="form-control value" value="100" oninput="updateData()"></td>
                <td><button class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
            </tr>
        </tbody>
    </table>

    <button class="btn btn-primary mb-3" onclick="addRow()">Add Row</button>

    <div id="chart_div" style="width: 100%; height: 500px;"></div>

    <button class="btn btn-success mt-3" onclick="downloadChart()">Download Chart</button>
</body>
</html>
