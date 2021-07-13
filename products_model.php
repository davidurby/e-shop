<?php
    class product {
        public $id;
        public $name;
        public $price;
        public $id_category;

        function get_id() {
            return $this->id;
        }

        function set_id($value) {
            $this->id = $value;
        }

        function get_name() {
            return $this->name;
        }

        function set_name($value) {
            $this->name = $value;
        }

        function get_price() {
            return $this->price;
        }

        function set_price($value) {
            $this->price = $value;
        }

        function get_id_category() {
            return $this->id_category;
        }

        function set_id_category($value) {
            $this->id_category = $value;
        }

        function save() {
            require_once("connect.php");
            $connection = $GLOBALS["connection"];
            
            $save = $connection->prepare("INSERT INTO products (name, price, id_category) VALUES (?, ?, ?)");
            $save->bind_param("sii", $this->name, $this->price, $this->id_category);
            $save->execute();
        }

        function get_info() {
            return $this->get_category_name().": ".$this->name.", ".$this->price;
        }

        function get_category_name() {
            require_once("connect.php");
            $connection = $GLOBALS["connection"];

            $sql = "SELECT * FROM categories WHERE id=".$this->id_category;
            $load = $connection->prepare($sql);
            $exec = $load->execute();
        
            if ($exec) {
                $result = $load->get_result();
                if ($result) {
                    $record = $result->fetch_assoc();
                    return $record["name"];
                }
                return "";
            }

            return "";
        }

        function set_params($object) {
            $this->id = $object->id;
            $this->name = $object->name;
            $this->price = $object->price;
            $this->id_category = $object->id_category;
        }
    }
?>