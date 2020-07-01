<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;

class VkInfoData extends DataTransferObject
{
    public $access_token;
    public $email;
    public $expires_in;
    public $https_required;
    public $secret;
    public $user_id;
}