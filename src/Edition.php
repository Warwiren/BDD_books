<?php 

class Edition {
    private $id;
    private $name;
    private $format;

    public function __construct($id, $name, $format) {
        $this->id = $id;
        $this->name = $name;
        $this->format = $format;
    }

    // Getter / Setter pour la propriété "id"
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter / Setter pour la propriété "name"
    public function getname() {
        return $this->name;
    }

    public function setname($name) {
        $this->name = $name;
    }

    // Getter / Setter pour la propriété "format"
    public function getformat() {
        return $this->format;
    }

    public function setformat($format) {
        $this->format = $format;
    }

    public static function showEditions(){
        $selectEdition = "SELECT * FROM editions";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectEdition);
        $stmlselect->execute();
        
        return $stmlselect->fetchAll();
    }

    public static function showOneEdition($edition){
        $selectEdition = "SELECT book_edition.id, title, resume, author, editions.format, book_edition.published_at FROM `book_edition` INNER Join editions ON book_edition.edition_id = editions.id INNER join books ON book_edition.book_id = books.id WHERE editions.name = :edition ";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectEdition);
        $stmlselect->execute([':edition' => $edition]);

        return $stmlselect->fetchAll();
    }

    public static function addEdition($name, $format){
        $addEdition = "INSERT INTO editions (name, format) VALUES (?, ?)";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($addEdition);
        $stmlselect->execute([$name, $format]);
    }

    public static function deleteEdition($id){
        $deleteEdition = "DELETE FROM editions WHERE id = (?)";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($deleteEdition);
        $stmlselect->execute([$id]);
    }
}