<?php

require_once 'app/helpers.php';
session_start();

if (!verify_user()) {
    header('location: signin.php');
    exit;
} else {
    header('location: blog.php');
    exit;
}