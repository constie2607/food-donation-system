<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Help the Homeless</title>
    <!-- Include Bootstrap for styling -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color:rgb(6, 179, 64);
        }
        .navbar {
            background-color: #ff6347; /* Tomato red */
        }
        .navbar-brand, .navbar-nav a {
            color: white !important;
        }
        .hero-section {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('https://via.placeholder.com/1200x800');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .hero-section p {
            font-size: 1.5rem;
            max-width: 600px;
            margin: auto;
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
                <li class="nav-item"><a href="donate.php" class="nav-link">Donate</a></li>
                    <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                    <li class="nav-item active"><a href="register.php" class="nav-link">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="hero" class="hero-section">
        <div class="container">
            <h1>Welcome to Help the Homeless</h1>
            <p>Your support can make a difference in their lives.</p>
            <a href="register.php" class="btn btn-primary btn-lg mt-3">Donate Now</a>
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
