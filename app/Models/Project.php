<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * Fillable Property of the Model.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'url',
        'user_id'
    ];
}
