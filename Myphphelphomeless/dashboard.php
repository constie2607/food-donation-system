<?php
session_start();
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7fa;
        }
        .navbar {
            background-color: #ff6347;
        }
        .navbar-brand, .navbar-nav a {
            color: white !important;
        }
        .dashboard-container {
            margin-top: 80px;
            text-align: center;
        }
        .card {
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a href="dashboard.php" class="navbar-brand">Help the Homeless</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="donate.php" class="nav-link">Donate</a></li>
                <li class="nav-item"><a href="requests.php" class="nav-link">View Requests</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container dashboard-container">
    <h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>
    <p>What would you like to do today?</p>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <h3>Donate</h3>
                <p>Help those in need by donating food.</p>
                <a href="donate.php" class="btn btn-success">Go to Donate</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3>View Requests</h3>
                <p>Check requests from the homeless.</p>
                <a href="requests.php" class="btn btn-primary">View Requests</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3>View Donations</h3>
                <p>Check Donations from donors.</p>
                <a href="view_donations.php" class="btn btn-success">View Donations</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3>Make a Request</h3>
                <p>Make a request for those in need</p>
                <a href="make_request.php" class="btn btn-success">Make Request</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3>Logout</h3>
                <p>Sign out of your account.</p>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white text-center py-4 fixed-bottom">
    &copy; 2023 Help the Homeless
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
