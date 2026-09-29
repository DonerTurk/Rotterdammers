<?php
session_start(); require_once 'database.php';
if(!isset($_SESSION['user_id'])){ header('Location: login.php'); exit; }

if(isset($_GET['delete'])){
    $stmt=$db->prepare("DELETE FROM recipes WHERE id=? AND user_id=?");
    $stmt->execute([(int)$_GET['delete'],$_SESSION['user_id']]);
    header('Location: manage.php'); exit;
}
$edit=null;
if(isset($_GET['edit'])){
    $stmt=$db->prepare("SELECT * FROM recipes WHERE id=? AND user_id=?");
    $stmt->execute([(int)$_GET['edit'],$_SESSION['user_id']]); $edit=$stmt->fetch(PDO::FETCH_ASSOC);
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $data=[trim($_POST['title']),$_POST['category'],trim($_POST['ingredients']),trim($_POST['instructions'])];
    if(!empty($_POST['id'])){
        $stmt=$db->prepare("UPDATE recipes SET title=?,category=?,ingredients=?,instructions=? WHERE id=? AND user_id=?");
        $stmt->execute([...$data,(int)$_POST['id'],$_SESSION['user_id']]);
    } else {
        $stmt=$db->prepare("INSERT INTO recipes(user_id,title,category,ingredients,instructions) VALUES(?,?,?,?,?)");
        $stmt->execute([$_SESSION['user_id'],...$data]);
    }
    header('Location: manage.php'); exit;
}
include 'header.php';
$stmt=$db->prepare("SELECT * FROM recipes WHERE user_id=? ORDER BY id DESC"); $stmt->execute([$_SESSION['user_id']]); $mine=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="page-head"><span class="tag">JOUW KEUKEN</span><h1>Mijn recepten</h1><p>Voeg recepten toe of pas ze aan.</p></section>
<section class="dashboard">
<form class="editor" method="post">
<h2><?= $edit?'Recept aanpassen':'Nieuw recept' ?></h2>
<input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
<label>Naam van het gerecht</label><input name="title" required value="<?= htmlspecialchars($edit['title'] ?? '') ?>">
<label>Type gerecht</label><select name="category"><?php foreach(['Ontbijt','Lunch','Diner','Voorgerecht','Hoofdgerecht','Nagerecht'] as $c): ?><option <?= ($edit['category']??'')==$c?'selected':'' ?>><?= $c ?></option><?php endforeach; ?></select>
<label>Ingrediënten (één per regel)</label><textarea name="ingredients" required><?= htmlspecialchars($edit['ingredients'] ?? '') ?></textarea>
<label>Bereiding</label><textarea name="instructions" required><?= htmlspecialchars($edit['instructions'] ?? '') ?></textarea>
<button><?= $edit?'Opslaan':'Recept toevoegen' ?></button>
</form>
<div class="my-list"><h2>Jouw recepten</h2>
<?php foreach($mine as $r): ?><div class="manage-row"><div><b><?= htmlspecialchars($r['title']) ?></b><small><?= htmlspecialchars($r['category']) ?></small></div><div><a href="?edit=<?= $r['id'] ?>">Bewerken</a><a class="danger" href="?delete=<?= $r['id'] ?>" onclick="return confirm('Recept verwijderen?')">Verwijderen</a></div></div><?php endforeach; ?>
<?php if(!$mine): ?><p>Je hebt nog geen recepten toegevoegd.</p><?php endif; ?>
</div></section>
<?php include 'footer.php'; ?>