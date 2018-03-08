<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 16/02/2018
 * Time: 12:49
 *
 * inactive members page
 */
require_once ("Models/DAO.php");
require_once ("Models/Utility.php");
require_once ("Models/Player.php");
include_once ("cron.php");

$clansRecorded = DAO::getClansRecord();

$clan=$clansRecorded[0];
if(isset($_REQUEST["clan"]))
    if(DAO::hasClansRecorded($_REQUEST["clan"]))
        $clan = DAO::getClanRecordByTag($_REQUEST["clan"]);

$all=false;
if(isset($_REQUEST["all"])){
    $all = true;
}

include_once ("Commons/Header.html");
?>
<html>
<body>
<h2>Inactive Members</h2>
<form method="post" action="inactiveMembers.php">
    <label for="selectClan">Select a Clan</label>
    <select name="clan" id="selectClan">
        <?php
        foreach ($clansRecorded as $record) {
            if(strcasecmp($record->getTagClan(),$clan->getTagClan())==0)
                echo'
            <option value="'.$record->getTagClan().'" selected>'.$record->getName().'</option>
            ';
            else
                echo'
            <option value="'.$record->getTagClan().'">'.$record->getName().'</option>
            ';
        }
        ?>
    </select>
    <button type="submit">Refresh</button>
</form>

<p><i>The register will update approximately every 10/15 minutes. For more informations please refer to <a href="mailto:iranpalangofficial@gmail.com">iranpalangofficial@gmail.com</a></i></p>
<p>Every player score is earned from: attacks won, donations made, donations received, war stars, trophies, xp (every field has got a different weight).</p>

    <?php
    try{
        $t = "'".$clan->getTagClan()."'";
        echo'
        <p><i>Note: the role inside the clan is significant. Press <a href="#" onclick="post('.$t.');">here</a> to see all members.</i></i></p>
        <br>
        <div>
        <h3 style="color: red;">Clan: ' . $clan->getName() . ' (' . $clan->getTagClan() . ') </h3>
        ';
        $membri = Utility::get_api('https://api.clashofclans.com/v1/clans/%23'.str_replace("#","",$clan->getTagClan()).'/members', true);
        $players = array();
        $inattivi = array();
        foreach($membri->{'items'} as $key => $membro) {
            $role=1;
            $tag = $membro-> {'tag'};
            $playerInfo = Utility::get_api('https://api.clashofclans.com/v1/players/' . str_replace('#', '%23', $tag), true);
            if (isset($playerInfo->{'league'})) {
                $shield = true;
                $badge_url = $playerInfo->{'league'}->{'iconUrls'}->{'medium'};
            }
            else {
                $shield = false;
                $badge_url = "https://api-assets.clashofclans.com/leagues/72/e--YMyIexEQQhE4imLoJcwhYn6Uy8KqlgyY3_kFV6t4.png";
            }

            $nome = $playerInfo->{'name'};
            $th = $playerInfo->{'townHallLevel'};
            $trophies = Utility::check_exist('trophies', $playerInfo);
            $war_stars = Utility::check_exist('warStars', $playerInfo);
            $attacks_win = Utility::check_exist('attackWins', $playerInfo);
            $defense_win =  Utility::check_exist('defenseWins', $playerInfo);
            $donations = Utility::check_exist('donations', $playerInfo);
            $donationsReceived = Utility::check_exist('donationsReceived', $playerInfo);
            $xp = Utility::check_exist('expLevel', $playerInfo);

            if(isset($playerInfo->{'clan'})) {
                switch ($playerInfo->{'role'}) {
                    case "leader":
                        $role = 4;
                        break;
                    case "coLeader":
                        $role = 3;
                        break;
                    case "admin":
                        $role = 2;
                        break;
                    default:
                        $role = 1;
                        break;
                }
                $clanTag = $playerInfo->{'clan'}->{'tag'};
                $clanName = $playerInfo->{'clan'}->{'name'};
            }
            else{
                $role = "";
                $clanTag = "";
                $clanName = "";
            }

            $result = Utility::check_inactive($attacks_win, $donations, $donationsReceived, $shield, $xp, $war_stars, $trophies, $role);
            $players[$tag] = Player::newInstance($tag,$nome,$badge_url,$th,$trophies,$war_stars,$attacks_win,$defense_win,$donations,$donationsReceived,$xp,$result,$role,$clanTag,$clanName);
            $inattivi[$tag] = $result;
        }

        asort($inattivi);
        $i=0;
        $stop=false;    //quando deve finire di visualizzare inattivi
        echo'
        <table style="text-align: center;">
        <tr><td><b>Inactive Rank</b></td><td><b>Player</b></td><td><b>Tag</b></td><td><b>Role</b></td><td><b>Attacks Won</b></td><td><b>Donations</b></td></tr>';
        foreach($inattivi as $key => $inattivo_result)
        {
            if(!$stop){
                if(!$all && $inattivo_result>=2.65) //clausola perchè si fermi di visualizzare gli inattivi      && $i>=3 && ($i%4==3)
                    $stop = true;
                if(!$stop)
                    printPlayer($players[$key], $i+1);
                $i++;
            }
        }
        echo '</table><br></div>';
        if($i==0)
            echo'<p>No inactive players detected</p>';
    }
    catch (Exception $e){
        print $e->getMessage();
    }
    ?>

</body>
</html>

<?php

function printPlayer($player, $rank){
    $role = "";
    switch ($player->getRole()){
        case 4: $role="Leader";break;
        case 3: $role="Co-Leader";break;
        case 2: $role="Elder";break;
        default:$role="Member";break;
    }

    echo '<tr><td>' . $rank . ')</td><td>' . $player->getName() . '</td><td>' . $player->getTag() . '</td><td>' . $role . '</td><td>' . $player->getAttackswon() . '</td><td>' . $player->getDonations() . '</td></tr>';
}

?>

<script>
    // Post to the provided URL with the specified parameters.
    function post(clan) {
        var form = $('<form></form>');

        form.attr("method", "post");
        form.attr("action", "inactiveMembers.php");

        var fieldClan = $('<input/>');
        fieldClan.attr("type", "hidden");
        fieldClan.attr("name", "clan");
        fieldClan.attr("value", clan);

        var fieldAll = $('<input/>');
        fieldAll.attr("type", "hidden");
        fieldAll.attr("name", "all");
        fieldAll.attr("value", "yes");

        form.append(fieldClan);
        form.append(fieldAll);

        // The form needs to be a part of the document in
        // order for us to be able to submit it.
        $(document.body).append(form);
        form.submit();
    }
</script>
