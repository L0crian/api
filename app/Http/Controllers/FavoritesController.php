<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use App\User;
use Illuminate\Http\Request;

class FavoritesController extends ApiController
{


    public function store(User $user)
    {
        $user->favorite();

        return $this->respond('User was liked');
    }

    public function destroy(User $user)
    {
        $user->unfavorite();

        return $this->respond('The like was deleted');
    }
}
