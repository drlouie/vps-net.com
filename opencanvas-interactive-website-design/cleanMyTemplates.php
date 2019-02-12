<?php

##################################################################
#   Program:        OpenCanvas Interactive Website Design        #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2009 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:      User Interface Design and User Experience    #
#        Module:    Carousel Template Paginator (by Category)    #
#        Info:      Asynchronously loads templates into the UX   #
#                   by way of JSON output.                       #
#        Interface: CarouselHeadScript.js                        #
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


$HTTPRoot = '/var/www/vps-net.com/htdocs/'; 

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

/*request response*/
//header('Content-type: text/json; charset: UTF-8');
header('Cache-Control: must-revalidate');

error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );

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
## rewritten from $rvar_results to $results, $rvar_start to $start, $rvar_query to $query, $rvar_innoprice to $innoprice
$query = isset($_GET['query']) ? $_GET['query'] : '';
$start = isset($_GET['start']) ? $_GET['start'] : '';
$results = isset($_GET['results']) ? $_GET['results'] : '';
$innoprice = isset($_GET['innoprice']) ? $_GET['innoprice'] : '';

if (empty($query)) { $query = '1'; }
if (empty($start)) { $start = '1'; }
if (empty($results)) { $results = '10'; }
//--starting price for each template in the canvas [0]
if (empty($innoprice)) { $innoprice = '0'; }

// read cart cookie
if (isset($_COOKIE["OpenCanvasDesign"]) && strlen($_COOKIE["OpenCanvasDesign"]) > 10) {
	$inUID = $OpenCanvasDesign;
	$USCART = $db->get_row("SELECT * FROM customerScarts WHERE UID = '$inUID'");
	$myCartID = $USCART->CartID;
	$myHistory = $USCART->Historic;
	$myFavorites = $USCART->Favorites;
	$myTrash = $USCART->Trash;
	$cs0 = $myCartID;
	$cs1 = $myHistory;
}

if ($query == "favorites" || $query == "trash") { 
		$cs2 = $myFavorites;
		$cs3 = $myTrash;
		// fav has unlimited slots and fed if avail
		if (!empty($cs2) && $query == "favorites") {
			$cs2X = $cs2;
			if (stristr($cs2, ',') === FALSE) {
				$tripSQLquery = "TID = '".$cs2."'";
			}
			else {
				$cFavoritesItems = explode(",", $cs2X);
				$tripSQLquery = "(TID = '" . implode("' OR TID = '",$cFavoritesItems) . "')";
			}
		}
		// trash has unlimited slots and fed if avail
		if (!empty($cs3) && $query == "trash") {
			$cs3X = $cs3;
			if (stristr($cs3, ',') === FALSE) { 
				$tripSQLquery = "TID = '".$cs3."'"; 
			}
			else {
				$cTrashItems = explode(",", $cs3X);
				$tripSQLquery = "(TID = '" . implode("' OR TID = '",$cTrashItems) . "')";
			}
		}
}
// start at true DB RECORD 1 which is actually 0, all subsequent queries are also affected, all works in line
$start = ($start-1);
echo '{"ResultSet":{"Result":[
';



if (empty($tripSQLquery)) {
	$totalResults = $db->get_results("SELECT * FROM TemplateCentral WHERE (Category = '$query' OR Category LIKE '$query, %' OR Category LIKE '%, $query,%' OR Category LIKE '%, $query') AND (ScreenshotHeight > 0 AND ScreenshotWidth > 0 AND Screenshots > 0 AND VirtualStatus = 'Active')");
	$results = $db->get_results("SELECT * FROM TemplateCentral WHERE (Category = '$query' OR Category LIKE '$query, %' OR Category LIKE '%, $query,%' OR Category LIKE '%, $query')  AND (ScreenshotHeight > 0 AND ScreenshotWidth > 0 AND Screenshots > 0 AND VirtualStatus = 'Active') ORDER BY Rank DESC LIMIT $start, $results");
}
else {
	$totalResults = $db->get_results("SELECT * FROM TemplateCentral WHERE $tripSQLquery");
	$results = $db->get_results("SELECT * FROM TemplateCentral WHERE $tripSQLquery  AND (ScreenshotHeight > 0 AND ScreenshotWidth > 0 AND Screenshots > 0 AND VirtualStatus = 'Active') ORDER BY Rank DESC LIMIT $start, $results");
}

