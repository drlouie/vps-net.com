<?php

################################################################
#   Program:    Domain Name Search and Registration            #
#   Author:     Luis Gustavo Rodriguez (drlouie)               #
#   Copyright:  (c) 2009 Luis G. Rodriguez                     #
#   Licensing:  MIT License                                    #
#   About                                                      #
#        Type:  Domain Name Whois Search                       #
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

#-- vps-net.com > Domain Name Search Tools > Domain Info (WHOIS)

	$phpCompileOS = $_SERVER["SERVER_SOFTWARE"];
	if (stristr($phpCompileOS, 'WIN') !== FALSE) {
		$HTTPRoot = 'H:/dvwf/rbsd_IO/vhosts/vsnet/htdocsNEW/';
	}
	else { $HTTPRoot = '/var/www/vps-net.com/htdocs/'; }

	/*define local working table*/
	define("VPSSQL_DB_NAME", "vpsnetcom");

	/** load VPS-DB-CONFIG */
	require_once($HTTPRoot.'vps-config.php' );

	// read cart cookie
	$OpenCanvasDesign = $_COOKIE["OpenCanvasDesign"];

	$section = 2;
	$subsection = 3;
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

	$VirtualPrivateDomain = $_COOKIE["VirtualPrivateDomain"];
	if (!empty($VirtualPrivateDomain)) {
		$VirtualPrivateDomain = (int)$VirtualPrivateDomain;
	}

	$headScriptJS = '';
	$headStyleCSS = '';


	//--> DEFINE DOCUMENT HEAD CONTENT [scripts/css]
	$headScriptJS = "\n" . CommonHeadScript() . "\n" . MainMenuHeadScript() . "\n" . AmazonAdHeadScript() . "\n" . FreeCaptchaHeadScript() . "\n" . FancyBoxHeadScript() . "\n";
	$headStyleCSS = "\n" . CommonHeadCSS() . "\n" . MainMenuHeadCSS() . "\n" . AmazonAdHeadCSS() . "\n" . FancyBoxHeadCSS() . "\n";
	$headScriptJSLinks = "\n" . CommonHeadJavascriptLinks() . "\n" . MainMenuHeadJavascriptLinks() . "\n";
	$headStyleCSSLinks = "\n" . CommonHeadCSSLinks() . "\n";

	$mainMenuItems = $db->get_results("SELECT * FROM Section ORDER BY SectionID ASC");
	$subMenuItems = $db->get_results("SELECT * FROM SubSection WHERE SID = '$section' AND VirtualStatus = 'Active' ORDER BY SectionID ASC");

	// get SELECTED section's document layout for processing
	// [SELECTED SECTION ONLY!!] //
	$selectedSectional = 0;
	if ($subsection > 0 && !empty($section)) { $selectedSectional = $db->get_row("SELECT * FROM SubSection WHERE SID = '$section' AND SectionID = '$subsection'"); }
	else if (!empty($section)) { $selectedSectional = $db->get_row("SELECT * FROM Section WHERE SectionID = '$section'"); }

	//--> DEFINE DOCUMENT TOP HEADER MARKUP [ANYTHING THAT WILL BE POSTED ON EVERY PAGE AT <BODY> TAG]
	$documentBodyHeader = MainDocumentHeaderMarkup($A1, $selectedSectional, $ISIN) . "" . MainDocumentMenuMarkup($section,$subsection,$mainMenuItems,$subMenuItems);

	// REQUEST DOCUMENT TEMPLATE BASED ON ABOVE PARAMS: templater.php
	// NEW section/subsection HEAD/META info is overwritted using pre-defined DB data
	$myHeadPiece = commonHead($cs1, $cs2, $cs3, $docHeader, $pageTitle, $mainKeywords, $shortKeywordList, $shortKeywordPhrase, $fluffyKeywords, $metaDescription, $headScriptJS, $headStyleCSS, $headScriptJSLinks, $headStyleCSSLinks, $onLoadScript, $documentBodyHeader,$section,$subsection,$mainMenuItems,$subMenuItems);


	//--> attain the advertisements for this page
	// $CommonADQuery = "AdKeys LIKE '%Data%' OR AdKeys LIKE 'Data%' OR AdKeys LIKE '%Data' OR AdKeys LIKE '%Encrypt%' OR AdKeys LIKE '%Encrypt' OR AdKeys LIKE 'Encrypt%'";
	$CommonADQuery = "
	AdKeys LIKE '%Domain%' OR AdKeys LIKE 'Domain%' OR AdKeys LIKE '%Domain' 
	OR 
	AdKeys LIKE '%Hosting%' OR AdKeys LIKE '%Hosting' OR AdKeys LIKE 'Hosting%' 
	OR 
	AdKeys LIKE '%Register%' OR AdKeys LIKE '%Register' OR AdKeys LIKE 'Register%' 
	OR 
	AdKeys LIKE '%Registration%' OR AdKeys LIKE '%Registration' OR AdKeys LIKE 'Registration%'";
	require_once($HTTPRoot.'commonAdvertisements.php' );


	$bgSpacerALT = $selectedSectional->SectionTitle;
	$bgSectionTITLE = $selectedSectional->SectionBackgroundTitle;
	$sectionLINK = $selectedSectional->SectionPage;
?>

<?php echo $myHeadPiece?>




































<div id="documentBody">
<center>
<div id="documentBodyHeader">
<style type="text/css">
.Lookup-Who-Is-Owner-Of-Com-Domain-Name-And-Registration {
	border:#FAFAFA 1px solid;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	background:url(/website_design_template_images/website-transparent-background-effects-heavy.png);
}

