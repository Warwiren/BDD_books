<?php

class CategoryController {

    public function category(){
        return Category::showOneCategory($_GET['category']);
    }

    public function allCategories(){
        return Category::showCategories();
    }

    public function addCategory(){
        return Category::addCategory($_POST['name']);
    }

    public function deleteCategory(){
        return Category::deleteCategory($_POST['id']);
    }
}