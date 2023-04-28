<?php 

class Editeur {
    private $id;
    private $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
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

    public static function showEditeurs(){
        $selectEditeur = "SELECT * FROM editeur";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectEditeur);
        $stmlselect->execute();
        
        return $stmlselect->fetchAll();
    }

    public static function showOneEditeur($editeur){
        $selectEditeur = "SELECT book_edition.id, title, resume, author, editions.format, book_edition.published_at FROM `book_edition` 
        INNER Join editions ON book_edition.edition_id = editions.id 
        INNER join books ON book_edition.book_id = books.id 
        INNER JOIN editeur ON editeur_id = editeur.id
        WHERE editeur.name_editor = :editeur ";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectEditeur);
        $stmlselect->execute([':editeur' => $editeur]);

        return $stmlselect->fetchAll();
    }

    public static function addEditeur($name){
        $addEditeur = "INSERT INTO editeur (name_editor) VALUES (?)";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($addEditeur);
        $stmlselect->execute([$name]);
    }

    public static function deleteEditeur($id){
        $deleteEditeur = "DELETE FROM editeur WHERE id = (?)";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($deleteEditeur);
        $stmlselect->execute([$id]);
    }


}