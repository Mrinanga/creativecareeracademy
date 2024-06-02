<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher's Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    
    .sidebar {
      width: 250px;
      height: 100%;
      background-color: #333;
      position: fixed;
      left: 0;
      top: 0;
      overflow-x: hidden;
      padding-top: 20px;
      color: #fff;
    }
    
    .sidebar a {
      padding: 10px;
      text-decoration: none;
      font-size: 18px;
      color: #fff;
      display: block;
      transition: all 0.3s ease;
    }
    
    .sidebar a:hover {
      background-color: #555;
    }
    
    .active {
      background-color: #4CAF50;
    }
    
    .content {
      margin-left: 250px;
      padding: 20px;
    }
    
    .logo {
      text-align: center;
      margin-bottom: 20px;
    }
    
    .logo img {
      width: 150px;
      height: auto;
    }
    
    .sidebar-heading {
      padding: 10px;
      text-transform: uppercase;
      font-weight: bold;
      letter-spacing: 1px;
      border-bottom: 1px solid #555;
    }
  </style>
</head>
<body>
  
  <div class="sidebar">
    <div class="logo">
      <img src="logo.png" alt="Logo">
    </div>
    <div class="sidebar-heading">Teachers Dashboard</div>
    <a href="#" class="active">Dashboard</a>
    <a href="#">Students</a>
    <a href="#">Grades</a>
    <a href="#">Attendance</a>
    <a href="#">Schedule</a>
    <a href="#">Messages</a>
    <a href="#">Reports</a>
    <a href="#">settings</a>
  </div>

  <div class="content">
    <h1>Dashboard</h1>
    <p>Welcome to your dashboard. Here you can manage your students, grades, schedule, and messages.</p>
  </div>

</body>
</html>
