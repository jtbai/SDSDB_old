<?PHP

//Cr�ation de la liste de mat�riel
function materielneeded($IDInspection){
	$INFO = get_info('inspection',$IDInspection);
	$Materiel = array();
	
	
	$MaterielTrack = array();
	
	//Trousse de premiers soins
	$MaterielTrack[] = array('Champ'=>'Manuel','IDItem'=>1,'Needed'=>1);
	$MaterielTrack[] = array('Champ'=>'Antiseptique','IDItem'=>2,'Needed'=>20);
	$MaterielTrack[] = array('Champ'=>'Epingle','IDItem'=>3,'Needed'=>24);
	$MaterielTrack[] = array('Champ'=>'Pansement','IDItem'=>4,'Needed'=>24);
	$MaterielTrack[] = array('Champ'=>'BTria','IDItem'=>5,'Needed'=>6);
	$MaterielTrack[] = array('Champ'=>'Gaze50','IDItem'=>6,'Needed'=>4);
	$MaterielTrack[] = array('Champ'=>'Gaze100','IDItem'=>7,'Needed'=>4);
	$MaterielTrack[] = array('Champ'=>'Ouate','IDItem'=>8,'Needed'=>4);
	$MaterielTrack[] = array('Champ'=>'Gaze75','IDItem'=>9,'Needed'=>12);
	$MaterielTrack[] = array('Champ'=>'Compressif','IDItem'=>10,'Needed'=>4);
	$MaterielTrack[] = array('Champ'=>'Tape12','IDItem'=>11,'Needed'=>1);
	$MaterielTrack[] = array('Champ'=>'Tape50','IDItem'=>12,'Needed'=>1);
	$MaterielTrack[] = array('Champ'=>'Eclisses','IDItem'=>13,'Needed'=>1);
	
	//Recommand�
	$MaterielTrack[] = array('Champ'=>'Ciseau','IDItem'=>14,'Needed'=>1);
	$MaterielTrack[] = array('Champ'=>'Pince','IDItem'=>15,'Needed'=>1);
	$MaterielTrack[] = array('Champ'=>'Masque','IDItem'=>16,'Needed'=>1);
	$MaterielTrack[] = array('Champ'=>'Gant','IDItem'=>17,'Needed'=>1);

	//Section Mat�riel
//	$MaterielTrack[] = array('Champ'=>'Verre','IDItem'=>18,'Needed'=>1);
//	$MaterielTrack[] = array('Champ'=>'Bousculade','IDItem'=>19,'Needed'=>1);
	$MaterielTrack[] = array('Champ'=>'Planche','IDItem'=>20,'Needed'=>1);
	$MaterielTrack[] = array('Champ'=>'Perche','IDItem'=>21,'Needed'=>1);
	$MaterielTrack[] = array('Champ'=>'Couverture','IDItem'=>22,'Needed'=>1);
		
	foreach($MaterielTrack as $Rail){
		$Materiel[$Rail['IDItem']] = getquantity($Rail['IDItem'], $INFO[$Rail['Champ']], $Rail['Needed']);
	}
	return $Materiel;
}

function getquantity($IDItem, $Stock, $Needed){
	if($Stock>=$Needed){
		return array('Unitaire'=>0,'Forfait'=>0);
	}else{
		$INFO = get_info('item',$IDItem);
		if(is_null($INFO['NBForfait'])){
			return array('NBUnitaire'=>$Needed-$Stock,'Forfait'=>0);
		}else{
			//Prix sans forfait
			$OldPrix = ($Needed-$Stock) * $INFO['Prix1'];
			//Nombre de forfait n�ssaires
			$NBForfait = ceil(($Needed-$Stock)/$INFO['NBForfait']);
			$i = 1;
			while($i<=$NBForfait){
				$NewPrix = max(0,$Needed-$Stock-$INFO['NBForfait']*$i)*$INFO['Prix1']+$i*$INFO['PrixForfait'];
				if($NewPrix>$OldPrix){
					return array('Unitaire'=>max(0,$Needed-$Stock-$INFO['NBForfait']*($i-1)),'Forfait'=>$i-1);
					$i = $NBForfait+1;
				}
				$i++;				
			}
			return array('Unitaire'=>max(0,$Needed-$Stock-$INFO['NBForfait']*($NBForfait)),'Forfait'=>$NBForfait);
			//retourner avec la derniere quantit� roul�e
		}
	}
}

