<?php

namespace App\Observers;

use App\Job;
use App\Activity;

use Auth;

class JobObserver
{
    /**
     * Handle the job "created" event.
     *
     * @param  \App\Job  $job
     * @return void
     */
    public function created(Job $job)
    {

    }

    /**
     * Handle the job "updated" event.
     *
     * @param  \App\Job  $job
     * @return void
     */
    public function updated(Job $job)
    {
        
    }

    /**
     * Handle the job "updating" event.
     *
     * @param  \App\Job  $job
     * @return void
     */
    public function updating(Job $job)
    {
        $user = Auth::user();

        if ($job->isDirty('status')) {
            Activity::create([
                'job_id' => $job->id,
                'user_id' => $user->id,
                'type' => 'status_change',
                'from' => $job->getOriginal('status'),
                'to' => $job->status
            ]);
        }
    }

    /**
     * Handle the job "deleted" event.
     *
     * @param  \App\Job  $job
     * @return void
     */
    public function deleted(Job $job)
    {
        //
    }

    /**
     * Handle the job "restored" event.
     *
     * @param  \App\Job  $job
     * @return void
     */
    public function restored(Job $job)
    {
        //
    }

    /**
     * Handle the job "force deleted" event.
     *
     * @param  \App\Job  $job
     * @return void
     */
    public function forceDeleted(Job $job)
    {
        //
    }
}
