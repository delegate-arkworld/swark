<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swark\Tests\Functional;

use Doctrine\DBAL\Query\QueryBuilder;

trait SwarkPaymentIdTrait
{
    /**
     * @throws \Exception
     *
     * @return bool|string
     */
    protected function getSwarkPaymentId()
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();

        return $queryBuilder->select('id')
            ->from('s_core_paymentmeans')
            ->where('name = :name')
            ->setParameter(':name', 'ark')
            ->execute()
            ->fetchColumn();
    }
}
