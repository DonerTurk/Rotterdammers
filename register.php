<?php
session_start(); require_once 'database.php'; $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $username=trim($_POST['username']); $password=$_POST['password'];
    if(strlen($username)<3 || strlen($password)<4) $error='Gebruik minimaal 3 letters voor je naam en 4 voor je wachtwoord.';
    else {
        try {
            $stmt=$db->prepare("INSERT INTO users(username,password) VALUES(?,?)");
            $stmt->execute([$username,password_hash($password,PASSWORD_DEFAULT)]);
            header('Location: login.php'); exit;
        } catch(Exception $e){ $error='Deze gebruikersnaam bestaat al.'; }
    }
}
include 'header.php'; ?>
<section class="auth"><form method="post"><span class="tag">DOE MEE</span><h1>Account maken</h1>
<?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
<label>Gebruikersnaam</label><input name="username" required>
<label>Wachtwoord</label><input type="password" name="password" required>
<button>Registreren</button><p>Al een account? <a href="login.php">Inloggen</a></p></form></section>
<?php include 'footer.php'; ?>