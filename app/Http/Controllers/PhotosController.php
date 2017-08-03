<?php

namespace App\Http\Controllers;

use App\AddPhotoToProfile;
use App\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\AddPhotoRequest;

class PhotosController extends ApiController
{

    public function store($id, Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|image|mimes:jpeg,png,jpg',

        ]);

        $profile = Profile::find($id);

        if (!$profile) {
            return $this->respondNotFound('Profile does not exist.');
        }

        if ($profile->owner->id !== request()->user()->id) {
            return $this->respondDeniedPermission("You don't have permission to update photo");
        }


        $photo = $request->file('photo');
        $profile->photo()->delete();

        (new AddPhotoToProfile($profile, $photo))->save();
        return $this->respond('The photo is updated');
    }
}
