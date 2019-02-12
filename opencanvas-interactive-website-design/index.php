<?php

##################################################################
#   Program:        OpenCanvas Interactive Website Design        #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2009 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:      User Interface Design and User Experience    #
#        Module:    Advanced Website Design Package              #
#        Info:   	Drag and drop website template selection,    #
#                   notes, sharing, and many other features as   #
#                   part of a sales tool to sell customized web  #
#                   design and development solutions.            #
#                                                                #
##################################################################################
# Permission is hereby granted, free of charge, to any person obtaining a copy   #
# of this software and associated documentation files (the "Software"), to deal  #
# in the Software without restriction, including without limitation the rights   #
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell      #
# copies of the Software, and to permit persons to whom the Software is          #
# furnished to do so, subject to the following conditions:                       #
#                                                                                #
# The above copyright notice and this permission notice shall be included in all #
# copies or substantial portions of the Software.                                #
#                                                                                #
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR     #
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,       #
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE    #
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER         #
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,  #
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE  #
# SOFTWARE.                                                                      #
##################################################################################

#-- vps-net.com > Professional Website Design Packages

	$phpCompileOS = $_SERVER["SERVER_SOFTWARE"];
	if (stristr($phpCompileOS, 'WIN') !== FALSE) {
		$HTTPRoot = 'H:/dvwf/rbsd_IO/vhosts/vsnet/htdocsNEW/';
	}
	else { $HTTPRoot = '/var/www/vps-net.com/htdocs/'; }

	/*define local working table*/
	define("VPSSQL_DB_NAME", "vpsnetcom");

	/** load VPS-DB-CONFIG */
	require_once($HTTPRoot.'vps-config.php' );

	// read shoppingCart cookie
	$OpenCanvasDesign = $_COOKIE["OpenCanvasDesign"];

	// read checkoutCart cookie
	$VirtualPrivateCart = $_COOKIE["VirtualPrivateCart"];

//--> total of 12 hours @ 75/hr discounted [regular business hours M-F 9a-6p USA ] 
$PriceBUSCON = '900.00'; 
//--> total of 12 hours @ 150/hr discounted [ 7a-10p USA ]
$PricePERCON = '1800.00'; 

$PriceSSL = '92.50';
$PriceSEM = '449.75';
$PriceSSLSEM = '525.50';

//--which function we running?
$getOpenCanvas = 0;
if ( isset($_REQUEST['getOpenCanvas']) ) { $getOpenCanvas = 1; }
else { $getOpenCanvas = 2; }
// same as HTMLo
//- $getOpenCanvas = 2;


	##-- canvas dynloader request encrypted call :)
	if (!empty($_REQUEST["OpenCanvasID"]) && strlen($_REQUEST["OpenCanvasID"]) > 5) {
		$idHASHISH = $_REQUEST["OpenCanvasID"];
		$myCNumber = 0;
		##-- call to perl for desalt
		##-- MUST BE SET TO DOMAIN: localhost [for local development testing environment] 
		$myCNumber = file_get_contents('http://www.vps-net.com/opencanvas-interactive-website-design/findmycanvas.htm?c='.$idHASHISH.'');
		##--- only if our call if found to be impeccable
		if ($myCNumber >= 400) {

			$ADDCART = $db->get_row("SELECT * FROM customerScarts WHERE CartID = $myCNumber");
			$inUID = $ADDCART->UID;
			$myCanvas = $ADDCART->Canvas;
			$myFavorites = $ADDCART->Favorites;
			$myTrash = $ADDCART->Trash;
			$myOCVEE = $ADDCART->OCv;
			$OpenCanvasVersion = $myOCVEE;

			$hasOCV = (int)$OpenCanvasVersion; 
			$cualOCv = $hasOCV;

			$expire=time()+60*60*24*365;
			setcookie("OpenCanvasVersion", "$OpenCanvasVersion", $expire, "/");
			setcookie("OpenCanvasDesign", "$inUID", $expire, "/");
			$UpdateOpenCanvas = "\$(document).ready(function() {parent.location.href = '/opencanvas-interactive-website-design/?favorites';});";

			// set section and subsection dynamically, act as if we are coming from those entrance points
			$section = 1;
			$subsection = $OpenCanvasVersion;

			#echo $idHASHISH;
		}
	}
	##-- template view request
	if (!empty($_REQUEST["DesignID"]) && strlen($_REQUEST["DesignID"]) > 8 && strstr($_REQUEST["DesignID"],'OCv') !== FALSE) {
		$myDID = $_REQUEST["DesignID"];
		// echo $_REQUEST["DesignID"];
		$myOCv = substr($myDID,3,1);
		$myOCd = substr($myDID,4,strlen($myDID));
		$elDID = $myOCd;
		if ((int)$myOCv === 1 || (int)$myOCv === 2 || (int)$myOCv === 3) {

			// only if not canvas version set do we set it now
			$OpenCanvasVersion = $_COOKIE["OpenCanvasVersion"];
			if (empty($OpenCanvasVersion)) {
				$expire=time()+60*60*24*365;
				setcookie("OpenCanvasVersion", $myOCv, $expire, "/");
				// set section and subsection dynamically, act as if we are coming from those entrance points
				$section = 1;
				$subsection = $myOCv;
			}
			$UpdateOpenCanvas = "\$(document).ready(function() {parent.location.href = '/opencanvas-interactive-website-design/?design=".$myOCd."';});";
		}
	}

	// since calls to favorites at this intersection revolve around shared links, we set ourselves up with that in mind
	if (isset($_REQUEST["favorites"])) {
		$UpdateOpenCanvas2 = "if(FavoriteContains.length > 0) { loadCategory('favorites',0); }";
		$OpenCanvasVersion = $_COOKIE["OpenCanvasVersion"];
		if (!empty($OpenCanvasVersion)) {
			$section = 1;
			$subsection = $OpenCanvasVersion;
		}
	}

	// since calls to categories at this intersection revolve around shared links, we set ourselves up with that in mind
	if (isset($_REQUEST["web-design-category"])) {
		$OpenCanvasVersion = $_COOKIE["OpenCanvasVersion"];
		if (!empty($OpenCanvasVersion)) {
			$section = 1;
			$subsection = $OpenCanvasVersion;
		}
	}

	if (isset($_REQUEST["design"])) {
		// only if not canvas version set do we set it now
		$OpenCanvasVersion = $_COOKIE["OpenCanvasVersion"];
		if (!empty($OpenCanvasVersion)) {
			// set section and subsection dynamically, act as if we are coming from those entrance points
			$section = 1;
			$subsection = $_COOKIE["OpenCanvasVersion"];
		}

		$myDID = (int)$_REQUEST["design"];
		$elDID = $myDID;
		###--- NEED TO FIX THE AJAX FUNCTION ON THESE CALLS, SOMETHING GONE BONKERS
		###-- hence runFlash
		###-- gotta run something like templateSucka.nsp
		if ($myDID > 55555) {
			$MYTEMP = $db->get_row("SELECT PreviewPage FROM TemplateCentral where TID = ".$myDID."");
			$ppage = $MYTEMP->PreviewPage;
			$cualScript = 'previewTemplate';
			if (!empty($ppage) && (strstr($ppage,'images.templatemonster.com') !== FALSE)) { $cualScript = 'runFlash'; }
			$UpdateOpenCanvas2 = "\$(document).ready(function() { ".$cualScript."('".$myDID."'); });";
		}
	}
	
	$popflash = '0';
	if ( isset($_REQUEST['popflash']) ) { $popflash = $_REQUEST['popflash']; }
	$ajaxflash = '0';
	if ( isset($_REQUEST['ajaxflash']) ) { $ajaxflash = $_REQUEST['ajaxflash']; }

	// option 0 + suboption 0 = 0 home
	// option 1 + suboption 0 = section home
	// option 1 + suboption 1 = section document

	#- Price
	$OCPrices = "1290.75|1650.75|2545.75";
	#- No Price
	#-$OCPrices = "0.00|0.00|0.00";
	$allCanvasPrices = explode("|", $OCPrices);
	#- Price
	$OCv1Price = '$'.$allCanvasPrices[0];
	$OCv2Price = '$'.$allCanvasPrices[1];
	$OCv3Price = '$'.$allCanvasPrices[2];
	#- No Price
	#- $OCv1Price = '';
	#- $OCv2Price = '';
	#- $OCv3Price = '';
	$jsCanvasPriceList = '' . implode(',',$allCanvasPrices) . '';

	if (!empty($section)) { $section = $section; } else { $section = 1; }
	if (!empty($subsection)) { $subsection = $subsection; } else { $subsection = 1; }
	/** load INTERFACING[DOC-HEAD DOC-FOOT MAIN-MENUS MAIN-FUNCTIONS] */
	require_once($HTTPRoot.'interface_design_templater.php' );

	// read OCversion cookie
	$hasOCV = 0;
	$inUID = $OpenCanvasDesign;
	$OpenCanvasVersion = $_COOKIE["OpenCanvasVersion"];
	$elOCv = 'OCv'; $cualOCv = 1;
	if (!empty($OpenCanvasVersion)) {
		$hasOCV = (int)$OpenCanvasVersion; 
		$cualOCv = $hasOCV;
	}
	$trueOCv = $elOCv . $cualOCv;

	//--> DEFINE DOCUMENT TEMPLATE PARAMS
	//* can be used to set document info
	//*> $pageTitle = "Website Design by VPS-Net";
	//*>$mainKeywords = "web design, website design, free web design tutorials";
	//*>$fluffyKeywords = "web design articles, web design news, free web design content";
	//*>$shortKeywordPhrase = "website design, web design, web designers and website development";
	//*>$shortKeywordList = "website design - web design - web designers - website development";
	//*>$metaDescription = "Professional Web Design by Virtual Private Servers and Networks along with tutorials, articles, news, interviews, free web design showcases, template reviews and free web design content is perfect for those looking for excellent web design services, information, materials and resources.";

	$canvasInfoType = $cualOCv;
	// set the OCV
	$elOCv = $subsection;
	$namedOCv = 'OCv'.$elOCv;

	$savedNewOCv = 0;
	##-- only if cookie available, might we need to reset it
	if ($hasOCV >= 1) {
		$hasOCV = (int)$hasOCV;
		##-- look for change cookie vs form OCv
		$newOCv = 0;
		if ($elOCv != $hasOCV) { 
			$newOCv = $elOCv;
			$expire=time()+60*60*24*365;
			setcookie("OpenCanvasVersion", "$newOCv", $expire, "/");
			##-- prep the save to to canvas
			if (strlen($OpenCanvasDesign) > 10) {
				$inUID = $OpenCanvasDesign;
				$savedNewOCv = $db->get_results("UPDATE LOW_PRIORITY customerScarts SET OCv='$newOCv' WHERE UID='$inUID'");
			}
		}
	}

	##--social network image
	if ($elDID)	{
		$MYTEMP = $db->get_row("SELECT Type FROM TemplateCentral where TID = ".$elDID."");
		$ttype = $MYTEMP->Type;
		if (stristr($ttype, 'website') === FALSE) { $ttype .= ' Website'; }
		$iURL = "\n"
		.'<meta property="og:url" content="http://vps-net.com/opencanvas-interactive-website-design/?design='.$elDID.'"/>'."\n"
		.'<meta property="og:image" content="http://www.vps-net.com/opencanvas-interactive-website-design/website-design-template-images.htm?t=OCv'.$elOCv.''.$elDID.'&k=s&s=tm"/>'."\n"
		.'<meta property="og:image:secure_url" content="https://www.vps-net.com/opencanvas-interactive-website-design/website-design-template-images.htm?t=OCv'.$elOCv.''.$elDID.'&k=s&s=tm"/>'."\n"
		.'<meta property="og:image:type" content="image/jpeg"/>'."\n"
		.'<meta property="og:title" content="OpenCanvas Design: OCv'.$elOCv.''.$elDID.' - '.$ttype.'"/>'."\n"
		.'<meta property="og:description" content="The OpenCanvas '.$ttype.' (Design ID: OCv'.$elOCv.''.$elDID.'), along with our other state-of-the-art website designs and high-quality flash templates, are indeed some of the most impressive interactive marketing platforms available on the Internet today."/>';
	}

	## which list option is selected?
	$OCvSelected[$elOCv] = 'selected';






//-- ONLY IF NOT SET
if (!$canvasCall && !$iURL) { $iURL = "\n".'<meta property="og:image" content="http://www.vps-net.com/website_design_template_images/opencanvas-interactive-website-design-logo.png"/>'."\n".'<meta property="og:title" content="OpenCanvas, The Interactive Design Experience - Three Website Design Packages: eXpress, Business and Advanced"/>'."\n".'<meta property="og:description" content="OpenCanvas, The Interactive Website Design Experience (Three packages: eXpress, Business and Advanced): OpenCanvas is an interactive web design and development creative communication platform revolving around our collection of over 14,000 professionally designed and uniquely engineered website designs. An OpenCanvas can consist of a single design canvas or a customized website with design, interfacing and functionality from up to five(5) seperate design canvases. Regardless of your tastes or ideas, our mission is to create a uniquely seductive website to capture the undivided attention of your intended audience. For, in the interactive marketing and virtual advertising business world, fascinating a casual Internet user is key in turning a casual website visitor into a paying customer, a return visitor or a dignified source for advertisement revenue."/>'; }




$SSLCOPY = "Secure Sockets Layer (SSL), an encryption layer for HTTP, hence the HTTPS protocol attached to all SSL secure website domain servers. SSL is required for any website attaining, processesing, storing or plainly dealing with sensitive client or customer information, including but not limited to: Email addresses, phone numbers, physical addresses, names, dates and any data that has some type of monetary or privacy value attached to it.";
$SEMCOPY = "Search Engine Marketing (SEM), the proliferation of your website's textual and multimedia content by use of white-hat methodologies. By enveloping your website with highly-relative content favoring search engine ranking algorithms, we will be giving your website an advantage over your competition on the Internet, as well as superiority over local and demographic searches. SEM is a service we render once a month for an entire year, in the process of updating the website content, its searchable indexes, its visibility online, social networkability and social interactivity.<br><br>Our search engine marketing service revolves around organic search index marketing methodologies, denoting the fact we don't utilize, nor do we offer, PPC (Pay-Per-Click) or CPM (Cost Per Mille) marketing to get the results we seek. Organic marketing consists of infusing your website with data with information relative to the content and subject base of your website, be it inventory, business or personal, then turning around and propagating this relative information to the Internet.";
$SEOCOPY = "Search Engine Optimization (SEO): We here at Virtual Private Servers and Networks are always inventing, and providing our clients, the most impressive and cost-effective SEO service available on the market today. We pride ourselves in continuously evolving by engineering if not merely finding new ways to keep our clients websites attaining and maintaining a high ranking presence using optimal search keywords and keyword phrases.<br><br>Your business's name and any other data sets, keywords and tags we agree to target as part of the terms to this service, will also be propagated throughout the Internet.";

$BUSCONCOPY = "Monday through Friday from 9am to 4pm (USA), the technology <em>gurus</em> at Virtual Private are just a phone call, video conference, email or chat message away.<br><br>Exclusively available only through Virtual Private: Technical Concierge I, a service within a service. We've added the concierge line of technical services to give your business peace of mind when it comes to computer, information and Internet technologies. Be it a simple mouse or keyboard issue, or an advanced data mining question, our expert technologists are at the ready to assist you in finding answers, fixing issues and plainly addressing the technical concerns, problems or questions you may have.<br><br>Engineering, support, advisory and information technologists at VPS-NET give your business an overwhelming edge by infusing your critical decision making processes and standards with decades of technical know-how and expertise. Advanced clients deserve advanced technical service, which is why we've made such available to you during normal business hours.";
$PERCONCOPY = "Weekdays from 9am to 9pm or weekends from 10am to 6pm (USA), we're here to be of service, and if its an emergency, our Virtual Private Concierge service is available to you 24/7.<br><br>Only at Virtual Private can you get Technical Concierge Level II, an exclusive service within a service. The concierge line of technical services is a personal touch to our business offering of the same class, think of it as your own personal technical guru at your beckon call. Have a question regarding hacks, wiretapping, networking, information security or any other basic or advanced technical subject? Just get in touch with your technical conceriege desk, our expert technologists will be ready to assist you in finding answers, fixing issues and plainly addressing the technical concerns, problems or questions you may have.<br><br>Engineering, support, advisory and information technologists at VPS-NET will make your technical life much easier to grasp and manage, a type of service only possible with decades of technical know-how and expertise to back it up. Your life deserves its own personal technical advisor, which is why we've made this class of service available, exclusively for you and only available at Virtual Private. The technology <em>gurus</em> at VPS-NET are just a phone call, video conference, email or chat message away, so give this service a try, you'll be more than glad you became a part of our exclusive client club.";

//-> hours
	$PackageCanvases = 'Your choice of one(1) of our 14,000 professionally developed interactive design canvases';
	$myCreativeTime = 2;
	$myTechnicalTime = 2;
	$myCanvasPersonalizationTime = 4; 
	$myTechnicalTimeInfo = 'The eXpress Website Package gives you up to two(2) full hours of technical production is alloted, time which will be used to setup your domain name, website hosting, server platform, content management system, email addresses and anything related to the technical setup of your domain name and website.';
	$myCreativeTimeInfo = 'With the eXpress Website Package you are allowed a total of two(2) hours creative design time. Two hours is enough to add or change logos, text colors, backgrounds and other minor aesthetic design features.';
	$myCanvasPersonalizationInfo = 'While half of the total project time allotment will be used for creative and technical processes, we must leave some time open for the customization of your new website design canvas. Hence, we will be using four(4) hours to personalize your website design canvas by adding your logo, changing imagery where approriate, changing copy and renaming menu items.<br><br>Furthermore, while peronalizing the textual content of your new website, we use that opportunity to liven up your website using our &lsquo;Basic Search Engine Optimization&rsquo; service, included in this package, for better search engine ranking based on the content of your new website.';
	$DiskSpace = '5';
	$GBTransferMonth = '100';
	$Databases = '1 MySQL Database';
	$ProjectManagement = '24/7 access to your virtual project manager, where you can view and approve designs, send us files and leave feedback';
	$EmailAccounts = '1';
	$SSLCertificate = '<a class="Web-Design-Information" title="'.$SSLCOPY.'">SSL Certificate</a>: Available as Add-On';
	$SEOService = 'Available as Add-On';
	$SEMService = 'Available as Add-On';



