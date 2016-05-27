<?PHP


if(isset($_GET['IDInspection'])){
$NMois = get_month_list();
	$current_inspection = new inspection($_GET['IDInspection']);
	if($current_inspection->InspectionType=="Piscine"){
		$MaterielTrack = array();
		$MaterielTrack['Mirador'] = "Comme votre piscine � plus de 150m2, il est obligatoire d'avoir un mirador";
		$MaterielTrack['SMU'] = "La sauveteur doit avoir acc�s a un moyen de communication avec les services m�dicaux d'urgence, il est n�cessaire de mettre un t�l�phone � la disposition du sauveteur";
		$MaterielTrack['Procedures'] = "Les proc�dures d'urgences doivent �tre affich�es pr�s du moyen de communication";
		$MaterielTrack['Perche'] = "Une perche isol�e �lectriquement doit �tre mise � la disposition du sauveteur";
		$MaterielTrack['Bouees'] = "2 bou�es de sauvetages de 275mm � 380mm de largeur avec un cordage de 3m + largeur de la piscine doivent �tre mises � la disposition du sauveteur (ou une Bou�e torpille avec 2m de cordage et bandouil�re";
		$MaterielTrack['Planche'] = "La planche dorsale fait partie du mat�riel obligatoire � d�tenir sur le bord d'une piscine";
		$MaterielTrack['Couverture'] = "Une couverture doit se trouver � la piscine";
		$MaterielTrack['Registre'] = "Un registre des installation doit se trouver � la piscine";
		$MaterielTrack['Chlore'] = "Le sauveteur doit avoir du mat�riel pour faire les tests d'eau (Chlore et pH)";

		$AffichageTrack = array();
		$AffichageTrack['ProfondeurPP'] = array('Message'=>"La profondeur de la piscine au peu profond doit �tre inscrite en caract�re d'au moins 100mm de haut",'Taille'=>100);
		$AffichageTrack['ProfondeurP'] = array('Message'=>"La profondeur de la piscine au profond doit �tre inscrite en caract�re d'au moins 100mm de haut",'Taille'=>100);
		$AffichageTrack['ProfondeurPente'] = array('Message'=>"La profondeur de la piscine dans le milieu de la pente doit �tre inscrite en caract�re d'au moins 100mm de haut",'Taille'=>100);
		$AffichageTrack['Cercle'] = array('Message'=>"Un cercle noir d'un diam�tre d'au moins 150mm doit �tre dessin� au point le plus profond de la piscine",'Taille'=>1);
		$AffichageTrack['Verre'] = array('Message'=>"Le r�glement \"Interdiction de contenants de vitre\" doit �tre �crit en un caract�re d'au moins 25mm de haut - Un pictogramme est �quivalent",'Taille'=>25);
		$AffichageTrack['Bousculade'] = array('Message'=>"Le r�glement \"Bousculade Interdite\" doit �tre �crit en un caract�re d'au moins 25mm de haut - Un pictogramme est �quivalent",'Taille'=>25);
		$AffichageTrack['Maximum'] = array('Message'=>"Le nombre maximum de baigneur de votre piscine doit �tre �crit en lettres d'au moins 150mm",'Taille'=>150);

		$ConstructionTrack = array();
		$ConstructionTrack['EchellePP'] = "Le peu profond de la piscine doit �tre accessible via une �chelle ou des escaliers";
		$ConstructionTrack['EchelleX2P'] = "Une �chelle de chaque partie du profond doit �tre install�e";
		$ConstructionTrack['Escalier'] = "Le nez des marches du peu profond doivent �tre peintur�s d'une couleur contrastante";
		$ConstructionTrack['Cloture12'] = "La cl�ture entourant la piscine doit au minimum avoir 1.20m de hauteur";
		$ConstructionTrack['Cloture100'] = "La cl�ture entourant la piscine ne doit pas faire passer d'objet de plus de 100mm de diam�tre";
		$ConstructionTrack['Maille38'] = "La maille de la cl�ture doit �tre inf�rieure � 38mm";
		$ConstructionTrack['Promenade'] = "La promenade accessible lorsque la piscine est ferm�e doit avoir une cl�ture d'au moins 900mm de hauteur";
		$ConstructionTrack['Fermeacle'] = "Il doit �tre possible de verrouiller les points d'acc�s � la piscine lorsque celle-ci est ferm�e";
		$Obligatoire = array(1,2,3,4,5,6,7,8,9,10,11,12,13,18,19,20,21);
	}elseif($current_inspection->InspectionType=="Plage"){
		$MaterielTrack = array();
		$MaterielTrack['Mirador'] = "Un mirador de 2.4m de haut doit etre installe pour chaque unit� ou fraction d'unit� de 125m lin�aire de plage";
		$MaterielTrack['SMU'] = "La sauveteur doit avoir acc�s a un moyen de communication avec les services m�dicaux d'urgence, il est n�cessaire de mettre un t�l�phone � 100m du poste de surveillance";
		$MaterielTrack['Procedures'] = "Les proc�dures d'urgences doivent �tre affich�es pr�s du moyen de communication";
		$MaterielTrack['Couverture'] = "Une couverture doit se trouver au poste de surveillance";
		$MaterielTrack['Registre'] = "Un registre des installation doit se trouver au poste de surveillance";
		$MaterielTrack['Bouees'] = "2 bou�es de sauvetages de 275mm � 380mm de largeur avec un cordage de 15m (ou une bou�e torpille avec 2m de cordage et boucle pour les �paules)";
		$MaterielTrack['Chaloupe'] = "Une chaloupe par unit� ou fraction d'unit� de 250m lin�aire de plage doit etre mise � la disposition du sauveteur";
		$MaterielTrack['ChaloupeRame'] = "Vous devez avoir 2 rames et tolets pour la chaloupe";
		$MaterielTrack['ChaloupeAncre'] = "Vous devez avoir une bou�e d'amarrage ou un ancre pour la chaloupe";
		$MaterielTrack['ChaloupeGilets'] = "Vous devez avoir 3 gilets de sauvetages conformes pour la chaloupe";
		$MaterielTrack['ChaloupeBouee'] = "Vous devez avoir une bou�e annulaire d'un diam�tre int�rieur maximal de 380mm et 15m de corde pour la chaloupe";
		$MaterielTrack['LigneBouee'] = "Une ligne de bou�es de couleur blanche indiquant les limites de la zone de surveillance doit etre install�e";
		$MaterielTrack['BoueeProfond'] = "Une bou�e indicant le point le plus profond doit �tre install�e pour chaque 125m lin�aires de plage et l'�criture doit avoir au moins 150mm et doit �tre d'une couleur contrastante";

		$AffichageTrack = array();
		$AffichageTrack['Verre'] = array('Message'=>"Le r�glement \"Pas de contenant de verre\" doit �tre �crit en un caract�re d'au moins 25mm de haut sur deux affiches plac�es en �vidence",'Taille'=>25);
		$AffichageTrack['Canotage'] = array('Message'=>"Le r�glement \"Le canotage et la peche sont interdites dans la zone de baignade\"  doit �tre �crit en un caract�re d'au moins 25mm de haut sur deux affiches plac�es en �vidence",'Taille'=>25);
		$AffichageTrack['HeureSurveillance'] = array('Message'=>"Une affiche comportant les heures de surveilance doit etre affich�e aux limites des terrains adjacents et a des intervalles maximales de 60m",'Taille'=>1);
		$AffichageTrack['LimitePlage'] = array('Message'=>"Une affiche comportant les limites de la zone surveill�es doit etre affich�e aux limites des terrains adjacents et a des intervalles maximaux de 60m.",'Taille'=>1);

		$Obligatoire = array(1,2,3,4,5,6,7,8,9,10,11,12,13,21);
	}
	
	$QteMateriel = materielneeded($_GET['IDInspection']);
	$NBItem =0;
	
	foreach($Obligatoire as $i){
		$NBItem = $NBItem + $QteMateriel[$i]['Unitaire']+$QteMateriel[$i]['Forfait'];
	}
	$Item = get_itemlist();
	$current_installation = new installation($current_inspection->IDInstallation);
	$INFOE = get_info('employe',$current_inspection->IDEmploye);
	$INFOR = get_info('responsable',$current_inspection->IDResponsable);
	$Date = getdate($current_inspection->DateI);
	
	$MainOutput->OpenTable('600');
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
	
	
	$MainOutput->AddTexte("Sillery, le ".$Date['mday']." ".$NMois[$Date['mon']]." ".$Date['year']."
 
 
 
 	Bonjour ".strtolower($INFOR['Titre'])." ".ucfirst($INFOR['Nom']).",
	
	",'Titre');

	
	$Date = getdate($current_inspection->DateI);
	$MainOutput->AddTexte("Suite � l'inspection de votre ".strtolower($current_inspection->InspectionType)." (".$current_installation->Nom.") effectu�e le ".$Date['mday']." ".$NMois[$Date['mon']]." ".$Date['year']." par ".$INFOE['Prenom']." ".$INFOE['Nom'].",  nous d�sirons vous informer qu'en vertu du r�glement sur les bains publics LRQ S-3, r-3, vous devrez apporter certains correctifs afin d'avoir des installations conformes. Voici un descriptif des correctifs que nous vous sugg�rons.");
	$MainOutput->br(2);
	$MainOutput->AddTexte('Mat�riel','Titre');
	$MainOutput->br(2);
	foreach($MaterielTrack as $k => $v){
	
		$Prob = false;
		if(!$current_inspection->$k){
			$MainOutput->AddTexte(" - ".$v);
			$MainOutput->br();
			$Prob = true;
		}
	}
	
	if($current_inspection->NotesMateriel<>""){
			$MainOutput->AddTexte(" - ".$current_inspection->NotesMateriel);
			$MainOutput->br();	
	}
	
			if($NBItem==0){
			$MainOutput->AddTexte(" - Votre ".strtolower($current_inspection->InspectionType)." r�pond � toutes les exigences concernant le mat�riel");
			$MainOutput->br();
		}else{
			$MainOutput->AddTexte(" - Votre trousse de premiers soins n'est pas compl�te, veuillez voir les d�tails plus bas");
			$MainOutput->br();
		}
		

	
	$MainOutput->br();
	$MainOutput->AddTexte('Affichage','Titre');
	$MainOutput->br(2);
	$Prob = false;
	Foreach($AffichageTrack as $k => $v){
		if($current_inspection->$k<$v['Taille']){
			$MainOutput->AddTexte(" - ".$v['Message']);
			$MainOutput->br();
			$Prob = true;
		}
		
	}
	if($current_inspection->NotesAffichage<>""){
			$MainOutput->AddTexte(" - ".$current_inspection->NotesAffichage);
			$MainOutput->br();	
	}
	if(!$Prob){
			$MainOutput->AddTexte(" - Votre ".strtolower($current_inspection->InspectionType)." r�pond � toutes les exigences concernant de l'affichage");
			$MainOutput->br();
	}
	
	
	
	if($current_inspection->InspectionType=="Piscine") {
		$MainOutput->br();
		$MainOutput->AddTexte('Construction', 'Titre');
		$MainOutput->br(2);
		$Prob = false;
		foreach ($ConstructionTrack as $k => $v) {
			if (!$current_inspection->$k) {
				$MainOutput->AddTexte(" - " . $v);
				$MainOutput->br();
				$Prob = true;
			}
		}
		if (!$Prob) {
			$MainOutput->AddTexte(" - Votre piscine r�pond � toutes les exigences concernant de la construction");
			$MainOutput->br();
		}

		if ($current_inspection->NotesConstruction <> "") {
			$MainOutput->AddTexte(" - " . $current_inspection->NotesConstruction);
			$MainOutput->br();
		}
	}elseif($current_inspection->InspectionType=="Plage"){

		$NBRessource = array(
			0=>"1 Surveillant-Sauveteur",
			1=>"2 Surveillant-Sauveteurs et 1 Assistant",
			2=>"2 Surveillant-Sauveteurs et 2 Assistants",
			3=>"3 Surveillant-Sauveteurs et 2 Assistants",
			4=>"3 Surveillant-Sauveteurs et 3 Assistants",
		);

		$MainOutput->br();
		$MainOutput->AddTexte('Votre plage doit avoir '.$NBRessource[$current_inspection->LongueurPlage]);
		$MainOutput->br(2);
	}
	
	$MainOutput->br();
	$MainOutput->AddTexte('Achat de mat�riel','Titre');
	$MainOutput->br();
	$MainOutput->AddTexte('Le service de sauveteur est en mesure de vous vendre les �l�ments manquants afin que vous soyez conformes au r�glement. Voici la liste ainsi que les prix rattach�s aux items n�cessaires. S\'ajoutent � ces prix les taxes de ventes applicables.');
	$MainOutput->br(2);
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	
	$MainOutput->OpenCol('230');
		$MainOutput->AddTexte('Item','Titre');
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol('30');
		$MainOutput->AddTexte('<div align=center>Qte</div>','Titre');
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol('120');
		$MainOutput->AddTexte('<div align=center>Prix</div>','Titre');
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol('120');
		$MainOutput->AddTexte('<div align=center>Sous-Total</div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',5);
		$MainOutput->AddOutput("<hr>");
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$Total = 0;
	foreach($QteMateriel as $k=>$v){
		if($QteMateriel[$k]['Unitaire']>0){

			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte($Item[$k]['Description']);
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.$QteMateriel[$k]['Unitaire']);
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Item[$k]['Unitaire'],2)." $");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Item[$k]['Unitaire']*$QteMateriel[$k]['Unitaire'],2)." $",'Titre');
			$MainOutput->CloseCol();
		
			$Total = $Total+$Item[$k]['Unitaire']*$QteMateriel[$k]['Unitaire'];
			$MainOutput->CloseRow();

		}
		
		if($QteMateriel[$k]['Forfait']>0){

			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte($Item[$k]['Description']." - Forfait (x".$Item[$k]['NBForfait'].")");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.$QteMateriel[$k]['Forfait']);
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Item[$k]['Forfait'],2)." $");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Item[$k]['Forfait']*$QteMateriel[$k]['Forfait'],2)." $",'Titre');
			$MainOutput->CloseCol();
				
			$MainOutput->CloseRow();
			$Total = $Total+$Item[$k]['Forfait']*$QteMateriel[$k]['Forfait'];
		}
	
	}
		$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',5);
		$MainOutput->AddOutput("<hr>");
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	
			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=right>'."Sous-Total",'Titre');
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Total,2)." $");
			$MainOutput->CloseCol();
				
			$MainOutput->CloseRow();
			
			
			
			
			
			
			
			
			/**
			
			
			
			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=right>'.'TPS ('.get_vars('TPS').'%)','Titre');
			$MainOutput->CloseCol();
			$TPS = $Total*get_vars('TPS');
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($TPS,2)." $");
			$MainOutput->CloseCol();
				
			$MainOutput->CloseRow();
			
	
	
			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=right>'.'TVQ ('.get_vars('TVQ').'%)','Titre');
			$MainOutput->CloseCol();
			$TVQ = ($Total+$TPS)*get_vars('TVQ');
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($TVQ,2)." $");
			$MainOutput->CloseCol();
				
			$MainOutput->CloseRow();
			
			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=right>'.'Total','Titre');
			$MainOutput->CloseCol();

			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Total+$TPS+$TVQ,2)." $");
			$MainOutput->CloseCol();
				
			$MainOutput->CloseRow();
	**/
	
		$MainOutput->CloseTable();
	
	
	
	
	$MainOutput->br();
	$MainOutput->AddTexte("Ce rapport d'observation a �t� effectu� � la date mentionn�e ci-dessus.  Tout changement survenu par la suite n'est pas mentionn�.  Le personnel de Service de Sauveteurs qn inc vous tiendra inform� du manque de mat�riel, des bris ou autres anomalies en cours d'�t�.  Nous vous remercions de bien vouloir proc�der aux correctifs n�cessaires afin que vous puissiez avoir des installations conformes.  Si vous avez des questions ou besoin de pr�cisions, n'h�sitez pas � communiquer avec nous au (418) 687-4047.");
	
	
	$MainOutput->br(3);
	$MainOutput->AddTexte("___________________________________");
	$INFOW = get_info('employe',$_COOKIE['IDEmploye']);
	$MainOutput->br();
	$MainOutput->AddTexte($INFOW['Prenom']." ".$INFOW['Nom'],'Titre');
	
	
	
	
	
	
	
	
	
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->CloseTable();
	
	
}else{
	include('inspection.php');
}


echo $MainOutput->Send(1);


?>