<?php
session_start();
include 'config.php'; 

// Ensure user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Get user data from session
$name = $_SESSION['name'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donate to Help the Homeless</title>
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
        .donate-section {
            padding-top: 50px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">Help the Homeless</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="requests.php" class="nav-link">Requests</a></li>
                    <li class="nav-item"><a href="view_donations.php" class="nav-link">View Donations</a></li>
                    <li class="nav-item active"><a href="logout.php" class="nav-link">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="content" class="donate-section">
        <div class="container">
            <h1 class="text-center mt-5 mb-4" style="color: #ff6347;">Donate to Help the Homeless</h1>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = htmlspecialchars($_POST['name'] ?? '');
                    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
                    $amount = $_POST['amount'] ?? 0.00;
                    $message = htmlspecialchars($_POST['message'] ?? '');
                    $pickup_date = htmlspecialchars($_POST['pickup_date'] ?? '');
                    $pickup_time = htmlspecialchars($_POST['pickup_time'] ?? '');

                    // Validate inputs
                    if (empty($name) || empty($email) || empty($pickup_date) || empty($pickup_time)) {
                        echo "<div class='alert alert-danger'>Error: Name, email, pick-up date, and pick-up time are required.</div>";
                    } elseif (!is_numeric($amount) || $amount <= 0) {
                        echo "<div class='alert alert-danger'>Error: Amount must be a positive number.</div>";
                    } else {
                        try {
                            // Prepare and bind
                            $stmt = $conn->prepare("INSERT INTO Donations (name, email, amount, message, pickup_date, pickup_time) VALUES (:name, :email, :amount, :message, :pickup_date, :pickup_time)");
                            $stmt->bindParam(':name', $name);
                            $stmt->bindParam(':email', $email);
                            $stmt->bindParam(':amount', $amount);
                            $stmt->bindParam(':message', $message);
                            $stmt->bindParam(':pickup_date', $pickup_date);
                            $stmt->bindParam(':pickup_time', $pickup_time);

                            // Execute the statement
                            if ($stmt->execute()) {
                                echo "<div class='alert alert-success'>Your donation has been received successfully!</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Error: Failed to process your donation.</div>";
                            }
                        } catch (PDOException $e) {
                            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
                        }
                    }
                }
            ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="w3-panel w3-white w3-margin">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required class="form-control" placeholder="Enter your name">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required class="form-control" placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="amount">Amount (food):</label>
                    <input type="number" id="amount" name="amount" min="1.00" step="0.01" required class="form-control" placeholder="Enter amount">
                </div>

                <div class="form-group">
                    <label for="pickup_date">Pick-Up Date:</label>
                    <input type="date" id="pickup_date" name="pickup_date" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="pickup_time">Pick-Up Time:</label>
                    <input type="time" id="pickup_time" name="pickup_time" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" class="form-control" placeholder="Write your message here"></textarea>
                </div>

                <button type="submit" class="btn btn-block btn-primary mt-3">Submit</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 fixed-bottom">
        &copy; 2025 Help the Homeless
    </footer>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
