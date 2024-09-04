<?php

namespace App\Models;

use App\Services\Hubspot;
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
        'user_id',
        'hubspot_blog_id',
    ];

    public function integrations()
    {
        return $this->hasMany(ProjectIntegration::class, 'project_id', 'id');
    }

    public function getHubspotIntegrations()
    {
        return $this->integrations()->where('type', ProjectIntegration::HUBSPOT)->latest()->first();
    }

    /**
     * @return void
     */
    public function getHubspotIntegrationAccessKey()
    {
        return $this->getHubspotIntegrations()?->value;
    }

    /**
     * @return true
     */
    public function isHubspotIntegrated()
    {
        $isEnabled = !empty($this->getHubspotIntegrations());

        if ($isEnabled && empty($this->hubspot_blog_id)) {
            $hubspot = new Hubspot($this->getHubspotIntegrationAccessKey());

            $blogsList = $hubspot->listBlogs();
            $blogsList = $blogsList['objects'] ?? [];

            if (isset($blogsList[0]) && isset($blogsList[0]['id'])) {
                $this->update(['hubspot_blog_id' => $blogsList[0]['id']]);
            }
        }

        return $isEnabled;
    }
}
