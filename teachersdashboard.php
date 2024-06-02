<?php
session_start();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['role']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher's Dashboard - Creative Career Academy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #001033;
            color: #fff;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            transition: transform 0.3s ease;
        }
        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            color: #fff;
            display: block;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s ease;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .sidebar-toggle {
            display: none;
            padding: 10px;
            background-color: #001033;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            cursor: pointer;
            z-index: 1000;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
                width: 250px;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .sidebar-toggle {
                display: block;
            }
        }
    </style>
</head>
<script>
        function updateCourseSelection(selectedcourseId) {
            var courseName = document.getElementById("course").value;
            if (courseName) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "get_students.php?course=" + courseName + "&selectedcourseId=" + selectedcourseId, true);
                xhr.send();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById("studentsList").innerHTML = xhr.responseText;
                    }
                };
            }
        }

        function submitAttendance() {
            var selectedCourse = document.getElementById('course').value;
            var students = document.querySelectorAll('.students-list tbody tr');
            var attendanceData = [];

            var attendanceDate = document.getElementById('cdate').value;
            var classTime = document.getElementById('ctime').value;
            var teacherName = document.getElementById('teacher-name').value;
            var className = document.getElementById('class-name').value;
            var classTopic = document.getElementById('class-topic').value;

            students.forEach(function(student) {
                var rollNumber = student.querySelector('td:first-child').textContent;
                var attendanceStatus = student.querySelector('input[type="checkbox"]').checked ? 'present' : 'absent';

                attendanceData.push({
                    rollNumber: rollNumber,
                    attendanceStatus: attendanceStatus,
                    courseSelection: selectedCourse,
                    attendanceDate: attendanceDate,
                    classTime: classTime,
                    teacherName: teacherName,
                    className: className,
                    classTopic: classTopic
                });
            });

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "submit_att.php", true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.send(JSON.stringify(attendanceData));

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    location.reload(); // Reload the page after successful submission
                }
            };
        }
    </script>
<body>
    <div class="sidebar-toggle" onclick="toggleSidebar()">☰</div>
    <div class="sidebar" id="sidebar">
        <h2>Creative Career Academy</h2>
        <a href="#" onclick="showTab('dashboard.php')">Dashboard</a>
        <a href="#" onclick="showTab('students.php')">Students</a>
        <a href="#" onclick="showTab('courses.php')">Courses</a>
        <a href="#" onclick="showTab('attendance.php')">Attendance</a>
        <a href="#" onclick="showTab('reports.php')">Reports</a>
        <a href="#" onclick="showTab('assesments.php')">Assesments</a>
        <a href="#" onclick="showTab('communication.php')">Communication</a>
        <a href="#" onclick="showTab('calendar.php')">Calendar</a>
        <a href="#" onclick="showTab('settings.php')">Settings</a>
        <a href="#" onclick="showTab('help.php')">Help</a>
        <a href="#" onclick="logout()">Logout</a>
    </div>
    <div class="main-content" id="main-content">
        <div id="tab-content" class="tab-content active">
            <h2>Welcome</h2>
            <p>Welcome to the teacher's dashboard!</p>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadTabContent('dashboard.php');
        });

        function showTab(tabFile) {
            loadTabContent(tabFile);
            if (window.innerWidth <= 768) {
                toggleSidebar();
            }
        }

        function loadTabContent(tabFile) {
            fetch(tabFile)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('tab-content').innerHTML = data;
                })
                .catch(error => console.error('Error loading tab content:', error));
        }

        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
        

        function logout() {
        // Clear the session and redirect to the login page
        window.location.href = 'logout.php'; // Create a logout.php file to clear the session
    }
    </script>
</body>
</html>