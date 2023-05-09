<?php

class WishlistController {

    public function userWishlist(){
        return Wishlist::showUserWishlist();
    }

    public function userWishlistAdd(){
        return Wishlist::userWishlistAdd();
    }

}