$countParsed = 0;
$countTotal = count($totalResults);
if (!empty($results)) {
	foreach ( $results as $result ) {
		$misCategories = '';
		$losCategories = '';
		if ($countParsed < $results) {
			#$myPrice = $result->Price; $myPrice = ($myPrice + $innoprice);
			$myPrice = '0.00';
			$buyoutPrice = $result->BuyoutPrice; $buyoutPrice = ($buyoutPrice + $innoprice);
			$myPrice = format_money($myPrice);
			$buyoutPrice = format_money($buyoutPrice);
			##-- toggles unique {buyout} pricing on/off
			$priceToggle = '0';
			if (!empty($cs1)) {
				$miHisto = "" . $cs1 . "";
				$elS = "|" . $result->TID . "";
    			$his = findinside($elS, "", $miHisto);
				if (!empty($his)) {
					$priceToggle = '1';
				}
			}

			##-- comments empty: 0 | has: 1
			$commentsToggle = '0';
			if (!empty($cs0)) {
				$myCID = $cs0;
				$myTID = $result->TID;
				$USCOMMENT = $db->get_row("SELECT * FROM CommentsLog WHERE (CartID = '$myCID' AND TemplateID = '$myTID' AND UID = '$inUID')");
				$cs4 = $USCOMMENT;
				if (!empty($cs4)) {
					$myComments = $USCOMMENT->Comment;
					$commentsToggle = '1';
				}
			}

			$misCategories = explode(", ", $result->Category);
			$cStart = '<span onClick=javascript:loadCategory(';
			$cMid = ',' . $result->TID . '); class=activityLink>';
			$cEnd = '</span>';

			$countMC = 0;
			foreach($misCategories as $uncat) {
				if (!empty($uncat))	{
					$countMC++;
					$inbetween = '';
					if (count($misCategories) > $countMC) { $inbetween = ', '; }
					$losCategories = $losCategories . '' . $cStart .''. $uncat .''. $cMid . ''. $catName[$uncat] .'' . $cEnd . '' . $inbetween;
				}
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
			$cualScript = "previewTemplate";

			/* flash are embeded into current document */
			if (!empty($out)) {
				if ($out[0] === "templatemonster") {
					$thisPreviewType = ""; $cualScript = "runFlash"; 
				}
			}

			$myType = "".$result->Type."";
			require_once($HTTPRoot.'opencanvas-interactive-website-design/TerminologyMarkup.php' );
			$markedupT = str_replace($term, $desc, $myType);

			/* pToggle, Comments = DB controlled pricing toggler for templates by id*/
			echo '{"Thumb":{"Url":"/opencanvas-interactive-website-design\/website-design-template-images.htm?t='.$elOCv.''.$result->TID.'&k=t&s=tm","Height":"145","Width":"133"},"Screenshot":{"Url":"/opencanvas-interactive-website-design\/website-design-template-images.htm?t='.$elOCv.''.$result->TID.'&k=s&s=tm","Height":"'.$result->ScreenshotHeight.'","Width":"'.$result->ScreenshotWidth.'"},
			"Price":"'.$myPrice.'",
			"Buyout":"'.$buyoutPrice.'",
			"pToggle":"'.$priceToggle.'",
			"Url":"javascript:runTemplate(\''.$result->TID.'\');",
			"Title":"'.$markedupT.'",
			"id":"'.$result->TID.'",
			"Rank":"'.$myRank.'",
			"Category":"'.$losCategories.'",
			"Comments":"'.$commentsToggle.'",
			"tipo":"javascript:'.$cualScript.'('.$result->TID.');"}';
			// last item doesn't need COMMA appended to end of result
			if ($countParsed == 9) { echo ''; }
			else { echo ','; }
			$countParsed++;
		}
	}
}


?>],
"totalResultsAvailable":"<?php echo $countTotal;?>","_attributes":{"totalResultsAvailable":"<?php echo $countTotal;?>","xmlns:xsi":"http:\/\/www.w3.org\/2001\/XMLSchema-instance","xmlns":"urn:yahoo:travel","xsi:schemaLocation":"urn:yahoo:travel http:\/\/api.travel.yahoo.com\/TripService\/V1.1\/TripSearchResponse.xsd","firstResultPosition":"1","totalResultsReturned":"<?php echo $countParsed;?>"},"firstResultPosition":"1","totalResultsReturned":"<?php echo $countParsed;?>"}}
