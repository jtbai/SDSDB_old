<?PHP
$MainOutput->OpenTable('400');
$MainOutput->OpenRow();
$MainOutput->OpenCol();
	$MainOutput->AddForm('Code de la facture � d�payer');
	$MainOutput->InputText('Cote','Code',10);
	$MainOutput->InputHidden_env('Section','SuperAdmin');
	$MainOutput->InputHidden_env('Action','MarkUnpayee');
	$MainOutput->FormSubmit('� D�payer');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->CloseTable();
echo $MainOutput->Send(1);
?>