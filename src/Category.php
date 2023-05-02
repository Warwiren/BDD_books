<?php 

class Category {
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

    public static function showCategories(){
        $selectCategory = "SELECT * FROM category";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($selectCategory);
        $stmlselect->execute();
        
        return $stmlselect->fetchAll();
    }

    public static function showOneCategory($category){
        $selectCategory = 

        return $stmlselect->fetchAll();
    }

    public static function addCategory($name){
        $addCategory = "INSERT INTO category (name_category) VALUES (?)";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($addCategory);
        $stmlselect->execute([$name]);
    }

    public static function deleteCategory($id){
        $deleteCategory = "DELETE FROM category WHERE id = (?)";
        $pdo = MysqlDatabaseConnectionService::get();
        $stmlselect = $pdo->prepare($deleteCategory);
        $stmlselect->execute([$id]);
    }

}