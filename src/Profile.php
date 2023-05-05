<?php 

// include 'MysqlDatabaseConnectionService.php';

use MongoDB\Driver\Cursor;
use MongoDB\Model\BSONArray;

class Profile {

    public static function userProfile(){

        /** @var Cursor $cursor */
        $cursor = MongoDatabaseConnectionService::get()->selectCollection('users')->aggregate([
                [
                    '$match' => [
                        'name' => $_GET['user']
                    ]
                ],
                [
                    '$lookup' => [
                        'from' => 'editions',
                        'localField' => 'librairy.edition_id',
                        'foreignField' => '_id',
                        'as' => 'editions'
                    ]
                ],
                [
                    '$lookup' => [
                        'from' => 'books',
                        'localField' => 'editions.book_id',
                        'foreignField' => '_id',
                        'as' => 'books'
                    ]
                ],

            ]);
        $documents = $cursor->toArray();
        if(!count($documents)) {
            throw new Exception('User not found');
        }

        $document = $documents[0];
       
        $editions = (array) $document->editions;
        $books = (array) $document->books;

        foreach ($document->librairy as $item) {
            $found = array_filter($editions, function($edition) use($item) {
                return $edition['_id'] == $item->edition_id;
            });

            if(count($found)) {
                $edition = current($found); // Récupere le premier élément dans $found
                
                // Même chose mais filtrer $books
                $foundBooks = array_filter($books, function($book) use($edition) {
                    return $book['_id'] == $edition->book_id;
                });

                $edition->book = current($foundBooks);
                unset($edition->book_id);
                $item->edition = $edition;
                // Equivalent à 
                // $item->edition_id = array_values($found)[0];
            }
        }
        unset($document->editions, $document->books);
        return $document;

    }
}