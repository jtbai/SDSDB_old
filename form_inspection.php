<?PHP
if(!isset($_GET['IDInspection']) AND isset($_GET['IDInstallation'])){
	$UPDATE = FALSE;
	$INFO = array('IDResponsable'=>'','IDInstallation'=> $_GET['IDInstallation'],'IDEmploye'=>'','DateI'=>time(),'EchellePP'=>'','Chlore'=>'','EchelleX2P'=>'','Escalier'=>'','Cloture12'=>'','Cloture100'=>'','Maille38'=>'','Promenade'=>'','Fermeacle'=>'','ProfondeurPP'=>'','ProfondeurP'=>'','ProfondeurPente'=>'','Cercle'=>'','Verre'=>'','Bousculade'=>'','Maximum'=>'','Mirador'=>'','SMU'=>'','Procedures'=>'','Perche'=>'','Bouees'=>'','Planche'=>'','Couverture'=>'','Registre'=>'','Manuel'=>'','Antiseptique'=>'','Epingle'=>'','Pansement'=>'','BTria'=>'','Gaze50'=>'','Gaze100'=>'','Ouate'=>'','Gaze75'=>'','Compressif'=>'','Tape12'=>'','Tape50'=>'','Eclisses'=>'','Ciseau'=>'','Pince'=>'','Crayon'=>'','Masque'=>'','Gant'=>'');
	$_GET['IDInspection']=NULL;

}else{
	$UPDATE = TRUE;
	$INFO = get_info('Inspection',$_GET['IDInspection']);
	$_GET['IDInstallation']=NULL;
}

if($INFO['DateI']=="" OR is_null($INFO['DateI']))
	$INFO['DateI']=$INFO['DateP'];

$MainOutput->AddForm('Ajouter / Modifier une inspection');

$MainOutput->InputHidden_Env('Action','Inspection');
$MainOutput->InputHidden_Env('UPDATE',$UPDATE);
$MainOutput->InputHidden_Env('IDInspection',$_GET['IDInspection']);
$MainOutput->InputHidden_Env('IDInstallation',$_GET['IDInstallation']);

 
$MainOutput->OpenRow();
$MainOutput->OpenCol('550');
	$MainOutput->AddTexte('<img src=carlos.gif width=550 height=1>');
