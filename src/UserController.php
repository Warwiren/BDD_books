<?php

class UserController {

    public function userBiblio(){
        return Users::showUserBiblio($_GET['user']);
    }

}