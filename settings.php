<?php

function getHeader() {
	echo("<!DOCTYPE html>\n");
	echo("<html lang=\"en\" style=\"height:100%;\">\n");
	echo("<head>\n");
	echo("<meta charset=\"utf-8\">\n");
    echo("<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n");
    echo("<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n");
	echo("<title>Statistically.Me</title>\n");
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/bootstrap.css\">\n");
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/custom.css\">\n");
	echo("<link href='http://fonts.googleapis.com/css?family=Istok+Web:400,400italic' rel='stylesheet' type='text/css'>\n");
	echo("<script src=\"http://code.jquery.com/jquery-latest.min.js\"></script>\n");
	echo("</head>\n");
}

function getMapHeader() {
	echo("<!DOCTYPE html>\n");
	echo("<html lang=\"en\" style=\"height:100%;\">\n");
	echo("<head>\n");
	echo("<meta charset=\"utf-8\">\n");
    echo("<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n");
    echo("<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n");
	echo("<title>Statistically.Me</title>\n");
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/bootstrap.css\">\n");
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/custom.css\">\n");
	echo("<link href='http://fonts.googleapis.com/css?family=Istok+Web:400,400italic' rel='stylesheet' type='text/css'>\n");
	echo("<script src=\"http://code.jquery.com/jquery-latest.min.js\"></script>\n");
	echo("<script type=\"text/javascript\" src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyAEwAlTq4PEFWq0H59t25BbSFgXrCmyJRU&libraries=visualization&sensor=true\"></script>");
	echo("</head>\n");
}

function getFixedIndexPage() {
	echo("<body style=\"height:100%;\">\n");
	echo("\t<div class=\"wrap\">");
	echo("\t\t<div id=\"fb-root\"></div>\n");
	echo("\t\t<div class=\"blog-masthead\">\n");
	echo("\t\t\t<div class=\"container\">\n");
	echo("\t\t\t\t<nav class=\"blog-nav text-center\">\n");
	echo("\t\t\t\t<a class=\"blog-nav-item\" href=\"index.php\"><h1 id=\"navHeader\">STATISTICALLY.ME</h1></a>\n");
	echo("\t\t\t\t</nav>\n");
	echo("\t\t\t</div>\n");
	echo("\t\t</div>\n");
}

function getDashboardPage() {
	echo("<body>\n");
	echo("\t\t<div id=\"fb-root\"></div>\n");
	echo("\t\t<div class=\"blog-masthead\">\n");
	echo("\t\t\t<div class=\"container\">\n");
	echo("\t\t\t\t<nav class=\"blog-nav text-center\">\n");
	echo("\t\t\t\t<a class=\"blog-nav-item\" href=\"main.php\"><h1 id=\"navHeader\">STATISTICALLY.ME</h1></a>\n");
	echo("\t\t\t\t</nav>\n");
	echo("\t\t\t</div>\n");
	echo("\t\t</div>\n");
	echo("\t\t<div class=\"container dashboard\">\n");
}

function getIndexJS() {
	echo("\t\t</div> <!-- end container or wrap-->\n");
	echo("\t<!-- Javascript files will go under here -->\n");
	echo("\t<script src=\"js/bootstrap.min.js\"></script>\n");
	echo("\t<script src=\"js/login-page.js\"></script>\n");
}

function getFooterJS() {
	echo("\t\t</div> <!-- end container or wrap-->\n");
	echo("\t<!-- Javascript files will go under here -->\n");
	echo("\t<script src=\"js/bootstrap.min.js\"></script>\n");
	echo("\t<script src=\"js/dashboard.js\"></script>\n");
}

