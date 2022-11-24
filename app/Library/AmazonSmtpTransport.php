<?php

namespace App\Library;

use Swift_SmtpTransport;

class AmazonSmtpTransport extends Swift_SmtpTransport
{
    /**
     * Array used to store raw SMTP responses.
     */
    private $rawResponses = [];

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
        $response = parent::executeCommand($command, $codes, $failures, $pipeline, $address);
        $this->rawResponses[] = $response;

        return $response;
    }

    /**
     * Get Amazon message ID from the last SMTP response.
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
     * Get an array of SMTP raw responses.
     *
     * @return array SMTP messages
     */
    public function getRawResponses()
    {
        return $this->rawResponses;
    }
}
