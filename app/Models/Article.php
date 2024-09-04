<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public const DRAFT = 'draft';
    public const SCHEDULED = 'scheduled';
    public const PUBLISHED = 'published';

    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'project_id',
        'user_id',
        'meta_title',
        'meta_description',
        'featured_image',
    ];

    public static function syncWithHubspot(Project $project, Article $article)
    {
        // TODO:
        if ($project->ishubspotIntegrated()) {

        }
    }
}
