<?php
include_once('view/HTMLContainerRenderer.php');
include_once('view/invoice/display_invoice/invoice_items/TimedInvoiceItemRenderer.php');

class TimedInvoiceItemTableRenderer extends HTMLContainerRenderer
{

    private $invoice_item_controls_renderer;

    function __construct(Renderer $invoice_item_controls_renderer)
    {
        $this->invoice_item_controls_renderer = $invoice_item_controls_renderer;
        parent::__construct();
    }

    function buildContent($content_array)
    {
        $this->buildInvoiceItemTableHeader();
        $this->buildInvoiceItemTableRows($content_array['invoice_items']);
    }

    private function buildInvoiceItemTableHeader()
    {
        $this->html_container->OpenTable(660);
        $this->html_container->OpenRow();
        $this->html_container->OpenCol(80);
        $this->html_container->AddTexte('Date','Titre');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol(20);
        $this->html_container->AddTexte('<div align=center>D�but</div>','Titre');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol(20);
        $this->html_container->AddTexte('Fin','Titre');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol(330);
        $this->html_container->AddTexte('Description','Titre');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol(30);
        $this->html_container->AddTexte('Qt�','Titre');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol(70);
        $this->html_container->AddTexte('Taux','Titre');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol(50);
        $this->html_container->AddTexte('Total','Titre');
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();
    }

    private function buildInvoiceItemTableRows($invoice_item_array)
    {
        foreach($invoice_item_array as $invoice_item){
            $invoice_item_renderer = new TimedInvoiceItemRenderer($this->invoice_item_controls_renderer);
            $invoice_item_renderer->buildContent($invoice_item);
            $this->html_container->addoutput($invoice_item_renderer->render(),0,0);
        }
    }
}
