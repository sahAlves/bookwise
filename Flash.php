<?php

class Flash {
    public function push($key, $value) {
        $_SESSION["flash_$key"] = $value;
    }

    public function get($key) {
        if( ! isset($_SESSION["flash_$key"]) ) {
            return false;
        }
        $value = $_SESSION["flash_$key"];
        unset($_SESSION["flash_$key"]); // Remove o flash após obter o valor
        return $value;
    }
}