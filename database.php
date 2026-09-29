<?php
// Simpele database verbinding met SQLite
$db = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'user'
)");

$db->exec("CREATE TABLE IF NOT EXISTS recipes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    title TEXT NOT NULL,
    category TEXT NOT NULL,
    ingredients TEXT NOT NULL,
    instructions TEXT NOT NULL,
    image TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$count = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ($count == 0) {
    $password = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
    $stmt->execute(['admin', $password]);
}

$countRecipes = $db->query("SELECT COUNT(*) FROM recipes")->fetchColumn();
if ($countRecipes == 0) {
    $recipes = [
        ['Romige kip pasta','Diner',"Pasta\nKipfilet\nRoom\nParmezaan\nKnoflook",'Kook de pasta. Bak de kip en knoflook. Voeg room toe en meng alles door elkaar.',''],
        ['Gezonde breakfast bowl','Ontbijt',"Yoghurt\nBanaan\nAardbeien\nGranola",'Doe de yoghurt in een kom en verdeel het fruit en de granola erover.',''],
        ['Crispy chicken wraps','Lunch',"Wraps\nKip\nSla\nTomaat\nSaus",'Bak de kip krokant. Vul de wraps met sla, tomaat, kip en saus.','']
    ];
    $stmt = $db->prepare("INSERT INTO recipes (user_id,title,category,ingredients,instructions,image) VALUES (1,?,?,?,?,?)");
    foreach ($recipes as $r) $stmt->execute($r);
}
?>