<?php

require_once("connect.php");
require_once("products_model.php");

$name = "";
$price = "";
$id_category = 0;

$name_messages = array();
$price_messages = array();
$id_category_messages = array();

if (isset($_GET["new_product"])) {

    if (isset($_GET["name"]) && $_GET["name"] != "" && strlen($_GET["name"]) < 30) $name = $_GET["name"];
    else array_push($name_messages, "Nebyl zadán název.");

    if (isset($_GET["price"]) && $_GET["price"] != "" && is_numeric($_GET["price"])) $price = $_GET["price"];
    else array_push($price_messages, "Nebyla zadána cena.");

    if (isset($_GET["category"]) && $_GET["category"] != "" && is_numeric($_GET["category"])) $id_category = $_GET["category"];
    else array_push($id_category_messages, "Nebyla vybrána kategorie");

    session_start();
    $_SESSION["name"] = $name;
    $_SESSION["price"] = $price;
    $_SESSION["id_category"] = $id_category;
    $_SESSION["name_messages"] = $name_messages;
    $_SESSION["price_messages"] = $price_messages;
    $_SESSION["id_category_messages"] = $id_category_messages;

    if (count($name_messages) + count($price_messages) + count($id_category_messages) == 0) {
        $product = new product();
        $product->set_name($name);
        $product->set_price($price);
        $product->set_id_category($id_category);
        $product->save();

        $_SESSION["new_product_ok"] = true;
    }
    else {
        $_SESSION["new_product_ok"] = false;
    }

    header("location: products.php");
}

function get_all_products() {
    $output = array();
    $connection = $GLOBALS["connection"];

    $sql = "SELECT * FROM products";
    $load = $connection->prepare($sql);
    $exec = $load->execute();

    if ($exec) {
        $result = $load->get_result();
        while ($record = $result->fetch_object()) {
            $product = new product();
            $product->set_params($record);
            array_push($output, $product);
        }
    }

    return $output;
}

function get_product($id) {
    if ($id <= 0) return null;

    $connection = $GLOBALS["connection"];

    $sql = "SELECT * FROM products WHERE id=?";
    $load = $connection->prepare($sql);
    $load->bind_param("i", $id);
    $exec = $load->execute();

    if ($exec) {
        $result = $load->get_result();
        $record = $result->fetch_object();
        if ($record) {
            $product = new product();
            $product->set_params($record);
            return $product;
        }
        return null;
    }

    return null;
}

?>