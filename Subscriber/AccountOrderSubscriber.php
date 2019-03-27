<?php

namespace Swark\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Event_EventArgs;
use Swark\Helper\OrderHelper;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Class AccountOrderSubscriber
 */
class AccountOrderSubscriber implements SubscriberInterface
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
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Account' => 'onPostDispatchSecureAccount',
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     *
     * @throws ServiceNotFoundException
     * @throws ServiceCircularReferenceException
     */
    public function onPostDispatchSecureAccount(Enlight_Event_EventArgs $args): void
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
