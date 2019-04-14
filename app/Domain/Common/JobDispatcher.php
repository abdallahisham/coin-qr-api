<?php

namespace App\Domain\Common;

use App\Domain\Common\Jobs\JobInterface;

class JobDispatcher
{
    public function dispatch(JobInterface $job)
    {
        $job->handle();
    }
}