function getIndexFooter() {
	echo("\t<!-- Social footer -->\n");
	echo("\t<footer class=\"blog-footer-index\">");
	echo("\t\t<div class=\"row blog-footer-row\">");
	echo("\t\t\t<div class=\"col-md-offset-1 col-md-10 text-center\" style=\"height: 90px;\">");
	echo("\t\t\t<div class=\"pull-left\" style=\"padding-top: 25px;\">");
	echo("\t\t\t\t<a href=\"https://www.facebook.com/StatisticallyMe\" target=\"new\"><img src=\"img/fb_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	echo("\t\t\t\t<a href=\"https://twitter.com/ThatCodeDude\" target=\"new\"><img src=\"img/tw_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	//echo("\t\t\t\t<a href=\"#\"><img src=\"img/li_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	echo("\t\t\t</div>");
	echo("\t\t\t<div id=\"footerNav\" class=\"text-center\">");
	echo("\t\t\t\t<a href=\"#\" class=\"blog-nav-item\"><h3 style=\"display:inline-block;\">About</h3></a>");
	echo("\t\t\t</div>");
	echo("\t\t</div>");
	echo("\t</footer>");

	echo("\t<script>");
  	echo("\t\t(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){");
  	echo("\t\t(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),");
  	echo("\t\tm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)");
  	echo("\t\t})(window,document,'script','//www.google-analytics.com/analytics.js','ga');");
  	echo("\t\tga('create', 'UA-42403118-7', 'www.statistically.me');");
  	echo("\t\tga('send', 'pageview');");
	echo("\t</script>");

	echo("\t</body>");
	echo("</html>");
}

function getFooter() {
	echo("\t<!-- Social footer -->\n");
	echo("\t<footer class=\"blog-footer-index\">");
	echo("\t\t<div class=\"row blog-footer-row\">");
	echo("\t\t\t<div class=\"col-md-offset-1 col-md-10 text-center\" style=\"height: 90px;\">");
	echo("\t\t\t<div class=\"pull-left\" style=\"padding-top: 25px;\">");
	echo("\t\t\t\t<a href=\"https://www.facebook.com/StatisticallyMe\" target=\"new\"><img src=\"img/fb_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	echo("\t\t\t\t<a href=\"https://twitter.com/ThatCodeDude\" target=\"new\"><img src=\"img/tw_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	//echo("\t\t\t\t<a href=\"#\"><img src=\"img/li_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	echo("\t\t\t</div>");
	echo("\t\t\t<div id=\"footerNav\" class=\"text-center\">");
	echo("\t\t\t\t<a href=\"index.php\" class=\"blog-nav-item\" style=\"margin-left:-69px;\"><h3 style=\"display:inline-block;\">Home</h3></a>");
	echo("\t\t\t\t<span style=\"text-align:center;\">•</span>");
	echo("\t\t\t\t<a href=\"#\" class=\"blog-nav-item\"><h3 style=\"display:inline-block;\">About</h3></a>");
	echo("\t\t\t\t<span style=\"text-align:center;\">•</span>\n<a href=\"index.php\" onclick=\"FB.logout();\" class=\"blog-nav-item\"><h3 style=\"display:inline-block;\">Logout</h3></a>");
	echo("\t\t\t</div>");
	echo("\t\t</div>");
	echo("\t</footer>");

	echo("\t<script>");
  	echo("\t\t(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){");
  	echo("\t\t(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),");
  	echo("\t\tm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)");
  	echo("\t\t})(window,document,'script','//www.google-analytics.com/analytics.js','ga');");
  	echo("\t\tga('create', 'UA-42403118-7', 'www.statistically.me');");
  	echo("\t\tga('send', 'pageview');");
	echo("\t</script>");

	echo("\t</body>");
	echo("</html>");
}

function echoLoginOptions() {
	echo "\t<div class=\"hero\">";
	echo "\t\t<div class=\"greeting\">";
	echo "\t\t\t<h4>Learn something about yourself</h4>";
	echo "\t\t\t<!-- <h1>Statistically.Me</h1> -->";
	echo "\t\t\t<a id=\"fbRegister\" href=\"#\"><img src=\"img/flat_fb_login.png\"></a>";
	echo "\t\t</div>";
	echo "\t</div>";
}

?>