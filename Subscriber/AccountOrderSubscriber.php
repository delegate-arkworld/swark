<?php

namespace Swark\Subscriber;

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
     * @param string $viewDir
     */
    public function __construct(
        string $viewDir
    ) {
        $this->viewDir = $viewDir;
    }

    /**
     * @param \Enlight_Event_EventArgs $args
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

        // TODO: implement logic and template (use order_item.tpl)

        /*$orderNumber = (int)$view->getAssign('sOrderNumber');
        $attributes = $this->orderHelper->getOrder($orderNumber)->getAttribute();
        $data = $this->orderHelper->getOrderAttributes($attributes);

        $view->assign('swarkConfirmations', $this->pluginConfig['confirmations']);
        $view->assign('swarkAttributes', $data);*/
        $view->extendsTemplate('frontend/plugins/swark/orders.tpl');
    }
}
