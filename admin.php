<?php
session_start(); require_once 'database.php';
if(($_SESSION['role'] ?? '')!=='admin'){ header('Location: index.php'); exit; }
if(isset($_GET['deleteRecipe'])){ $db->prepare("DELETE FROM recipes WHERE id=?")->execute([(int)$_GET['deleteRecipe']]); header('Location: admin.php'); exit; }
if(isset($_GET['deleteUser'])){
    $id=(int)$_GET['deleteUser'];
    if($id!=$_SESSION['user_id']){ $db->prepare("DELETE FROM recipes WHERE user_id=?")->execute([$id]); $db->prepare("DELETE FROM users WHERE id=?")->execute([$id]); }
    header('Location: admin.php'); exit;
}
include 'header.php';
$users=$db->query("SELECT * FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$recipes=$db->query("SELECT recipes.*,users.username FROM recipes LEFT JOIN users ON recipes.user_id=users.id ORDER BY recipes.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="page-head"><span class="tag">ADMIN</span><h1>Beheer</h1><p>Beheer gebruikers en alle recepten.</p></section>
<section class="admin-grid">
<div><h2>Gebruikers</h2><?php foreach($users as $u): ?><div class="manage-row"><div><b><?= htmlspecialchars($u['username']) ?></b><small><?= $u['role'] ?></small></div><?php if($u['id']!=$_SESSION['user_id']): ?><a class="danger" href="?deleteUser=<?= $u['id'] ?>" onclick="return confirm('Gebruiker verwijderen?')">Verwijder</a><?php endif; ?></div><?php endforeach; ?></div>
<div><h2>Alle recepten</h2><?php foreach($recipes as $r): ?><div class="manage-row"><div><b><?= htmlspecialchars($r['title']) ?></b><small>door <?= htmlspecialchars($r['username'] ?? '-') ?></small></div><a class="danger" href="?deleteRecipe=<?= $r['id'] ?>" onclick="return confirm('Recept verwijderen?')">Verwijder</a></div><?php endforeach; ?></div>
</section>
<?php include 'footer.php'; ?>