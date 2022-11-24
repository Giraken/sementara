<?php

namespace App\Library\Traits;

use App\Models\JobMonitor;

trait Trackable
{
    public $monitor;

    public $eventAfterDispatched;

    public $eventAfterFinished;

    public function setMonitor(JobMonitor $monitor)
    {
        $this->monitor = $monitor;
    }

    public function afterDispatched($callback)
    {
        $this->eventAfterDispatched = $callback;
    }

    public function afterFinished($callback)
    {
        $this->eventAfterFinished = $callback;
    }
}
