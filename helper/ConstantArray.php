<?php
/**
 * Created by PhpStorm.
 * User: jtbai
 * Date: 05/06/18
 * Time: 9:59 AM
 */

class ConstantArray
{
    static function get_installation_type_kvp(){
        $installation_type_kvp = array('I'=>'Int�rieure','IS'=>'Int�rieure + Spa','E'=>'Ext�rieure','ES'=>'Ext�rieure + Spa','EP'=>'Ext�rieure + Patogeoire','P'=>'Plage');

        return $installation_type_kvp;
    }

    static function get_installation_parking_type_kvp(){
        $installation_parking_type_kvp = array('DG'=>'Disponible Gratuit','DP'=>'Disponible Payant','ND'=>'Non-Disponible');

        return $installation_parking_type_kvp;
    }
}