<?php
namespace Dev\Custom\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SalesModelServiceQuoteSubmitBefore implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getData('order');

        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getData('quote');

        $order->setData('custom_field', $quote->getCustomField()); // Code for save custom field in table "sale_order"

        // Code for save custom field in table "sale_order_address"
        $shippingAddressData = $quote->getShippingAddress()->getData();
        
        if (isset($shippingAddressData['custom_field'])) {
            $order->getShippingAddress()->setCustomField($shippingAddressData['custom_field']);
            $order->getBillingAddress()->setCustomField($shippingAddressData['custom_field']);
        }

        return $this;
    }
}