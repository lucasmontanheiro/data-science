<?php
// sankey_chart.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sankey Chart Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
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

            // Fetch data from inputs
            let nodes = [];
            for (let i = 1; i <= 4; i++) {
                let from = document.getElementById('from' + i).value;
                let to = document.getElementById('to' + i).value;
                let weight = parseInt(document.getElementById('value' + i).value) || 0;
                nodes.push([from, to, weight]);
            }

            data.addRows(nodes);

            var chart = new google.visualization.Sankey(document.getElementById('sankey_chart'));
            chart.draw(data, {
                width: 700,
                height: 400,
                sankey: {link: {color: {fill: '#007bff', fillOpacity: 0.4}}}
            });
        }

        function updateChart() {
            drawChart();
        }
    </script>
</head>
<body>

<div class="container">
    <h2 class="text-center">Editable Sankey Chart</h2>
    <p class="text-center">Change the values and labels to update the chart dynamically.</p>

    <div class="chart-container">
        <div id="sankey_chart" style="width: 100%; height: 400px;"></div>
    </div>

    <h4 class="mt-4">Edit Data</h4>
    <form id="dataForm" class="row g-3">
        <?php
        // Predefined dummy data
        $data = [
            ["A", "X", 10],
            ["B", "Y", 15],
            ["C", "Z", 20],
            ["D", "W", 25]
        ];

        foreach ($data as $index => $row) {
            $i = $index + 1;
            echo "
                <div class='col-md-3'>
                    <label>From:</label>
                    <input type='text' class='form-control' id='from$i' value='{$row[0]}' oninput='updateChart()'>
                </div>
                <div class='col-md-3'>
                    <label>To:</label>
                    <input type='text' class='form-control' id='to$i' value='{$row[1]}' oninput='updateChart()'>
                </div>
                <div class='col-md-3'>
                    <label>Value:</label>
                    <input type='number' class='form-control' id='value$i' value='{$row[2]}' min='1' oninput='updateChart()'>
                </div>
                <hr>
            ";
        }
        ?>
    </form>
</div>

</body>
</html>
