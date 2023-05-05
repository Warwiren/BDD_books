<?php 

class Category {

    public static function updateCategories($id){
        $updateCategory = MongoDatabaseConnectionService::get()->selectCollection('books')->updateOne(
            [
                '_id' => new MongoDB\BSON\ObjectID($id),
                'category' => $_POST['tag']
            ],
            [
                '$set' => ['category.$' => $_POST['newCategory']]
            ]
        );
    }
    //filter sur l'id + chercher dans category $_post $tags
    //$set un autre post qui remplace le tag

    public static function showByCategory($category){
        $selectCategory = MongoDatabaseConnectionService::get()->selectCollection('books')->find(
            ["category" => $category
        ],[
            'limit' => 3
        ]);

        return $selectCategory->toArray();
    }

    public static function addCategory($id){
        $addCategory = MongoDatabaseConnectionService::get()->selectCollection('books')->updateOne(
            [
                "_id"=> new \MongoDB\BSON\ObjectId("$id")
            ],
            [
                '$addToSet' => [
                    'category'=> $_POST['category']
                ]
            ]
        );
    }

    public static function deleteCategory($bookID, $categoryName){
        $result = MongoDatabaseConnectionService::get()->selectCollection('books')->updateOne(
            ['_id' => new MongoDB\BSON\ObjectID($bookID)],
            ['$pull' => ['category' => $categoryName]]
        );
    }
}