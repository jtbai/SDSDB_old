<?PHP
if(isset($_GET['IDInspection'])){
	$INFO = get_info('inspection',$_GET['IDInspection']);
	$MainOutput->AddForm('Faire le suivi d\'une inspection');

	$MainOutput->InputHidden_Env('Action','SuiviInspection');
	$MainOutput->InputHidden_Env('IDInspection',$_GET['IDInspection']);
	
	$MainOutput->Flag('Envoye',$INFO['Envoye'],'Rapport&nbsp;d\'inspection&nbsp;envoy�&nbsp;au&nbsp;responsable');
	$MainOutput->Flag('Confirme',$INFO['Confirme'],'La r�ception du rapport � �t� confirm�e avec le responsable');

	$Radio = array('Non Repondu'=>0,'Ne d�sire pas de mat�riel'=>'-1','D�sire le mat�riel'=>'1');
	$MainOutput->InputRadio('Materiel',$Radio,$INFO['Materiel'],'Le client:');
	$MainOutput->Flag('MaterielPret',$INFO['MaterielPret'],'La commande de mat�riel est mont�ee');
	$MainOutput->Flag('MaterielLivre',$INFO['MaterielLivre'],'La commande de mat�riel est livr�e');
	$MainOutput->TextArea('Notes',NULL,45,5,$INFO['Notes']);
	$MainOutput->FormSubmit('Faire le suivi');
}
echo $MainOutput->Send(1);
?>