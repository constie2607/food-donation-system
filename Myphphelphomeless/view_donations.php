<?php
session_start();
include 'config.php'; // Include your database connection

// Ensure user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

try {
    // Fetch available donations that have not been picked up
    $stmt = $conn->query("SELECT donations.id, donations.message, donations.amount, donations.pickup_date, donations.pickup_time, users.name AS name 
                          FROM donations
                          JOIN users ON donations.user_id = users.id
                          WHERE donations.status = 'available'");

    $donations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching donations: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Donations</title>
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
        .container {
            margin-top: 80px;
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a href="dashboard.php" class="navbar-brand">Help the Homeless</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="donate.php" class="nav-link">Donate</a></li>
                <li class="nav-item"><a href="requests.php" class="nav-link">View Requests</a></li>
                <li class="nav-item"><a href="view_donations.php" class="nav-link">View Donations</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container">
    <h1 class="text-center mt-5 mb-4">Available Donations</h1>

    <!-- Display success or error message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info text-center">
            <?= htmlspecialchars($_SESSION['message']); ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (count($donations) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Donation ID</th>
                    <th>Donor Name</th>
                    <th>Food Item</th>
                    <th>Quantity</th>
                    <th>Pickup Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td><?= htmlspecialchars($donation['id']) ?></td>
                        <td><?= htmlspecialchars($donation['name']) ?></td>
                        <td><?= htmlspecialchars($donation['message']) ?></td>
                        <td><?= htmlspecialchars($donation['amount']) ?></td>
                        <td><?= htmlspecialchars($donation['pickup_date']) ?></td>
                        <td><?= htmlspecialchars($donation['pickup_time']) ?></td>
                        <td>
                            <form method="POST" action="pickup_donation.php">
                                <input type="hidden" name="donation_id" value="<?= $donation['id'] ?>">
                                <button type="submit" class="btn btn-success">Pick Up</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No donations available at the moment.</p>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4 fixed-bottom">
    &copy; 2025 Help the Homeless
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
