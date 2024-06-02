<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Form</title>
    <link rel="stylesheet" href="./application_.css">
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
</head>
<body>
    <header>
        <div id="logo">
            <img id="logo-img" src="./logo.svg" alt="Logo">
            <h2>CCA</h2>
        </div>
    </header>

    <form onsubmit="event.preventDefault(); submitAttendance();" enctype="multipart/form-data">
        <section>
            <fieldset>
                <legend>Attendance</legend>
                <div>
                    <label for="teacher-name">Teacher's Name:</label>
                    <input type="text" id="teacher-name" name="teacher-name" required>
                </div>
                <div class="timing">
                    <label for="cdate">Today's Date:</label>
                    <div class="date-display"><h2><?php echo date('d M, Y'); ?></h2></div>
                    <input type="hidden" id="cdate" name="cdate" value="<?php echo date('Y-m-d'); ?>" required readonly>
                    <label for="ctime">Class Time:</label>
                    <input type="time" id="ctime" name="ctime" value="<?php echo date('H:i'); ?>" required>
                </div>
                <div>
                    <label for="course">Course:</label>
                    <select id="course" name="course" onchange="updateCourseSelection(this.value)" required>
                        <option value="">Select Course</option>
                        <?php
                        $db = mysqli_connect('localhost', 'root', '', 'creativecareeracademy');
                        if (!$db) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                        $query = "SELECT DISTINCT course_selection FROM admissions";
                        $result = mysqli_query($db, $query);
                        if (!$result) {
                            die("Query failed: " . mysqli_error($db));
                        }
                        while ($course = mysqli_fetch_array($result)) {
                            echo '<option value="'.$course['course_selection'].'">'.$course['course_selection'].'</option>';
                        }
                        mysqli_close($db);
                        ?>
                    </select>
                </div>
                <div>
                    <label for="class-name">Class Name:</label>
                    <input type="text" id="class-name" name="class-name" required>
                </div>
                <div>
                    <label for="class-topic">Class Topic:</label>
                    <input type="text" id="class-topic" name="class-topic" required>
                </div>
            </fieldset>
        </section>
        <section id="students">
            <fieldset>
                <div id="studentsList">
                    <!-- Student list will be populated here by AJAX -->
                </div>
            </fieldset>
        </section>
        <section>
            <div class="button-container">
                <button type="reset">Reset</button>
                <button type="submit">Submit Data</button>
            </div>
        </section>
    </form>
</body>
</html>