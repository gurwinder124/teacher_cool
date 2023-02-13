<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    public const ASSIGNMENT_STATUS_PENDING = 1;
    public const ASSIGNMENT_STATUS_SUBMITTED = 2;
    public const ASSIGNMENT_STATUS_APPROVED = 3;


    public static function assignmentStatus()
    {
        return [
            ['value'=>static::ASSIGNMENT_STATUS_PENDING, 'name' => "Pending"],
            ['value'=>static::ASSIGNMENT_STATUS_SUBMITTED, 'name' =>  "Submitted"],
            ['value'=>static::ASSIGNMENT_STATUS_APPROVED, 'name' =>  "Approved"],
        ];
    }
}
