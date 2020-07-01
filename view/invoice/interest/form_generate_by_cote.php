<?php
const GENERATE_INTEREST_FACTURE = "G�n�rer une facture d'int�r�t";
const GENERATE = "G�n�rer";

$MainOutput->addform(GENERATE_INTEREST_FACTURE);
$MainOutput->inputhidden_env('Section','Invoice_Show');
$MainOutput->inputhidden_env('Action','Invoice_GenerateInterestInvoice');
foreach($unpaid_factures as $facture){

    $formated_date = date("d-m-Y", $facture->EnDate);
    $facture_total = $facture->STotal *(1+$facture->TPS)*(1+$facture->TVQ);
    $formated_facture_total = number_format($facture_total, 2,'.', ' ')." $";
    $choice_string = "<b>".$facture->Cote."-".$facture->Sequence."</b> ".$formated_facture_total." \n (".$formated_date.")";

    $MainOutput->flag('IDFacture['.$facture->IDFacture.']', '1',$choice_string);

}
$MainOutput->inputtext('InterestRate','taux int�r�t (%)',2);
$MainOutput->inputtime('StartDate','Date d�but',Null,array('Time'=>false, 'Date'=>true) );
//$MainOutput->flag
$MainOutput->formsubmit(GENERATE);
print($MainOutput->send(1));
