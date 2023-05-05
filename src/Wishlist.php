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

    public static function showUserWishlist(){
        /** @var Cursor $cursor */
        $cursor = MongoDatabaseConnectionService::get()->selectCollection('wishlist')->aggregate([
            [
                '$match' => [
                    'user_id' => new MongoDB\BSON\ObjectID($_GET['user'])
                ]
            ],
            [
                '$lookup' => [
                    'from' => 'books',
                    'localField' => 'wishlist',
                    'foreignField' => '_id',
                    'as' => 'book'
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
                '$unwind' => '$book'
            ],
            [
                '$unwind' => '$user'
            ],
            [
                '$project' => [
                    'user' => [
                        'name' => '$user.name',
                    ],
                    'book' => [
                        'title' => '$book.title',
                        'author' => '$book.author',
                        'isbn' => '$book.ISBN'
                    ]
                ]
            ]
        ]);
        
        $documents = $cursor->toArray();
        if(!count($documents)) {
            throw new Exception('book not found');
        }
        return $documents;
    }

}