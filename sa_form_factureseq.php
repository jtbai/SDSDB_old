<?PHP
$MainOutput->AddForm('Modifier une facture - Cote et S�quence');
$MainOutput->InputHidden_env('Action','Modifie_Facture_CoteSeq');
$MainOutput->InputText('Initial','Cote-Seq initial','6');
$MainOutput->InputText('Final','Cote-Seq � mettre','6');
$MainOutput->FormSubmit('Modifier');
?>