.Internet-Website-Domain-Name-1 { font-family:Tahoma, Arial, Helvetica; font-size:16px; font-weight:bold; padding-left:10px; padding-top:5px; width:240px; height:18px; }
.Internet-Website-Domain-Name-2 { width:240px; height:18px; background:url(/web_design_imagery/interface-design-linear1.gif) no-repeat 0 10px; }
.Internet-Website-Domain-Name-3 { padding-left:10px; line-height:20px; width:228px;font-family:tahoma,arial,verdana;font-size:14px;}
.Internet-Website-Domain-Name-4 { width:240px; height:12px; background:url(/web_design_imagery/interface-design-linear1.gif) no-repeat 0 10px; }
.Internet-Website-Domain-Name-5 a{ padding-right:15px; width:240px;height:16px;font-family:tahoma,arial,verdana;font-size:10px;color:#B0B0B0; }
.Internet-Website-Domain-Name-5 a:hover { width:240px;height:14px;font-family:tahoma,arial,verdana;font-size:10px; text-decoration:none; }
.Internet-Website-Domain-Name-5dark { width:240px;height:16px;font-family:tahoma,arial,verdana;font-size:10px;text-decoration:underline; }
.Internet-Website-Domain-Name-5dark:hover { width:240px;height:16px;font-family:tahoma,arial,verdana;font-size:10px; text-decoration:underline; }
.Internet-Website-Domain-Name-Nocont { width:60px; height:1px; overflow:hidden; clip:rect(0px, 60px, 1px, 0px); }

.Internet-Website-Domain-Name-Wrapper { padding-top:32px; padding-bottom:32px; margin-left: 27px; width:615px; }
.Internet-Website-Domain-Name-FormContainer { margin-left: 10px; width:605px; }
.Internet-Website-Domain-Name-Prompt { font-family:tahoma,arial,verdana; font-size:14px; font-weight:bold; color:#000000; }
.Internet-Website-Domain-Name-Instructions { margin-left:30px; margin-bottom:20px; width:540px; font-family:verdana,tahoma,arial; font-size:12px; color:#000000; font-weight:normal; }
.EOFSectionTitle { margin-bottom:20px; font-family:Tahoma, Arial, Helvetica; font-size:19px; font-weight:normal; color:#266899; }
.EOFSectionIntroduction { margin-bottom:30px; padding-right:35px; font-family:Tahoma, Arial, Helvetica; font-size:15px; font-weight:normal; color:#000000; line-height:21px; }

legend.Internet-Website-Domain-Name-Legend { padding-top:15px; padding-bottom:10px; font:12px verdana,arial,helvetica; color:#000000; font-weight:bold; }
label.Internet-Website-Domain-Name-Label { font-size:14px; }
textarea.Internet-Website-Domain-Name-Textarea, #Lookup-Who-Is-Owner-Of-Com-Domain-Name-And-Registration-Results { width:550px; height:180px; font-family:Courier New,monospace,serif;font-size:12px; }
#Internet-Website-Domain-Name-Textarea, #Lookup-Who-Is-Owner-Of-Com-Domain-Name-And-Registration-Results { margin-left:25px; margin-bottom:10px; }
input.Internet-Website-Domain-Name-Buttons { height:24px; font-family:Verdana,Arial,Helvetica; font-size:12px; }
#Internet-Website-Domain-Name-Buttons { margin-right:30px; margin-bottom:12px; }
#Internet-Website-Domain-Name-CodeRequest { margin-left:21px; margin-bottom:10px; } 

textarea.HTML-O-Feedback { width:256px;height:85px; font-family:Courier New,monospace,serif;font-size:12px; }

#Whois-IP-Address-lookup-who-is-owner-of-com-domain-name-Lookup-title { text-align: left; }
#Whois-IP-Address-lookup-who-is-owner-of-com-domain-name-Lookup-title b { display: block; margin-right: 80px; }
#Whois-IP-Address-lookup-who-is-owner-of-com-domain-name-Lookup-title span { float: right; }




#Com-Domain-Name-Who-Is-Whois-Lookup-Owner form {
	margin: 0;
	padding: 0;
	display: block;
}
#Com-Domain-Name-Who-Is-Whois-Lookup-Owner *:focus {
	outline: none;
}

#Com-Domain-Name-Who-Is-Whois-Lookup-Owner{
	padding:18px 0 0 36px;
	position: relative;
	font: normal 12px/16px Arial, sans-serif;
	color: #111;
	list-style:none;
	margin:0;
}

#Com-Domain-Name-Who-Is-Whois-Lookup-Owner li{
    height: auto;
    position: relative;
}

#Com-Domain-Name-Who-Is-Whois-Lookup-Owner li .text {
	top:3px;
	left:3px;
	background: #F0EFEF;
	padding:13px 10px 5px 0;
	position:absolute;
	z-index:1001;
	min-width:60px;
	border-bottom-right-radius: 5px;
	-moz-border-radius-bottomright:5px;
	-webkit-border-bottom-right-radius:5px;
	border-top-left-radius: 5px;
	-moz-border-radius-topleft:5px;
	-webkit-border-top-left-radius:5px;
	text-indent: 16px;
	display:block;
	font-size:1.50em;
}
#Com-Domain-Name-Who-Is-Whois-Lookup-Owner li .lookup-who-is-owner-of-com-domain-name-form-control-wrap{
	z-index:1000;
	position: relative;
	height:auto;
}

#pa-rappa-the-rappa {
	float:left;
	position:relative;
	z-index:1000;

	border:solid 1px #FAFAFA;
	-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
	-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
	box-shadow: 0 1px 3px rgba(0,0,0,0.5);

	border-radius:5px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;

}
#Com-Domain-Name-Who-Is-Whois-Lookup-Owner li .lookup-who-is-owner-of-com-domain-name-form-control-wrap textarea {
	color: #ACACAC;
	overflow:hidden;
	background:#fff;
	border:solid 5px #F0EFEF;

	border-radius:5px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;

    width: 555px;
	max-width:555px;
	z-index:100;
	margin:0;
	float:left;
	position:relative;

	font-size:1.75em;
	font-weight:normal;
	padding:8px 0 0 0;
	max-height:34px;
	height:34px;
	clip:rect(0px,555px,34px,0px);
	overflow:hidden;
	text-indent:80px;
}

#Lookup-Who-Is-Owner-Of-Com-Domain-Name-And-Registration-Results {
	color: #111;
	overflow:hidden;
	background:#fff;
	border:solid 5px #F0EFEF;
	text-align:left;

	border-radius:5px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;

    width: 515px;
	min-width:515px;
	max-width:515px;
	z-index:100;
	margin:0;
	font-size:12px;
	font-weight:normal;
	font-family:tahoma,arial,verdana;
	padding:60px 20px 20px 20px;
}

