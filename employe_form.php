<?PHP
const EMPLOYEE_NUMBER = 'Num�ro d\'employ�';
const ADD_MODIFY_EMPLOYEE = 'Ajouter / Modifier un employ�';
const NAME = 'Nom';
const SURNAME = 'Pr�nom';
const SCHEDULE_NAME = 'Nom Horaire';
const DATE_OF_BIRTH = 'Date de naissance';
const SOCIAL_SECURITY_NUMBER = 'Num�ro d\assurance sociale';
const NOTES = 'Notes';
const PHONE_PRINCIPAL = 'T�l. Principal';
const PHONE_SECONDARY = 'T�l. Autre';
const CELLPHONE = 'Cellulaire';
const PAGET = 'Paget';
const LEAVING_REASON = 'Raison du d�part';
const ADD_MODIFY = 'Ajouter / Modifier';

$EMPLOYEE_STATUS = array('Temps plein' => 'Temps plein', 'Secondaire' => 'Secondaire', 'C�GEP' => 'C�GEP', 'Universit�' => 'Universit�');
$SA_EMPLOYEE_STATUS = array('Temps plein' => 'Temps plein', 'Secondaire' => 'Secondaire', 'C�GEP' => 'C�GEP', 'Universit�' => 'Universit�', 'Bureau' => 'Bureau');


$MainOutput->addform(ADD_MODIFY_EMPLOYEE);
$MainOutput->inputhidden_env('Action','Employe');
if(isset($_GET['IDEmploye'])){
	$Info = get_employe_info($_GET['IDEmploye']);
	$MainOutput->inputhidden_env('IDEmploye',$_GET['IDEmploye']);
	$MainOutput->inputhidden_env('Update',TRUE);

    $new_employe = false;
}else{
    $new_employe = true;
	$Info = array('IDEmploye'=>'','HName'=>'','Ville'=>'Qu?bec','Status'=>'','NAS'=>'', NAME =>'','Prenom'=>'','Session'=>get_vars('Saison'),'DateNaissance'=>0,'Adresse'=>'','CodePostal'=>'','Email'=>'','TelM'=>'','TelP'=>'','TelA'=>'','Cell'=>'', PAGET =>'','IDSecteur'=>'','Cessation'=>'', NOTES =>'','Raison'=>'','SalaireB'=>'9.50','SalaireS'=>'9.75','SalaireA'=>'9.25','DateEmbauche'=>0,'Engage'=>1,'EAssistant'=>'');
	$MainOutput->inputhidden_env('Update',FALSE);
}


$cannot_edit_company_field = !$authorization->verifySuperAdmin($_COOKIE);
$can_see_protected_fields = $authorization->verifySuperAdmin($_COOKIE);



$MainOutput->addlink('index.php?Section=Employe_Report&IDEmploye='.$Info['IDEmploye'].'&ToPrint=TRUE', '<img src=assets/buttons/b_sheet.png border=0>');
$MainOutput->addlink('index.php?Section=Employe_Horshift&IDEmploye='.$Info['IDEmploye'], '<img src=assets/buttons/b_fact.png border=0>');
$MainOutput->addlink('index.php?Section=Display_AskedRemplacement&IDEmploye='.$Info['IDEmploye'], '<img src=assets/buttons/b_del.png border=0>');

$MainOutput->inputtext('IDEmploye', EMPLOYEE_NUMBER,'3',$Info['IDEmploye']);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Personnel------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtext(NAME, NAME,'28',$Info[NAME]);
$MainOutput->inputtext('Prenom', SURNAME,'28',$Info['Prenom']);
$MainOutput->inputtext('HName', SCHEDULE_NAME,'28',$Info['HName']);
$MainOutput->inputtime('DateNaissance', DATE_OF_BIRTH,$Info['DateNaissance'],array('Date'=>TRUE,'Time'=>FALSE));
if($can_see_protected_fields or $new_employe){
    $MainOutput->inputtext('NAS', SOCIAL_SECURITY_NUMBER,'9',$Info['NAS']);
}else{
    $MainOutput->inputhidden('NAS', $Info['NAS']);
}
$MainOutput->textarea(NOTES, NOTES,'25','2',$Info[NOTES]);



