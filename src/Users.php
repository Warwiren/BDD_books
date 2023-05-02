<?php 

class Users {

    public static function showUserBiblio($userID){
        $selectUserBiblio = MongoDatabaseConnectionService::get()->selectCollection('books');

        $cursor = $selectUserBiblio->find([
            "user_id" => $userID
        ], [
            // 'limit' => 10,
            // 'skip' => 0
        ]);

        return $cursor->toArray();
    }

}