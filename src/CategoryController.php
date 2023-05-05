<?php

class CategoryController {

    public function category(){
        return Category::showByCategory($_GET['category']);
    }

    public function updateCategories(){
        return Category::updateCategories($_POST['id']);
    }

    public function addCategory(){
        return Category::addCategory($_POST['id']);
    }

    public function deleteCategory(){
        return Category::deleteCategory($_POST['bookId'], $_POST['categoryName']);
    }
}