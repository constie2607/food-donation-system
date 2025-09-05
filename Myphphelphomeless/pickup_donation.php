<?php
session_start();
include 'config.php'; // Include your database connection

// Ensure user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Check if donation_id is set in the form
if (isset($_POST['donation_id'])) {
    $donation_id = $_POST['donation_id'];

    try {
        // Update the donation status to 'not available' (or 'picked up')
        $stmt = $conn->prepare("UPDATE donations SET status = 'not available' WHERE id = :donation_id AND status = 'available'");
        $stmt->bindParam(':donation_id', $donation_id);

        // Execute the update
        if ($stmt->execute()) {
            // Redirect back to view_donations.php with a success message
            $_SESSION['message'] = "Pickup confirmed for donation ID: " . $donation_id;
            header("Location: view_donations.php");
        } else {
            // If update fails, show an error message
            $_SESSION['message'] = "Error: Could not update donation status.";
            header("Location: view_donations.php");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    // If donation_id is not set, redirect back with an error message
    $_SESSION['message'] = "Error: Invalid donation ID.";
    header("Location: view_donations.php");
}
?>
