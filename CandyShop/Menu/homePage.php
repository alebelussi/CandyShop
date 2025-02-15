<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CandyShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homePage.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="icon" href="../Immagini/logoCandyshop.png" type="image/x-icon">
</head>
<body>
    <?php 
        include("../header.php"); 
        require "../Prodotto/product.php";
        require "../category.php";
        require "../connectionManager.php";

        session_start(); 
    ?>
    <div class="special-text">
        <h1> Scopri i nostri dolci irresistibili! </h1>
        <p> Entra nel nostro mondo di golosità e lasciati tentare da caramelle, cioccolatini e dolciumi unici. </p>
    </div>
    <div class="container my-4">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
            <?php 
                if (!isset($_SESSION['query_result'])) { 

                    $conn = ConnectionManager::getInstance();
                    
                    $product = new Product("", "", "", "", "", "", "");
                    $query = "SELECT * 
                              FROM Prodotto P
                              WHERE P.CodiceCategoria = '001'
                              LIMIT 5";
                    $result = $product->getProducts($conn->getConnection(), $query);
                    $_SESSION['query_result'] = $result;
                }

                foreach ($result as $product) { 
            ?>
                <div class="col mb-3 h-100">
                    <div class="product-card h-100 d-flex flex-column">
                        <div class="product-image">
                            <img src="<?= htmlspecialchars($product['PercorsoImmagine']) ?>" alt="<?= htmlspecialchars($product['Nome']) ?>">
                        </div>
                        <div class="product-title mt-auto">
                            <?= htmlspecialchars($product['Nome']) ?>
                            <br>
                            <?= htmlspecialchars($product['Prezzo'])." €" ?>
                        </div>
                    </div>
                </div>
            <?php 
                }
                unset($_SESSION['query_result']);
            ?>
        </div>
    </div>
    <div class="button-container">
        <form action="viewProduct.php">
            <input type="submit" value="Scopri di più" class="btn btn-primary">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
