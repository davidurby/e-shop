<?php
//ahoj
require_once("connect.php");
require_once("categories_model.php");

if (isset($_GET["allCategories"])) {
    $result = get_all_categories();
    header("content-type: application/json");
    echo json_encode($result);
}

class category_viewmodel {
    public $newCategoryOk;
    public $name;
    public $idParent;
    public $nameMessages;
    public $idParentMessages;

    public function __construct($n, $i, $nM, $iM) {
        $this->name = $n;
        $this->idParent = $i;
        $this->nameMessages = $nM;
        $this->idParentMessages = $iM;
    }

    public function set_newCategoryOk($value) {
        $this->newCategoryOk = $value;
    }
}

$name = "";
$idParent = "";

$nameMessages = array();
$idParentMessages = array();

if (isset($_GET["name"]) && isset($_GET["parent"])) {

    if (isset($_GET["name"]) && $_GET["name"] != "" && strlen($_GET["name"]) < 30) $name = $_GET["name"];
    else array_push($nameMessages, "Nebyl zadán název.");

    if (isset($_GET["parent"]) && $_GET["parent"] != "" && is_numeric($_GET["parent"])) $idParent = $_GET["parent"];
    else array_push($parentMessages, "Nebyla zadána cena.");

    $viewmodel = new category_viewmodel($name, $idParent, $nameMessages, $idParentMessages);

    if (count($nameMessages) + count($idParentMessages) == 0) {
        $category = new category();
        $category->set_name($name);
        $category->set_id_parent($idParent);
        $category->save();

        $viewmodel->set_newCategoryOk(true);
    }
    else {
        $viewmodel->set_newCategoryOk(false);
    }

    header("content-type: application/json");
    echo json_encode($viewmodel);
}

function get_all_categories() {
    $output = array();
    $connection = $GLOBALS["connection"];

    $sql = "SELECT * FROM categories";
    $load = $connection->prepare($sql);
    $exec = $load->execute();

    if ($exec) {
        $result = $load->get_result();
        while ($record = $result->fetch_object()) {
            $category = new category();
            $category->set_params($record);
            array_push($output, $category);
        }
    }

    return $output;
}

?>