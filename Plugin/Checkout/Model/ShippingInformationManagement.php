<?php
namespace Dev\Custom\Plugin\Checkout\Model;


class ShippingInformationManagement
{
    protected $quoteRepository;

    protected $dataHelper;

    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository
    )
    {
        $this->quoteRepository = $quoteRepository;
    }

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    )
    {
		if(!$extensionAttributes = $addressInformation->getExtensionAttributes()) // If not custom attribute
        {
            return;
        }
        $quote = $this->quoteRepository->getActive($cartId);
        // Code for save customfield in table "quote_address"
        $shippingAddress = $addressInformation->getShippingAddress();
        $shippingAddress->setCustomField($extensionAttributes->getCustomField());
        
        // Code for save customfield in table "quote"
        
        $quote->setCustomField($extensionAttributes->getCustomField());
    }
}
