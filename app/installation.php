<?php
include_once('BaseModel.php');
class Installation extends BaseModel
{
    public $IDInstallation;
    public $IDClient;
    public $IDResponsable;
    public $IDHoraire;
    public $IDSecteur;
    public $Cote;
    public $Nom;
    public $Tel;
    public $Lien;
    public $Adresse;
    public $Notes;
    public $Actif;
    public $IDType;
    public $Punch;
    public $Toilettes;
    public $Assistant;
    public $Cadenas;
    public $Balance;
    public $Saison;
    public $Seq;
    public $Seqc;
    public $Factname;
    public $ASFact;
    public $AdresseFact;
    public $Inspections;
    public $PONo;
    public $Stationnement;

    static function define_table_info(){
        return array("model_table" => 'installation',
                     "model_table_id" => 'IDInstallation');
    }

    static function get_installations_in_string_to_bill($semaine){

      $SQL = new sqlclass;
      $Req = "SELECT Cote, sum(Facture) as isBilled FROM shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE `Semaine`=".$semaine." GROUP BY Cote HAVING isBilled=0 ORDER BY Cote ASC ";
      $SQL->select($Req);
      $Installation = array();
      while($Rep = $SQL->FetchArray()){
          $Installation[$Rep[0]] = get_installation_by_cote_in_string($Rep[0]);
      }
      $SQL->CloseConnection();

      return $Installation;
    }

    static function get_installations_to_bill($cote, $semaine){

        $SQL = new sqlclass;
        $Req = "SELECT installation.IDInstallation, sum(shift.Facture) as isBilled FROM shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE `Semaine`=".$semaine." and `Cote`='".$cote."' GROUP BY installation.IDInstallation HAVING isBilled=0 ORDER BY Cote ASC ";
        $SQL->select($Req);
        $Installations = array();
        while($installation_results_set = $SQL->FetchArray()){
            $Installations[] = new Installation($installation_results_set['IDInstallation']);
        }
        $SQL->CloseConnection();

        return $Installations;
    }


    function fill_facture(&$Facture){
        $shifts = $this->get_billable_shift_by_installation($Facture->Semaine);
        foreach ($shifts as $current_shift) {
            $current_shift->add_to_facture($Facture);
        }
    }

    function get_billable_shift_by_installation($Semaine){

        $sql = new SqlClass();
        $Req = "SELECT shift.IDShift FROM shift JOIN installation JOIN client on shift.IDInstallation = installation.IDInstallation AND client.IDClient = installation.IDClient WHERE shift.IDInstallation = ".$this->IDInstallation." AND Semaine=".$Semaine." ORDER BY installation.Nom ASC, Jour ASC, shift.Assistant ASC, Start ASC";
        $sql->SELECT($Req);
        $shifts  = array();
        while($shift_result = $sql->FetchArray()){
            $shifts[] = new Shift($shift_result['IDShift']);
        }

        return $shifts;
    }
}
