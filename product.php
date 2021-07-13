<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkty</title>
</head>
<body>
    <?php

    require_once("products_controller.php");

    if (!isset($_GET["id"]) || $_GET["id"] == "") $id = -1;
    else $id = $_GET["id"];

    $product = get_product($id);

    ?>

    <h4><a href="products.php">zpět</a></h4>

    <h1>Správa produktů</h1>

    <?php

    if ($product != null) {
        echo "<h2>Výpis produktu ".$product->get_name()."</h2>";

        echo "<h3>Kategorie: ".$product->get_category_name()."</h3>";
        echo "<h3>Cena: ".$product->get_price()."</h3>";
    }

    ?>
</body>
</html>