<?php 

class Wishlist {
    private $id;

    public function __construct($id) {
        $this->id = $id;
    }

    // Getter / Setter pour la propriété "id"
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function showUserWishlist($name){
        $selectUserBiblio = "SELECT
                                title,
                                resume,
                                editions.name,
                                editions.format
                            FROM
                                Wishlist
                            INNER JOIN book_edition ON book_edition.id = Wishlist.edition_id
                            INNER JOIN books ON books.id = book_edition.book_id
                            INNER JOIN users ON users.id = Wishlist.users_id
                            INNER JOIN editions ON editions.id = book_edition.edition_id
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