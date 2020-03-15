<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function store(Request $request) {
        Activity::create($request->all());

        return response('', 204);
    }

    public function view($job_id) {
        $activities = Activity::where('job_id', $job_id)->get();
        return json($activities);
    }
}
