<?php
namespace App\Transformers;


class ProfileTransformer extends Transformer{

    public function transform($profile)
    {
        return [
            'city' => $profile['city'],
            'country' => $profile['country'],
            'about' => $profile['about']
        ];
    }
}
