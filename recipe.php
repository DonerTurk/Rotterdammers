<?php include 'header.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $db->prepare("SELECT recipes.*, users.username FROM recipes LEFT JOIN users ON recipes.user_id=users.id WHERE recipes.id=?");
$stmt->execute([$id]); $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$recipe){ echo '<section class="section"><h2>Recept niet gevonden</h2></section>'; include 'footer.php'; exit; }
?>
<section class="detail">
    <div class="detail-image">🍽️</div>
    <div>
        <span class="tag"><?= htmlspecialchars($recipe['category']) ?></span>
        <h1><?= htmlspecialchars($recipe['title']) ?></h1>
        <p>Gedeeld door <b><?= htmlspecialchars($recipe['username'] ?? 'gebruiker') ?></b></p>
    </div>
</section>
<section class="recipe-body">
    <div><h2>Ingrediënten</h2><ul><?php foreach(explode("\n",$recipe['ingredients']) as $i): ?><li><?= htmlspecialchars($i) ?></li><?php endforeach; ?></ul></div>
    <div><h2>Bereiding</h2><p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p></div>
</section>
<?php include 'footer.php'; ?>