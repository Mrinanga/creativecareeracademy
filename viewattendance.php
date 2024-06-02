<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Details</title>
</head>
<style>
            body {
                background-color: #001033;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            /* Style the table headers */
            th {
                background-color: #001033;
                color: white;
                font-weight: bold;
                padding: 12px;
                text-align: left;
            }

            /* Style the table rows */
            tr {
                border-bottom: 1px solid #ddd;
            }

            /* Style the table cells */
            td {
                padding: 12px;
                color: #fff;
            }

            /* Style the container */
            .container {
                margin: auto;
                max-width: 800px;
                min-width: 500px;
                padding: 20px;
                background-color: #001f61;
            }

            /* Style the heading */
            h1 {
                text-align: center;
                color: #fff;
            }

            /* Alternate row colors */
            tr:nth-child(even) {
                background-color: #001033;
            }
    </style>
<body>
    <div class="container">
        <h1 class="mb-4">Attendance Details</h1>
        <table class="table table-bordered table-striped" id="attendanceTable">
            <thead>
                <tr>
                    <th>Roll Number</th>
                    <th>Student Name</th>
                    <th>Attendance Record</th>
                    <th>Total Classes</th>
                    <th>Attendance Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Replace these values with your actual database credentials
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "creativecareeracademy";

                // Create a database connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check the connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from the 'attendance_status' table, ordered by roll_number in ascending order
                $sql = "SELECT roll_number, full_name, attendance_record, total_classes FROM attendance_status WHERE total_classes > 0 ORDER BY roll_number ASC";
                $result = $conn->query($sql);

                // Generate table rows using the fetched data
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["roll_number"] . "</td>";
                        echo "<td>" . $row["full_name"] . "</td>";
                        echo "<td>" . $row["attendance_record"] . "</td>";
                        echo "<td>" . $row["total_classes"] . "</td>";

                        // Calculate and display the attendance percentage
                        $attendancePercentage = ($row["attendance_record"] / $row["total_classes"]) * 100;
                        echo "<td>" . number_format($attendancePercentage, 2) . "%</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>