<?php

namespace App\Library;

use Exception;

class Lockable
{
    /**
     * Get exclusive lock.
     */
    private $file;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            touch($file);
        }

        $this->file = $file;
    }

    /**
     * Get exclusive lock.
     *
     * @param mixed $callback
     * @param mixed $timeout
     * @param mixed|null $timeoutCallback
     */
    public function getExclusiveLock($callback, $timeout = 15, $timeoutCallback = null)
    {
        $start = time();
        $reader = fopen($this->file, 'r+');
        try {
            while (true) {
                // raise an exception and quit if timed out
                if ($this->isTimeout($start, $timeout)) {
                    if (is_null($timeoutCallback)) {
                        throw new Exception('Timeout getting lock #Lockable for: ' . $this->file);
                    } else {
                        $timeoutCallback();
                        break;
                    }
                }

                if (flock($reader, LOCK_EX | LOCK_NB)) {  // acquire an exclusive lock
                    // execute the callback
                    $callback($reader);
                    break;
                }
            }
        } finally {
            fflush($reader);
            flock($reader, LOCK_UN);    // release the lock
            fclose($reader);
        }
    }

    /**
     * Check for timeout.
     *
     * @param mixed $startTime
     * @param mixed $timeoutDuration
     */
    public function isTimeout($startTime, $timeoutDuration)
    {
        return time() - $startTime > $timeoutDuration;
    }

    /**
     * Get shared lock.
     *
     * @param mixed $callback
     * @param mixed $timeout
     * @param mixed|null $timeoutCallback
     */
    public function getSharedLock($callback, $timeout = 5, $timeoutCallback = null)
    {
        $start = time();
        $reader = fopen($this->file, 'r');
        while (true) {
            // raise an exception and quit if timed out
            if ($this->isTimeout($start, $timeout)) {
                if (is_null($timeoutCallback)) {
                    throw new Exception('Timeout getting lock #Lockable for: ' . $this->file);
                } else {
                    $timeoutCallback();
                    break;
                }
            }

            if (flock($reader, LOCK_SH | LOCK_NB)) {  // acquire an exclusive lock
                // execute the callback
                $callback($this);

                flock($reader, LOCK_UN);    // release the lock
                fclose($reader);
                break;
            }
        }
    }
}
