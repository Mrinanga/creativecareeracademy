<?php
if (isset($_GET['course'])) {
    $course = $_GET['course'];

    // Connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'creativecareeracademy');
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch student data based on the selected course
    $query = "SELECT Roll_number, full_name FROM admissions WHERE course_selection = '".mysqli_real_escape_string($db, $course)."' ORDER BY Roll_number ASC";
    $result = mysqli_query($db, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($db));
    }

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="students-list">';
        echo '<thead><tr><th>Roll Number</th><th>Full Name</th><th>Present</th></tr></thead>';
        echo '<tbody>';
        while ($student = mysqli_fetch_array($result)) {
            echo '<tr>';
            echo '<td>'.$student['Roll_number'].'</td>';
            echo '<td>'.$student['full_name'].'</td>';
            echo '<td><input type="checkbox" name="present[]" value="'.$student['Roll_number'].'"></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No students found for this course.</p>';
    }

    mysqli_close($db);
} else {
    echo '<p>Course not specified.</p>';
}
?>
