<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CandyShop - Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="viewProductStyle.css">
    <link rel="stylesheet" href="../Utente/filter.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="icon" href="../Immagini/logoCandyshop.png" type="image/x-icon">
</head>
<body>
    <?php 
        include("../header.php"); 
        require "../category.php";
        require "../connectionManager.php";
        require "../Prodotto/product.php";

        $category = new Category();
        $conn = ConnectionManager::getInstance();

        session_start(); 
    ?>
    <div class="filtro">
        <form action="../Prodotto/productFilter.php" method="POST">

            <label for="nome"> Nome: </label>
            <input type="text" id="nome" name="nome" placeholder="Inserisci il nome" autocomplete="off">
    
            <label for="categoria"> Categoria: </label>
            <select id="categoria" name="categoria">
                <option value=""> Seleziona </option>
                <?php
                    $queryResult = $category->getCategoryList($conn->getConnection());
    
                    foreach ($queryResult as $row) {
                        echo "<option value='" . $row['CodiceCategoria'] . "'>" . $row['Nome'] . "</option>";
                    }
                ?>
            </select>
            <button type="submit">Filtra</button>
        </form>
    </div>
    <div class="container my-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
            <?php 
                /*  --- isset()
                    Nel caso in cui $_SESSION['query_result'] non sia istanziata, vengono visualizzati tutti i prodotti
                    e quindi si considera un'altra query, Altrimenti si considera la query e vengono visualizzati i prodotti
                    selezionati dal filtro.
                */
                if (!isset($_SESSION['query_result'])) {    
                    $product = new Product("", "", "", "", "", "", "");
                    $query = "SELECT * FROM Prodotto";
                    $result = $product->getProducts($conn->getConnection(), $query);
                    $_SESSION['query_result'] = $result;
                }

                if (isset($_SESSION['query_result']) && !empty($_SESSION['query_result'])){
                    $result = $_SESSION['query_result'];
                    
                    foreach ($result as $product) { 
            ?>
                <div class="col mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?= htmlspecialchars($product['PercorsoImmagine']) ?>" alt="<?= htmlspecialchars($product['Nome']) ?>">
                        </div>
                        <div class="product-title">
                            <?= htmlspecialchars($product['Nome']) ?>
                            <br>
                            <?= htmlspecialchars($product['Prezzo'])." €" ?>
                        </div>
                        <form action="carrelloPage.php" method="POST">
                            <input type="hidden" name="nome" value="<?= htmlspecialchars($product['Nome']) ?>">
                            <input type="hidden" name="descrizione" value="<?= htmlspecialchars($product['Descrizione']) ?>">
                            <input type="hidden" name="prezzo" value="<?= htmlspecialchars($product['Prezzo']) ?>">
                            <input type="hidden" name="immagine" value="<?= htmlspecialchars($product['PercorsoImmagine']) ?>">
                            <div class="add-to-cart">
                                <button type="submit" class="cart-button">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <input type="number" name="quantitaOrdinata" id="" min = "0" max="<?= htmlspecialchars($product['QuantitaMagazzino']) ?>">
                            </div>
                        </form>   
                    </div>
                </div>
            <?php 
                    }
                }
                else
                    echo "No product available";
                unset($_SESSION['query_result']);
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