#Com-Domain-Name-Who-Is-Whois-Lookup-Owner li#submit input {
	position:absolute;
	background: #222 url(../web_design_imagery/btn-overlay.png) repeat-x top left;
	display: inline-block; 
	padding: 10px 20px 10px 20px; 
	color: #fff; 
	text-decoration: none;

	border-radius: 5px; 
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px;

	-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
	-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
	box-shadow: 0 1px 3px rgba(0,0,0,0.5);

	text-shadow: 0 -1px 1px rgba(0,0,0,0.25);

	border: 1px solid #FFF;
	cursor: pointer;
	background-color:#0078AD;
	font-weight:bold;
	margin:10px;
}
#Com-Domain-Name-Who-Is-Whois-Lookup-Owner .bbl_buttons a:hover, #Com-Domain-Name-Who-Is-Whois-Lookup-Owner li#submit input:hover {
	 background-color: #111; 
	 color: #fff;
}
#Com-Domain-Name-Who-Is-Whois-Lookup-Owner .bbl_buttons a:active {
	top:1px;
}
#Find-Your-Domain {
	padding:0;
	position:relative;
	left:-165px;
	top:-19px;
	color:#266899;
	font-size:17px;
	font-family:tahoma,arial,verdana;
}

#domain-name-search { position:relative;top:-4px;left:4px;padding: 5px 7px 0px 12px; width:auto; display: block; text-align:left; margin:0; font-size: 14px; }
.lookup-who-is-owner-of-com-domain-name-error {background: url(/web_design_imagery/website_design_communications/domain-name-error.png) no-repeat 6px 5px; }
.lookup-who-is-owner-of-com-domain-name-available {background: url(/web_design_imagery/website_design_communications/domain-name-available.png) no-repeat 6px 5px; }
.domain-name-search-taken {background: url(/web_design_imagery/website_design_communications/domain-name-taken.png) no-repeat 6px 5px; }
.lookup-who-is-owner-of-com-domain-name-saved {background: url(/web_design_imagery/website_design_communications/domain-name-saved.png) no-repeat 6px 5px; }



.WHOIS_Who_Is_Lookup_Com_Domain_Submitted, .Domain_Whois_Information_Lookup {
	visibility:visible;
	display:block;
	background:url(/website_design_template_images/website-transparent-background-effects-white.png);
	font-size: 12px; font-family:Tahoma, Arial, Helvetica; color:#333333; 
	margin-bottom:15px; 
	overflow:hidden; 
}
.WHOIS_Who_Is_Lookup_Com_Domain_Inner { text-align:left; padding:6px; padding-top:14px; padding-bottom:14px; line-height:12px;}
.WHOIS_Who_Is_Lookup_Com_Domain_Submitted, .Domain_Whois_Information_Lookup {
	border:#EEF0F5 1px solid;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
}
.WHOIS_Who_Is_Lookup_Com_Domain_Submitted {
	box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
	-moz-box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
	-webkit-box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
}
.Domain_Whois_Information_Lookup {
	text-shadow: 0px 3px 1px rgba(200,200,200,0.13);
}
.hidden { width:0px; height:0px; overflow:hidden; clip:rect(0px,0px,0px,0px); visibility:hidden; }