if ($elOCv === 3) {
	$PackageCanvases = 'Select up to five(5) high-quality interactive design canvases that feature functionality, features, designs, ideas and concepts you want as part of your new website interface';
	$myCreativeTime = '6';
	$myTechnicalTime = '6';
	$myCanvasPersonalizationTime = '12';
	$myCreativeTimeInfo = 'With the Advanced Website package you are given a hefty six(6) hours of creative design time. Six hours is more than enough time to change website design backgrounds, menus, imagery, styling as well as other graphical user interface features and their interactive multimedia such as video and flash. With six hours we can introduce new features, functions and creative to change the way your website design canvas looks, feels or behaves as well.<br><br>Only the Advanced Website Package allows you to mix and match Creative, Technical and Canvas Personalization hours. This exclusive feature allows us to get really creative with the overall presentation of your new interactive interface as well as its features and design.'; 
	$myTechnicalTimeInfo = 'Only the Advanced Website Package gives you a full six(6) hours of time for technical production. With six hours, we have the time to setup your domain name, website hosting, server platform, content management system, email addresses and anything related to the technical setup of your domain name and website.<br><br>With the extra alloted time there is plenty time left to develop proprietary technology to upgrade your site, or if you choose, you can utilize the extra time for Creative or Canvas Personalization. For, only the Advanced Website Package gives you the flexibility of mixing and matching Creative, Technical and Canvas Personalization hours, allowing us a timeframe and platform from which to really get technically creative with the production of your new interactive interface.';
	$myCanvasPersonalizationInfo = 'Our Advanced Website Package is advanced in much more than just name. It delivers on its namesake by providing your project with a whopping twenty-four(24) combined hours for Creative Design, Technical and Canvas Personalization. Considering we are working with up to five(5) interactive designs, we will most definitely have our hands full merging and combining designs, features, functions and creative materials into a single website interface.<br><br>Talking about the Advanced Website Package, it gives you even more flexibility than any of the other two packages. For instance, you can request the addition or development of features, functions, multimedia and other materials not found in any of your design canvases. This, of course, denotes the fact you have the ultimate control in getting the exact site you want, at an extraordinarily low price.';

	$ProjectManagement = 'Direct access to your Project Manager and Technical Advisor during normal business hours via phone, email, online chat or remote desktop, whichever best fits your style of computing.';
	$DiskSpace = '10';
	$GBTransferMonth = '300';
	$Databases = '25 MySQL Databases';
	$EmailAccounts = '10';
	$SSLCertificate = '<a class="Web-Design-Information" title="'.$SSLCOPY.'">SSL Certificate</a> Included: One(1) Year';
	$SEOService = 'Included';
	$SEMService = '1 Year';
	
	//-- ONLY IF NOT SET
	if (!$iURL) { $iURL = "\n".'<meta property="og:image" content="http://www.vps-net.com/website_design_template_images/opencanvas-interactive-advanced-website-design-package.png"/>'."\n".'<meta property="og:title" content="OpenCanvas Advanced Website Design Package: The 24-Hour Solution"/>'."\n".'<meta property="og:description" content="The OpenCanvas Advanced Website Design Package: '.$myCreativeTimeInfo.' '.$myTechnicalTimeInfo.'"/>'; }

}
else if ($elOCv === 2) {
	$PackageCanvases = 'Select up to two(2) high-quality interactive design canvases which, if combined or merged, best match what you envision as your new domain website';
	$myCreativeTime = '4';
	$myTechnicalTime = '4';
	$myCanvasPersonalizationTime = '8';
	$myCreativeTimeInfo = 'With the Business Website package you are allowed a total of four(4) hours creative design time. Four hours is more than enough to add logos, text colors, backgrounds and other minor and simple aesthetic design changes. Keep in mind, with this package you get two more hours than the Xpress Website Package offers, giving you more time for changes to the website design as well as other types of creative customizations.';
	$myTechnicalTimeInfo = 'Our Business Website Package allows for a maximum of four(4) hours technical production time, which is more than enough time to setup your domain name, website hosting, server platform, content management system, email addresses and anything related to the technical setup of your domain name and website. The two hour extra allotment by this package gives you enough time to have some scripting or programming changed on the site, not much, but enough for a minor upgrade or update.';
	$myCanvasPersonalizationInfo = 'Half of the total project time allotment will be used for creative and technical processes, yet we must leave some time open for the customization of your new website design canvas. Which is why we the Business Website Package gives you eight(8) hours of customization time, enough time personalize your website design canvas by adding your logo, changing imagery where approriate, changing copy and renaming menu items. And since you are getting four(4) more hours than the eXpress package, you will have enough time left over to add a few plug-ins, scripts, some multimedia or a wide array of other content to your website.<br><br>Furthermore, while peronalizing the textual content of your new website, we use that opportunity to liven up your website using our &lsquo;Basic Search Engine Optimization&rsquo; service, included in this package, for better search engine ranking based on the content of your new website.';
	$EmailAccounts = '3';

	//-- DiskSpace, GBTransferMonth and Databases are the same for 1 and 2

	//-- ONLY IF NOT SET
	if (!$iURL) { $iURL = "\n".'<meta property="og:image" content="http://www.vps-net.com/website_design_template_images/opencanvas-interactive-business-website-design-package.png"/>'."\n".'<meta property="og:title" content="OpenCanvas Business Website Design Package: Professional Business Solution"/>'."\n".'<meta property="og:description" content="The OpenCanvas Business Website Design Package: '.$myCreativeTimeInfo.' '.$myTechnicalTimeInfo.'"/>'; }

}
else if ($elOCv === 1) {
	//-- ONLY IF NOT SET
	if (!$iURL) { $iURL = "\n".'<meta property="og:image" content="http://www.vps-net.com/website_design_template_images/opencanvas-interactive-express-website-design-package.png"/>'."\n".'<meta property="og:title" content="OpenCanvas eXpress Website Design Package: The Professionally Economical Solution"/>'."\n".'<meta property="og:description" content="The OpenCanvas eXpress Website Design Package: '.$myCreativeTimeInfo.' '.$myTechnicalTimeInfo.'"/>'; }
}


$DiskSpace .= ' GB Disk Space';
$GBTransferMonth .= ' GB Transfer Per Month';






	//--> DEFINE DOCUMENT HEAD CONTENT [scripts/css]
	//--> CarouselHeadScript(0,0,showing,scrolling,width,idDragDrop)
##	$headScriptJS = "\n" . DDCarouselHeadScript($canvasInfoType) . "\n" . CarouselHeadScript($popflash,$ajaxflash,"3","3","507","1","2") . "\n" . MainMenuHeadScript() . "\n" . NoRightClickHeadScript() . "\n";
	$headScriptJS = "\n" . CommonHeadScript() . "\n" . DDCarouselHeadScript($elOCv, $trueOCv) . "\n" . CarouselHeadScript($popflash,$ajaxflash,"3","3","507","1","2") . "\n" . MainMenuHeadScript() . "\n" . AmazonAdHeadScript() . "\n" . FancyBoxHeadScript() . "\n" . NoRightClickHeadScript() . "\n";
	$headStyleCSS = "\n" . CommonHeadCSS() . "\n" . MainMenuHeadCSS() . "\n" . DDCarouselHeadCSS() . "\n" . CarouselHeadCSS() . "\n" . AmazonAdHeadCSS() . "\n" . FancyBoxHeadCSS() . "\n";
	$headScriptJSLinks = $iURL . "\n" . CommonHeadJavascriptLinks() . "\n" . MainMenuHeadJavascriptLinks() . "\n" . CarouselHeadJavascriptLinks() . "\n";
	$headStyleCSSLinks = "\n" . CommonHeadCSSLinks() . "\n" . CarouselHeadCSSLinks() . "\n";

	$mainMenuItems = $db->get_results("SELECT * FROM Section ORDER BY SectionID ASC");
	$subMenuItems = $db->get_results("SELECT * FROM SubSection WHERE SID = '$section' AND VirtualStatus = 'Active' ORDER BY SectionID ASC");

	// section page select list
	foreach ( $subMenuItems as $subMenuItem ) {
		$subMIs = $subMIs . 'sectionPages[' . $subMenuItem->SectionID . '] = "' . $subMenuItem->SectionPage . '";';
	}


	//-->> default, not working on ranking (by changing from quickRate.htm to dropZone.htm, negate non admin users the ability to change ranks)
	$theranker = '0';
	$therater = 'dropZone';
	//-->> if we are working on the ranking
	if ($rvar_r == 'rankact') { 
		$theranker = '1';
		$therater = 'quickRate'; 
	}

	//-->> when saving the $uf script file replace: 
	//-->> var theRanker='';if('1'=='1')
	//-->> with:
	//-->> var theRanker='';if('%%THEACT%%'=='1')

	$headScriptJS = str_replace("%%THEACT%%", "$theranker", $headScriptJS);
	$headScriptJS = str_replace("quickRate", "$therater", $headScriptJS);


	// get SELECTED section's document layout for processing
	// [SELECTED SECTION ONLY!!] //
	$selectedSectional = 0;
	if ($elOCv > 0 && !empty($section)) { $selectedSectional = $db->get_row("SELECT * FROM SubSection WHERE SID = '$section' AND SectionID = '$elOCv'"); }
	else if (!empty($section)) { $selectedSectional = $db->get_row("SELECT * FROM Section WHERE SectionID = '$section'"); }

	//--> DEFINE DOCUMENT TOP HEADER MARKUP [ANYTHING THAT WILL BE POSTED ON EVERY PAGE AT <BODY> TAG]
	$documentBodyHeader = MainDocumentHeaderMarkup($A1, $selectedSectional, $ISIN) . "" . MainDocumentMenuMarkup($section,$elOCv,$mainMenuItems,$subMenuItems);
	
	$onLoadScript = "onLoad=\"setTheCanvas('".$namedOCv."');\"";

	// REQUEST DOCUMENT TEMPLATE BASED ON ABOVE PARAMS: templater.php
	// NEW section/subsection HEAD/META info is overwritted using pre-defined DB data

	// $cs1 = designated to pass the itemID for templates in canvas [$cs2 and $cs2 OPEN for DATA, maybe for fav and trash contents, maybe not but hey...???]

	// default canvases
	$cs1 = ",,,,";
	$cs2 = "";
	$cs3 = "";

	$myWebsiteExtras = '0';
	$myWebsiteMaintenance = '0';
	$lastAddon = "";

	$NOADDON = "checked";
	$SSLSelected = "";
	$SEMSelected = "";
	$SSLSEMSelected = "";

	$BUSCONSelected = "";
	$PERCONSelected = "";

	$NOMAINTENANCE = "checked";
	$SIXMONTHMAINTENANCESelected = "";
	$TWELVEMONTHMAINTENANCESelected = "";
	
	if (strlen($OpenCanvasDesign) > 10) { 
		$inUID = $OpenCanvasDesign;
		$USCART = $db->get_row("SELECT * FROM customerScarts WHERE UID = '$inUID'");
		$myHistory = $USCART->Historic;
		$myCanvas = $USCART->Canvas;
		$myFavorites = $USCART->Favorites;
		$myTrash = $USCART->Trash;
		$cs1 = $myCanvas;
		$cs2 = $myFavorites;
		$cs3 = $myTrash;

		$USACTIONS = $db->get_row("SELECT * FROM ConversationLog WHERE (UID = '$inUID' AND EntryType = 'SubmitCanvas') ORDER BY LineID ASC LIMIT 1");

		##-- look for submittedCart, finalized, stacked
		#if (strlen($VirtualPrivateCart) > 10) {
		#	$CanvasWasSubmitted = 1;
		#}
		
		##-- instead of looking at the VirtualPrivateCart we will look to the conversation log
		##-- look for submittedCart, finalized, stacked
		##-- for, VirtualPrivateCart being used also to track other cart content, not just canvases
		if (!empty($USACTIONS)) {
			$CanvasWasSubmitted = 1;
		}

		if ($elOCv > 0 && !empty($myHistory)) {
			
			//-- all canvases get maintenance offer
			if (strstr($myHistory,'|SIXMONTHMAINTENANCE|')) {
				$myWebsiteMaintenance = '1';
				$lastMaint = 'SIXMONTHMAINTENANCE';
				$SIXMONTHMAINTENANCESelected = 'checked';
				$NOMAINTENANCE = "";
			}
			else if (strstr($myHistory,'|TWELVEMONTHMAINTENANCE|')) {
				$myWebsiteMaintenance = '2';
				$lastMaint = 'TWELVEMONTHMAINTENANCE';
				$TWELVEMONTHMAINTENANCESelected = 'checked';
				$NOMAINTENANCE = "";
			}

				
			//-- SSL / SEM / SSLSEM for OpenCanvas v1 v2 [v3 already has these included]
			//-- set $SSLOPTIONAL flag for later use, hence v3 gets different addon options
			if ($elOCv === 1 || $elOCv === 2) {
				if (strstr($myHistory,'|SSL|')) {
					$myWebsiteExtras = '1';
					$lastAddon = 'SSL';
					$SSLSelected = 'checked';
					$NOADDON = "";
				}
				else if (strstr($myHistory,'|SEM|')) {
					$myWebsiteExtras = '2';
					$lastAddon = 'SEM';
					$SEMSelected = 'checked';
					$NOADDON = "";
				}
				else if (strstr($myHistory,'|SSLSEM|')) {
					$myWebsiteExtras = '3';
					$lastAddon = 'SSLSEM';
					$SSLSEMSelected = 'checked';
					$NOADDON = "";
				}
			}
			else if ($elOCv === 3) {
				if (strstr($myHistory,'|BUSCON|')) {
					$myWebsiteExtras = '1';
					$lastAddon = 'BUSCON';
					$BUSCONSelected = 'checked';
					$NOADDON = "";
				}
				else if (strstr($myHistory,'|PERCON|')) {
					$myWebsiteExtras = '2';
					$lastAddon = 'PERCON';
					$PERCONSelected = 'checked';
					$NOADDON = "";
				}
			}
		}
	}



	//--> 
	//--> START CAROUSEL PREPROCESSING
	//--> 
	$myCanvasList = '';
	/** grab all filled categories */
	$categories = $db->get_results("SELECT * FROM Categories WHERE (TotalPages = LastPage AND VirtualStatus = 'AcTiVe') ORDER By CatName ASC");
	$myCanvasList = $myCanvasList . '<select id="search-string" class="commonInput">';
	$myCanvasList = $myCanvasList . '<option value="favorites">Your Favorite Designs</option>';
	$myCanvasList = $myCanvasList . '<option value="trash">Designs You\'ve Deleted</option>';
	$myCanvasList = $myCanvasList . '<option value=""></option>';
	$myCanvasList = $myCanvasList . '<option value="">------------------------------</option>';
	$myCanvasList = $myCanvasList . '<option value=""></option>';
	foreach ( $categories as $category ) {
		$cselec = '';
		$mcatname = $category->CatName;
		$myCatCall = $_REQUEST['website-design-category'] == '' ? $_REQUEST['web-design-category'] : $_REQUEST['website-design-category'];
		if ((strstr($mcatname,'&') && strstr(''.$mcatname.' & ', $myCatCall) !== FALSE) || strstr($mcatname, $myCatCall) !== FALSE) {
			$cselec = ' selected';
			/// EFFeCtiVE is our obfuscated variable name for searchStr, used to hold 'current category'
			// slow it down, make it loadCategory after a few milliseconds, so it catches always
			$onLoadScript = "onLoad=\"EFFeCtiVE='".$category->CatID."';setTheCanvas('".$namedOCv."');window.setTimeout(function(){ loadCategory('".$category->CatID."',0); }, 500);\"";
			
		}
		$myCanvasList = $myCanvasList . '<option class="'.$myCatCall.'" value="' . $category->CatID . '"'.$cselec.'>'. $category->CatName .'</option>';
	}
	$myCanvasList = $myCanvasList . '</select>';



	$myHeadPiece = commonHead($cs1, $cs2, $cs3, $docHeader, $pageTitle, $mainKeywords, $shortKeywordList, $shortKeywordPhrase, $fluffyKeywords, $metaDescription, $headScriptJS, $headStyleCSS, $headScriptJSLinks, $headStyleCSSLinks, $onLoadScript, $documentBodyHeader,$section,$elOCv,$mainMenuItems,$subMenuItems);

	$bgSpacerALT = $selectedSectional->SectionTitle;
	$bgSectionTITLE = $selectedSectional->SectionBackgroundTitle;
	$sectionLINK = $selectedSectional->SectionPage;


	//--> VARIABLE PASS FOR CAROUSEL V1
	$bgSectionTITLE = "OpenCanvas, an Interactive Design Experience";
	$bgSubSectionALT = $namedOCv.":. Select up to five(5) designs you'd like to incorporate into the functional interfacing and creative design of your new website production.";
	$bgSubSectionTITLE = "OpenCanvas Version ".$elOCv.", select up to five(5) designs you&rsquo;d like to incorporate into the functional interfacing and creative design of your new website production.";
	
	$bgSectionLINK= $sectionLINK;
	$bgSubSectionLINK = ""; //<< is to self by making it empty
	//--> REQUEST DOCUMENT MARKUP FOR CAROUSEL V1
	// --> NOW LOCALIZED [ $CarouselBodyMarkup = CarouselBodyMarkup($myCanvasList,$bgSectionALT,$bgSectionTITLE,$bgSectionLINK,$bgSubSectionALT,$bgSubSectionTITLE,$bgSubSectionLINK); ]

	//--> 
	//--> END CAROUSEL PREPROCESSING
	//--> 
	
	// grab the imagemap for the star rating functions
	$StarRatingImagemap = StarMapperMarkup();



	//--> attain the advertisements for this page
//	$CommonADQuery = "AdKeys LIKE '%Data%' OR AdKeys LIKE 'Data%' OR AdKeys LIKE '%Data' OR AdKeys LIKE '%Encrypt%' OR AdKeys LIKE '%Encrypt' OR AdKeys LIKE 'Encrypt%'";
	$CommonADQuery = "AdKeys LIKE '%Website%' OR AdKeys LIKE 'Website%' OR AdKeys LIKE '%Website' 
	OR AdKeys LIKE '%Ecom%' OR AdKeys LIKE '%Ecom' OR AdKeys LIKE 'Ecom%' 
	OR AdKeys LIKE '%Design%' OR AdKeys LIKE '%Design' OR AdKeys LIKE 'Design%'";
	$ForceDouble = 1;
	require_once($HTTPRoot.'commonAdvertisements.php' );

global $HTTP_ENV_VARS;
##-- pass valid top placement
$UA = "".getenv("HTTP_USER_AGENT")."";

$selectWidth = '243';
if (!(stristr($UA, 'Opera') === FALSE)) {
	$selectWidth = "242";
}
else if(stristr($UA, 'MSIE') === FALSE) {
	$canvasOverlibHoriz = '0';
	if(!(stristr($UA, 'Chrome') === FALSE)) {
		$selectWidth = "243";
	}
	else if (!(stristr($UA, 'Safari') === FALSE)) {
		$selectWidth = "242";
	}
}
else {
	$canvasOverlibHoriz = '8';
}



















?>

