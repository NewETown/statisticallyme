<?php

function getHeaderOld() {
	echo("<!DOCTYPE html>\n");
	echo("<html lang=\"en\">\n");
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
	echo("<body>\n");
	echo("\t<div id=\"fb-root\"></div>\n");
	echo("\t<div class=\"blog-masthead\">\n");
	echo("\t\t<div class=\"container\">\n");
	echo("\t\t\t<nav class=\"blog-nav\">\n");
	echo("\t\t\t\t<span class=\"blog-nav-item\">STATISTICALLY.ME</span>\n");
	echo("\t\t\t\t<a id=\"login\" class=\"blog-nav-item pull-right\" href=\"#\">Log In</a>\n");
	echo("\t\t\t\t<a id=\"register\" class=\"blog-nav-item pull-right\" href=\"#\">Register</a>\n");
	echo("\t\t\t\t<a id=\"logout\" href=\"#\" class=\"blog-nav-item pull-right\"></a>\n");
	echo("\t\t\t</nav>\n");
	echo("\t\t</div>\n");
	echo("\t</div>\n");
}

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
	echo("\t\t\t\t<a class=\"blog-nav-item\" href=\"http://localhost/statisticallyme/\"><h1 id=\"navHeader\">STATISTICALLY.ME</h1></a>\n");
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

function getFooterOld() {
	echo("\t<!-- Social footer -->\n");
	echo("\t<footer>");
	echo("\t\t<div class=\"row row-dark\">");
	echo("\t\t\t<div class=\"col-md-offset-1 col-md-10 text-center\">");
	echo("\t\t\t<h3 class=\"text-center\">Stay in touch</h3>");
	//echo("\t\t\t<div class=\"social-container\">");
	echo("\t\t\t<div style=\"padding-bottom:20px;\">");
	echo("\t\t\t\t<a href=\"https://www.facebook.com/pages/StatisticallyMe/1470796433142543\" ><img src=\"img/fb_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	echo("\t\t\t\t<a href=\"https://twitter.com/ThatCodeDude\"><img src=\"img/tw_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	echo("\t\t\t</div>");
	//echo("\t\t\t\t<img src=\"img/li_square.svg\" class=\"img-responsive social-icon\">");
	echo("\t\t\t</div>");
	// echo("\t\t\t<div class=\"col-md-4 text-center\" style=\"margin:auto;\">");
	// echo("\t\t\t\t<a href=\"#\"><h3 style=\"display:inline-block;\">Home</h3></a>");
	// echo("\t\t\t\t<a href=\"#\"><h3 style=\"display:inline-block;\">About</h3></a>");
	// echo("\t\t\t</div>");
	echo("\t\t</div>");
	echo("\t</footer>");

	echo("\t<script>");
  	echo("\t\t(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){");
  	echo("\t\t(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),");
  	echo("\t\tm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)");
  	echo("\t\t})(window,document,'script','//www.google-analytics.com/analytics.js','ga');");
  	echo("\t\tga('create', 'UA-42403118-7', 'statistically.me');");
  	echo("\t\tga('send', 'pageview');");
	echo("\t</script>");

	echo("\t</body>");
	echo("</html>");
}

function getIndexFooter() {
	echo("\t<!-- Social footer -->\n");
	echo("\t<footer class=\"blog-footer-index\">");
}

function getDashFooter() {
	echo("\t<!-- Social footer -->\n");
	echo("\t<footer class=\"blog-footer\">");
}

function getFooter() {
	echo("\t\t<div class=\"row blog-footer-row\">");
	echo("\t\t\t<div class=\"col-md-offset-1 col-md-10 text-center\" style=\"height: 88px;\">");
	//echo("\t\t\t<h5 class=\"text-center\">Stay in touch</h5>");
	//echo("\t\t\t<div class=\"social-container\">");
	echo("\t\t\t<div class=\"pull-left\" style=\"padding-top: 25px;\">");
	echo("\t\t\t\t<a href=\"https://www.facebook.com/StatisticallyMe\" target=\"new\"><img src=\"img/fb_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	echo("\t\t\t\t<a href=\"https://twitter.com/ThatCodeDude\" target=\"new\"><img src=\"img/tw_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	//echo("\t\t\t\t<a href=\"#\"><img src=\"img/li_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	echo("\t\t\t</div>");
	//echo("\t\t\t</div>");
	echo("\t\t\t<div id=\"footerNav\" class=\"text-center\">");
	echo("\t\t\t\t<a href=\"#\" class=\"blog-nav-item\" style=\"margin-left:-69px;\"><h3 style=\"display:inline-block;\">Home</h3></a>");
	echo("\t\t\t\t<span style=\"text-align:center;\">•</span>");
	echo("\t\t\t\t<a href=\"#\" class=\"blog-nav-item\"><h3 style=\"display:inline-block;\">About</h3></a>");
	echo("\t\t\t</div>");
	// echo("\t\t\t<div class=\"pull-right\" style=\"padding-top:30px;\">");
	// echo("\t\t\t\t<p>&#169; Mental Tangent, 2014</p>");
	// echo("\t\t\t</div>");
	echo("\t\t</div>");
	echo("\t</footer>");

	echo("\t<script>");
  	echo("\t\t(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){");
  	echo("\t\t(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),");
  	echo("\t\tm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)");
  	echo("\t\t})(window,document,'script','//www.google-analytics.com/analytics.js','ga');");
  	echo("\t\tga('create', 'UA-42403118-7', 'statistically.me');");
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