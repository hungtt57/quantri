<?php

namespace App\Http;

use Auth;
use Hash;

class CustomValidator {
    public function validateOldPassword($attribute, $value, $parameters, $validator)
    {
    	return Hash::check($value, Auth::user()->password);
    }
}