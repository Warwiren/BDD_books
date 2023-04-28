<?php

class EditionController {

    public function edition(){
        return Edition::showOneEdition($_GET['edition']);
    }

    public function allEdition(){
        return Edition::showEditions();
    }

    public function addEdition(){
        return Edition::addEdition($_POST['name'], $_POST['format']);
    }

    public function deleteEdition(){
        return Edition::deleteEdition($_POST['id']);
    }
}