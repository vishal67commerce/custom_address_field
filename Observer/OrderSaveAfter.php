<?php
namespace Dev\Custom\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Customer\Api\AddressRepositoryInterface;

class OrderSaveAfter implements ObserverInterface
{   
    public function __construct(
        AddressRepositoryInterface $addressRepository
 
    ) {
        $this->addressRepository = $addressRepository;

    }

    public function execute(Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getData('order');
        $addressId = $order->getShippingAddress()->getData('customer_address_id'); // Get Address Id
        if($addressId){ // Check address id exist
            $address = $this->addressRepository->getById($addressId); // Get address by id
            $address->setCustomAttribute('custom_field',$order->getCustomField());
            $this->addressRepository->save($address);
        }
    }
}