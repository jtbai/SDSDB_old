<?php
include_once('app/invoice/invoice_item/InvoiceItem.php');

class countableInvoiceItem extends InvoiceItem
{
    function add_to_balance(&$Balance){
        $Balance += round(($this->End - $this->Start)*$this->TXH,2);
    }

    static function find_item_by_invoice_id($invoice_id)
    {
        $invoice_items = array();
        $sql = new SqlClass();
        $database_information = self::define_table_info();
        $query = self::get_item_by_invoice_id_query($invoice_id);  // TODO: Implement find_item_by_facture_id() method.
        $sql->Select($query);
        while($invoice_item_cursor = $sql->FetchArray()){
            $invoice_items[] = new self($invoice_item_cursor[$database_information['model_table_id']]);
        }

        return $invoice_items;
    }

    function getNumberOfBilledItems()
    {
        return $this->End - $this->Start;
    }

    function getDetails()
    {
        // TODO: Implement getDetails() method.
    }
}
