<?php

################################################################
#   Program:    Core Website Functionality and Templater       #
#   Author:     Luis Gustavo Rodriguez (drlouie)               #
#   Copyright:  (c) 2016 Luis G. Rodriguez                     #
#   Licensing:  MIT License                                    #
#   About                                                      #
#        Type:  Most features on the website rely or require   #
#               this PHP script. It serves many essential      #
#               duties such as JavaScript obfuscation and web  #
#               document construction.                         #
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

/**
 * UI-Templating System
 *
 * @author       L Rodriguez <drlouie@louierd.com>
 * @domain		LouieRd.com
 *
 * [TRASH HAS ISSUES WHEN REFRESHING DD: refreshDD()]
*/


/* 
	WHEN REGENERATING OBFUSCATED :
	DDCarouselHeadScript remember to reset cualOCv and OCvVER javascript variables in the OBFUSCATED version to the following:
	var cualOCv='OCv%%ELOCV%%';
	var OCvVER='%%ELOCV%%';

	CarouselHeadScript %%
	ALL %%x%% EXCEPT FOR %%FAV%% %%TRA%%
*/

##- 2017
## import_request_variables deprecated in PHP 5.3
## import_request_variables("gp", "rvar_");
## rewritten from $rvar_q to $q, $rvar_p to $p, $rvar_a to $a
$q = isset($_GET['q']) ? $_GET['q'] : '';
$p = isset($_GET['p']) ? $_GET['p'] : '';
$a = isset($_GET['a']) ? $_GET['a'] : '';

error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );

$headStyleCSS = '';
$ServerName = $_SERVER['SERVER_NAME'];
if (!empty($q)) {
	if (!empty($p)) {
		if ($p == 'CHCSS') {
			header('Content-type: text/css');
			$myKickback = CommonHeadCSS();

			// make cross-domain compatible [kill for testing - this only for production]
			$myKickback = str_replace('/web_design_imagery/','https://vps-net.com/web_design_imagery/',$myKickback);
		}
		else if ($p == 'CHS') {
			header('Content-type: text/javascript');
			$myKickback = CommonHeadScript();
			
			// make cross-domain compatible [kill for testing - this only for production]
			$myKickback = str_replace('/web_design_imagery/','https://vps-net.com/web_design_imagery/',$myKickback);
		}
		else if ($p == 'AHCSS') {
			header('Content-type: text/css');
			$myKickback = AmazonAdHeadCSS();
		}
		else if ($p == 'DOMAppScript') {
			header('Content-type: text/css');
			$myKickback = DOMAppScript();
		}
		else if ($p == 'FBHCSS') {
			header('Content-type: text/css');
			$myKickback = FancyBoxHeadCSS();
		}
		else if ($p == 'AHS') {
			header('Content-type: text/javascript');
			$myKickback = AmazonAdHeadScript();
			// cross-domain compatible, remove / so their client always looks at local directory
			if (!empty($a)) {
				// set this up to where it is user controlled via query string, so they can install wikipeeks any directory they want
				// as well as with whatever type of extention (pre-processor)
				//$myKickback = str_replace('/amazon-advertisements.htm','/wikipeeks-books.htm',$myKickback);
			}
		}
		else if ($p == 'FCHS') {
			header('Content-type: text/javascript');
			$myKickback = FreeCaptchaHeadScript();
		}
		else if ($p == 'FBHS') {
			header('Content-type: text/javascript');
			$myKickback = FancyBoxHeadScript();
		}
		else if ($p == 'WPCHS') {
			header('Content-type: text/javascript');
			$myKickback = WikiPeeksCoreHeadScript();
		}
		else if ($p == 'WPWPHS') {
			header('Content-type: text/javascript');
			$myKickback = WikiPeeksWikipediaHeadScript();

			// make cross-domain compatible [kill for testing - this only for production]
			$myKickback = str_replace('(/web_design_imagery/','(https://vps-net.com/web_design_imagery/',$myKickback);
			$myKickback = str_replace('"/web_design_imagery/','"https://vps-net.com/web_design_imagery/',$myKickback);
		}
		else if ($p == 'WPCFS') {
			header('Content-type: text/javascript');
			$myKickback = WikiPeeksCoreFooterScript();
		}

		// make cross-domain compatible [kill for testing - this only for production]
		//$myKickback = str_replace('international-standard-book-number-lookup.htm','/international-standard-book-number-lookup.htm',$myKickback);

		echo $myKickback;
	}
}


function runDEV($swatch) {
	//--> this switches dev functions such as js obfuscation on/off
	// running as devtest simply means we force obfuscation on the local work file, to make sure everything working fine with obfucation on
	// to run with non-obf on an EXISTING non-obf file, simply switch this off[0] while testing [non-obf file must be present in invHTTP otherwise defaults to public obf version]
	// WITHOUT pushing IP script resorts to user-facing, non-dev STABLE version
	$devtest = 0;
	if ($swatch !== 'obf') { $myres = '75.82.241.12 127.0.0.1'; }
	else { $myres = $devtest; }
	return $myres;
}


function getROOT($cual) {
	$phpCompileOS = $_SERVER["SERVER_SOFTWARE"];
	if (stristr($phpCompileOS, 'WIN') !== FALSE) {
		if($cual !== 'inv') { $myROOT = 'H:/dvwf/rbsd_IO/vhosts/vsnet/htdocsNEW/'; }
		else { $myROOT = 'H:/dvwf/rbsd_IO/vhosts/vsnet/invisibleHTTP/'; }
	}
	else { 
		if($cual !== 'inv') { $myROOT = '/var/www/vps-net.com/htdocs/'; }
		else { $myROOT = '/var/www/vps-net.com/invisibleHTTP/'; }
	}
	return $myROOT;
}



function obfuscateJavascripts($af,$uf,$forScript) {
	$HTTPRoot = getROOT('http');
	$invHTTPRoot = getROOT('inv');
	$devip = runDEV('devip');
	$parseobf = runDEV('obf');
	$myIP = "".getenv("REMOTE_ADDR")."";
	$isIN = $_COOKIE["IN"];
	$af = $invHTTPRoot."".$af;
	$uf = $HTTPRoot."".$uf;

	// if hard-coded dev IP || logged in [dirty check]
	if (file_exists($af) && (stristr($devip, $myIP) !== FALSE || !empty($isIN))) {
		$myMMHeadScript = implode('', file($af));
		if ($parseobf !== 0) {
			// create array
			$tboObf = array();
			// $obfuscatables = Array("bodyBGWidth" => 'bulletin_board', "backieX" => 'cross_browser');
			$losToBeObf = explode("\n", $myMMHeadScript);

			$ctbq = 0;
			foreach ($losToBeObf as $unTBO) {
				##- locate obfucatables
				if (stristr($unTBO, "<OBF>") !== FALSE) { $startTBQ = $ctbq; }
				if (stristr($unTBO, "</OBF>") !== FALSE) { $endTBQ = $ctbq; }
				$ctbq++;
			}
			$ctbq2 = 0;
			foreach ($losToBeObf as $unTBO) {
				##- process all obfucatables
				##- each obfuscatable line contains: ( = ) and (// ) and nothing else
				##- anything else (/**/) is throw-away
				if ($ctbq2 > $startTBQ && $ctbq2 < $endTBQ) {
					if (stristr($unTBO, "// ") !== FALSE && stristr($unTBO, ' = ') !== FALSE) {
						$unTBO = str_replace("// ", '', $unTBO);
						$unTBO = str_replace(" = ", '-----', $unTBO);
    					array_push($tboObf, $unTBO);
					}
				}
				else if ($ctbq2 > $endTBQ) {
					##- line comments (//) are removed, multi-line comments (/**/) are shown to user
					if (stristr($unTBO, "//") === FALSE) { $newTBQ = $newTBQ .''. $unTBO; }
				}
				$ctbq2++;
			}

			$newTBQ = str_replace("\t", '', $newTBQ);
			$newTBQ = str_replace(" =", '=', $newTBQ);
			$newTBQ = str_replace("= ", '=', $newTBQ);
			$newTBQ = str_replace(" !=", '!=', $newTBQ);
			$newTBQ = str_replace("+ ", '+', $newTBQ);
			$newTBQ = str_replace(" +", '+', $newTBQ);
			$newTBQ = str_replace(", ", ',', $newTBQ);
			$newTBQ = str_replace("- ", '-', $newTBQ);
			$newTBQ = str_replace(" -", '-', $newTBQ);
			$newTBQ = str_replace(" {", '{', $newTBQ);
			$newTBQ = str_replace("{ ", '{', $newTBQ);
			$newTBQ = str_replace(" }", '}', $newTBQ);
			$newTBQ = str_replace("} ", '}', $newTBQ);
			#- double pipe
			$newTBQ = str_replace(" || ", '||', $newTBQ);
			$newTBQ = str_replace(" == ", '==', $newTBQ);
			$newTBQ = str_replace("if (", 'if(', $newTBQ);
			$newTBQ = str_replace(" < ", '<', $newTBQ);
			$newTBQ = str_replace(" > ", '>', $newTBQ);
			$newTBQ = str_replace(" <=", '<=', $newTBQ);
			$newTBQ = str_replace(" >=", '>=', $newTBQ);
			$newTBQ = str_replace(" != ", '!=', $newTBQ);
			$newTBQ = str_replace(" && ", '&&', $newTBQ);
			$newTBQ = str_replace(" && ", '&&', $newTBQ);
			$newTBQ = str_replace(": ", ':', $newTBQ);
			$newTBQ = str_replace(" :", ':', $newTBQ);
			$newTBQ = str_replace("; ", ';', $newTBQ);

			##- run variable obfuscation
			foreach ($tboObf as $obfTBQ) {
				$obfEX = explode('-----', $obfTBQ);
				$obfEX[0] = trim($obfEX[0]);
				$obfEX[1] = trim($obfEX[1]);
				$newTBQ = str_replace($obfEX[0],$obfEX[1],$newTBQ);
			}

			$newTBQ = str_replace("\n", '', $newTBQ);
			$newTBQ = str_replace("\r", '', $newTBQ);
			$myMMHeadScript = "/*isdev ".$forScript."*/".$newTBQ."";
		}
	}
	else {
		$myMMHeadScript = implode('', file($uf));
		$myMMHeadScript = "/*".$forScript."*/".$myMMHeadScript;
	}
	return $myMMHeadScript;
}











