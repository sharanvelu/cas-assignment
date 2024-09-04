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
        return !empty($this->getHubspotIntegrations());
    }
}
