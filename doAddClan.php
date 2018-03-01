<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 23/02/2018
 * Time: 18:16
 *
 * this check if the clan exist, and if true, it will be added to the register
 */

require_once ("Models/DAO.php");
require_once ("Models/Utility.php");
$tagClan = $_REQUEST["addClan"];
$tagClan = str_replace("#", "", $tagClan);
$clanInfo = Utility::get_api("https://api.clashofclans.com/v1/clans/%23$tagClan", true);

if(isset($clanInfo->{'tag'})) {
    DAO::insertClanRecord($clanInfo->{'tag'}, $clanInfo->{'name'});
    header("Location: index.php?error=0&clan=".$clanInfo->{'tag'});
}
else{
    header("Location: index.php?error=1");
}
exit();
