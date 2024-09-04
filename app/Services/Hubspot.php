<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Project;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Auth\Authenticatable;

class Hubspot
{
    private Client $client;
    private mixed $accessToken;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->client = new Client();
    }

    private function makeAPICall($url, $method, $options = [])
    {
        $options['headers']['Authorization'] = 'Bearer ' . $this->accessToken;

        // Set Content type header when JSON data is provided for POST Method
        if (isset($options['json']) && in_array(strtoupper($method), ['POST', 'PUT', "PATCH", "DELETE"])) {
            $options['headers']['content-type'] = 'application/json';
        }

        try {
            $response = $this->client->request($method, $url, $options);
            return json_decode($response->getBody()->getContents(), 1);
        } catch (GuzzleException $e) {
            $response = $e->getResponse()->getBody()->getContents();
            logError($e, 'Error in hubspot API', __METHOD__, ['url'=>$url, 'method' => $method, 'options' => $options, 'response' => $response]);
            return json_decode($response, 1);
        }
    }

    /**
     * @return void
     */
    public function listBlogs()
    {
        $url = 'https://api.hubapi.com/content/api/v2/blogs';

        return $this->makeAPICall($url, 'GET');
    }

    /**
     * @return int
     */
    public function createBlogPost(Project $project, Article $article)
    {
        $url = 'https://api.hubapi.com/content/api/v2/blog-posts';

        $user = $this->getAuthor();

        $blogContent = $this->processBlogPostContent($project, $article);
        $blogContent['blog_author_id'] = $user->hubspot_author_id;

        $response = $this->makeAPICall($url, 'POST', [
            'json' => $blogContent,
        ]);

        return $this->setHubspotBlogPostId($article, $response);
    }

    /**
     * @param Project $project
     * @param Article $article
     * @return array
     */
    private function processBlogPostContent(Project $project, Article $article)
    {
        $data = [
            'name' => $article->title,
            'post_body' => $article->content,
            'meta_description' => $article->meta_description,
            'content_group_id' => $project->hubspot_blog_id,
            'slug' => $article->getSlug(),
            'use_featured_image' => true,
            'publish_immediately' => true
        ];

        if ($article->featured_image) {
            $data['featured_image'] = retrieveFile($article->featured_image);
        }

        return $data;
    }

    /**
     * @param Article $article
     * @param $response
     * @return int
     */
    private function setHubspotBlogPostId(Article $article, $response)
    {
        $hubspotBlogPostId = $response['id'];

        $article->update(['hubspot_blog_post_id' => $hubspotBlogPostId]);

        return $hubspotBlogPostId;
    }

    /**
     * @return Authenticatable
     */
    private function getAuthor()
    {
        $authUser = auth()->user();

        if (empty($authUser->hubspot_author_id)) {
            return $this->createAuthor($authUser);
        }

        return $authUser;
    }

    private function createAuthor(Authenticatable $user, $reCheck = 0)
    {
        if (!empty($authUser->hubspot_author_id)) {
            return $user;
        }

        $url = 'https://api.hubapi.com/blogs/v3/blog-authors';

        $hubspotAuthor = $this->makeAPICall($url, 'POST', [
            'json' => [
                'email' => $user->email,
                'fullName' => $user->name,
            ]
        ]);

        if ($hubspotAuthor) {
            $user->update(['hubspot_author_id' => $hubspotAuthor['id']]);
            return $user;
        }

        if ($reCheck < 2) {
            $this->createAuthor($user, ++$reCheck);
        }

        return null;
    }

    /**
     * @param Article $article
     * @return mixed
     */
    public function publishPost(Article $article)
    {
        $hubspotBlogPostId = $article->hubspot_blog_post_id;

        if (empty($hubspotBlogPostId)) {
            $project = Project::find($article->project_id);

            $hubspotBlogPostId = $this->createBlogPost($project, $article);
        }

        $url = "https://api.hubapi.com/content/api/v2/blog-posts/$hubspotBlogPostId/publish-action";

        return $this->makeAPICall($url, 'POST', [
            'json' => [
                'action' => 'schedule-publish'
            ]
        ]);
    }

    public function updateBlogPost(Project $project, Article $article)
    {
        $url = 'https://api.hubapi.com/content/api/v2/blog-posts/' . $article->hubspot_blog_post_id;

        $user = $this->getAuthor();

        $blogContent = $this->processBlogPostContent($project, $article);
        $blogContent['blog_author_id'] = $user->hubspot_author_id;

        $response = $this->makeAPICall($url, 'PUT', [
            'json' => $blogContent,
        ]);

        return $this->setHubspotBlogPostId($article, $response);
    }

    public function deletePost(Article $article)
    {
        $url = 'https://api.hubapi.com/content/api/v2/blog-posts/' . $article->hubspot_blog_post_id;

        return $this->makeAPICall($url, 'DELETE');
    }
}
