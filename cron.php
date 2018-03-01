<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 15/02/2018
 * Time: 23:21
 *
 * cronjob that call the check function on new records
 */

require_once ("Models/DAO.php");
require_once ("Models/Record.php");
require_once ("Models/Utility.php");

$clansRecorded = DAO::getClansRecord();
foreach ($clansRecorded as $clan) {

    $tagClan = str_replace("#", "", $clan->getTagClan());
    $clanInfo = Utility::get_api("https://api.clashofclans.com/v1/clans/%23$tagClan", true);

    foreach ($clanInfo->{'memberList'} as $member) {
        try {
            $record = Record::newInstance($member->{'tag'},$member->{'name'},$member->{'donations'},$member->{'donationsReceived'},$clan->getTagClan());
            Utility::checkLogsDb($record);
        }
        catch (Exception $e){
            print $e->getMessage();
        }
    }
}
?>