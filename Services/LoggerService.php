<?php

namespace Swark\Services;

use Shopware\Components\Logger as BaseLogger;

/**
 * Class LoggerService
 */
class LoggerService extends BaseLogger
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        // TODO: fix Logger with own file!!
        parent::__construct('swark');
    }
}
