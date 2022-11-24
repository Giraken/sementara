<?php

namespace App\Library;

use Swift_SmtpTransport;

class ExtendedSmtpTransport extends Swift_SmtpTransport
{
    /**
     * Array used to store raw SMTP responses.
     */
    private $rawResponses = [];

    private $rawTrasmissionData = [];

    /**
     * Overwrite the initialization method.
     *
     * @param mixed $host
     * @param mixed $port
     * @param mixed|null $security
     * @return mixed
     */
    public static function newInstance($host = 'localhost', $port = 25, $security = null)
    {
        return new self($host, $port, $security);
    }

    /**
     * Overwrite the execute method.
     *
     * @param mixed $command
     * @param mixed $codes
     * @param mixed|null $failures
     * @param mixed $pipeline
     * @param mixed|null $address
     * @return mixed
     */
    public function executeCommand($command, $codes = [], &$failures = null, $pipeline = false, $address = null)
    {
        $this->rawTrasmissionData[] = $command;
        $response = parent::executeCommand($command, $codes, $failures, $pipeline, $address);
        $this->rawResponses[] = $response;
        $this->rawTrasmissionData[] = $response;

        return $response;
    }

    /**
     * Get Elastic message ID from the last SMTP response.
     * which looks like this: "250 OK 5c4764a2-93a7-4914-91e2-b6c6f57aff9d".
     *
     * @return string messageId
     */
    public function getMessageId()
    {
        $messageId = null;
        foreach ($this->rawResponses as $e) {
            preg_match('/(?<=250 ok\s)[^\s]*/i', $e, $matched);
            if (count($matched) > 0) {
                $messageId = $matched[0];
            }
        }

        return $messageId;
    }

    /**
     * Get SMTP raw responses (for debugging).
     *
     * @return array SMTP responses
     */
    public function getRawTrasmissionData()
    {
        return $this->rawTrasmissionData();
    }
}
