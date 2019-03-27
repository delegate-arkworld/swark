<?php

namespace Swark\Logger;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

/**
 * Class LoggerFactory
 */
class LoggerFactory
{
    const LOGGER_PREFIX = 'swark';

    /**
     * @var string
     */
    private $rootLogDir;

    /**
     * @param string $rootLogDir
     */
    public function __construct(
        string $rootLogDir
    ) {
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
        $logger->pushHandler(new RotatingFileHandler(
            $this->rootLogDir . '/' . $logger->getName() . '.log',
            10
        ));
    }
}
