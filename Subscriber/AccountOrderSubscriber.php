<?php

namespace Swark\Subscriber;

use Swark\Helper\OrderHelper;

/**
 * Class AccountOrderSubscriber
 */
class AccountOrderSubscriber
{
    /**
     * @var string
     */
    private $viewDir;

    /**
     * @var OrderHelper
     */
    private $orderHelper;

    /**
     * @param string      $viewDir
     * @param OrderHelper $orderHelper
     */
    public function __construct(
        string $viewDir,
        OrderHelper $orderHelper
    ) {
        $this->viewDir = $viewDir;
        $this->orderHelper = $orderHelper;
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     */
    public function onPostDispatchSecureAccount(\Enlight_Event_EventArgs $args): void
    {
        /** @var \Shopware_Controllers_Frontend_Account $subject */
        $subject = $args->getSubject();

        $view = $subject->View();

        if ($subject->Request()->getActionName() !== 'orders') {
            return;
        }

        $view->addTemplateDir($this->viewDir);

        $orders = $view->getAssign('sOpenOrders');

        foreach ($orders as $key => $order) {
            $order = $this->orderHelper->getOrder($order['ordernumber']);
            $orders[$key]['swarkTransactionId'] = $this->orderHelper->getTransactionIdByOrder($order);
        }

        $view->assign('sOpenOrders', $orders);
        $view->extendsTemplate('frontend/plugins/swark/order_item_details.tpl');
    }
}
