<?PHP


	$MainOutput->addForm('Modifier le num�ro d\'employ�');
	$MainOutput->inputhidden_env('Section','SuperAdmin');
	$MainOutput->inputhidden_env('Action','ChangeEmployeNo');
	$MainOutput->inputText('IDEmployeIni','IDEmploye erreur','3');
	$MainOutput->inputText('IDEmployeFin','IDEmploye bon','3');
	$MainOutput->formSubmit('Modifier');




	echo $MainOutput->Send(1)
?>