.domain-extension-support {
	z-index:1;
	padding:0;margin:0;
	list-style:none;
}
.domain-extension-support li, .domain-extension-support span{
	color:#D2D2D2;
	border:#EEF0F5 1px solid;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	background:url(/website_design_template_images/website-transparent-background-effects-heavy.png);
	float:left; 
	padding:1px 4px 2px 2px;
	/* margin:2px 0 0 3px; */
	margin: 7px 0px 0px 4px;
	cursor:pointer;
}
.domain-extension-support span {
	color:#C0C0C0;
	letter-spacing:1px;
}
.domain-extension-support li:hover, .domain-extension-support span:hover {
	color:#E89520;
	border:#FFFFFF 1px solid;
	background:url(/website_design_template_images/website-transparent-background-effects-yellow.png);
}
.hoverpanels {
	cursor:pointer;
}
.hoverpanels:hover {

}
.hoverpanels, .hoverpanels:hover {
	margin:0 auto 0 auto;
	max-width:240px;

}
a.WikiBoard {
	color:#000000; 
}
a.WikiBoard:hover, a.WikiBoard:focus {
	color:#266899;
	text-decoration:none;
}
</style>
<script language="Javascript" type="text/javascript">
var lookupText = '';
var lookupAct = '';
var textareaFont = '';
var runDomainSearch = function(acual) {
	searchActivity = $('#Com-Domain-Name-Who-Is-Whois-Lookup-Owner .text');
	if (document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].value.indexOf('WhoIsBehindThat.com') != -1) { return true; }
	else {
	if (lookupText == '') { lookupText = searchActivity.html();  lookupAct = $('#submit').html(); }
	searchActivity.html('<span style="position:relative;top:0px;left:0px;" title="Searching..."><img src="/web_design_imagery/loadCircle.gif" width="18" height="15" border="0" alt="Searching..." style="padding-right:10px;"></span>');
	$('#submit').html('<input type="reset" value="Run Another Query" onClick="javascript:reSearch();" style="background-color:#111;">');
	//alert(document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].value);
	var lUrl = '/domain-registration-search/whois-protocol-query-search-lookup.htm?d='+document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].value+'';
	var callback = {
		success: function(o) {
			if(o.responseText !== undefined) {
				if (o.responseText.indexOf('JUSTOUTSTANDING!') != -1) {
					searchActivity.fadeTo('fast','0.00',function() {
						myWhoisResults = o.responseText;
						myWhoisResults = myWhoisResults.replace('JUSTOUTSTANDING!','');
						
						if (o.responseText.indexOf('No match for domain') != -1) {
							$(this).html('<div id="domain-name-search" class="lookup-who-is-owner-of-com-domain-name-available">Domain Name Available: <i>'+document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].value+'</i></div>');

							$('#submit').html(
								$('#submit').html()+
								'<div style="position:relative;top:40px;" id="save"><input type="button" value="Save This Domain" onClick="javascript:saveMyDomainName(\''+document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].value+'\');" style="background-color:#E89520;"></div>'+
								'<div style="position:relative;top:80px;" id="register"><input type="button" value="Register Domain" onClick="registerDomain=1;javascript:saveMyDomainName(\''+document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].value+'\');" style="background-color:#0078AD;"></div>'
							);
							$('#save').focus();

						}
						else {
							$(this).html('<div id="domain-name-search" class="lookup-who-is-owner-of-com-domain-name-available"><i>Whois '+document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].value+'</i></div>');
						}

						$('#Com-Domain-Name-Who-Is-Whois-Lookup-Owner li .lookup-who-is-owner-of-com-domain-name-form-control-wrap textarea').css('text-indent',''+(searchActivity.width()+20)+'px');
						document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].value = '';
						$('#Lookup-Who-Is-Owner-Of-Com-Domain-Name-And-Registration-Results').css('display','block').html(myWhoisResults);
						$('.Lookup-Who-Is-Owner-Of-Com-Domain-Name-And-Registration').css('background','url(/website_design_template_images/website-transparent-background-effects-heaviest.png)').css('height',''+($('#Lookup-Who-Is-Owner-Of-Com-Domain-Name-And-Registration-Results').height()+130)+'px');
						$('#search-form').css('display','none');
						$(this).fadeTo('slow','1.00');
						$(".domain-extension-support").hide();
						$('#submit input').focus();
						whoisHasBeenSuccessful();
						countCPM++;
					});
				}
				else {
					searchActivity.fadeTo('fast','0.00',function() {
						if (o.responseText.indexOf('Invalid characters') != -1) {
							$(this).html('<div id="domain-name-search" class="lookup-who-is-owner-of-com-domain-name-error">'+o.responseText+'</div>');
						}
						else {
							$(this).html('<div id="domain-name-search" class="lookup-who-is-owner-of-com-domain-name-error">Try again!</div>');
						}
						$('#Com-Domain-Name-Who-Is-Whois-Lookup-Owner li .lookup-who-is-owner-of-com-domain-name-form-control-wrap textarea').css('text-indent',''+(searchActivity.width()+20)+'px');
						$(this).fadeTo('slow','1.00');
						$('#submit input').focus();
					});
				}
			}
		},
		failure: function(o) {
			searchActivity.fadeTo('fast','0.00',function() {
				$(this).html('<div id="domain-name-search" class="lookup-who-is-owner-of-com-domain-name-error">Try again!</div>');
				$('#Com-Domain-Name-Who-Is-Whois-Lookup-Owner li .lookup-who-is-owner-of-com-domain-name-form-control-wrap textarea').css('text-indent',''+(searchActivity.width()+20)+'px');
				$(this).fadeTo('slow','1.00');
				$('#submit input').focus();
			});
		}
	};
	var transaction = YAHOO.util.Connect.asyncRequest("GET", lUrl, callback, null);
	return false;
	}
}
var registerDomain = 0;
var saveMyDomainName = function(domain) {
	searchActivity.html('<span style="position:relative;top:0px;left:0px;" title="Saving..."><img src="/web_design_imagery/loadCircle.gif" width="18" height="15" border="0" alt="Saving..." style="padding-right:10px;"></span>');
	$('#save').html('<input type="button" value="Saving Your Domain" style="background-color:#E89520;">');

	var lUrl = '/domain-registration-search/find-my-domain.htm?s='+domain+'';
	var callback = {
		success: function(o) {
			if(o.responseText !== undefined) {
				if (o.responseText == domain || o.responseText == 'You previously saved:') {
					searchActivity.fadeTo('fast','0.00',function() {
						// only add to tally if truly new domain
						if (o.responseText == domain) { SavedDomains++; }
						$('#save').html('<input type="button" value="Domain Was Saved!" style="background-color:#E89520;">');
						$(this).html('<div id="domain-name-search" class="lookup-who-is-owner-of-com-domain-name-saved">Saved!</div>');
						$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap textarea').css('text-indent',''+(searchActivity.width()+20)+'px');

						// update top bar
						$("#gui-register-a-domain-text div nobr").html('Saved Domains: '+SavedDomains+'');

						$(this).fadeTo('slow','1.00',function() {
					   		window.setTimeout(function(){ 
								reSearch();
								successStory = '<b style="color:#266899">'+o.responseText+'</b> has been saved!';
								if (o.responseText == 'You previously saved:') { successStory = 'You had previously saved that domain.'; }
								domainHasBeenSaved('<center>'+successStory+'</center>');
					   		}, 2000);
						});

						if (registerDomain == 1) { 
							window.setTimeout(function(){
								runFancyFancy('/domain-registration-search/select-your-domain-registrar.htm','Virtual Private',640,370);
							},2000);
						}
					});
				}
				else {
					searchActivity.html('<div id="domain-name-search" class="domain-name-search-error">'+o.responseText+'</div>');
					$(this).fadeTo('slow','1.00',function() {
					  		window.setTimeout(function(){ 
							reSearch();
					  		}, 2000);
					});
				}
			}
		}
	};
	var transaction = YAHOO.util.Connect.asyncRequest("GET", lUrl, callback, null);
};

	var domainHasBeenSaved = function(cuales) {

		swapDomainState();

		$("#gui-register-a-domain").animate({ width: "134px" }, {queue: false});
		$("#gui-register-a-domain-text").animate({ width: "113px" }, {queue: false});
		$("#gui-design-your-website").animate({ width: "21px" }, {queue: false});
		$("#gui-design-your-website-text").animate({ width: "0px" }, {queue: false});

	};
	

var countCPM = 1;
var reSearch = function() {
	if (lookupText != '') {
		$('#Lookup-Who-Is-Owner-Of-Com-Domain-Name-And-Registration-Results').css('display','none').html('');
		$('.Lookup-Who-Is-Owner-Of-Com-Domain-Name-And-Registration').css('background','url(/website_design_template_images/website-transparent-background-effects-heavy.png)').css('height','92px');
		$('#search-form').css('display','block');
		$(".domain-extension-support").show();
//--> TO LIMIT UNCOMMENT TWO FOLLOWING singular // commented lines
// if (countCPM == 6) { $('#Com-Domain-Name-Who-Is-Whois-Lookup-Owner .text').html('<div id="domain-name-search" class="lookup-who-is-owner-of-com-domain-name-error">Save limit reached:</div>'); $('#Com-Domain-Name-Who-Is-Whois-Lookup-Owner li .lookup-who-is-owner-of-com-domain-name-form-control-wrap textarea').css('text-indent',''+(searchActivity.width()+20)+'px'); $('#submit').html(''); document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].value = 'Maximum five(5) domain names'; document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].disabled = 1; } else {
			$('#Com-Domain-Name-Who-Is-Whois-Lookup-Owner .text').html(lookupText);
			$('#Com-Domain-Name-Who-Is-Whois-Lookup-Owner li .lookup-who-is-owner-of-com-domain-name-form-control-wrap textarea').css('text-indent','80px');
			$('#submit').html(lookupAct);
			document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].value = '';
//}
	$('#AdvertisementSpace').css('display','none');

		document["lookup-who-is-owner-of-com-domain-name-form"]["domain-search"].focus();
	}
};

