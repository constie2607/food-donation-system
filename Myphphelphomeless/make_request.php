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
            <h1 class="text-center mt-5 mb-4" style="color: #ff6347;">Request Application</h1>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = htmlspecialchars($_POST['name'] ?? '');
                    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
                    $amount_needed = $_POST['amount_needed'] ?? 0.00;
                    $message = htmlspecialchars($_POST['message'] ?? '');

                    // Validate inputs
                    if (empty($name) || empty($email)) {
                        echo "<div class='alert alert-danger'>Error: Name and email required.</div>";
                    } elseif (!is_numeric($amount_needed) || $amount_needed <= 0) {
                        echo "<div class='alert alert-danger'>Error: Amount must be a positive number.</div>";
                    } else {
                        try {
                            // Prepare and bind
                            $stmt = $conn->prepare("INSERT INTO requests (name, email, amount_needed, message) VALUES (:name, :email, :amount_needed, :message)");
                            $stmt->bindParam(':name', $name);
                            $stmt->bindParam(':email', $email);
                            $stmt->bindParam(':amount_needed', $amount_needed);
                            $stmt->bindParam(':message', $message);

                            // Execute the statement
                            if ($stmt->execute()) {
                                echo "<div class='alert alert-success'>Your Request has been sent through!</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Error: Failed to process your request.</div>";
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
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required class="form-control" placeholder="Enter Name">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required class="form-control" placeholder="Enter Email">
                </div>

                <div class="form-group">
                    <label for="amount_needed">Amount Needed:</label>
                    <input type="number" id="amount_needed" name="amount_needed" min="1.00" step="0.01" required class="form-control" placeholder="Enter amount">
                </div>

                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" class="form-control" placeholder="Write your message here"></textarea>
                </div>

                <button type="submit" class="btn btn-block btn-primary mt-3">Make Request</button>
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
