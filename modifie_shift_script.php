<?PHP
if(isset($_POST['IDShift'])){
	$Info = get_shift_info($_POST['IDShift']);
	$_GET['Semaine'] = $Info['Semaine'];
	$SQL = new SQLclass();
	$SQL2 = new SQLclass();
	if($_POST['FORMRec']==""){
		$_POST['FORMRec']=1;
	}
	if(!isset($_POST['FORMAssistant']))
		$_POST['FORMAssistant']=0;	
	if(!isset($_POST['FORMConfirme']))
		$_POST['FORMConfirme']=0;
	
	if(!isset($_POST['FORMIDEmploye']))
		$_POST['IDEmploye']=NULL;
        $EndWeek = get_next_sunday($_POST['FORMRec']-2, $Info['Semaine']);
       	if($_POST['FORMStart2']=="" || $_POST['FORMEnd2']==0){
		
		while($Info['Semaine']<=$EndWeek){
			$Req = "SELECT IDShift FROM shift WHERE Semaine='".$Info['Semaine']."' AND IDInstallation = '".$_POST['IDInstallation']."' AND Jour='".$_POST['FORMJour']."' AND Start = '".$Info['Start']."' AND Assistant = '".$_POST['FORMAssistant']."'";
			$SQL->Select($Req);
			$IDShift = $SQL->FetchArray();
			$Req = "DELETE FROM shift WHERE `IDShift`='".$IDShift[0]."'";
                        echo "<br>".$Req;
			$SQL->QUERY($Req);
			$Info['Semaine'] = get_next_sunday(0,$Info['Semaine']);
		}
	}else{
	
		//Je ramasse ce qui caract�rise le shift Jour, D�but, fin, piscine

		$OldStart = $Info['Start'];
		$OldEnd = $Info['End'];
		$Start = 60*($_POST['FORMStart1']+60*$_POST['FORMStart2']);
		$End = 60*($_POST['FORMEnd1']+60*$_POST['FORMEnd2']);
		while($Info['Semaine']<=$EndWeek){		
		//Requete qui va chercher le ID du shift selon les caract�ristique du shift s�lecitonn�
		// il faut noter qu'ici seulement les shift qui ont le m�me d�but seront s�lectionn�s
			$Req = "SELECT IDShift FROM shift WHERE Semaine='".$Info['Semaine']."' AND IDInstallation = '".$_POST['IDInstallation']."' AND Jour='".$_POST['FORMJour']."' AND Start = '".$Info['Start']."' AND Assistant = '".$_POST['FORMAssistant']."' ";
			$SQL->Select($Req);
			$IDShift = $SQL->FetchArray();
		
		if(isset($_POST['FORMAttach'])){
			// REQUETE QUI V�RIFIE S'IL Y A UN SHIFT QUI FINI TOUT DE SUITE AVANT
			
			$Req = "SELECT IDShift FROM shift WHERE IDInstallation = '".$_POST['IDInstallation']."' && `Jour`='".$_POST['FORMJour']."' && `End`='".$OldStart."'  && `Semaine`='".$Info['Semaine']."'&& Assistant='".$_POST['FORMAssistant']."' ";
			$SQL->SELECT($Req);
			while($Rep = $SQL->FetchArray()){
				$Req2 = "UPDATE shift SET `End`= '".$Start."' WHERE `IDShift`='".$Rep['IDShift']."'";
				$SQL2->UPDATE($Req2);
			}
			
			// REQUETE QUI V�RIFIE S'IL Y A UN SHIFT QUI COMMENCE TOUT DE SUITE APR�S
			
			$Req = "SELECT IDShift FROM shift WHERE IDInstallation = '".$_POST['IDInstallation']."' && `Jour`='".$_POST['FORMJour']."' && `Start`='".$OldEnd."' && `Semaine`='".$Info['Semaine']."' && Assistant='".$_POST['FORMAssistant']."'";
			$SQL->SELECT($Req);
			while($Rep = $SQL->FetchArray()){
				$Req2 = "UPDATE shift SET `Start`= '".$End."' WHERE `IDShift`='".$Rep['IDShift']."'";
				$SQL2->UPDATE($Req2);
			}
		}	
			
			
			// REQUETE QUI V�RIFIE SI UN SHIFT ENGLOBE UN AUTRE AVANT AU COMPLET 
			
			$Req = "SELECT IDShift FROM shift WHERE IDInstallation = '".$_POST['IDInstallation']."' && `Jour`='".$_POST['FORMJour']."' && `Start`='".$Start."' && `Semaine`='".$Info['Semaine']."' && Assistant='".$_POST['FORMAssistant']."' && IDShift<>'".$IDShift[0]."'";
			$SQL->SELECT($Req);
			
			while($Rep = $SQL->FetchArray()){
			
				$Req2 = "DELETE FROM shift WHERE `IDShift`='".$Rep['IDShift']."'";
				$SQL2->QUERY($Req2);
			}
			
			// REQUETE QUI V�RIFIE SI UN SHIFT ENGLOBE UN AUTRE APR�S AU COMPLET
			
			$Req = "SELECT IDShift FROM shift WHERE IDInstallation = '".$_POST['IDInstallation']."' && `Jour`='".$_POST['FORMJour']."' && `End`='".$End."'  && `Semaine`='".$Info['Semaine']."'&& Assistant='".$_POST['FORMAssistant']."' && IDShift<>'".$IDShift[0]."'";
			$SQL->SELECT($Req);
			while($Rep = $SQL->FetchArray()){
		
		
				$Req2 = "DELETE FROM shift WHERE `IDShift`='".$Rep['IDShift']."'";
				$SQL2->QUERY($Req2);
			}

		
			$Req = "UPDATE shift SET
			`Start`='".$Start."',
			`End`='".$End."',
			`Jour`='".$_POST['FORMJour']."',
			`Assistant`='".$_POST['FORMAssistant']."',
			`TXH`='".$_POST['FORMTXH']."',
			`Salaire`='".$_POST['FORMSalaire']."',
			`Commentaire`='".addslashes($_POST['FORMCommentaire'])."',
			`Warn`='".addslashes($_POST['FORMWarn'])."',
			`IDEmploye`='".addslashes($_POST['FORMIDEmploye'])."',
			`Confirme` ='".$_POST['FORMConfirme']."'
			WHERE `IDShift`='".$IDShift[0]."'";
		$SQL->QUERY($Req);
		
		$Req = "UPDATE remplacement SET
			`IDEmployeE` = '".$_POST['FORMIDEmploye']."'
			WHERE `IDShift` = '".$IDShift[0]."'";
                
		$SQL->QUERY($Req);
			$Info['Semaine'] = get_next_sunday(0,$Info['Semaine']);
		}
	}
}

	?>


<script language=JAVASCRIPT>
history.back(2);
</script>
