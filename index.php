<?php include 'header.php'; ?>
<section class="hero">
    <div class="hero-text">
        <span class="tag">KOKEN ZONDER GEDOE</span>
        <h1>Stop met scrollen.<br><em>Start met koken.</em></h1>
        <p>Makkelijke recepten, lekkere ideeën en inspiratie voor wanneer je weer eens niet weet wat je moet eten.</p>
        <form class="hero-search" action="recipes.php" method="get">
            <input type="text" name="search" placeholder="Zoek op gerecht of ingrediënt...">
            <button>Zoeken</button>
        </form>
    </div>
    <div class="hero-card">
        <div class="food-emoji">🍝</div>
        <b>Vanavond iets lekkers?</b>
        <p>Vind binnen een paar seconden een recept.</p>
    </div>
</section>

<section class="section">
    <div class="section-title"><div><span class="tag">KIES JE MOMENT</span><h2>Waar heb je trek in?</h2></div></div>
    <div class="categories">
        <a href="recipes.php?category=Ontbijt">🥞<b>Ontbijt</b><small>Begin goed</small></a>
        <a href="recipes.php?category=Lunch">🥪<b>Lunch</b><small>Snel & lekker</small></a>
        <a href="recipes.php?category=Diner">🍜<b>Diner</b><small>Voor vanavond</small></a>
        <a href="recipes.php?category=Nagerecht">🍰<b>Nagerecht</b><small>Altijd plek voor</small></a>
    </div>
</section>

<section class="section alt">
    <div class="section-title">
        <div><span class="tag">TRENDING</span><h2>Populaire recepten</h2></div>
        <a href="recipes.php">Bekijk alles →</a>
    </div>
    <div class="recipe-grid">
    <?php
    $recipes = $db->query("SELECT * FROM recipes ORDER BY id DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
    foreach($recipes as $recipe): ?>
        <a class="recipe-card" href="recipe.php?id=<?= $recipe['id'] ?>">
            <div class="recipe-image"><?= $recipe['category']=='Ontbijt'?'🥣':($recipe['category']=='Lunch'?'🌯':'🍝') ?></div>
            <div class="recipe-info"><small><?= htmlspecialchars($recipe['category']) ?></small><h3><?= htmlspecialchars($recipe['title']) ?></h3><span>Bekijk recept →</span></div>
        </a>
    <?php endforeach; ?>
    </div>
</section>

<section class="cta">
    <span class="tag">JOUW KEUKEN</span>
    <h2>Heb jij een goed recept?</h2>
    <p>Maak een account en deel je eigen recepten met anderen.</p>
    <a class="button light" href="<?= isset($_SESSION['user_id']) ? 'manage.php' : 'register.php' ?>">Deel je recept</a>
</section>
<?php include 'footer.php'; ?>