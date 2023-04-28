<?php 

// include 'MysqlDatabaseConnectionService.php';

class Profile {
    private $id;
    private $title;
    private $resume;
    private $author;
    private $rate;
    private $name;
    private $password;

    public function __construct($id, $title, $resume, $author, $rate, $name, $password) {
        $this->id = $id;
        $this->title = $title;
        $this->resume = $resume;
        $this->author = $author;
        $this->rate = $rate;
        $this->name = $name;
        $this->password = $password;
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

    // Getter / Setter pour la propriété "name"
    public function getname() {
        return $this->name;
    }

    public function setname($name) {
        $this->name = $name;
    }

    // Getter / Setter pour la propriété "password"
    public function getpassword() {
        return $this->password;
    }

    public function setpassword($password) {
        $this->password = $password;
    }

    public static function userProfile($name){

        $selectBooks = "SELECT reading_status.status, count(*) as nb 
        from  
        biblio
        INNER JOIN book_edition ON book_edition.id = biblio.edition_id
        INNER JOIN books ON books.id = book_edition.book_id
        INNER JOIN users ON users.id = biblio.users_id
        INNER JOIN editions ON editions.id = book_edition.edition_id
        INNER JOIN reading_status ON reading_status.edition_id = book_edition.id
        WHERE users.name = :username GROUP BY reading_status.status";
    //     $selectBooks = "SELECT
    //     COUNT(*) AS 'nombre de Livre',
    //     COUNT(if(reading_status.status = 'finish', 1, null)) AS 'Livres lus',
    //     sum(if(reading_status.status = 'in progress', 1, 0)) AS 'Livres en cours'
    // FROM
    //     biblio


    $pdo = MysqlDatabaseConnectionService::get();
    $stmlselect = $pdo->prepare($selectBooks);
    $stmlselect->execute([':username' => $name]);

    $userBiblio = $stmlselect->fetchAll();
    $result = new stdClass();
    $result->name = $name;
    $result->bibliotheque = $userBiblio;
    $totalBooks = 0;
   
    foreach($userBiblio as $data) { 
        $totalBooks += $data['nb'];
    
    }

    $result->total = $totalBooks;
    // $result->bibliotheque[] = [
    //     'total' => $totalBooks
    // ];
   

    return $result;
    }
}