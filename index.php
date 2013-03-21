<html>
<head>
<title>WDIGT</title>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/style.css" />


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
<body>
<!--<hr id="aboveLine"/>-->
<?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
{echo "<div id=\"title2\">WHERE<br>DO I GO TONIGHT</div>";
}
else{
echo "<div id=\"title1\">WHERE</div>";
echo "<div id=\"title2\">DO I GO TONIGHT</div>";
}
?>
<!--<hr id="titleLine"/>-->
<div id="button">
<form action = "club.php" method="post">
<input type="hidden" name="testingvalue" value="1000 Yonge St, Toronto, Ontario"/>
<input type="image" src="images/button.png"/>
</form>

<?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')){
echo "<h2>WE'VE DETECTED YOU'RE USING IE. THIS PAGE WON'T WORK CORRECTLY ON IE. GET A REAL BROWSER HERE</h2>";
echo "<br><a href=\"http://www.google.com/chrome\"><img src=\"http://upload.wikimedia.org/wikipedia/en/thumb/f/fa/Google_Chrome_2011_computer_icon.svg/200px-Google_Chrome_2011_computer_icon.svg.png\" height=\"100px\" width=\"100px\"/></a>";
echo "<a href=\"http://www.mozilla.org/en-US/firefox\"><img src=\"http://upload.wikimedia.org/wikipedia/commons/e/e7/Mozilla_Firefox_3.5_logo_256.png\" height=\"100px\" width=\"100px\"/></a>";
}?>

</div>


</body>
</html>