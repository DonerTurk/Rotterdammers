<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'database.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stop de Ontkoking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a class="logo" href="index.php">STOP DE <span>ONTKOKING</span></a>
    <nav>
        <a href="index.php">Home</a>
        <a href="recipes.php">Recepten</a>
        <a href="recipes.php?category=Ontbijt">Ontbijt</a>
        <a href="recipes.php?category=Diner">Diner</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="manage.php">Mijn recepten</a>
            <?php if(($_SESSION['role'] ?? '') === 'admin'): ?><a href="admin.php">Admin</a><?php endif; ?>
            <a class="nav-button" href="logout.php">Uitloggen</a>
        <?php else: ?>
            <a class="nav-button" href="login.php">Inloggen</a>
        <?php endif; ?>
    </nav>
</header>
<main>