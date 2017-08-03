<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'city',
        'country',
        'information'
    ];


    public function addPhoto(Photo $photo)
    {
        return $this->photo()->save($photo);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function photo()
    {
        return $this->hasOne(Photo::class, 'profile_id');
    }

}
