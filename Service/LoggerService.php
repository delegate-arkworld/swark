<?php

namespace Swark\Service;

use Shopware\Components\Logger as BaseLogger;

/**
 * Class LoggerService
 */
class LoggerService extends BaseLogger
{
    // @TODO: rewrite to logger Dir with Factory!

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        // TODO: fix Logger with own file!!
        parent::__construct('swark');
    }
}
