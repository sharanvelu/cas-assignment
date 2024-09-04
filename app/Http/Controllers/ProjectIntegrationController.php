<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectIntegration;
use Illuminate\Http\Request;

class ProjectIntegrationController extends Controller
{
    public function index(Project $project)
    {
        $projectIntegration = ProjectIntegration::query()
            ->where('project_id', $project->id)
            ->where('type', ProjectIntegration::HUBSPOT)
            ->first();

        return view('projects.integrations.index', compact('project', 'projectIntegration'));
    }

    public function update(Project $project, Request $request)
    {
        $projectIntegration = ProjectIntegration::query()
            ->where('project_id', $project->id)
            ->where('type', ProjectIntegration::HUBSPOT)
            ->first();

        if ($projectIntegration) {
            $projectIntegration->update([
                'value' => $request->get('api_key'),
            ]);

            return redirect()->route('projects.integrations.index', compact('project'))
                ->with('success', 'Integration updated successfully');
        }

        ProjectIntegration::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'type' => ProjectIntegration::HUBSPOT,
            'value' => $request->get('api_key'),
        ]);

        return redirect()->route('projects.integrations.index', ['project' => $project])
            ->with('success', 'Integration updated successfully');
    }
}
