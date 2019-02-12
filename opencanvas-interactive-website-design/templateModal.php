<?php

##################################################################
#   Program:        OpenCanvas Interactive Website Design        #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2009 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:      User Interface Design and User Experience    #
#        Module:    Modal View for Template Preview Document     #
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

	$phpCompileOS = $_SERVER["SERVER_SOFTWARE"];
	if (stristr($phpCompileOS, 'WIN') !== FALSE) {
		$HTTPRoot = 'H:/dvwf/rbsd_IO/vhosts/vsnet/htdocsNEW/';
	}
	else { $HTTPRoot = '/var/www/vps-net.com/htdocs/'; }

	/*define local working table*/
	define("VPSSQL_DB_NAME", "vpsnetcom");

	/** load VPS-DB-CONFIG */
	require_once($HTTPRoot.'vps-config.php' );

	/** load VPS-DATA-TOOLS */
	require_once($HTTPRoot.'dataToolie.php' );

	// read ocv
	$OpenCanvasVersion = $_COOKIE["OpenCanvasVersion"];
	$elOCv = 'OCv'; $cualOCv = '1';
	if (!empty($OpenCanvasVersion)) { $cualOCv = $OpenCanvasVersion; }
	$elOCv .= $cualOCv;

	/** load INTERFACING[DOC-HEAD DOC-FOOT MAIN-MENUS MAIN-FUNCTIONS] */
	require_once($HTTPRoot.'interface_design_templater.php' );

	//--> DEFINE DOCUMENT TEMPLATE PARAMS
	$headScriptJS = '';
	$headStyleCSS = '';

	//--> DEFINE DOCUMENT HEAD CONTENT [scripts/css]
	//--> CarouselHeadScript(0,0,showing,scrolling,width,idDragDrop)
//	$headScriptJS = "\n" . NoRightClickHeadScript() . "\n";
	$headStyleCSS = "\n" . CommonHeadCSS() . "\n";
	$headScriptJSLinks = "\n" . CommonHeadJavascriptLinks() . "\n";
	$headStyleCSSLinks = "\n" . CommonHeadCSSLinks() . "\n";


	// REQUEST DOCUMENT TEMPLATE BASED ON ABOVE PARAMS: templater.php
	// NEW section/subsection HEAD/META info is overwritted using pre-defined DB data
	$myHeadPiece = commonHead($cs1, $cs2, $cs3, $docHeader, $pageTitle, $mainKeywords, $shortKeywordList, $shortKeywordPhrase, $fluffyKeywords, $metaDescription, $headScriptJS, $headStyleCSS, $headScriptJSLinks, $headStyleCSSLinks, $onLoadScript, $documentBodyHeader,$section,$subsection,$mainMenuItems,$subMenuItems);


header('Cache-Control: must-revalidate');

error_reporting(E_ALL);

/*create array hash of category titles*/
$catName = array();
$categories = $db->get_results("SELECT * FROM Categories WHERE 1=1");
foreach ( $categories as $category ) {
	$catName[$category->CatID] = $category->CatName;
}

$starChartParse = array(); 
$starChartParse['10'] = '0.5'; 
$starChartParse['20'] = '1.0'; 
$starChartParse['30'] = '1.5'; 
$starChartParse['40'] = '2.0'; 
$starChartParse['50'] = '2.5'; 
$starChartParse['60'] = '3.0'; 
$starChartParse['70'] = '3.5'; 
$starChartParse['80'] = '4.0'; 
$starChartParse['90'] = '4.5'; 
$starChartParse['100'] = '5.0';

##- 2017
## import_request_variables deprecated in PHP 5.3
## import_request_variables("gp", "rvar_");
## rewritten from $rvar_width to $width, $rvar_height to $height, $rvar_query to $query, $rvar_results to $results
$query = isset($_GET['query']) ? $_GET['query'] : '';
$height = isset($_GET['height']) ? $_GET['height'] : '';
$width = isset($_GET['width']) ? $_GET['width'] : '';
$results = isset($_GET['results']) ? $_GET['results'] : '';

if (empty($query)) { $query = '55560'; }
if (empty($width)) { $width = '250'; }
if (empty($height)) { $height = '250'; }


##-- get template number
$TN = $query;

##only query for good items
if ($TN > 55555) {
	$dbresults = $db->get_results("SELECT * FROM TemplateCentral WHERE TID = '$TN'");
}

$results = 1;

$myHeadPiece = str_replace('<div id="vps-net-virtual-private-servers-networks" class="stretch" style="width:100%">', '', $myHeadPiece);
$myHeadPiece = str_replace('<div class="topKeys" title=""></div>', '', $myHeadPiece);
echo $myHeadPiece;

