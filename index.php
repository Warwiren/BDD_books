<?php
include_once 'src/bootstrap.php';

$url = parse_url($_SERVER['REQUEST_URI'])['path'];

// Définition des routes
$routes = [
    '/books' => [BooksController::class, 'index'], //liste des livres   + commentaires  + moyenne                             -> mongo done <!>
    '/books/search' => [BooksController::class, 'oneBook'], //rechercher un livre par son titre                              -> mongo done <!>
    '/books/add' => [BooksController::class, 'addBook'], // ajouter un livre                                                 -> mondo done <!>
    '/books/delete' => [BooksController::class, 'deleteBook'], //supprimer un livre                                          -> mondo done <!>
    // '/books/comment' => [BooksController::class, 'commentBook'], //voir un commentaire
    // '/books/addcomment' => [BooksController::class, 'addCommentBook'], //ajouter un commentaire et une note à un livre
    '/books/allcomment' => [BooksController::class, 'allCommentBook'], //tous les commentaires + notes d'un livre            -> mondo done <!>
    '/books/author' => [BooksController::class, 'authorBook'], // les livres d'un auteur                                     -> mondo done <!>
    // '/books/updaterate' => [BooksController::class, 'updaterate'], //Modifie une note d'un commentaire
    // '/books/deletecategory' => [BooksController::class, 'deleteCategoryBook'], // Supprimer la catégory d'un livre

    // Lié à l'édition
    '/editions' => [EditionController::class, 'allEdition'],
    '/edition' => [EditionController::class, 'edition'],
    '/edition/add' => [EditionController::class, 'addEdition'],
    '/edition/delete' => [EditionController::class, 'deleteEdition'],

    // Lié à l'éditeur
    // '/editeurs' => [EditeurController::class, 'allEditeur'],
    // '/editeur' => [EditeurController::class, 'editeur'],
    // '/editeur/add' => [EditeurController::class, 'addEditeur'],
    // '/editeur/delete' => [EditeurController::class, 'deleteEditeur'],

    // Lié à la catégorie
    '/category' => [CategoryController::class, 'category'],                                                  //             -> mondo done <!>
    '/category/update' => [CategoryController::class, 'updateCategories'],                                   //             -> mondo done <!>
    '/category/add' => [CategoryController::class, 'addCategory'],                                           //             -> mondo done <!>
    '/category/delete' => [CategoryController::class, 'deleteCategory'],                                     //             -> mondo done <!>

    // '/biblio' => [UserController::class, 'userBiblio'], //bibliothèque d'un utilisateur
    '/wishlist' => [WishlistController::class, 'userWishlist'], // Wishlist d'un utilisateur                 //             -> mondo done <!>
    '/profile' => [ProfileController::class, 'userProfile'], //Affiche les stats d'un utilisateur                              -> mondo done <!>



];
try {
    // var_dump(MongoDatabaseConnectionService::get()->selectCollection('books')->findOne());
    // exit();
    $router = new Router();
    $data = $router->handle($url, $routes);
    header("Content-type: application/json; charset=utf-8");

    echo json_encode($data);

    // iterator_to_array
    // echo $data;
} 
// catch(PDOException $e) {

// }
catch(\Exception $e) {
    echo $e->getMessage();
}
