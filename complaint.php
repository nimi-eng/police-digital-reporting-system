<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Set parameters and execute statement
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $complaint_type = $_POST['complaint-type'];
    $dob = $_POST['dob'];
    $location_of_complaint = $_POST['location_of_complaint'];
    $victims = $_POST['victims'];
    $suspect = $_POST['suspect'];
    $witness = $_POST['witness'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $image_url = $_POST["image_url"];

    if (!empty($_POST['image_url'])) {
        // Get the image URL from the form
        $image_url = $_POST['image_url'];

        // Validate the URL
        if (filter_var($image_url, FILTER_VALIDATE_URL)) {
            // Get the image data
            $image_data = file_get_contents($image_url);

            // Generate a unique filename
            $filename = uniqid() . ".jpg";

            // Save the image to a directory on your server
            $save_path = "images/" . $filename;
            file_put_contents($save_path, $image_data);

            // Add the image path to the database
            $media = $save_path;
        } else {
            echo "Invalid URL!";
            // You might want to handle the error case here, for example, redirecting back to the form.
        }
    } else {
        $media = null; // If no image URL is provided, set media to null or an empty string in the database.
    }
    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO complaints (name, dob, gender, phone, address, complaint_type, suspect, victims, witness, location, date, time,  picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $name, $dob, $gender, $phone,  $address,  $complaint_type, $suspect, $victims, $witness, $location_of_complaint, $date, $time, $media);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
$anything = "text";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report a Complaint</title>
    <link rel="stylesheet" href="incident.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>
<body>
    <div class="body-container">
        <nav>
            <div class="nav-body">
                    <div class="nav-logo-container">
                        <img src="/images/logo.png" alt="police logo">
                    </div>
                <div class="nav-title">
                    <p>This page belongs to the Police Department of Ghana</p>
                </div>
            </div>
        </nav>
        <div class="form-container">
            <h2>Report a Complaint</h2>
            <form action="#" method="POST">
                <div class="form-row">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of birth:</label>
                            <input type="date" id="dob" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select id="gender" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="complaint-type">Complaint Type:</label>
                            <select id="complaint-type" name="complaint-type" required>
                                <option value="theft">Theft</option>
                                <option value="assault">Assault</option>
                                <option value="vandalism">Vandalism</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label for="location_of_complaint">Location of Complaints:</label>
                            <input type="text" id="location_of_complaint" name="location_of_complaint" required>
                        </div>
                        <label for="victims" class="victims-combo">Victims:</label>
                            <select id="victims" name="victims" required class="victims-combo">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        <div class="form-group">
                            <label for="suspect">Suspect:</label>
                            <input type="text" id="suspect" name="suspect" required>
                        </div>
                        <label for="witness" class="witness-combo">Witnesss:</label>
                            <select id="witness" name="witness" required class="witness-combo">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        <div class="form-group">
                            <label for="date">Date of Incidents:</label>
                            <input type="date" id="date" name="date">
                        </div>
                        <div class="form-group">
                            <label for="time">Time of incident:</label>
                            <input type="time" id="time" name="time">
                        </div>
                        <div class="form-group">
                            <label for="image_url">Upload Picture/Video:</label>
                            <input type="file" id="image_url" name="image_url">
                        </div>
                    </div>
                </div>
                <div class="button-container"><button type="submit">Submit</button></div>
            </form>

        </div>
    </div>
</body>
</html>