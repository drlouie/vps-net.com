<?php

################################################################
#   Program:    Domain Name Search and Registration            #
#   Author:     Luis Gustavo Rodriguez (drlouie)               #
#   Copyright:  (c) 2009 Luis G. Rodriguez                     #
#   Licensing:  MIT License                                    #
#   About                                                      #
#        Type:  Domain Name search, save and registration app  #
#        For:   Godaddy, 1and1, domain.com                     #
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

#-- vps-net.com > Domain Name Search Tools > Domain Registration

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
	$subsection = 2;
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
.Domain-Name-Search-And-Registration {
	border:#FAFAFA 1px solid;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
}

.Internet-Website-Domain-Name-1 { font-family:Tahoma, Arial, Helvetica; font-size:16px; font-weight:bold; padding-left:10px; padding-top:5px; width:240px; height:18px; }
.Internet-Website-Domain-Name-2 { width:240px; height:18px; background:url(/web_design_imagery/interface-design-linear1.gif) no-repeat 0 10px; }
.Internet-Website-Domain-Name-3 { padding-left:10px; line-height:20px; width:228px;font-family:tahoma,arial,verdana;font-size:14px;}
.Internet-Website-Domain-Name-4 { width:240px; height:12px; background:url(/web_design_imagery/interface-design-linear1.gif) no-repeat 0 10px; }
.Internet-Website-Domain-Name-5 a{ padding-right:15px; width:240px;height:16px;font-family:tahoma,arial,verdana;font-size:10px;color:#B0B0B0; }
.Internet-Website-Domain-Name-5 a:hover { width:240px;height:14px;font-family:tahoma,arial,verdana;font-size:10px; text-decoration:none; }
.Internet-Website-Domain-Name-5dark { width:240px;height:16px;font-family:tahoma,arial,verdana;font-size:10px; text-decoration:underline; }
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
textarea.Internet-Website-Domain-Name-Textarea { width:550px; height:180px; font-family:Courier New,monospace,serif;font-size:12px; }
#Internet-Website-Domain-Name-Textarea { margin-left:25px; margin-bottom:10px; }
input.Internet-Website-Domain-Name-Buttons { height:24px; font-family:Verdana,Arial,Helvetica; font-size:12px; }
#Internet-Website-Domain-Name-Buttons { margin-right:30px; margin-bottom:12px; }
#Internet-Website-Domain-Name-CodeRequest { margin-left:21px; margin-bottom:10px; } 

textarea.HTML-O-Feedback { width:256px;height:85px; font-family:Courier New,monospace,serif;font-size:12px; }

#Whois-IP-Address-Domain-Name-Search-Lookup-title { text-align: left; }
#Whois-IP-Address-Domain-Name-Search-Lookup-title b { display: block; margin-right: 80px; }
#Whois-IP-Address-Domain-Name-Search-Lookup-title span { float: right; }




#Search-Domain-Names-IP-Address-Lookup form {
	margin: 0;
	padding: 0;
	display: block;
}
#Search-Domain-Names-IP-Address-Lookup *:focus {
	outline: none;
}

#Search-Domain-Names-IP-Address-Lookup{
	padding:18px 0 0 36px;
	position: relative;
	font: normal 12px/16px Arial, sans-serif;
	color: #111;
	list-style:none;
	margin:0;
}

#Search-Domain-Names-IP-Address-Lookup li{
    height: auto;
    position: relative;
}

#Search-Domain-Names-IP-Address-Lookup li .text {
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
#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap{
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
#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap textarea {
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

#Search-Domain-Names-IP-Address-Lookup li#submit input {
	position:relative;
	left:20px;
	top:10px;
	float:left;
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
	margin-bottom:18px;
}
#Search-Domain-Names-IP-Address-Lookup .bbl_buttons a:hover, #Search-Domain-Names-IP-Address-Lookup li#submit input:hover {
	 background-color: #111; 
	 color: #fff;
}
#Search-Domain-Names-IP-Address-Lookup .bbl_buttons a:active {
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
.domain-name-search-error {background: url(/web_design_imagery/website_design_communications/domain-name-error.png) no-repeat 6px 5px; }
.domain-name-search-available {background: url(/web_design_imagery/website_design_communications/domain-name-available.png) no-repeat 6px 5px; }
.domain-name-search-taken {background: url(/web_design_imagery/website_design_communications/domain-name-taken.png) no-repeat 6px 5px; }
.domain-name-search-saved {background: url(/web_design_imagery/website_design_communications/domain-name-saved.png) no-repeat 6px 5px; }



