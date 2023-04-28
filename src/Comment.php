<?php 

class Editeur {
    private $id;
    private $comment;
    private $rate;

    public function __construct($id, $comment, $rate) {
        $this->id = $id;
        $this->comment = $comment;
        $this->rate = $rate;
    }

    // Getter / Setter pour la propriété "id"
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter / Setter pour la propriété "comment"
    public function getcomment() {
        return $this->comment;
    }

    public function setcomment($comment) {
        $this->comment = $comment;
    }

    // Getter / Setter pour la propriété "rate"
    public function getrate() {
        return $this->rate;
    }

    public function setrate($rate) {
        $this->rate = $rate;
    }

}