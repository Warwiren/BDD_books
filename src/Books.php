<?php 

// include 'MysqlDatabaseConnectionService.php';

class Books {
    private $id;
    private $title;
    private $resume;
    private $author;
    private $rate;

    public function __construct($id, $title, $resume, $author, $rate) {
        $this->id = $id;
        $this->title = $title;
        $this->resume = $resume;
        $this->author = $author;
        $this->rate = $rate;
    }

    // Getter / Setter pour la propriété "id"
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter / Setter pour la propriété "title"
    public function gettitle() {
        return $this->title;
    }

    public function settitle($title) {
        $this->title = $title;
    }

    // Getter / Setter pour la propriété "resume"
    public function getresume() {
        return $this->resume;
    }

    public function setresume($resume) {
        $this->title = $resume;
    }

    // Getter / Setter pour la propriété "author"
    public function getauthor() {
        return $this->author;
    }

    public function setauthor($author) {
        $this->author = $author;
    }

    // Getter / Setter pour la propriété "rate"
    public function getrate() {
        return $this->rate;
    }

    public function setrate($rate) {
        $this->rate = $rate;
    }

    public static function showBooks(){
        $selectBooks = "SELECT book_edition.id, title, resume, author, editions.format, book_edition.published_at 
        FROM `book_edition` 
        INNER Join editions ON book_edition.edition_id = editions.id 
        INNER join books ON book_edition.book_id = books.id 
        ORDER BY `book_edition`.`id` ASC";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectBooks);
        $stmlselect->execute();
        
        return $stmlselect->fetchAll();
    }

    public static function showAllBooks(){
        $selectBooks = "SELECT books.id, title, resume, author, name_category, ROUND(AVG(rate),2) as moyenne
        FROM books
        INNER join category ON books.category_id = category.id
        LEFT JOIN Comments ON books.id = Comments.book_id
        GROUP BY books.id, title, resume, author
        ORDER BY books.id DESC
        LIMIT 6";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectBooks);
        $stmlselect->execute();
        
        return $stmlselect->fetchAll();
    }

    public static function showOneBook($title){
        $selectBooks = "SELECT book_edition.id, title, resume, author, editions.format, book_edition.published_at FROM `book_edition` INNER Join editions ON book_edition.edition_id = editions.id INNER join books ON book_edition.book_id = books.id WHERE title = :title LIMIT 1";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectBooks);
        $stmlselect->execute([':title' => $title]);

        return $stmlselect->fetch();
    }

    public static function addBook($title, $category, $resume, $author, $editeur, $published){
        $addBook = "INSERT INTO books (title, category_id, resume, author, editeur_id, published_at) VALUES (?, ?, ?, ?, ?, ?)";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($addBook);
        $stmlselect->execute([$title, $category, $resume, $author, $editeur, $published]);
    }

    public static function deleteBook($id){
        $deleteBook = "DELETE FROM books WHERE id = (?)";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($deleteBook);
        $stmlselect->execute([$id]);
    }

    public static function commentBook($id){
        $commentBook = "SELECT users.name AS users_name, comments.comment, comments.rate, books.title 
        FROM comments 
        INNER JOIN users ON comments.user_id = users.id
        INNER JOIN books ON books.id = comments.book_id 
        WHERE users.id = :id";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($commentBook);
        $stmlselect->execute([':id' => $id]);

        return $stmlselect->fetchAll();
    }

    public static function allCommentBook($title){
        $allCommentBook = "SELECT users.name, comment, rate, (SELECT ROUND(AVG(rate),2) from comments where book_id = books.id) as moyenne
        FROM comments 
        INNER JOIN books ON books.id = comments.book_id 
        INNER JOIN users ON users.id = comments.user_id 
        WHERE books.title = :title
        ";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($allCommentBook);
        $stmlselect->execute([':title' => $title]);
        
        $allComment =  $stmlselect->fetchAll();



        $result = new stdClass();
        $result->title = $title;
        $result->moyenne = $allComment[0]['moyenne'];

        foreach($allComment as $index => $row) { //on déplace la colonne moyenne dans une variable $row (et vu que l'on ne l'affiche jamais beh c'est bon)
        
            unset($allComment[$index]['moyenne']);
            // $allComment[$index]['test'] = 'plouf_' . $index + 1;
        }

        // foreach($allComment as &$row){
        //     unset($row['moyenne']);
        // }


        $result->Commentaires = $allComment;
        return $result;
    }

    public static function showAuthorBook($author){
        $selectAuthor = "SELECT * FROM books WHERE books.author = :author";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectAuthor);
        $stmlselect->execute([':author' => $author]);

        return $stmlselect->fetchAll();
    }

    public static function updaterate($id, $rate, $user){
        $selectBooks = "UPDATE comments SET rate = :rate WHERE comments.id = :id AND comments.user_id = :user";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectBooks);
        $stmlselect->execute([':id' => $id, ':rate' => $rate, ':user' => $user]);

    }

    public static function addCommentBook($comment, $rate, $book, $user){
        $addBook = "INSERT INTO Comments (comment, rate, book_id, user_id)
        VALUE (:comment, :rate, :book_id, :user_id)";

        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($addBook);
        $stmlselect->execute([':comment' => $comment, ':rate' => $rate, ':book_id' => $book, ':user_id' => $user]);
    }

    public static function deleteCategoryBook($id){
        $selectBooks = "UPDATE books SET category_id = null WHERE books.id = :id";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectBooks);
        $stmlselect->execute([':id' => $id]);

    }
}