<?php echo $myHeadPiece?>
<!--<?php echo $UA?>-->
<style type="text/css" media="screen">
	.Open-Canvas-Slot-Back-InuseOff { background: url(/web_design_imagery/Open-Canvas-Slot-Back_inuseOff.jpg) repeat-x 2px 0; cursor:pointer; } .Open-Canvas-Slot-Back-InuseOver { background: url(/web_design_imagery/Open-Canvas-Slot-Back_inuseOver.jpg) repeat-x 2px 0; cursor:pointer; } .Open-Canvas-Slot-Back-Disabled { height:34px; background: url(/web_design_imagery/Open-Canvas-Slot-Back_disabled.jpg) repeat-x 2px 0; } .Open-Canvas-Slot-White { width:1px; height:34px; background-color:#FFFFFF; } .Open-Canvas-Slot-Spacer { width:3px; height:27px; overflow:hidden; clip:rect(0px, 3px, 27px, 0px); background: url(/web_design_imagery/Open-Canvas-Slot-Spacer.gif) no-repeat 0 0; } .Open-Canvas-Slot-Spacer-Disabled { width:3px; height:27px; overflow:hidden; clip:rect(0px, 3px, 27px, 0px); background: url(/web_design_imagery/Open-Canvas-Slot-Spacer-Disabled.gif) no-repeat 0 0; } .Template-Is-Unique { } 
	
	.Template-ID { padding-left:6px; color:#000000; font-size:11px; font-family:arial,helvetica,verdana; } 
	.Template-Price { padding-right:6px; color:#000000; font-size:11px; font-family:arial,helvetica,verdana; }
	.Template-Add-Comments { padding-top:4px; }
	.Template-More-Options { padding-top:8px; }

/*
	.Template-ID { padding-left:6px; width:74px; height:34px; clip:rect(0px, 74px, 34px, 0px); overflow:hidden; background:yellow; color:#000000; font-size:11px; font-family:arial,helvetica,verdana; } 
	.Template-Price { padding-right:6px; width:71px; height:34px; clip:rect(0px, 71px, 34px, 0px); overflow:hidden; background:green; color:#000000; font-size:11px; font-family:arial,helvetica,verdana; } 
	.Template-Add-Comments { width:25px; height:34px; clip:rect(0px, 25px, 34px, 0px); overflow:hidden; background:red; }
	.Template-More-Options { width:24px; height:34px; clip:rect(0px, 24px, 34px, 0px); overflow:hidden; background:orange; }
*/

	select { border-top:#ABADB3 1px solid; border-left:#E2E3EA 1px solid; border-right:#E2E3EA 1px solid; border-bottom:#E3E9EF 1px solid; font-family:arial,verdana,helvetica; }
	#SelectedCanvas { position:relative; visibility:visible; top:-19px; left:3px; padding-left:2px; z-index:11; width:<?php echo $selectWidth?>px; height: 18px; font-size:11px; font-family: verdana; border:0; background-color: #FFFFFF; font-family:arial,verdana,helvetica; padding-top:2px; } 
	.ocselect { width:266px; height:21px; font-size:12px; }
	#search-string { font-size:14px; padding-left:6px; }
	#CanvasTotal { position:relative; top:0px; left:0px; height:26px; width:266px; overflow:hidden; clip:rect(0px,266px,26px,0px); visibility:visible; }
	#CanvasTotalWrap { width:264px; height:24px; border-top:#ABADB3 1px solid; border-left:#E2E3EA 1px solid; border-right:#E2E3EA 1px solid; border-bottom:#DFE6EC 1px solid; background-color: #FFFFFF; }
	#CanvasTotalDisplay { font-size:11px; text-align:center; font-family:arial,verdana,helvetica; } 
	#CanvasSelection { position:relative; top:0px; left:0px; height:21px; width:266px; overflow:hidden; clip:rect(0px,266px,21px,0px); z-index:10; visibility:visible; }
	.CanvasPrompts,.CanvasPromptSubmitted { font-size: 10px; font-family:Tahoma, Arial, Helvetica; color:#333333; width:255px;height:40px;margin-bottom:15px;overflow:hidden;clip:rect(0px,255px,40px,0px); }
	.CanvasPromptInner { text-align:left; padding:6px; padding-left:10px;padding-top:7px;line-height:12px;}
	.CanvasFooter { width:225px;font-size:11px;padding-top:8px;line-height:13px; }

	.CanvasPrompts, .CanvasPromptSubmitted {
		border:#EEF0F5 1px solid;
		border-radius: 4px;
		-moz-border-radius: 4px;
		-webkit-border-radius: 4px;
		box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
		-moz-box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
		-webkit-box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
	}
	/* START CSS CONTEXT MENU */
	.canvasContextItem { font-family:arial,helvetica; font-size:11px; }
	/* canvasContext CSS */
	#canvasContext { position:relative; top:0px; left:0px; width:14px; background:url(/web_design_imagery/Open-Canvas-Slot-More-Options_off.gif) no-repeat 0 0; cursor:pointer; }
	#canvasContext:hover { background:url(/web_design_imagery/Open-Canvas-Slot-More-Options_over.gif) no-repeat 0 0; }
	#canvasContext ul { list-style: none; padding: 0px; margin:0px; }
	#canvasContext a { font-family:arial,helvetica; font-size:11px; font-weight:normal; display: block; margin: 0; padding: 2px 3px; color: #000; text-decoration: none; }
	#canvasContext li { position: relative; height:22px; text-align:left; }
	#canvasContext ul ul ul { padding:0px; margin:0px; position: absolute; top: 0px; left: 14px; border:#E1E3EC 1px solid; z-index:30000; background:url(/web_design_imagery/canvasContextBacker.gif) repeat 0 0; }
	#canvasContext ul ul li:hover div#shadow { position: absolute; top: 0px; left: -200px; background:url(/web_design_imagery/contextShadow_4.png) no-repeat 14px 0px; width:202px; height:107px;}
	div#canvasContext ul ul ul li { border:none; padding:1px; margin:0px; width:175px; height:22px; line-height:16px; }
	div#canvasContext ul ul li:hover ul li:hover { border:#E1E3EC 1px solid; padding:0px; margin:0px; width:175px; height:22px; line-height:16px; background:#F8F9FA; }
	div#canvasContext ul ul ul {display: none; padding:1px; margin:0px; }
	div#canvasContext ul ul li:hover ul {display: block;padding:1px; margin:0px; }
</style>
<!--from newindex [off HTMLo design]-->
<style type="text/css">
.Web-Design-1 { padding-left:10px; padding-right:10px; font-family: Tahoma, Arial, Helvetica; font-size: 20px; font-weight: normal; color: #266899; }
fieldset { 
	position:relative; 
	width:290px; 
	height:auto; 
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
	-moz-box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
	-webkit-box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
}
.Web-Design-3 { padding:15px; padding-left:20px; padding-top:5px; line-height:22px; font-family:tahoma,arial,verdana; font-size:14px; color:#000000; }
.Web-Design-2, .Web-Design-4 { padding-bottom: 6px; width:236px; height:10px; background: url(/web_design_imagery/interface-design-bodyLinear1.gif) repeat-x 0 0px; }
.Web-Design-4 { background:none; width:290px; }
.Web-Design-5 a{ padding-right:15px; width:290px;height:16px;font-family:tahoma,arial,verdana;font-size:10px;color:#B0B0B0; }
.Web-Design-5 a:hover { width:290px;height:14px;font-family:tahoma,arial,verdana;font-size:10px;color:#CC0000; text-decoration:none; }
.Web-Design-5dark { width:290px;height:16px;font-family:tahoma,arial,verdana;font-size:10px;color:#000000; text-decoration:underline; }
.Web-Design-5dark:hover { width:290px;height:16px;font-family:tahoma,arial,verdana;font-size:10px;color:#CC0000; text-decoration:underline; }
.Web-Design-Nocont { width:25px; height:1px; overflow:hidden; clip:rect(0px, 25px, 1px, 0px); }

.Web-Design-Wrapper { padding-top:32px; padding-bottom:32px; margin-left: 27px; width:615px; }
.Web-Design-FormContainer { margin-left: 10px; width:605px; }
.Web-Design-Prompt { font-family:tahoma,arial,verdana; font-size:14px; font-weight:bold; color:#000000; }
.Web-Design-Instructions { margin-left:30px; margin-bottom:20px; width:540px; font-family:verdana,tahoma,arial; font-size:12px; color:#000000; font-weight:normal; }
.EOFSectionTitle { margin-left:10px; margin-bottom:20px; font-family:Tahoma, Arial, Helvetica; font-size:19px; font-weight:normal; color:#266899; }
.EOFSectionIntroduction { margin-left:10px; padding-right:35px; font-family:Tahoma, Arial, Helvetica; font-size:15px; font-weight:normal; color:#000000; line-height:22px; }

legend.Web-Design-Legend { padding-top:15px; padding-bottom:10px; font:12px verdana,arial,helvetica; color:#000000; font-weight:bold; }
label.Web-Design-Label { font-size:14px; }
textarea.Web-Design-Textarea { width:550px; height:180px; font-family:Courier New,monospace,serif;font-size:12px; }
#Web-Design-Textarea { margin-left:25px; margin-bottom:10px; }
input.Web-Design-Buttons { height:24px; font-family:Verdana,Arial,Helvetica; font-size:12px; }
#Web-Design-Buttons { margin-right:30px; margin-bottom:12px; }
#Web-Design-CodeRequest { margin-left:21px; margin-bottom:10px; } 

textarea.HTML-O-Feedback { width:256px;height:85px; font-family:Courier New,monospace,serif;font-size:12px; }

#Web-Design-View-title { text-align: left; }
#Web-Design-View-title b { display: block; margin-right: 80px; }
#Web-Design-View-title span { float: right; }

.SectionTitle { }
#AD3 { margin-top:40px; }
</style>
<!--[if lt IE 7]>
<style type="text/css" media="screen">
	body { behavior: url(/csshover.htc); font-size: 100%; } 
	#canvasContext ul li a {height: 1%;} 
	#canvasContext a, #canvasContext h2 { font: bold 0.7em/1.4em arial, helvetica, sans-serif; } 
</style>
<![endif]-->
<!--END CSS CONTEXT MENU-->

<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-function-selectlist.js"></script><div id="documentBody"><center><div id="documentBodyHeader"></div><div id="documentBodyContent">
<script>
var sectionPages = new Array();
<?php echo $subMIs;?>
<?php echo $UpdateOpenCanvas;?>

var toggleMainOverlib = 1;
var DontSwitchBackground = '';

var whichCanvasSelected = ''; 
var lastCanvas = '';
var canvasPrice = 0;
var addonPrice = 0;

var uniquePrice = 0;
var canvasPriceToggled = 0;
var whichUnique = 0;

var myWebsiteExtras = <?php echo $myWebsiteExtras; ?>;
var myWebsiteMaintenance = <?php echo $myWebsiteMaintenance; ?>;
var lastAddon = '<?php echo $lastAddon; ?>';
var lastMaint = '<?php echo $lastMaint; ?>';

var WebDesignTab = 'OpenCanvas-Custom-Web-Design-Overview';
var WebDesignContent = 'OpenCanvas-Website-Design-Package-Overview';

var swapOpenCanvas = function(laya,switchie,piece) {
var Dom = YAHOO.util.Dom;var laLaya = Dom.get(laya);
var lid = 0;

if(laLaya.id.indexOf("5")!=-1){lid=5;}else if(laLaya.id.indexOf("4")!=-1){lid=4;}else if(laLaya.id.indexOf("3")!=-1){lid=3;}else if(laLaya.id.indexOf("2")!=-1){lid=2;}else {lid=1;}var elIcon = '';if (lid!=0 && CanvasContains[lid-1]) {elIcon = 'Template-Image-'+activeTemplates[CanvasContains[lid-1]].id+'';elIcon = elIcon.innerHTML;}else {lid=0;}if (laLaya.className != "Open-Canvas-Slot-Back-Disabled") {if (switchie == 1) {laLaya.className = "Open-Canvas-Slot-Back-InuseOver";if (lid!=0 && toggleMainOverlib==1) {if (piece == 'info') {}}}else { laLaya.className = "Open-Canvas-Slot-Back-InuseOff"; if (lid!=0) { if (piece == 'info') { this.nd(); } } }}else { if (switchie == 1) { } else { } }};

// all template actions come through here, even carousel.
// Based on the level from which we are calling, we can tell if we are at the carousel or the canvas levels
var runCanvasOptions = function(laya,switchie) {var Dom = YAHOO.util.Dom;var laLaya = Dom.get(laya);var myPrice = '0.00';var pricing = 'Common';var cualSwap = 'unique'; var cualSwap2 = 'to a ';var pricedAs = '<b>No:</b> '+pricing+' License'; 
var aboutLicense = '<b>About Common Licensing</b><div style=padding-top:5px;>Purchasing this design&acute;s common license allows us to continue selling this design to future customers. In essence, customers can continue buying common licenses for this design until it goes out of circulation. Website designs stay in circulation until a customer purchases a unique license for it.</div>';
var templatePricer = '<form><center><div><input type=radio id=CanvasRadio-MIID-0 class=templateRADIO name=MIID value=0 checked1><input type=radio id=CanvasRadio-MIID-1 class=templateRADIO name=MIID value=1 checked2 style=margin-left:20px;></div><div class=templatePRICES><div id=CanvasTemplateCOMMON-MIID class=templateCOMMON>common</div><div id=CanvasTemplateUNIQUE-MIID class=templateUNIQUE>unique</div><div><span id=CanvasPriceCOMMON-MIID class=priceCOMMON style=font-weight:checked1x>$MIPRICE</span><span id=CanvasPriceUNIQUE-MIID class=priceUNIQUE style=font-weight:checked2x>$MIBUYOUT</span></div></div></center></form>';
var commentTemplate = '<div id=Comment-MIID class=templateComment onClick>TCOMMENTS</div>';

var lid = 0;var checked1 = 'checked'; var checked2 = ''; var checked1x = 'bold'; var checked2x = 'normal';if(laLaya.parentNode){if(laLaya.parentNode.parentNode){if(laLaya.parentNode.parentNode.parentNode){if(laLaya.parentNode.parentNode.parentNode.parentNode){if(laLaya.parentNode.parentNode.parentNode.parentNode.parentNode){if(laLaya.parentNode.parentNode.parentNode.parentNode.parentNode.id){if(laLaya.parentNode.parentNode.parentNode.parentNode.parentNode.id.indexOf("5")!=-1){lid=5;}else if(laLaya.parentNode.parentNode.parentNode.parentNode.parentNode.id.indexOf("4")!=-1){lid=4;}else if(laLaya.parentNode.parentNode.parentNode.parentNode.parentNode.id.indexOf("3")!=-1){lid=3;}else if(laLaya.parentNode.parentNode.parentNode.parentNode.parentNode.id.indexOf("2")!=-1){lid=2;}else {lid=1;}}}}}}}if (activeTemplates[CanvasContains[lid-1]]) {if (activeTemplates[CanvasContains[lid-1]].pricetoggle == 0) { myPrice = activeTemplates[CanvasContains[lid-1]].price; }else { aboutLicense = '<b>About Unique Licensing</b><div style=padding-top:5px;>By buying a unique license for a given design, you can resell it, reuse it without limit on as many domains or websites as you&acute;d like and do anything you want with it. With a unique license you have complete ownership of the design and are at liberty to use, modify, distribute and resell it as you see fit. Furthermore, the design will be permenantly removed from our point-of-sale systems and will never be available for purchase again.</div>'; pricing = 'Unique'; pricedAs = '<b>Yes:</b> '+pricing+' License'; cualSwap = 'common'; cualSwap2 = 'back to a '; myPrice = activeTemplates[CanvasContains[lid-1]].buyout; checked1 = ''; checked2 = 'checked'; checked1x = 'normal'; checked2x = 'bold'; }}if (laLaya.innerHTML.indexOf("+") != -1) {if (switchie == 1) {var elel=laLaya.innerHTML;if(lid!=0) {miID = activeTemplates[CanvasContains[lid-1]].id;miPrice = activeTemplates[CanvasContains[lid-1]].price;miBuyout = activeTemplates[CanvasContains[lid-1]].buyoutmyTemplatePrice = templatePricer;myTemplatePrice = myTemplatePrice.replace(/checked1x/g,checked1x).replace(/checked2x/g,checked2x).replace(/MIID/g,miID).replace(/MIPRICE/g,miPrice).replace(/MIBUYOUT/g,miBuyout).replace(/checked1/g,checked1).replace(/checked2/g,checked2);toggleMainOverlib=0;
	// '<div style=line-height:12px;text-align:left;padding:10px;><b style=font-size:12px;>What type of licensing would you like to purchase for you website&rsquo;s design template?</b><br><br>'+myTemplatePrice+'<br><br><div style=font-size:11px;line-height:13px;>'+aboutLicense+'</div><br><br><center>- <font style=color:#266899>click to switch '+cualSwap2+''+cualSwap+' license</font> -</center></div>';
	//return this.overlib('<div style=line-height:12px;text-align:left;padding:10px;><b style=font-size:12px;>What type of licensing would you like to purchase for you website&rsquo;s design template?</b><br><br>'+myTemplatePrice+'<br><br><div style=font-size:11px;line-height:13px;>'+aboutLicense+'</div><br><br><center>- <font style=color:#266899>click to switch '+cualSwap2+''+cualSwap+' license</font> -</center></div>', OFFSETY, 5, OFFSETX, 15, LEFT, VAUTO, CELLPAD, 10, WIDTH, 300, DELAY, 250);
}}else {if(lid!=0) {this.nd();toggleMainOverlib=1;}}}
else {
	if (!(!laLaya.firstChild)) {
		if (!(!laLaya.firstChild.src)) {
			var mysrc = laLaya.firstChild.src; 
			if (mysrc.indexOf("disabled") != -1) { }
			else { 
				if (switchie == 1) { 
					mysrc = mysrc.replace("off","over"); 
					laLaya.firstChild.src = mysrc; 
					if (mysrc.indexOf("Unique") != -1) { 
						if(lid!=0) {
							miID = activeTemplates[CanvasContains[lid-1]].id; 
							miPrice = activeTemplates[CanvasContains[lid-1]].price; 
							miBuyout = activeTemplates[CanvasContains[lid-1]].buyout; 
							myTemplatePrice = templatePricer; 
							myTemplatePrice = myTemplatePrice.replace(/checked1x/g,checked1x).replace(/checked2x/g,checked2x).replace(/MIID/g,miID).replace(/MIPRICE/g,miPrice).replace(/MIBUYOUT/g,miBuyout).replace(/checked1/g,checked1).replace(/checked2/g,checked2); 
							toggleMainOverlib=0;
							$(laLaya).RemoveBubblePopup();
							$(laLaya).CreateBubblePopup( BPoptions ).each( function() {
								if (canvasPriceToggled == 0 || miID == whichUnique) {
									$(this).SetBubblePopupInnerHtml('<div style=line-height:12px;text-align:left;padding:10px;><b style=font-size:12px;>What type of licensing would you like to purchase for you website&rsquo;s design?</b><br><br>'+myTemplatePrice+'<br><br><div style=font-size:11px;line-height:13px;>'+aboutLicense+'</div><div style=padding-top:12px;><center>- <font style=color:#266899>click to switch '+cualSwap2+''+cualSwap+' license</font> -</center></div></div>');
								}
								else {
									$(this).SetBubblePopupInnerHtml('<div style=line-height:12px;text-align:left;padding:10px;><b style=font-size:12px;>You&rsquo;ve already flagged another design in your canvas as unique, we only allow one unique design per canvas.</b><br><br>'+myTemplatePrice+'<br><br><div style=font-size:11px;line-height:13px;width:auto;float:left;padding-bottom:10px;>If you want to make this design unique instead of the other design you have slated as such, remove the unique flag from the other design then come back and flag this design as unique.</div></div>');
								}
							});
							// return this.overlib('<div style=line-height:12px;text-align:left;padding:10px;><b style=font-size:12px;>What type of licensing would you like to purchase for your website&rsquo;s design template?</b><br><br>'+myTemplatePrice+'<br><br><div style=font-size:11px;line-height:13px;>'+aboutLicense+'</div><br><br><center>- <font style=color:#266899>click to switch '+cualSwap2+''+cualSwap+' license</font> -</center></div>', OFFSETY, 5, OFFSETX, 15, LEFT, VAUTO, CELLPAD, 10, WIDTH, 300, DELAY, 250); 
						}
					}
					else if (mysrc.indexOf("Comments") != -1) {
						if(lid!=0) {
							toggleMainOverlib=0;
							myTemplateCom = commentTemplate;
							miID = activeTemplates[CanvasContains[lid-1]].id;
							miCommentSwitch = activeTemplates[CanvasContains[lid-1]].comments;
							$(laLaya).RemoveBubblePopup();
							if (miCommentSwitch == 1) {
								$(laLaya).CreateBubblePopup( BPoptions ).each( function() {
									$(this).SetBubblePopupInnerHtml('<div style=line-height:12px;text-align:left;padding:10px;><div id=Template-Comments-'+miID+'>Loading...</div><div style=padding-top:12px;><center>- <font style=color:#266899>click to edit your notes</font> -</center></div></div>');
								});
								captureTemplateComment(miID,laLaya);
							}
							else {
								myTemplateCom = myTemplateCom.replace(/TCOMMENTS/g,'You don&rsquo;t have any notes saved to this design.');
								$(laLaya).CreateBubblePopup( BPoptions ).each( function() {
									$(this).SetBubblePopupInnerHtml('<div style=line-height:12px;text-align:left;padding:10px;>'+myTemplateCom+'<div style=padding-top:12px;><center>- <font style=color:#266899>click to add some notes to this design</font> -</center></div></div>');
								});
							}
							// return this.overlib('<div style=line-height:12px;text-align:left;padding:10px;><b style=font-size:12px;>What type of licensing would you like to purchase for your website&rsquo;s design template?</b><br><br>'+myTemplatePrice+'<br><br><div style=font-size:11px;line-height:13px;>'+aboutLicense+'</div><br><br><center>- <font style=color:#266899>click to switch '+cualSwap2+''+cualSwap+' license</font> -</center></div>', OFFSETY, 5, OFFSETX, 15, LEFT, VAUTO, CELLPAD, 10, WIDTH, 300, DELAY, 250); 
						}
					}
				}
				else {
					mysrc = mysrc.replace("over","off");
					laLaya.firstChild.src = mysrc; 
					if (mysrc.indexOf("Unique") != -1 || mysrc.indexOf("Comments") != -1) { 
						this.nd(); 
						toggleMainOverlib=1; 
						$(laLaya).RemoveBubblePopup();
					}
				}
			}
		}
	} 
} };

var captureTemplateComment = function(id,laLaya) {
	var lUrl = '/opencanvas-interactive-website-design/findMyTemplates.php?query=comments&t=' + id + '';
	var callback = {
		success: function(o) {
			var tcom = YAHOO.util.Dom.get("Template-Comments-"+id+"");
			if (!(!tcom)) {
				if(o.responseText !== undefined) { tcom.innerHTML = o.responseText; }
				else { tcom.innerHTML = ''; }
			}
		}
	};
	var transaction = YAHOO.util.Connect.asyncRequest("GET", lUrl, callback, null);
};

// used with in-line carousel items [now used with popups, no longer with in use by carousel]
//-- maybe run setCanvasPrice, maybe not here
var toggleTemplatePrice = function(id,switchie) {
	activeTemplates[id].pricetoggle = switchie;
	var Dom = YAHOO.util.Dom; 
	var laPCommon = Dom.get("priceCOMMON-"+id+""); 
	var laPUnique = Dom.get("priceUNIQUE-"+id+""); 
	var laRCommon = Dom.get("radio-"+id+"-0"); 
	var laRUnique = Dom.get("radio-"+id+"-1"); 
	if (switchie == 1) {
		YAHOO.util.Dom.setStyle(laPCommon, "font-weight", "normal"); 
		YAHOO.util.Dom.setStyle(laPUnique, "font-weight", "bold"); 
		laRCommon.checked = 0;
		laRUnique.checked = 1;
		updateUserCart(id,laRUnique.checked);
		whichUnique = id;
	} 
	else { 
		YAHOO.util.Dom.setStyle(laPCommon, "font-weight", "bold"); 
		YAHOO.util.Dom.setStyle(laPUnique, "font-weight", "normal"); 
		laRCommon.checked = 1; 
		laRUnique.checked = 0;
		updateUserCart(id,laRUnique.checked);
		uniquePrice = 0.00;
		setCanvasPrice(whichCanvasSelected);
		canvasPriceToggled = 0;
		whichUnique = '';
	}
};
var updateUserCart = function(template,pricing) {
	var lUrl = '/opencanvas-interactive-website-design/saveMyCanvas.htm?uni=1&t='+template+'&u='+pricing+'&v='+OCvVER+'';
	var callback = {
		cache:false,
		success: function(o) {
			if(o.responseText !== undefined) {
				//alert(o.responseText);
			}
		},
		failure: function(o) {}
	};
	var transaction = YAHOO.util.Connect.asyncRequest("GET", lUrl, callback, null);
};

var saveAddons = function(addon,chosen,tipio) {
	var lUrl = '/opencanvas-interactive-website-design/saveMyCanvas.htm?uni=1&a='+addon+'&u='+chosen+'&v='+OCvVER+'';
	var callback = {
		cache:false,
		success: function(o) {
			if(o.responseText !== undefined) {
				// addon for real
				if (tipio == 1) {
					if (chosen == 0) { lastAddon = ''; }
					else { lastAddon = addon; }
				}
				// maintenance
				else if (tipio == 2) {
					if (chosen == 0) { lastMaint = ''; }
					else { lastMaint = addon; }
				}
			}
		},
		failure: function(o) {}
	};
	var transaction = YAHOO.util.Connect.asyncRequest("GET", lUrl, callback, null);
};


var forwardFriend = function(quien, id) {
	if (activeTemplates[id]) {
		var lUri = '/customer-communication-panel.htm?share=1&t=OCv'+OCvVER+''+id+'&v='+OCvVER+'';
		quien.rel = lUri;
		runFancyFrame(quien);
	}
};
var canvasQuestion = function(quien, id) {
	if (activeTemplates[id]) {
		var lUri = '/customer-communication-panel.htm?question=1&t=OCv'+OCvVER+''+id+'&v='+OCvVER+'';
		quien.rel = lUri;
		runFancyFrame(quien);
	}
};


var lastCommentEdit = '';
var toggleCanvasComments = function(quien,id) {
	if (activeTemplates[id]) {
		miCommentSwitch = activeTemplates[id].comments;
		actcomment = 'addc';
		if (miCommentSwitch == 1) { actcomment = 'editc'; }
		lastCommentEdit = quien;
		var lUri = '/customer-communication-panel.htm?'+actcomment+'=1&t=OCv'+OCvVER+''+id+'&v='+OCvVER+'';
		quien.rel = lUri;
		runFancyFrame(quien);
	}
};
var swapCanvasCommentState = function(id) {
	if (lastCommentEdit != '') {
		if (activeTemplates[id]) {
			var Dom = YAHOO.util.Dom;
			var laTCImage = Dom.get("Template-Comments-Toggle-"+id+""); 
			var laTID = Dom.get("Template-ID-"+id+""); 
			if (activeTemplates[id].comments == 1) { laTCImage.innerHTML = '<img src="/web_design_imagery/Open-Canvas-Slot-Add-Comments_view_off.gif" width="16" height="13" border="0">'; }
			else { laTCImage.innerHTML = '<img src="/web_design_imagery/Open-Canvas-Slot-Add-Comments_add_off.gif" width="16" height="13" border="0">'; }
		}
		lastCommentEdit.blur();
		lastCommentEdit != '';
	}
};

// used by other dynamic pricing methods
var toggleCanvasPrice = function(quien,id) { 
	if (activeTemplates[id]) {
		var Dom = YAHOO.util.Dom;
		var laTImage = Dom.get("Template-Image-"+id+""); 
		var laTID = Dom.get("Template-ID-"+id+""); 
		var laTPrice = Dom.get("Template-Price-"+id+""); 
		if (activeTemplates[id].pricetoggle == 1) {
			laTImage.innerHTML = '<img src="/web_design_imagery/Open-Canvas-Slot-Unique-Template_common_off.gif" width="9" height="10" border="0">'; 
			YAHOO.util.Dom.setStyle(laTPrice, "color", "#000000"); 
			laTPrice.innerHTML = '+'+activeTemplates[id].price; 
			activeTemplates[id].pricetoggle = 0; 
			updateUserCart(id,activeTemplates[id].pricetoggle);
			uniquePrice = 0.00;
			setCanvasPrice(whichCanvasSelected);
			canvasPriceToggled = 0;
			whichUnique = '';
		}
		else if (canvasPriceToggled == 0) {
			laTImage.innerHTML = '<img src="/web_design_imagery/Open-Canvas-Slot-Unique-Template_unique_off.gif" width="9" height="10" border="0">'; 
			YAHOO.util.Dom.setStyle(laTPrice, "color", "#0071A6"); 
			laTPrice.innerHTML = '+'+activeTemplates[id].buyout; 
			activeTemplates[id].pricetoggle = 1; 
			updateUserCart(id,activeTemplates[id].pricetoggle);
			uniquePrice = activeTemplates[id].buyout;
			if (isNaN(uniquePrice)) { uniquePrice = uniquePrice.replace(',',''); }
			setCanvasPrice(whichCanvasSelected);
			canvasPriceToggled = 1;
			whichUnique = id;
		}
	} 
	quien.blur();
}; 
var templateModal = function(id) {var milid = id; if (activeTemplates[milid]) { elWidth = parseFloat(activeTemplates[milid].screenw) + 500 + 4; elHeight = parseFloat(activeTemplates[milid].screenh) + 40 + 40 + 4; /*11 border above and 11 border below screenshot image + 2px above and 2px below (1pad 1bord each)*/var templateModalo = '/opencanvas-interactive-website-design/templateModal.php?query=' + activeTemplates[milid].id + '&width='+elWidth+'&height='+elHeight+'&isIFRAME=1&TB_iframe=true';openFlashBox('' + templateModalo + '',elWidth,elHeight);}};
var OpenCanvases = new Array(); 
//-WITH PRICE
OpenCanvases[0] = new Option("<span style=font-size:10px;>Package:</span> <b>Open<font style=color:#266899>Canvas</font> Xpress</b> [$"+Commify('<?=$OCv1Price?>')+"]</span>", "OCv1", "<?php echo $OCvSelected[1];?>", "");
OpenCanvases[1] = new Option("<span style=font-size:10px;>Package:</span> <b>Open<font style=color:#266899>Canvas</font> Business</b> [$"+Commify('<?=$OCv2Price?>')+"]</span>", "OCv2", "<?php echo $OCvSelected[2];?>", "");
OpenCanvases[2] = new Option("<span style=font-size:10px;>Package:</span> <b>Open<font style=color:#266899>Canvas</font> Advanced</b> [$"+Commify('<?=$OCv3Price?>')+"]</span>", "OCv3", "<?php echo $OCvSelected[3];?>", "");
//-NO PRICE
//-OpenCanvases[0] = new Option("<span style=font-size:10px;>Package:</span> <b>Open<font style=color:#266899>Canvas</font> Xpress</b></span>", "OCv1", "<?php echo $OCvSelected[1];?>", "");
//-OpenCanvases[1] = new Option("<span style=font-size:10px;>Package:</span> <b>Open<font style=color:#266899>Canvas</font> Business</b></span>", "OCv2", "<?php echo $OCvSelected[2];?>", "");
//-OpenCanvases[2] = new Option("<span style=font-size:10px;>Package:</span> <b>Open<font style=color:#266899>Canvas</font> Advanced</b></span>", "OCv3", "<?php echo $OCvSelected[3];?>", "");

var inCanvasPrices = new Array(<?php echo $jsCanvasPriceList?>);
var setTheCanvas = function(whichCanvasSelected) {
	var Dom = YAHOO.util.Dom;
	for (var i=0; i<OpenCanvases.length; i++) { var myVALUE = ''+OpenCanvases[i].value+''; 
	if (myVALUE == whichCanvasSelected) { 
		Dom.get("SelectedCanvas").innerHTML = OpenCanvases[i].html;
		setCanvasPrice(i);
		//set global canvas version number
		OCvVER = i+1;
	}}
	setTimeout('canvasPrompts(0,0,0)',1000); 
};
var PriceSSL = <?php echo $PriceSSL; ?>;
var PriceSEM = <?php echo $PriceSEM; ?>;
var PriceSSLSEM = <?php echo $PriceSSLSEM; ?>;
var PriceBUSCON = <?php echo $PriceBUSCON; ?>;
var PricePERCON = <?php echo $PricePERCON; ?>;

var setCanvasPrice = function(litem) {
	var Dom = YAHOO.util.Dom;
	canvasPrice = inCanvasPrices[litem];

	//need total price before addons
	addedPrice = amtround(uniquePrice+addonPrice);
	packageStartingPrice = CurrencyFormatted(addedPrice+canvasPrice);

	//need for this
	PPriceSSL = CurrencyFormatted(PriceSSL+addedPrice+canvasPrice);
	PPriceSEM = CurrencyFormatted(PriceSEM+addedPrice+canvasPrice);
	PPriceSSLSEM = CurrencyFormatted(PriceSSLSEM+addedPrice+canvasPrice);

	//need for this
	PPriceBUSCON = CurrencyFormatted(PriceBUSCON+addedPrice+canvasPrice);
	PPricePERCON = CurrencyFormatted(PricePERCON+addedPrice+canvasPrice);

	if (myWebsiteExtras >= 1) {
<?php if ($elOCv === 1 || $elOCv === 2) { ?>
		if (myWebsiteExtras == 1) { totalPrice = PPriceSSL; lastAddon = 'SSL'; }
		else if (myWebsiteExtras == 2) { totalPrice = PPriceSEM; lastAddon = 'SEM'; }
		else if (myWebsiteExtras == 3) { totalPrice = PPriceSSLSEM; lastAddon = 'SSLSEM'; }
<?php } else { ?>
		if (myWebsiteExtras == 1) { totalPrice = PPriceBUSCON; lastAddon = 'BUSCON'; }
		else if (myWebsiteExtras == 2) { totalPrice = PPricePERCON; lastAddon = 'PERCON'; }
<?php } ?>
	}
	else {
		//now real total price with addons
		totalPrice = CurrencyFormatted(addedPrice+canvasPrice);
	}

	// even though we are not really using this here, we might as well follow the norm and run this by here to keep in line with rest of layout
	if (myWebsiteMaintenance >= 1) {
		if (myWebsiteMaintenance == 1) { lastMaint = 'SIXMONTHMAINTENANCE'; }
		else if (myWebsiteMaintenance == 2) { lastMaint = 'TWELVEMONTHMAINTENANCE'; }
	}
	
	Dom.get("TotalWebsitePrice").innerHTML = 'Website Package Price: <font style="color:#266899">$' + Commify(totalPrice) + '</font>';
	Dom.get("PackageStartingPrice").innerHTML = '' + Commify(packageStartingPrice) + '';


	Dom.get("ComparePriceOpenCanvasExpress").innerHTML = '$' + Commify(CurrencyFormatted(inCanvasPrices[0])) + '';
	Dom.get("ComparePriceOpenCanvasBusiness").innerHTML = '$' + Commify(CurrencyFormatted(inCanvasPrices[1])) + '';
	Dom.get("ComparePriceOpenCanvasAdvanced").innerHTML = '$' + Commify(CurrencyFormatted(inCanvasPrices[2])) + '';

	Dom.get("ComparePriceSSL1").innerHTML = '$' + Commify(CurrencyFormatted(PriceSSL)) + '/year';
	Dom.get("ComparePriceSSL2").innerHTML = '$' + Commify(CurrencyFormatted(PriceSSL)) + '/year';

	Dom.get("CompareBUSCON").innerHTML = '$' + Commify(CurrencyFormatted(PriceBUSCON)) + '/year';
	Dom.get("ComparePERCON").innerHTML = '$' + Commify(CurrencyFormatted(PricePERCON)) + '/year';

<?php if ($elOCv === 1 || $elOCv === 2) { ?>
	Dom.get("PackageWithSSL").innerHTML = '' + Commify(PPriceSSL) + '<font style=font-weight:normal;font-size:9px;> [+'+CurrencyFormatted(PriceSSL)+']</font>';
	Dom.get("PackageWithSEM").innerHTML = '' + Commify(PPriceSEM) + '<font style=font-weight:normal;font-size:9px;> [+'+CurrencyFormatted(PriceSEM)+']</font>';
	Dom.get("PackageWithSSLSEM").innerHTML = '' + Commify(PPriceSSLSEM)  + '<font style=font-weight:normal;font-size:9px;> [+'+CurrencyFormatted(PriceSSLSEM)+']</font>';
<?php } else { ?>
	Dom.get("PackageWithBUSCON").innerHTML = '' + Commify(PPriceBUSCON);
	Dom.get("PackageWithPERCON").innerHTML = '' + Commify(PPricePERCON);
<?php } ?>
	whichCanvasSelected = litem;
};


/*force new document load on stale calls*/
var randomize = function() {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ";
	var string_length = 16;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
};

var changeTheCanvas = function(whichCanvasSelected) { 
	var Dato = new Date();
	for (var i=0; i<OpenCanvases.length; i++) {
		var myVALUE = ''+OpenCanvases[i].value+''; 
		if (myVALUE == whichCanvasSelected) {
			myVALUE = myVALUE.replace("OCv","");
			document.getElementById("SelectedCanvas").innerHTML = OpenCanvases[i].html;
			setCanvasPrice(i);
			parent.location.href = 'http://<?php echo getenv("SERVER_NAME"); ?>'+sectionPages[myVALUE]+'?'+randomize()+'';
		}
	} 
};
/* wCp=whichCanvasType, wCl=whichCanvasLayer, wCt=whichCanvasText [if wCp is set no need for either wCl or wCt] */
var DCanvasPrompter = "<div id=\"CanvasPromptDIV\" class=\"CanvasPrompts\" CLICKJOB style=\"visibility:visible;display:block;background:url(/web_design_imagery/spacer.gif) no-repeat 0 0; APPENDSTYLE\"><div class=\"CanvasPromptInner\">DCanvasPrompter</div></div>";
var countCPM = 0;
var canvasPrompts = function(wCp,wCl,wCt) {
	countCPM++;
	var Dom = YAHOO.util.Dom;

	var DCanvasPrompt1 = Dom.get("CanvasPrompt1"); 
	var DCanvasPrompt2 = Dom.get("CanvasPrompt2"); 
	var DCanvasPrompt3 = Dom.get("CanvasPrompt3"); 
	
	var makeDC1 = 0;
	var makeDC2 = 0;
	var makeDC3 = 0;
	if(jQuery.browser.msie){
		$('.CanvasPrompts, .CanvasPromptSubmitted').css('border','none');
	}
	// only if canvas not submitted yet
	if ('<?php echo $CanvasWasSubmitted; ?>' != '1') {

		var cpContents = Dom.get("PromptSpace");
		switch(wCp) {
			case 1:

			var dcp1 = document.createElement("div");
    	 	dcp1.timeout = setTimeout(function(){ 
				// divBlinks must be called inline due to counting, otherwise wont work [cant call anywhere else cause layers are not filled yet]
				DC1 = "DCPM"+countCPM+"";
				dcp1 = DCanvasPrompt1.firstChild;
				cpContents.appendChild(dcp1);
				divBlink(''+DC1+'',5);
				countCPM++;
	     	}, 5);
			var dcp2 = document.createElement("div");
     		dcp2.timeout = setTimeout(function(){ 
				// divBlinks must be called inline due to counting, otherwise wont work [cant call anywhere else cause layers are not filled yet]
				DC2 = "DCPM"+countCPM+"";
				dcp2 = DCanvasPrompt2.firstChild;
				cpContents.appendChild(dcp2);
				divBlink(''+DC2+'',5);
				countCPM++;
     		}, 4000);
			var dcp3 = document.createElement("div");
    	 	dcp3.timeout = setTimeout(function(){ 
				// divBlinks must be called inline due to counting, otherwise wont work [cant call anywhere else cause layers are not filled yet]
				DC3 = "DCPM"+countCPM+"";
				dcp3 = DCanvasPrompt3.firstChild;
				cpContents.appendChild(dcp3);
				divBlink(''+DC3+'',5);
				countCPM++;
	     	}, 8000);

  			break;
			case 2:
			break;
			default:


			var dcp1 = document.createElement("div");
    	 	dcp1.timeout = setTimeout(function(){ 
				// divBlinks must be called inline due to counting, otherwise wont work [cant call anywhere else cause layers are not filled yet]
				DC1 = "DCPM"+countCPM+"";
				dcp1 = DCanvasPrompt1.firstChild;
				cpContents.appendChild(dcp1);
				divBlink(''+DC1+'',5);
				countCPM++;
     		}, 5);
			var dcp2 = document.createElement("div");
	     	dcp2.timeout = setTimeout(function(){ 
				// divBlinks must be called inline due to counting, otherwise wont work [cant call anywhere else cause layers are not filled yet]
				DC2 = "DCPM"+countCPM+"";
				dcp2 = DCanvasPrompt2.firstChild;
				cpContents.appendChild(dcp2);
				divBlink(''+DC2+'',5);
				countCPM++;
	     	}, 4000);
			var dcp3 = document.createElement("div");
     		dcp3.timeout = setTimeout(function(){ 
				// divBlinks must be called inline due to counting, otherwise wont work [cant call anywhere else cause layers are not filled yet]
				DC3 = "DCPM"+countCPM+"";
				dcp3 = DCanvasPrompt3.firstChild;
				cpContents.appendChild(dcp3);
				divBlink(''+DC3+'',5);
				countCPM++;
     		}, 8000);

		}
	}
		else {
			canvasHasBeenSubmitted();
		}

	<?php echo $UpdateOpenCanvas2;?>
};



	var websiteExtras = function(val) {
		myWebsiteExtras = val;
		$('input:radio[name=Website-Design-Package-Extras]')[val].checked = true;
		setCanvasPrice(whichCanvasSelected);
		saveAddons(lastAddon,val,1);
	};
	var websiteMaintenance = function(val) {
		myWebsiteMaintenance = val;
		$('input:radio[name=Website-Design-Package-Maintenance]')[val].checked = true;
		setCanvasPrice(whichCanvasSelected);
		saveAddons(lastMaint,val,2);
	};
	var msie = '<?php echo $UA; ?>';
	var WebsiteDesignTab = function(tabbie,contento) {
		$("#"+WebDesignContent+"").css('display','none');
		// hide the linear and sides for 'How It Works'
		if (tabbie == 'OpenCanvas-Custom-Web-Design-Works') {
			$("#Website-Design-Warp").hide();
			$("#HideLinear").css('height','30px');
		}
		else {
			$("#Website-Design-Warp").show();
			$("#HideLinear").css('height','');
		}
		if (msie.indexOf("MSIE 5.") != -1 || msie.indexOf("MSIE 6.") != -1 || msie.indexOf("MSIE 7.") != -1 || msie.indexOf("MSIE 8.") != -1) {
			$("#"+WebDesignContent+"").hide();
			$("#"+WebDesignTab+"-Tab").css('top','0').css('z-index','1');
			$("#"+WebDesignTab+"-Tab div").css('font-weight','normal');

			WebDesignTab = tabbie;
			WebDesignContent = contento;
			$("#"+tabbie+"-Tab div").css('font-weight','bold');
			$("#"+tabbie+"-Tab").css('top','4px').css('z-index','2');
			$("#"+contento+"").css('display','block');
			$("#"+contento+"").show();
		}
		else {
			$("#"+WebDesignContent+"").show().fadeTo('slow','0.00',function() {
				$("#"+WebDesignContent+"").hide();
				$("#"+WebDesignTab+"-Tab").css('top','0').css('z-index','1');
				$("#"+WebDesignTab+"-Tab div").css('color','').css('font-weight','');
				WebDesignTab = tabbie;
				WebDesignContent = contento;
				$("#"+tabbie+"-Tab div").css('color','#000000').css('font-weight','bold');
				$("#"+tabbie+"-Tab").css('top','4px').css('z-index','2');
				$("#"+contento+"").fadeTo('fast','0.00',function(){
					$(this).css('display','block').fadeTo('slow','1.00');
				});
			});
		}
	};
	// internal call function [after process]
	var CanvasSubmitted = function() {
		$("#SaveCanvas").html('');
		$("#ResetCanvas").html('');
		$("#SubmitCanvas").html('');
		$("#SubmitCanvas").html('<input type="button" class="canvasButtons" value="Reset Canvas To Design Another" style="padding:3px;font-size:11px;width:250px;" onClick="javascript:resetMyCanvas(this);">');
		$("#CanvasFooter").html('<div class="CanvasFooter">Your <a style="text-decoration:none;color:#266899;font-weight:bold;"><font style="color:#000000;text-decoration:none;">Open</font>Canvas</a> has been submitted, we will be contacting you shortly via email to discuss its production in detail.</div>');
		$('#DCPM1').hide(function() {
			$('#DCPM2').hide('slow',function() {
				$('#DCPM3').hide('slow',function() {
					canvasHasBeenSubmitted();
				});
			});
		});
	};
	// internal call function [after process]
	var CanvasSaved = function() {
		$("#SaveCanvas").html('');
	};

	// loadtime process
	var canvasHasBeenSubmitted = function() {
		var countCPM = 4;
		var Dom = YAHOO.util.Dom;
		var DCanvasPrompt4 = Dom.get("CanvasPrompt4"); 
		var DCanvasPrompt5 = Dom.get("CanvasPrompt5"); 
		var cpContents = Dom.get("PromptSpace");
		var dcp1 = document.createElement("div");
    	dcp1.timeout = setTimeout(function(){ 
			DC1 = "DCPM"+countCPM+"";
			dcp1 = DCanvasPrompt4.firstChild;
			cpContents.appendChild(dcp1);
			divBlink(''+DC1+'',5);
			countCPM++;
	    }, 5);

		var dcp2 = document.createElement("div");
   		dcp2.timeout = setTimeout(function(){ 
			DC2 = "DCPM"+countCPM+"";
			dcp2 = DCanvasPrompt5.firstChild;
			cpContents.appendChild(dcp2);
			divBlink(''+DC2+'',5);
			countCPM++;
   		}, 4000);


		// yummy, thanks jquery ;)
		swapCartState();

			$("#gui-your-shopping-cart").animate({ width: "102px" }, {queue: false});
			$("#gui-your-shopping-cart-text").animate({ width: "81px" }, {queue: false});
			$("#gui-design-your-website").animate({ width: "21px" }, {queue: false});
			$("#gui-design-your-website-text").animate({ width: "0px" }, {queue: false});
	};
	

	var mouseCart = function() {
		$("#gui-your-shopping-cart-text").focus();
	};

	var viewCart = function() {
		
	};
</script>
<table width="920" cellpadding="0" cellspacing="0" border="0" class="nobord">
	<tr>
		<td align="left" class="nobord" width="628" valign="top">
			<div id="webDesignTemplateSpacer" style="width:628px;height:10px;overflow:hidden;clip:rect(0px,628px,10px,0px);"><img src="/web_design_imagery/spacer.gif" width="628" height="10" border="0" alt=""></div>
			<div id="backgroundOverlay" style="width:628px;height:45px;overflow:hidden;clip:rect(0px,628px,45px,0px);"><div style="padding-left:30px;"><a href="<?php echo $bgSectionLINK;?>" title="<?php echo $bgSectionTITLE;?>"><img src="/web_design_imagery/spacer.gif" width="598" height="45" border="0" alt="<?php echo $bgSectionALT;?>"></a></div></div>
			<div id="Open-Canvas-backgroundTitleOverlay" style="width:628px;height:100px;overflow:hidden;clip:rect(0px,628px,100px,0px);"><div style="padding-left:30px;"><a href="<?php echo $bgSubSectionLINK;?>" title="<?php echo $bgSubSectionTITLE;?>"><img src="/web_design_imagery/spacer.gif" width="598" height="100" border="0" alt="<?php echo $bgSubSectionALT;?>"></a></div></div>
			<div id="Web-Design-Template-Browser">
				<div id="Template-Design-Websites">Browse our website designs:</div>
				<div id="Browse-Website-Template-Designs">
					<center>
						<table cellpadding="0" cellspacing="0" border="0" class="nobord" id="Website-Template-Listing">
							<tr valign="middle">
								<td><?php echo $myCanvasList;?></td>
								<td><button id="search-button" class="sbclass" style="padding:0px;padding-left:2px;padding-right:2px;">Browse</button></td>
							</tr>
						</table>
					</center>
				</div>
			</div>
			<div id="Open-Canvas-Container-Contents"></div>
			<div id="Template-Browser-Container">
			<form id="carouselWrap">
			<center>
			<table cellpadding="0" cellspacing="0" border="0" class="nobord">
				<tr>
				
					<td class="nobord" valign="top"><div style="clear:both;margin-top:10px;" id="prev-arrow-container"><img id="prev-arrow" class="left-button-image" src="/website_design_template_images/left-enabled.png" alt="Previous Button"/></div></td>
					<td class="nobord" valign="top"><div id="dhtml-carousel" class="carousel-component"><div class="carousel-clip-region"><ul class="carousel-list"></ul></div></div></td>
					<td class="nobord" valign="top">
						<div style="clear:both;margin-top:10px;" id="next-arrow-container"><img id="next-arrow" class="right-button-image" src="/website_design_template_images/right-enabled.png" alt="Next Button"/></div>
						<div id="DDBuckets">
							<table cellpadding="0" cellspacing="0" border="0">
								<tr><td rowspan="7"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td><td><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td><td rowspan="7"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
								<tr><td><div id="canvas" class="CFTicons" style="background:#FFFFFF url(/web_design_imagery/cft-canvas-off.gif) no-repeat 0 0;"><div style="padding-top:28px;padding-right:2px;">0</div></div></td></tr>
								<tr><td><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
								<tr><td><div id="favorites" class="CFTicons" style="background:#FFFFFF url(/web_design_imagery/cft-favorites-off.gif) no-repeat 0 0;"><div style="padding-top:28px;padding-right:2px;">0</div></div></td></tr>
								<tr><td><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
								<tr><td><div id="trash" class="CFTicons" style="background:#FFFFFF url(/web_design_imagery/cft-trash-off.gif) no-repeat 0 0;"><div style="padding-top:28px;padding-right:2px;">0</div></div></td></tr>
								<!--+8 for dropshadow-->
								<tr><td><div style="width:1px;height:9px;overflow:hidden;clip:rect(0px,1px,9px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="9" border="0"></div></td></tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
			</center>
			</form>
			</div>
		</td>
		<td width="292" valign="top" align="center">
			<form name="OpenCanvasSelector">
			<div style="width:292px;height:571px;overflow:visible;clip:rect(0px,292px,571px,0px);">
			<div id="canvasSpace" style="width:292px;height:30px;overflow:hidden;clip:rect(0px,292px,30px,0px);"><img src="/web_design_imagery/spacer.gif" width="292" height="30" border="0"></div>
			<div id="openCanvas3" style="width:292px;background:url(/web_design_imagery/openCanvasI.png) no-repeat 0 151px;">
				<div id="PromptContainer" style="width:292px;height:168px;overflow:hidden;clip:rect(0px,292px,168px,0px);"><table cellpadding="0" cellspacing="0" border="0" width="292" class="nobord"><tr><td valign="bottom" align="center" height="168"><div id="PromptSpace"></div></td></tr></table></div>
				<div style="width:266px;height:1px;overflow:hidden;clip:rect(0px,266px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="266" height="1" border="0"></div>
				<div style="width:266px;height:1px;overflow:hidden;clip:rect(0px,266px,1px,0px);background-color:#C9CDDF;"><img src="/web_design_imagery/spacer.gif" width="266" height="1" border="0"></div>
				<div style="width:266px;height:1px;overflow:hidden;clip:rect(0px,266px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="266" height="1" border="0"></div>
				<div id="CanvasSelection" align="left"><table width="266" cellpadding="0" cellspacing="0" border="0" bgcolor="#F7F3EF"><tr valign="top"><td align="left"><select name="OCSELECT" class="ocselect" onChange="changeTheCanvas(this.options[this.selectedIndex].value);">
				<!--<option value="OCvI">Package: OpenCanvas Interactive [$920.00]</option>-->
				<option value="OCv1" <?php echo $OCvSelected[1];?>>Package: OpenCanvas Xpress [<?=$OCv1Price?>]</option>
				<option value="OCv2" <?php echo $OCvSelected[2];?>>Package: OpenCanvas Business [<?=$OCv2Price?>]</option>
				<option value="OCv3" <?php echo $OCvSelected[3];?>>Package: OpenCanvas Advanced [<?=$OCv3Price?>]</option>
				</select></td></tr></table><div id="SelectedCanvas"></div></div>
				<div style="width:266px;height:1px;overflow:hidden;clip:rect(0px,266px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="266" height="1" border="0"></div>
				<div style="width:266px;height:1px;overflow:hidden;clip:rect(0px,266px,1px,0px);background-color:#C9CDDF;"><img src="/web_design_imagery/spacer.gif" width="266" height="1" border="0"></div>
				<div style="width:266px;height:1px;overflow:hidden;clip:rect(0px,266px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="266" height="1" border="0"></div>
				<div style="width:266px;height:1px;overflow:hidden;clip:rect(0px,266px,1px,0px);background-color:#C9CDDF;"><img src="/web_design_imagery/spacer.gif" width="266" height="1" border="0"></div>
				<div style="width:266px;height:1px;overflow:hidden;clip:rect(0px,266px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="266" height="1" border="0"></div>
				<table cellpadding="0" cellspacing="0" border="0" width="260" class="nobord" style="border:#C9CDDF 1px solid;">
					<tr>
						<td valign="top">
							<div style="width:264px;height:174px;clip:rect(0px,266px,174px,0px);overflow:visible;">
								<div style="width:264px;height:174px;z-index:1;position:relative;overflow:visible;">
									<table cellpadding="0" cellspacing="0" border="0" class="nobord">
										<tr><td><div class="slot" id="t1"><img src="/web_design_imagery/spacer.gif" width="36" height="32" border="0"></div></td><td width="100%" style="border-left:#C9CDDF 1px solid;padding:1px;"><div class="t2">&nbsp;</div></td></tr>
										<tr><td colspan="2" style="height:1px;" height="1"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
										<tr><td><div class="slot" id="t2"><img src="/web_design_imagery/spacer.gif" width="36" height="32" border="0"></div></td><td width="100%" style="border-left:#C9CDDF 1px solid;padding:1px;"><div class="t2">&nbsp;</div></td></tr>
										<tr><td colspan="2" style="height:1px;" height="1"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
										<tr><td><div class="slot" id="t3"><img src="/web_design_imagery/spacer.gif" width="36" height="32" border="0"></div></td><td width="100%" style="border-left:#C9CDDF 1px solid;padding:1px;"><div class="t2">&nbsp;</div></td></tr>
										<tr><td colspan="2" style="height:1px;" height="1"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
										<tr><td><div class="slot" id="t4"><img src="/web_design_imagery/spacer.gif" width="36" height="32" border="0"></div></td><td width="100%" style="border-left:#C9CDDF 1px solid;padding:1px;"><div class="t2">&nbsp;</div></td></tr>
										<tr><td colspan="2" style="height:1px;" height="1"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
										<tr><td><div class="slot" id="t5"><img src="/web_design_imagery/spacer.gif" width="36" height="32" border="0"></div></td><td width="100%" style="border-left:#C9CDDF 1px solid;padding:1px;"><div class="t2">&nbsp;</div></td></tr>
									</table>
								</div>
								<!--START: THIS ONE SITS ON TOP OF SLOT/TARGET LAYER-->
								<!-- ACTS AS OUR ACTIVE DISPLAY TABLE -->
								<div id="topcanvas" style="width:264px;height:174px;z-index:2;position:relative;left:0px;top:-174px;">
									<table cellpadding="0" cellspacing="0" border="0" class="nobord">
										<tr>
											<td valign="middle" align="left"><div class="CanvasSlot" id="openCanvasImage1" onMouseOver="swapOpenCanvas('openCanvasInfo1',1,'icon');" onMouseOut="swapOpenCanvas('openCanvasInfo1',0,'icon');"><img src="/web_design_imagery/spacer.gif" width="36" height="32" border="0"></div></td>
											<td width="100%" style="border-left:#C9CDDF 1px solid;"><div id="openCanvasInfo1" class="Open-Canvas-Slot-Back-Disabled" onMouseOver="swapOpenCanvas('openCanvasInfo1',1,'info');" onMouseOut="swapOpenCanvas('openCanvasInfo1',0,'info');"></div></td>
										</tr>
										<tr><td colspan="2" style="background-color:#C9CDDF;height:1px;" height="1"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
										<tr>
											<td valign="middle" align="left"><div class="CanvasSlot" id="openCanvasImage2" onMouseOver="swapOpenCanvas('openCanvasInfo2',1,'icon');" onMouseOut="swapOpenCanvas('openCanvasInfo2',0,'icon');"><img src="/web_design_imagery/spacer.gif" width="36" height="32" border="0"></div></td>
											<td width="100%" style="border-left:#C9CDDF 1px solid;"><div id="openCanvasInfo2" class="Open-Canvas-Slot-Back-Disabled" onMouseOver="swapOpenCanvas('openCanvasInfo2',1,'info');" onMouseOut="swapOpenCanvas('openCanvasInfo2',0,'info');"></div></td>
										</tr>
										<tr><td colspan="2" style="background-color:#C9CDDF;height:1px;" height="1"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
										<tr>
											<td valign="middle" align="left"><div class="CanvasSlot" id="openCanvasImage3" onMouseOver="swapOpenCanvas('openCanvasInfo3',1,'icon');" onMouseOut="swapOpenCanvas('openCanvasInfo3',0,'icon');"><img src="/web_design_imagery/spacer.gif" width="36" height="32" border="0"></div></td>
											<td width="100%" style="border-left:#C9CDDF 1px solid;"><div id="openCanvasInfo3" class="Open-Canvas-Slot-Back-Disabled" onMouseOver="swapOpenCanvas('openCanvasInfo3',1,'info');" onMouseOut="swapOpenCanvas('openCanvasInfo3',0,'info');"></div></td>
										</tr>
										<tr><td colspan="2" style="background-color:#C9CDDF;height:1px;" height="1"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
										<tr>
											<td valign="middle" align="left"><div class="CanvasSlot" id="openCanvasImage4" onMouseOver="swapOpenCanvas('openCanvasInfo4',1,'icon');" onMouseOut="swapOpenCanvas('openCanvasInfo4',0,'icon');"><img src="/web_design_imagery/spacer.gif" width="36" height="32" border="0"></div></td>
											<td width="100%" style="border-left:#C9CDDF 1px solid;"><div id="openCanvasInfo4" class="Open-Canvas-Slot-Back-Disabled" onMouseOver="swapOpenCanvas('openCanvasInfo4',1,'info');" onMouseOut="swapOpenCanvas('openCanvasInfo4',0,'info');"></div></td>
										</tr>
										<tr><td colspan="2" style="background-color:#C9CDDF;height:1px;" height="1"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
										<tr>
											<td valign="middle" align="left"><div class="CanvasSlot" id="openCanvasImage5" onMouseOver="swapOpenCanvas('openCanvasInfo5',1,'icon');" onMouseOut="swapOpenCanvas('openCanvasInfo5',0,'icon');"><img src="/web_design_imagery/spacer.gif" width="36" height="32" border="0"></div></td>
											<td width="100%" style="border-left:#C9CDDF 1px solid;"><div id="openCanvasInfo5" class="Open-Canvas-Slot-Back-Disabled" onMouseOver="swapOpenCanvas('openCanvasInfo5',1,'info');" onMouseOut="swapOpenCanvas('openCanvasInfo5',0,'info');"></div></td>
										</tr>
									</table>
								</div>
								<!--END: THIS ONE SITS ON TOP OF DRAG TO LAYER-->
							</div>
						</td>
					</tr>
				</table>
				<div style="width:266px;height:1px;overflow:hidden;clip:rect(0px,266px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="266" height="1" border="0"></div>
				<div style="width:266px;height:1px;overflow:hidden;clip:rect(0px,266px,1px,0px);background-color:#C9CDDF;"><img src="/web_design_imagery/spacer.gif" width="266" height="1" border="0"></div>
				<div style="width:266px;height:1px;overflow:hidden;clip:rect(0px,266px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="266" height="1" border="0"></div>
				<div id="CanvasTotal" align="left"><table cellpadding="0" cellspacing="0" border="0" bgcolor="#F7F3EF"><tr valign="middle"><td align="center" id="CanvasTotalWrap"><div id="CanvasTotalDisplay"><b><div id="TotalWebsitePrice">Website Package Price: <font style="color:#266899">$0.00</font></div></b></div></td></tr></table></div>
				<div id="canvasSpace" style="width:292px;height:20px;overflow:hidden;clip:rect(0px,292px,20px,0px);"><img src="/web_design_imagery/spacer.gif" width="292" height="20" border="0"></div>
				<div id="canvasFoot" style="width:292px;">
					<table width="266" cellpadding="0" cellspacing="0" border="0">
						<tr valign="top">
							<td align="center" colspan="2"><div id="SubmitCanvas">
								<?php 	
									if(isset($CanvasWasSubmitted)) { echo '<input type="button" class="canvasButtons" value="Reset Canvas To Design Another" style="padding:3px;font-size:11px;width:250px;" onClick="javascript:resetMyCanvas(this);">'; } 
									else { echo '<input type="button" class="canvasButtons" value="Done With Canvas? Submit it!" style="padding:3px;font-size:11px;width:250px;" onClick="submitMyCanvas(this);">'; } 
								?>
							</div></td>
						<tr valign="top">
							<td align="center"><div id="SaveCanvas" style="padding:3px;padding-top:6px;"><?php if(!isset($CanvasWasSubmitted)) { ?><input type="button" class="canvasButtons" value="Save Canvas"  style="padding:2px;font-size:10px;font-weight:normal;" onClick="javascript:saveMyCanvas(this);"><?php } ?></div></td>
							<td align="center"><div id="ResetCanvas" style="padding:3px;padding-top:6px;"><?php if(!isset($CanvasWasSubmitted)) { ?><input type="button" class="canvasButtons" value="Reset Canvas" style="padding:2px;font-size:10px;font-weight:normal;" onClick="javascript:resetMyCanvas(this);"><?php } ?></div></td>
						</tr>
							<td align="center" colspan="2"><div id="CanvasFooter">
							<?php 
								if(isset($CanvasWasSubmitted)) { echo '<div class="CanvasFooter">Your <a style="text-decoration:none;color:#266899;font-weight:bold;"><font style="color:#000000;text-decoration:none;">Open</font>Canvas</a> has been submitted, we will be contacting you shortly via email to discuss its production in detail. Feel free to reset the canvas to create a new one.</div>'; } 
								else { echo '<div style="cursor:help;" onMouseOver="javascript:CFTPanelSelectIcon=\'canvas\';toggleCFTPanel(\'visible\');" onMouseOut="javascript:CFTPanelSelectIcon=\'canvas\';toggleCFTPanel(\'hidden\');" class="CanvasFooter">Designs saved to your <a onMouseOver="javascript:CFTPanelSelectIcon=\'canvas\';toggleCFTPanel(\'visible\');" onMouseOut="javascript:CFTPanelSelectIcon=\'canvas\';toggleCFTPanel(\'hidden\');" class="showgunCAN" style="font-weight:bold;text-decoration:none;color:#266899;cursor:help;"><font style="color:#000000;text-decoration:none;">Open</font>Canvas</a> will act as catalysts in the creation of a functional website worthy of representing your business and domain.</div>'; }
							?>
							</div></td>
						</tr>
					</table>
				</div>
				</div>
			</div>
			</form>
		</td>
	</tr>
</table>

































<table width="920" cellpadding="0" cellspacing="0" border="0" class="nobord">
	<tr class="nobord" height="35">
		<td class="nobord"><div style="width:670px;height:35px;overflow:hidden;clip:rect(0px,670px,35px,0px);"><img src="/web_design_imagery/spacer.gif" width="670" height="35" border="0"></div></td>
		<td class="nobord"><div style="width:30px;height:35px;overflow:hidden;clip:rect(0px,30px,35px,0px);"><img src="/web_design_imagery/spacer.gif" width="30" height="35" border="0"></div></td>
		<td class="nobord"><div style="width:220px;height:35px;overflow:hidden;clip:rect(0px,220px,35px,0px);"><img src="/web_design_imagery/spacer.gif" width="220" height="35" border="0"></div></td>
	</tr>
	<tr class="nobord">
		<td class="nobord" align="left" valign="top" width="670">
			<div class="EOFSectionTitle" style="margin-left:0;">Designing A Website Has Never Been So Fun, Or Easy!</div>
			<div class="EOFSectionIntroduction" style="margin-left:0;margin-right:20;">
				Website design can be a tedious and highly involved creative and technical procedure, which is why we've engineered our unique web design selection process, to interactively facilitate the design and development of your custom website. With <a style="text-decoration:none;color:#266899;font-weight:bold;"><font style="color:#000000;text-decoration:none;">Open</font>Canvas</a>, acquiring a professionally designed business website is as quick, easy and painless as placing an ad in your local newspaper.
				<!--Website design can be a tedious and highly involved creative and technical procedure, which is why we've engineered an advanced time-saving platform: . The platform allows for an interactive design experience for both client and technical producer, helping keep the website design project on point, on time as well as on budget.--> 
				<!--Give it a try, browse through our website designs, add the ones you like to your <span onClick="if(FavoriteContains.length > 0) { loadCategory('favorites',0); }" onMouseOver="javascript:CFTPanelSelectIcon='favorites';toggleCFTPanel('visible');" onMouseOut="javascript:CFTPanelSelectIcon='favorites';toggleCFTPanel('hidden');"><a class="showgunFAV" style="cursor:pointer;color:#E4BE4A;text-decoration:none;">favorites</a></span>, those most to your liking to the <span onMouseOver="javascript:CFTPanelSelectIcon='canvas';toggleCFTPanel('visible');" onMouseOut="javascript:CFTPanelSelectIcon='canvas';toggleCFTPanel('hidden');"><a class="showgunCAN" style="cursor:help;text-decoration:none;">canvas</a></span>, and as for removing designs, just use the <span onClick="if(TrashContains.length > 0) { loadCategory('trash',0); }" onMouseOver="javascript:CFTPanelSelectIcon='trash';toggleCFTPanel('visible');" onMouseOut="javascript:CFTPanelSelectIcon='trash';toggleCFTPanel('hidden');"><a class="showgunTRA" style="cursor:pointer;text-decoration:none;color:#BF0000;">trash</a></span>.-->
				<!--Give it a try, browse through our website designs, <a href="/wikipedia.htm?st=Drag_and_drop" class="WikiBoard" target="WIKI">drag-and-drop</a> the ones you like to your <span onClick="if(FavoriteContains.length > 0) { loadCategory('favorites',0); }" onMouseOver="javascript:CFTPanelSelectIcon='favorites';toggleCFTPanel('visible');" onMouseOut="javascript:CFTPanelSelectIcon='favorites';toggleCFTPanel('hidden');"><a class="showgunFAV" style="cursor:pointer;color:#E4BE4A;">favorites</a></span>. As for the designs most to your liking, simply click 'Add to Canvas' or just drag-and-drop it to one of the five slots available on your <span onMouseOver="javascript:CFTPanelSelectIcon='canvas';toggleCFTPanel('visible');" onMouseOut="javascript:CFTPanelSelectIcon='canvas';toggleCFTPanel('hidden');"><a class="showgunCAN" style="color:#266899;cursor:help;">canvas</a></span>. If you change your mind, just remove designs from your canvas by dropping them into the <span onClick="if(TrashContains.length > 0) { loadCategory('trash',0); }" onMouseOver="javascript:CFTPanelSelectIcon='trash';toggleCFTPanel('visible');" onMouseOut="javascript:CFTPanelSelectIcon='trash';toggleCFTPanel('hidden');"><a class="showgunTRA" style="cursor:pointer;">trash</a></span> slot, denoted by a red X, which will consequently remove that design from favorites as well.-->
				<!--These technical resources will help you understand the nature, inner-workings and basic principles encompassing the art of designing custom graphical user interfaces and developing proprietary platforms. You'll find links for the most influential technical resources we know, such as: <a href="http://www.stackoverflow.com/" title="StackOverflow - Website Programmer and Internet Developer Q&A" target="SO">StackOverflow</a>, <a href="http://www.wdvl.com/" title="WDVL - Web Developers Virtual Library" target="WDVL">WDVL</a>, <a href="http://www.w3c.org/" title="W3C - World Wide Web Consortium" target="W3C">W3C</a>, <a href="http://www.internet.com/" title="Internet.com - One of the Original Website Development Technical Resouces" target="InternetCOM">Internet.com</a> and <a href="http://www.dmoz.com/" title="DMOZ - Open Directory Project [Human-Edited Internet Directory]" target="DMOZ">DMOZ</a> and many more. We focus our energy and skill in always providing you resources and products that are most relative to the technical information you seek. Be it a simple question or and in-depth analysis of the subject at-hand, you'll always find relative information on our websites, no clutter, and certainly no junk.-->
			</div>
			<?php /* $ServerName comes from interface_design_templater.php */ ?>
			<div class="SectionIntroduction">
					<form name="OpenCanvas-Website-Design-Package">
				<div id="Choose-A-Website-Design-Package" class="SectionTitle" style="margin-bottom:0;">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<?php 
					$onesel = '';
					$twosel = '';
					$threesel = '';
					if ($elOCv == '3') { $threesel = 'checked'; }
					else if ($elOCv == '2') { $twosel = 'checked'; }
					else if ($elOCv == '1') { $onesel = 'checked'; }

#-WITH PRICE
#							<div style="position:relative;top:-20px;left:-40px;background:url(/website_design_template_images/open-canvas-website-design-price.png) top left no-repeat;width:103px;height:73px" title="OpenCanvas, an Interactive Website Design Experience, Starting at just $529.75">
#								<div id="Open-Canvas-Website-Starting-At">STARTING AT</div>
#								<div id="Low-Priced-Budget-Open-Canvas-Web-Design">
#									<div class="Internet-Development-Dollar-Sign">$</div><div class="Internet-Development-Price">529</div><div class="Internet-Development-Cents">75</div>
#								</div>
#							</div>
#-NO PRICE
#							<div style="position:relative;top:-20px;left:-40px;background:url(/website_design_template_images/open-canvas-website-design-price.png) top left no-repeat;width:103px;height:73px" title="OpenCanvas, an Interactive Website Design Experience, Contact us for pricing.">
#								<div id="Open-Canvas-Website-Starting-At">FOR PRICING</div>
#								<div id="Low-Priced-Budget-Open-Canvas-Web-Design">
#									<div class="Internet-Development-Dollar-Sign"></div><div class="Internet-Development-Price">CALL</div><div class="Internet-Development-Cents"></div>
#								</div>
#							</div>

					?>
					<tr valign="middle">
						<td align="center" class="Open-Canvas-Interactive-Web-Design-Logo"><div style="background:url(/website_design_template_images/open-canvas-interactive-website-design-experience.png) top left no-repeat;width:95px;height:96px" title="OpenCanvas, an Interactive Website Design Experience"><img src="/web_design_imagery/spacer.gif" width="95" height="96" border="0" alt="OpenCanvas, an Interactive Website Design Experience"></div></td>
						<td class="web-design-selector">
							<table>
								<tr><td class="web-design-selector" style="padding-bottom:8px;"><div onClick="changeTheCanvas('OCv1');"><input type="radio" name="Web-Design-Package" value="OCv1" onClick="changeTheCanvas(this.value);" <?php echo $onesel; ?> ><span class="Web-Programming-And-Development">OpenCanvas Xpress (Express Website Package)</span></div></td></tr>
								<tr><td class="web-design-selector"><div onClick="changeTheCanvas('OCv2');"><input type="radio" name="Web-Design-Package" value="OCv2"<?php echo $twosel; ?>><span class="Web-Programming-And-Development">OpenCanvas OCv2 (Business Website Package)</span></div></td></tr>
								<tr><td class="web-design-selector" style="padding-top:8px;"><div onClick="changeTheCanvas('OCv3');"><input type="radio" name="Web-Design-Package" value="OCv3" <?php echo $threesel; ?>><span class="Web-Programming-And-Development">OpenCanvas OCv3 (Advanced Website Package)</span></div></td></tr>
							</table>
						</td>
						<td align="left">
							<div style="position:relative;top:-20px;padding-top:5px;left:-40px;background:url(/website_design_template_images/open-canvas-website-design-price.png) top left no-repeat;width:103px;height:73px" title="OpenCanvas, an Interactive Website Design Experience, Starting at just $529.75">
								<div id="Open-Canvas-Website-Starting-At">STARTING AT</div>
								<div id="Low-Priced-Budget-Open-Canvas-Web-Design">
									<div class="Internet-Development-Dollar-Sign">$</div><div class="Internet-Development-Price">1,290</div><div class="Internet-Development-Cents">75</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
				</div>			
					</form>
			</div>
<style>
.Web-Design-Wrapper { position:relative; padding:32px 0 0 0; margin-left: 7px; width:616px; top:2px; left:0; }
.Website-Design-Warper { position:relative; padding:0; width:616px; z-index:1; }
.productTabs {
    background-image: url("/website_design_template_images/dotted-tableback.gif");
    background-repeat: repeat-x;
}
.ptabs div { text-align:center; padding-bottom:6px; }
.ptabs {
	font-size:12px;
	font-family:Tahoma, Arial, Helvetica; 
}
.ptabs:hover {
	font-weight:600;
}
#OpenCanvas-Custom-Web-Design-Overview {
	width:111px;
	color:#266899;
}
#OpenCanvas-Custom-Web-Design-Works{
	width:101px;
	color:#266899;
}
#OpenCanvas-Custom-Website-Design-Features {
	width:71px;
	color:#266899;
}
#Compare-OpenCanvas-Custom-Web-Design-Packages {
	width:126px;
	color:#266899;
}

#OpenCanvas-Custom-Web-Design-Overview:hover, #OpenCanvas-Custom-Web-Design-Works:hover, #OpenCanvas-Custom-Website-Design-Features:hover, #Compare-OpenCanvas-Custom-Web-Design-Packages:hover {
	color:#CC0000;
}

#OpenCanvas-Custom-Web-Design-Overview-Tab, #OpenCanvas-Custom-Web-Design-Works-Tab, #OpenCanvas-Custom-Website-Design-Features-Tab, #Compare-OpenCanvas-Custom-Web-Design-Packages-Tab {
	position:relative;
	top:0;
	left:0;
	border-bottom:#FFF 1px solid;
}



.Web-Design-Features, .Web-Design-Freebies {
	list-style:url(/website_design_template_images/open-canvas-design-arrow.png);
	font-family:Tahoma, Arial, Helvetica;
	font-size:12px;
	font-weight:bold;
	padding:20px;
}


.Web-Design-Freebies {
	padding:0;
	margin:0;
	font-size:11px;
}


.Web-Design-Features ul {
	padding:2px;
	margin:0 0 7px 0;
}
.Web-Design-Features li {
	padding-top:4px;
}
.Website-Design-Service {
	list-style:url(/website_design_template_images/web-design-list-style-line.gif);
	font-family:Tahoma, Arial, Helvetica;
	font-size:12px;
	font-weight:normal;
	margin:0;
}
.Website-Design-Service li {
	padding-top:4px;
	margin:0 0 0 13px;
}
.Website-Development-Extra a, .Technical-Web-Design-Service-Support a {
	text-decoration:underline;
	cursor:help;
}

		.Website-Development-Extras { padding:0 0 2px 0; font-family:Tahoma, Arial, Helvetica; font-weight:bold; font-size:12px; }
		.Website-Development-Extra { padding:6px 0 0 10px; font-family:Tahoma, Arial, Helvetica; cursor:pointer; font-weight:normal; }
		.Website-Development-Extra span { padding:0 0 0 10px; font-size:11px; }

.Website-Development-Extras {
	margin:0 0 30px 0;
	background: #FFFFFF;
	border: 1px solid #266899;
	padding: 10px 10px 18px 10px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
	box-shadow: 0px 1px 3px rgba(0,0,0,0.5);
	-moz-box-shadow: 0px 1px 3px rgba(0,0,0,0.5);
	-webkit-box-shadow: 0px 1px 3px rgba(0,0,0,0.5);
}

.Website-Extras {
	padding:20px 20px 0 20px;
}
.Web-Dev-Extras {
	margin:2px 0 0 0;
	font-weight:bold;
	padding:0 0 6px 6px;
}

.Web-Design-Freebies span {
	padding:0;
	margin:0;
	color:#CB0000
}
.Web-Design-Freebies li {
	padding-bottom:3px;
	font-size:11px;
	cursor:default;
}
.Website-Development-Extra ul {
	padding-bottom:7px;
}
</style>
			<div class="Web-Design-Wrapper">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td>
								<div id="OpenCanvas-Custom-Web-Design-Overview-Tab">
								<table class="productTabs" border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr height="24" valign="bottom">
											<td><img src="/website_design_template_images/dotted-tablesides_left.gif" border="0" height="24" width="10"></td>
											<td class="ptabs"><a href="javascript:WebsiteDesignTab('OpenCanvas-Custom-Web-Design-Overview','OpenCanvas-Website-Design-Package-Overview');" style="text-decoration:none;"><div id="OpenCanvas-Custom-Web-Design-Overview" style="font-weight:bold;color:#000000;">Overview: <?php echo $trueOCv;?></div></a></td>
											<td><img src="/website_design_template_images/dotted-tablesides_right.gif" border="0" height="24" width="10"></td>
										</tr>
									</tbody>
								</table>
								</div>
							</td>
							<td style="padding-left:5px;">
								<div id="OpenCanvas-Custom-Web-Design-Works-Tab">
								<table class="productTabs" border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr height="24" valign="bottom">
											<td><img src="/website_design_template_images/dotted-tablesides_left.gif" border="0" height="24" width="10"></td>
											<td class="ptabs"><a href="javascript:WebsiteDesignTab('OpenCanvas-Custom-Web-Design-Works','How-OpenCanvas-Website-Design-Package-Works');" style="text-decoration:none;"><div id="OpenCanvas-Custom-Web-Design-Works">How It Works</div></a></td>
											<td><img src="/website_design_template_images/dotted-tablesides_right.gif" border="0" height="24" width="10"></td>
										</tr>
									</tbody>
								</table>
								</div>
							</td>
							<td style="padding-left:5px;">
								<div id="OpenCanvas-Custom-Website-Design-Features-Tab">
								<table class="productTabs" border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr height="24" valign="bottom">
											<td><img src="/website_design_template_images/dotted-tablesides_left.gif" border="0" height="24" width="10"></td>
											<td class="ptabs"><a href="javascript:WebsiteDesignTab('OpenCanvas-Custom-Website-Design-Features','OpenCanvas-Website-Design-Package-Features');" style="text-decoration:none;"><div id="OpenCanvas-Custom-Website-Design-Features">Features</div></a></td>
											<td><img src="/website_design_template_images/dotted-tablesides_right.gif" border="0" height="24" width="10"></td>
										</tr>
									</tbody>
								</table>
								</div>
							</td>
							<td style="padding-left:5px;padding-right:4px;">
								<div id="Compare-OpenCanvas-Custom-Web-Design-Packages-Tab">
								<table class="productTabs" border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr height="24" valign="bottom">
											<td><img src="/website_design_template_images/dotted-tablesides_left.gif" border="0" height="24" width="10"></td>
											<td class="ptabs"><a href="javascript:WebsiteDesignTab('Compare-OpenCanvas-Custom-Web-Design-Packages','Compare-Open-Canvas-Web-Design-Packages');" style="text-decoration:none;"><div id="Compare-OpenCanvas-Custom-Web-Design-Packages">Compare Packages</div></a></td>
											<td><img src="/website_design_template_images/dotted-tablesides_right.gif" border="0" height="24" width="10"></td>
										</tr>
									</tbody>
								</table>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="Website-Design-Warper">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody>
						<tr><td style="background:url(/website_design_template_images/web-design-table-top.png) top left no-repeat;" align="center"><div id="dynamic-html-loading-bar" style="height:5px;"><img src="/web_design_imagery/spacer.gif" border="0" height="5" width="1"></div></td></tr>
						<tr><td style="background:url(/website_design_template_images/web-design-table-top.png) top left no-repeat;" align="center"><div id="web-design-topper" style="height:5px;"><img src="/web_design_imagery/spacer.gif" border="0" height="5" width="1"></div></td></tr>
						<tr>
							<td>
								<div id="Website-Design-Warp" style="background:url(/website_design_template_images/web-design-table-spanner.png) top left repeat-y;min-height:135px;">
									<div id="Website-Design-Wrap" style="min-height:130px;background:url(/website_design_template_images/web-design-table-bottom.png) bottom left no-repeat;">
										<div id="Website-Design-Information">
											<div id="OpenCanvas-Website-Design-Package-Overview" style="display:block;padding:20px 35px 20px 35px; line-height:26px; font-size:15px; font-family:Tahoma, Arial, Helvetica; color:#000000;">

												<?php if ($elOCv == '1') { ?>
												<img src="/website_design_template_images/opencanvas-interactive-express-website-design-package.png" width="144" height="141" border="0" align="right" style="margin:10px 25px 0 25px;">
												Our <b>Express Website Package</b> allows you to select the one website design canvas which best illustrates your direction, ideas and vision for the design and development of your new website interface, web-based application or mobile application. Based on this one design canvas, our team of highly skilled creative directors, technical producers and business model architects will work together to custom design interfaces and develop the associated technologies. The one design canvas you choose will serve as the backbone and overall structure and design for your website. If you desire or require changes to the design canvas you select or would like to combine features from more than one design canvas, you might want to look into <a onClick="changeTheCanvas('OCv2');" style="cursor:pointer;">OCv2</a>, our <a onClick="changeTheCanvas('OCv2');" style="cursor:pointer;">Business Website Package</a>. OCv2 allows you to select two(2) designs from which to base your website's design, functionality and features.
												<br><br>Click on any of the tabs above to find out more about this web design package, how the process of interactively designing a website works, as well as other useful information regarding the art of producing a high-quality website.
												<?php } else if ($elOCv == '2') { ?>
												<img src="/website_design_template_images/opencanvas-interactive-business-website-design-package.png" width="144" height="141" border="0" align="right" style="margin:10px 25px 0 25px;">
												The <b>Business Website Package</b> gives you the flexibility of selecting up to two(2) high-quality site design canvases which best illustrate and communicate your creative direction. Business ideas and functional requirements pertaining to the design and development of your new website interface, web-based application or mobile application will be wholly based on the design, function, features and content available on the two design canvases you choose. If you require custom functionality, changes in programming or scripting away from what the two design canvases contain, you might need to select <a onClick="changeTheCanvas('OCv3');" style="cursor:pointer;">OCv3</a>, our <a onClick="changeTheCanvas('OCv3');" style="cursor:pointer;">Advanced Website Package</a>, which allows you to select up to five(5) design canvases as well as more hours for custom design, programming and scripting.
												<br><br>Click on any of the tabs above to find out more about this web design package, how the process of interactively designing a website works, as well as other useful information regarding the art of producing a high-quality website.
												<?php } else if ($elOCv == '3') { ?>
												<img src="/website_design_template_images/opencanvas-interactive-advanced-website-design-package.png" width="144" height="141" border="0" align="right" style="margin:10px 25px 0 25px;">
												Exclusively, the <b>Advanced Website Package</b> can allow for up to five(5) high-quality site design canvases which best illustrate and communicate your creative direction, business ideas and functional requirements pertaining to the design and development of your new website interface, web-based application or mobile application. By combining features, designs, ideas and functionality from all five canvases as the foundation for the project, our team of highly skilled artists, technical producers and advanced business model architects will work in collaboration with you to develope an Internet Marketing platform worthy of the task of representing your company in the World Wide Web's global marketplace.
												<br><br>Click on any of the tabs above to find out more about this web design package, how the process of interactively designing a website works, as well as other useful information regarding the art of producing a high-quality website.
												<?php } ?>

											</div>
											<div id="How-OpenCanvas-Website-Design-Package-Works" style="display:none;"></div>
											<div id="OpenCanvas-Website-Design-Package-Features" style="display:none;padding:2px;position:relative;top:-3px;left:0px;">
												<table border="0" cellpadding="0" cellspacing="0" width="612">
													<tbody>
														<tr><td style="background:url(/website_design_template_images/virtual-private-information-top.png) top left no-repeat;" align="center"><div style="height:5px;"><img src="/web_design_imagery/spacer.gif" border="0" height="5" width="1"></div></td></tr>
														<tr>
															<td>
																<div style="background:url(/website_design_template_images/virtual-private-information-spanner.png) top left repeat-y;min-height:15px;">
																	<div style="min-height:200px;background:url(/website_design_template_images/virtual-private-information-bottom.png) bottom left no-repeat;">

<table>
	<tr valign="top">
		<td width="55%">
			<div style="width:100%;">
				<ul class="Web-Design-Features">
					<li>
						Design Canvas Allotment
						<ul class="Website-Design-Service"><li><?php echo $PackageCanvases; ?></li></ul>
					</li>
					<li>
						Setup & Customization
						<ul class="Website-Design-Service">
							<li><span class="Technical-Web-Design-Service-Support"><a class="Web-Design-Information" title="<?php echo $myCreativeTimeInfo; ?>">Creative Design</a></span>: <?php echo $myCreativeTime; ?> Hours</li>
							<li><span class="Technical-Web-Design-Service-Support"><a class="Web-Design-Information" title="<?php echo $myTechnicalTimeInfo; ?>">Technical</a></span>: <?php echo $myTechnicalTime; ?> Hours</li>
							<li><span class="Technical-Web-Design-Service-Support"><a class="Web-Design-Information" title="<?php echo $myCanvasPersonalizationInfo; ?>">Canvas Personalization</a></span>: <?php echo $myCanvasPersonalizationTime; ?> Hours</li>
						</ul>
					</li>
					<li>
						Project Management
						<ul class="Website-Design-Service"><li><?php echo $ProjectManagement; ?></li></ul>
					</li>
					<li>
						Web Hosting
						<ul class="Website-Design-Service">
							<li><?php echo $DiskSpace; ?></li>
							<li><?php echo $GBTransferMonth; ?></li>
							<li><?php echo $Databases; ?></li>
						</ul>
					</li>
					<li>
						Email Addresses
						<ul class="Website-Design-Service">
							<li><?php echo $EmailAccounts; ?> Email Address Accounts</li>
						</ul>
					</li>
					<li>
						Search Engine Ranking Services
						<ul class="Website-Design-Service">
							<li><a class="Web-Design-Information" title="<?php echo $SEOCOPY; ?>">SEO</a>: <?php echo $SEOService; ?></li>
							<li><a class="Web-Design-Information" title="<?php echo $SEMCOPY; ?>">SEM</a>: <?php echo $SEMService; ?></li>
						</ul>
					</li>
					<li>
						World Class Data Centers (Hosting + DNS)
						<ul class="Website-Design-Service">
							<li>Daily Backups</li>
							<li>Top-of-the-line Routers, Firewalls and Servers</li>
							<li>24/7 Phone & Email Support</li>
							<li>99.99% Up-Time</li>
						</ul>
					</li>
					<li>
						Website Domain Name
						<ul class="Website-Design-Service">
							<li>Domain Name Registration: One(1) Year</li>
						</ul>
					</li>
					<li>
						Website & Data Security
						<ul class="Website-Design-Service">
							<li><?php echo $SSLCertificate; ?></li>
						</ul>
					</li>
				</ul>
			</div>
		</td>
		<td width="45%">
<!--SEM-->
<!--We here at Virtual Private Servers and Networks are keenly and wholly capable of inventing and providing to our clients the most impressive and cost-effective SEM service available on the market today, and we're proud to keep searching for new ways. Anytime we find new methods, we try and propagate those throughout our SEM client websites, keeping in line with our promise to make your site the most visible and most impressive for its market or niche.-->
<!--SSL-->
<!--Yes it costs a bit more for the SSL individually for we must set up the server s well as request the SSL Certificate, all of which takes time and technical know-how, hence the difference in price.-->
<!--FREE SSL Advanced-->
<!--<br><br>SSL, FREE for Advanced Website Package (a $80 value), whilst other website packages must specifically request the addition of SSL to their package.-->
<!--SEM-->
 <!--Your business's name and any other data sets, keywords and tags we agree to target as part of the terms to this service, will also be propagated throughout the Internet, as part of this service.-->
		<form name="Website-Package-AddOns">
		<div class="Website-Extras">
			<div class="Web-Dev-Extras">Website Package Add-Ons</div>
			<div class="Website-Development-Extras">
				<div class="Website-Development-Extra" onClick="javascript:websiteExtras(0);"><input type="radio" name="Website-Design-Package-Extras" id="none" value="none" <?php echo $NOADDON; ?>><span>No Extras: <b>$<span id="PackageStartingPrice" style="margin:0;padding:0;"></span></b></span></div>

<?php if ($elOCv === 1 || $elOCv === 2) { ?>
				<div class="Website-Development-Extra" onClick="javascript:websiteExtras(1);"><input type="radio" name="Website-Design-Package-Extras" id="ssl" value="ssl" <?php echo $SSLSelected; ?>><span>With <a class="Web-Design-Add-Ons" style="cursor:help;" title="<?php echo $SSLCOPY; ?>">SSL</a>: <b>$<span id="PackageWithSSL" style="margin:0;padding:0;"></span></b></span></div>
				<div class="Website-Development-Extra" onClick="javascript:websiteExtras(2);"><input type="radio" name="Website-Design-Package-Extras" id="sem" value="sem" <?php echo $SEMSelected; ?>><span>With <a class="Web-Design-Add-Ons" style="cursor:help;" title="<?php echo $SEMCOPY; ?>">SEM</a>: <b>$<span id="PackageWithSEM" style="margin:0;padding:0;"></span></b></span></div>
				<div class="Website-Development-Extra" onClick="javascript:websiteExtras(3);"><input type="radio" name="Website-Design-Package-Extras" id=sslsem" value="sslsem" <?php echo $SSLSEMSelected; ?>><span>w/SSL & SEM: <b>$<span id="PackageWithSSLSEM" style="margin:0;padding:0;"></span></b></span></div>
<?php } else { ?>
				<div class="Website-Development-Extra" onClick="javascript:websiteExtras(1);"><input type="radio" name="Website-Design-Package-Extras" id="businessconcierge" value="businessconcierge" <?php echo $BUSCONSelected; ?>><span>With <a class="Web-Design-Add-Ons" title="<?php echo $BUSCONCOPY; ?>">Concierge I</a>: <b>$<span id="PackageWithBUSCON" style="margin:0;padding:0;"></span></b></span></div>
				<div class="Website-Development-Extra" onClick="javascript:websiteExtras(2);"><input type="radio" name="Website-Design-Package-Extras" id="personalconcierge" value="personalconcierge" <?php echo $PERCONSelected; ?>><span>With <a class="Web-Design-Add-Ons" title="<?php echo $PERCONCOPY; ?>">Concierge II</a>: <b>$<span id="PackageWithPERCON" style="margin:0;padding:0;"></span></b></span></div>
<?php } ?>
			</div>
			<div class="Web-Dev-Extras">Site Maintenance & Updates</div>
			<div class="Website-Development-Extras">
				<div class="Website-Development-Extra" onClick="javascript:websiteMaintenance(0);"><input type="radio" name="Website-Design-Package-Maintenance" id="none" value="none" <?php echo $NOMAINTENANCE; ?>><span>None</span></div>
				<div class="Website-Development-Extra" onClick="javascript:websiteMaintenance(1);"><input type="radio" name="Website-Design-Package-Maintenance" id="6" value="6months" <?php echo $SIXMONTHMAINTENANCESelected; ?>><span>6 Months: <b>$49.99/month</b></span></div>
				<div class="Website-Development-Extra" onClick="javascript:websiteMaintenance(2);"><input type="radio" name="Website-Design-Package-Maintenance" id="12" value="12months" <?php echo $TWELVEMONTHMAINTENANCESelected; ?>><span>12 Months: <b>$47.49/month</b></span></div>
			</div>

			<div class="Web-Dev-Extras"><span style="color:#266899;"><span style="color:#000;">Open</span>Canvas</span> Bonuses</div>
			<div class="Website-Development-Extras" style="padding:15px 15px 5px 20px;">
				<div class="Website-Development-Extra">
					<ul class="Web-Design-Freebies">
						<li>
							<span>FREE!</span> Google Webmaster Tools
							<ul class="Website-Design-Service"><li>Provides detailed reports about your pages' visibility on Google</li></ul>
						</li>
						<li>
							<span>FREE!</span> Domain Name
							<ul class="Website-Design-Service"><li>Free domain name registration for all our web design packages</li></ul>
						</li>
						<li>
							<span>FREE!</span> Web Hosting
							<ul class="Website-Design-Service"><li>Free year of website hosting for all our web design packages</li></ul>
						</li>
						<li>
							<span>FREE!</span> Search Engine Submission
							<ul class="Website-Design-Service"><li>We submit your website to the 20 most popular search enignes</li></ul>
						</li>
						<li>
							<span>FREE!</span> Advertisement Credits
							<ul class="Website-Design-Service">
								<li><a href="http://www.bing.com/explore/rewards" target="Free-Bing-Ads-Credit-From-Microsoft" title="FREE Bing Ads Credits From Microsoft">Bing Ads Credit</a></li>
								<li><a href="http://www.facebook.com/help/243807179069441/" target="Free-Facebook-Ad-Credit" title="FREE Facebook Ad Credits, a value of $50">Facebook&reg; Ad Credit</a>: $50</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		</form>
		</td>
	</tr>
</table>
																	
																	</div>
															</td>
														</tr>
													</table>
											</div>
											<div id="Compare-Open-Canvas-Web-Design-Packages" style="display:none;padding:2px;position:relative;top:-3px;left:0px;">
												<table border="0" cellpadding="0" cellspacing="0" width="612">
													<tbody>
														<tr><td style="background:url(/website_design_template_images/virtual-private-information-top.png) top left no-repeat;" align="center"><div style="height:5px;"><img src="/web_design_imagery/spacer.gif" border="0" height="5" width="1"></div></td></tr>
														<tr>
															<td>
																<div style="background:url(/website_design_template_images/virtual-private-information-spanner.png) top left repeat-y;min-height:15px;">
																	<div style="min-height:200px;background:url(/website_design_template_images/virtual-private-information-bottom.png) bottom left no-repeat;">

											


<style>
.compare tr{
	border:#EFEFEF 1px solid;
}
.compare td{
	padding:5px 7px 5px 7px;
}
.compare a:visited {
	color:#266899;
}
.compare table {
	background:#FFFFFF;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	box-shadow: 0px 1px 3px rgba(0,0,0,0.17);
	-moz-box-shadow: 0px 1px 3px rgba(0,0,0,0.17);
	-webkit-box-shadow: 0px 1px 3px rgba(0,0,0,0.17);
}
.included {
	background:url(/website_design_template_images/included.png) top left no-repeat;
	width:10px;
	height:9px;
	cursor:help;
}
.leftbord {
	border-left:#EFEFEF 1px solid;
}
.breakerrow {
	height:30px;
	font-weight:bold;
	background:#EFEFEF;
}
.Web-Design-Information, .Web-Design-Add-Ons {
	cursor:help;
}
</style>
<div class="compare" style="padding:20px;font-family:Tahoma, Arial, Helvetica;font-size:12px;">
<table style="border-collapse: inherit;" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr style="border:none;height:40px;">
<td style="width:40%;"></td>
<td style="text-align: center;"><strong>eXpress</strong></td>
<td style="text-align: center;"><strong>Business</strong></td>
<td style="text-align: center;"><strong>Advanced</strong></td>
</tr>
<tr style="height:30px;">
<td>Package Price, No Monthly Fees.</td><td class="leftbord" id="ComparePriceOpenCanvasExpress">&nbsp;</td><td class="leftbord" id="ComparePriceOpenCanvasBusiness">&nbsp;</td><td class="leftbord" id="ComparePriceOpenCanvasAdvanced">&nbsp;</td>
</tr>
<tr class="breakerrow">
<td colspan="4">OpenCanvas Interactive Design Specifics</td></td>
</tr>
<tr>
<td>Canvas Allotment</td><td class="leftbord">1</td><td class="leftbord">Up to 2</td><td class="leftbord">Up to 5</td>
</tr>
<tr>
<td><a class="Web-Design-Information" title="<?php echo $myCreativeTimeInfo; ?>">Creative Design</a></td><td class="leftbord">4 Hours</td><td class="leftbord">8 Hours</td><td class="leftbord">16 Hours</td>
</tr>
<tr>
<td><a class="Web-Design-Information" title="<?php echo $myTechnicalTimeInfo; ?>">Technical Production</a></td><td class="leftbord">4 Hours</td><td class="leftbord">8 Hours</td><td class="leftbord">16 Hours</td>
</tr>
<tr>
<td><a class="Web-Design-Information" title="<?php echo $myCanvasPersonalizationInfo; ?>">Canvas Personalization</a></td><td class="leftbord">8 Hours</td><td class="leftbord">16 Hours</td><td class="leftbord">24 Hours</td>
</tr>
<tr>
<td>Total Development Time</td><td class="leftbord">16 Hours</td><td class="leftbord">32 Hours</td><td class="leftbord">48 Hours</td>
</tr>
<tr class="breakerrow">
<td colspan="4">Web Hosting</td></td>
</tr>
<tr>
<td>Term Length</td><td class="leftbord">1 Year</td><td class="leftbord">1 Year</td><td class="leftbord">1 Year</td>
</tr>
<tr>
<td>Disk Space</td><td class="leftbord">5 GB</td><td class="leftbord">5 GB</td><td class="leftbord">10 GB</td>
</tr>
<tr>
<td>Monthly Data Transfer</td><td class="leftbord">25 GB</td><td class="leftbord">25 GB</td><td class="leftbord">50 GB</td>
</tr>
<tr>
<td>FTP Users</td><td class="leftbord">1</td><td class="leftbord">1</td><td class="leftbord">10</td>
</tr>
<tr>
<td>SSH Access (Secure Shell)</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>FTP over SSL (FTPS)</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Raw Access Logs</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Site Statistics</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Malware Scanner</td><td class="leftbord">--</td><td class="leftbord">--</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>SSL Certificate</td><td class="leftbord" id="ComparePriceSSL1"></td><td class="leftbord" id="ComparePriceSSL2"></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>24/7 Phone/Email Support</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Cron Jobs</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>File Manager</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr class="breakerrow">
<td colspan="4">Email Accounts</td></td>
</tr>
<tr>
<td>Number of Addresses</td><td class="leftbord">1</td><td class="leftbord">3</td><td class="leftbord">10</td>
</tr>
<tr>
<td>Total Email Storage</td><td class="leftbord">100 MB</td><td class="leftbord">300 MB</td><td class="leftbord">1 GB</td>
</tr>
<tr>
<td>Web-Based Email Client</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>"Light" Web-Based Email Client w/PDA</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Forwarding</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Auto-Responder</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Catch-All Email Address</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Fraud, Virus &amp; Spam Protection</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Sender ID</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Email privacy &amp; protection with 256-Bit Encryption</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr class="breakerrow">
<td colspan="4">Databases</td>
</tr>
<tr>
<td>MySQL</td><td class="leftbord">1 x 1 GB</td><td class="leftbord">5 x 1 GB</td><td class="leftbord">25 x 1 GB</td>
</tr>
<tr>
<td>Database Backup/Restore</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Direct Database Access</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr class="breakerrow">
<td colspan="4">Domains</td>
</tr>
<tr>
<td>Domain Name Registration</span></td><td class="leftbord">1 Year</td><td class="leftbord">1 Year</td><td class="leftbord">1 Year</td>
</tr>
<tr class="breakerrow">
<td colspan="4">Domain Name Management <span class="setupfees">(Setup Fees May Apply)</span></td>
</tr>
<tr>
<td>DNS Management</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Access without "www."</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>External Domains</td><td class="leftbord">Unlimited</td><td class="leftbord">Unlimited</td><td class="leftbord">Unlimited</td>
</tr>
<tr>
<td>Subdomains</td><td class="leftbord">5</td><td class="leftbord">25</td><td class="leftbord">100</td>
</tr>
<tr>
<td>Multiple Web Sites</td><td class="leftbord">--</td><td class="leftbord">Unlimited</td><td class="leftbord">Unlimited</td>
</tr>
<tr>
<td>Alias Domains</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr class="breakerrow">
<td colspan="4">Extra Features</td>
</tr>
<tr>
<td><a href="http://www.bing.com/explore/rewards" target="Free-Bing-Ads-Credit-From-Microsoft" title="FREE Bing Ads Credits From Microsoft">Bing Ads Credit</a></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td><a href="http://www.facebook.com/help/243807179069441/" target="Free-Facebook-Ad-Credit" title="FREE Facebook Ad Credits">Facebook&reg; Credit</a></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td><a href="http://www.fotolia.com/Info/Credits" target="Free-Fotolia-Credits" title="FREE Fotolia Credits">Fotolia&reg; Photo Credit</a></td><td class="leftbord">10 credits</td><td class="leftbord">10 credits</td><td class="leftbord">10 credits</td>
</tr>
<tr class="breakerrow">
<td colspan="4">Languages (Programming)</td>
</tr>
<tr>
<td>PHP5</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Custom PHP.ini/PHP5.ini</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Perl w/FASTCGI</td><td class="leftbord">--</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Python CGI</td><td class="leftbord">--</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Ruby CGI</td><td class="leftbord">--</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Ruby on Rails w/FASTCGI</td><td class="leftbord">--</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr class="breakerrow">
<td colspan="4">OpenCanvas Project Management</td>
</tr>
<tr>
<td>Email</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Online Chat</td><td class="leftbord">---</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Phone</td><td class="leftbord">---</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Remote Desktop</td><td class="leftbord">---</td><td class="leftbord">---</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr class="breakerrow">
<td colspan="4">Other Features</td>
</tr>
<tr>
<td>Admin Tools</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Advertising</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>ImageMagick</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>jQuery</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>OpenDB</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Social Networking</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr class="breakerrow">
<td colspan="4">Exclusive Technical Services by Virtual Private</td>
</tr>
<tr>
<td><a class="Web-Design-Add-Ons" title="<?php echo $BUSCONCOPY; ?>">Concierge I (Business)</a></td><td class="leftbord">---</td><td class="leftbord">---</td><td class="leftbord" id="CompareBUSCON"></td>
</tr>
<tr>
<td><a class="Web-Design-Add-Ons" title="<?php echo $PERCONCOPY; ?>">Concierge II (Personal)</a></td><td class="leftbord">---</td><td class="leftbord">---</td><td class="leftbord" id="ComparePERCON"></td>
</tr>
<tr class="breakerrow">
<td colspan="4">Virtual Content Management Systems (CMS)</td>
</tr>
<tr>
<td>WordPress</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>osCommerce</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>ZenCart</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Drupal</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Joomla!&reg;</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
<tr>
<td>Mambo</td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td><td class="leftbord"><div class="included" title="Included in OpenCanvas Website Design Package">&nbsp;</div></td>
</tr>
</tbody></table>
</div>




											

																	</div>
															</td>
														</tr>
													</table>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="interface-design-linear" id="HideLinear" style="width:640px;"><img src="/web_design_imagery/spacer.gif" width="640" height="20" border="0"></div>
			<div class="EOFSectionTitle">Interactive Website Design for Advanced Business Clients</div>
			<div class="EOFSectionIntroduction">
				<a style="text-decoration:none;color:#266899;font-weight:bold;"><font style="color:#000000;text-decoration:none;">Open</font>Canvas</a> is an interactive web design and development creative communication platform revolving around our collection of over 14,000 professionally designed and uniquely engineered website designs. An <a style="text-decoration:none;color:#266899;font-weight:bold;"><font style="color:#000000;text-decoration:none;">Open</font>Canvas</a> can consist of a single design canvas or a customized website with design, interfacing and functionality from up to five(5) seperate design canvases. Regardless of your tastes or ideas, our mission is to create a uniquely seductive website to capture the undivided attention of your intended audience. For, in the interactive marketing and virtual advertising business world, fascinating a casual Internet user is key in turning a casual website visitor into a paying customer, a return visitor or a dignified source for advertisement revenue.<br><br>
				Our state-of-the-art website designs and high-quality flash templates are some of the most impressive marketing platforms available on the Internet today. Not only do our website design canvases present themselves in a professionally creative manner, but are also engineered from the core to give your business the upper-hand when it comes to marketing your products or services to the tens of millions of users on the Internet. Combine that with over two decades of Information Technology expertise by our beloved developers and designers, and you're assured to come away with an advanced technological platform fully capable of being marketed into a highly successful internet venture.<br><br>
				We offer three(3) website design service packages to choose from: Express, Business and Advanced. Select the package that best suits your business needs, creative ideas, content needs and most of all, your budget. Regardless of the package you select, you can rest assured we will only provide you with skillful technology development and the most advanced interactive design, nothing less.
			</div>
<!--
			<div class="interface-design-linear" style="width:640px;"><img src="/web_design_imagery/spacer.gif" width="640" height="20" border="0"></div>
			<div class="EOFSectionTitle">FREE Website Hosting for One Year for Web Design Customers</div>
			<div class="EOFSectionIntroduction">
				Here at <a style="text-decoration:none;color:#266899;font-weight:bold;"><font style="color:#000000;text-decoration:none;">Virtual</font>Private</a> Servers and Networks, VPS-NET for short, we have always and will continue to provide you with the best website designs, technical support and Internet development services, guaranteed! Our promise is simple: Our highly skilled staff will have you promoting your business services and closing online sales on the world-wide-web expeditiously, cost-effectively, expertly and with an unmitigated technical and creative advantage over the competition.<br><br>
				We are so confident in our products and services, we will give you FREE website hosting for one(1) year with the purchase and customization of any of our premium website design packages. Where other companies will nickle-and-dime you to the ground, we on the other hand, let you buy and own your own website at a fraction of the cost other companies charge for websites of questionable quality and extremely limited functionality and flexibility. So, if you're here for the FREE hosting, we'd like to believe you will stay for the quality of our technology development, and the overly competitive pricing behind our wide-range of specialized expert technical services.<br><br>FREE website hosting is a limited time offer, and is only available for customers using <a style="text-decoration:none;color:#266899;font-weight:bold;"><font style="color:#000000;text-decoration:none;">Open</font>Canvas</a> to interactively choose and purchase a website design. FREE web hosting has a value of over $80, our way of saying thank you for trying out our Website Design, Internet Development and Technology Engineering services.
			</div>
-->
		</td>
		<td class="nobord" width="30"><div style="width:30px;height:1px;overflow:hidden;clip:rect(0px,30px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="30" height="1" border="0"></div></td>
		<td class="nobord" valign="top" align="center" width="220">
			<!--AskAnExpert-->
			<?php /* require_once($HTTPRoot.'AAE.php' ); */ ?>

			<div id="AD3" style="<?php echo $Advertisement3x1style; ?>"><?php echo $Advertisement3x1; ?></div>
			<div class="advertisement" style="text-align:right;width:<?php echo $Advertisement3x1w; ?>px;padding-top:2px;height:10px;"><?php echo $Advertisement3x1title; ?></div>
			<div id="AD3x1spacer" style="width:<?php echo $Advertisement3x1spacerW; ?>px;height:<?php echo $Advertisement3x1spacerH; ?>px;overflow:hidden;clip:rect(0px,<?php echo $Advertisement3x1spacerW; ?>px,<?php echo $Advertisement3x1spacerH; ?>px,0px);"><img src="/web_design_imagery/spacer.gif" width="<?php echo $Advertisement3x1spacerW; ?>" height="<?php echo $Advertisement3x1spacerH; ?>" border="0"></div>

			<div class="panelBarWIKItop" style="padding-left:2px;text-align:left;"><strong><span title="OpenCanvas, an Interactive Web Design Experience by Virtual Private Servers and Networks, VPS-NET for short, where technology and creativity coalesce to deliver the most vibrant and stunning website designs on the Internet, all in a cost-effective manner." style="color:#266899;cursor:help;"><span style="color:#000;">Open</span>Canvas</span> Website Categories</strong></div>
			<div id="Select-Your-Business-Website-Design" style="background:url(/website_design_template_images/select-your-business-website-design-panel-top.png) no-repeat;padding-top:13px;">
				<div id="Preview-Interactive-Web-Designs" style="background:url(/website_design_template_images/select-your-business-website-design-panel-spanner.png) repeat-y;">
					<div id="Professional-Web-Design-Templates" style="background:url(/website_design_template_images/select-your-business-website-design-panel-bottom.png) no-repeat bottom left;">
						<table width="220" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr><td height="20" align="left">
							<div style="max-height:400px;overflow:auto;max-width:212px;">
							<ul id="Web-Design-Class-Listing">
							<?php 
							$ccatz = 0;
							shuffle($categories);
							foreach ( $categories as $category ) { 
								$ccatz++;
								if ($ccatz < 14) {
									if ($ccatz % 2 == 0) { $myweb = 'website'; $mywebT = 'Website'; } /*even*/
									else { $myweb = 'web'; $mywebT = 'Web'; } /*odd*/
									echo '<li><a href="?'.$myweb.'-design-category='.$category->CatName.'" class="'.$mywebT.'-Design-Class" title="OpenCanvas '.$mywebT.' Design Category: '.$category->CatName.'">'.$category->CatName.'</a></li>'; 
								}
							} 
							?>
							</ul>
							</div></td></tr>
						</table>
					</div>
				</div>
			</div>

			<div class="advertisement" style="text-align:right;width:200px;height:10px;padding-top:3px;padding-right:5px;"><b><span title="OpenCanvas, an Interactive Web Design Experience by Virtual Private Servers and Networks, VPS-NET for short, where technology and creativity coalesce to deliver the most vibrant and stunning website designs on the Internet, all in a cost-effective manner." style="color:#266899;cursor:help;"><span style="color:#000;">Open</span>Canvas</span> Website Design Categories</div>

			<div id="AD3s2x1spacer" style="width:<?php echo $Advertisement3s2x1spacerW; ?>px;height:<?php echo $Advertisement3s2x1spacerH; ?>px;overflow:hidden;clip:rect(0px,<?php echo $Advertisement3s2x1spacerW; ?>px,<?php echo $Advertisement3s2x1spacerH; ?>px,0px);"><img src="/web_design_imagery/spacer.gif" width="<?php echo $Advertisement3s2x1spacerW; ?>" height="<?php echo $Advertisement3s2x1spacerH; ?>" border="0"></div>
			<div id="AD3" style="<?php echo $Advertisement3s2x1style; ?>margin:0;"><?php echo $Advertisement3s2x1; ?></div>
			<div class="advertisement" style="text-align:right;width:<?php echo $Advertisement3s2x1w; ?>px;padding-top:2px;height:10px;"><?php echo $Advertisement3s2x1title; ?></div>
		</td>
	</tr>
</table>


<!--
<div class="hzdm" style="width:585px;height:20px;overflow:hidden;clip:rect(0px,585px,20px,0px);"><img src="/web_design_imagery/spacer.gif" width="585" height="20" border="0"></div>
-->



<div class="interface-design-linear" style="width:920px;"><img src="/web_design_imagery/spacer.gif" width="920" height="20" border="0"></div>







<table width="920" cellpadding="0" cellspacing="0" border="0" class="nobord">
	<tr><td class="nobord" align="center" style="padding-top:10px;"><div id="AD5" style="<?php echo $Advertisement5x1style; ?>"><?php echo $Advertisement5x1; ?></div><div class="advertisement" style="width:<?php echo $Advertisement5x1w; ?>px;height:10px;padding-top:2px;"><?php echo $Advertisement5x1title; ?></div></td></tr><tr><td class="nobord" align="center" style="padding-top:50px;"><div class="FooterSponsorInfo"><a href="<?php echo $sectionLINK; ?>" title="<?php echo $bgSpacerALT; ?>" style="color:#266899;">OpenCanvas</a> is made possible by the following content and service providers:</div></td></tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="FooterSponsorBar">
	<tr class="nobord"><td width="50%" class="nobord"><div class="HTMLoNocont" style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td><td align="center" class="nobord"><div id="AD6-F1" class="FooterSponsorItem" style="<?php echo $Advertisement6x1style; ?>"><?php echo $Advertisement6x1; ?></div></td><td align="center" class="nobord"><div id="AD6-F2" class="FooterSponsorItem" style="<?php echo $Advertisement6x2style; ?>"><?php echo $Advertisement6x2; ?></div></td><td align="center" class="nobord"><div id="AD6-F3" class="FooterSponsorItem" style="<?php echo $Advertisement6x3style; ?>"><?php echo $Advertisement6x3; ?></div></td><td align="center" class="nobord"><div id="AD6-F4" class="FooterSponsorItem" style="<?php echo $Advertisement6x4style; ?>"><?php echo $Advertisement6x4; ?></td><td align="center" class="nobord"><div id="AD6-F5" class="FooterSponsorItem" style="width:160px;height:105px;"><a href="http://www.wikimedia.org/" title="Wikimedia - Operates Some of the Largest Collaboratively Edited Reference Projects" target="Wikimedia" style="color:#000000;"><div style="padding-bottom:12px;"><img src="/web_design_imagery/TechnicalResources_Wikimedia.gif" width="116" height="36" border="0" alt="Wikimedia - Operates Some of the Largest Collaboratively Edited Reference Projects"></div>Referencing</a></div></td><td width="50%" class="nobord"><div class="HTMLoNocont" style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
</table>
<table width="920" cellpadding="0" cellspacing="0" border="0">
	<tr><td width="50%"><div class="HTMLoNocont" style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td><td align="center"><div class="FooterLogo">&copy; 2000 to <?php echo $year;?> Virtual Private - <a rel="/Contact-Website-Design-Internet-Development-Experts/?s=&amp;ss=" title="Questions about web design, website templates, custom design, intuitive website design, website package or any other information technology related topic? Contact our friendly and knowledgable staff." onclick="javascript:runFancyFrame(this);" style="color:#266899;cursor:pointer;">Contact</a><br><a href="http://www.vps-net.com/" title="Site is copyright Virtual Private Servers and Networks [VPS-NET]" style="color:#000000;"><img src="/web_design_imagery/Virtual_Private_footer_logo.gif" width="175" height="37" border="0" alt="Site is copyright Virtual Private Servers and Networks [VPS-NET]"></a></div></td> <td width="50%"><div class="HTMLoNocont" style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td></tr>
</table>
</div>
<!--start DD layers-->
</center>
</div>
<div class="hidden" id="TrashContents"></div>
<div class="hidden" id="FavoriteContents"></div>
<div id="CContextTemplate" style="visibility:hidden;width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);">
<div id="canvasContext">
<ul>
  <li>
    <ul>
      <li><a href="#" title="More Options"><img src="/web_design_imagery/spacer.gif" border="0" width="14" height="14"></a>
		<div id="shadow">
		<ul>
          <li><div class="canvasContextItem" onClick="javascript:addToFavorites();"><table cellpadding="0" cellspacing="0" border="0" class="nobord"><tr><td class="nobord" align="left"><tr><td><div style="width:156px;padding-top:4px;padding-bottom:3px;">&nbsp;&nbsp;Make this design a favorite</div></td><td align="right" valign="top" style="padding-top:3px;padding-right:3px;"><img src="/web_design_imagery/canvasContextIcons_favorites_off.gif" name="ccmFavorites" alt="Make template a favorite" width="14" height="14" border="0"></td></tr></table></div></li>
          <li><div class="canvasContextItem" onClick="javascript:forwardFriend();"><table cellpadding="0" cellspacing="0" border="0" class="nobord"><tr><td class="nobord" align="left"><tr><td><div style="width:156px;padding-top:4px;padding-bottom:3px;">&nbsp;&nbsp;Share this with friends</div></td><td align="right" valign="top" style="padding-top:3px;padding-right:3px;"><img src="/web_design_imagery/canvasContextIcons_email_off.gif" name="ccmFriendForwarder" alt="Share this with friends" width="14" height="14" border="0"></td></tr></table></div></li>
          <li><div class="canvasContextItem" onClick="javascript:canvasQuestion();"><table cellpadding="0" cellspacing="0" border="0" class="nobord"><tr><td class="nobord" align="left"><tr><td><div style="width:156px;padding-top:4px;padding-bottom:3px;">&nbsp;&nbsp;Questions & Feedback</div></td><td align="right" valign="top" style="padding-top:3px;padding-right:3px;"><img src="/web_design_imagery/canvasContextIcons_aae_off.gif" name="ccmQnA" alt="Questions & Feedback" width="14" height="14" border="0"></td></tr></table></div></li>
          <li><div class="canvasContextItem" onClick="javascript:removeFromCanvas();"><table cellpadding="0" cellspacing="0" border="0" class="nobord"><tr><td class="nobord" align="left"><tr><td><div style="width:156px;padding-top:4px;padding-bottom:3px;">&nbsp;&nbsp;Remove this design</div></td><td align="right" valign="top" style="padding-top:3px;padding-right:3px;"><img src="/web_design_imagery/canvasContextIcons_delete_off.gif" name="ccmDelete" alt="Remove this template" width="14" height="14" border="0"></td></tr></table></div></li>
        </ul>
		</div>
      </li>
    </ul>
  </li>
</ul>
</div>
</div>
<div class="hidden" id="CanvasPrompt1"><div id="DCPM1" class="CanvasPrompts" style="visibility:visible;display:block;background:url(/website_design_template_images/website-transparent-background-effects-white.png);"><div class="CanvasPromptInner"><b>Browse</b> our designs to find those most suitable for your website's intended purpose and audience.</div></div></div>
<div class="hidden" id="CanvasPrompt2"><div id="DCPM2" class="CanvasPrompts" onMouseOver="javascript:CFTPanelSelectIcon='canvas';toggleCFTPanel('visible');" onMouseOut="javascript:CFTPanelSelectIcon='canvas';toggleCFTPanel('hidden');" style="visibility:visible;display:block;background:url(/website_design_template_images/website-transparent-background-effects-white.png); cursor:help;"><div class="CanvasPromptInner"><a href="/wikipedia.htm?st=Drag_and_drop" class="WikiBoard" target="WIKI">Drag-and-drop</a> the five(5) most relevant designs to any slot on the <a class="showgunCAN" style="font-weight:bold;"><font style="color:#000000;">Open</font>Canvas</a> design platform.</div></div></div>
<div class="hidden" id="CanvasPrompt3"><div id="DCPM3" class="CanvasPrompts" onClick="if(FavoriteContains.length > 0) { loadCategory('favorites',0); }" onMouseOver="javascript:CFTPanelSelectIcon='favorites';toggleCFTPanel('visible');" onMouseOut="javascript:CFTPanelSelectIcon='favorites';toggleCFTPanel('hidden');" style="visibility:visible;display:block;background:url(/website_design_template_images/website-transparent-background-effects-white.png); cursor:pointer;"><div class="CanvasPromptInner">You may also <a href="/wikipedia.htm?st=Drag_and_drop" class="WikiBoard" target="WIKI">drag-and-drop</a> unto <a class="showgunFAV" style="font-weight:bold;color:#E4BE4A">favorites</a>, but try to keep those to a minimum. Thanks!</div></div></div>
<div class="hidden" id="CanvasPrompt4"><div id="DCPM4" class="CanvasPromptSubmitted" onMouseOver="javascript:CFTPanelSelectIcon='canvas';toggleCFTPanel('visible');" onMouseOut="javascript:CFTPanelSelectIcon='canvas';toggleCFTPanel('hidden');" style="visibility:visible;display:block;background:url(/website_design_template_images/website-transparent-background-effects-white.png); cursor:help;"><div class="CanvasPromptInner">Your <a class="showgunCAN" style="font-weight:bold;text-decoration:none;color:#266899;"><font style="color:#000000;text-decoration:none;">Open</font>Canvas</a> has been submitted, as well as added to your shopping cart.</div></div></div>
<div class="hidden" id="CanvasPrompt5"><div id="DCPM5" class="CanvasPromptSubmitted" style="visibility:visible;display:block;background:url(/website_design_template_images/website-transparent-background-effects-white.png);"><div class="CanvasPromptInner">Want <a class="showgunCAN" style="font-weight:bold;text-decoration:none;color:#266899;"><font style="color:#000000;text-decoration:none;">Virtual</font>Private</a> started on your interactive design project expeditiously? <a href="javascript:viewCart();" onMouseOver="javascript:mouseCart();">Buy it now</a></div></div></div>
<?php echo $StarRatingImagemap?>
</body>
</html>