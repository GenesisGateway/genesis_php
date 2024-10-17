<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial\Alternatives\Transaction;

use Faker\Factory;
use Genesis\Api\Constants\Financial\Alternative\Transaction\ItemTypes;
use Genesis\Api\Request\Financial\Alternatives\Transaction\Item as InvoiceItem;
use Genesis\Api\Request\Financial\Alternatives\Transaction\ProductIdentifiers;

trait ItemsExample
{
    public function setItem()
    {
        $faker = Factory::create();

        $item = new InvoiceItem();
        $item->setName($faker->name);
        $item->setItemType(ItemTypes::PHYSICAL);
        $item->setQuantity('5');
        $item->setUnitPrice('0.99');
        $item->setQuantityUnit('pcs');
        $item->setTaxRate('0.05');
        $item->addMerchantMarketplaceSellerInfo('Electronic components');

        $productIdentifiers = new ProductIdentifiers();
        $productIdentifiers->setBrand('Brand');
        $productIdentifiers->setCategoryPath('Category Path');
        $productIdentifiers->setGlobalTradeItemNumber('GTIN');
        $productIdentifiers->setManufacturerPartNumber('MPN');

        $item->setProductIdentifiers($productIdentifiers);

        return $item;
    }
}
