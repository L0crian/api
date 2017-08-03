<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.06.2017
 * Time: 22:08
 */

namespace App;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddPhotoToProfile
{
    protected $profile;
    protected $file;


    public function __construct(Profile $profile, UploadedFile $file)
    {
        $this->profile = $profile;
        $this->file = $file;
    }

    public function save()
    {
        $photo = $this->profile->addPhoto($this->makePhoto());

        $this->file->move($photo->baseDir(), $photo->name);

    }

    public function makePhoto()
    {
        return new Photo([
            'name' => $this->makeFileName()
        ]);
    }

    public function makeFileName()
    {
        $name =  sha1(time() . $this->file->getClientOriginalName());
        $extension = $this->file->getClientOriginalExtension();

        return "{$name}.{$extension}";
    }
}