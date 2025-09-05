<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
        .login-section {
            padding-top: 50px;
        }
        .message{
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
                    <li class="nav-item active"><a href="login.php" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="register.php" class="nav-link">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="content" class="login-section">
        <div class="container">
            <h1 class="text-center mt-5 mb-4" style="color: #ff6347;">Login</h1>
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);

                if (empty($email) || empty($password)) {
                    echo "<div class='message'><p>Email and password are required.</p></div><br>";
                } else {
                    try {
                        // Prepare statement
                        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
                        $stmt->bindParam(':email', $email);
                        $stmt->execute();
                        
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (!$user) {
                            echo "<div class='message'><p>User not found. Please try again or register</p></div>";
                        } else {
                            echo "<pre>";
                            print_r($user); // Print user data to verify what's being retrieved
                            echo "</pre>";
                        

                        
                            if (!password_verify($password, $user['password'])) {
                                echo "<div class='message'><p>Wrong email or password.</p></div>";
                            } else {             
                        
                                // After the user is validated, store the user details in the session
                                $_SESSION['valid'] = true;
                                $_SESSION['user_id'] = $user['id']; // User's ID
                                $_SESSION['name'] = $user['name']; // User's Name
                                $_SESSION['email'] = $user['email']; // User's Email

                        
                                header("Location: dashboard.php");
                                exit();
                            }
                        }
                        
                        

                    
                    } catch (PDOException $e) {
                        echo "<div class='message'><p>Error: " . htmlspecialchars($e->getMessage()) . "</p></div>";
                    }
                }
            }
            ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="w3-panel w3-white w3-margin">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required class="form-control" placeholder="Enter Email">
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required class="form-control" placeholder="Enter Password">
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary mt-3">Login</button>
                <div class="links">Don't have an account? <a href="register.php">Sign Up</a></div>
            </form>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-4 fixed-bottom">
        &copy; 2023 Help the Homeless
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
