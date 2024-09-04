<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ProjectIntegration extends Model
{
    use HasFactory;

    public const HUBSPOT = 'hubspot';

    protected $fillable = [
        'project_id',
        'user_id',
        'type',
        'value',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    /**
     * Get the user's first name.
     */
    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Crypt::decrypt($value),
            set: fn (string $value) => Crypt::encrypt($value),
        );
    }
}