var whoisHasBeenSuccessful = function() {
	var Dom = YAHOO.util.Dom;
	var cpContents = Dom.get("AdvertisementSpace");
	if (jQuery.browser.msie) {
		$('.WHOIS_Who_Is_Lookup_Com_Domain_Inner').css('border','0').css('background','none');
		$('#DomainSearchPM1').css('border','0').css('background','none');
	}
	if (countCPM == 1) {
		var DWHOIS_Who_Is_Lookup_Com_Domain_1 = Dom.get("WHOIS_Who_Is_Lookup_Com_Domain_1");
		var WHOIS_Who_Is_Lookup_Com_Domain_Inner1 = Dom.get("WHOIS_Who_Is_Lookup_Com_Domain_Inner1");
		var dcp1 = document.createElement("div");
   		dcp1.timeout = setTimeout(function(){ 
			// WHOIS_Who_Is_Lookup_Com_Domain_Inner1.innerHTML = cuales;
			DC1 = "DomainSearchPM"+countCPM+"";
			dcp1 = DWHOIS_Who_Is_Lookup_Com_Domain_1.firstChild;
			cpContents.appendChild(dcp1);
			divBlink(''+DC1+'',2);
	    }, 1);
	}
	$('#AdvertisementSpace').css('display','block');
};
	
var divBlink = function(quien,timesBlink) {
	for (var i=0; i<timesBlink; i++) {
		if(!jQuery.browser.msie) {
			$('#'+quien+'').fadeOut("fast");
			$('#'+quien+'').fadeIn("slow");
		}
	}
	//if (jQuery.browser.msie && oldBG) { $('#'+quien+'').css('background',""+oldBG+""); }
};
	var mouseCart = function() {
		$("#gui-your-shopping-cart-text").focus();
	};

var extensionView = 1;
var toggleExtensions = function(eview) {
	extensionView = eview;
	countExtensions = 0;
	$("#domain-extension-support").find('li').each(function(){
		countExtensions++;
		var tti = $(this).attr('title');
		if (extensionView == 1) {
			$("#ccTLD-1").css('color','#000');
			$("#ccTLD-2").css('color','');
		}
		else {
			$("#ccTLD-1").css('color','');
			$("#ccTLD-2").css('color','#000');
		}
		if ((extensionView == 1 && countExtensions <= 97) || (extensionView == 2 && countExtensions >= 98)) {
			$(this).show();
			$(this).attr('id',tti);
			$(this).click(function(e){ 
				$.fancybox(wikifancy);
				$("#fancybox-frame").attr("src",'/wikipedia.htm?st='+tti+'');
			});
		}
		else {
			$("#ccTLD-1").css('color','#000');
			$(this).hide();
		}
	});
};	
	
$(document).ready(function() {
	//$("#domain-extension-support").find('li').CreateBubblePopup( BPoptions3 ).each(function(){
	countExtensions = 0;
	$("#domain-extension-support").find('li').each(function(){
		countExtensions++;
		var tti = $(this).attr('title');
		if (countExtensions <= 97) {
			$(this).attr('id',tti);
			$(this).click(function(e){ 
				$.fancybox(wikifancy);
				$("#fancybox-frame").attr("src",'/wikipedia.htm?st='+tti+'');
			});
		}
		else {
			$(this).hide();
		}

	});
	$(".Country-Code-Top-Level-Domain-Name-Extensions").each(function(){
		var tti = $(this).attr('title');
		$(this).CreateBubblePopup( BPoptions3 );
		$(this).SetBubblePopupInnerHtml( '<div class="MoreInfo-panelBarWIKIitem-WikiBoard" style="padding:10px;font-size:11px;font-family:verdana,arial,helvetica;line-height:15px;color:#444;max-width:450px;">'+ tti +'</div>');
		$(this).removeAttr( 'title' );
		$(".Country-Code-Top-Level-Domain-Name-Extensions a").removeAttr( 'title' );
	});
	$('#domain-search').keypress(function (e) {
		if (e.keyCode == 13) {
			runDomainSearch(document.forms["domain-name-search-form"]);
			return false;
		}
	});
});

var hideAd = function(e) {
	$('#AdvertisementSpace').css('display','none');
};
</script>
<table width="920" cellpadding="0" cellspacing="0" border="0" class="nobord">
	<tr class="nobord">
		<td class="nobord" valign="top" align="center" width="100%">
		<div style="height:146px;max-height:164px;padding-top:96px;position:relative;">
			<div id="Find-Your-Domain">Domain and IP Address Search:</div>
			<div class="Lookup-Who-Is-Owner-Of-Com-Domain-Name-And-Registration" style="width:800px;height:92px;">
				<div class="domain-name-search" style="position:absolute;">
					<form method="post" name="lookup-who-is-owner-of-com-domain-name-form" class="lookup-who-is-owner-of-com-domain-name-form" onSubmit="return runDomainSearch(this);">
					<ul id="Com-Domain-Name-Who-Is-Whois-Lookup-Owner">
						<li id="message">
							<span class="text">www.</span>
							<span id="pa-rappa-the-rappa"><span class="lookup-who-is-owner-of-com-domain-name-form-control-wrap">
								<div id="search-form" style="display:block;">
									<textarea name="domain-search" id="domain-search" cols="40" rows="10" onFocus="javascript:if(this.value=='WhoIsBehindThat.com') { this.value=''; } $(this).css('background-color','#FCFCFC').css('color','#111'); $('#pa-rappa-the-rappa').css('border-color','#EFEFEF');" onBlur="javascript:if(this.value==''||this.value==' '||this.value.length <= 3||this.value=='WhoIsBehindThat.com') { this.value='WhoIsBehindThat.com'; $(this).css('color','#ACACAC'); } $(this).css('background-color','#FFFFFF'); $('#pa-rappa-the-rappa').css('border-color','#FAFAFA');">WhoIsBehindThat.com</textarea>
								</div>
								<div id="Lookup-Who-Is-Owner-Of-Com-Domain-Name-And-Registration-Results" style="display:none;height:auto;"></div>
							</span></span>
							
						</li>
						<li id="submit"><input type="submit" value="Query The Protocol"></li>
					</ul>
					</form>
				</div>
			<div id="AdvertisementSpace" style="position:absolute;top:146px;right:268px;z-index:1001;max-width:400px;"></div>
		</div>
		</td>
	</tr>
