<?PHP
if($_POST['FORMDate5']<>""){
    $debut_semaine = $time_service->get_start_of_week(new DateTime("@".mktime(0,0,0,$_POST['FORMDate4'],$_POST['FORMDate5'],$_POST['FORMDate3'])));
}else{
    $debut_semaine = $time_service->get_start_of_week(new DateTime());
}


$facture_dto = array(
    "cote" => $_POST['FORMCote'],
    "semaine" => $debut_semaine->getTimestamp(),
    "notes" => $_POST['FORMNotes'],
    "sequence"=>$_POST['FORMSeq'],
    "facture_type"=>FactureService::FACTURE_SHIFT,
    "taxable"=>true);


if($_POST['FORMCredit']==1)
    $facture_dto ['facture_type']=FactureService::CREDIT;
if($_POST['FORMMateriel']==1)
    $facture_dto ['facture_type']=FactureService::FACTURE_MATERIEL;
if($_POST['FORMAvanceClient']==1)
    $facture_dto ['facture_type']=FactureService::AVANCE_CLIENT;
if($_POST['FORMTaxes']==0)
    $facture_dto ['taxable']=false;

$facture = $facture_service->generate_blank_facture($facture_dto);
print_r($facture);
$facture->save();
$_GET['IDFacture']= $facture->IDFacture;

?>