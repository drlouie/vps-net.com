<?php

################################################################
#   Program:    Advertisement Serving Script                   #
#   Author:     Luis Gustavo Rodriguez (drlouie)               #
#   Copyright:  (c) 2016 Luis G. Rodriguez                     #
#   Licensing:  MIT License                                    #
#   About                                                      #
#        Type:  Image and Interactive Advertisments            #
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
	
	///////////////////////////////////////////
	//--> START: CUSTOMIZE ADVERTISEMENTS <--//
	///////////////////////////////////////////
//	$CommonADQuery = "AdKeys LIKE '%Security%' OR AdKeys LIKE 'Security%' OR AdKeys LIKE '%Security' OR AdKeys LIKE '%Encrypt%' OR AdKeys LIKE '%Encrypt' OR AdKeys LIKE 'Encrypt%'";


	//-->> AD3 right bar spot(s) [1 OR 2 spots]
	$Advertisement3x1style='padding-top:0px;width:0px;height:0px;';$Advertisement3x1w='0';$Advertisement3x1h='0';$AD3x1advert = 'Advertisement';$Advertisement3x1spacerW='0';$Advertisement3x1spacerH='0';
	$AD3 = $db->get_results("SELECT * FROM AffAdvertisements where AdSpot='AD3' AND VirtualStatus = 'Active' AND ($CommonADQuery) order by rand() limit 2");
	if (count($AD3) > 0) {
		//-->> AD3 NO LOCAL IMAGE
		if ($AD3[0]->DisplayImage == "" && $AD3[0]->AdImageURL == "") {
			$Advertisement3x1 = '<div>'.$AD3[0]->AdText.'</div>'; 
		}
		else if ($AD3[0]->DisplayImage == "" || $AD3[0]->DisplayImage == $AD3[0]->AdImageURL) {
			$Advertisement3x1 = '<a href="'.$AD3[0]->AdLink.'" target="Advertisement" title="'.$AD3[0]->AdKeys.'"><img src="'.$AD3[0]->AdImpressionURL.'" width="'.$AD3[0]->AdImageWidth.'" height="'.$AD3[0]->AdImageHeight.'" border="0" alt="'.$AD3[0]->AdText.'"></a>'; $Advertisement3x1w = $AD3[0]->AdImageWidth; $Advertisement3x1h = $AD3[0]->AdImageHeight; 
		}
		//-->> AD3 LOCAL IMAGE [AD IMPRESSION IMAGE TO AD]
		else { $Advertisement3x1 = '<a href="'.$AD3[0]->AdLink.'" target="Advertisement" title="'.$AD3[0]->AdKeys.'"><img src="'.$AD3[0]->DisplayImage.'" width="'.$AD3[0]->DisplayImageWidth.'" height="'.$AD3[0]->DisplayImageHeight.'" border="0" alt="'.$AD3[0]->AdText.'"></a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD3[0]->AdImpressionURL.'" width="1" height="1" border="0"></div>'; $Advertisement3x1w = $AD3[0]->DisplayImageWidth;  $Advertisement3x1h = $AD3[0]->DisplayImageHeight; }
		//-->> AD3 IF w is less than 150 [make 'Advertisement' smaller]
		if ($Advertisement3x1w < 150) { $AD3x1advert = '<span style="cursor:help;" title="Advertisement">Advert</span>'; }
		$Advertisement3x1title = $AD3x1advert.': <a href="'.$AD3[0]->AdLink.'" target="Advertisement" title="'.$AD3[0]->AdText.'">'.$AD3[0]->AdTitle.'</a>';
		//-->> AD3 STYLE THE LAYER
		$Advertisement3x1style = "width:".($Advertisement3x1w+1)."px;height:".($Advertisement3x1h+1)."px;";
			 //-->> AD3 PRESET PADDING AND DIV RESIZE ONLY IF BORDER IS ON
			if ((int)$AD3[0]->ShowBorder > 0) { $Advertisement3x1style = $Advertisement3x1style . "border:".$AD3[0]->ShowBorder."px ".$AD3[0]->BorderStyle.";padding-top:".$AD3[0]->ShowBorder."px;padding-left:".$AD3[0]->ShowBorder."px;"; }
			//-->> AD3x1 SPACER AFTER ADVERTISEMENT
			$Advertisement3x1spacerW='220';$Advertisement3x1spacerH='40';
			$Advertisement3x1spacer='width:220px;height:40px;overflow:hidden;clip:rect(0px,220px,40px,0px);';
			//-->> AD3 SETUP IMPRESSION COUNT
			$AD3countX1 = $AD3[0]->Impressions + 1; $AD3idX1 = $AD3[0]->AID;
	}


	//-->> AD3 right bar spot(s) 3x2 = TEXT/HTML AD [NO IMAGE - EXAMPLE: WHOIS PAGES]
	/*
	$Advertisement3x2style='padding-top:0px;width:0px;height:0px;';$Advertisement3x2w='0';$Advertisement3x2h='0';$AD3x2advert = 'Advertisement';$Advertisement3x2spacerW='0';$Advertisement3x2spacerH='0';
	$AD3 = $db->get_results("SELECT * FROM AffAdvertisements where AdSpot='AD3' AND VirtualStatus = 'Active' AND ($CommonADQuery) order by rand() limit 2");
	if (count($AD3) > 0) {
		$Advertisement3x2 = '<div>some</div>';
		$Advertisement3x2w = $AD3[0]->AdImageWidth; $Advertisement3x2h = $AD3[0]->AdImageHeight; 
		$AD3countx2 = $AD3[0]->Impressions + 1; $AD3idx2 = $AD3[0]->AID;
	}
	*/



	//-->> setup AD3side bottom spot
	$Advertisement3s2x1style='padding-top:0px;width:0px;height:0px;';$Advertisement3s2x1w='0';$Advertisement3s2x1h='0';$AD3s2x1advert = 'Advertisement';$Advertisement3s2x1spacerW='0';$Advertisement3s2x1spacerH='0';

	//-->> AD3side bottom spot [if spot AD3 MAIN is larger than 300px HEIGHT MAKE AD3main NOTHING and AD3s2 becomes AD3main- bottom]
	if ($Advertisement3x1h > 300 && !isset($ForceDouble)) {
		//make s2 mirror main
		$Advertisement3s2x1=$Advertisement3x1;
		$Advertisement3s2x1style=$Advertisement3x1style;
		$Advertisement3s2x1w=$Advertisement3x1w;
		$Advertisement3s2x1h=$Advertisement3x1h;
		$Advertisement3s2x1spacerW=$Advertisement3x1spacerW;
		$Advertisement3s2x1spacerH=$Advertisement3x1spacerH;
		$Advertisement3s2x1title = $Advertisement3x1title;
		// clear main
		$Advertisement3x1='';$Advertisement3x1title='';$Advertisement3x1style='padding-top:0px;width:0px;height:0px;';$Advertisement3x1w='0';$Advertisement3x1h='0';$AD3x1advert = 'Advertisement';$Advertisement3x1spacerW='0';$Advertisement3x1spacerH='0';
	}

	//-->> AD3side bottom spot [if spot AD3 MAIN is smaller than 200px HEIGHT add an AD2 sized item to AD3s2 - bottom]
	else if ($Advertisement3x1h < 200 || isset($ForceDouble)) {
		if (!isset($ForceDouble)) {
			$HeightQuery = "AND AdImageHeight < 200";
		}
		$AD3s2 = $db->get_results("SELECT * FROM AffAdvertisements where AdSpot='AD2' AND VirtualStatus = 'Active' $HeightQuery AND ($CommonADQuery) order by rand() limit 2");
		// if first ad was small height, less than 200px, then we add another ad to the bottom of the bar[right]
		if (count($AD3s2) > 1) {
			//-->> AD3 NO LOCAL IMAGE
			if ($AD3s2[0]->DisplayImage == "" || $AD3s2[0]->DisplayImage == $AD3s2[0]->AdImageURL) {$Advertisement3s2x1 = '<a href="'.$AD3s2[0]->AdLink.'" target="Advertisement" title="'.$AD3s2[0]->AdKeys.'"><img src="'.$AD3s2[0]->AdImpressionURL.'" width="'.$AD3s2[0]->AdImageWidth.'" height="'.$AD3s2[0]->AdImageHeight.'" border="0" alt="'.$AD3s2[0]->AdText.'"></a>'; $Advertisement3s2x1w = $AD3s2[0]->AdImageWidth; $Advertisement3s2x1h = $AD3s2[0]->AdImageHeight; }
			//-->> AD3 LOCAL IMAGE [AD IMPRESSION IMAGE TO AD]
			else { $Advertisement3s2x1 = '<a href="'.$AD3s2[0]->AdLink.'" target="Advertisement" title="'.$AD3s2[0]->AdKeys.'"><img src="'.$AD3s2[0]->DisplayImage.'" width="'.$AD3s2[0]->DisplayImageWidth.'" height="'.$AD3s2[0]->DisplayImageHeight.'" border="0" alt="'.$AD3s2[0]->AdText.'"></a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD3s2[0]->AdImpressionURL.'" width="1" height="1" border="0"></div>'; $Advertisement3s2x1w = $AD3s2[0]->DisplayImageWidth;  $Advertisement3s2x1h = $AD3s2[0]->DisplayImageHeight; }
			//-->> AD3 IF w is less than 150 [make 'Advertisement' smaller]
			if ($Advertisement3s2x1w < 150) { $AD3s2x1advert = '<span style="cursor:help;" title="Advertisement">Advert</span>'; }
			$Advertisement3s2x1title = $AD3s2x1advert.': <a href="'.$AD3s2[0]->AdLink.'" target="Advertisement" title="'.$AD3s2[0]->AdText.'">'.$AD3s2[0]->AdTitle.'</a>';
			//-->> AD3 STYLE THE LAYER
			$Advertisement3s2x1style = "width:".($Advertisement3s2x1w+1)."px;height:".($Advertisement3s2x1h+1)."px;";
				 //-->> AD3 PRESET PADDING AND DIV RESIZE ONLY IF BORDER IS ON
				if ((int)$AD3s2[0]->ShowBorder > 0) { $Advertisement3s2x1style = $Advertisement3s2x1style . "border:".$AD3s2[0]->ShowBorder."px ".$AD3s2[0]->BorderStyle.";padding-top:".$AD3s2[0]->ShowBorder."px;padding-left:".$AD3s2[0]->ShowBorder."px;"; }
				//-->> AD3s2x1 SPACER AFTER ADVERTISEMENT
				$Advertisement3s2x1spacerW='220';$Advertisement3s2x1spacerH='40';
				$Advertisement3s2x1spacer='width:220px;height:40px;overflow:hidden;clip:rect(0px,220px,40px,0px);';
				//-->> AD3 SETUP IMPRESSION COUNT
				$AD3countX2 = $AD3s2[0]->Impressions + 1; $AD3idX2 = $AD3s2[0]->AID;
		}
	}

	//-->> AD4 medium spots AD4 [3]
	$Advertisement4x1style='padding-top:0px;width:0px;height:0px;';$Advertisement4x1w='0';$Advertisement4x1h='0';$Advertisement4x2style='padding-top:0px;width:0px;height:0px;';$Advertisement4x2w='0';$Advertisement4x2h='0';$Advertisement4x3style='padding-top:0px;width:0px;height:0px;';$Advertisement4x3w='0';$Advertisement4x3h='0';
	$AD4 = $db->get_results("SELECT * FROM AffAdvertisements where AdSpot='AD4' AND VirtualStatus = 'Active' AND ($CommonADQuery) order by rand() limit 3");
	//-->> [AD4 x1]
	if (count($AD4) > 0) {
		$Advertisement4x1 = '<a href="'.$AD4[0]->AdLink.'" target="Advertisement" title="'.$AD4[0]->AdKeys.'"><div style="padding-bottom:12px;"><img src="'.$AD4[0]->DisplayImage.'" width="'.$AD4[0]->DisplayImageWidth.'" height="'.$AD4[0]->DisplayImageHeight.'" border="0" alt="'.$AD4[0]->AdText.'"></div></a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD4[0]->AdImpressionURL.'" width="1" height="1" border="0"></div>';
		$Advertisement4x1title = 'Advertisement: <a href="'.$AD4[0]->AdLink.'" target="Advertisement" title="'.$AD4[0]->AdText.'">'.$AD4[0]->AdTitle.'</a>';
		if ($AD4[0]->DisplayImage == "" || $AD4[0]->DisplayImage == $AD4[0]->AdImageURL) { $Advertisement4x1 = '<a href="'.$AD4[0]->AdLink.'" target="Advertisement" title="'.$AD4[0]->AdKeys.'"><div style="padding-bottom:12px;"><img src="'.$AD4[0]->AdImpressionURL.'" width="'.$AD4[0]->AdImageWidth.'" height="'.$AD4[0]->AdImageHeight.'" border="0" alt="'.$AD4[0]->AdText.'"></div></a>'; $Advertisement4x1w = $AD4[0]->AdImageWidth; $Advertisement4x1h = $AD4[0]->AdImageHeight; }
		else { $Advertisement4x1 = '<a href="'.$AD4[0]->AdLink.'" target="Advertisement" title="'.$AD4[0]->AdKeys.'"><div style="padding-bottom:12px;"><img src="'.$AD4[0]->DisplayImage.'" width="'.$AD4[0]->DisplayImageWidth.'" height="'.$AD4[0]->DisplayImageHeight.'" border="0" alt="'.$AD4[0]->AdText.'"></div></a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD4[0]->AdImpressionURL.'" width="1" height="1" border="0"></div>'; $Advertisement4x1w = $AD4[0]->DisplayImageWidth; $Advertisement4x1h = $AD4[0]->DisplayImageHeight; }
		$Advertisement4x1style = "width:".($Advertisement4x1w+2)."px;height:".($Advertisement4x1h+1)."px;";
			if ((int)$AD4[0]->ShowBorder > 0) { $Advertisement4x1style = $Advertisement4x1style . "border:".$AD4[0]->ShowBorder."px ".$AD4[0]->BorderStyle.";padding-top:".$AD4[0]->ShowBorder."px;"; }
			$AD4countX1 = $AD4[0]->Impressions + 1; $AD4idX1 = $AD4[0]->AID;
	}
	//-->> [AD4 x2]
	if (count($AD4) > 1) {
		$Advertisement4x2 = '<a href="'.$AD4[1]->AdLink.'" target="Advertisement" title="'.$AD4[1]->AdKeys.'"><div style="padding-bottom:12px;"><img src="'.$AD4[1]->DisplayImage.'" width="'.$AD4[1]->DisplayImageWidth.'" height="'.$AD4[1]->DisplayImageHeight.'" border="0" alt="'.$AD4[1]->AdText.'"></div></a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD4[1]->AdImpressionURL.'" width="1" height="1" border="0"></div>';
		$Advertisement4x2title = 'Advertisement: <a href="'.$AD4[1]->AdLink.'" target="Advertisement" title="'.$AD4[1]->AdText.'">'.$AD4[1]->AdTitle.'</a>';
		if ($AD4[1]->DisplayImage == "" || $AD4[1]->DisplayImage == $AD4[1]->AdImageURL) { $Advertisement4x2 = '<a href="'.$AD4[1]->AdLink.'" target="Advertisement" title="'.$AD4[1]->AdKeys.'"><div style="padding-bottom:12px;"><img src="'.$AD4[1]->AdImpressionURL.'" width="'.$AD4[1]->AdImageWidth.'" height="'.$AD4[1]->AdImageHeight.'" border="0" alt="'.$AD4[1]->AdText.'"></div></a>'; $Advertisement4x2w = $AD4[1]->AdImageWidth; $Advertisement4x2h = $AD4[1]->AdImageHeight; }
		else { $Advertisement4x2 = '<a href="'.$AD4[1]->AdLink.'" target="Advertisement" title="'.$AD4[1]->AdKeys.'"><div style="padding-bottom:12px;"><img src="'.$AD4[1]->DisplayImage.'" width="'.$AD4[1]->DisplayImageWidth.'" height="'.$AD4[1]->DisplayImageHeight.'" border="0" alt="'.$AD4[1]->AdText.'"></div></a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD4[1]->AdImpressionURL.'" width="1" height="1" border="0"></div>'; $Advertisement4x2w = $AD4[1]->DisplayImageWidth; $Advertisement4x2h = $AD4[1]->DisplayImageHeight; }
		$Advertisement4x2style = "width:".($Advertisement4x2w+2)."px;height:".($Advertisement4x2h+1)."px;";
			if ((int)$AD4[1]->ShowBorder > 0) { $Advertisement4x2style = $Advertisement4x2style . "border:".$AD4[1]->ShowBorder."px ".$AD4[1]->BorderStyle.";padding-top:".$AD4[1]->ShowBorder."px;"; }
			$AD4countX2 = $AD4[1]->Impressions + 1; $AD4idX2 = $AD4[1]->AID;
	}
	//-->> [AD4 x3]
	if (count($AD4) > 2) {	
		$Advertisement4x3 = '<a href="'.$AD4[2]->AdLink.'" target="Advertisement" title="'.$AD4[2]->AdKeys.'"><div style="padding-bottom:12px;"><img src="'.$AD4[2]->DisplayImage.'" width="'.$AD4[2]->DisplayImageWidth.'" height="'.$AD4[2]->DisplayImageHeight.'" border="0" alt="'.$AD4[2]->AdText.'"></div></a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD4[2]->AdImpressionURL.'" width="1" height="1" border="0"></div>';
		$Advertisement4x3title = 'Advertisement: <a href="'.$AD4[2]->AdLink.'" target="Advertisement" title="'.$AD4[2]->AdText.'">'.$AD4[2]->AdTitle.'</a>';
		if ($AD4[2]->DisplayImage == "" || $AD4[2]->DisplayImage == $AD4[2]->AdImageURL) { $Advertisement4x3 = '<a href="'.$AD4[2]->AdLink.'" target="Advertisement" title="'.$AD4[2]->AdKeys.'"><div style="padding-bottom:12px;"><img src="'.$AD4[2]->AdImpressionURL.'" width="'.$AD4[2]->AdImageWidth.'" height="'.$AD4[2]->AdImageHeight.'" border="0" alt="'.$AD4[2]->AdText.'"></div></a>'; $Advertisement4x3w = $AD4[2]->AdImageWidth; $Advertisement4x3h = $AD4[2]->AdImageHeight; }
		else { $Advertisement4x3 = '<a href="'.$AD4[2]->AdLink.'" target="Advertisement" title="'.$AD4[2]->AdKeys.'"><div style="padding-bottom:12px;"><img src="'.$AD4[2]->DisplayImage.'" width="'.$AD4[2]->DisplayImageWidth.'" height="'.$AD4[2]->DisplayImageHeight.'" border="0" alt="'.$AD4[2]->AdText.'"></div></a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD4[2]->AdImpressionURL.'" width="1" height="1" border="0"></div>'; $Advertisement4x3w = $AD4[2]->DisplayImageWidth; $Advertisement4x3h = $AD4[2]->DisplayImageHeight; }
		$Advertisement4x3style = "width:".($Advertisement4x3w+2)."px;height:".($Advertisement4x3h+1)."px;";
			if ((int)$AD4[2]->ShowBorder > 0) { $Advertisement4x3style = $Advertisement4x3style . "border:".$AD4[2]->ShowBorder."px ".$AD4[2]->BorderStyle.";padding-top:".$AD4[2]->ShowBorder."px;"; }
			$AD4countX3 = $AD4[2]->Impressions + 1; $AD4idX3 = $AD4[2]->AID;
	}


	//-->> AD5 large spot [1]
	$Advertisement5x1style='width:0px;height:0px;';$Advertisement5x1w='0';$Advertisement5x1h='0';
	$AD5 = $db->get_results("SELECT * FROM AffAdvertisements where AdSpot='AD5' AND VirtualStatus = 'Active' AND ($CommonADQuery) order by rand() limit 1");
	if (count($AD5) > 0) {
		$Advertisement5x1title = 'Advertisement: <a href="'.$AD5[0]->AdLink.'" target="Advertisement" title="'.$AD5[0]->AdText.'">'.$AD5[0]->AdTitle.'</a>';
		//-->> AD5 NO LOCAL IMAGE
		if ($AD5[0]->DisplayImage == "" || $AD5[0]->DisplayImage == $AD5[0]->AdImageURL) { $Advertisement5x1 = '<a href="'.$AD5[0]->AdLink.'" target="Advertisement" title="'.$AD5[0]->AdKeys.'"><div style="padding-bottom:12px;"><img src="'.$AD5[0]->AdImpressionURL.'" width="'.$AD5[0]->AdImageWidth.'" height="'.$AD5[0]->AdImageHeight.'" border="0" alt="'.$AD5[0]->AdText.'"></div></a>'; $Advertisement5x1w = $AD5[0]->AdImageWidth; $Advertisement5x1h = $AD5[0]->AdImageHeight; }
		//-->> AD5 LOCAL IMAGE [AD IMPRESSION IMAGE TO AD]
		else { $Advertisement5x1 = '<a href="'.$AD5[0]->AdLink.'" target="Advertisement" title="'.$AD5[0]->AdKeys.'"><div style="padding-bottom:12px;"><img src="'.$AD5[0]->DisplayImage.'" width="'.$AD5[0]->DisplayImageWidth.'" height="'.$AD5[0]->DisplayImageHeight.'" border="0" alt="'.$AD5[0]->AdText.'"></div></a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD5[0]->AdImpressionURL.'" width="1" height="1" border="0"></div>'; $Advertisement5x1w = $AD5[0]->DisplayImageWidth; $Advertisement5x1h = $AD5[0]->DisplayImageHeight; }
		//-->> AD5 STYLE THE LAYER
		$Advertisement5x1style = "margin-top:15px;width:".($Advertisement5x1w+2)."px;height:".($Advertisement5x1h+1)."px;";
	 		//-->> AD5 PRESET PADDING AND DIV RESIZE ONLY IF BORDER IS ON
			if ((int)$AD5[0]->ShowBorder > 0) { $Advertisement5x1style = $Advertisement5x1style . "border:".$AD5[0]->ShowBorder."px ".$AD5[0]->BorderStyle.";padding-top:".$AD5[0]->ShowBorder."px;"; }
			//-->> AD5 SETUP IMPRESSION COUNT
			$AD5countX1 = $AD5[0]->Impressions + 1; $AD5idX1 = $AD5[0]->AID;
	}

	//-->> AD6 foot spots [3]
	$Advertisement6x1style="width:0px;height:0px;";
	$Advertisement6x2style="width:0px;height:0px;";
	$Advertisement6x3style="width:0px;height:0px;";
	$AD6 = $db->get_results("SELECT * FROM AffAdvertisements where AdSpot='AD6' AND VirtualStatus = 'Active' AND ($CommonADQuery) order by rand() limit 3");
	if (count($AD6) > 0) {
		$Advertisement6x1 = '<a href="'.$AD6[0]->AdLink.'" target="Advertisement" title="'.$AD6[0]->AdKeys.'" style="color:#000000;"><div style="padding-bottom:12px;"><img src="'.$AD6[0]->DisplayImage.'" width="'.$AD6[0]->DisplayImageWidth.'" height="'.$AD6[0]->DisplayImageHeight.'" border="0" alt="'.$AD6[0]->AdText.'"></div>'.$AD6[0]->AdTitle.'</a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD6[0]->AdImpressionURL.'" width="1" height="1" border="0"></div>';
		$Advertisement6x1style="width:160px;height:105px;";
		$AD6countX1 = $AD6[0]->Impressions + 1; $AD6idX1 = $AD6[0]->AID;
	}
	if (count($AD6) > 1) {
		$Advertisement6x2 = '<a href="'.$AD6[1]->AdLink.'" target="Advertisement" title="'.$AD6[1]->AdKeys.'" style="color:#000000;"><div style="padding-bottom:12px;"><img src="'.$AD6[1]->DisplayImage.'" width="'.$AD6[1]->DisplayImageWidth.'" height="'.$AD6[1]->DisplayImageHeight.'" border="0" alt="'.$AD6[1]->AdText.'"></div>'.$AD6[1]->AdTitle.'</a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD6[1]->AdImpressionURL.'" width="1" height="1" border="0"></div>';
		$Advertisement6x2style="width:160px;height:105px;";
		$AD6countX2 = $AD6[1]->Impressions + 1; $AD6idX2 = $AD6[1]->AID;
	}
	if (count($AD6) > 2) {
		$Advertisement6x3 = '<a href="'.$AD6[2]->AdLink.'" target="Advertisement" title="'.$AD6[2]->AdKeys.'" style="color:#000000;"><div style="padding-bottom:12px;"><img src="'.$AD6[2]->DisplayImage.'" width="'.$AD6[2]->DisplayImageWidth.'" height="'.$AD6[2]->DisplayImageHeight.'" border="0" alt="'.$AD6[2]->AdText.'"></div>'.$AD6[2]->AdTitle.'</a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD6[2]->AdImpressionURL.'" width="1" height="1" border="0"></div>';
		$Advertisement6x3style="width:160px;height:105px;";
		$AD6countX3 = $AD6[2]->Impressions + 1; $AD6idX3 = $AD6[2]->AID;
	}

	//-->> AD6p2 foot checkout/payment spot AD6 [1]
	$Advertisement6x4style = 'width:0px;height:0px;';
	$AD6co = $db->get_row("SELECT * FROM AffAdvertisements where AdSpot='AD6' AND VirtualStatus = 'Active' AND (AdKeys LIKE '%Checkout%' OR AdKeys LIKE 'Checkout%' OR AdKeys LIKE '%Checkout') order by rand() limit 1");
	if (count($AD6co) > 0) {
		$Advertisement6x4 = '<a href="'.$AD6co->AdLink.'" target="Advertisement" title="'.$AD6co->AdKeys.'" style="color:#000000;"><div style="padding-bottom:12px;"><img src="'.$AD6co->DisplayImage.'" width="'.$AD6co->DisplayImageWidth.'" height="'.$AD6co->DisplayImageHeight.'" border="0" alt="'.$AD6co->AdText.'"></div>'.$AD6co->AdTitle.'</a>';
		//-->> AD6p2 SETUP IMPRESSION COUNT
		$AD6countX4 = $AD6co->Impressions + 1; $AD6idX4 = $AD6co->AID;
		$Advertisement6x4style = 'width:160px;height:105px;';
	}



	//-->> ADPAIR paired results, for instance Whois search results
	//-->> for instance pairing AD3 w/AD7
	$AdvertisementPAIRx1style='padding-top:0px;width:0px;height:0px;';
	$AdvertisementPAIRx1w='0';
	$AdvertisementPAIRx1h='0';
	$AD3x1advert = 'Advertisement';
	$AdvertisementPAIRx1spacerW='0';
	$AdvertisementPAIRx1spacerH='0';
	$AD3 = $db->get_results("SELECT * FROM AffAdvertisements where AdSpot='AD3' AND VirtualStatus = 'Active' AND ($CommonADQuery) order by rand() limit 2");
	if (count($AD3) > 0) {
		//-->> AD7 NO LOCAL IMAGE
		if ($AD3[0]->DisplayImage == "" && $AD3[0]->AdImageURL == "") {
			$AdvertisementPAIRx1 = '<div>'.$AD3[0]->AdText.'</div>'; 
		}
		else if ($AD3[0]->DisplayImage == "" || $AD3[0]->DisplayImage == $AD3[0]->AdImageURL) {
			$AdvertisementPAIRx1 = '<a href="'.$AD3[0]->AdLink.'" target="Advertisement" title="'.$AD3[0]->AdKeys.'"><img src="'.$AD3[0]->AdImpressionURL.'" width="'.$AD3[0]->AdImageWidth.'" height="'.$AD3[0]->AdImageHeight.'" border="0" alt="'.$AD3[0]->AdText.'"></a>'; 
			$AdvertisementPAIRx1w = $AD3[0]->AdImageWidth; 
			$AdvertisementPAIRx1h = $AD3[0]->AdImageHeight; 
		}
		//-->> AD7 LOCAL IMAGE [AD IMPRESSION IMAGE TO AD]
		else { 
			$AdvertisementPAIRx1 = '<a href="'.$AD3[0]->AdLink.'" target="Advertisement" title="'.$AD3[0]->AdKeys.'"><img src="'.$AD3[0]->DisplayImage.'" width="'.$AD3[0]->DisplayImageWidth.'" height="'.$AD3[0]->DisplayImageHeight.'" border="0" alt="'.$AD3[0]->AdText.'"></a><div width="height:1px;width:1px;visibility:hidden;overflow:hidden;clip:rect(0px,1px,1px,0px);"><img src="'.$AD3[0]->AdImpressionURL.'" width="1" height="1" border="0"></div>'; 
			$AdvertisementPAIRx1w = $AD3[0]->DisplayImageWidth;  
			$AdvertisementPAIRx1h = $AD3[0]->DisplayImageHeight; 
		}
		//-->> AD7 IF w is less than 150 [make 'Advertisement' smaller]
		if ($AdvertisementPAIRx1w < 150) { $AD3x1advert = '<span style="cursor:help;" title="Advertisement">Advert</span>'; }
		$AdvertisementPAIRx1title = $AD3x1advert.': <a href="'.$AD3[0]->AdLink.'" target="Advertisement" title="'.$AD3[0]->AdText.'">'.$AD3[0]->AdTitle.'</a>';
		//-->> AD7 STYLE THE LAYER
		$AdvertisementPAIRx1style = "width:".($AdvertisementPAIRx1w+1)."px;height:".($AdvertisementPAIRx1h+1)."px;";
			 //-->> AD7 PRESET PADDING AND DIV RESIZE ONLY IF BORDER IS ON
			if ((int)$AD3[0]->ShowBorder > 0) { $AdvertisementPAIRx1style = $AdvertisementPAIRx1style . "border:".$AD3[0]->ShowBorder."px ".$AD3[0]->BorderStyle.";padding-top:".$AD3[0]->ShowBorder."px;padding-left:".$AD3[0]->ShowBorder."px;"; }
			//-->> AD7x1 SPACER AFTER ADVERTISEMENT
			$AdvertisementPAIRx1spacerW='220';
			$AdvertisementPAIRx1spacerH='40';
			$AdvertisementPAIRx1spacer='width:220px;height:40px;overflow:hidden;clip:rect(0px,220px,40px,0px);';
			//-->> AD7 SETUP IMPRESSION COUNT
			$AD3countX1 = $AD3[0]->Impressions + 1; 
			$AD3idX1 = $AD3[0]->AID;
	}



	/////////////////////////////////////////
	//--> END: CUSTOMIZE ADVERTISEMENTS <--//
	/////////////////////////////////////////






	//////////////////////////////////////////////////
	//--> UPDATE ADVERTISEMENT IMPRESSION COUNTS <--//
	//////////////////////////////////////////////////
	// [AD3]
	if (count($AD3) > 0) {$db->query("UPDATE AffAdvertisements SET Impressions='$AD3countX1' WHERE AID='$AD3idX1'");}
	if (count($AD3s2) > 1) {$db->query("UPDATE AffAdvertisements SET Impressions='$AD3countX2' WHERE AID='$AD3idX2'");}
	// [AD4]
	if (count($AD4) > 0) {$db->query("UPDATE AffAdvertisements SET Impressions='$AD4countX1' WHERE AID='$AD4idX1'");}
	if (count($AD4) > 1) {$db->query("UPDATE AffAdvertisements SET Impressions='$AD4countX2' WHERE AID='$AD4idX2'");}
	if (count($AD4) > 2) {$db->query("UPDATE AffAdvertisements SET Impressions='$AD4countX3' WHERE AID='$AD4idX3'");}
	// [AD5]
	if (count($AD5) > 0) { $db->query("UPDATE AffAdvertisements SET Impressions='$AD5countX1' WHERE AID='$AD5idX1'"); }
	// [AD6]
	if (count($AD6) > 0) {$db->query("UPDATE AffAdvertisements SET Impressions='$AD6countX1' WHERE AID='$AD6idX1'");}
	if (count($AD6) > 1) {$db->query("UPDATE AffAdvertisements SET Impressions='$AD6countX2' WHERE AID='$AD6idX2'");}
	if (count($AD6) > 2) {$db->query("UPDATE AffAdvertisements SET Impressions='$AD6countX3' WHERE AID='$AD6idX3'");}
	if (count($AD6co) > 0) {$db->query("UPDATE AffAdvertisements SET Impressions='$AD6countX4' WHERE AID='$AD6idX4'");}

	// [AD7]
	if (count($AD7) > 0) {$db->query("UPDATE AffAdvertisements SET Impressions='$AD7countX1' WHERE AID='$AD7idX1'");}

?>