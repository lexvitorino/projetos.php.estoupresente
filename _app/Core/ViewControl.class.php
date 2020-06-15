<?php

class ViewControl {

    public function loadView($viewName, $viewData = array()) {
        extract($viewData);
        include 'views/' . $viewName . '.php';
    }

    public function loadTamplate($viewName, $viewData = array()) {
        include './views/tamplate.php';
    }

    public function loadCleanTamplate($viewName, $viewData = array()) {
        include './views/novalidatetamplate.php';
    }

    public function loadViewInTamplate($viewName, $viewData) {
        extract($viewData);
        include 'views/' . $viewName . '.php';
    }

    public function loadLibary($lib) {
        if (file_exists('../libaries/' . $lib . '.php')) {
            include '../libaries/' . $lib . '.php';
        }
    }

}
