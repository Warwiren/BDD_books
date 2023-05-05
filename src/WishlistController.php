<?php

class WishlistController {

    public function userWishlist(){
        return Wishlist::showUserWishlist();
    }

}