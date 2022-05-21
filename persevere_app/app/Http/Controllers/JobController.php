<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Job};

class JobController extends Controller
{
    /**
     * Show jobs.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jobs = Job::all();
        return response()->json($jobs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2048',
        ]);

        // Create new Job instance
        $job = new Job();
        $job->name = $validatedData['name'];
        $job->description = $validatedData['description'];
        $job->save();

        return response()->json('Métier ajouté avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        return response()->json($job);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2048',
        ]);

        // Update Job
        $job->name = $validatedData['name'];
        $job->description = $validatedData['description'];
        $job->update();

        return response()->json('Métier mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return response()->json('Métier supprimé avec succès !');
    }
}