</table>
<table width="920" cellpadding="0" cellspacing="0" border="0" class="nobord">
	<tr class="nobord">
		<td class="nobord"><div id="backgroundOverlay" style="width:300px;height:68px;overflow:hidden;clip:rect(0px,300px,68px,0px);"><div style="padding-top:30px;padding-left:60px;"><a href="<?php echo $sectionLINK; ?>" title="<?php echo $bgSectionTITLE; ?>"><img src="/web_design_imagery/spacer.gif" width="460" height="80" border="0" alt="<?php echo $bgSpacerALT; ?>"></a></div></div></td>
		<td class="nobord" align="right"><div id="AD4" style="<?php echo $Advertisement4x1style; ?>;margin-right:60px;width:320px;max-height:68px;overflow:hidden;clip:rect(0px,320px,68px,0px);"><?php echo $Advertisement4x1; ?></div><div class="advertisement" style="width:<?php echo $Advertisement4x1w; ?>px;height:10px;padding-top:2px;margin-right:60px;"><?php echo $Advertisement4x1title; ?></div></td>
	</tr>
</table>
<div style="max-height:183px;overflow:hidden;">
<table width="920" cellpadding="0" cellspacing="0" border="0" class="nobord">
	<tr class="nobord">
		<td class="nobord" valign="top" align="center" width="100%">
<div class="DomainSearchExtensions domain-extension-support" style="background:none;float:left;clear:right;margin-bottom:10px;"><span class="Country-Code-Top-Level-Domain-Name-Extensions" title="&lt;b&gt;ccTLD (Country-Code Top-Level Domain) Extensions&lt;/b&gt;&lt;br&gt;&lt;br&gt;Country code top-level domain extensions are listed below for your convenience. For instance: .ac .ad .ae .lr .ls etc, and on a side note, the extension list on this whois page doesn't show any of the extensions listed on the domain search and domain registration pages. Click now to learn more about Country-Code Top-Level Domains(ccTLDs) using Wikipedia.&lt;br&gt;&lt;br&gt;Furthermore, click any of the top-level extensions listed below to learn more about the origin, country association and other pertinent information regarding that domain name extension.&lt;br&gt;&lt;br&gt;&lt;i&gt;Note: You can toggle between .ac-.lk and .lr-zw extensions using the text-link menu to the right.&lt;/i&gt;&lt;b&gt;&lt;br&gt;&lt;br&gt;Whois search supports all domain names with top-level, mid-level and low-level extensions as well as public Internet Protocol(IP) addresses.&lt;/b&gt;" style="border:0;background:0;"><a href="/wikipedia.htm?st=List_of_Internet_top-level_domains" class="WikiBoard" target="WIKI" title="Whois search supports all domain names with top-level, mid-level and low-level extensions as well as public Internet Protocol(IP) addresses. If you'd like more information about Country-Code Top-Level Domains(ccTLDs), simply click now to learn more. Furthermore, click any of the top-level extensions listed below to learn more about the origin, country association and other pertinent information regarding that domain name extension." style="color:#266899;font-style:italic;text-decoration:none;">ccTLDs: Country-Code Top Level Domain Extensions:</a></span><span style="border:0;background:0;color:#266899;"><a href="javascript:toggleExtensions(1);" id="ccTLD-1" title="Show (ccTLD) Country-Code Top Level Domain Name Extensions from .AC to .LK" style="text-decoration:none;color:#000;">.ac - .lk</a> | <a href="javascript:toggleExtensions(2);" id="ccTLD-2" title="Show (ccTLD) Country-Code Top Level Domain Name Extensions from .LR to .ZW" style="text-decoration:none;">.lr - .zw</a></span></div>
<div class="DomainSearchExtensions" style="background:none;float:left;clear:right;margin-bottom:40px;"><i><ul id="domain-extension-support" class="domain-extension-support" style="background:none;float:left;clear:right;margin-bottom:40px;">
<li title=".ac">.ac</li><li title=".ad">.ad</li><li title=".ae">.ae</li><li title=".af">.af</li><li title=".ai">.ai</li><li title=".al">.al</li><li title=".ao">.ao</li><li title=".aq">.aq</li><li title=".ar">.ar</li><li title=".aw">.aw</li><li title=".ax">.ax</li><li title=".az">.az</li><li title=".ba">.ba</li><li title=".bb">.bb</li><li title=".bd">.bd</li><li title=".bf">.bf</li><li title=".bg">.bg</li><li title=".bh">.bh</li><li title=".bj">.bj</li><li title=".bm">.bm</li><li title=".bn">.bn</li><li title=".bo">.bo</li><li title=".bt">.bt</li><li title=".bw">.bw</li><li title=".by">.by</li><li title=".cd">.cd</li><li title=".cf">.cf</li><li title=".cg">.cg</li><li title=".ch">.ch</li><li title=".ci">.ci</li><li title=".ck">.ck</li><li title=".cl">.cl</li><li title=".cm">.cm</li><li title=".cn">.cn</li><li title=".cr">.cr</li><li title=".cu">.cu</li><li title=".cv">.cv</li><li title=".cw">.cw</li><li title=".cx">.cx</li><li title=".cy">.cy</li><li title=".cz">.cz</li><li title=".dj">.dj</li><li title=".dk">.dk</li><li title=".dm">.dm</li><li title=".do">.do</li><li title=".dz">.dz</li><li title=".ec">.ec</li><li title=".ee">.ee</li><li title=".eg">.eg</li><li title=".er">.er</li><li title=".fj">.fj</li><li title=".fk">.fk</li><li title=".ga">.ga</li><li title=".gd">.gd</li><li title=".gf">.gf</li><li title=".gg">.gg</li><li title=".gh">.gh</li><li title=".gi">.gi</li><li title=".gl">.gl</li><li title=".gm">.gm</li><li title=".gn">.gn</li><li title=".gp">.gp</li><li title=".gq">.gq</li><li title=".gr">.gr</li><li title=".gt">.gt</li><li title=".gu">.gu</li><li title=".gw">.gw</li><li title=".gy">.gy</li><li title=".hk">.hk</li><li title=".hm">.hm</li><li title=".hn">.hn</li><li title=".hr">.hr</li><li title=".ht">.ht</li><li title=".hu">.hu</li><li title=".ie">.ie</li><li title=".il">.il</li><li title=".im">.im</li><li title=".io">.io</li><li title=".iq">.iq</li><li title=".is">.is</li><li title=".je">.je</li><li title=".jm">.jm</li><li title=".ke">.ke</li><li title=".kg">.kg</li><li title=".kh">.kh</li><li title=".ki">.ki</li><li title=".km">.km</li><li title=".kn">.kn</li><li title=".kp">.kp</li><li title=".kr">.kr</li><li title=".kw">.kw</li><li title=".ky">.ky</li><li title=".kz">.kz</li><li title=".la">.la</li><li title=".lb">.lb</li><li title=".lc">.lc</li><li title=".lk">.lk</li>

