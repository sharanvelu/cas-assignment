<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::query()
            ->where('user_id', auth()->id())
            ->get();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectCreateRequest $request)
    {
        try {
            Project::create([
                'name' => $request->get('name'),
                'url' => $request->get('url'),
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('projects.index')->with('success', 'Project created successfully.');
        } catch (\Exception $exception) {
            logError($exception, 'Error while storing project', __METHOD__, ['request' => $request->all()]);
            return redirect()->back('422')->with('error', 'Unable to create Project. Please try after sometime.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        try {
            $project->update([
                'name' => $request->get('name'),
                'url' => $request->get('url'),
            ]);

            return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
        } catch (\Exception $exception) {
            logError($exception, 'Error while updating project', __METHOD__, ['request' => $request->all()]);
            return redirect()->back('422')->with('error', 'Unable to update Project. Please try after sometime.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();

            return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
        } catch (\Exception $exception) {
            logError($exception, 'Error while updating project', __METHOD__);
            return redirect()->back('422')->with('error', 'Unable to delete Project. Please try after sometime.');
        }
    }
}
