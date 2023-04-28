<?php 

class Users {
    private $id;
    private $name;
    private $password;

    public function __construct($id, $name, $password) {
        $this->id = $id;
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

    public static function showUserBiblio($name){
        $selectUserBiblio = "SELECT
                                title,
                                resume,
                                editions.name,
                                editions.format,
                                reading_status.status
                            FROM
                                biblio
                            INNER JOIN book_edition ON book_edition.id = biblio.edition_id
                            INNER JOIN books ON books.id = book_edition.book_id
                            INNER JOIN users ON users.id = biblio.users_id
                            INNER JOIN editions ON editions.id = book_edition.edition_id
                            INNER JOIN reading_status ON reading_status.edition_id = book_edition.id
                            WHERE users.name  = :username";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectUserBiblio);
        $stmlselect->execute([':username' => $name]);

        $userBiblio = $stmlselect->fetchAll();
        $result = new stdClass();
        $result->name = $name;
        $result->bibliotheque = $userBiblio;

        return $result;
    }

}