<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Activity;
use App\User;
use Auth;

class JobsController extends Controller
{
    public function update(Request $request, $id) {
        $job = Job::findOrFail($id);
        // dd($request);
        $job->status = $request->get('status');
        $job->save();

        return response('', 204);
    }

    public function send_notification(Request $request, $id) {
        $job = Job::with('customer', 'activities')->find($id);
        $type = "";
        
        if ($request->get('sms')) $type = 'SMS';
        if ($request->get('email')) $type = 'Email';

        Activity::create([
            'type' => 'notification',
            'user_id' => Auth::user()->id,
            'to' => $type,
            'job_id' => $id
        ]);

        return response($job);
    }
}
