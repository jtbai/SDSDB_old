<?PHP
$MainOutput->AddForm('Boni Crusher');
$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ORDER BY Nom ASC, Prenom ASC";
$MainOutput->InputSelect('IDEmploye',$Req,'','Employ�');
$MainOutput->InputHidden_Env('Action','BoniCrusher');

$Raison = array(
'Retard'=>'Retard',
'Absence'=>'Absence',
'Remplacement derni�re minute'=>'Remplacement derni�re minute',
'Pas de sp�cimen de ch�que'=>'Pas de sp�cimen de ch�que',
'Pas donn� ses heures'=>'Pas donn� ses heures',
'Pas retourn� apr�s la pluie'=>'Pas retourn� apr�s la pluie',
'Pas de sp�cimen de ch�que'=>'Pas de sp�cimen de ch�que',
'D�part injustifi�'=>'D�part injustifi�',
'Probl�me � l\'�thique'=>'Probl�me � l\'�thique',
'Non Respect de son horaire'=>'Non Respect de son horaire');

$MainOutput->inputtime('Date','Date','',array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->InputSelect('Raison',$Raison);
$MainOutput->InputText('Detail');
$MainOutput->InputText('Pourcentage','Pourcentage',3);
$MainOutput->FormSubmit('CRUSHHH!!!!');
echo $MainOutput->Send(1);
?>