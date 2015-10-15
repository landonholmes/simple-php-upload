<?php
session_start();

if(!isset($_SESSION['loggedIn']) || (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == false)) {
    header("Location: login.php"); // Redirecting To Home Page
    exit;
} else {
    header("Location: manageUploads.php"); // Redirecting To Home Page
    exit;
}