$MainOutput->CloseCol();
$MainOutput->OpenCol('50');
	$MainOutput->AddTexte('<img src=carlos.gif width=50 height=1>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<u>Information G�n�rale</u>
	
	','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ORDER BY Nom ASC";



$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->OpenTable();

$MainOutput->inputselect('IDEmploye',$Req,$INFO['IDEmploye'],'Inspecteur');
$MainOutput->inputselect('IDResponsable',get_responsable_client($INFO['IDInstallation']),$INFO['IDResponsable'],'Contact');
$MainOutput->InputTime('DateI','Date de l\'inspection',$INFO['DateI'],array('Date'=>TRUE,'Time'=>False));

$MainOutput->CloseTable();
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<hr>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<u>Mat�riel de piscine</u>
	
	','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->flag('Mirador',$INFO['Mirador'],'Mirador (Si la piscine est plus grande que 150m2)');
$MainOutput->flag('SMU',$INFO['SMU'],'Moyen de communication pour les SMU � moins de 100m et facilement accessible');
$MainOutput->flag('Procedures',$INFO['Procedures'],'Les proc�dures d\'urgences sont affich�es pr�s du moyen de communication');
$MainOutput->flag('Perche',$INFO['Perche'],'Perche isol�e �lectriquement de 3.6m');
$MainOutput->flag('Bouees',$INFO['Bouees'],'Deux bou�es de sauvetage 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a) annulaires entre 275 et 380mm de diam�tre 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;avec cordage de 3m + � largeur de la piscine
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OU b) Bou�e torpille avec 2m de cordage et une bandouill�re');
$MainOutput->flag('Planche',$INFO['Planche'],'Planche dorsale');
$MainOutput->flag('Couverture',$INFO['Couverture']);
$MainOutput->flag('Registre',$INFO['Registre'],'Registre des installations');
$MainOutput->flag('Chlore',$INFO['Chlore'],'Trousse de v�rification de Chlore et pH');
$MainOutput->textarea('NotesMateriel','Notes',25,5,$INFO['NotesMateriel']);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<hr>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('
	<u>Affichage</u>
	
	','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('Pronfondeur de l\'eau (en 100mm) aux points suivants:','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->InputText('ProfondeurPP','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Peu profond (en mm)',3,$INFO['ProfondeurPP']);
$MainOutput->InputText('ProfondeurP','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Profond (en mm)',3,$INFO['ProfondeurP']);
$MainOutput->InputText('ProfondeurPente','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pente (en mm)',3,$INFO['ProfondeurPente']);

$MainOutput->Flag('Cercle',$INFO['Cercle'],'Cercle noir de 150 mm de diam�tre au point le plus profond de la piscine');

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('R�glements (en 25mm) - ou pictogramme','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->InputText('Verre','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Aucun contenant de verre (en mm)',3,$INFO['Verre']);
$MainOutput->InputText('Bousculade','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pas de bousculade (en mm)',3,$INFO['Bousculade']);

$MainOutput->InputText('Maximum','Nombre maximum de baigneurs (en 150mm)',3,$INFO['Maximum']);
$MainOutput->textarea('NotesAffichage','Notes',25,5,$INFO['NotesAffichage']);
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<hr>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('
	<u>Construction</u>
	
	','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->Flag('EchellePP',$INFO['EchellePP'],'Une �chelle / escalier dans la partie peu profonde si la profondeur d�passe 600mm');
$MainOutput->Flag('EchelleX2P',$INFO['EchelleX2P'],'Une �chelle de chaque c�t� de la partie profonde');
$MainOutput->Flag('Escalier',$INFO['Escalier'],'S\'il y a un estcalier, le nez de la marche doit �tre peint de couleur contrastante');
$MainOutput->Flag('Cloture12',$INFO['Cloture12'],'La piscine doit �tre entour�e d\'une cl�ture d\'un minimum de 1,20m');
$MainOutput->Flag('Cloture100',$INFO['Cloture100'],'La cl�ture ne doit pas permettre de faire passer un cercle de 100mm de diam�tre');
$MainOutput->Flag('Maille38',$INFO['Maille38'],'S\'il s\'agit d\'une cl�ture de maille, la maille doit �tre inf�rieure � 38mm');
$MainOutput->Flag('Promenade',$INFO['Promenade'],'Si une partie de la promenade peut �tre utilis�e hors des heures d\'ouverture, une cl�ture de 900mm doit s�parer la promenade de la partie r�serv�e de la piscine');
$MainOutput->Flag('Fermeacle',$INFO['Fermeacle'],'Toutes les ouvertures qui donnent acc�s � la piscine doivent �tre ferm�es � clef lorsque la piscine est sans surveillance');
$MainOutput->textarea('NotesConstruction','Notes',25,5,$INFO['NotesConstruction']);
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<hr>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('
	<u>Trousse de premiers soins</u>
	
	','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<u>Obligatoire</u>
		','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->InputText('Manuel','Manuel de secourisme',2,$INFO['Manuel']);
$MainOutput->InputText('Antiseptique','150ml d\'antiseptique OU 20 tampons d\'alcool',2,$INFO['Antiseptique']);
$MainOutput->InputText('Epingle','24 �pingles de s�ret�',2,$INFO['Epingle']);
$MainOutput->InputText('Pansement','24 pansements adh�sifs envelopp�s s�par�ment',2,$INFO['Pansement']);
$MainOutput->InputText('Btria','6 bandages triangulaires',2,$INFO['BTria']);
$MainOutput->InputText('Gaze50','4 rouleaux de bandage de gaze de 50mm',2,$INFO['Gaze50']);
$MainOutput->InputText('Gaze100','4 rouleaux de bandage de gaze de 100mm',2,$INFO['Gaze100']);
$MainOutput->InputText('Ouate','4 paquets de Ouate de 25g chacun',2,$INFO['Ouate']);
$MainOutput->InputText('Gaze75','12 tampons ou compresses de gaze de 75 x 75mm',2,$INFO['Gaze75']);
$MainOutput->InputText('Compressif','4 tampons chirurgicaux pour pansements compressifs envelopp�s s�par�ment',2,$INFO['Compressif']);
$MainOutput->InputText('Tape12','1 rouleau de diachylon de 12 mm de largeur',2,$INFO['Tape12']);
$MainOutput->InputText('Tape50','1 rouleau de diachylon de 50 mm de largeur',2,$INFO['Tape50']);
$MainOutput->InputText('Eclisses','�clisses de grandeur assorties ou QuickSplint',2,$INFO['Eclisses']);

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('
	<u>Fortement recommand�</u>
		','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->InputText('Ciseau','Ciseaux',2,$INFO['Ciseau']);
$MainOutput->InputText('Pince','Pinces � �charde',2,$INFO['Pince']);
$MainOutput->InputText('Crayon','Crayon',2,$INFO['Crayon']);
$MainOutput->InputText('Masque','Masque de poche',2,$INFO['Masque']);
$MainOutput->InputText('Gant','Gants chirurgicaux',2,$INFO['Gant']);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<hr>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->FormSubmit('Ajouter / Modifier');






echo $MainOutput->Send(1);

?>