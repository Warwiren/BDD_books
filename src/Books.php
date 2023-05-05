<?php 

// include 'MysqlDatabaseConnectionService.php';

class Books {

    public static function showBooks(){
        /** @var Cursor $cursor */
        $cursor = MongoDatabaseConnectionService::get()->selectCollection('books')->aggregate([
            [
                '$lookup' => [
                    'from' => 'comments',
                    'localField' => '_id',
                    'foreignField' => 'book_id',
                    'as' => 'avg_rate'
                ]
            ],
            // [
            //     '$group' => [
            //         '_id' => null,
            //         'averageRate' => ['$avg' => '$comments.rate'],
            //         'books' => ['$push' => '$$ROOT']
            //     ]
            // ],
            [
                '$project' => [
                    'books' =>[
                        'title'=> '$$ROOT.title',
                        'isbn' => '$$ROOT.ISBN',
                        'author'=> '$$ROOT.author', 
                        'category'=> '$$ROOT.category',
                        'resume'=> '$$ROOT.summary'
                        
                    ],
                    'avg' => ['$avg'=>'$avg_rate.rate']
                ]
            ]
        ]);
        $documents = $cursor->toArray();
        if(!count($documents)) {
            throw new Exception('book not found');
        }
        return $documents;
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
            "editions" => [
                [
                'id' => new \MongoDB\BSON\ObjectId(),
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

    public static function allCommentBook($id){
        /** @var Cursor $cursor */
        $cursor = MongoDatabaseConnectionService::get()->selectCollection('comments')->aggregate(
            [
            [
                '$match' => [
                    'book_id' => new MongoDB\BSON\ObjectID($id)
                ]
            ],
            [
                '$lookup' => [
                    'from' => 'users',
                    'localField' => 'user_id',
                    'foreignField' => '_id',
                    'as' => 'user'
                ]
            ],
            [
                '$unwind' => '$user'
            ],
            [
                '$lookup' => [
                    'from' => 'books',
                    'localField' => 'book_id',
                    'foreignField' => '_id',
                    'as' => 'book'
                ]
            ],
            // [
            //     '$group' => [
            //         '_id' => null,
            //         'averageRate' => ['$avg' => '$rate'],
            //     ]
            //     ],
            [
                '$project'=>[
                    'title' => '$book.title',
                    'author' => '$book.author',
                    'isbn' => '$book.ISBN',
                    'comment' => '$comments',
                    'user_name' => '$user.name',
                    'rate' => '$rate'
                ]
                ]

        ]);

        $documents = $cursor->toArray();
        if(!count($documents)) {
            throw new Exception('book not found');
        }
        return $documents;
    }

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