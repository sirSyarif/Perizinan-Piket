<?php

class Redirect {
    
    public static function to($target = null) {
        if ($target) {
            if (is_numeric($target)) {
                header('Location: ' . BASE_URL . '/NotFound');
                exit();
            }
            header('Location: ' . BASE_URL . '/' . $target);
            exit();
        } else {
            header('Location: ' . BASE_URL);
            exit();
        }
    }
}