<li title=".lr">.lr</li><li title=".ls">.ls</li><li title=".lt">.lt</li><li title=".lu">.lu</li><li title=".lv">.lv</li><li title=".ly">.ly</li><li title=".ma">.ma</li><li title=".mc">.mc</li><li title=".md">.md</li><li title=".mg">.mg</li><li title=".mh">.mh</li><li title=".mk">.mk</li><li title=".ml">.ml</li><li title=".mm">.mm</li><li title=".mn">.mn</li><li title=".mp">.mp</li><li title=".mq">.mq</li><li title=".mr">.mr</li><li title=".mt">.mt</li><li title=".mu">.mu</li><li title=".mv">.mv</li><li title=".mw">.mw</li><li title=".my">.my</li><li title=".mz">.mz</li><li title=".na">.na</li><li title=".nc">.nc</li><li title=".ng">.ng</li><li title=".ni">.ni</li><li title=".np">.np</li><li title=".nr">.nr</li><li title=".nu">.nu</li><li title=".pa">.pa</li><li title=".pe">.pe</li><li title=".pf">.pf</li><li title=".pg">.pg</li><li title=".ph">.ph</li><li title=".pk">.pk</li><li title=".pl">.pl</li><li title=".pm">.pm</li><li title=".pn">.pn</li><li title=".pr">.pr</li><li title=".ps">.ps</li><li title=".pt">.pt</li><li title=".pw">.pw</li><li title=".py">.py</li><li title=".qa">.qa</li><li title=".re">.re</li><li title=".ro">.ro</li><li title=".rs">.rs</li><li title=".ru">.ru</li><li title=".rw">.rw</li><li title=".sa">.sa</li><li title=".sb">.sb</li><li title=".sc">.sc</li><li title=".sd">.sd</li><li title=".sg">.sg</li><li title=".sh">.sh</li><li title=".sk">.sk</li><li title=".sl">.sl</li><li title=".sm">.sm</li><li title=".sn">.sn</li><li title=".so">.so</li><li title=".sr">.sr</li><li title=".ss">.ss</li><li title=".st">.st</li><li title=".sv">.sv</li><li title=".su">.su</li><li title=".sx">.sx</li><li title=".sy">.sy</li><li title=".sz">.sz</li><li title=".tc">.tc</li><li title=".td">.td</li><li title=".tf">.tf</li><li title=".tg">.tg</li><li title=".th">.th</li><li title=".tj">.tj</li><li title=".tm">.tm</li><li title=".tn">.tn</li><li title=".to">.to</li><li title=".tr">.tr</li><li title=".tt">.tt</li><li title=".tz">.tz</li><li title=".ua">.ua</li><li title=".ug">.ug</li><li title=".uy">.uy</li><li title=".uz">.uz</li><li title=".va">.va</li><li title=".vc">.vc</li><li title=".ve">.ve</li><li title=".vi">.vi</li><li title=".vn">.vn</li><li title=".vu">.vu</li><li title=".wf">.wf</li><li title=".ye">.ye</li><li title=".za">.za</li><li title=".zm">.zm</li><li title=".zw">.zw</li>

				</ul></i></div>
			</div>
		</td>
	</tr>
