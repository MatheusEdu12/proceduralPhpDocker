<?php
// Conectar ao banco SQLite
$db = new PDO('sqlite:products.db');

// Criar tabela de produtos se não existir
$db->exec("CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    price REAL NOT NULL
)");

// Inserir um novo produto se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    
    if ($name && $price) {
        $stmt = $db->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->execute();
    }
}

// Listar todos os produtos
$products = $db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
</head>
<body>
    <h1>Cadastro de Produtos</h1>
    
    <form method="post">
        <label for="name">Nome do Produto:</label>
        <input type="text" name="name" id="name" required><br><br>
        
        <label for="price">Preço:</label>
        <input type="number" step="0.01" name="price" id="price" required><br><br>
        
        <button type="submit">Cadastrar</button>
    </form>
    
    <h2>Lista de Produtos</h2>
    <ul>
        <?php foreach ($products as $product): ?>
            <li><?php echo htmlspecialchars($product['name']) . ' - $' . number_format($product['price'], 2); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
