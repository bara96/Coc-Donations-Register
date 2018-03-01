<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 09/09/2017
 * Time: 02:38
 */
require_once ("DAO.php");
require_once ("Record.php");
require_once ("Log.php");

class Utility
{

    /**
     * return a json response of a coc API request
     * if decode=true the result will be json_decoded, else not
     * @param string $URL
     * @param string $decode
     * @return mixed|string
     */
    public static function get_api($URL, $decode)
    {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_URL, $URL);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6IjdiYjJlNDMyLTg0ZTUtNDRlZi1hZmZhLTY4MzFkYjBkMjNkYyIsImlhdCI6MTUxODc4MjM0NSwic3ViIjoiZGV2ZWxvcGVyLzk3ZjFhMjMzLTk0YjQtYzI4Ni1lMTlkLTMzMWYzNTE0ZDk5MSIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjE1My45Mi4wLjIyIl0sInR5cGUiOiJjbGllbnQifV19.XOkFVYinq2arXHCpv_p_L7IgCtUa2esUodkQVpZsVfZSvn3M3AEvXufZ7vwGOTo0L_Uqc068KqkP29MuxH26BQ'
            )); // Clash of Clans API Token
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            $json = curl_exec($curl);
            curl_close($curl);
            if($decode)
                $api = json_decode($json);
            else
                $api = $json;
            //var_dump($api); // Print Output
            return $api;
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * return the api field if exist, else 0
     * $string is the api field
     * $api is a get_api($URL, false) object
     * @param string $string
     * @param mixed $api
     * @return int
     */
    public static function check_exist($string, $api){
        if(isset($api->{"$string"}))
            return $api->{"$string"};
        else
            return 0;
    }

    /**
     * core function of the donation register.
     * check the difference between records stored and a new record, and update the db with the new record as well.
     * @param $newrecord
     * @throws Exception
     */
    public static function checkLogsDb($newrecord)
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Europe/Rome'));
        $now = $date->format('Y/m/d H:i:s');
        $check = DAO::checkRecordbyTag($newrecord->getTag(),$newrecord->getTagClan());
        $i=0;
        foreach ($check as $c){
          $i++;
        }
        if($i==0){  //nuovo membro
            DAO::insertRecordDonated($newrecord->getTag(),$newrecord->getName(),$newrecord->getDonations(), $newrecord->getTagClan()); //aggiungi record
            DAO::insertRecordReceived($newrecord->getTag(),$newrecord->getName(),$newrecord->getReceived(), $newrecord->getTagClan()); //aggiungi record
            if($newrecord->getDonations()>0)
                DAO::insertLogDonated($newrecord->getName(),$newrecord->getDonations(),$now,$newrecord->getTag(), $newrecord->getTagClan());    //aggiungi log
            if($newrecord->getReceived()>0)
                DAO::insertLogReceived($newrecord->getName(),$newrecord->getReceived(),$now,$newrecord->getTag(), $newrecord->getTagClan());    //aggiungi log
        }
        else {  //membro presente
            if ($newrecord->getDonations() != $check[0]->getDonations()) {
                $differenza = $newrecord->getDonations() - $check[0]->getDonations();
                if ($differenza <= 0)
                    $differenza = $newrecord->getDonations();
                $nome = $newrecord->getName();
                if ($differenza > 0)
                    DAO::insertLogDonated($nome, $differenza, $now, $newrecord->getTag(), $newrecord->getTagClan());    //aggiungi log
                DAO::updateRecordDonated($newrecord->getTag(), $newrecord->getName(), $newrecord->getDonations(), $newrecord->getTagClan());  //aggiorna record
            }
            if ($newrecord->getReceived() != $check[0]->getReceived()) {
                $differenza = $newrecord->getReceived() - $check[0]->getReceived();
                if ($differenza <= 0)
                    $differenza = $newrecord->getReceived();
                $nome = $newrecord->getName();
                if ($differenza > 0)
                    DAO::insertLogReceived($nome, $differenza, $now, $newrecord->getTag(), $newrecord->getTagClan());    //aggiungi log
                DAO::updateRecordReceived($newrecord->getTag(), $newrecord->getName(), $newrecord->getReceived(), $newrecord->getTagClan());  //aggiorna record
            }
        }

    }

}