<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 16/02/2018
 * Time: 12:49
 *
 * index of the register, only a test script
 * you can find an example at: https://apicoc.000webhostapp.com/
 */
require_once ("Models/DAO.php");
include_once ("cron.php");
$clansRecorded = DAO::getClansRecord();

$clan=$clansRecorded[0];
if(isset($_REQUEST["clan"]))
    if(DAO::hasClansRecorded($_REQUEST["clan"]))
        $clan = DAO::getClanRecordByTag($_REQUEST["clan"]);

if(isset($_REQUEST["error"]))
    switch ($_REQUEST["error"]){
        case 0:
            echo '<script language="javascript"> alert("Clan Added")</script>';break;
        case  1:
            echo '<script language="javascript"> alert("Error. Check if tag is correct")</script>';break;
    }
?>
<html>
<body>
<h1>Donations Register (Beta)</h1>
<form method="post" action="index.php">
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

<form method="post" action="doAddClan.php">
    <label for="addClan">Add a Clan to register</label>
    <input type="text" name="addClan" id="addClan"/>
    <button type="submit">Add</button>
</form>

<p><i>The register will update approximately every 10/15 minutes. For more informations please refer to <a href="mailto:iranpalangofficial@gmail.com">iranpalangofficial@gmail.com</a></i></p>

<?php

try {
    echo '<h2 style="color: red;">Clan: ' . $clan->getName() . ' (' . $clan->getTagClan() . ') </h2>';
    $logs = DAO::getLogsDonated($clan->getTagClan());
    echo '
    <h3 class="centered">Donated</h3>
    <table style="text-align: center;">
    <tr><td><b>Player</b></td><td><b>Tag</b></td><td><b>Donations</b></td><td><b>Date</b></td></tr>';
    foreach ($logs as $log) {
        echo '<tr><td>' . $log->getName() . '</td><td>' . $log->getTag() . '</td><td>' . $log->getDonations() . '</td><td>' . $log->getDate() . '</td></tr>';
    }
    echo '</table><br>';

    $ricevute = DAO::getLogsReceived($clan->getTagClan());
    echo '
    <h3 class="centered">Received</h3>
    <table style="text-align: center;">
        <tr><td><b>Player</b></td><td><b>Tag</b></td><td><b>Donations</b></td><td><b>Date</b></td></tr>';
    foreach ($ricevute as $log) {
        echo '<tr><td>' . $log->getName() . '</td><td>' . $log->getTag() . '</td><td>' . $log->getDonations() . '</td><td>' . $log->getDate() . '</td></tr>';
    }
    echo '</table><br>';
}
catch (Exception $e){
    print $e->getMessage();
}
?>

</body>
</html>

