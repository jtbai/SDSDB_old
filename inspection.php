<?PHP
if(isset($_GET['TODO'])){
$NMois = get_month_list();
$NDay= get_day_list();
	//On enleve ceux qui ont d?j? ?t? inspect?es ou planifi?es
	$Req = "SELECT IDInstallation FROM inspection WHERE (!isnull(DateI) OR !isnull(DateP)) AND Annee=".get_vars("Boniyear");
	$SQL->Select($Req);
	
	$NOTIN = "0";
	while($Rep = $SQL->FetchArray()){
		$NOTIN .= ",".$Rep['IDInstallation'];
	}

$MainOutput->OpenTable(600);
$MainOutput->OpenRow();
$MainOutput->OpenCol(300);
	$MainOutput->OpenTable(300);
	
	$Req = "SELECT IDInspection,  installation.IDInstallation,installation.Nom,client.IDClient, DateR FROM installation JOIN client JOIN inspection on client.IDClient= installation.IDClient AND installation.IDInstallation = inspection.IDInstallation WHERE !isnull(inspection.DateR) AND installation.IDInstallation NOT IN (".$NOTIN.") and Annee=".get_vars("Boniyear")." ORDER BY DateR ASC, installation.Nom ASC";
	
	$SQL->Select($Req);
	if($SQL->NumRow()>0){
		
	$MainOutput->OpenRow();
	$MainOutput->OpenCol(300,3);
			$MainOutput->AddTexte('Client � rappeller','Titre');
	$MainOutput->Closecol();
	$MainOutput->CloseRow();
	$OLDJour = 0;
	$OLDMois = 0;
	
		while($Rep=$SQL->FetchArray()){
		
	
		$Date = getdate($Rep['DateR']);
		
		if($OLDJour<>$Date['mday'] OR $OLDMois<>$Date['mon']){
		$MainOutput->OpenRow();
		$MainOutput->OpenCol(300,3);
			$MainOutput->AddTexte("- ".$NDay[$Date['wday']]." ".$Date['mday']." ".$NMois[$Date['mon']],'Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$OLDJour=$Date['mday'] ;
		$OLDMois=$Date['mon'];
		}
		
		$MainOutput->OpenRow();
	
		$MainOutput->Opencol('16');
			$MainOutput->Addpic('assets/buttons/b_help.png','border=0',"index.php?MenuClient=".$Rep['IDClient'],'_BLANK');
		$MainOutput->CloseCol();

		$MainOutput->Opencol('16');
			$MainOutput->Addpic('assets/buttons/b_conf.png','border=0','index.php?Section=PlanifieInspection&IDInspection='.$Rep['IDInspection']);
		$MainOutput->CloseCol();
		
		
	
		$MainOutput->OpenCol(268);
			$MainOutput->AddLink('index.php?Section=AddInspection&IDInspection='.$Rep['IDInspection'],$Rep['Nom']);
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$NOTIN .= ",".$Rep['IDInstallation'];
	}
	}
	

	$Req = "SELECT IDInstallation, installation.Nom,client.IDClient FROM installation JOIN client on client.IDClient= installation.IDClient WHERE installation.Actif AND !client.Piece AND IDInstallation NOT IN (".$NOTIN.") ORDER BY installation.Nom ASC";
	$SQL->Select($Req);

	$MainOutput->OpenRow();
	$MainOutput->OpenCol(300,3);
			$MainOutput->AddTexte('Inspections � planifier','Titre');
	$MainOutput->Closecol();
	$MainOutput->CloseRow();
	$ARappeller = FALSE;
	while($Rep = $SQL->FetchArray()){
		$MainOutput->OpenRow();
	
		$MainOutput->Opencol('16');
			$MainOutput->Addpic('assets/buttons/b_help.png','border=0',"index.php?MenuClient=".$Rep['IDClient'],"_BLANK");
		$MainOutput->CloseCol();
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic('assets/buttons/b_conf.png','border=0','index.php?Section=PlanifieInspection&IDInstallation='.$Rep['IDInstallation']);
		$MainOutput->CloseCol();
		
	
		$MainOutput->OpenCol(268);
			$MainOutput->AddLink('index.php?Section=AddInspection&IDInstallation='.$Rep['IDInstallation'],$Rep['Nom']);
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
	}
	$MainOutput->CloseTable();
$MainOutput->CloseCol();

$MainOutput->OpenCol(300);
	
	$Req = "SELECT installation.IDInstallation, installation.Nom as nomIns, client.IDClient, IDInspection, DateP, IDEmploye  FROM installation JOIN client JOIN inspection on client.IDClient= installation.IDClient AND inspection.IDInstallation = installation.IDInstallation WHERE isnull(inspection.DateI) AND !isnull(inspection.DateP) AND Annee= ".get_vars('Boniyear')." ORDER BY DateP ASC";
	$SQL->Select($Req);
	$MainOutput->OpenTable(300);
	$MainOutput->OpenRow();
	$MainOutput->OpenCol(300,3);
			$MainOutput->AddTexte('Inspections planifi�es','Titre');
	$MainOutput->Closecol();
	$MainOutput->CloseRow();
	
	$OLDJour = 0;
	$OLDMois = 0;
	while($Rep = $SQL->FetchArray()){
		$Date = getdate($Rep['DateP']);
		
		if($OLDJour<>$Date['mday'] OR $OLDMois<>$Date['mon']){
		$MainOutput->OpenRow();
		$MainOutput->OpenCol(300,3);
			$MainOutput->AddTexte($NDay[$Date['wday']]." ".$Date['mday']." ".$NMois[$Date['mon']],'Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$OLDJour=$Date['mday'] ;
		$OLDMois=$Date['mon'];
		}
		
		$MainOutput->OpenRow();
		$MainOutput->Opencol('16');
			$MainOutput->Addpic('b_help.png','border=0',"index.php?MenuClient=".$Rep['IDClient'],'_BLANK');
		$MainOutput->CloseCol();

		$MainOutput->Opencol('16');
			$MainOutput->Addpic('b_conf.png','border=0','index.php?Section=PlanifieInspection&IDInspection='.$Rep['IDInspection']);
		$MainOutput->CloseCol();
		

		$MainOutput->OpenCol(268);
		if($Date['minutes']==0)
			$Date['minutes']="00";
			$MainOutput->AddTexte($Date['hours']."h".$Date['minutes']." :",'Titre');
			$MainOutput->AddLink('index.php?Section=AddInspection&IDInspection='.$Rep['IDInspection'],$Rep['nomIns']);

			if($Rep['IDEmploye']<>""){
                $employe = new Employee($Rep['IDEmploye']);

			$MainOutput->AddTexte("par ",'Titre');
			$MainOutput->AddTexte($employe->Prenom." ".$employe->Nom);
		}
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
	}
	$MainOutput->CloseTable();
$MainOutput->CloseCol();
	
	
}else{


$Req = "SELECT installation.IDInstallation, installation.Nom as nomIns,client.IDClient, IDInspection, DateI, IDEmploye, Envoye, Confirme, Materiel, MaterielPret, MaterielLivre FROM installation JOIN client JOIN inspection on client.IDClient= installation.IDClient AND inspection.IDInstallation = installation.IDInstallation WHERE !isnull(inspection.DateI) AND Annee= ".get_vars('Boniyear')." ORDER BY nomIns ASC";
	$SQL->Select($Req);
	$MainOutput->OpenTable(452);
	$MainOutput->OpenRow();
	$MainOutput->OpenCol(452,10);
			$MainOutput->AddTexte('Inspections effectu�es','Titre');
	$MainOutput->Closecol();
	$MainOutput->CloseRow();
	$NMois = get_month_list();
	$NDay= get_day_list();
	$OLDJour = 0;
	$OLDMois = 0;
	while($Rep = $SQL->FetchArray()){
		
		$MainOutput->OpenRow();
	
	
		$MainOutput->Opencol('16');
			$MainOutput->Addlink("index.php?MenuClient=".$Rep['IDClient'], '<img src=assets/buttons/b_help.png border=0>','_BLANK');
		$MainOutput->CloseCol();
	
		$MainOutput->Opencol('16');
			$MainOutput->Addlink('index.php?Section=AddInspection&IDInspection='.$Rep['IDInspection'], '<img src=assets/buttons/b_edit.png border=0>');
		$MainOutput->CloseCol();
		
		$MainOutput->Opencol('16');
			$MainOutput->Addlink('index.php?Section=Generate_InspectionReport&ToPrint=TRUE&IDInspection='.$Rep['IDInspection'], '<img src=assets/buttons/b_print.png border=0>','_BLANK');
		$MainOutput->CloseCol();
		
		$MainOutput->Opencol('16');
			$MainOutput->Addlink('index.php?Action=Generate_FactureInspectiont&ToPrint=TRUE&IDInspection='.$Rep['IDInspection'], '<img src=assets/buttons/b_fact.png border=0>','_BLANK');
		$MainOutput->CloseCol();
		
			$MainOutput->OpenCol(308);	
			$MainOutput->AddLink('index.php?Section=SuiviInspection&IDInspection='.$Rep['IDInspection'],$Rep['nomIns']);
        if($Rep['IDEmploye']<>""){
            $employe = new Employee($Rep['IDEmploye']);

            $MainOutput->AddTexte("par ",'Titre');
            $MainOutput->AddTexte($employe->Prenom." ".$employe->Nom);
        }
		$MainOutput->CloseCol();
		

		$IMGEnvoye = "assets/buttons/b_linkBW.png";
		$IMGConfirme = "assets/buttons/b_confBW.png";
		$IMGMateriel = "assets/buttons/b_matBW.png";
		$IMGMaterielPret = "assets/buttons/b_monteBW.png";
		$IMGMaterielLivre = "assets/buttons/b_okBW.png";


        $TITLEEnvoye  = "Inspection non envoy�e";
        $TITLEConfirme = "R�ception non confirm�e";
        $TITLEMateriel = "Attente de la r�ponse du client";
        $TITLEMaterielPret = "Commande non pr�te";
        $TITLEMaterielLivre = "Commande non livr�e";

		if($Rep['Envoye']){
			$IMGEnvoye = "assets/buttons/b_link.png";
            $TITLEEnvoye  = "Inspection envoy�e";
        }
		if($Rep['Confirme'])
		{
			$IMGConfirme = "assets/buttons/b_conf.png";
            $TITLEConfirme = "R�ception confirm�e";
        }
		if($Rep['Materiel'])
		{
			$IMGMateriel = "assets/buttons/b_mat.png";
            $TITLEMateriel = "D�sire le mat�riel";
        }
		if($Rep['MaterielPret'])
        {
            $IMGMaterielPret = "assets/buttons/b_monte.png";
            $TITLEMaterielPret = "Commande pr�te";
        }
		if($Rep['MaterielLivre'])
        {
            $IMGMaterielLivre = "assets/buttons/b_ok.png";
            $TITLEMaterielLivre = "Commande non livr�e";
        }
		if($Rep['Materiel']==-1){
			$IMGMateriel = "carlos.gif";
            $TITLEMateriel = "Ne veut pas le mat�riel";
			$IMGMaterielPret = "carlos.gif";
            $TITLEMaterielPret = "";
			$IMGMaterielLivre = "assets/buttons/b_ok.png";
            $TITLEMaterielLivre = "";
		}
		
		
		
		
		
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic($IMGEnvoye,'border=0, width=16, title="'.$TITLEEnvoye.'"');
		$MainOutput->CloseCol();
		
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic($IMGConfirme,'border=0, width=16, title="'.$TITLEConfirme.'"');
		$MainOutput->CloseCol();
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic($IMGMateriel,'border=0, width=16, title="'.$TITLEMateriel.'"');
		$MainOutput->CloseCol();
		
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic($IMGMaterielPret,'border=0, width=16, title="'.$TITLEMaterielPret.'"');
		$MainOutput->CloseCol();
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic($IMGMaterielLivre,'border=0, width=16, title="'.$TITLEMaterielLivre.'"');
		$MainOutput->CloseCol();
		
		
		
		
		
		$MainOutput->CloseRow();
		
	}
	
	
	
	
	
	
	$MainOutput->CloseTable();


}
echo $MainOutput->Send(1);
?>