//check s'il y a des vacances ? venir
if(!$Info['IDEmploye']==''){
    $vacances_threshold = time()-3600*24;
    $Req = "SELECT * FROM vacances WHERE FinVacances >= ".$vacances_threshold." and IDEmploye = ".$Info['IDEmploye']." ORDER BY DebutVacances ASC";
    $SQL = new sqlclass();
    $SQL->Select($Req);

    if($SQL->NumRow() <> 0){

        $MainOutput->OpenRow();
        $MainOutput->OpenCol('100%',2);
        $MainOutput->addtexte('----------Vacances--------------------------------------','Titre');
        $MainOutput->CloseCol();
        $MainOutput->CloseRow();

        While($Rep = $SQL->FetchArray()){
            $MainOutput->OpenRow();
            $MainOutput->OpenCol();
                $MainOutput->AddTexte($Rep['Raison']);
            $MainOutput->addlink("index.php?Action=Delete_Vacances&Section=Employe&IDVacances=".$Rep['IDVacances']."&IDEmploye=".$Info['IDEmploye'], "<img src=assets/buttons/b_del.png border=0>");
            $MainOutput->CloseCol();
            $MainOutput->OpenCol();
                $MainOutput->addTexte(date("d M Y",$Rep['DebutVacances'])." au ".date("d M Y",$Rep['FinVacances']));
            $MainOutput->CloseCol();

            $MainOutput->CloseRow();
        }
    }

}

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Contact----------------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$secteurs = Secteur::get_all(1,"Nom","ASC");

$MainOutput->inputtext('Adresse','Adresse','28',$Info['Adresse']);
$MainOutput->inputselect('IDSecteur',ModelToKVPConverter::to_kvp($secteurs, "IDSecteur", "Nom"),$Info['IDSecteur'],'Secteur');
$MainOutput->inputtext('Ville','Ville','28',$Info['Ville']);
$MainOutput->inputtext('CodePostal','Code Postal','7',$Info['CodePostal']);
$MainOutput->inputtext('Email','Courriel','28',$Info['Email']);
$MainOutput->inputphone('TelP', PHONE_PRINCIPAL,$Info['TelP']);
$MainOutput->inputphone('TelA', PHONE_SECONDARY,$Info['TelA']);
$MainOutput->inputphone('Cell', CELLPHONE,$Info['Cell']);
$MainOutput->inputphone(PAGET, PAGET,$Info['Paget']);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Compagnie----------------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtime('DateEmbauche','Date d\'embauche',$Info['DateEmbauche'],array('Date'=>TRUE,'Time'=>FALSE));

$Session = get_saison_list();
$Saison = array();
foreach($Session as $v){
	$Saison[$v]=$v;
}

$MainOutput->inputselect('Session',$Saison,$Info['Session'],'Session');
if($authorization->verifySuperAdmin($_COOKIE)){
    $MainOutput->inputselect('Status',$SA_EMPLOYEE_STATUS,$Info['Status'],'Status');
}elseif($Info['Status']=="Bureau"){
    $MainOutput->inputselect('Status',$SA_EMPLOYEE_STATUS,$Info['Status'],'Status', True);
}else{
    $MainOutput->inputselect('Status',$EMPLOYEE_STATUS,$Info['Status'],'Status', False);
}


$MainOutput->inputselect('Emploi',array('1'=>'Assistant','0'=>'Sauveteur'),$Info['EAssistant']);
$MainOutput->inputtext('SalaireB','Salaire Bureau','5',$Info['SalaireB']);
$MainOutput->inputtext('SalaireS','Salaire Sauveteur','5',$Info['SalaireS']);
$MainOutput->inputtext('SalaireA','Salaire Assitant','5',$Info['SalaireA']);
$MainOutput->flag('Cessation',$Info['Cessation']);
$MainOutput->textarea('Raison', LEAVING_REASON,'25','2',$Info['Raison']);


$MainOutput->formsubmit(ADD_MODIFY);
echo $MainOutput->send(1);

?>
