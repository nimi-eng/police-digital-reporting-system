<?php
// Database connection
$username = "root";
$password = "";
$dbname = "digital_reporting";

// Create connection
$conn = new mysqli("localhost", $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch records from the complaints table
$sql = "SELECT name, date FROM complaints";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Complaint</title>
    <link rel="stylesheet" href="complaint_view.css">
</head>
<body>
    <div class="container">
        <div class="body-container">
            <div class="h1-text"><p>View Reported Complaint</p></div>
            <div class="complaint-container">
                <?php
                // Check if there are records
                if ($result->num_rows > 0) {
                    // Loop through records
                    while($row = $result->fetch_assoc()) {
                        // Output name and date in the desired HTML structure
                        echo '<a href="#">
                                <div class="complaintss">
                                    <p class="complaint_name">' . $row["name"] . '</p>
                                    <p class="complaint_date">' . $row["date"] . '</p>
                                </div>
                              </a>';
                    }
                } else {
                    echo "0 results";
                }
                // Close connection
                $conn->close();
                ?>
        </div>
    </div>
</body>
</html>