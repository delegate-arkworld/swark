<?php

namespace Swark\Components\Services;

use Shopware\Components\Logger;

/**
 * Class LoggerService
 */
class LoggerService
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Logger $baseLogger
     */
    public function __construct(Logger $baseLogger)
    {
        $this->logger = $baseLogger;
    }

    /**
     * @param string $message
     * @param array  $context
     */
    public function warning($message, array $context = []): void
    {
        /*if (!$this->settings->hasSettings()) {
            return;
        }

        if ((int) $this->settings->get('log_level') === 1) {
            $finalMessage = '[Warning] PayPal Products: ' . $message;
            $this->logger->addWarning($finalMessage, $context);
        }*/
        $finalMessage = '[Warning] Swark: ' . $message;
        $this->logger->addWarning($finalMessage, $context);
    }

    /**
     * @param string $message
     * @param array  $context
     */
    public function notify($message, array $context = []): void
    {
        /*if (!$this->settings->hasSettings()) {
            return;
        }

        if ((int) $this->settings->get('log_level') === 1) {
            $finalMessage = '[Info] PayPal Products: ' . $message;
            $this->logger->addInfo($finalMessage, $context);
        }*/
        $finalMessage = '[Info] Swark: ' . $message;
        $this->logger->addInfo($finalMessage, $context);
    }

    /**
     * @param string $message
     * @param array  $context
     */
    public function error($message, array $context = []): void
    {
        $finalMessage = '[Error] Swark: ' . $message;
        $this->logger->addError($finalMessage, $context);
    }
}
