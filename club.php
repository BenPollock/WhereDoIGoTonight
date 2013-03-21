<html>
<head>
<title>WDIGT</title>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Didact+Gothic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<?php
 
 global $relativewidth;
 
$mobile_browser = '0';
 
if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
}
 
if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
}    
 
$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-');
 
if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}
 
if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0) {
    $mobile_browser++;
}
 
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
    $mobile_browser = 0;
}
 
if ($mobile_browser > 0) {
   $relativewidth = 1;
}
else {
   // do something else
  $relativewidth = 0;
}   
?>


<?php
//Create the club class
class club{
	public $clubName;
	public $clubAddress;
	public $clubPhone;
	public $clubWebsite;
	public $clubEvent;
	
	function club($a, $b, $c, $d, $e){
		$this->clubName = $a;
		$this->clubAddress = $b;
		$this->clubPhone = $c;
		$this->clubWebsite = $d;
		$this->clubEvent = $e;
	}
	
	function getClubName(){
		return $this->clubName;
	}
	function getClubAddress(){
		return $this->clubAddress;
	}
	function getClubPhone(){
		return $this->clubPhone;
	}
	function getClubWebsite(){
		return $this->clubWebsite;
	}
	function getClubEvent(){
		return $this->clubEvent;
	}
}


//Connect to database
$link = mysql_connect('localhost', 'demo_clubs', 'demo') or die ('Could not connect');
mysql_select_db('anantv_clubs') or die('Error');

//Get all the clubs
$getClub = 'SELECT * FROM CLUB';
$allclubs = mysql_query($getClub, $link);

//Global Var
global $clubs;
global $chosenClub;

//Put the clubs in the array
while($line = mysql_fetch_array($allclubs)){
$multiplier = $line[5];
$clubid = $line[0];

//See if there are any events that might increase the club's popularity
//Get the events
$dayofweek = date("w");
$getEvent = "SELECT * FROM EVENT WHERE DayNum = '$dayofweek' AND ClubID = '$clubid'";
$allevents = mysql_query($getEvent, $link);

//It's safe to assume there's only going to be one event per club per day, so let's get the first one
$event_description;
$event_description = null;
$multiplier_event = 0;
while($line2 = mysql_fetch_array($allevents)){
$multiplier_event = $line2[5];
$event_description = $line2[2];
}
mysql_free_result($allevents);

//Multiplier the club multiplier by the event multiplier if it's not 0
if($multiplier_event != 0)
$multiplier = $multiplier * $multiplier_event;



//Make the clubs more likely based on multiplier
for($i = 0; $i < $multiplier; $i++){
$temp = new club($line[1], $line[2], $line[3], $line[4], $event_description);
$clubs[] = $temp;

}

}

//Free result
mysql_free_result($allclubs);
//Close
mysql_close($link);

//Get a random club to chose from
$randClub = rand(0, count($clubs) - 1);
$chosenClub = new club($clubs[$randClub]->getClubName(), $clubs[$randClub]->getClubAddress(), $clubs[$randClub]->getClubPhone(), $clubs[$randClub]->getClubWebsite(), $clubs[$randClub]->getClubEvent());

global $chosenAddress;
$chosenAddress = $chosenClub->getClubAddress();
$chosenAddress .= " London, Ontario";


?>


<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
		var geocoder;
		var map;
	function initialize() {
		geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(57.0442, 9.9116);
		var settings = {
			zoom: 15,
			center: latlng,
			mapTypeControl: true,
			mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
			navigationControl: true,
			navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
			mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), settings);
}
function codeAddress(){
//var sAddress = "<?php echo $_POST["testingvalue"];?>";
var sAddress = "<?php echo $chosenAddress; ?>";
geocoder.geocode({'address':sAddress},function(results,status){
	if(status == google.maps.GeocoderStatus.OK){
		map.setCenter(results[0].geometry.location);
		var marker = new google.maps.Marker({
		map:map, position: results[0].geometry.location});
		var myControl = document.getElementById('mapsAddress');
		map.controls[google.maps.ControlPosition.TOP_CENTER].push(myControl);
	}
	else{
	alert("aww shit");
	}
});
}
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34722060-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body onload = "initialize(), codeAddress()">
<?php

echo "<div id=\"goto\">GO TO<br>";
if($chosenClub->getClubEvent() != null){
echo strtoupper($chosenClub->getClubEvent());
echo " AT ";
}
echo "<u>"; echo strtoupper($chosenClub->getClubName()); echo "</u>";
echo "</div>";


if($relativewidth == 0){
	echo "<div id=\"map_canvas\" style=\"width:800px; height:300px\"></div>";
}
else{
	echo "<div id=\"map_canvas\" style=\"width:80%; height:80%\"></div>";
}
?>


<?php if($relativewidth == 0){
    echo "<div id=\"mapsAddress\" position: absolute;\">"; echo $chosenClub->getClubAddress(); echo "</div>";
}
else{
echo "<div id=\"mobileMap\">"; echo $chosenClub->getClubAddress(); echo "</div>";
}
?>

<div id="refresh"><a href="club.php">NO,<BR>TAKE ME SOMEWHERE ELSE</a></div>

<img src="images/fb.png" height="25px" width="25px"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  
  <a href= "http://www.twitter.com" class="twitter-share-button" data-lang="en">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
  
  
 <script src="https://apis.google.com/js/plusone.js"></script>
<g:plus action="share" annotation = "bubble"></g:plus>

<div><!--<hr id="titleLine"/>-->
<?php if($relativewidth == 0){
echo "<a id =\"faq\" href=\"faq.php\">FAQ</a>";
echo "<a id=\"contact\" href=\"mailto:demo@demo.com\">CONTACT</a>";
}
else{
echo "<div id =\"mobilefaq\"><a href=\"faq.php\">FAQ</a><br><a href=\"mailto:demo@demo.com\">CONTACT</a></div>";
}
?>

</div>
</body>
</html>