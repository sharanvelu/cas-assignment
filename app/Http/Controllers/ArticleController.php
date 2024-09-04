<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Article;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $articles = Article::query()
            ->where('project_id', $project->id)
            ->get();

        return view('articles.index', compact('project', 'articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('articles.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleCreateRequest $request, Project $project)
    {
        DB::beginTransaction();
        try {
            $article = Article::create([
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'status' => Article::DRAFT,
                'project_id' => $project->id,
                'user_id' => auth()->id(),
                'meta_description' => $request->get('meta_description'),
                'featured_image' => storeFile('featured_image', 'articles/featured_image'),
            ]);

            Article::syncWithHubspot($project, $article);

            DB::commit();
            return redirect()->route('articles.show', compact('project', 'article'))
                ->with('success', 'Article Draft created successfully.');
        } catch (\Exception $exception) {
            DB::rollBack();
            logError($exception, 'Error while creating Article Draft', __METHOD__, ['req' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Error while creating Article Draft');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Article $article)
    {
        if ($article->project_id != $project->id) {
            abort(404);
        }

        return view('articles.show', compact('project', 'article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Article $article)
    {
        if ($article->project_id != $project->id) {
            abort(404);
        }

        return view('articles.edit', compact('project', 'article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleUpdateRequest $request, Project $project, Article $article)
    {
        if ($article->project_id != $project->id) {
            abort(404);
        }

        DB::beginTransaction();
        try {
            $updateData = [
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'project_id' => $project->id,
                'user_id' => auth()->id(),
                'meta_description' => $request->get('meta_description'),
            ];

            if ($request->hasFile('featured_image')) {
                $updateData['featured_image'] = storeFile('featured_image', 'articles/featured_image');
            }

            $article->update($updateData);

            Article::syncWithHubspot($project, $article);

            DB::commit();
            return redirect()->route('articles.index', compact('project'))
                ->with('success', 'Article updated successfully.');
        } catch (\Exception $exception) {
            DB::rollBack();
            logError($exception, 'Error while updating Article', __METHOD__, ['req' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Error while updating Article');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Article $article)
    {
        if ($article->project_id != $project->id) {
            abort(404);
        }

        try {
            $article->delete();

            Article::deleteWithHubspot($project, $article);

            return redirect()->route('articles.index', compact('project'))
                ->with('success', 'Article deleted successfully');
        } catch (\Exception $exception) {
            logError($exception, 'Error while deleting Article', __METHOD__);
            return redirect()->route('articles.index', compact('project'))
                ->with('success', 'Unable to delete Article');
        }
    }

    /**
     * @param Project $project
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish(Project $project, Article $article)
    {
        if ($article->project_id != $project->id) {
            abort(404);
        }

        if ($article->status !== Article::DRAFT) {
            return redirect()->back()->with('error', 'This article is already published.');
        }

        $article->update(['status' => Article::PUBLISHED]);

        Article::publishWithHubspot($project, $article);

        return redirect()->route('articles.show', compact('project', 'article'))->with('success', 'Article published successfully');
    }
}