if(isset($_GET['IDInspection'])){
$NMois = get_month_list();
	$INFO = get_info('inspection',$_GET['IDInspection']);
	$MaterielTrack = array();
	$MaterielTrack['Mirador'] = "Comme votre piscine � plus de 150m2, il est obligatoire d'avoir un mirador";
	$MaterielTrack['SMU'] = "La sauveteur doit avoir acc�s a un moyen de communication avec les services m�dicaux d'urgence, il est n�ssaire de mettre un t�l�phone � la disposition du sauveteur";
	$MaterielTrack['Procedures'] = "Les proc�dures d'urgences doivent �tre affich�es pr�s du moyen de communication";
	$MaterielTrack['Perche'] = "Une perche isol�e �lectriquement doit �tre mise � la disposition du sauveteur";
	$MaterielTrack['Bouees'] = "2 bou�es de sauvetages de 275mm � 380mm de largeur avec un cordage de 3m + � largeur de la piscine doivent �tre mises � la disposition du sauveteur (ou une Bou�e torpille avec 2m de cordage et bandouill�re";
	$MaterielTrack['Planche'] = "La planche dorsale fait parti du mat�riel obligatoire � d�tenir sur le bord d'une piscine";
	$MaterielTrack['Couverture'] = "Une couverture doit se trouver � la piscine";
	$MaterielTrack['Registre'] = "Un registre des installation doit se trouver � la pisince";
	$MaterielTrack['Chlore'] = "Le sauveteur doit avoir du mat�riel pour faire les tests d'eau (Chlore et pH)";
	
	$AffichageTrack = array();
	$AffichageTrack['ProfondeurPP'] = "La profondeur de la piscine au peu profond doit �tre inscrite en caract�re d'au moins 100mm de haut";
	$AffichageTrack['ProfondeurP'] = "La profondeur de la piscine au profond doit �tre inscrite en caract�re d'au moins 100mm de haut";
	$AffichageTrack['ProfondeurPente'] = "La profondeur de la piscine dans le milieu de la pente doit �tre inscrite en caract�re d'au moins 100mm de haut";
	$AffichageTrack['Cercle'] = "Un cercle noir d'un diam�tre d'au moins 150mm doit �tre dessin� au point le plus profond de la piscine";
	$AffichageTrack['Verre'] = "Le r�glement \"Interdiction de contenants de vitre\" doit �tre �crit en un caract�re d'au moins 25mm de haut - Un pictogramme est �quivalent";
	$AffichageTrack['Bousculade'] = "Le r�glement \"Bousculade Interdite\" doit �tre �crit en un caract�re d'au moins 25mm de haut - Un pictogramme est �quivalent";
	$AffichageTrack['Maximum'] = "Le r�glement \"Bousculade Interdite\" doit �tre �crit en un caract�re d'au moins 25mm de haut - Un pictogramme est �quivalent";
	
	$ConstructionTrack = array();
	$ConstructionTrack['EchellePP'] = "Le peu profond de la piscine doit �tre accessible via une �chelle ou des escaliers";
	$ConstructionTrack['EchelleX2P'] = "Une �chelle de chaque partie du profond doit �tre install�e";
	$ConstructionTrack['Escalier'] = "Le nez des marches du peu profond doivent �tre peintur�es d'une couleur contrastante";
	$ConstructionTrack['Cloture12'] = "La cl�ture entourant la piscine doit au minimum avoir 1.20m de hauteur";
	$ConstructionTrack['Cloture100'] = "La cl�ture entourant la piscine ne doit pas faire passer d'objet de plus de 100mm de diam�tre";
	$ConstructionTrack['Maille38'] = "La maille de la cl�ture doit �tre inf�rieure � 38mm";
	$ConstructionTrack['Promenade'] = "La promenade acc�ssible lorsque la piscine est ferm�e doit avoir une cloture d'au moins 900mm de hauteur";
	$ConstructionTrack['Fermeacle'] = "Il doit �tre possible de v�rouilles les points d'acc�s � la piscine lorsque celle-ci est ferm�e";
	
	
	$INFOP = get_info('installation',$INFO['IDInstallation']);
	$INFOE = get_info('employe',$INFO['IDEmploye']);
	$Date = getdate($INFO['DateI']);
	
	$MainOutput->OpenTable('600');
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte("Suite � l'inspection de votre piscine( ".$INFOP['Nom'].") effectu�e le ".$Date['mday']." ".$NMois[$Date['mon']]." ".$Date['year']." par ".$INFOE['Prenom']." ".$INFOE['Nom'].",  nous d�sirons vous informer qu'en vertu du r�glement sur les bains publics LRQ S-3, r-3, vous devrez apporter certains correctifs afin d'avoir des installations conformes. Voici un descriptif des correctifs que nous vous sugg�rons.");
	$MainOutput->br(2);
	$MainOutput->AddTexte('Materiel','Titre');
	$MainOutput->br(2);
	foreach($MaterielTrack as $k => $v){
		if(!$INFO[$k]){
		$MainOutput->AddTexte(" - ".$v);
		$MainOutput->br();
		}
	}

	$MainOutput->br();
	$MainOutput->AddTexte('Construction','Titre');
	$MainOutput->br(2);
	foreach($ConstructionTrack as $k => $v){
		if(!$INFO[$k]){
		$MainOutput->AddTexte(" - ".$v);
		$MainOutput->br();
		}
	}
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->CloseTable();
	
}else{
	include('inspection.php');
}


echo $MainOutput->Send(1);


?>