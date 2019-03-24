<?php

namespace Swark\Logger;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

/**
 * Class LoggerFactory
 *
 * @package Swark\Logger
 */
class LoggerFactory
{
    const LOGGER_PREFIX = 'swark';

    /**
     * @var array
     */
    private $loggerConfig;

    /**
     * @var string
     */
    private $rootLogDir;

    /**
     * @param array  $loggerConfig
     * @param string $rootLogDir
     */
    public function __construct(
        array $loggerConfig,
        string $rootLogDir
    ) {
        $this->loggerConfig = $loggerConfig;
        $this->rootLogDir = $rootLogDir;
    }

    /**
     * @param string $name
     *
     * @return Logger
     */
    public function createErrorLogger(string $name): Logger
    {
        $logger = new Logger(self::LOGGER_PREFIX . '_' . $name);

        $this->addFileHandler($logger);

        return $logger;
    }

    /**
     * @param string $name
     *
     * @return Logger
     */
    public function createProcessLogger(string $name): Logger
    {
        $logger = new Logger(self::LOGGER_PREFIX . '_' . $name);

        $this->addFileHandler($logger);

        return $logger;
    }

    /**
     * @param Logger $logger
     */
    private function addFileHandler(Logger $logger): void
    {
        if (!array_key_exists('file', $this->loggerConfig)) {
            return;
        }

        $logger->pushHandler(new RotatingFileHandler(
            $this->rootLogDir . '/' . $logger->getName() . '.log',
            10
        ));
    }
}
