<?php include 'header.php';
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$sql = "SELECT * FROM recipes WHERE 1=1";
$params = [];
if ($search != '') {
    $sql .= " AND (title LIKE ? OR ingredients LIKE ?)";
    $params[] = "%$search%"; $params[] = "%$search%";
}
if ($category != '') { $sql .= " AND category = ?"; $params[] = $category; }
$sql .= " ORDER BY id DESC";
$stmt = $db->prepare($sql); $stmt->execute($params);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="page-head">
    <span class="tag">ONTDEK</span><h1>Recepten</h1>
    <p>Zoek iets lekkers en maak het gewoon zelf.</p>
</section>
<section class="section">
<form class="filters" method="get">
    <input name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Zoek op gerecht of ingrediënt">
    <select name="category">
        <option value="">Alle gerechten</option>
        <?php foreach(['Ontbijt','Lunch','Diner','Voorgerecht','Hoofdgerecht','Nagerecht'] as $c): ?>
        <option <?= $category==$c?'selected':'' ?>><?= $c ?></option>
        <?php endforeach; ?>
    </select>
    <button>Zoeken</button>
</form>
<div class="recipe-grid">
<?php foreach($recipes as $recipe): ?>
<a class="recipe-card" href="recipe.php?id=<?= $recipe['id'] ?>">
    <div class="recipe-image">🍽️</div>
    <div class="recipe-info"><small><?= htmlspecialchars($recipe['category']) ?></small><h3><?= htmlspecialchars($recipe['title']) ?></h3><span>Bekijk recept →</span></div>
</a>
<?php endforeach; ?>
<?php if(count($recipes)==0): ?><p>Geen recepten gevonden.</p><?php endif; ?>
</div>
</section>
<?php include 'footer.php'; ?>