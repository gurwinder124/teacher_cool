<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    public const CONTENT_CATEGORY_IT = 1;
    public const CONTENT_CATEGORY_NON_IT = 2;
    
    public static function getContentCategory()
    {
        return [
            ['value'=>static::CONTENT_CATEGORY_IT, 'name' => "IT"],
            ['value'=>static::CONTENT_CATEGORY_NON_IT, 'name' =>  "Non-IT"],
        ];
    }
}
