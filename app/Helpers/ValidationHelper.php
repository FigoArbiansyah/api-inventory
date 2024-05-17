<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;

class ValidationHelper
{
    public static function validate($validatedData)
    {
        if ($validatedData->fails()) {
            return ResponseHelper::error(
                'Request tidak valid',
                422,
                $validatedData->errors(),
            );
        }

        return null;
    }
}
