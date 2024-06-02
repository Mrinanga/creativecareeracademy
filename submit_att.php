<?php
$db = mysqli_connect('localhost', 'root', '', 'creativecareeracademy');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$json = file_get_contents('php://input');
$attendanceData = json_decode($json, true);

foreach ($attendanceData as $attendance) {
    $rollNumber = $attendance['rollNumber'];
    $attendanceStatus = $attendance['attendanceStatus'];

    // Update attendance_record based on roll number and attendance status
    if ($attendanceStatus === 'present') {
        $updateQuery = "UPDATE attendance_status SET attendance_record = attendance_record + 1 WHERE roll_number = '$rollNumber'";
        mysqli_query($db, $updateQuery);
    }

    // Insert data into the attendance_status table
    $insertQuery = "INSERT INTO attendance_status (roll_number, attendance_status) VALUES ('$rollNumber', '$attendanceStatus')";
    mysqli_query($db, $insertQuery);
}

// Get unique courses
$uniqueCourses = array_unique(array_column($attendanceData, 'courseSelection'));

foreach ($uniqueCourses as $course) {
    // Update total_classes for all students in the selected course
    $updateAllQuery = "UPDATE attendance_status SET total_classes = total_classes + 1 WHERE course_selection = '$course'";
    mysqli_query($db, $updateAllQuery);
}

// Insert data into the dailyclass_details table
$teacherName = $attendanceData[0]['teacherName'];
$attendanceDate = $attendanceData[0]['attendanceDate'];
$classTime = $attendanceData[0]['classTime'];
$className = $attendanceData[0]['className'];
$classTopic = $attendanceData[0]['classTopic'];

$insertDailyClassQuery = "INSERT INTO dailyclass_details (teacher_name, attendance_date, class_time, class_name, class_topic) VALUES ('$teacherName', '$attendanceDate', '$classTime', '$className', '$classTopic')";
mysqli_query($db, $insertDailyClassQuery);

mysqli_close($db);

echo "Attendance data submitted successfully.";
?>