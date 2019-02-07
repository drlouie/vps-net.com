<?php
##################################################################
#	Program: 		TheTVDB Guide (RESTful)                      #
#	Author: 		Luis Gustavo Rodriguez (drlouie)             #
#	Copyright: 	    (c) 2018 Luis G. Rodriguez                   #
#	Licensing:		MIT License                                  #
#                                                                #
#	About                                                        #
#        Type: 			API Strap                                #
#        Source:		TheTVDB.com                              #
#        Type: 			Web Application                          #
#        Dependencies:	PHP::TVDB library (included)             #
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

header("Cache-Control: no-cache, must-revalidate");

include_once './config/db.php';
include_once './TVDB.php';
include_once './entities/User.php';

$cb = $_REQUEST['callback'];
$search = $_REQUEST['search'];
$update = $_REQUEST['update'];
$delete = $_REQUEST['delete'];
$read = $_REQUEST['read'];
$Handshake = $_REQUEST['Handshake'];
$GetChangeLog = $_REQUEST['GetChangeLog'];
$GetEpisodes = $_REQUEST['GetEpisodes'];

if (!!$GetEpisodes) {
	$tvshow = new TV_Show();
	$result = $tvshow->getEpisodes($GetEpisodes);
	
	$result = json_decode($result);
				
	/* flush the filename data with either a local file link or a remote file link, depending on if we can utilize, and have cached, local file of remote image */
	foreach ($result->data as $i) {
		if ($i->filename) {
			$i->filename = parseMyImagery($i->filename);
		}
	}
	$result = str_replace('\/','/',json_encode($result));

	header("Content-Type: application/json; charset=UTF-8");
	echo $cb . "(" . $result . ")";
}
if (!!$_REQUEST['test']) {
	
	#- test show id=73192
	# result is JSON data object
	#$tvshow = new TV_Show();
	#$result = $tvshow->getEpisodes($_REQUEST['test']);
	
	#- test show id=73192
	# result is XML dataset
	#$tvshow = new TV_Shows();
	#$result = $tvshow->search($_REQUEST['test']);
	
	#- test episode epidsode_id=307508
	# result is JSON data object
	#$tvshow = new TV_Show();
	#$result = $tvshow->getEpisode($_REQUEST['test']);

	#- test episode show_id=73192
	# result is JSON data object
	$tvshow = new TV_Shows();
	$result = $tvshow->findById($_REQUEST['test']);
	
	echo $result;
}
if (!!$Handshake && (strlen($Handshake) == 1) && !!$cb) {
	header("Content-Type: application/json; charset=UTF-8");
	echo $cb . "({\"success\":\"1\"});";
	exit;
}

// read cart cookie: OpenCanvasDesign AKA OpenCanvasDesign
if (!isset($_COOKIE["OpenCanvasDesign"])) {
	$dbclass = new DBConnection();
	$connection = $dbclass->getConnection();
	$dbo = new User($connection);
	##--> create(CookieName + UID)
	$inUID = $dbo->create("OpenCanvasDesign");
	$OpenCanvasDesign = $inUID;
}
else {
	$inUID = $_COOKIE["OpenCanvasDesign"];
	if(preg_match('/[^a-z_\-0-9]/i', $inUID))
	{
	  /* hack attempt */
	  exit;
	}
	$OpenCanvasDesign = $inUID;
}


##-- domain delete(REMove) request
if (!!$delete && (strlen($delete) >= 3) && !!$inUID && ($inUID !== "" && $inUID !== " ")) {
	if (preg_match('/[^a-zA-Z0-9-_\. ]/', $delete)) {
		echo "<font color='#AF041C' style='cursor:help;' title='Show names may contain a series of characters, including upper or lower-case letters (A-Z a-z), numbers (0-9) or dashes (-). Beyond this set of mainly alpha-numeric characters, nothing else is allowed.'>Invalid characters</font>:";
	}
	else {
		$dbclass = new DBConnection();
		$connection = $dbclass->getConnection();
		$dbo = new User($connection);
		$result = $dbo->delete($inUID,$delete);
		echo "deleted";
	}
	exit;
}


##-- update($save) request, only for trailing users
if (strlen($update) >= 3 && !!$inUID && ($inUID !== "" && $inUID !== " ")) {
	if (preg_match('/[^a-zA-Z0-9-_\. ]/', $update)) {
		echo "<font color='#AF041C' style='cursor:help;' title='Show names may contain a series of characters, including upper or lower-case letters (A-Z a-z), numbers (0-9) or dashes (-). Beyond this set of mainly alpha-numeric characters, nothing else is allowed.'>Invalid characters</font>:";
		exit;
	}
	else {
		$tvshows = new TV_Shows();
		$tvshow = $tvshows->findById($update);
		if (!!$tvshow) {
			
			/* START: define tv show saveTitle */
			$jsonified = json_decode($tvshow);
			$SeriesName = '';
			$FirstAired = '';
			if (!!$jsonified->{'data'}->{'seriesName'}) { $SeriesName = '"' . $jsonified->{'data'}->{'seriesName'} . '"'; }
			if (!!$jsonified->{'data'}->{'firstAired'}) { 
				if (strstr($jsonified->{'data'}->{'firstAired'},"-")) {
					$FirstAired = $jsonified->{'data'}->{'firstAired'}; 
					$AiredYear = explode("-",$FirstAired);
					/* only if our string is truly 4 character number */
					if (!!$AiredYear[0] && (strlen($AiredYear[0]) === 4 && (!is_nan($AiredYear[0])))) {
						$FirstAired = ' ('.$AiredYear[0].')';
					}
					else {
						$FirstAired = '';
					}
				}
			}
			$saveTitle = $SeriesName . "" . $FirstAired;
			$saveTitle = str_replace('"','',$saveTitle);
			$saveTitle = str_replace("'","\'",$saveTitle);
			/* END define tv show saveTitle */
			
			$dbclass = new DBConnection();
			$connection = $dbclass->getConnection();
			$dbo = new User($connection);
			$result = $dbo->update($inUID, $update, $saveTitle);
			## by echoing back the same as given in we assure user we've acted according to request
			/* start SHOW */
			echo $update;
			exit;
		}
		else {
			echo $cb . "({\"error\":\"NoMatch\",\"data\":\"No match: ".$update."\"});";
			exit;
		}
	}
}