</table>
</div>
<table width="820" cellpadding="0" cellspacing="0" border="0" class="nobord">
	<tr class="nobord" valign="top">
		<td class="nobord hoverpanels" width="240" align="left"><a href="/wikipedia.htm?st=WHOIS" class="WikiBoard" target="WIKI" title="WHOIS Protocol Information by Wikipedia, The Free Encyclopedia"><div class="Internet-Website-Domain-Name-1">Whois Lookup</div><div class="Internet-Website-Domain-Name-2"><img src="/web_design_imagery/spacer.gif" width="240" height="18" border="0"></div><div class="Internet-Website-Domain-Name-3">WHOIS was standardized in the early 1980s to look up domains, people and other resources related to domain and number registrations.</div><div class="Internet-Website-Domain-Name-4"><img src="/web_design_imagery/spacer.gif" border="0" width="240" height="12" border="0"></div><div class="Internet-Website-Domain-Name-5" align="right">more info regarding: "<span class="Internet-Website-Domain-Name-5dark">WHOIS</span>"<img src="/web_design_imagery/graphical-user-interface-arrow1.gif" width="7" height="16" border="0" style="margin-left:4px;"></div></a></td>
		<td class="nobord" width="50"><div class="Internet-Website-Domain-Name-Nocont"><img src="/web_design_imagery/spacer.gif" width="50" height="1" border="0"></div></td>
		<td class="nobord hoverpanels" width="240" align="left"><a href="/wikipedia.htm?st=Name_server" class="WikiBoard" target="WIKI" title="Name Server Information by Wikipedia, The Free Encyclopedia"><div class="Internet-Website-Domain-Name-1">Domain Name Server</div><div class="Internet-Website-Domain-Name-2"><img src="/web_design_imagery/spacer.gif" width="240" height="18" border="0"></div><div class="Internet-Website-Domain-Name-3">Name servers maintain the domain namespace and provide translation services between IP addresses and the domain name hierarchy.</div><div class="Internet-Website-Domain-Name-4"><img src="/web_design_imagery/spacer.gif" width="240" height="12" border="0"></div><div class="Internet-Website-Domain-Name-5" align="right">more info regarding: "<span class="Internet-Website-Domain-Name-5dark">Name Server</span>"<img src="/web_design_imagery/graphical-user-interface-arrow1.gif" width="7" height="16" style="margin-left:4px;"></div></a></td>
		<td class="nobord" width="50"><div class="Internet-Website-Domain-Name-Nocont"><img src="/web_design_imagery/spacer.gif" width="50" height="1" border="0"></div></td>
		<td class="nobord hoverpanels" width="240" align="left"><a href="/wikipedia.htm?st=Internet_Protocol" class="WikiBoard" target="WIKI" title="(IP) Internet Protocol Information by Wikipedia, The Free Encyclopedia"><div class="Internet-Website-Domain-Name-1">Internet Protocol</div><div class="Internet-Website-Domain-Name-2"><img src="/web_design_imagery/spacer.gif" width="240" height="18" border="0"></div><div class="Internet-Website-Domain-Name-3">IP defines the format of packets and an addressing system with the function of identifying hosts and providing logical location services.</div><div class="Internet-Website-Domain-Name-4"><img src="/web_design_imagery/spacer.gif" width="240" height="12" border="0"></div><div class="Internet-Website-Domain-Name-5" align="right">more info regarding: "<span class="Internet-Website-Domain-Name-5dark">IP</span>"<img src="/web_design_imagery/graphical-user-interface-arrow1.gif" width="7" height="16" style="margin-left:4px;"></div></a></td>
	</tr>
</table>
</div>
<div id="documentBodyContent">
<div style="height:60px;width:920px;"><img src="/web_design_imagery/spacer.gif" width="920" height="20" border="0"></div>
<table width="920" cellpadding="0" cellspacing="0" border="0" class="nobord">
	<tr>
		<td class="nobord" align="center"><div id="AD5" style="<?php echo $Advertisement5x1style; ?>"><?php echo $Advertisement5x1; ?></div><div class="advertisement" style="width:<?php echo $Advertisement5x1w; ?>px;height:10px;padding-top:2px;"><?php echo $Advertisement5x1title; ?></div></td>
	</tr>
	<tr>
		<td class="nobord" align="center" style="padding-top:50px;"><div class="FooterSponsorInfo">The <a href="<?php echo $sectionLINK; ?>" title="<?php echo $bgSpacerALT; ?>" style="color:#266899;"><?php echo $bgSectionTITLE; ?></a> is made possible by the following sponsors and content providers:</div></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="FooterSponsorBar">
	<tr class="nobord">

		<td width="50%" class="nobord"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td>
		<td align="center" class="nobord"><div id="AD6-F1" class="FooterSponsorItem" style="<?php echo $Advertisement6x1style; ?>"><?php echo $Advertisement6x1; ?></div></td>
		<td align="center" class="nobord"><div id="AD6-F2" class="FooterSponsorItem" style="<?php echo $Advertisement6x2style; ?>"><?php echo $Advertisement6x2; ?></div></td>
		<td align="center" class="nobord"><div id="AD6-F3" class="FooterSponsorItem" style="<?php echo $Advertisement6x3style; ?>"><?php echo $Advertisement6x3; ?></div></td>
		<td align="center" class="nobord"><div id="AD6-F4" class="FooterSponsorItem" style="<?php echo $Advertisement6x4style; ?>"><?php echo $Advertisement6x4; ?></td>
		<td align="center" class="nobord"><div id="AD6-F5" class="FooterSponsorItem" style="width:160px;height:105px;"><a href="http://www.wikimedia.org/" title="Wikimedia - Operates Some of the Largest Collaboratively Edited Reference Projects" target="Wikimedia" style="color:#000000;"><div style="padding-bottom:12px;"><img src="/web_design_imagery/TechnicalResources_Wikimedia.gif" width="116" height="36" border="0" alt="Wikimedia - Operates Some of the Largest Collaboratively Edited Reference Projects"></div>Referencing</a></div></td>
		<td width="50%" class="nobord"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td>
	</tr>
</table>
<table width="920" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="50%"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td>
		<td align="center"><div class="FooterLogo">&copy; 2000 - 2010 VPSNET - <a rel="/Contact-Website-Design-Internet-Development-Experts/?s=&amp;ss=" title="Questions about web design, website templates, custom design, intuitive website design, website package or any other information technology related topic? Contact our friendly and knowledgable staff." onclick="javascript:runFancyFrame(this);" style="color:#266899;cursor:pointer;">Contact</a><br><a href="http://<?php echo $ServerName; ?>/about" title="Site is copyright Virtual Private Servers & Networks [VPSNET]" style="color:#000000;"><img src="/web_design_imagery/Virtual_Private_footer_logo.gif" width="175" height="37" border="0" alt="Site is copyright Virtual Private Servers & Networks [VPSNET]"></a></div></td>
		<td width="50%"><div style="width:1px;height:1px;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="1" height="1" border="0"></div></td>
	</tr>
</table>
</div>
<div class="hidden" style="display:none;" id="WHOIS_Who_Is_Lookup_Com_Domain_1"><div id="DomainSearchPM1" class="WHOIS_Who_Is_Lookup_Com_Domain_Submitted"><span style="position:absolute;top:3px;right:10px;font-size:9px;font-family:arial,tahoma,helvetica;"><a href="javascript:hideAd();" title="Hide Advertisement">hide ad</a></span><div id="WHOIS_Who_Is_Lookup_Com_Domain_Inner1" class="WHOIS_Who_Is_Lookup_Com_Domain_Inner"><?php echo $AdvertisementPAIRx1; ?><span style="position:absolute;bottom:18px;right:7px;font-size:9px;font-family:arial,tahoma,helvetica;"><?php echo $AdvertisementPAIRx1title; ?></span></div></div></div>
</center>
</div>










</body>
</html>