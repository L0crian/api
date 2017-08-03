<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'profile_photos';

    protected $fillable = ['path', 'name'];


    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->path = $this->baseDir() . '/' . $name;
    }


    public function baseDir()
    {
        return 'images/photos';
    }

    public function delete()
    {
        \File::delete([
            $this->path,
        ]);

        parent::delete();
    }
}
