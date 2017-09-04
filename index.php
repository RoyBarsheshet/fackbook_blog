<?php
require_once 'app/helpers.php';
session_start();

$title = 'Home page';

if (!verify_user()) {
    header('location: signin.php');
    exit;
} else {
    header('location: blog.php');
}