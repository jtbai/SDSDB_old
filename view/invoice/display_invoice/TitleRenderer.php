<?php

include_once('helper/Renderer.php');

class TitleRenderer implements Renderer
{
    private $invoice_title_caption;
    private $title;

    function __construct(Invoice $invoice)
    {
        $this->invoice_title_caption = $this->getInvoiceTitleCaption($invoice);
        $this->title = "";
    }

    private function getInvoiceTitleCaption(Invoice $invoice)
    {
        if($invoice instanceof EquipmentInvoice) # Materiel
        {
            return "FACTURE MAT�RIEL";
        }
        else if($invoice instanceof AvanceClient)
        { # Avance
            return "AVANCE";
        }
        else if($invoice instanceof InterestInvoice)
        { # Int�ret
            return "CHARGE D'INT�R�T";
        }
        else if($invoice instanceof Credit)
        { # Credit
            return "CR�DIT";
        }else{
            return "FACTURE";
        }
    }

    function buildContent($content_array)
    {
        $this->title =  $this->invoice_title_caption;
    }

    function render()
    {
        return $this->title;
    }
}