// $c1 is designated for loadtime CanvasSlotConfig up to 5 numbers split by comma [27308,24180,23214,,] MUST PASS 5 or amount of items canvas holds
// $c2 is designated for favorites [no min or max, inline draw]
// $c3 is designated for trash [no min or max, inline draw]
function commonHead($c1, $c2, $c3, $header, $documentTitle, $mainKeys, $shortKeyList, $shortKeyPhrase, $fluffKeys, $metaDesc, $headScript, $headCSS, $headScriptLinks, $headCSSLinks, $loadScript, $docBodyHeader, $miSect, $miSubsect, $miMMIs, $miSMIs) {


	// FIND MOST IMPRESSIVE 2013 template to replace: 55584

	// canvas has 5 slots and all must be fed
	if (!empty($c1)) { $C1X = $c1; }
	// true default [if none set at function call]
	else { $C1X = "55584,,,,"; }
	$currentCanvasItems = explode(",", $C1X);
	$inCanvasARRAY = '"' . implode('","',$currentCanvasItems) . '"';

	// fav has unlimited slots and fed if avail
	if (!empty($c2)) {
		$C2X = $c2;
		if (stristr($c2, ',') === FALSE) { $inFavoritesARRAY = '"'.$c2.'"'; }
		else {
			$currentFavoritesItems = explode(",", $C2X);
			$inFavoritesARRAY = '"' . implode('","',$currentFavoritesItems) . '"';
		}
	}
	else { $inFavoritesARRAY = ''; }
	// trash has unlimited slots and fed if avail
	if (!empty($c3)) {
		$C3X = $c3;
		if (stristr($c3, ',') === FALSE) { $inTrashARRAY = '"'.$c3.'"'; }
		else {
			$currentTrashItems = explode(",", $C3X);
			$inTrashARRAY = '"' . implode('","',$currentTrashItems) . '"';
		}
	}
	else { $inTrashARRAY = ''; }

	//if is a website section index page [subsection 0], print out this page's doc info
	// OTHERWISE DEFAULTS TO WHATEVER VARIABLES ARE BEING PASSED via commonHEAD
	if (!empty($miMMIs) && !empty($miSect)) {
		foreach ( $miMMIs as $miMMI ) {
			if ($miMMI->SectionID > 0) {
				if ($miSect == $miMMI->SectionID) {
					//for page title, meta and desc
					//--> DEFINE DOCUMENT TEMPLATE PARAMS
					$documentTitle = $miMMI->SectionTitle;
					$mainKeys = $miMMI->SectionMainKeys;
					$fluffKeys = $miMMI->SectionFluffKeys;
					$keyPhraseParts = explode(", ", $mainKeys);
					$cKPP = 0;
					$thisKeywordPhrase = '';
					$thisKeywordList = '';
					foreach ($keyPhraseParts as $KPP) {
						$cKPP++;
						$myKPP = trim($KPP);
						if ($cKPP > 1 && $cKPP == count($keyPhraseParts)) {
							$thisKeywordPhrase = $thisKeywordPhrase . " and " . $myKPP;
							$thisKeywordList = $thisKeywordList . " - " . $myKPP;
						}
						else if ($cKPP > 1) {
							$thisKeywordPhrase = $thisKeywordPhrase . ", " . $myKPP;
							$thisKeywordList = $thisKeywordList . " - " . $myKPP;
						}
						else {
							$thisKeywordPhrase = $myKPP;
							$thisKeywordList = $myKPP;
						}
					}
					$shortKeyPhrase = $thisKeywordPhrase;
					$shortKeyList = $thisKeywordList;
					$metaDesc = $miMMI->SectionMetaDescription;
				}
			}
		}
	}

	//if is a website section index page [subsection 0], print out this page's doc info
	// OTHERWISE DEFAULTS TO WHATEVER VARIABLES ARE BEING PASSED via commonHEAD
	if (!empty($miSMIs) && !empty($miSubsect)) {
		foreach ( $miSMIs as $miSMI ) {
			if ($miSMI->SectionID > 0) {
				if ($miSubsect == $miSMI->SectionID) {
					//for page title, meta and desc
					//--> DEFINE DOCUMENT TEMPLATE PARAMS
					$documentTitle = $miSMI->SectionTitle;
					$mainKeys = $miSMI->SectionMainKeys;
					$fluffKeys = $miSMI->SectionFluffKeys;
					$keyPhraseParts = explode(", ", $mainKeys);
					$countKPP = 0;
					$subKeywordPhrase = '';
					$subKeywordList = '';
					foreach ($keyPhraseParts as $KPP) {
						$countKPP++;
						$subKPP = trim($KPP);
						if ($countKPP > 1 && $countKPP == count($keyPhraseParts)) {
							$subKeywordPhrase = $subKeywordPhrase . " and " . $subKPP;
							$subKeywordList = $subKeywordList . " - " . $subKPP;
						}
						else if ($countKPP > 1) {
							$subKeywordPhrase = $subKeywordPhrase . ", " . $subKPP;
							$subKeywordList = $subKeywordList . " - " . $subKPP;
						}
						else {
							$subKeywordPhrase = $subKPP;
							$subKeywordList = $subKPP;
						}
					}
					$shortKeyPhrase = $subKeywordPhrase;
					$shortKeyList = $subKeywordList;
					$metaDesc = $miSMI->SectionMetaDescription;
				}
			}
		}
	}

return "
<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">
<!-- ".$shortKeyList." -->
<html>
<head>
<title>".$documentTitle."</title>
<meta http-equiv=\"PICS-Label\" content='(PICS-1.1 \"http://www.classify.org/safesurf/\" L gen true for \"https://vps-net.com\" r (SS~~000 1))'>
<meta name=\"description\" content=\"".$metaDesc."\">
<meta name=\"keywords\" content=\"".$mainKeys.", ".$fluffKeys."\">
<meta name=\"robots\" content=\"index,follow\">
<meta name=\"resource-type\" CONTENT=\"document\">
<meta name=\"author\" CONTENT=\"DRLv4 for Virtual Private Servers and Networks [VPS-NET]\">
<meta name=\"copyright\" CONTENT=\"Copyright (c) 1995 - ".$year." Virtual Private Servers and Networks [VPS-NET]\">
<meta name=\"revisit-after\" CONTENT=\"1 days\">
<meta http-equiv=\"X-UA-Compatible\" content=\"IE = 8\" />
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<script language=\"javascript\" type=\"text/javascript\">
/*
/* 
/* Hi, and thank for your interest in viewing the structure of my work. You are free 
/* to utilize any of the scripting you see so long as you follow the licensing rules 
/* governing my permission for such use. And, of course, I thank you for utilizing 
/* my work on your project, it makes all the time I spent coding and debugging this 
/* website's interface and programming, totally worth it :)
/* 
/* Also, if you find any bugs just fire me a message, if you can figure out how to 
/* reach me that is :P [OS, include browser version, and bug], Ill work the bug out, 
/* eventually.
/* 
/* 	The following license statement applies to all scripts and programs found 
/* 	throughout vps-net.com(vps-net.com), those of which I myself have hardcoded; 
/* 	You are free to use and distribute it in its native format; Considering 
/* 	you add the following license tag to any and all documents displaying the 
/* 	script(s):
*/

/* BEGIN LICENSE TAG */
/**
/** This program is free software; you can redistribute it and/or modify it under 
/** the terms of the GNU General Public License as published by the Free Software 
/** Foundation; either version 2 of the License, or (at your option) any later 
/** version. This program is distributed in the hope that it will be useful, but 
/** WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
/** or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License 
/** for more details.
/** 
/** You should have received a copy of the GNU General Public License along with 
/** this program; if not, write to: the Free Software Foundation, Inc., 
/** 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
/** 
/** Script: VPS-NET Scripting [by louierd]
/** Author: DoctorLouie aka LouieRd (Luis Gustavo Rodriguez) [ http://louierd.com/about/ ]
/** Release: November 2010
/** Version: 4.1
/** Description:
/**		This is a generic license for all the scripting within 
/**		vps-net.com (vps-net.com), this website, which includes the following 
/**		named scripts:
/**
/**		OpenCanvas UI, docuMaster, swFlasher, eyeCaptcha;
/**		More to be modulized and named in the future.
/**/
/* END LICENSE TAG */

</script>
<LINK href=\"/favicon.ico\" rel=\"SHORTCUT ICON\">
".$headScriptLinks."
".$headCSSLinks."
<style type=\"text/css\">
".$headCSS."
</style>
<script language=\"javascript\" type=\"text/javascript\">
var inCanvas = new Array(".$inCanvasARRAY.");
var FavoriteContains = new Array(".$inFavoritesARRAY.");
var TrashContains = new Array(".$inTrashARRAY.");
".$headScript."
</script>
</head>
<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#266899\" alink=\"#CC0000\" vlink=\"#CC0000\" ".$loadScript.">
<div id=\"vps-net-virtual-private-servers-networks\" class=\"stretch\" style=\"width:100%\">
<div class=\"topKeys\" title=\"".$shortKeyPhrase."\">".$shortKeyPhrase."</div>
".$docBodyHeader."
";
}










function CommonHeadJavascriptLinks() {
return "
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/data-formatting-tools.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-function-dom_sizer.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-library-Before_DOM.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-library-jquery-1.4.2.min.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-yui-extension-container_core-min.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-yui-extension_connection-min.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-yui-extension_dom-event.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-yui-extension_drag-drop-min.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-yui-extension_animation-min.js\"></script>

<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-function-popwindow.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-library-overlib_4.22.js\"></script>

<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-jquery-extension_fancybox-1.3.1.pack.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-jquery-extension_mousewheel-3.0.2.pack.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-jquery-extension_bubblepopup.v2.3.1.min.js\"></script>

<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-wysiwyg.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/modernizr.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/jquery-plugin-touchSwipe.js\"></script>

";
}


function MainMenuHeadJavascriptLinks() {
return "
<script language=\"javascript\" type=\"text/javascript\" src=\"/website_design_template_javascripts/javascript-jquery-extension-bgpos.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/website_design_template_javascripts/javascript-jquery-extension-james_nettuts_anicontentload.js\"></script>
";
}


function CarouselHeadJavascriptLinks() {
return "
<script language=\"javascript\" type=\"text/javascript\" src=\"/cross_browser_javascripts/javascript-function-star_rating.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"/website_design_template_javascripts/javascript-yui-extension-carousel.js\"></script>
";
}











function CommonHeadCSSLinks() {
return "
<link rel=\"stylesheet\" type=\"text/css\" href=\"/yui.css\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"/javascript-jquery-extension_fancybox-1.3.1.css\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"/jquery.bubblepopup.v2.3.1.css\">
";
}


function CarouselHeadCSSLinks() {
return "
<link rel=\"stylesheet\" type=\"text/css\" href=\"/opencanvas-interactive-website-design/carousel.css\">
";
}










