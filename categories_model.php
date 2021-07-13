<?php
    class category {
        public $id;
        public $name;
        public $id_parent;

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

        function get_id_parent() {
            return $this->id_parent;
        }

        function set_id_parent($value) {
            $this->id_parent = $value;
        }

        function save() {
            require_once("connect.php");
            $connection = $GLOBALS["connection"];

            $save = $connection->prepare("INSERT INTO categories (name, id_parent) VALUES (?, ?)");
            $save->bind_param("si", $this->name, $this->id_parent);
            $save->execute();
        }

        function get_info() {
            return $this->name;
        }

        function set_params($object) {
            $this->id = $object->id;
            $this->name = $object->name;
            $this->id_parent = $object->id_parent;
        }
    }
?>