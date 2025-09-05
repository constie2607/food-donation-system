<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register as a Volunteer</title>
    <!-- Include Bootstrap for styling -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7fa;
        }
        .navbar {
            background-color: #ff6347; /* Tomato red */
        }
        .navbar-brand, .navbar-nav a {
            color: white !important;
        }
        .register-section {
            padding-top: 50px;
        }
        .alert{
            text-align: center;
            background: #f9eded;
            padding: 15px 0px;
            border: 1px solid tomato;
            border-radius: 5px;
            margin-bottom: 10px;
            color: black;

        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a href="index.php" class="navbar-brand">Help the Homeless</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                    <li class="nav-item active"><a href="register.php" class="nav-link">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="content" class="register-section">
        <div class="container">
            <h1 class="text-center mt-5 mb-4" style="color: #ff6347;">Register as a Donor</h1>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = htmlspecialchars($_POST['name'] ?? '');
                    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
                    $address = htmlspecialchars($_POST['address'] ?? '');
                    $password = htmlspecialchars($_POST['password'] ?? '');

                    // Verify if email already exists
                    $verify_query = $conn->prepare("SELECT email FROM users WHERE email = :email");
                    $verify_query->bindParam(':email', $email);
                   $verify_query->execute();
                    if ($verify_query->rowCount() != 0) {
                        echo "<div class='message'>
                        <p>This email is already in use. Please try another email or log in.</p>
                        </div><br>"; 
                        
                    } else {
                        // Hash the password before storing
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        try {
                            // Prepare and bind for registration
                            $stmt = $conn->prepare("INSERT INTO users (name, email, address, password) VALUES (:name, :email, :address, :password)");
                            $stmt->bindParam(':name', $name);
                            $stmt->bindParam(':email', $email);
                            $stmt->bindParam(':address', $address);
                            $stmt->bindParam(':password', $hashedPassword);

                            // Execute the statement
                            if ($stmt->execute()) {
                                echo "<div class='alert alert-success'>Registration successful!</div>";
                                echo "<div class='alert alert-success'> <a href='login.php'>Login Now</a></div>";;
                            } else {
                                echo "<div class='alert alert-danger'>Error: Failed to register you. Please try again.</div>";
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
                    <input type="text" id="name" name="name" required class="form-control" placeholder="Enter name">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required class="form-control" placeholder="Enter Email">
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="4" class="form-control" placeholder="Enter Address"></textarea>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required class="form-control" placeholder="Enter Password">
                </div>

                <button type="submit" class="btn btn-block btn-primary mt-3">Register</button>
                <div class="links">Already have an account? <a href="login.php">Sign In</a></div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 fixed-bottom">
        &copy; 2023 Help the Homeless
    </footer>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
