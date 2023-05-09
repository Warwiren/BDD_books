<?php 

class Wishlist {

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

    public static function userWishlistAdd(){
        $addBook = MongoDatabaseConnectionService::get()->selectCollection('wishlist')->updateOne(
            [
                "user_id" => new \MongoDB\BSON\ObjectId($_POST['user'])
            ],
            [
                '$addToSet' =>[
                    'wishlist'=>
                        new \MongoDB\BSON\ObjectId($_POST['book_id'])
                    
                ]
            ]
            
        );
        return $addBook;
    }

}