.DomainSearchPromptSubmitted, .DomainSearchInformation {
	visibility:visible;
	display:block;
	background:url(/website_design_template_images/website-transparent-background-effects-white.png);
	font-size: 12px; font-family:Tahoma, Arial, Helvetica; color:#333333; 
	width:340px; 
	margin-bottom:15px; 
	overflow:hidden; 
}
.DomainSearchPromptInner { text-align:left; padding:6px; padding-left:10px;padding-top:7px;line-height:12px;}
.DomainSearchPromptSubmitted, .DomainSearchInformation {
	border:#EEF0F5 1px solid;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
}
.DomainSearchPromptSubmitted {
	box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
	-moz-box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
	-webkit-box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
}
.DomainSearchInformation {
	text-shadow: 0px 3px 1px rgba(200,200,200,0.13);
}
.hidden { width:0px; height:0px; overflow:hidden; clip:rect(0px,0px,0px,0px); visibility:hidden; }

.domain-extension-support {
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
	padding:1px 4px 2px 4px;
	/* margin:2px 0 0 3px; */
	margin: 7px 0px 0px 4px;
	cursor:pointer;
}
.domain-extension-support span {
	color:#C0C0C0;
	letter-spacing:2px;
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
var runDomainSearch = function(acual) {
	searchActivity = $('#Search-Domain-Names-IP-Address-Lookup .text');
	if (document["domain-name-search-form"]["domain-search"].value.indexOf('mydomain.com') != -1) { return true; }
	else {
	if (lookupText == '') { lookupText = searchActivity.html();  lookupAct = $('#submit').html(); }
	searchActivity.html('<span style="position:relative;top:0px;left:0px;" title="Searching..."><img src="/web_design_imagery/loadCircle.gif" width="18" height="15" border="0" alt="Searching..." style="padding-right:10px;"></span>');
	$('#submit').html('<input type="reset" value="Try Another Search" onClick="javascript:reSearch();" style="background-color:#111;">');
	//alert(document["domain-name-search-form"]["domain-search"].value);
	var lUrl = '/domain-registration-search/find-my-domain.htm?d='+document["domain-name-search-form"]["domain-search"].value+'';
	var callback = {
		success: function(o) {
			if(o.responseText !== undefined) {
				if (o.responseText.indexOf('Taken') != -1) {
					searchActivity.fadeTo('fast','0.00',function() {
						$(this).html('<div id="domain-name-search" class="domain-name-search-taken">'+o.responseText+':</div>');
						$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap textarea').css('text-indent',''+(searchActivity.width()+20)+'px');
						$(this).fadeTo('slow','1.00');
						$('#submit input').focus();
					});
				}
				else if (o.responseText.indexOf('Available') != -1) {
					searchActivity.fadeTo('fast','0.00',function() {
						$(this).html('<div id="domain-name-search" class="domain-name-search-available">'+o.responseText+':</div>');
						$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap textarea').css('text-indent',''+(searchActivity.width()+20)+'px');
						$(this).fadeTo('slow','1.00');
						$('#submit').html('<input type="button" value="Save This Domain" onClick="javascript:saveMyDomainName();" style="background-color:#E89520;">');
						$('#submit input').focus();
					});
				}
				else {
					searchActivity.fadeTo('fast','0.00',function() {
						if (o.responseText.indexOf('Invalid characters') != -1 || o.responseText.indexOf('Undefined extension') != -1 || o.responseText.indexOf('Invalid extension') != -1) {
							$(this).html('<div id="domain-name-search" class="domain-name-search-error">'+o.responseText+'</div>');
						}
						else {
							$(this).html('<div id="domain-name-search" class="domain-name-search-error">Try again!</div>');
						}
						$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap textarea').css('text-indent',''+(searchActivity.width()+20)+'px');
						$(this).fadeTo('slow','1.00');
						$('#submit input').focus();
					});
				}
			}
		},
		failure: function(o) {
			searchActivity.fadeTo('fast','0.00',function() {
				$(this).html('<div id="domain-name-search" class="domain-name-search-error">Try again!</div>');
				$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap textarea').css('text-indent',''+(searchActivity.width()+20)+'px');
				$(this).fadeTo('slow','1.00');
				$('#submit input').focus();
			});
		}
	};
	var transaction = YAHOO.util.Connect.asyncRequest("GET", lUrl, callback, null);
	return false;
	}
}
var countCPM = 1;
var reSearch = function() {
	if (lookupText != '') {
		if (countCPM == 5) {
			$('#Search-Domain-Names-IP-Address-Lookup .text').html('<div id="domain-name-search" class="domain-name-search-error">Save limit reached:</div>');
			$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap textarea').css('text-indent',''+(searchActivity.width()+20)+'px');
			$('#submit').html('');
			document["domain-name-search-form"]["domain-search"].value = 'Maximum five(5) domain names';
			document["domain-name-search-form"]["domain-search"].disabled = 1;
		}
		else {
			$('#Search-Domain-Names-IP-Address-Lookup .text').html(lookupText);
			$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap textarea').css('text-indent','80px');
			$('#submit').html(lookupAct);
			document["domain-name-search-form"]["domain-search"].value = '';
		}
		document["domain-name-search-form"]["domain-search"].focus();
	}
};

var saveMyDomainName = function() {
	searchActivity.html('<span style="position:relative;top:0px;left:0px;" title="Saving..."><img src="/web_design_imagery/loadCircle.gif" width="18" height="15" border="0" alt="Saving..." style="padding-right:10px;"></span>');
	$('#submit').html('<input type="button" value="Saving Your Domain" style="background-color:#E89520;">');

	var lUrl = '/domain-registration-search/find-my-domain.htm?s='+document["domain-name-search-form"]["domain-search"].value+'';
	var callback = {
		success: function(o) {
			if(o.responseText !== undefined) {
				if (o.responseText == document["domain-name-search-form"]["domain-search"].value || o.responseText == 'You previously saved:') {
					searchActivity.fadeTo('fast','0.00',function() {
						// only add to tally if truly new domain
						if (o.responseText == document["domain-name-search-form"]["domain-search"].value) { SavedDomains++; }
						$('#submit').html('<input type="button" value="Domain Was Saved!" style="background-color:#E89520;">');
						$(this).html('<div id="domain-name-search" class="domain-name-search-saved">Saved!</div>');
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
		var Dom = YAHOO.util.Dom;
		var cpContents = Dom.get("PromptSpace");
		if (jQuery.browser.msie) {
			$('.DomainSearchPromptInner').css('border','0').css('background','none');
			$('#DomainSearchPM1').css('border','0').css('background','none');
			$('#DomainSearchPM2').css('border','0').css('background','none');
			$('#DomainSearchPM3').css('border','0').css('background','none');
			$('#DomainSearchPM4').css('border','0').css('background','none');
			$('#DomainSearchPM5').css('border','0').css('background','none');
		}


		if (countCPM == 5) {
			var DDomainSearchPrompt5 = Dom.get("DomainSearchPrompt5"); 
			var DomainSearchPromptInner5 = Dom.get("DomainSearchPromptInner5");
			var dcp5 = document.createElement("div");
   			dcp5.timeout = setTimeout(function(){ 
				DomainSearchPromptInner5.innerHTML = cuales;
				DC5 = "DomainSearchPM"+countCPM+"";
				dcp5 = DDomainSearchPrompt5.firstChild;
				cpContents.appendChild(dcp5);
				divBlink(''+DC5+'',5);
				countCPM++;
	   		}, 1);
			window.timeout = setTimeout(function(){ 
				$('#DomainSearchPM5').hide('slow',function(){
					cpContents.removeChild(dcp5);
				});
		    }, 10000);
		}
		else if (countCPM == 4) {
			var DDomainSearchPrompt4 = Dom.get("DomainSearchPrompt4"); 
			var DomainSearchPromptInner4 = Dom.get("DomainSearchPromptInner4");
			var dcp4 = document.createElement("div");
   			dcp4.timeout = setTimeout(function(){ 
				DomainSearchPromptInner4.innerHTML = cuales;
				DC4 = "DomainSearchPM"+countCPM+"";
				dcp4 = DDomainSearchPrompt4.firstChild;
				cpContents.appendChild(dcp4);
				divBlink(''+DC4+'',5);
				countCPM++;
	   		}, 1);
			window.timeout = setTimeout(function(){ 
				$('#DomainSearchPM4').hide('slow',function(){
					cpContents.removeChild(dcp4);
				});
		    }, 10000);
		}
		else if (countCPM == 3) {
			var DDomainSearchPrompt3 = Dom.get("DomainSearchPrompt3"); 
			var DomainSearchPromptInner3 = Dom.get("DomainSearchPromptInner3");
			var dcp3 = document.createElement("div");
   			dcp3.timeout = setTimeout(function(){ 
				DomainSearchPromptInner3.innerHTML = cuales;
				DC3 = "DomainSearchPM"+countCPM+"";
				dcp3 = DDomainSearchPrompt3.firstChild;
				cpContents.appendChild(dcp3);
				divBlink(''+DC3+'',5);
				countCPM++;
	   		}, 1);
			window.timeout = setTimeout(function(){ 
				$('#DomainSearchPM3').hide('slow',function(){
					cpContents.removeChild(dcp3);
				});
		    }, 10000);
		}
		else if (countCPM == 2) {
			var DDomainSearchPrompt2 = Dom.get("DomainSearchPrompt2");
			var DomainSearchPromptInner2 = Dom.get("DomainSearchPromptInner2");
			var dcp2 = document.createElement("div");
   			dcp2.timeout = setTimeout(function(){ 
				DomainSearchPromptInner2.innerHTML = cuales;
				DC2 = "DomainSearchPM"+countCPM+"";
				dcp2 = DDomainSearchPrompt2.firstChild;
				cpContents.appendChild(dcp2);
				divBlink(''+DC2+'',5);
				countCPM++;
	   		}, 1);
			window.timeout = setTimeout(function(){ 
				$('#DomainSearchPM2').hide('slow',function(){
					cpContents.removeChild(dcp2);
				});
		    }, 10000);
		}
		else {
			var DDomainSearchPrompt1 = Dom.get("DomainSearchPrompt1");
			var DomainSearchPromptInner1 = Dom.get("DomainSearchPromptInner1");
			var dcp1 = document.createElement("div");
    		dcp1.timeout = setTimeout(function(){ 
				DomainSearchPromptInner1.innerHTML = cuales;
				DC1 = "DomainSearchPM"+countCPM+"";
				dcp1 = DDomainSearchPrompt1.firstChild;
				cpContents.appendChild(dcp1);
				divBlink(''+DC1+'',5);
				countCPM++;
		    }, 1);
			window.timeout = setTimeout(function(){ 
				$('#DomainSearchPM1').hide('slow',function(){
					cpContents.removeChild(dcp1);
				});
		    }, 10000);


		}



		// yummy, thanks jquery ;)
		swapDomainState();


			$("#gui-register-a-domain").animate({ width: "134px" }, {queue: false});
			$("#gui-register-a-domain-text").animate({ width: "113px" }, {queue: false});
			$("#gui-design-your-website").animate({ width: "21px" }, {queue: false});
			$("#gui-design-your-website-text").animate({ width: "0px" }, {queue: false});


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

$(document).ready(function() {
	//$("#domain-extension-support").find('li').CreateBubblePopup( BPoptions3 ).each(function(){
	$("#domain-extension-support").find('li').each(function(){
		var tti = $(this).attr('title');
		$(this).attr('id',tti);
		// $(this).SetBubblePopupInnerHtml( '<div class="MoreInfo-panelBarWIKIitem-WikiBoard" style="padding:1px 4px 1px 4px;font-size:11px;font-family:verdana,arial,helvetica;line-height:15px;color:#444;">'+ tti +'</div>');
		//$(this).removeAttr( 'title' );
		$(this).click(function(e){ 
			if (tti == '.com.au' || tti == '.net.au' || tti == '.org.au') { tti = '.au'; }
			if (tti == '.com.ag' || tti == '.net.ag' || tti == '.org.ag') { tti = '.ag'; }
			if (tti == '.com.br' || tti == '.net.br') { tti = '.br'; }
			if (tti == '.com.bz' || tti == '.net.bz') { tti = '.bz'; }
			if (tti == '.com.co' || tti == '.net.co' || tti == '.nom.co') { tti = '.co'; }
			if (tti == '.com.es' || tti == '.nom.es' || tti == '.org.es') { tti = '.es'; }
			if (tti == '.co.in' || tti == '.firm.in' || tti == '.gen.in' || tti == '.ind.in' || tti == '.net.in' || tti == '.org.in') { tti = '.in'; }
			if (tti == '.com.mx') { tti = '.mx'; }
			if (tti == '.co.nz' || tti == '.net.nz' || tti == '.org.nz') { tti = '.nz'; }
			if (tti == '.com.tw' || tti == '.idv.tw' || tti == '.org.tw') { tti = '.tw'; }
			if (tti == '.co.uk' || tti == '.org.uk') { tti = '.uk'; }
			$.fancybox(wikifancy);
			$("#fancybox-frame").attr("src",'/wikipedia.htm?st='+tti+'');
		});
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
</script>
<table width="920" cellpadding="0" cellspacing="0" border="0" class="nobord">
	<tr class="nobord">
		<td class="nobord" valign="top" align="center" width="100%">
		<div style="height:146px;max-height:164px;padding-top:96px;position:relative;">
			<div id="Find-Your-Domain">Find a domain name to register as your own:</div>
			<div class="Domain-Name-Search-And-Registration" style="background:url(/website_design_template_images/website-transparent-background-effects-heavy.png);width:800px;height:92px;">
				<div class="domain-name-search" style="position:relative;">
					<form method="post" name="domain-name-search-form" class="domain-name-search-form" onSubmit="return runDomainSearch(this);">
					<ul id="Search-Domain-Names-IP-Address-Lookup">
						<li id="message">
							<span class="text">www.</span>
							<span id="pa-rappa-the-rappa"><span class="domain-name-search-form-control-wrap"><textarea name="domain-search" id="domain-search" cols="40" rows="10" onFocus="javascript:if(this.value=='mydomain.com') { this.value=''; } $(this).css('background-color','#FCFCFC').css('color','#111'); $('#pa-rappa-the-rappa').css('border-color','#EFEFEF');" onBlur="javascript:if(this.value==''||this.value==' '||this.value.length <= 3||this.value=='mydomain.com') { this.value='mydomain.com'; $(this).css('color','#ACACAC'); } $(this).css('background-color','#FFFFFF'); $('#pa-rappa-the-rappa').css('border-color','#FAFAFA');">mydomain.com</textarea></span></span>
						</li>
						<li id="submit"><input type="submit" value="Find Your Domain"></li>
					</ul>
					</form>
				</div>
			</div>
			<div id="PromptSpace" style="position:absolute;bottom:126px;left:490px;min-width:340px;max-width:400px;"></div>
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
<div class="DomainSearchExtensions domain-extension-support" style="background:none;float:left;clear:right;margin-bottom:10px;"><span class="Country-Code-Top-Level-Domain-Name-Extensions" title="&lt;b&gt;ccTLD (Country-Code Top-Level Domain) Extensions&lt;/b&gt;&lt;br&gt;&lt;br&gt;Country code top-level domain extensions our search supports are listed below for your convenience. For instance: .com .co .info .net .org etc. Therefore, if the extension is unlisted, it is unsupported by our domain search.&lt;br&gt;&lt;br&gt;Click now to learn more about Country-Code Top-Level Domains(ccTLDs) using Wikipedia.&lt;br&gt;&lt;br&gt;Furthermore, if you want to learn detailed information regarding any specific top level domain name extension listed below, you can do so as well, just by clicking it." style="border:0;background:0;"><a href="/wikipedia.htm?st=Country_code_top-level_domain" class="WikiBoard" target="WIKI" title="Domain name extensions supported by our domain search are listed below. Want more information about Country-Code Top-Level Domains(ccTLDs)? Click now to learn more, and once you're done there if you want to learn even more: You can also click any of the extensions listed below to learn more about the origin, country association and other pertinent information regarding that domain name extension." style="color:#266899;font-style:italic;text-decoration:none;">We support the Domain Name Extensions listed below:</a></span></div>
<div class="DomainSearchExtensions" style="background:none;float:left;clear:right;margin-bottom:40px;"><i><ul id="domain-extension-support" class="domain-extension-support"><li title=".com">.com</li><li title=".co">.co</li><li title=".info">.info</li><li title=".net">.net</li><li title=".org">.org</li><li title=".me">.me</li><li title=".mobi">.mobi</li><li title=".us">.us</li><li title=".biz">.biz</li><li title=".tv">.tv</li><li title=".ca">.ca</li><li title=".com.au">.com.au</li><li title=".net.au">.net.au</li><li title=".org.au">.org.au</li><li title=".mx">.mx</li><li title=".ws">.ws</li><li title=".ag">.ag</li><li title=".com.ag">.com.ag</li><li title=".net.ag">.net.ag</li><li title=".org.ag">.org.ag</li><li title=".am">.am</li><li title=".asia">.asia</li><li title=".at">.at</li><li title=".be">.be</li><li title=".com.br">.com.br</li><li title=".net.br">.net.br</li><li title=".com.bz">.com.bz</li><li title=".net.bz">.net.bz</li><li title=".cc">.cc</li><li title=".com.co">.com.co</li><li title=".net.co">.net.co</li><li title=".nom.co">.nom.co</li><li title=".de">.de</li><li title=".es">.es</li><li title=".com.es">.com.es</li><li title=".nom.es">.nom.es</li><li title=".org.es">.org.es</li><li title=".eu">.eu</li><li title=".fm">.fm</li><li title=".fr">.fr</li><li title=".gs">.gs</li><li title=".in">.in</li><li title=".co.in">.co.in</li><li title=".firm.in">.firm.in</li><li title=".gen.in">.gen.in</li><li title=".ind.in">.ind.in</li><li title=".net.in">.net.in</li><li title=".org.in">.org.in</li><li title=".it">.it</li><li title=".jobs">.jobs</li><li title=".jp">.jp</li><li title=".ms">.ms</li><li title=".com.mx">.com.mx</li><li title=".nl">.nl</li><li title=".co.nz">.co.nz</li><li title=".net.nz">.net.nz</li><li title=".org.nz">.org.nz</li><li title=".se">.se</li><li title=".tk">.tk</li><li title=".tw">.tw</li><li title=".com.tw">.com.tw</li><li title=".idv.tw">.idv.tw</li><li title=".org.tw">.org.tw</li><li title=".co.uk">.co.uk</li><li title=".me.uk">.me.uk</li><li title=".org.uk">.org.uk</li><li title=".vg">.vg</li></ul></i></div>
		</td>
	</tr>
</table>
</div>
<table width="820" cellpadding="0" cellspacing="0" border="0" class="nobord">
	<tr class="nobord" valign="top">
		<td class="nobord hoverpanels" width="240" align="left"><a href="/wikipedia.htm?st=Domain_registration" class="WikiBoard" target="WIKI" title="Domain Registration Information by Wikipedia, The Free Encyclopedia"><div class="Internet-Website-Domain-Name-1">Domain Registration</div><div class="Internet-Website-Domain-Name-2"><img src="/web_design_imagery/spacer.gif" width="240" height="18" border="0"></div><div class="Internet-Website-Domain-Name-3">Domain registration is the process of acquiring a domain name from a domain name registrar, which then must be assigned DNS authority.</div><div class="Internet-Website-Domain-Name-4"><img src="/web_design_imagery/spacer.gif" border="0" width="240" height="12" border="0"></div><div class="Internet-Website-Domain-Name-5" align="right">more info regarding: "<span class="Internet-Website-Domain-Name-5dark">Domain Registration</span>"<img src="/web_design_imagery/graphical-user-interface-arrow1.gif" width="7" height="16" border="0" style="margin-left:4px;"></div></a></td>
		<td class="nobord" width="50"><div class="Internet-Website-Domain-Name-Nocont"><img src="/web_design_imagery/spacer.gif" width="50" height="1" border="0"></div></td>
		<td class="nobord hoverpanels" width="240" align="left"><a href="/wikipedia.htm?st=DNS_hosting_service" class="WikiBoard" target="WIKI" title="DNS Hosting Information by Wikipedia, The Free Encyclopedia"><div class="Internet-Website-Domain-Name-1">Domain Name Hosting</div><div class="Internet-Website-Domain-Name-2"><img src="/web_design_imagery/spacer.gif" width="240" height="18" border="0"></div><div class="Internet-Website-Domain-Name-3">Registration of a domain does not automatically imply the provision of DNS services for the registered domain.</div><div class="Internet-Website-Domain-Name-4"><img src="/web_design_imagery/spacer.gif" width="240" height="12" border="0"></div><div class="Internet-Website-Domain-Name-5" align="right">more info regarding: "<span class="Internet-Website-Domain-Name-5dark">DNS Hosting</span>"<img src="/web_design_imagery/graphical-user-interface-arrow1.gif" width="7" height="16" style="margin-left:4px;"></div></a></td>
		<td class="nobord" width="50"><div class="Internet-Website-Domain-Name-Nocont"><img src="/web_design_imagery/spacer.gif" width="50" height="1" border="0"></div></td>
		<td class="nobord hoverpanels" width="240" align="left"><a href="/wikipedia.htm?st=Domain_name_registrar" class="WikiBoard" target="WIKI" title="Domain Name Registrar Information by Wikipedia, The Free Encyclopedia"><div class="Internet-Website-Domain-Name-1">Domain Name Registrars</div><div class="Internet-Website-Domain-Name-2"><img src="/web_design_imagery/spacer.gif" width="240" height="18" border="0"></div><div class="Internet-Website-Domain-Name-3">Registrars must be accredited by a generic top-level domain (gTLD) registry and/or a country code top-level domain (ccTLD) registry.</div><div class="Internet-Website-Domain-Name-4"><img src="/web_design_imagery/spacer.gif" width="240" height="12" border="0"></div><div class="Internet-Website-Domain-Name-5" align="right">more about: "<span class="Internet-Website-Domain-Name-5dark">Domain Name Registrar</span>"<img src="/web_design_imagery/graphical-user-interface-arrow1.gif" width="7" height="16" style="margin-left:4px;"></div></a></td>
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
<div class="hidden" id="DomainSearchPrompt1"><div id="DomainSearchPM1" class="DomainSearchPromptSubmitted"><div id="DomainSearchPromptInner1" class="DomainSearchPromptInner"></div></div></div>
<div class="hidden" id="DomainSearchPrompt2"><div id="DomainSearchPM2" class="DomainSearchPromptSubmitted"><div id="DomainSearchPromptInner2" class="DomainSearchPromptInner"></div></div></div>
<div class="hidden" id="DomainSearchPrompt3"><div id="DomainSearchPM3" class="DomainSearchPromptSubmitted"><div id="DomainSearchPromptInner3" class="DomainSearchPromptInner"></div></div></div>
<div class="hidden" id="DomainSearchPrompt4"><div id="DomainSearchPM4" class="DomainSearchPromptSubmitted"><div id="DomainSearchPromptInner4" class="DomainSearchPromptInner"></div></div></div>
<div class="hidden" id="DomainSearchPrompt5"><div id="DomainSearchPM5" class="DomainSearchPromptSubmitted"><div id="DomainSearchPromptInner5" class="DomainSearchPromptInner"></div></div></div>
</center>
</div>










</body>
</html>