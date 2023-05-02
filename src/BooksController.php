<?php 

class BooksController {

    public function index() {
        // Afficher tous les livres
       return Books::showBooks();
    }

    // public function indexAll() {
    //     // Afficher tous les livres
    //    return Books::showAllBooks();
    // }

    public function oneBook(){
        if(isset($_GET['title'])) {
            return Books::showOneBook($_GET['title']);
        }
        return [];
    }

    // public function userBiblio(){
    //     return Users::showUserBiblio($_GET['user']);
    // }

    public function addBook() {
        return Books::addBook();
    }


    public function deleteBook() {
        return Books::deleteBook();
    }

    // public function commentBook(){
    //     return Books::commentBook($_GET['id']);
    // }

    // public function allCommentBook(){
    //     return Books::allCommentBook($_GET['title']);
    // }

    public function authorBook(){
        $author = isset($_GET['author']) ? $_GET['author'] : '';
        $books = Books::showAuthorBook($author);

        return $books;
    }

    // public function updaterate(){
    //     return Books::updaterate($_GET['id'], $_POST['rate'], $_GET['user']);
    // }

    // public function addCommentBook(){
    //     return Books::addCommentBook($_POST['comment'], $_POST['rate'], $_GET['book'], $_GET['user']);
    // }

    // public function deleteCategoryBook() {
    //     return Books::deleteCategoryBook($_POST['id']);
    // }
    
}