function AmazonAdHeadCSS() {
$myAAHeadCSS = <<<HTML

#WikiPeeksAd .WikiPeeksAdText { padding-left:5px; }
#WikiBoardBarAd { height:36px; }
#WikiBoardBarAdDisplay { height:36px; }
#WikiPeeksAd{ position:absolute; background:#EFEDD4; display:none; border-top:#E2E3EA 1px solid; border-left:#E2E3EA 1px solid; border-right:#ACA976 1px solid; border-bottom:#ACA976 1px solid; }
#WikiPeeksAd span, #WikiPeeksAd div, #WikiPeeksAd a { line-height:14px; }
.WikiPeeksAdLink { border:none; border-style:none; }
.WikiPeeksAdText { padding-left:5px; }
a img.WikiPeeksAdImage { border:1px solid #ACA976; padding:1px; margin-right:3px; }
a img.WikiPeeksAdImage:hover { border:1px solid #F99D10; padding:1px; margin:0px; margin-right:3px; }
.DonateNow { text-align:left; background:#fff; border:#ACA976 1px solid; font-weight:normal; font-size:9px; font-family:arial,helvetica,times; color: #ACA977; margin-left: 3px; padding:8px; padding-top:10px; padding-left:10px; }
.DonateNow .resource { font-weight:normal; font-family:tahoma,helvetica,verdana; color: #000; }
.WikiPeeksAdWrap { background:#fff; border:#ACA976 1px solid; margin:3px; padding:3px; overflow:hidden; }
.WikiPeeksAdWrap a { color:#000; }
.WikiPeeksAdWrap a:hover { color:#CC0000; }
a img.WikiPeeksAdPreviewImage { border:#ACA976 1px solid; padding:1px; }
.WikiPeeksAdPreviewInfo { font-family:tahoma,helvetica,verdana; color: #000; font-weight:normal; font-size:10px; }
.WikiPeeksAdPreviewTitle { padding:5px; padding-left:15px; padding-top:15px; padding-right:15px; font-weight:bold; font-size:14px; }
.WikiPeeksAdPreviewTitle a { line-height:18px; }
.WikiPeeksAdPreviewPrice { padding:5px; padding-left:15px; padding-bottom:0px; padding-right:15px; font-size:13px; }
.WikiPeeksAdPreviewAuthor, .WikiPeeksAdPreviewPublisher { padding:5px; padding-left:15px; padding-right:15px; font-size:11px; }
.WikiPeeksAdPreviewAuthor .by, .WikiPeeksAdPreviewPublisher .by { color:#ACA977; }
.WikiPeeksAdPreviewPrice .price { color:#990000; padding-left:5px; }
.WikiPeeksAdPreviewAbout {}
.WikiPeeksReferenceHeader, .WikiPeeksReferenceFooter { padding-left:6px; padding-right:6px; }
.WikiPeeksReferenceHeader .WikiActs { position:relative;top:1px;left:0px; font-size:11px; }
/*close button*/
.WikiPeeksReferenceHeader .WikiActs .WikiPeeksClose { font-weight:normal; font-size:10px; position:relative; top:-1px; }
.WikiPeeksReferenceFooter { font-size:9px; }
HTML;
return $myAAHeadCSS;
}


function FancyBoxHeadCSS() {
$myFBHC = <<<HTML

div#fancybox-title { margin-left:0px;padding-left:0px;margin-top:0px;margin-bottom:1px;margin-right:12px; }
#WikiBoardBarTitle{ color:#000000; font-weight:bold; padding-bottom:11px; padding-left:10px; width:auto; height:auto; font-size:14px; font-family:tahoma,arial,verdana;}
a#WikiBoardBarTitle{ color:#000000; font-weight:bold; }
#WikiBoardBarHistory{ padding-bottom:9px; padding-left:5px; font-size:14px; font-family:arial,courier,sans; width:auto; height:auto; }
#WikiBoardBarHistory select { color:#000000; width:auto; height:auto; font-size:inherit; font-family:inherit; }
#WikiPeeksLogo { position:relative; top:6px; }
#fancybox-frame{ overflow-x:hidden; }
#topbar-center { font-family:Tahoma, Arial, Helvetica; font-size:13px; }
#Wiki-Peeks-Content-Source { padding-left:10px; font-weight:bold; }
#Wiki-Peeks-Content-Search { padding-left:10px; font-family:arial,helvetica,verdana; font-size:9px; }
#Wiki-Peeks-Document-Title a, #Wiki-Peeks-Content-Search a, a.WikiPeeksClose, a.search { text-decoration:none; }
#Wiki-Peeks-Document-Title a:hover, #Wiki-Peeks-Content-Search a:hover, a.WikiPeeksClose:hover { text-decoration:none; }

HTML;
return $myFBHC;
}

function CommonHeadCSS() {
global $HTTP_ENV_VARS;
##-- pass valid top placement
$UA = "".getenv("HTTP_USER_AGENT")."";
if(stristr($UA, 'MSIE') === FALSE) {
	$buttonPadder = "padding-left:10px; padding-right:10px;";
}
else { 
	$buttonPadder = "padding-left:10px; padding-right:10px;";
}

$myCommonHeadCSS = <<<HTML

.topKeys { width:100%; height:23px; padding-top:10px; text-align:center; color:#666666; font-size:9px; font-family:tahoma,arial,verdana; background: url(/web_design_imagery/website_design_template_topper.jpg) repeat-x left center; letter-spacing:3px; }
a, a.MoreWikiInfo, a.NoWikiInfo, a.MoreInfoB, a.NoInfoB { color: #266899; text-decoration:none; }
a:hover, a.MoreWikiInfo:hover, a.NoWikiInfo:hover, a.MoreInfoB:hover, a.NoInfoB:hover { color: #CC0000; text-decoration:underline; }

.hover { text-decoration:none; cursor:pointer; }
.hover:hover { text-decoration:underline; }

a.nohover { text-decoration:none; cursor:pointer; }
a.nohover:hover { text-decoration:none; color:#266899; }

.nobord { border:0px; padding:0px; margin:0px; line-height:0px; }
#documentBody {position:absolute; top:188px; width:100%; left:0px; z-index:2;}
a.commonLinks {color: #000000; font-size:10px; font-family:verdana,arial,tahoma; }
a.commonLinks:hover {color: #CC0000; font-size:10px; font-family:verdana,arial,tahoma; }
a.commonLinks:visited {color: #666666; font-size:10px; font-family:verdana,arial,tahoma; }

a.commonAdLink:hover { color: #CC0000; font-size:10px; font-family:verdana,arial,tahoma; }
a.commonAdLink:visited { color: #666666; font-size:10px; font-family:verdana,arial,tahoma; }

.commonText {color: #000000; font-size:10px; font-family:verdana,arial,tahoma; }

.W3C-Compliant { color: #000000; font-size:10px; font-family:verdana,arial,tahoma; padding-left:1px; padding-right:1px;}
.World-Wide-Web-Consortium { cursor:pointer;background:url(/web_design_imagery/web-design-service-list-bg-silver.png) repeat -30px 30px; padding-left:10px;height:20px;line-height:20px;width:105px;overflow:hidden; }

div.grippie { background:#EEEEEE url(/web_design_imagery/grippie.png) no-repeat scroll center 2px; border-color:#DDDDDD; border-style:solid; border-width:0pt 1px 1px; cursor:s-resize; height:9px; overflow:hidden; }
.news {	font-size:10px; color:#000000; }
.wiki {	font-size:10px; color:#ADADAE; }
#news {	line-height:12px; width:220px; font-family:verdana,arial,helvetica; font-size:9px; color:#000000; padding-bottom:5px; }
#wiki {	line-height:12px; width:220px; font-family:verdana,arial,helvetica; font-size:9px; color:#ADADAE; padding-bottom:15px; padding-top:13px; border: none; }
.commonInput { font-size: 13px; font-family:verdana,arial,helvetica; color:#000000; font-weight:normal; }
.commonArea { font-size: 11px; font-family:verdana,arial,helvetica; height:60px; color:#000000; padding: 3px; font-weight:normal; }
font.label { font-size:11px; font-family:verdana,arial,helvetica; color: #000000;  }
font.mainLabel { font-size:11px; font-weight:bold; font-family:verdana,arial,helvetica; color: #000000; }	

.commonHelper { color: #1841B7; cursor:help; font-size:9px; }
.FooterSponsorInfo {font-family:Tahoma, Arial, Helvetica; font-size:13px; font-weight:bold; color:#666666; }
.FooterSponsorBar { margin-top:20px; background:url(/web_design_imagery/interface-design-footer-background.jpg) repeat-x 0 26px; }
.FooterSponsorItem { font-family:arial,helvetica,verdana;color:#000000;font-size:9px;text-align:center; }
.FooterLogo { height:70px;font-family:arial,helvetica,verdana;color:#000000;font-size:9px;text-align:center;}
.FooterNoUnderline { text-decoration:none; }

.advertisement, .contentfooter { font-family:arial,helvetica,verdana;color:#333333;font-size:9px;text-align:right; }
#AD4 { height:350px;width:280px; }
.AD4 { color:#333333; width:240px;height:65px; }
#AD3 { }
#AD5 { width:730px;height:92px; }

.sbclass { width:75px; font-size:11px; height:24px; font-weight:bold; font-family:verdana,arial,helvetica; margin:0px; }
#Ask-An-Expert { background:url(/web_design_imagery/Questions_Ask_An_Expert.jpg) no-repeat 0 0; }

#AskAnExpert { color:#666666; width:220px; height:105px; padding-left:6px; padding-right:6px; font-family:tahoma,arial,helvetica; font-size:13px; }
#AskAnExpert:hover, #AskAnExpert:focus { color:#000000; }

.AAEinput { color:#666666; width:120px; height:20px; padding-left:6px; padding-right:6px; font-family:tahoma,arial,helvetica; font-size:13px; }
.AAEinput:hover, .AAEinput:focus { color:#000000; }

#Web-Design-Class-Listing {
	padding-left:19px;
	margin:20px 0 20px 7px;
	list-style:url(/website_design_template_images/web-design-list-style-square.gif);
	font-family:verdana, helvetica, tahoma;
	font-size:12px;
}
#Web-Design-Class-Listing li {
	padding-bottom:6px;
}
a.Website-Design-Class, a.Web-Design-Class { color:#313825; }

.activityLink { cursor:pointer;color:#266899;border:0px; }
.activityLink:hover { cursor:pointer;color:#CC0000;border:0px; }

.commonButtons { font-size:11px; $buttonPadder padding-bottom:2px; padding-top:1px; font-weight:bold; font-family:verdana,arial,helvetica; width:115px; }

.hzdm { background:url(/web_design_imagery/horizontalDottieMini.gif) repeat-x; }
.hzdmV, .hzdmV-WikiPeeks { background:url(/web_design_imagery/horizontalDottieMiniVertical.gif) repeat-y 0 0; }
.hzdmV-WikiPeeks { position:relative; top:2px; left:0px; margin-left:5px;margin-right:5px;width:1px;height:10px; }

.SectionTitle { margin-left:10px; margin-bottom:20px; font-family:Tahoma, Arial, Helvetica; font-size:19px; font-weight:normal; color:#266899; }
.SectionIntroduction { margin-left:10px; font-family:Tahoma, Arial, Helvetica; font-size:15px; font-weight:normal; color:#000000; line-height:20px; }
.SectionCloser { margin-left:10px; font-family:Tahoma, Arial, Helvetica; font-size:15px; font-weight:normal; color:#000000; line-height:21px; }
.interface-design-linear { width:20px; height:72px; background:url(/web_design_imagery/interface-design-bodyLinear1.gif) repeat-x 0 35px; }
fieldset { width:605px; font:10px verdana,arial,helvetica; color:#000000; font-weight:normal; padding-top:11px; padding-bottom:10px; border:#D5DFE5 1px solid; }

#Choose-A-Website-Design-Package {
	padding: 20px 0 0 0;
}
#Choose-A-Website-Design-Package .Open-Canvas-Interactive-Web-Design-Logo {
	padding:10px 0 10px 0;
}
#Choose-A-Website-Design-Package span.Web-Programming-And-Development {
	font-weight:normal;
	padding:0 0 3px 12px;
	font-size:15px;
	font-family:tahoma, arial, helvetica;
	margin:0;
}
#Choose-A-Website-Design-Package span.Web-Programming-And-Development:hover {
	font-weight:normal;
	cursor:pointer;
}
.web-design-selector {
	padding-left:7px;
}

.Website-Design-Package-Extras {
	font-weight:normal;
	padding:0 0 3px 7px;
	font-size:12px;
	font-family:tahoma, arial, helvetica;
	margin:0;
}
.Website-Design-Package-Extras:hover {
	cursor:pointer;
}


#Open-Canvas-Website-Starting-At {
	color:#000;
	font-family:tahoma, arial, helvetica;
	font-size:9px;
	position:relative;
	padding:3px 0 5px 0;
	text-align:center;
	position:relative;
	top:13px;
	left:-3px;
}
#Low-Priced-Budget-Open-Canvas-Web-Design {
	position:relative;
	top:10px;
	left:14px;
}
.Internet-Development-Dollar-Sign, .Internet-Development-Price, .Internet-Development-Cents {
	float:left;
	font-family: arial narrow, verdana, helvetica, arial;
	color:#CC0000;
	font-weight:bold;
	text-align:center;
	font-size:11px;
	font-weight:100;
	position:relative;
	top:0;
	left:0;
	z-index:1;
}
.Internet-Development-Price { 
	font-family:tahoma,helvetica,verdana;
	font-size:24px;
	letter-spacing:-2px;
	font-weight:200;
	padding:0;
	top:-6px;
	left:3px;
}
.Internet-Development-Dollar-Sign {
	top:2px;
	left:4px;
	z-index:2;
}
.Internet-Development-Cents {
	left:4px;
	letter-spacing:-1px;
}

.vFormTitle { font-size:11px; font-family:verdana,arial,helvetica; color:#000000; }
.fbSmallInput { height:17px; width:79px; background-color:#FFFFFF; border-top: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #D0D0D0; border-right: 1px solid #D0D0D0; font-family:verdana,arial,helvetica; font-size:10px; }
.fbLargeInput { height:17px; width:120px; background-color:#FFFFFF; border-top: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #D0D0D0; border-right: 1px solid #D0D0D0; font-family:verdana,arial,helvetica; font-size:10px; }
.fbTArea { width:250px; height:54px; background-color:#FFFFFF; border-top: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #D0D0D0; border-right: 1px solid #D0D0D0; font-family:verdana,arial,helvetica; font-size:10px; }
.fbButtons { font-size:10px; font-family:verdana,arial,helvetica; }
#ReadTOS { padding-top:14px;padding-bottom:14px; text-align:left; width:445px; font-family:verdana,arial,helvetica; font-size:11px; color:#000000; font-weight:normal; }
textarea.TOS { width:445px;height:85px; font-family:Courier New,monospace,serif;font-size:12px; }
#TOSTextarea { width:445px; padding-bottom:18px; }
.AgreeTOS { font-family:verdana,arial,helvetica; font-size:11px; color:#000000; font-weight:normal; }
#FreeCaptcha-Text-to-Speech { visibility: visible; width:20px; height:20px; clip:rect(0px,20px,20px,0px); left:0px;top:0px;z-index:10; overflow:hidden; border:0; padding:0; margin:0; }
#FreeCaptchaTTS {  }

#FreeCaptchaChallenge { width:174px; border:0; }
#FreeCaptchaChallenge:hover { width:174px; border:0; }
#FreeCaptchaPrompt { font-family:verdana,arial,helvetica; font-size:11px; width:216px; text-align:left; padding-left:2px; }
#FreeCaptchaPromptLabel { }
.FreeCaptchaPromptLabel { color:#000000; }
#FreeCaptchaInput { width:216px; }
#FreeCaptchaInfo { width:216px; text-align:left; padding-left:2px; font-family:arial,verdana,helvetica; font-size:12px; color:#CBCBCB; font-weight:normal; }

#AccessInformation { }
.AccessInfoExtras { margin-left:24px; margin-top:25px; margin-left:20px; width:215px; font-family:Tahoma, Arial, Helvetica; font-size:14px; font-weight:normal; color:#000000; line-height:20px; }

.EOFTechnicalResources-Table { background:url(/web_design_imagery/TechnicalResources_background.jpg) no-repeat 116px 1px; }
.EOFTechnicalResources-Logo{ width:126px;height:36px;overflow:hidden;clip:rect(0px,126px,36px,0px); }
.EOFTechnicalResources-Title{ width:100px; padding-top:3px;overflow:hidden;clip:rect(0px,100px,36px,0px); font-family:arial,verdana,helvetica; font-size:11px; color:#CCCCCC; font-weight:normal; }
.EOFTechnicalResources-Links{ margin-left:30px;width:430px; padding-top:3px;overflow:hidden;clip:rect(0px,430px,36px,0px); font-family:arial,verdana,helvetica; font-size:13px; color:#000000; font-weight:normal; }

a.TechnicalResources { color:#000000; }
a.TechnicalResources:hover { color:#CC0000; }

.panelBarWIKItop { padding-left:2px; padding-bottom:4px; font-size:13px; font-weight:bold; font-family:Tahoma, Arial, Helvetica; color:#444444; }
.panelBarWIKItermi { font-size:9px; font-weight:normal; }
.panelBarWIKIbutton { padding-bottom:6px; }
.panelBarWIKIbot { padding-right:5px; padding-top:5px; font-size:9px; font-family:verdana,arial,helvetica; color:#666666; }
.panelBarWIKIitem { margin-left:10px; width:205px; height:15px; padding:3px; font-size:11px; font-family:verdana,arial,helvetica; color:#666666; }
.panelBarWIKIbody {	font-size:10px; color:#000000; }

.commonFont { font-size:12px; font-weight:normal; font-family:arial,helvetica,verdana; color: #333333; }
.f0078AD { color:#0078AD; }

#Virtual-Private-Servers-and-Networks-Logo { background-image:url(https://vps-net.com/electronic-communications/Virtual-Private-Servers-and-Networks-Logo_off.png); background-position:0 0; background-repeat:no-repeat; }
#Virtual-Private-Servers-and-Networks-Logo:hover { background-image:url(https://vps-net.com/electronic-communications/Virtual-Private-Servers-and-Networks-Logo_over.png); background-position:0 0; background-repeat:no-repeat; }
#Virtual_Private_Servers_and_Networks_Logo { background-image:url(https://vps-net.com/electronic-communications/Virtual_Private_Servers_and_Networks_Logo_off.png); background-position:0 0; background-repeat:no-repeat; }
#Virtual_Private_Servers_and_Networks_Logo:hover { background-image:url(https://vps-net.com/electronic-communications/Virtual_Private_Servers_and_Networks_Logo_over.png); background-position:0 0; background-repeat:no-repeat; }
#Virtual-Private-Solution-Spanner { background-image:url(https://vps-net.com/electronic-communications/secureTopSpanner.png); background-position:0 5px; background-repeat:repeat-x; }



HTML;

#/*
#	Virtual-Private-Servers-and-Networks-Logo_over dash version for common
#	Virtual_Private_Servers_and_Networks_Logo_over underscore version for emailer
#*/


return $myCommonHeadCSS;
}

function MainMenuHeadCSS() {
$myMMHeadCSS = <<<HTML

		.web-design-topmenu { color:#000000; font-size:11px; font-family:arial,verdana,helvetica; }
		#web_design_logo { width:278px; height:71px; padding-top:5px; }
		.web-design-questions { color:#000000; font-size:10px; letter-spacing:0.1em; font-family:arial,verdana,helvetica; }
		.topKeys { width:100%; height:23px; padding-top:10px; text-align:center; color:#666666; font-size:9px; font-family:tahoma,arial,verdana; background: url(/web_design_imagery/website_design_template_topper.jpg) repeat-x left center; letter-spacing:3px; }
		.user_interface_menu { height:18px; padding-left:15px; padding-right:15px; }
		.user_interface_menu_text { color:#000000; font-size:12px; font-family:tahoma,arial,verdana; }
		.user_interface_menu_text:hover { text-decoration:none; }

		/*JQUERY: wavy menu mouseover*/
		ul.web-design-service-list {list-style:none;margin:0;padding:0;}
		li.web-design-website-hosting-services {list-style:none;float:left;text-align:center;height:17px;}
		li.web-design-website-hosting-services a {display:block;padding:4px 25px;height:100%;color:#000000;text-decoration:none;}
		li.web-design-website-hosting-services a:hover, li.web-design-website-hosting-services a:focus, li.web-design-website-hosting-services a:active {background-position:-150px 0;color:#CC0000;}
		#web-design-scripts a {list-style:none; background:url(/web_design_imagery/web-design-service-list-bg.png) repeat -20px 35px;}

		.website-design-mainmenu { color:#000000; font-size:12px; font-family:tahoma,arial,verdana; font-weight:normal; width:714px; margin:0; padding:0; }
		#user_interface_main_menubar { background:url(/web_design_imagery/user_interface_main_menubar.png) 0 0 no-repeat; width:940px; height:26px; overflow:hidden; clip:rect(0px,940px,26px,0px); padding-top:1px;}
		a.graphical-user-interface_text { color:#000000; font-size:11px; font-family:tahoma,arial,verdana; text-decoration:none; }
		a.graphical-user-interface_text:hover { text-decoration:none; color:#CC0000; }

		a.graphical-user-interface_text_active { color:#266899; font-size:11px; font-family:tahoma,arial,verdana; text-decoration:none; }
		a.graphical-user-interface_text_active:hover { text-decoration:none; color:#266899; }
		/*JQUERY: wavy menu mouseover END*/
HTML;
return $myMMHeadCSS;
}

function CarouselHeadCSS() {
global $HTTP_ENV_VARS;
##-- pass valid top placement
$UA = "".getenv("HTTP_USER_AGENT")."";
if(stristr($UA, 'MSIE') === FALSE) {
	$topRadio = "0px"; 
	$topTP = "2px";
	$buttonPadder = "padding-left:10px; padding-right:10px;";
}
else { 
	$topRadio = "-4px"; 
	$topTP = "0px";
	$buttonPadder = "padding-left:10px; padding-right:10px;";
}

$myCarouselHeadCSS = <<<HTML
		#dhtml-carousel { padding:8px; margin:0px; float:left; }
		.carousel-component .carousel-list li { margin:6px; margin-left:10px; margin-right:10px; width:149px; }
		.carousel-component .carousel-list li a { display:block; border:1px solid #FFFFFF; outline:none; }
		.carousel-component .carousel-list li a:hover { border: 1px solid #C5DAED; }
		.carousel-component .carousel-list li img { border:1px solid #C5DAED; display:block; }
		.carousel-component .carousel-list li img:hover { border:1px dashed #5794BF; display:block; }
		#prev-arrow-container { float:left; z-index:1; }
		#next-arrow-container { float:right; z-index:1; }
		#prev-arrow { cursor:pointer; margin-top:50px; margin-right:5px; visibility:hidden; }
		#next-arrow { cursor:pointer; margin-top:50px; margin-left:5px; visibility:hidden; }
		pre { margin-bottom:20px; }
		#Web-Design-Template-Browser { width:600px; }
		#Template-Browser-Container { padding-top:15px; }
		#Template-Design-Websites {
			position:relative;
			left:115px;
			top:-6px;
			padding-left:20px;
			color:#266899;
			font-size:17px;
			font-family:tahoma,arial,verdana;
		}

		#Browse-Website-Template-Designs { 
			position:relative;
			left:115px; 
			top:0px; 
			width:381px;
			height:36px;
			background:url(/website_design_template_images/website-transparent-background-effects-ready.png);
			border:#EEF0F5 1px solid;
			border-radius: 4px;
			-moz-border-radius: 4px;
			-webkit-border-radius: 4px;
			box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
			-moz-box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
			-webkit-box-shadow: 0px 2px 3px rgba(0,0,0,0.17);
		}
		#Website-Template-Listing { height:37px; }
		#Open-Canvas-Container-Contents { 
			visibility:visible; 
			position:relative; 
			display:inline; 
			font-size:12px; 
			font-family:tahoma,arial,verdana; 
			top:8px;
		}
		.showgun { color:#266899; }
		.showgunFAV { color:#E4BE4A; }
		.showgunTRA { color:#BF0000; }
		.showgunCAN { color:#266899; text-decoration:none; }
		.showgunTRA:hover { text-decoration:underline; }
		.showgunFAV:hover { text-decoration:underline; }
		.showgunCAN:hover { text-decoration:underline; }
		#FavoritesHas { visibility:visible; display:inline; }
		#TrashHas { visibility:visible; display:inline; }
		#FavoritesHas:hover { cursor:pointer; }
		#TrashHas:hover { cursor:pointer; }

		.templateID { font-weight:bold; padding-top:15px; cursor:pointer; text-align:center; color:#266899; font-size:13px; letter-spacing:3px; font-family:tahoma,arial,verdana; }
		.templateID:hover { color:#CC0000; }
		.templateIDtitle { text-align:center; color:#CCCCCC; font-size:9px; font-family:tahoma,arial,verdana; }
		.templateTYPE { padding-top:8px; padding-bottom:11px; text-align:center; color:#000000; font-size:11px; font-family:tahoma,arial,verdana; }
		.templateCATEGORY { padding-top:7px; padding-bottom:10px; color:#666666; font-size:11px; font-family:tahoma,arial,verdana; }
		input.templateRADIO { position:relative; top:$topRadio; left:0px; }
		.templateCOMMON { cursor:pointer; background:url(/website_design_template_images/horizontalDottie_000000.gif) repeat-x 0 11px; color:#000000; font-size:9px; font-family:verdana,arial,helvetica; float:left; text-align:right; width:120px; }
		.templateUNIQUE { cursor:pointer; background:url(/website_design_template_images/horizontalDottie_0078AD.gif) repeat-x 0 11px; color:#0071A6; font-size:9px; font-family:verdana,arial,helvetica; text-align:left; width:120px; float:right; }
		.templatePRICE { padding-top:7px; width:149px;height:60px; background:url(/web_design_imagery/Design-Template-Price-Background.gif) no-repeat center top; }
		.templatePRICES { padding-top:$topTP; }
		.priceCOMMON { cursor:pointer; color:#000000; font-size:11px; font-family:verdana,arial,helvetica; font-weight:bold; padding-top:4px; float:left; text-align:right; width:120px; padding-bottom:12px; }
		.priceUNIQUE { cursor:pointer; color:#0071A6; font-size:11px; font-family:verdana,arial,helvetica; font-weight:normal; padding-top:4px; float:right; text-align:left; width:120px; padding-bottom:12px; }
		.templateButton { font-size:10px; $buttonPadder padding-bottom:2px; padding-top:1px; font-weight:bold; font-family:verdana,arial,helvetica; width:120px; }
		.buyIT { padding-top:4px; padding-bottom:5px; }
		.miniLINE { background:url(/website_design_template_images/horizontalDottie_000000.gif) repeat-x 0 0; width:123px; height:2px; overflow:hidden; clip:rect(0px,123px,2px,0px); }
		.loadx { background:url(/web_design_imagery/loadx.gif) no-repeat; }

		.canvasButtons { font-size:11px; $buttonPadder padding-bottom:2px; padding-top:1px; font-weight:bold; font-family:verdana,arial,helvetica; width:115px; }

HTML;
return $myCarouselHeadCSS;
}


function DDCarouselHeadCSS() {
$myDDHeadCSS = <<<HTML
/*#C5DAED*/
.slot { border:1px dashed #FFFFFF; background-color:#FFFFFF; color:#666666; text-align:left; width:36px; height:32px; }
.CanvasSlot { padding:1px; text-align:left; width:36px; height:32px; }
.target { border:1px dashed #C5DAED; background-color:#ffffff; color:#666666; text-align:left; width:36px; height:32px; }
.targetOver { border:1px dashed #5794BF; background-color:#ffffff; color:#666666; text-align:left; width:36px; height:32px; }
.template { z-index:2000; left:0px; top:0px; cursor:move; }
.hidden { width:0px; height:0px; overflow:hidden; clip:rect(0px,0px,0px,0px); visibility:hidden; }
#t1 { left: 0px; top: 0px; }
#t2 { left: 0px; top: 0px; }
#t3 { left: 0px; top: 0px; }
#t4 { left: 0px; top: 0px; }
#t5 { left: 0px; top: 0px; }
#DDBuckets { background: url(/web_design_imagery/CFTBack.png) no-repeat left top; position:absolute; z-index:10; visibility:hidden; margin-left:4px; }

.CFTicons { margin:1px; border:1px solid #FFFFFF; width:39px; height:39px; text-align:right; font-size:9px; }
.CFTiconsOn { margin:1px; border:1px dashed #C5DAED; width:39px; height:39px; text-align:right; font-size:9px; }
.CFTiconsOnOver { margin:1px; border:1px dashed #5794BF; width:39px; height:39px; text-align:right; font-size:9px; }
.CFTiconsOnDrop { margin:1px; border:1px solid #5794BF; width:39px; height:39px; text-align:right; font-size:9px; }


HTML;
return $myDDHeadCSS;
}





function DDCarouselHeadScript($canvasInfoType, $OCv) {
	// DEFAULT: OCvX+ID / price / unique / comments / menu
	$OpenCanvasInfoTemplate = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td onclick=\"CLICKACTD\"><div class=\"Open-Canvas-Slot-White\"></div></td><td align=\"left\" style=\"width:74px;height:34px;\" valign=\"middle\" onclick=\"CLICKACTD\"><div id=\"Template-ID-X\" class=\"Template-ID\" style=\"color:#D9D9D9;\">template X</div></td><td onclick=\"CLICKACTD\"><div class=\"Open-Canvas-Slot-Spacer-Disabled\"></div></td><td align=\"right\" valign=\"middle\" onclick=\"CLICKACTD\"><div id=\"Template-Price-X\" class=\"Template-Price\" style=\"color:#D9D9D9;font-weight:normal;\">+ 0.00</div></td><td onclick=\"CLICKACTD\"><div class=\"Open-Canvas-Slot-Spacer-Disabled\"></div></td><td align=\"center\" valign=\"middle\" style=\"width:71px;height:34px;\"><div id=\"Template-Image-X\" class=\"Template-Is-Unique\" onMouseOver=\"runCanvasOptions(this,1);\" onMouseOut=\"runCanvasOptions(this,0);\" onClick=\"toggleCanvasPrice(this,XID);\"><img src=\"/web_design_imagery/Open-Canvas-Slot-Unique-Template_disabled.gif\" width=\"9\" height=\"10\" border=\"0\"></div></td><td onclick=\"CLICKACTD\"><div class=\"Open-Canvas-Slot-Spacer-Disabled\"></div></td><td align=\"center\" style=\"width:24px;height:34px;\" valign=\"middle\"><div id=\"Template-Comments-Toggle-X\" class=\"Template-Add-Comments\" onMouseOver=\"runCanvasOptions(this,1);\" onMouseOut=\"runCanvasOptions(this,0);\" onClick=\"toggleCanvasComments(this,XID);\"><img src=\"/web_design_imagery/Open-Canvas-Slot-Add-Comments_disabled.gif\" width=\"16\" height=\"13\" border=\"0\"></div></td><td><div class=\"Open-Canvas-Slot-Spacer-Disabled\"></div></td><td align=\"center\" style=\"width:25px;height:34px;\" valign=\"middle\"><div class=\"Template-More-Options\" onMouseOver=\"runCanvasOptions(this,1);\" onMouseOut=\"runCanvasOptions(this,0);\"><img src=\"/web_design_imagery/spacer.gif\" width=\"13\" height=\"13\" border=\"0\"></div></td><td><div class=\"Open-Canvas-Slot-White\"></div></td></tr></table>";
	if (!empty($canvasInfoType)) {
		// DEFAULT
		if ($canvasInfoType == 1) { $OpenCanvasInfoTemplate = $OpenCanvasInfoTemplate; }
		// OCvX+ID / price / comments / menu
		else if ($canvasInfoType == 2) { 
			$OpenCanvasInfoTemplate = "
			<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
				<tr>
					<td onclick=\"CLICKACTD\"><div class=\"Open-Canvas-Slot-White\"></div></td>
					<td align=\"left\" style=\"width:78px;height:34px;\" valign=\"middle\" onclick=\"CLICKACTD\"><div id=\"Template-ID-X\" class=\"Template-ID\" style=\"color:#D9D9D9;\">template X</div></td>
					<td onclick=\"CLICKACTD\"><div class=\"Open-Canvas-Slot-Spacer-Disabled\"></div></td>
					<td align=\"right\" style=\"width:62px;height:34px;\" valign=\"middle\" onclick=\"CLICKACTD\"><div id=\"Template-Price-X\" class=\"Template-Price\" style=\"color:#D9D9D9;font-weight:normal;\">+ 0.00</div></td>
					<td onclick=\"CLICKACTD\"><div class=\"Open-Canvas-Slot-Spacer-Disabled\"></div></td>
					<td align=\"center\" valign=\"middle\" style=\"width:24px;height:34px;\"><div id=\"Template-Image-X\" class=\"Template-Is-Unique\" onMouseOver=\"runCanvasOptions(this,1);\" onMouseOut=\"runCanvasOptions(this,0);\" onClick=\"toggleCanvasPrice(this,XID);\"><img src=\"/web_design_imagery/Open-Canvas-Slot-Unique-Template_disabled.gif\" width=\"9\" height=\"10\" border=\"0\"></div></td>
					<td onclick=\"CLICKACTD\"><div class=\"Open-Canvas-Slot-Spacer-Disabled\"></div></td>
					<td align=\"center\" style=\"width:24px;height:34px;\" valign=\"middle\"><div id=\"Template-Comments-Toggle-X\" class=\"Template-Add-Comments\" onMouseOver=\"runCanvasOptions(this,1);\" onMouseOut=\"runCanvasOptions(this,0);\" onClick=\"toggleCanvasComments(this,XID);\"><img src=\"/web_design_imagery/Open-Canvas-Slot-Add-Comments_disabled.gif\" width=\"16\" height=\"13\" border=\"0\"></div></td>
					<td><div class=\"Open-Canvas-Slot-Spacer-Disabled\"></div></td>
					<td align=\"center\" style=\"width:24px;height:34px;\" valign=\"middle\"><div class=\"Template-More-Options\" onMouseOver=\"runCanvasOptions(this,1);\" onMouseOut=\"runCanvasOptions(this,0);\" ><img src=\"/web_design_imagery/spacer.gif\" width=\"13\" height=\"13\" border=\"0\"></div></td>
					<td><div class=\"Open-Canvas-Slot-White\"></div></td>
				</tr>
			</table>"; 
		}
		else { $OpenCanvasInfoTemplate = $OpenCanvasInfoTemplate; }
	}
	else { $OpenCanvasInfoTemplate = $OpenCanvasInfoTemplate; }


	$OpenCanvasInfoTemplate = str_replace("\n", "", $OpenCanvasInfoTemplate);
	$OpenCanvasInfoTemplate = str_replace("\t", "", $OpenCanvasInfoTemplate);

	$af = "DDCarouselHeadScript.js.nsf";
	$uf = "cross_browser_javascripts/DDCarouselHeadScript.js";
	$obfuscatedJS = obfuscateJavascripts($af,$uf,'DDCarouselHeadScript');
	
	//--> $obfuscatedJS is what gets saved to $uf, not $myDDheader3

	$myDDheader2 = str_replace("%%OCIT%%", "$OpenCanvasInfoTemplate", $obfuscatedJS);
	$myDDheader3 = str_replace("%%ELOCV%%", "$canvasInfoType", $myDDheader2);
	//--> script also has %%FAV%% and %%TRA%% data placeholders, which we haven't used for anything yet, maybe we had something planned
	return $myDDheader3;
}







function CarouselHeadScript($popflash,$ajaxflash,$show,$scroll,$cWidth,$isDD,$itemStyle) {

	// template for carousel item [$IS1 = open wrapper div, $IS2 = radio button TRs && $IS3 = close wrapper div]
	// DEFAULT: OCvX+ID - common/unique price w/radio - buy it now - categories
	$IS1 = "<div class=\"templatePRICE\"><div><input type=\"radio\" id=\"radio-'+result.id+'-0\" class=\"templateRADIO\" name=\"'+result.id+'\" value=\"0\" onClick=\"toggleTemplatePrice('+result.id+',0);\" checked><input type=\"radio\" id=\"radio-'+result.id+'-1\" class=\"templateRADIO\" name=\"'+result.id+'\" value=\"1\" onClick=\"toggleTemplatePrice('+result.id+',1);\" style=\"margin-left:20px;\"></div><div class=\"templatePRICES\">";
	$IS2 = "<center><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"nobord\"><tr><td class=\"nobord\" align=\"right\"><span id=\"templateCOMMON-'+result.id+'\" class=\"templateCOMMON\" onClick=\"toggleTemplatePrice('+result.id+',0);\" >common</span></td><td align=\"left\"><span id=\"templateUNIQUE-'+result.id+'\" class=\"templateUNIQUE\" onClick=\"toggleTemplatePrice('+result.id+',1);\" >unique</span></td></tr><tr><td class=\"nobord\" align=\"right\"><div id=\"priceCOMMON-'+result.id+'\" class=\"priceCOMMON\" onClick=\"toggleTemplatePrice('+result.id+',0);\" >$'+result.Price+'</div></td><td align=\"left\"><div id=\"priceUNIQUE-'+result.id+'\" class=\"priceUNIQUE\" onClick=\"toggleTemplatePrice('+result.id+',1);\" >$'+result.Buyout+'</div></td></tr></table></center>";
	$IS3 = "</div></div>";
	$STYLE1 = "height:166px;";
	$ACT1N = "Buy It Now!";
	$ACT1 = "javascript:alert('+result.id+');";
	$continue = 0;
	if (!empty($itemStyle)) {
		// DEFAULT
		if ($itemStyle == 1) { $continue = 1; }
		// OCvX+ID / price / comments / menu
		else if ($itemStyle == 2) { $IS1 = ""; $IS2 = ""; $IS3 = ""; $ACT1N = "Add to Canvas";  $ACT1 = "javascript:appendToCanvas('+result.id+');"; $STYLE1 = ""; } 
		else { $continue = 1; }
	} else { $continue = 1; }

	$af = "CarouselHeadScript.js.nsf";
	$uf = "cross_browser_javascripts/CarouselHeadScript.js";
	$obfuscatedJS = obfuscateJavascripts($af,$uf,'CarouselHeadScript');

	//--> $obfuscatedJS is what gets saved to $uf, not $myone3
	//--> return $obfuscatedJS;

	$myone = str_replace("%%S1%%", "$STYLE1", $obfuscatedJS);
	$myone = str_replace("%%IS1%%", "$IS1", $myone);
	$myone = str_replace("%%IS2%%", "$IS2", $myone);
	$myone = str_replace("%%IS3%%", "$IS3", $myone);
	$myone = str_replace("%%ACTION1NAME%%", "$ACT1N", $myone);
	$myone = str_replace("%%ACTION1%%", "$ACT1", $myone);
	$myone = str_replace("%%SHOW%%", "$show", $myone);
	$myone = str_replace("%%ISDD%%", "$isDD", $myone);
	$myone = str_replace("%%CWIDTH%%", "$cWidth", $myone);
	$myone = str_replace("%%SCROLL%%", "$scroll", $myone);
	
	$myone2 = str_replace("%%MYPOPFLASH%%", "$popflash", $myone);
	$myone3 = str_replace("%%MYAJAXFLASH%%", "$ajaxflash", $myone2);
	
	return $myone3;
}









function CommonHeadScript() {

$domainsSaved = 0;
##-- if domains saved
if (isset($_COOKIE["VirtualPrivateDomain"])) {
	$domainStateSwap = '$(document).ready(function(){ swapDomainState(); });';
	$domainsSaved = $_COOKIE["VirtualPrivateDomain"];
}
##-- if canvas was submitted, VirtualPrivateCart cookie is its UID, swap the cart state
if (isset($_COOKIE["VirtualPrivateCart"]) && (strlen($_COOKIE["VirtualPrivateCart"]) > 10)) {
	$cartStateSwap = '$(document).ready(function(){ swapCartState(); });';
}
$myCHS = <<<HTML
var formLabelFlipper = function(este,state) {
	if (state == '1') { if (document.getElementById("label_"+este.id+"")) { document.getElementById("label_"+este.id+"").style.color = '#0078AD'; } }
	else {  if (document.getElementById("label_"+este.id+"")) { document.getElementById("label_"+este.id+"").style.color = '#000000'; } }
};
var iHover = function(image,hover) {
	if (image.src)	{
		var ciSRC = ''+image.src+'';
		if (hover == 1) { overSRC = ciSRC.replace('off','over'); image.src = overSRC; }
		else { offSRC = ciSRC.replace('over','off'); image.src = offSRC; }
	}
};
var addBookmark = function(url, title) {
	if (!(!window.sidebar)) { // firefox
		window.sidebar.addPanel(title, url, "");
	}
	else if (!(!window.external)) {// ie
		if (!(!window.chrome)) {
			popWindow(url,'addbookmark',500,500,'addressbar,toolbar,resizable');
		}
		else {
			window.external.AddFavorite(url, title);
		}
	}
	else if(!(!window.opera) && !(!window.print)) { // opera
		var elem = document.createElement('a');
		elem.setAttribute('href',url);
		elem.setAttribute('title',title);
		elem.setAttribute('rel','sidebar');
		elem.click();
	}
	else {
		popWindow(url,'addbookmark',500,500,'addressbar,toolbar,resizable');
	}
};


var swapCartState = function() {
	$("#gui-your-shopping-cart-image").html('<img src="/web_design_imagery/website_design_cart-on.gif" border="0" width="21" height="24" alt="Your secure shopping cart is in-use.">');
	$("#gui-your-shopping-cart-text div nobr").html('Cart Is In-Use');

	$("#gui-your-shopping-cart").animate({ width: "102px" }, {queue: false});
	$("#gui-your-shopping-cart-text").animate({ width: "81px" }, {queue: false});
	$("#gui-design-your-website").animate({ width: "21px" }, {queue: false});
	$("#gui-design-your-website-text").animate({ width: "0px" }, {queue: false});
};

var SavedDomains = %%NUMBERDOMAINS%%;
var swapDomainState = function() {
	var vpsNETurl = '/domain-registration-search/select-your-domain-registrar.htm';
	if (SavedDomains >= 1) {
		$("#gui-register-a-domain-image").html('<a rel="/domain-registration-search/internet-domain-name-registration.php" title="Search and Register Domain Names, quickly and easily. (.com, .net, .org, .tv, .ca, ,.mx, .cc)" onClick="javascript:document.location.href=this.rel;"><img src="/web_design_imagery/domain_name_search.gif" border="0" width="21" height="24" alt="Search and Register Domain Names, quickly and easily. (.com, .net, .org, .tv, .ca, ,.mx, .cc)"></a>');
		$("#gui-register-a-domain-text div").html('<a rel="'+vpsNETurl+'" onClick="javascript:runFancyFancy(this.rel,\'Virtual Private\',640,370);" class="user_interface_menu_text"><nobr title="Domain name registration pending.">Saved Domains: '+SavedDomains+'</nobr></a>');
	}
	else {
		$("#gui-register-a-domain-image").html('<img src="/web_design_imagery/domain_name_search.gif" border="0" width="21" height="24" alt="You have no domain names pending registration, would you like to search for a domain name to register?">');
		$("#gui-register-a-domain-text div").html('<a title="" onClick="javascript:document.location.href=\'/domain-registration-search/internet-domain-name-registration.php\';" class="user_interface_menu_text"><nobr>Domain Registration</nobr></a>');
	}

	$("#gui-register-a-domain").animate({ width: "134px" }, {queue: false});
	$("#gui-register-a-domain-text").animate({ width: "113px" }, {queue: false});
	$("#gui-design-your-website").animate({ width: "21px" }, {queue: false});
	$("#gui-design-your-website-text").animate({ width: "0px" }, {queue: false});
};

%%DOMAINSTATE%%

%%CARTSTATE%%

var WikiPeeksThemeColor = (WikiPeeksThemeColor) ? WikiPeeksThemeColor : 'azure';
var WikiPeeksInnerHTMLColor = (WikiPeeksInnerHTMLColor) ? WikiPeeksInnerHTMLColor : '#000000';
//-->> local BPoptions
var BPoptions =	{
	openingDelay: 2000,
	position : 'left',
	align	 : 'middle',
	width: '320px',
	innerHtmlStyle: { color:WikiPeeksInnerHTMLColor,  'text-align':'left' },
	themeName: 	WikiPeeksThemeColor,
	themePath: 	'/web_design_imagery/bubblepop',
	themeMargins: { total: '13px', difference: '0px' },
	tail: {'hidden':true}
};

var BPoptions2 = {
	openingDelay: 500,
	position : 'top',
	align	 : 'center',
	width: '320px',
	innerHtmlStyle: { color:WikiPeeksInnerHTMLColor,  'text-align':'left' },
	themeName: 	WikiPeeksThemeColor,
	themePath: 	'/web_design_imagery/bubblepop',
	themeMargins: { total: '13px', difference: '0px' },
	tail: {'hidden':true}
};

var BPoptions3 = {
	openingDelay: 500,
	position: 'top',
	align	 : 'left',
	innerHtmlStyle: { color:WikiPeeksInnerHTMLColor,  'text-align':'left' },
	themeName: 	WikiPeeksThemeColor,
	themePath: 	'/web_design_imagery/bubblepop',
	distance:'15px',
	themeMargins: { total: '-12px', difference:'-4px'},
	tail: {'hidden':true}
};

/*Same as BPoptions3 but sticky(selectable)*/
var BPoptions4 = {
	selectable: true,
	openingDelay: 500,
	position: 'top',
	align	 : 'left',
	innerHtmlStyle: { color:WikiPeeksInnerHTMLColor,  'text-align':'left' },
	themeName: 	WikiPeeksThemeColor,
	themePath: 	'/web_design_imagery/bubblepop',
	distance:'15px',
	themeMargins: { total: '-12px', difference:'-4px'},
	tail: {'hidden':true}
};

var BPoptionsWebDesign = {
	openingDelay: 500,
	position : 'right',
	align	 : 'middle',
	width: '420px',
	innerHtmlStyle: { color:WikiPeeksInnerHTMLColor,  'text-align':'left' },
	themeName: 	WikiPeeksThemeColor,
	themePath: 	'/web_design_imagery/bubblepop',
	distance:'5px',
	themeMargins: { total: '13px', difference: '0px' },
	tail: {'hidden':true}
};


var BPoptionsWebsiteAddons = {
	openingDelay: 500,
	position : 'left',
	align	 : 'middle',
	width: '420px',
	innerHtmlStyle: { color:WikiPeeksInnerHTMLColor, 'text-align':'left' },
	themeName: 	WikiPeeksThemeColor,
	themePath: 	'/web_design_imagery/bubblepop',
	distance:'5px',
	themeMargins: { total: '13px', difference: '0px' },
	tail: {'hidden':true}
};


//-->> local BPoptions
var BPoptionsReference = {
	alwaysVisible: true,
	selectable: true,
	openingDelay: 750,
	position: 'top',
	align: 'center',
	tail: {'hidden':true},
	width: '555px',
	/*divStyle: {'z-index': '9999999 !important'},*/
	innerHtmlStyle: { color:WikiPeeksInnerHTMLColor,  'text-align':'left' },
	themeName: 	WikiPeeksThemeColor,
	themePath: 	'/web_design_imagery/bubblepop',
	themeMargins: { total: '13px', difference: '0px' }
};

/* start wikiboard head script */
$(document).ready(function(){
	$('.MoreInfo, .panelBarWIKIitem .WikiBoard, .panelBarWIKI a.WikiBoard').CreateBubblePopup( BPoptions ).each( function() {
		aTitle = $(this).attr( 'title' ).split('%%%%%');
		wikiPeekTitle = aTitle[0]; wikiPeekContent = aTitle[1];
		wikiPeekContent = wikiPeekContent.replace( / %%BR%% /g, '<br>' );
		$(this).SetBubblePopupInnerHtml( '<div class="MoreInfo-panelBarWIKIitem-WikiBoard" style="padding:10px;font-size:11px;font-family:verdana,arial,helvetica;line-height:15px;color:#444;"><b style="font-size:13px;color:#000;">'+ wikiPeekTitle +'</b><br><br>'+ wikiPeekContent +'<br><br>(click to read more...)</div>');
		$(this).removeAttr( 'title' );
	});
	$('.MoreWikiInfo').CreateBubblePopup( BPoptions2 ).each( function() {
		wikiPeekTitle = $(this).html(); 
		wikiPeekContent = $(this).attr( 'title' );
		$(this).SetBubblePopupInnerHtml( '<div style="padding:10px;font-size:11px;font-family:verdana,arial,helvetica;line-height:15px;color:#444;"><b style="font-size:13px;color:#000;">'+ wikiPeekTitle +'</b><br><br>'+ wikiPeekContent +'</div>');
		$(this).removeAttr( 'title' );
	});
	$('.MoreInfoB').CreateBubblePopup( BPoptions2 ).each( function() {
		wikiPeekTitle = $(this).html(); 
		wikiPeekContent = $(this).attr( 'title' );
		$(this).SetBubblePopupInnerHtml( '<div style="padding:10px;font-size:11px;font-family:verdana,arial,helvetica;line-height:15px;color:#444;"><b style="font-size:13px;color:#000;">'+ wikiPeekTitle +'</b><br><br>'+ wikiPeekContent +'</div>');
		$(this).removeAttr( 'title' );
	});
	$('.Web-Design-Information').CreateBubblePopup( BPoptionsWebDesign ).each( function() {
		myTitle = $(this).html(); 
		myContent = $(this).attr( 'title' );
		$(this).SetBubblePopupInnerHtml( '<div style="padding:10px;font-size:11px;font-family:verdana,arial,helvetica;line-height:15px;color:#444;"><b style="font-size:13px;color:#000;">'+ myTitle +'</b><br><br>'+ myContent +'</div>');
		$(this).removeAttr( 'title' );
	});
	$('.Web-Design-Add-Ons').CreateBubblePopup( BPoptionsWebsiteAddons ).each( function() {
		myTitle = $(this).html(); 
		myContent = $(this).attr( 'title' );
		$(this).SetBubblePopupInnerHtml( '<div style="padding:10px;font-size:11px;font-family:verdana,arial,helvetica;line-height:15px;color:#444;"><b style="font-size:13px;color:#000;">'+ myTitle +'</b><br><br>'+ myContent +'</div>');
		$(this).removeAttr( 'title' );
	});
	$('.UserStatus').CreateBubblePopup( BPoptions3 ).each( function() {
		var extragoods = '';
		var thepadd = '5px 4px 3px 4px';
		var fonsiz = '9px';
		thisID = $(this).attr('id');
		thisCLASS = $(this).attr('class');
		if (thisID == 'CommunicationsLogin' || thisID == 'PendingRegistration' || (thisCLASS == 'UserStatus ActiveUser')) {
			thepadd = '10px';
			fonsiz = '10px';
		}
		/*Same as BPoptions3 but sticky(selectable): DOESN'T STICK WITH MAXTHON! ONLY MAXTHON THOUGH?!?!? */
		if (thisCLASS == 'UserStatus Activity') {
			$(this).SetBubblePopupOptions( BPoptions4 );
		}
		wikiPeekTitle = $(this).html(); 
		wikiPeekContent = $(this).attr( 'title' );
		$(this).SetBubblePopupInnerHtml( '<div style="padding:'+thepadd+'; font-size:'+fonsiz+';max-width:250px;font-family:verdana,arial,helvetica;">'+extragoods+''+ wikiPeekContent +'</div>');
		$(this).removeAttr( 'title' );
	});
});
/* end wikiboard head script */

HTML;


$myCHS = str_replace("%%NUMBERDOMAINS%%", "$domainsSaved", $myCHS);
$myCHS = str_replace("%%DOMAINSTATE%%", "$domainStateSwap", $myCHS);
$myCHS = str_replace("%%CARTSTATE%%", "$cartStateSwap", $myCHS);


return $myCHS;
}



function MainMenuHeadScript() {
	$af = "MainMenuHeadScript.js.nsf";
	$uf = "cross_browser_javascripts/MainMenuHeadScript.js";
	$obfuscatedJS = obfuscateJavascripts($af,$uf,'MainMenuHeadScript');
	return $obfuscatedJS;
}


function DOMAppScript() {
	$af = "domapp.js.nsf";
	$uf = "domapp/domapp.js";
	$obfuscatedJS = obfuscateJavascripts($af,$uf,'domapp');
	return $obfuscatedJS;
}





function WikiPeeksCoreHeadScript() {
	$af = "WikiPeeksCore-1.1.2.js.nsf";
	$uf = "cross_browser_javascripts/WikiPeeksCore-1.1.2.js";
	$obfuscatedJS = obfuscateJavascripts($af,$uf,'WikiPeeksCoreHead');
	return $obfuscatedJS;
}


function WikiPeeksWikipediaHeadScript() {
	$af = "WikiPeeksCore-Wikipedia-1.0.0.js.nsf";
	$uf = "cross_browser_javascripts/WikiPeeksCore-Wikipedia-1.0.0.js";
	$obfuscatedJS = obfuscateJavascripts($af,$uf,'WikiPeeksWikipediaHead');
	return $obfuscatedJS;
}

function WikiPeeksCoreFooterScript() {
	$af = "javascript-jquery-extension_inDocAnchorScroll-f-1.1.2.js.nsf";
	$uf = "cross_browser_javascripts/javascript-jquery-extension_inDocAnchorScroll-f-1.1.2.js";
	$obfuscatedJS = obfuscateJavascripts($af,$uf,'WikiPeeksCoreFoot');
	return $obfuscatedJS;
}





function FancyBoxHeadScript() {
$myFBF = <<<HTML
var fancyToggle = function(swatch) {
	if (swatch == 0) { $("#fancybox-title").hide(); }
	else { $("#fancybox-title").show(); }
};
var fancySlide = function(swatch) {
	if (swatch == 0) { $("#WikiPeeksSlider").animate({ top: '36px', height: '56px' }, {queue: false}); }
	else { $("#WikiPeeksSlider").animate({ top: '0px', height: '56px' }, {queue: false}); }
};
var fancyLoad = function(newurl) {
	$("#fancybox-frame").attr("src",newurl);
};

var timeTheLoad = ''; 
function formatTitle(title, currentArray, currentIndex, currentOpts) {
	gva = getViewableArea();
	return '<div id="WikiPeeksSlider" style="position:relative;top:0px;left:0px;background:url(/web_design_imagery/information-technology-tools-footer-background-bottom.png) repeat-x 0 -2px;height:56px;"><div style="padding-top:2px;"><table width="100%" cellpadding="0" cellspacing="0" style="height:56px;"><tr valign="bottom"><td align="left" nowrap><div id="WikiBoardBarTitle">' + (title && title.length ? '<b>' + title + '</b>' : '' ) + '</div></td><td align="left" nowrap><div id="WikiBoardBarHistory"></div></td><td width="100%" nowrap><div id="WikiBoardBarSpacer"></div></td><td align="right" nowrap><div id="WikiBoardBarAd"><div id="WikiBoardBarAdDisplay"></div></div></td></tr></table></div></div>';
}
var runFancyParams = function(docType) {
	$("#fancybox-title").hover( function() { $("#WikiPeeksSlider").animate({ top: '0px', height: '56px' }, {queue: false}); },
		function() { /* $("#WikiPeeksSlider").animate({ top: '36px', height: '56px' }, {queue: false}); */ },
		$("#fancybox-title").css({bottom : '0px', height: '56px', overflow: 'hidden'}),
		$("#fancybox-title").hide()
	);
	$("#fancybox-wrap").click( function() { $("#WikiPeeksSlider").animate({ top: '0px', height: '56px' }, {queue: false}); } );
	$("#topbar-center").html('<table width="100%" height="29" cellpadding="0" cellspacing="0"><tr valign="bottom"><td align="left" width="80%" style="padding-left:7px;padding-bottom:6px;" nowrap><div id="Wiki-Peeks-Document-Header"><span id="Document-Title">'+docType+'</span><span id="Wiki-Peeks-Content-Source"><span style="position:relative;top:2px;left:0px;" title="Loading, please wait..."><img src="/web_design_imagery/loadCircle.gif" width="18" height="15" border="0" alt="Loading, please wait..."></span></span><span id="Wiki-Peeks-Content-Search"></span></div></td><td align="right" width="20%" style="padding-bottom:7px;padding-right:5px;"><a href="javascript:;" class="WikiPeeksClose" onclick="$.fancybox.close();">close &nbsp;X</a></td></tr></table>');
};
var openFlashBox = function(url,w,h){ 
	myOP = 0.30; 
	if (url.indexOf("templateModal") != -1) { 
		myOP = 0.20; 
	} 
	$.fancybox({ 
		'type': 'iframe',
		href: url, 
		'titleFormat' : formatTitle,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'titleShow': true,
		'titlePosition'	:'below',
		'autoDimensions': false, 
		'width': w,
		'height': h,
	    'margin' : 40,
	    'showCloseButton' : true,
	    'closeButtonLayerOffset' : 29,
		'centerOnScroll' : true, 
		'overlayShow' : true, 
		'overlayOpacity' : myOP, 
		'hideOnOverlayClick':true,
		'padding': 0, 
		'TitleWidthOffset': 18,
		'onComplete' : function() { runFancyParams('OpenCanvas'); }
	});
};
var gva;
$(document).ready(function() {
	gva = getViewableArea();
	$(window).resize(function() {
		gva = getViewableArea();
	});
});
var wikifancy = '';
var fancyframe = '';
// fancybox
jQuery(document).ready(function() {
	wikifancy = {
		'type': 'iframe',
		'titleFormat' : formatTitle,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'titleShow': true,
		'titlePosition'	:'below',
		'width': '95%',
		'height': '88%',
	    'margin' : 40,
	    'showCloseButton' : true,
		//-- the full height of the closeButtonDiv
	    'closeButtonLayerOffset' : 29,
		'centerOnScroll' : true, 
		'overlayShow' : true, 
		'overlayOpacity' : 0.15,
		'hideOnOverlayClick':true,
		'padding': 1,
		//cutomized to take on width offsets of titlebar[dynamic left right margin]
		//see div#fancybox-title
		'TitleWidthOffset': 18,
		'onComplete' : function() { runFancyParams('Wiki Peeks'); }
	};
	$(".WikiBoard").fancybox(wikifancy);
	fancyframe = {
		'type': 'iframe',
		'titleFormat' : formatTitle,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'titleShow': true,
		'titlePosition'	:'below',
		'width': 467,
		'height': 400,
	    'showCloseButton' : true,
		//-- the full height of the closeButtonDiv
	    'closeButtonLayerOffset' : 29,
		'centerOnScroll' : true, 
		'overlayShow' : true, 
		'overlayOpacity' : 0.15,
		'hideOnOverlayClick':true,
		'padding': 1,
		//cutomized to take on width offsets of titlebar[dynamic left right margin]
		//see div#fancybox-title
		'TitleWidthOffset': 18,
		//removed the title at loadtime, now fed on the fly, much better
		'onComplete' : function() { runFancyParams(''); }
	};



});

/*dynamic calls*/
var runWikiBoard = function(quien) {
	$.fancybox(wikifancy);
	$("#fancybox-frame").attr("src",quien.rel);
};
/*dynamic calls*/
var runFancyFrame = function(quien) {
	$.fancybox(fancyframe);
	$("#fancybox-frame").attr("src",quien.rel);
};
/*dynamic calls*/
var runFancyFancy = function(quien,tat,w,h) {
	titulo = tat;
	fancyfancy = {
		'type': 'iframe',
		'titleFormat' : formatTitle,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'titleShow': true,
		'titlePosition'	:'below',
	    'showCloseButton' : true,
		'width': w,
		'height': h,
		//-- the full height of the closeButtonDiv
	    'closeButtonLayerOffset' : 29,
		'centerOnScroll' : true, 
		'overlayShow' : true, 
		'overlayOpacity' : 0.15,
		'hideOnOverlayClick':true,
		'autoDimensions':false,
		'padding': 1,
		//cutomized to take on width offsets of titlebar[dynamic left right margin]
		//see div#fancybox-title
		'TitleWidthOffset': 18,
		'onComplete' : function() { runFancyParams(titulo); }
	};
	$.fancybox(fancyfancy);
	$("#fancybox-frame").attr("src",quien);
};




HTML;
return $myFBF;
}














function AmazonAdHeadScript() {
	$af = "AmazonAdHeadScript.js.nsf";
	$uf = "cross_browser_javascripts/AmazonAdHeadScript.js";
	$obfuscatedJS = obfuscateJavascripts($af,$uf,'AmazonAdHeadScript');
	return $obfuscatedJS;
}





function FreeCaptchaHeadScript() {
	$af = "javascript-function-freecaptcha.js.nsf";
	$uf = "cross_browser_javascripts/javascript-function-freecaptcha.js";
	$obfuscatedJS = obfuscateJavascripts($af,$uf,'FreeCaptchaHeadScript');
	return $obfuscatedJS;
}






function NoRightClickHeadScript() {
$myNoRighty = <<<HTML
		/*
		function clickIE4(){if (event.button==2){return false;}}
		function clickNS4(e){if (document.layers||document.getElementById&&!document.all){if (e.which==2||e.which==3){return false;}}}
		if (document.layers){document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS4;}
		else if (document.all&&!document.getElementById){document.onmousedown=clickIE4;}
		document.oncontextmenu=new Function("return false")
		*/
HTML;
return $myNoRighty;
}












function MainDocumentHeaderMarkup($A1, $selSection, $ISIN) {

/// SELECTED SECTION/DOCUMENT LAYOUT
$miPAGINA='';
// subsection being viewed
	if ($selSection->SectionID) {
		$secTitle = $selSection->SectionTitle;
		$bgTitle = $selSection->SectionBackgroundTitle;
		$bgImage = $selSection->SectionBackgroundImage;
		$qcontactALT = "Questions about ".$selSection->SectionMainKeys." or any other information technology related topic? Contact our friendly and knowledgable staff.";
		//subsection
		if ($selSection->SID) {
			$qcontactLINK = "/Contact-Website-Design-Internet-Development-Experts/?s=".$section."&ss=".$subsection;
		}
		//section
		else {
			$qcontactLINK = "/Contact-Website-Design-Internet-Development-Experts/?s=".$section;
		}
	}
	else {
		$bgTitle = 'Web Design, Internet Marketing and Domain Names';
		$secTitle = 'Virtual Private - Home of the OpenCanvas';
		$qcontactLINK = "/Contact-Website-Design-Internet-Development-Experts/";
		$bgImage = "/web_design_imagery/vps-net-default-background.jpg";
	}

	$vploginSTATE = 'Log In';
	$vploginALT = 'Would you like to log to your Virtual Private account?';
	$vploginLINK = '/login.htm';
	$vploginHEIGHT = '260';

	#$vpaccountSTATE = 'No Account';
	#$vpaccountALT = '';
	#$vpaccountLINK = '';

	$vpaccountSTATE = 'Create Account';
	$vpaccountALT = 'Click to create a new account.';
	$vpaccountLINK = '/new-virtual-private-account.htm';

	if (!empty($ISIN)) {
		$vploginSTATE = 'Log Out';
		$vploginALT = 'Click to log out from your account.';
		$vploginLINK = '/logout.htm';
		$vploginHEIGHT = '190';

		$vpaccountSTATE = 'My Account';
		$vpaccountALT = 'Edit your account settings.';
		$vpaccountLINK = '/myaccount.htm';
	}

	$mySID = (int)$selSection->SID;
	#->1(213)293-GURU
	$myDID = 'call-technical-support-or-sales.gif';
	$callWhat = 'Need web design, internet marketing, domain registration, search engine optimization support or sales? Call us anytime: 1(213)293-GURU, or 1(213)293-4878';

	// read cart cookie
	$OpenCanvasDesign = $_COOKIE["OpenCanvasDesign"];

	// ONLY FOR website design sections
	// AND ONLY IF already modified OpenCanvas in some way [users must be seasoned]
	if (($mySID == 555 || $mySID == 1 || $mySID == 2 || $mySID == 3 || $mySID == 4) && (!empty($OpenCanvasDesign))) {
		#->1(213)2-CANVAS
		#->$myDID = 'open-canvas-website-design.gif';
		$callWhat = 'OpenCanvas Website Design: The easiest, cheapest and most admired way to have a high-quality professional business, personal or ecommerce website, blog or mobile application interactively created and designed for you. Visit us online, then call us if you have any questions: 1(213)293-GURU[4878]';
		//The proprietary technologies behind the OpenCanvas interactive web design platform, were exclusively engineered by and for Virtual Private Servers and Networks [VPS-NET]
	}
	#$myDID = ;

	
$myHeaderMark = <<<HTML
<div id="vps-net-interface" title="%%SECTITLE%%" style="position:absolute; top:0px; left:0px; visibility:hidden; max-width:980px; height:768px; overflow:hidden; clip:rect(0px,980px,768px,0px); z-index:-1000;"><img src="%%BGIMAGE%%" alt="%%BGTITLE%%" width="100%" height="100%" border="0"></div>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<center>
<table cellpadding="0" cellspacing="0" border="0" width="940" class="nobord" id="MainTopBar">
	<tr class="nobord">
		<td width="278" class="nobord" style="padding-left:15px;">
			<table cellpadding="0" cellspacing="0" border="0" class="nobord">
				<tr class="nobord">
					<td class="nobord"><div id="web_design_logo"><center><img src="/web_design_imagery/virtual_private_servers_and_networks.jpg" border="0" width="278" height="66" alt="Virtual Private Servers and Networks [VPS-NET]' Logo" onMouseOver="this.src='/web_design_imagery/virtual_private_servers_and_networks-over.jpg';" onMouseOut="this.src='/web_design_imagery/virtual_private_servers_and_networks.jpg';" style="cursor:pointer;"></center></div></td></td>
				</tr>
				<tr class="nobord">
					<td class="nobord" style="height:22px;"><center><font color="#666666" size="1" face="arial" class="web-design-questions">Questions? <a id="Contact-Virtual-Private-Support" rel="%%QuestionsContactLINK%%" title="%%QuestionsContactALT%%" onClick="javascript:runFancyFrame(this);" class="hover">Contact</a> our smart and friendly staff.</font></center></td>
				</tr>
			</table>
		</td>
		<td width="100%" class="nobord" align="center"><div id="A1" style="width:200px;height:90px;visibility:visible;overflow:hidden;clip:rect(0px,200px,90px,0px);color:#FFFFFF;font-size:1px;">%%A1%%</div></td>
		<td width="100%" class="nobord" align="right" valign="top" style="padding-right:15px;" height="18">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" class="nobord" height="18">
				<tr class="nobord">
					<td width="100%" class="nobord" align="right">
						<table cellpadding="0" cellspacing="0" border="0" class="nobord" title="We accept PayPal Visa, American Express and MasterCard for our Website Design, Internet Marketing, Domain Registration, Search Engine Optimization and Email Marketing services." height="18">
							<tr class="nobord">
								<td width="35" height="18" class="nobord" align="right"><img src="/web_design_imagery/web-design_payment_paypal_30x18.jpg" border="0" width="30" height="18" alt="We accept payments made through PayPal for our Website Design services."></td>
								<td width="35" height="18" class="nobord" align="right"><img src="/web_design_imagery/internet-marketing_payment_visa_30x18.jpg" border="0" width="30" height="18" alt="VISA payments are accepted for our Internet Marketing solutions."></td>
								<td width="35" height="18" class="nobord" align="right"><img src="/web_design_imagery/domain-registration_payment_amex_30x18.jpg" border="0" width="30" height="18" alt="You can use your American Express as payment for Domain Registration."></td>
								<td width="35" height="18" class="nobord" align="right"><img src="/web_design_imagery/search-engine-optimization_payment_mastercard_30x18.jpg" border="0" width="30" height="18" alt="The Virtual Private Search Engine Optimization Experts accept MasterCard payments."></td>
								<!--<td width="35" height="18" class="nobord" align="right"><img src="/web_design_imagery/email-marketing_google-checkout_30x18.jpg" border="0" width="30" height="18" alt="Our Email Marketing Team accepts payments made through Google Checkout"></td>-->
							</tr>
						</table>
					</td>
				</tr>
				<tr class="nobord" height="24">
					<td width="100%" class="nobord" align="right" valign="top">
						<table cellpadding="0" cellspacing="0" border="0" class="nobord" height="22">
							<tr class="nobord">
								<td class="nobord" align="right"><font color="#666666" size="1" face="arial" class="web-design-topmenu"><a id="Virtual-Private-Network-Login" rel="%%VPAccountLINK%%" title="%%VPAccountALT%%" onClick="javascript:runFancyFancy(this.rel,'Virtual Private',640,480);" class="hover">%%VPAccountSTATE%%</a></font></td>
								<td width="14" class="nobord" align="center"><font color="#666666" size="1" face="arial" class="web-design-topmenu">|</font></td>
								<td class="nobord" align="right"><font color="#666666" size="1" face="arial" class="web-design-topmenu"><a id="Virtual-Private-Network-Login" rel="%%VPLoginLINK%%" title="%%VPLoginALT%%" onClick="javascript:runFancyFancy(this.rel,'Virtual Private',580,%%VPLoginHEIGHT%%);" class="hover">%%VPLoginSTATE%%</a></font></td>
								<td width="14" class="nobord" align="center"><font color="#666666" size="1" face="arial" class="web-design-topmenu">|</font></td>
								<td class="nobord" align="right"><font color="#666666" size="1" face="arial" class="web-design-topmenu"><a id="Contact-Virtual-Private-Support" rel="/Contact-Website-Design-Internet-Development-Experts/?s=&amp;ss=" title="Have any questions or need help with web design, website templates, custom design, intuitive website design, website package or any other information technology related topic? just send our friendly and knowledgable staff a message, they'll certainly make it a mission to assist you in a timely and professional manner." onclick="javascript:runFancyFrame(this);" class="hover">Questions?</a></font></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="nobord" height="26" valign="top">
					<td width="100%" class="nobord" align="right" title="%%CALLWHATTITLE%%"><img src="/web_design_imagery/%%WHICHDID%%" border="0" width="320" height="22" alt="%%CALLWHATALT%%"></td>
				</tr>
				<tr class="nobord" height="24">
					<td width="100%" class="nobord" align="right" valign="top" style="padding-right:0px;">
						<table cellpadding="0" cellspacing="0" border="0" class="nobord" height="24" style="cursor:pointer;">
							<tr class="nobord">
								<td class="nobord">
									<div id="gui-design-your-website" style="width:111px;height:24px;">
										<table cellpadding="0" cellspacing="0" border="0" class="nobord" height="24" title="OpenCanvas, the Interactive Website Design Experience">
											<tr class="nobord">
												<td height="24" class="nobord" align="right" nowrap><div id="gui-design-your-website-image" style="width:21px;height:24px;overflow:hidden;clip:rect(0px,21px,24px,0px);" onClick="javascript:document.location.href='/opencanvas-interactive-website-design/';"><img src="/web_design_imagery/design-your-website.gif" border="0" width="21" height="24" alt=""></div></td>
												<td height="24" class="nobord" align="left" width="1"><div id="gui-design-your-website-text" style="width:90px;height:24px;overflow:hidden;" class="user_interface_menu_text"><div style="padding-left:6px;padding-top:4px;"><a rel="/opencanvas-interactive-website-design/" title="" onClick="javascript:document.location.href=''+this.rel+'';" class="user_interface_menu_text"><nobr>Build a Website</nobr></a></div></div></td>
											</tr>
										</table>
									</div>
								</td>
								<td height="18" valign="top" class="nobord" align="center" width="1" style="padding-top:2px;padding-left:12px;padding-right:12px;background:url(/web_design_imagery/user_interface_splitter.gif) no-repeat 12px 6px;"><img src="/web_design_imagery/spacer.gif" border="0" width="1" height="18"></td>
								<td class="nobord">
									<div id="gui-register-a-domain" style="width:21px;height:24px;">
										<table cellpadding="0" cellspacing="0" border="0" class="nobord" height="24" title="Search and Register Domain Names, quickly and easily. (.com, .net, .org, .tv, .ca, ,.mx, .cc)">
											<tr class="nobord">
												<td height="24" class="nobord" align="right" nowrap><div id="gui-register-a-domain-image" style="width:21px;height:24px;overflow:hidden;clip:rect(0px,21px,24px,0px);"><a rel="/domain-registration-search/internet-domain-name-registration.php" title="Search and Register Domain Names, quickly and easily. (.com, .net, .org, .tv, .ca, ,.mx, .cc)" onClick="javascript:document.location.href=''+this.rel+'';"><img src="/web_design_imagery/domain_name_search.gif" border="0" width="21" height="24" alt="Search and Register Domain Names, quickly and easily. (.com, .net, .org, .tv, .ca, ,.mx, .cc)"></a></div></td>
												<td height="24" class="nobord" align="left" width="1"><div id="gui-register-a-domain-text" style="width:0px;height:24px;overflow:hidden;" class="user_interface_menu_text"><div style="padding-left:6px;padding-top:4px;"><a rel="/domain-registration-search/internet-domain-name-registration.php" title="" onClick="javascript:document.location.href=''+this.rel+'';" class="user_interface_menu_text"><nobr>Domain Registration</nobr></a></div></div></td>
											</tr>
										</table>
									</div>
								</td>
								<td height="18" valign="top" class="nobord" align="center" width="1" style="padding-top:2px;padding-left:12px;padding-right:12px;background:url(/web_design_imagery/user_interface_splitter.gif) no-repeat 12px 6px;"><img src="/web_design_imagery/spacer.gif" border="0" width="1" height="18"></td>
								<td class="nobord">
									<div id="gui-ask-an-expert" style="width:21px;height:24px;">
										<table cellpadding="0" cellspacing="0" border="0" class="nobord" height="24" title="Need assistance with any of our services or our website? Ask one of our expert Website Designers or Internet Developers!">
											<tr class="nobord">
												<td height="24" class="nobord" align="right" nowrap><div id="gui-ask-an-expert-image" style="width:21px;height:24px;overflow:hidden;clip:rect(0px,21px,24px,0px);"><a rel="%%QuestionsContactLINK%%" title="%%QuestionsContactALT%%" onClick="javascript:runFancyFrame(this);"><img src="/web_design_imagery/ask_an_expert-support.gif" border="0" width="21" height="24" alt="Need assistance with any of our services or our website? Ask one of our expert Website Designers or Internet Developers!"></a></div></td>
												<td height="24" class="nobord" align="left" width="1"><div id="gui-ask-an-expert-text" style="width:0px;height:24px;overflow:hidden;" class="user_interface_menu_text"><div style="padding-left:6px;padding-top:4px;"><a rel="%%QuestionsContactLINK%%" title="%%QuestionsContactALT%%" onClick="javascript:runFancyFrame(this);" class="user_interface_menu_text"><nobr>Questions? Ask Us!</nobr></a></div></div></td>
											</tr>
										</table>
									</div>
								</td>
								<td height="18" valign="top" class="nobord" align="center" width="1" style="padding-top:2px;padding-left:12px;padding-right:12px;background:url(/web_design_imagery/user_interface_splitter.gif) no-repeat 12px 6px;"><img src="/web_design_imagery/spacer.gif" border="0" width="1" height="18"></td>
								<td class="nobord">
									<div id="gui-your-shopping-cart" style="width:21px;height:24px;">
										<table cellpadding="0" cellspacing="0" border="0" class="nobord" height="24" title="Your secure shopping cart is empty.">
											<tr class="nobord">
												<td height="24" class="nobord" align="right" nowrap><div id="gui-your-shopping-cart-image" style="width:21px;height:24px;overflow:hidden;clip:rect(0px,21px,24px,0px);"><img src="/web_design_imagery/website_design_cart-off.gif" border="0" width="21" height="24" alt="Your secure shopping cart is empty."></div></td>
												<td height="24" class="nobord" align="left" width="1"><div id="gui-your-shopping-cart-text" style="width:0px;height:24px;overflow:hidden;" class="user_interface_menu_text"><div style="padding-left:6px;padding-top:4px;"><nobr>Cart is Empty</nobr></div></div></td>
											</tr>
										</table>
									</div>
								</td>
								<td height="18" valign="top" class="nobord" align="center" width="1" style="padding-top:2px;padding-left:12px;padding-right:12px;background:url(/web_design_imagery/user_interface_splitter.gif) no-repeat 12px 6px;"><img src="/web_design_imagery/spacer.gif" border="0" width="1" height="18"></td>
								<td class="nobord">
									<div id="gui-currency-and-language" style="width:21px;height:24px;">
										<table cellpadding="0" cellspacing="0" border="0" class="nobord" height="24" title="Virtual Private technologies are proudly made in the USA, we've been digitally serving our country's information systems needs, professionally, since 1997.">
											<tr class="nobord">
												<td height="24" class="nobord" align="right" nowrap><div id="gui-currency-and-language-image" style="width:21px;height:24px;overflow:hidden;clip:rect(0px,21px,24px,0px);"><a href="/wikipedia.htm?st=Made_in_USA" class="WikiBoard" target="WIKI"><img src="/web_design_imagery/data_localization_flags_us-1.gif" border="0" width="21" height="24" alt="Virtual Private Technologies are proudly Made in USA, we've been digitally serving our country since 1997."></a></div></td>
												<td height="24" class="nobord" align="left" width="1"><div id="gui-currency-and-language-text" style="width:0px;height:24px;overflow:hidden;" class="user_interface_menu_text"><div style="padding-left:6px;padding-top:4px;"><nobr><a href="/wikipedia.htm?st=Made_in_USA" class="WikiBoard" target="WIKI"><span title="WikiPeeks: Made in USA [Source: Wikipedia]" class="Wiki-Peeks-Wikipedia-Javascript-jQuery"><img src="/web_design_imagery/spacer.gif" alt="WikiPeeks: Made in USA - Source: Wikipedia" height="1" border="0" width="1"></span>USA</a></nobr></div></div></td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
	    </td>
	</tr>
</table>
HTML;
$myHeaderMark2 = str_replace("%%A1%%", "$A1", $myHeaderMark);
$myHeaderMark2 = str_replace("%%BGTITLE%%", "$bgTitle", $myHeaderMark2);
$myHeaderMark2 = str_replace("%%BGIMAGE%%", "$bgImage", $myHeaderMark2);
$myHeaderMark2 = str_replace("%%SECTITLE%%", "$secTitle", $myHeaderMark2);
$myHeaderMark2 = str_replace("%%QuestionsContactALT%%", "$qcontactALT", $myHeaderMark2);
$myHeaderMark2 = str_replace("%%QuestionsContactLINK%%", "$qcontactLINK", $myHeaderMark2);

$myHeaderMark2 = str_replace("%%VPLoginALT%%", "$vploginALT", $myHeaderMark2);
$myHeaderMark2 = str_replace("%%VPLoginLINK%%", "$vploginLINK", $myHeaderMark2);
$myHeaderMark2 = str_replace("%%VPLoginSTATE%%", "$vploginSTATE", $myHeaderMark2);
$myHeaderMark2 = str_replace("%%VPLoginHEIGHT%%", "$vploginHEIGHT", $myHeaderMark2);

$myHeaderMark2 = str_replace("%%VPAccountALT%%", "$vpaccountALT", $myHeaderMark2);
$myHeaderMark2 = str_replace("%%VPAccountLINK%%", "$vpaccountLINK", $myHeaderMark2);
$myHeaderMark2 = str_replace("%%VPAccountSTATE%%", "$vpaccountSTATE", $myHeaderMark2);

$myHeaderMark2 = str_replace("%%WHICHDID%%", "$myDID", $myHeaderMark2);
$myHeaderMark2 = str_replace("%%CALLWHATTITLE%%", "$callWhat", $myHeaderMark2);
$myHeaderMark2 = str_replace("%%CALLWHATALT%%", "$callWhat", $myHeaderMark2);

return $myHeaderMark2;
}








function CarouselBodyMarkup($BrowseSelectList) {
$myCarousel = <<<HTML
			<div id="Browse-Website-Template-Designs">%%BROWSE-LIST-A%%<button id="search-button" class="sbclass" style="padding:0px;padding-left:2px;padding-right:2px;">Browse</button></div>
			<div>
			<center>
			<table cellpadding="0" cellspacing="0" border="0" class="nobord">
				<tr>
					<td class="nobord" valign="top">
						<div style="clear:both;" id="prev-arrow-container"><img id="prev-arrow" class="left-button-image" src="/website_design_template_images/left-enabled.png" alt="Previous Button"/></div>
					</td>
					<td class="nobord" valign="top">
						<div id="dhtml-carousel" class="carousel-component">
							<div class="carousel-clip-region">
								<ul class="carousel-list"></ul>
							</div>
						</div>
					</td>
					<td class="nobord" valign="top">
						<div id="next-arrow-container"><img id="next-arrow" class="right-button-image" src="/website_design_template_images/right-enabled.png" alt="Next Button"/></div>
					</td>
				</tr>
			</table>
			</center>
			</div>
HTML;
$myCarousel2 = str_replace("%%BROWSE-LIST-A%%", "$BrowseSelectList", $myCarousel);
$myCarousel2 = str_replace("%%sectionALT%%", "$SectionAlt", $myCarousel2);
$myCarousel2 = str_replace("%%sectionTITLE%%", "$SectionTitle", $myCarousel2);
$myCarousel2 = str_replace("%%sectionLINK%%", "$SectionLink", $myCarousel2);
$myCarousel2 = str_replace("%%subsectionALT%%", "$SubSectionAlt", $myCarousel2);
$myCarousel2 = str_replace("%%subsectionTITLE%%", "$SubSectionTitle", $myCarousel2);
$myCarousel2 = str_replace("%%subsectionLINK%%", "$SubSectionLink", $myCarousel2);


return $myCarousel2;
}









function StarMapperMarkup() {
$myStarMap = <<<HTML
<map name="StarRates">
	<area shape="poly" coords="58,0,64,0,64,13,58,13,58,0" href="javascript:rateMe('5.0');" title="Vote 5 Stars" alt="Vote 5 Stars" onMouseOver="mouseStars('5');" onMouseOut="resetStars();">
	<area shape="poly" coords="52,0,58,0,58,13,52,13,52,0" href="javascript:rateMe('4.5');" title="Vote 4 1/2 Stars" alt="Vote 4 1/2 Stars" onMouseOver="mouseStars('4.5');" onMouseOut="resetStars();">
	<area shape="poly" coords="45,0,53,0,53,13,45,13,45,0" href="javascript:rateMe('4.0');" title="Vote 4 Stars" alt="Vote 4 Stars" onMouseOver="mouseStars('4');" onMouseOut="resetStars();">
	<area shape="poly" coords="39,0,45,0,45,13,39,13,39,0" href="javascript:rateMe('3.5');" title="Vote 3 1/2 Stars" alt="Vote 3 1/2 Stars" onMouseOver="mouseStars('3.5');" onMouseOut="resetStars();">
	<area shape="poly" coords="32,0,40,0,40,13,32,13,32,0" href="javascript:rateMe('3.0');" title="Vote 3 Stars" alt="Vote 3 Stars" onMouseOver="mouseStars('3');" onMouseOut="resetStars();">
	<area shape="poly" coords="26,0,32,0,32,13,26,13,26,0" href="javascript:rateMe('2.5');" title="Vote 2 1/2 Stars" alt="Vote 2 1/2 Stars" onMouseOver="mouseStars('2.5');" onMouseOut="resetStars();">
	<area shape="poly" coords="19,0,26,0,26,13,19,13,19,0" href="javascript:rateMe('2.0');" title="Vote 2 Stars" alt="Vote 2 Stars" onMouseOver="mouseStars('2');" onMouseOut="resetStars();">
	<area shape="poly" coords="13,0,30,0,19,13,13,13,13,0" href="javascript:rateMe('1.5');" title="Vote 1 1/2 Stars" alt="Vote 1 1/2 Stars" onMouseOver="mouseStars('1.5');" onMouseOut="resetStars();">
	<area shape="poly" coords="6,0,13,0,13,13,6,13,6,0" href="javascript:rateMe('1.0');" title="Vote 1 Star" alt="Vote 1 Star" onMouseOver="mouseStars('1');" onMouseOut="resetStars();">
	<area shape="poly" coords="0,0,6,0,6,13,0,13,0,0" href="javascript:rateMe('0.5');" title="Vote 1/2 Star" alt="Vote 1/2 Star" onMouseOver="mouseStars('.5');" onMouseOut="resetStars();">
</map>
<div id="output" style="position:relative;z-index:10000;background:#FFFFFF;top:-160px;left:0px;"></div>
HTML;
return $myStarMap;
}








function MainDocumentMenuMarkup($sect,$subsect,$MMIs,$SMIs) {

$sectionLI = '<li class="web-design-website-hosting-services" id="%%SectionTopic%%"><a href="%%SectionLink%%" rel="%%SectionLinkX%%" style="color:#%%MAINGUI%%;" title="%%ItemTitle%%">%%SectionName%%</a></li>';

$GUIc0 = '333333';
$GUIc1 = '266899';

$tr1 = '<td class="nobord" align="center" nowrap><div style="padding-top:4px;height:20px;"><a href="%%SubSectionPage%%" id="%%SubSectionList%%" class="%%GUICLASS%%" onMouseOver="mouseTheArrow(this,\'%%SubSectionTopicNum%%\');" onMouseOut="resetTheArrow(this,\'%%SubSectionTopicNum%%\');" title="%%SubSectionTopic%%" style="%%SubSectionStyle%%">%%SubSectionName%%</a></div></td>';
$tr1space = '<td class="nobord" align="center" width="1" style="padding-left:30px;padding-right:30px;"><img src="/web_design_imagery/spacer.gif" border="0" width="1" height="20"></td>';

$tr2 = '<td height="5" class="nobord" align="center"><img src="/web_design_imagery/%%ARROWIMG%%" border="0" width="12" height="4" id="%%SubSectionTopicNum%%"></td>';
$tr2space = '<td height="5" class="nobord" align="center" width="1" style="padding-left:30px;padding-right:30px;"><img src="/web_design_imagery/spacer.gif" border="0" width="1" height="4"></td>';

$elSubMenu = '<table cellpadding="0" cellspacing="0" border="0" class="nobord"><tr class="nobord" valign="top">%%TR1%%</tr><tr class="nobord" valign="top">%%TR2%%</tr></table>';

$arrowIMAGEX = 'spacer.gif';
$arrowIMAGE1 = 'user_interface_sub_menuarrow-active.gif';

$guiCLASS0 = 'graphical-user-interface_text';
$guiCLASS1 = 'graphical-user-interface_text_active';

$elMF = '<script language="Javascript" type="text/javascript">setMainMenuFocus = "%%CualMainChosen%%";</script>';

$docMainBGi = '';

$losSections = ''; $elTopic = ''; $myTR1 = ''; $myTR2 = ''; $losSubSections = ''; $setMF = '';

if (!empty($MMIs) && !empty($sect)) {

	foreach ( $MMIs as $MMI ) {
		if ($MMI->SectionID > 0) {
			$mySectionLI0 = $sectionLI;
			$myGUI = $GUIc0;
			$myLINK = $MMI->SectionPage;
			$myMF = $elMF;
			$setMF = '';
			if ($sect == $MMI->SectionID) {
				$elTopic = "$MMI->SectionTopic";
				$myGUI = $GUIc1;
				$myLINKX = $myLINK . '?x=' . $subsect;
				$setMF = $elTopic;
				$cSID = $MMI->SectionID;
			}
			else {
				$myLINKX = $myLINK . '?s=' . $MMI->SectionID;
			}


					// create keywords for images, titles and ids
					$mainKeys = $MMI->SectionMainKeys;
					$fluffKeys = $MMI->SectionFluffKeys;
					$keyPhraseParts = explode(", ", $mainKeys);
					$cKPP = 0;
					$thisKeywordPhrase = '';
					$thisKeywordList = '';
					foreach ($keyPhraseParts as $KPP) {
						$cKPP++;
						$myKPP = trim($KPP);
						if ($cKPP > 1 && $cKPP == count($keyPhraseParts)) {
							$thisKeywordPhrase = $thisKeywordPhrase . " and " . $myKPP;
							$thisKeywordList = $thisKeywordList . " - " . $myKPP;
						}
						else if ($cKPP > 1) {
							$thisKeywordPhrase = $thisKeywordPhrase . ", " . $myKPP;
							$thisKeywordList = $thisKeywordList . " - " . $myKPP;
						}
						else {
							$thisKeywordPhrase = $myKPP;
							$thisKeywordList = $myKPP;
						}
					}
					$shortKeyPhrase = $thisKeywordPhrase;
					$shortKeyList = $thisKeywordList;
					$metaDesc = $MMI->SectionMetaDescription;


			// JS: mainMenuItem onload dynamic focus
			if ($setMF != '') { $myMF = str_replace("%%CualMainChosen%%", "$MMI->SectionTopic", $myMF); }
			else { $myMF = ''; }

			$mySectionLI1 = str_replace("%%SectionName%%", "$MMI->SectionName" . "" . "$myMF", $mySectionLI0);
			$mySectionLI1 = str_replace("%%SectionTopic%%", "$MMI->SectionTopic", $mySectionLI1);
			$mySectionLI1 = str_replace("%%SectionLink%%", "$myLINK", $mySectionLI1);
			$mySectionLI1 = str_replace("%%SectionLinkX%%", "$myLINKX", $mySectionLI1);
			$mySectionLI1 = str_replace("%%ItemTitle%%", "$shortKeyPhrase", $mySectionLI1);
			$mySectionLI1 = str_replace("%%MAINGUI%%", "$myGUI", $mySectionLI1);
			$losSections = $losSections . "" . $mySectionLI1;
		}
	}
}


$losSubSections = ''; $subTopic = ''; $subTR1 = ''; $subTR2 = ''; $losSubSections = '';

if (!empty($SMIs)) {

	$losSubSections =  $SMI->SectionID . "" . $elSubMenu;
	
	foreach ( $SMIs as $SMI ) {


					//for page title, meta and desc
					//--> DEFINE DOCUMENT TEMPLATE PARAMS
					$documentTitle = $SMI->SectionTitle;
					$mainKeys = $SMI->SectionMainKeys;
					$fluffKeys = $SMI->SectionFluffKeys;
					$keyPhraseParts = explode(", ", $mainKeys);
					$countKPP = 0;
					$subKeywordPhrase = '';
					$subKeywordList = '';
					$subKeywordItem = '';
					foreach ($keyPhraseParts as $KPP) {
						$countKPP++;
						$subKPP = trim($KPP);
						if ($countKPP > 1 && $countKPP == count($keyPhraseParts)) {
							$subKeywordPhrase = $subKeywordPhrase . " and " . $subKPP;
							$subKeywordList = $subKeywordList . " - " . $subKPP;
						}
						else if ($countKPP > 1) {
							$subKeywordPhrase = $subKeywordPhrase . ", " . $subKPP;
							$subKeywordList = $subKeywordList . " - " . $subKPP;
						}
						else {
							$subKeywordPhrase = $subKPP;
							$subKeywordList = $subKPP;
							$subKeywordItem = $subKPP;
						}
					}
					$shortKeyPhrase = $subKeywordPhrase;
					$shortKeyList = $subKeywordList;
					$metaDesc = $SMI->SectionMetaDescription;


		if ($SMI->SID == $sect) {
			$mtr1 = $tr1space;
			$mtr2 = $tr2space;
			$subArrow = $arrowIMAGEX;
			$subGUI = $guiCLASS0;
			$esteLINK = $SMI->SectionPage;
			$subCursor = "";

			// dont add space to last item
			if ($SMI->SectionID == count($SMIs)) { $mtr1 = ''; $mtr2 = ''; }

			//if x IS SET, is selected mainmenu item [only set to X from XML based call from main menu item]
			if ((isset($_REQUEST['x']))) {
				if ($_REQUEST['x'] == $SMI->SectionID) {
					$subArrow = $arrowIMAGE1;
					$subGUI = $guiCLASS1;
					$subTopic = $SMI->SectionTopic;
					$shortKeyPhrase = "You are here: " . $SMI->SectionTitle;
					$subCursor = "cursor:help;";
				}
			}
			// if actually selecting a subsection for the page we are on
			else if ($subsect > 0 && $subsect == $SMI->SectionID) {
				// make sure its not XML called
				if (!(isset($_REQUEST['s']))) {
					$subArrow = $arrowIMAGE1;
					$subGUI = $guiCLASS1;
					$subTopic = $SMI->SectionTopic;
					$shortKeyPhrase = "You are here: " . $SMI->SectionTitle;
					$subCursor = "cursor:help;";
					// this will overwrite the main menu document background [if any]
				}
			}

			$subTR1 = $tr1 . "" . $mtr1;
			$subTR2 = $tr2 . "" . $mtr2;


			//$SMI->SectionID == $subsect
			$subTopicNum = $SMI->SectionID;
			$subTR1 = str_replace("%%SubSectionTopicNum%%", "$subTopicNum", $subTR1);
			$subTR1 = str_replace("%%SubSectionName%%", "$SMI->SectionName", $subTR1);
			$subTR1 = str_replace("%%SubSectionPage%%", "$SMI->SectionPage", $subTR1);
			$subTR1 = str_replace("%%SubSectionTopic%%", "$shortKeyPhrase", $subTR1);
			$subTR1 = str_replace("%%SubSectionStyle%%", "$subCursor", $subTR1);
			$subTR1 = str_replace("%%SubSectionList%%", "$subTopic", $subTR1);
			$subTR1 = str_replace("%%GUICLASS%%", "$subGUI", $subTR1);
			$subTR2 = str_replace("%%SubSectionTopicNum%%", "$subTopicNum", $subTR2);
			$subTR2 = str_replace("%%ARROWIMG%%", "$subArrow", $subTR2);

			$losSubSections = str_replace("%%TR1%%", "$subTR1 %%TR1%%", $losSubSections);
			$losSubSections = str_replace("%%TR2%%", "$subTR2 %%TR2%%", $losSubSections);
		}
		$countSMI++;
	}
}
// clean up the markup
$losSubSections = str_replace("%%TR1%%", "", $losSubSections);
$losSubSections = str_replace("%%TR2%%", "", $losSubSections);
$myDocMark = <<<HTML
<div id="user_interface_main_menubar">
	<ul id="web-design-scripts" class="website-design-mainmenu">
		%%LOSSECTIONS%%
	</ul>
</div>
<div id="graphical-user-interface">
	<table cellpadding="0" cellspacing="0" border="0" class="nobord" width="880" style="background:url(/web_design_imagery/user_interface_sub_menubar-span.gif) repeat-x 0 0;">
		<tr class="nobord">
			<td class="nobord" align="left" valign="top" width="10"><img src="/web_design_imagery/user_interface_sub_menubar-left.gif" border="0" width="10" height="25"></td>
			<td class="nobord" align="center" valign="top">
				%%LOSSUBS%%
			</td>
			<td class="nobord" align="right" valign="top" width="10"><img src="/web_design_imagery/user_interface_sub_menubar-right.gif" border="0" width="10" height="25"></td>
		</tr>
	</table>
</div>
<script language="Javascript" type="text/javascript">
%%DocMainBGi%%
\$("#vps-net-internet-home").css('display','none').css('visiblity','hidden');
</script>
HTML;
/*above we hide vps-net-internet-home, the Section page link within our top/main menu, we don't need it there*/

$myDocMark = str_replace("%%LOSSECTIONS%%", "$losSections", $myDocMark);
$myDocMark = str_replace("%%LOSSUBS%%", "$losSubSections", $myDocMark);
$myDocMark = str_replace("%%DocMainBGi%%", "$docMainBGi", $myDocMark);
return $myDocMark;
}
?>
