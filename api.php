<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 30/01/2018
 * Time: 19:34
 *
 * this file is used to send request to Clash API and print the json response, if you need to made a call without a token from some other application.
 * https://apicoc.000webhostapp.com/api.php can be used to do that.
 */
require_once("Models/Utility.php");
$api = null;
if(isset($_REQUEST["api"])){
    $request = $_REQUEST["api"];
    $request = str_replace('#','%23',$request);
    $api = Utility::get_api($request, false);

   echo($api);
}
else
    index();


/**
 * print a request hint
 */
function index(){
    echo'
    <h3>No request made</h3>
    <h4>To made a request:</h4>
    <form method="post" action="api.php">
            <p style="margin-bottom: 0.5em; margin-top: 0.5em;">Get a request from Clash API:</p>
            <p style="margin-bottom: 0.5em; margin-top: 0.5em;">Curl request: <i>"http://apicoc.000webhostapp.com/api.php?api=$request"</i></p>
            <p style="margin-bottom: 0.5em; margin-top: 0.5em;"><i>$request = see Clash API documentations and paste here a request like following example</i></p>
		      <input type="text" name="api" placeholder="https://api.clashofclans.com/v1/clans/%23PVVL92PP" style="width: 25em;" required>
		      <button type="submit" >Try out</button>
        </form>
    ';
}

?>
