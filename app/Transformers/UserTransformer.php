<?php
namespace App\Transformers;

use Carbon\Carbon;

class UserTransformer extends Transformer{

    public function transform($user)
    {
        return [
            'name' => $user['name'],
            'last_name' => $user['last_name'],
            'registration_date' => $user['created_at']->toFormattedDateString()
        ];
    }
}