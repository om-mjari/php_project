<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="./assets/css/style.css"></link>
        <title>Product Popularity</title>

        <!-- Load Google Charts library -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!--        <style>
            /* Basic Reset */
            body, html {
                margin-top: 180px;
                margin-bottom: 200px;
                padding: 0;
                font-family: Arial, sans-serif;
                height: 100%;
                background-color: #f4f4f4;
            }

            /* Center the charts on the page using Flexbox */
            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                height: 100vh; /* Full viewport height */
                padding: 20px;
                text-align: center;
            }

            h1 {
                font-size: 28px;
                margin-bottom: 20px;
                color: #333;
            }

            /* Add some styling to the chart containers */
            .chart-container {
                margin: 40px 0; /* Vertical margin between charts */
                width: 80%; /* Make charts responsive */
                max-width: 900px; /* Max width to prevent stretching */
                padding: 30px; /* Padding around the chart */
                background-color: #fff; /* White background for the chart container */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
                border-radius: 10px; /* Rounded corners */
            }

            /* Styling for the chart titles */
            .chart-title {
                font-size: 22px;
                margin-bottom: 20px; /* Spacing between title and chart */
                color: #555;
            }

            /* Responsive design for smaller screens */
            @media (max-width: 768px) {
                .chart-container {
                    width: 100%;
                    padding: 15px; /* Reduced padding for smaller screens */
                }

                h1 {
                    font-size: 24px;
                }
            }

        </style>-->
    </head>
    <body>



        <?php
// Include database connection
        $server = "localhost";
        $user = "root";
        $password = "";
        $db = "speczone";

        $conn = mysqli_connect($server, $user, $password, $db);

        if (!$conn) {
            die("Connection Failed:" . mysqli_connect_error());
        }

// SQL Query to fetch product popularity
        $query = "SELECT 
    o.Product_Id,
    p.Product_name,
    COUNT(o.Product_Id) AS EntryCount
FROM tbl_ordercart o
JOIN tbl_productinfo p ON o.Product_Id = p.Id
GROUP BY o.Product_Id, p.Product_name
ORDER BY EntryCount DESC";

// Execute the query
        $res = mysqli_query($conn, $query);

// Check for query errors
        if (!$res) {
            die("Query failed: " . mysqli_error($conn));
        }

// Prepare data for Google Charts
        $product = array();
        while ($result = mysqli_fetch_assoc($res)) {
            $product[] = "['" . $result['Product_name'] . "', " . $result['EntryCount'] . "]";
        }

// Convert PHP array to a JavaScript-friendly format
        $product_data = implode(",", $product);
        ?>

        <div class="container">
            <h1>Product Popularity</h1>

            <!-- Pie Chart Section -->
            <div class="chart-container">
                <div class="chart-title">Product Popularity (Pie Chart)</div>
                <div id="piechart" style="width: 100%; height: 500px;"></div>
            </div>

            <!-- Line Chart Section -->
            <div class="chart-container">
                <div class="chart-title">Product Popularity Trend (Line Chart)</div>
                <div id="linechart" style="width: 100%; height: 500px;"></div>
            </div>
        </div>

        <script type="text/javascript">
            // Load Google Charts package for corechart
            google.charts.load('current', {'packages': ['corechart']});

            // Callback function to draw charts after library is loaded
            google.charts.setOnLoadCallback(drawCharts);

            function drawCharts() {
                // Prepare data for all charts
                var data = google.visualization.arrayToDataTable([
                    ['Product Name', 'Popularity'], // Header Row
<?php echo $product_data; ?>    // Data from PHP
                ]);

                // Pie Chart Options
                var pieOptions = {
                    title: 'Product Popularity (Pie Chart)',
                    is3D: true,
                    width: '100%',
                    height: 500
                };

                // Line Chart Options
                var lineOptions = {
                    title: 'Product Popularity Trend (Line Chart)',
                    curveType: 'function',
                    width: '100%',
                    height: 500,
                    legend: {position: 'bottom'}
                };

                // Draw Pie Chart
                var pieChart = new google.visualization.PieChart(document.getElementById('piechart'));
                pieChart.draw(data, pieOptions);

                // Draw Line Chart
                var lineChart = new google.visualization.LineChart(document.getElementById('linechart'));
                lineChart.draw(data, lineOptions);
            }
        </script>

    </body>
</html>
