<?PHP
$MainOutput->br(2);
$MainOutput->AddForm('Veuillez entrer vos identifiants');
$MainOutput->inputHidden_env('Action','Login');

$MainOutput->InputSelect('CIE',array('QC'=>'Qu�bec','MTL'=>'Montr�al','TR'=>'Trois-Rivi�res'),'QC','R�gion');
$MainOutput->inputText('Cote','Cote&nbsp;de&nbsp;Facturation',5);
$MainOutput->InputPassword('Password','Mot de passe');
$MainOutput->FormSubmit('Connexion');
echo $MainOutput->Send(1);
?>