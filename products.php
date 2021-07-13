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

    session_start();

    if (isset($_SESSION["new_product_ok"])) {

        if ($_SESSION["new_product_ok"]) {
            echo '<p style="color: green">Nový produkt úspěšně uložen.</p>';
        }
        else {
            echo '<p style="color: red">Nový produkt nebyl uložen.</p>';
        }
    }

    $products = get_all_products();

    ?>

    <h4><a href="index.php">zpět</a></h4>

    <h1>Správa produktů</h1>

    <?php

    if (count($products) > 0) {
        echo "<h2>Výpis produktů</h2>";

        echo "<ul>";
        for ($i = 0; $i < count($products); $i++) {
            echo '<li><a href="product.php?id='.$products[$i]->get_id().'">'.$products[$i]->get_info().'</a></li>';
        }
        echo "</ul>";
    }

    ?>

    <h2>Nový produkt (ukázka pouze PHP)</h2>
    <form action="products_controller.php">
        <div>
            <label for="name">Název: </label>
            <input type="text" name="name" id="name" maxlength="30" <?php if (isset($_SESSION["name_messages"]) && count($_SESSION["name_messages"]) == 0) echo 'value="'.$_SESSION["name"].'"'; ?>>
            <?php

            if (isset($_SESSION["new_product_ok"]) && !$_SESSION["new_product_ok"])
            {
                for ($i = 0; $i < count($_SESSION["name_messages"]); $i++) {
                    echo "<p>".$_SESSION["name_messages"][$i]."</p>";
                }
            }

            ?>
        </div>

        <div>
            <label for="price">Cena: </label>
            <input type="number" name="price" id="price" min="1" <?php if (isset($_SESSION["price_messages"]) && count($_SESSION["price_messages"]) == 0) echo 'value="'.$_SESSION["price"].'"'; ?>>
            <?php

            if (isset($_SESSION["new_product_ok"]) && !$_SESSION["new_product_ok"])
            {
                for ($i = 0; $i < count($_SESSION["price_messages"]); $i++) {
                    echo "<p>".$_SESSION["price_messages"][$i]."</p>";
                }
            }
            
            ?>
        </div>

        <div>
            <label for="category">Kategorie: </label>
            <select name="category" id="category">
                <?php

                require_once("categories_controller.php");
                $categories = get_all_categories();

                for ($i = 0; $i < count($categories); $i++) {
                    echo '<option value="'.$categories[$i]->get_id().'"'.(isset($_SESSION["id_category_messages"]) && count($_SESSION["id_category_messages"]) == 0 && $_SESSION["id_category"] == $categories[$i]->get_id() ? " selected" : "").'>'.$categories[$i]->get_info().'</option>';
                }

                ?>
            </select>

            <?php

            if (isset($_SESSION["new_product_ok"]) && !$_SESSION["new_product_ok"])
            {
                for ($i = 0; $i < count($_SESSION["id_category_messages"]); $i++) {
                    echo "<p>".$_SESSION["id_category_messages"][$i]."</p>";
                }
            }
            
            ?>
        </div>

        <div>
            <input type="submit" name="new_product">
        </div>
    </form>

    <?php

    if (isset($_SESSION["new_product_ok"])) {
        unset($_SESSION["new_product_ok"]);
        unset($_SESSION["name"]);
        unset($_SESSION["price"]);
        unset($_SESSION["id_category"]);
        unset($_SESSION["name_messages"]);
        unset($_SESSION["price_messages"]);
        unset($_SESSION["id_category_messages"]);
    }

    ?>
</body>
</html>