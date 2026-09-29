<?php
session_start(); require_once 'database.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $stmt=$db->prepare("SELECT * FROM users WHERE username=?"); $stmt->execute([trim($_POST['username'])]);
    $user=$stmt->fetch(PDO::FETCH_ASSOC);
    if($user && password_verify($_POST['password'],$user['password'])){
        $_SESSION['user_id']=$user['id']; $_SESSION['username']=$user['username']; $_SESSION['role']=$user['role'];
        header('Location: index.php'); exit;
    } else $error='Gebruikersnaam of wachtwoord klopt niet.';
}
include 'header.php'; ?>
<section class="auth"><form method="post"><span class="tag">WELKOM TERUG</span><h1>Inloggen</h1>
<?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
<label>Gebruikersnaam</label><input name="username" required>
<label>Wachtwoord</label><input type="password" name="password" required>
<button>Inloggen</button><p>Nog geen account? <a href="register.php">Registreren</a></p></form></section>
<?php include 'footer.php'; ?>