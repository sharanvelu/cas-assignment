<?php

namespace App\Models;

use App\Services\Hubspot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'hubspot_blog_post_id',
        'meta_title',
        'meta_description',
        'featured_image',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        $slug = $this->title;

        if (is_null($slug)) {
            $slug = Str::random('15');
        }

        $slug = substr($slug, 0, 10);
        $slug = str_replace('-', '_', $slug);
        $slug = str_replace(' ', '_', $slug);
        return strtolower($slug);
    }

    public static function syncWithHubspot(Project $project, Article $article)
    {
        if ($project->ishubspotIntegrated()) {
            $hubspot = new Hubspot($project->getHubspotIntegrationAccessKey());
            if (is_null($article->hubspot_blog_post_id)) {
                $hubspot->createBlogPost($project, $article);
            } else {
                $hubspot->updateBlogPost($project, $article);
            }

            return true;
        }

        session()->flash('error', 'Hubspot not integrated for this project');
        return false;
    }

    public static function publishWithHubspot(Project $project, Article $article)
    {
        if ($project->ishubspotIntegrated()) {
            $hubspot = new Hubspot($project->getHubspotIntegrationAccessKey());

            $hubspot->publishPost($article);
        }
    }

    public static function deleteWithHubspot(Project $project, Article $article)
    {
        if ($project->ishubspotIntegrated()) {
            $hubspot = new Hubspot($project->getHubspotIntegrationAccessKey());

            $hubspot->deletePost($article);
        }
    }
}