$countParsed = 0;
$countTotal = count($dbresults);
if (!empty($dbresults)) {
	foreach ( $dbresults as $result ) {
		$misCategories = '';
		$losCategories = '';
		if ($countParsed < $dbresults) {
			$myPrice = $result->Price; $myPrice = ($myPrice + 555);
			$buyoutPrice = $result->BuyoutPrice; $buyoutPrice = ($buyoutPrice + 555);
			
			$myPrice = format_money($myPrice);
			$buyoutPrice = format_money($buyoutPrice);
			
			
			$misCategories = explode(", ", $result->Category);

//			$cStart = '<a onClick=javascript:parent.tb_remove();parent.loadCategory(';
			$cStart = '<a onClick=javascript:parent.$.fancybox.close();parent.loadCategory(';
			$cMid = ',' . $result->TID . '); class="activityLink" style="cursor:pointer;">';
			$cEnd = '</a>';

			$countMC = 0;
			foreach($misCategories as $uncat) {
				$countMC++;
				$inbetween = '';
				if (count($misCategories) > $countMC) { $inbetween = ', '; }
				$losCategories = $losCategories . '' . $cStart .''. $uncat .''. $cMid . ''. $catName[$uncat] .'' . $cEnd . '' . $inbetween;
        	}
			
			$selectedRank = $result->Rank;
			if ($selectedRank > 0) { $myRank = $starChartParse[$selectedRank]; }
			else { $myRank = '0.5'; }

    		$start = "images.";
    		$end = ".com";

			$miPagi = "" . $result->PreviewPage . "";
    		$out = findinside($start, $end, $miPagi);

			/* common pages are popped in new window */
			$thisPreviewType = "ISNOTFLASH";
			$cualScript = "parent.previewTemplate";

			/* flash are embeded into current document */
			if (!empty($out)) {
				if ($out[0] === "templatemonster") {
					$thisPreviewType = ""; $cualScript = "parent.runFlash"; 
				}
			}

// topKeys height is 28px (23 for height + 5 top margin)
echo '
<style>
#templateModalImage { background: #C5DAED; }
#templateModalImage img { margin:1px; border: #FFFFFF 1px solid; }
.templateModalData { padding:10px; padding-top:20px; padding-bottom:20px; padding-right:35px; padding-left:30px; text-align:left; }
.templateModalData div { padding-left:7px; margin-top:14px; background: url(/web_design_imagery/graphical-user-interface-arrow_off.gif) no-repeat 0px 5px; text-align:left; font-weight:normal; }
.templateModalData div div { line-height:18px; margin-top:3px; background: none; }
.templateModalData div div div { padding-left:0px; }
.templateModalDasher { padding-right:10px; background: none; }
</style>
<!--<div class="topKeys" style="text-align:center; color:#000000; font-size:11px; font-family:tahoma,arial,verdana;" title="OpenCanvas v3 - Advanced Website Package"><b>Open<font style="color:#266899;">Canvas</font> v3 - Advanced Website Package</div>-->
<table cellpadding="10" cellspacing="0" border="0" class="nobord" width="100%">
	<tr><td colspan="3" height="40">&nbsp;</td></tr>
	<tr>
		<td align="left" valign="middle" width="100%">
			<div class="templateModalData">
				<div>
					<div><b>Design/Website Type:</b>
						<div><table cellpadding="0" border="0" cellspacing="0"><tr valign="top"><td class="templateModalDasher">-</td><td align="left">Joomla 1.5 Design</td></tr></table></div>
					</div>
				</div>
<!--
				<div>
					<div><b>Design ID:</b>
						<div><table cellpadding="0" border="0" cellspacing="0"><tr valign="top"><td class="templateModalDasher">-</td><td align="left"><a href="javascript:'.$cualScript.'('.$result->TID.');">'.$elOCv.''.$result->TID.'</a></td></tr></table></div>
					</div>
				</div>
				<div>
					<div><b>Designer:</b>
						<div><table cellpadding="0" border="0" cellspacing="0"><tr valign="top"><td class="templateModalDasher">-</td><td align="left">Svelte</td></tr></table></div>
					</div>
				</div>
-->
				<div>
					<div><b>Downloads (Times Purchased):</b>
						<div><table cellpadding="0" border="0" cellspacing="0"><tr valign="top"><td class="templateModalDasher">-</td><td align="left">1</td></tr></table></div>
					</div>
				</div>
				<div>
					<div><b>Sources Available:</b>
						<div><table cellpadding="0" border="0" cellspacing="0"><tr valign="top"><td class="templateModalDasher">-</td><td align="left">.PSD | .PHP</td></tr></table></div>
					</div>
				</div>
				<div>
					<div><b>Software Required:</b>
						<div><table cellpadding="0" border="0" cellspacing="0"><tr valign="top"><td class="templateModalDasher">-</td><td align="left">Adobe Photoshop CS+; Adobe Dreamweaver 8+ (or any php-editor); For uncompressing a template ZIP package: WinZip 9+ (Windows); Stuffit Expander 10+ (Mac); Joomla! 1.5.0</td></tr></table></div>
					</div>
				</div>
				<div>
					<div><b>Related Categories:</b>
						<div><table cellpadding="0" border="0" cellspacing="0"><tr valign="top"><td class="templateModalDasher">-</td><td align="left">'.$losCategories.'</td></tr></table></div>
					</div>
				</div>
			</div>
			<div><center>| - <a href="javascript:'.$cualScript.'('.$result->TID.');">full template preview</a> - | - <a href="javascript:parent.$.fancybox.close();parent.appendToCanvas('.$result->TID.');">add to canvas</a> - |</center></div>
		</td>
		<td class="nobord" align="right" valign="top" id="templateModalImage" onClick="javascript:'.$cualScript.'('.$result->TID.');"><img src="http://www.vps-net.com/opencanvas-interactive-website-design/website-design-template-images.htm?t='.$elOCv.''.$result->TID.'&k=s&s=tm" width="'.$result->ScreenshotWidth.'" height="'.$result->ScreenshotHeight.'" border="0"></td>
		<td class="nobord"><img src="http://www.vps-net.com/web_design_imagery/spacer.gif" width="30" height="1" border="0"></td>
	</tr>
	<tr><td colspan="3" height="29">&nbsp;</td></tr>
</table>
';
		}
	}
}


?>

</body>
</html>