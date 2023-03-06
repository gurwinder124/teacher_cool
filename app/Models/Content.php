<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    public const CONTENT_CATEGORY_BOTH = 0;
    public const CONTENT_CATEGORY_IT = 1;
    public const CONTENT_CATEGORY_NON_IT = 2;

    public const CONTENT_PENDING = 1;
    public const CONTENT_APPROVE = 2;
    public const CONTENT_DISAPPROVE = 3;
    
    
    public static function getContentCategory()
    {
        return [
            ['value'=>static::CONTENT_CATEGORY_IT, 'name' => "IT"],
            ['value'=>static::CONTENT_CATEGORY_NON_IT, 'name' =>  "Non-IT"],
        ];
    }

    public static function getContentStatus()
    {
        return [
            ['value'=>static::CONTENT_APPROVE, 'name' => "Approve"],
            ['value'=>static::CONTENT_DISAPPROVE, 'name' =>  "disapprove"],
        ];
    }
}
