<?php

include_once('app/invoice/invoice_item/CountableInvoiceItem.php');
include_once ('app/payment/payment.php');

class TestCountableInvoiceItem extends PHPUnit_Framework_TestCase{

    const UNE_COTE = "TII";
    const UN_ID_DE_FACTURE_DE_MATERIEL = 4002;
    const UN_ID_DE_FACTSHEET_COMPTABLE = 5;

    function test_givenIDFactureDeMateriel_whenGetInvoiceItemFromInvoiceId_thenReturnArrayOfAssociatedCountableInvoiceItems(){
        $invoice_items = CountableInvoiceItem::findItemByInvoiceId(self::UN_ID_DE_FACTURE_DE_MATERIEL);

        $this->assertEquals(2, count($invoice_items));
        $first_invoice_item = array_pop($invoice_items);
        $this->isInstanceOf(CountableInvoiceItem::class, $first_invoice_item);
    }

    function test_givenCountableInvoiceItemId_whenAddToBalance_ThenValueItemIsCalculted(){
        $invoice_item = new CountableInvoiceItem(self::UN_ID_DE_FACTSHEET_COMPTABLE);
        $balance = 0;
        $invoice_item->add_to_balance($balance);

        $this->assertEquals(300, $balance);
    }

    function test_givenCountableInvoiceItemId_whenGetNumberBilledItem_thenGetDifferenceOfItems()
    {
        $invoice_item = new CountableInvoiceItem(self::UN_ID_DE_FACTSHEET_COMPTABLE);

        $number_of_billed_items = $invoice_item->getNumberOfBilledItems();

        $this->assertEquals(2, $number_of_billed_items);
    }

    function test_givenCountableItemWithAmountBilledIsZero_whenIsEmpty_thenReturnTrue()
    {
        $invoice_item = CountableInvoiceItem::fromDetails(array("quantity"=>0,'unit_cost'=>1));

        $this->assertTrue($invoice_item->isEmpty());
    }

    function test_givenCountableItemWithAmountBilledIsNotZero_whenIsEmpty_thenReturnFalse()
    {
        $invoice_item = CountableInvoiceItem::fromDetails(array("quantity"=>1,'unit_cost'=>1));

        $this->assertFalse($invoice_item->isEmpty());
    }
}
