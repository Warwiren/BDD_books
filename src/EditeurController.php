<?php

class EditeurController {

    public function editeur(){
        return Editeur::showOneEditeur($_GET['editeur']);
    }

    public function allEditeur(){
        return Editeur::showEditeurs();
    }

    public function deleteEditeur(){
        return Editeur::deleteEditeur($_POST['id']);
    }

}