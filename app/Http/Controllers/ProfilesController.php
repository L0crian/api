<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Transformers\ProfileTransformer;
use Illuminate\Http\Request;

class ProfilesController extends ApiController
{
    protected $profileTransformer;

    public function __construct(ProfileTransformer $profileTransformer)
    {
        $this->profileTransformer = $profileTransformer;

        $this->middleware('auth:api');
    }



    public function show($id)
    {

        $profile = Profile::find($id);

        if (!$profile) {
            return $this->respondNotFound('Profile does not exist.');
        }

        if ($profile->owner->id !== request()->user()->id) {
            return $this->respondDeniedPermission("You don't have permission to see this profile");
        }

        return $this->respond([
            'data' => $this->profileTransformer->transform($profile)
        ]);
    }
}
