<?php 

// include 'MysqlDatabaseConnectionService.php';

class Books {

    public static function showBooks(){
        $selectAll = MongoDatabaseConnectionService::get()->selectCollection('books')->find([]);
        return $selectAll;
    }

    // public static function showAllBooks(){
    //     $selectBooks = "SELECT books.id, title, resume, author, name_category, ROUND(AVG(rate),2) as moyenne
    //     FROM books
    //     INNER join category ON books.category_id = category.id
    //     LEFT JOIN Comments ON books.id = Comments.book_id
    //     GROUP BY books.id, title, resume, author
    //     ORDER BY books.id DESC
    //     LIMIT 6";
    //     $pdo = MysqlDatabaseConnectionService::get();
    //     $stmlselect = $pdo->prepare($selectBooks);
    //     $stmlselect->execute();
        
    //     return $stmlselect->fetchAll();
    // }

    public static function showOneBook($bookTitle){
        $selectOne = MongoDatabaseConnectionService::get()->selectCollection('books')->findOne(["title" => $bookTitle]);
        return $selectOne;
    }

    public static function addBook(){
        $addBook = MongoDatabaseConnectionService::get()->selectCollection('books')->insertOne([
            "title" => $_POST['title'],
            "author" => $_POST['author'],
            "category" => [$_POST['category']],
            "summary" => $_POST['summary'],
            "ISBN" => $_POST['isbn'],
            "user_id" => $_POST['user_id'],
            "editions" => [
                [
                'id' => $_POST['editionId'],
                'publisher' => $_POST['publisher'],
                'publicationDate' => $_POST['publicationDate'],
                'language' => $_POST['language'],
                ]
            ]
        ]);
        return $addBook;
    }

    public static function deleteBook(){
        $deleteBook = MongoDatabaseConnectionService::get()->selectCollection('books')->deleteOne([
            "_id" => new MongoDB\BSON\ObjectID($_POST['id'])
          ]);
        return $deleteBook;
    }

    // public static function commentBook($id){
    //     $commentBook = "SELECT users.name AS users_name, comments.comment, comments.rate, books.title 
    //     FROM comments 
    //     INNER JOIN users ON comments.user_id = users.id
    //     INNER JOIN books ON books.id = comments.book_id 
    //     WHERE users.id = :id";
    //     $pdo = MysqlDatabaseConnectionService::get();
    //     $stmlselect = $pdo->prepare($commentBook);
    //     $stmlselect->execute([':id' => $id]);

    //     return $stmlselect->fetchAll();
    // }

    // public static function allCommentBook($title){
    //     $allCommentBook = "SELECT users.name, comment, rate, (SELECT ROUND(AVG(rate),2) from comments where book_id = books.id) as moyenne
    //     FROM comments 
    //     INNER JOIN books ON books.id = comments.book_id 
    //     INNER JOIN users ON users.id = comments.user_id 
    //     WHERE books.title = :title
    //     ";
    //     $pdo = MysqlDatabaseConnectionService::get();
    //     $stmlselect = $pdo->prepare($allCommentBook);
    //     $stmlselect->execute([':title' => $title]);
        
    //     $allComment =  $stmlselect->fetchAll();



    //     $result = new stdClass();
    //     $result->title = $title;
    //     $result->moyenne = $allComment[0]['moyenne'];

    //     foreach($allComment as $index => $row) { //on déplace la colonne moyenne dans une variable $row (et vu que l'on ne l'affiche jamais beh c'est bon)
        
    //         unset($allComment[$index]['moyenne']);
    //         // $allComment[$index]['test'] = 'plouf_' . $index + 1;
    //     }

    //     // foreach($allComment as &$row){
    //     //     unset($row['moyenne']);
    //     // }


    //     $result->Commentaires = $allComment;
    //     return $result;
    // }

    public static function showAuthorBook($author){
        $collection =  MongoDatabaseConnectionService::get()->selectCollection('books');

        // $count = $collection->countDocuments([
        //     "author" => $author
        // ]);

        $cursor = $collection->find([
            "author" => $author
        ], [
            'limit' => 10,
            'skip' => 0
        ]);


        return $cursor->toArray();
    }

    // public static function updaterate($id, $rate, $user){
    //     $selectBooks = "UPDATE comments SET rate = :rate WHERE comments.id = :id AND comments.user_id = :user";
    //     $pdo = MysqlDatabaseConnectionService::get();
    //     $stmlselect = $pdo->prepare($selectBooks);
    //     $stmlselect->execute([':id' => $id, ':rate' => $rate, ':user' => $user]);

    // }

    // public static function addCommentBook($comment, $rate, $book, $user){
    //     $addBook = "INSERT INTO Comments (comment, rate, book_id, user_id)
    //     VALUE (:comment, :rate, :book_id, :user_id)";

    //     $pdo = MysqlDatabaseConnectionService::get();
    //     $stmlselect = $pdo->prepare($addBook);
    //     $stmlselect->execute([':comment' => $comment, ':rate' => $rate, ':book_id' => $book, ':user_id' => $user]);
    // }

    // public static function deleteCategoryBook($id){
    //     $selectBooks = "UPDATE books SET category_id = null WHERE books.id = :id";
    //     $pdo = MysqlDatabaseConnectionService::get();
    //     $stmlselect = $pdo->prepare($selectBooks);
    //     $stmlselect->execute([':id' => $id]);

    // }
}