##-- get change.log
if ((!!$GetChangeLog) && (strlen($GetChangeLog) === 1)) {
	$changeLog = file_get_contents('/var/www/vps-net.com/htdocs/thetvdb/change.log');
	if (strstr($changeLog,"Fixes") || strstr($changeLog,"Updates") || strstr($changeLog,"Pending")) {
		echo $changeLog;
	}
	exit;
}


##-- domain list data request (data), only for trailing users
if ((!!$read) && strlen($read) === 1 && !!$inUID && ($inUID !== "" && $inUID !== " ")) {
	// VirtualPrivateDomain = cookie total count of stored items
	$VirtualPrivateDomain = 1;
	if (!!$VirtualPrivateDomain) {

		// OpenCanvasDesign = cookie setting for DB->UID/GUID
		##-- associative UID = OpenCanvasDesign ID (Cart) [IF EXISTS]
		if (!!$OpenCanvasDesign  && ($OpenCanvasDesign !== "" && $OpenCanvasDesign !== " ")) {
			$dbclass = new DBConnection();
			$connection = $dbclass->getConnection();
			$dbo = new User($connection);
			$data = $dbo->read($inUID)[0];
			header("Content-Type: application/json; charset=UTF-8");
			
			##-> JSON only prints if data available, JS handles otherwise
			if (stristr($data,'[series:{') && stristr($data,'}]')) {
				$data = str_replace('[series:{','',$data);
				$data = str_replace('}]','',$data);
				$allDomains = explode(',',$data);
				if (sizeof($allDomains) >= 1) {
					echo $cb . '({"success":"1","domains":'.json_encode($allDomains).'});';
				}
			}
		}
	}
	else {
		echo "0";
	}
	exit;
}


##-- SEARCH request, only for trailing users
if (strlen($search) >= 3 && !!$inUID && ($inUID !== "" && $inUID !== " ")) {
		header("Content-Type: application/json; charset=UTF-8");
		
		$searchstring = $search;
		/* after clean up does it still add up? */
		if (strlen($searchstring) >= 3) {

			/* get the shows */
			$shows = TV_Shows::search($search);
			
			/* force run without real data, case doing dry run */
			#- $shows = 1;
			
			/* found at least one match */
			if (!!$shows) {
			
				
				
				/* flush the banner data with either a local file link or a remote file link, depending on if we can utilize, and have cached, local file of remote image */
				foreach ($shows as $i) {
					if ($i->banner) {
						$i->banner = parseMyImagery($i->banner);
					}
				}
				
				/* start SHOW */
				echo $cb . "({\"success\":\"Available\",\"data\":".json_encode($shows)."});";
				exit;
				/* end  SHOW */
			}
			else {
				echo $cb . "({\"error\":\"NoMatch\",\"data\":\"No match: ".$search."\"});";
				exit;
			}
		}
		else {
			echo $cb . "({\"error\":\"Invalid characters\",\"data\":\"Show names may contain a series of characters, including upper or lower-case letters (A-Z a-z), numbers (0-9) or dashes (-) and even spaces. Beyond this set of mainly alpha-numeric characters, nothing else is allowed.\"});";
			exit;
		}

	echo $cb . "({\"error\":\"error\",\"data\":\"error\"});";
	exit;
}


function parseMyImagery ($source) {
	// $source WAS $i->banner || $i->filename
	/* if its blank, then unset image data, kill client-side 403 errors from dead imagery */
	if (strstr($source,'blank/')) { 
		unset($source);
	}
	/* otherwise its not blank/ continue */
	else {
		$localBannerFileName = str_ireplace('/','_',$source);
		$localBanner = "/var/www/vps-net.com/htdocs/thetvdb/images/banners/" . $localBannerFileName;
								
		if (!file_exists($localBanner)) { 
			$image = file_get_contents("https://www.thetvdb.com/banners/" . $source);
			if ($image && (!file_exists($localBanner))) { 
				file_put_contents($localBanner, $image);
				$source = "/thetvdb/images/banners/".$localBannerFileName;
			}
			/* local file doesn't exist but remote file is good */
			else if ($image) {
				// $i->banner = "https://www.thetvdb.com/banners/".$source;
				// Can't do above, cross-domain policy, so will simply unset
				unset($source);
			}
			/* local file doesn't exist and remote file doesn't either, unset banner */
			else {
				unset($source);
			}
		}
		else if (file_exists($localBanner)) {
			$source = "/thetvdb/images/banners/".$localBannerFileName;
		}
		else {
			unset($source);
		}
	}
	return $source;
}

?>
