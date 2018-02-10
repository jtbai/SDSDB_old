<?PHP

if(isset($_GET['Semaine']) && !isset($_POST['FORMGenerateCote'])){
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	$MainOutput->Opencol();
	$ENDS = get_end_dates(0,$_GET['Semaine']);
	$MainOutput->AddTexte('Semaine du '.$ENDS['Start'].' au '.$ENDS['End'],'Titre');
 	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
    $installation_to_bill = Installation::get_installations_in_string_to_bill($_GET['Semaine']);
	$MainOutput->OpenRow();
	$MainOutput->Opencol();
		$MainOutput->addform(AJOUTER_UNE_FACTURE);
		$MainOutput->inputhidden_env('Section','Generate_Facture');
		$MainOutput->inputhidden_env('Semaine',$_GET['Semaine']);
		$MainOutput->InputRadio('GenerateCote',$installation_to_bill,'','Piscine','VER');
		$MainOutput->formsubmit(CREER);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->CloseTable();
}elseif(isset($_POST['Semaine']) AND isset($_POST['FORMGenerateCote'])){
    $_POST['FORMCote'] = $_POST['FORMGenerateCote'];
    $installation_to_bill = Installation::get_installations_to_bill($_POST['FORMCote'], $_POST['Semaine']);
    if(count($installation_to_bill)==0){
        $MainOutput->AddTexte(ALREADY_BILLED,'Warning');
    }elseif($_POST['Semaine'] >= get_last_sunday(0,time()) ) {
        $MainOutput->AddTexte(INCOMPLETE_PERIOD, 'Warning');
    }else{
        $facture = Customer::generate_facture_hebdomadaire_shifts($_POST['FORMCote'],$_POST['Semaine']);
        $Modifie=TRUE;
        $_GET['IDFacture'] = $facture->IDFacture;
        include_once('display_facture.php');
	}
}
echo $MainOutput->send(1);