<?php 

class ProfileController {
    public function userProfile() {
        return Profile::userProfile($_GET['user']);
    }
}