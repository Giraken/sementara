<?php

namespace App\Library;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Read configuration settings
 * Setup init CONSTANTS.
 */
class Log
{
    public static $logger;

    public static $path;

    /**
     * Debug.
     *
     * @param mixed $message
     * @return mixed
     */
    public static function debug($message)
    {
        self::$logger->debug($message);
    }

    /**
     * Info.
     *
     * @param mixed $message
     * @return mixed
     */
    public static function info($message)
    {
        self::$logger->info($message);
    }

    /**
     * Notice.
     *
     * @param mixed $message
     * @return mixed
     */
    public static function notice($message)
    {
        self::$logger->notice($message);
    }

    /**
     * Warning.
     *
     * @param mixed $message
     * @return mixed
     */
    public static function warning($message)
    {
        self::$logger->warning($message);
    }

    /**
     * Error.
     *
     * @param mixed $message
     * @return mixed
     */
    public static function error($message)
    {
        self::$logger->error($message);
    }

    /**
     * Critical.
     *
     * @param mixed $message
     * @return mixed
     */
    public static function critical($message)
    {
        self::$logger->critical($message);
    }

    /**
     * Alert.
     *
     * @param mixed $message
     * @return mixed
     */
    public static function alert($message)
    {
        self::$logger->alert($message);
    }

    /**
     * Emergency.
     *
     * @param mixed $message
     * @return mixed
     */
    public static function emergency($message)
    {
        self::$logger->emergency($message);
    }

    /**
     * Reconfigure log format for the forked process.
     *
     * @return mixed
     */
    public static function fork()
    {
        $pid = getmypid();
        $output = '[%datetime%] #' . $pid . " %level_name%: %message%\n";
        $formatter = new LineFormatter($output);

        $stream = new StreamHandler(self::$path, Logger::INFO);
        $stream->setFormatter($formatter);

        self::$logger = new Logger('mailer');
        self::$logger->pushHandler($stream);
    }

    /**
     * Configure log format, used at initialization.
     *
     * @param mixed $path
     * @return logger
     */
    public static function configure($path)
    {
        $pid = getmypid();
        $output = '[%datetime%] #' . $pid . " %level_name%: %message%\n";
        $formatter = new LineFormatter($output);

        $stream = new StreamHandler($path, Logger::INFO);
        $stream->setFormatter($formatter);

        self::$logger = new Logger('mailer');
        self::$logger->pushHandler($stream);
        self::$path = $path;
    }

    /**
     * Create a custom logger.
     *
     * @param mixed $path
     * @param mixed $name
     * @return logger
     */
    public static function create($path, $name = 'default')
    {
        $pid = getmypid();
        $output = '[%datetime%] #' . $pid . " %level_name%: %message%\n";
        $formatter = new LineFormatter($output);

        $stream = new StreamHandler($path, Logger::INFO);
        $stream->setFormatter($formatter);

        $logger = new Logger($name);
        $logger->pushHandler($stream);

        return $logger;
    }
}
