#!/usr/bin/perl -s

##################################################################
#   Program:        Earth Health Monitor                         #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2006 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:      USGS Data Feed Analyzer                      #
#        Module:    USGS Landslide Data Monitor                  #
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

###--      --###
###-- 2צע9 --###
###--      --###

### -->>>> TO DO:
###-- SLOW PROCESS/DATA-RSS RATE
###--

###-- 
###-- MAYBE SET ON A MANUAL ALERT SYSTEM SINCE THIS IS HARDLY UPDATED [ADMIN CONTROLS USER ALERTS] MORE RELIABLE
###-- 

#####################################################
###                                               ###
### RECENT LANDSLIDE ACTIVITY FINDER (worldwide)  ###
###                                               ###
### SINGLE STATE [w/County or City Specified]	  ###
### NO DOUBLE STATE or STATE ONLY alerts	 	  ###
### ALERTS ONLY FOR SINGLE STATE w/County or City ###
###                                               ###
#####################################################

require("/var/www/html/DN/adminAlert.nsp");
require("/var/www/html/DN/parse_query.nsp");
require("/var/www/html/DN/calcDistanceLatLon.nsp");
require("/var/www/html/DN/sendAlert1.nsp");

##--> no date parse directive
$noDateParse = 1; require ("/var/www/html/DN/dateNew.nsp"); 

use locale;
use Text::Autoformat;
use DBI;

#print "Content-type: text/html\n\n"; 

my $dbh = DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>unvWeb</b>\n"; 
$dbh->{RaiseError} = 1; 

#####################
### GET FEED INFO ###
#####################
my $sth = $dbh->prepare("SELECT * FROM Landslides WHERE FeedID='1'");
$sth->execute or die "Sorry, no DB, please try again.\n"; 
my $row = $sth->fetchrow_arrayref; 
$SFName = $row->[1];
$SFRSS = $row->[3];
$SFLastData = $row->[4];
$SFLastReportDate = $row->[5];
$sth->finish;
$dbh->disconnect;


my $dbh = DBI->connect("DBI:mysql:DN_Mapping",$leLU,$leLP) or die "Unable to connect to database: <b>unvWeb</b>\n";
$dbh->{RaiseError} = 1;
##################
### GET STATES ###
##################
my $sth = $dbh->prepare("SELECT StateName, StateAbrv FROM States");
$sth->execute or die "Unable to execute query\n";
my @row;
	while(@row = $sth->fetchrow_array) {
		$StateName = $row[0];
		$SABRV = $row[1];
		push(@StateNames,"$StateName");
		push(@StateABRV,"$SABRV");
		$losSTATES{uc($SABRV)} = $StateName;
	}
$sth->execute or die "Unable to execute query\n";
$sth->finish;
$dbh->disconnect;

#########################
### GET NEW FEED DATA ###
#########################
use LWP::Simple;
use CGI;
use CGI::Carp qw(fatalsToBrowser);
my $url = "$SFRSS";
my $page = get ($url);
##TEST DATA##>> $page = `cat USGS/eqs7day-M2.5.xml`;

$page =~ s/'/`/gi;

$passed = 0;
if ($page =~ "</rss>" && $page ne "$SFLastData") { 
	use DBI;
	my $dbh = DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>unvWeb</b>\n"; 
	$dbh->{RaiseError} = 1; 
	
	$passed = 1; 
	my $sth = $dbh->prepare("UPDATE LOW_PRIORITY Landslides 
		SET LastData='$page' 
		WHERE FeedID='1'");
	$sth->execute or die "Unable to execute query\n"; 
	$sth->finish;
	$dbh->disconnect; 

}
elsif ($page eq "$SFLastData") {
	print "[0] New Records. Same data as before.";
	exit;
}
else {
	$passed = 0;
	## bad query/reply/data tell admin
	$alertSubject = "(Bad USGS landslide data)";
	$alertData = "";
	&alertADMIN;
	print "Bad USGS Landslide data.";
	exit;
}


use XML::RSS;
use lib;
my $rss = new XML::RSS(Style => 'Debug');
$rss->parse($page);


$newlyAdded = 0;
foreach $item (@{$rss->{'items'}}) {

	$Title = $item->{title};
	$Link = $item->{link};
	$Description = $item->{description};
	$PubDate = $item->{pubDate};

	
	
	my $dbh = DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>unvWeb</b>\n"; 
	$dbh->{RaiseError} = 1; 

	$LID = 0;
	my $sth = $dbh->prepare("SELECT LandslideID FROM LandslidesRecorded WHERE Link = '$Link'");
	$sth->execute or die "Sorry, no DB, please try again.\n"; 
	my $row = $sth->fetchrow_arrayref; 
	$LID = $row->[0];
	$sth->finish;

	##- doesnt already exist
	if ($LID == 0) {
		
		##-- for state search purposes only, never used to save or print out
		use Text::Beautify;
		$bD = lc($Description);
		$text1 = Text::Beautify->new($bD);
		$cleanD = $text1->beautify;

		##-- used to print out and save
		$Description = autoformat $cleanD, { case => 'sentence' };
		$Description =~ s/\n/ /gi;

		$Description =~ s/\.\.\.\.\./\. /gi;
		$Description =~ s/\.\.\.\./\. /gi;
		$Description =~ s/\.\.\./\. /gi;
		$Description =~ s/\.\./\. /gi;
		$Description =~ s/    / /gi; $Description =~ s/    / /gi;
		$Description =~ s/   / /gi;	$Description =~ s/   / /gi;
		$Description =~ s/  / /gi; $Description =~ s/  / /gi;
		$Description =~ s/  / /gi;$Description =~ s/  / /gi;
		

		##-- format to sql datetime
		$PubDate =~ s/,//gi;
		($DaySpelled, $Da, $Mo, $Yr, $Ti, $TimeZone) = split(/ /,$PubDate);
		chomp($Mo);
		$Mo =~ s/\s+/ /g;
		$newDate = $Yr . '-' . $los_months_abrv{$Mo} . '-' . $Da . ' ' . $Ti;
		
		######################################################################################
		## we need to find state in the title (remove uneeded specs on title & description) ##
		######################################################################################
		$affectedLocation = "$Title $Description";

		######################################
		## Name useful names for weird ones ##
		######################################
		#- if ($affectedLocation =~ "Mariana") { $affectedLocation =~ s/Mariana/Marianas/gi; }
		#- if ($affectedLocation =~ "Midway") { $affectedLocation = s/Midway/Midway Island/gi; }
		#- if ($affectedLocation =~ "Virgin") { $affectedLocation = s/Virgin/Virgin Islands/gi; }
		
		###################################################
		## find States affected as per DN_Mapping layout ##
		###################################################
		$affected = 0;
		$csn = 0;
		$seenState = '';
		$miSTAB = '';
		foreach $SN (@StateNames) {
			$ucST = uc($StateABRV[$csn]);
			$lcST = lc($StateABRV[$csn]);
			$mss = "";
			if ($seenState ne "") { $mss = 'xxxxx'; }
			###-- [1] contains full state name in title and/or desc
			if ($affectedLocation =~ "$SN" || lc($affectedLocation) =~ lc($SN) || uc($affectedLocation) =~ uc($SN)) {
				$affected = 1;
				##-- always use full state name for accuracy
				if ($seenState !~ '$SN') { 
					$seenState = $seenState . $mss . "$SN--$ucST"; 
					$miSTAB = $lcST;
				}
			}
			###-- [2] contains abrv state in title
			elsif (($Title =~ " $ucST" || $Title =~ "$ucST ") && $affected == 0) {
				$affected = 2;
				##-- always use full state name for accuracy
				if ($seenState !~ '$SN') {
					$seenState = $seenState . $mss . "$losSTATES{$ucST}--$ucST";
					$miSTAB = $lcST;
				}
			}
			$csn++;
		}
		###-- [0] contains no state info at all [generic usa]
		if ($affected eq "0") {
			$affected = 0;
			$seenState = '';
		}
		## print "$affectedLocation<br>\n";
		@allMyCounties = '';
		@allMyCities = '';
		$countied = 0;
		$miscounties = '';
		$miscities = '';
		$citied = 0;
		if (($affected eq "1" || $affected eq "2") && length($miSTAB) == 2) {

			my $dbh = DBI->connect("DBI:mysql:DN_Mapping",$leLU,$leLP) or die "Unable to connect to database: <b>unvWeb</b>\n"; 
			$dbh->{RaiseError} = 1; 

			$sth = $dbh->prepare("
			SELECT DISTINCT ZipCode, State, County, City, Latitude, Longitude
			FROM USPS_AIS_GEO
			WHERE USPS_AIS_GEO.State = '$miSTAB' ORDER BY USPS_AIS_GEO.County ASC
			");
			$sth->execute;
			my @row;
			$iveSeenCounty = "";
			$iveSeenCity = "";
			while (@row = $sth->fetchrow_array) {
				$theCounty = $row[2];
				$theCity = $row[3];
				$theLon = $row[4];
				$theLat = $row[5];
				$lcCO = lc($theCounty);
				$lcCT = lc($theCity);
				##-->> only pinpoint cities if keyword found in text for cities/city [strict reference to city(s)]
				##-->> must be at least 3 characters long
				if ((lc($Description) =~ " $lcCT" || lc($Description) =~ "$lcCT " || lc($Description) =~ " $lcCT." || lc($Description) =~ " $lcCT,") && substr($theCity,0,3) ne "" && (lc($Description) =~ "cities" || lc($Description) =~ "city")) {
					if ($iveSeenCity !~ " $lcCT ") {
						$affected = 4;
						$theCity =~ s/,/ /gi;
						push(@allMyCities,"$theCity");
						$iveSeenCity = $iveSeenCity . " $lcCT ";
						$citied++;
					}
				}
				###== if no cities then we do counties
				elsif ((lc($Description) =~ " $lcCO" || lc($Description) =~ "$lcCO " || lc($Description) =~ " $lcCO." || lc($Description) =~ " $lcCO,") && substr($theCounty,0,3) ne "" && (lc($Description) =~ "counties" || lc($Description) =~ "county")) {
					if ($iveSeenCounty !~ " $lcCO ") {
						$affected = 3;
						$theCounty =~ s/,/ /gi;
						push(@allMyCounties,"$theCounty");
						$iveSeenCounty = $iveSeenCounty . " $lcCO ";
						$countied++;
					}
				}


			}
			$sth->finish;
			$dbh->disconnect;

		}
		if ($countied ne "0") {
			shift(@allMyCounties);
			$miscounties = join(', ', @allMyCounties);
		}
		if ($citied ne "0") {
			shift(@allMyCities);
			$miscities = join(', ', @allMyCities);
		}
		
		$Description =~ s/usgs/USGS/gi;
		
		$IL = "$Title-----$Link-----$Description-----$PubDate";

		my $dbh = DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>unvWeb</b>\n"; 
		$dbh->{RaiseError} = 1; 

			###-->> SAVE NEW ITEM TO RECORDED
			my $sth = $dbh->prepare("INSERT INTO LandslidesRecorded (LandslideID, DateTimeStamp, Link, ActualData)
									 VALUES (Null, '$newDate', '$Link', '$IL')");
			$sth->execute or die "Unable to execute query\n";
			$sth->finish;

			###-->> GRAB NEW ITEM ID
			my $sth = $dbh->prepare("SELECT LandslideID FROM LandslidesRecorded WHERE Link = '$Link'");
			$sth->execute or die "Sorry, no DB, please try again.\n"; 
			my $row = $sth->fetchrow_arrayref;
			$alertID = $row->[0];
			$sth->finish;

			###-->> UPDATE WHO WAS ALERTED to the ITEMS processedData field
			$IL2 = $IL .'-----'.  $affected .'-----'.  $seenState .'-----'.  $miscounties .'-----'. $miscities;

			my $sth = $dbh->prepare("UPDATE LandslidesRecorded 
									 SET ProcessedData = '$IL2' 
									 WHERE Link = '$Link'");
			$sth->execute or die "Unable to execute query\n";
			$sth->finish;

			$newlyAdded++;

		$dbh->disconnect;
		
		my $dbh = DBI->connect("DBI:mysql:DN_Master",$leLU,$leLP) or die "No db connection for: <b>DN_Master</b>\n";
		$dbh->{RaiseError} = 1;
		###########################
		### FIND RELEVANT USERS ###
		###########################

		my $sth = $dbh->prepare("SELECT * FROM UserBase WHERE State = '$miSTAB'");
		$sth->execute or die "Unable to execute query\n";
		my @row;
		while(@row = $sth->fetchrow_array) {
			$myUID = $row[0];
			$UFirst = $row[2];
			$ULast = $row[3];
			$UEmail = $row[4];
			$UCity = $row[7];
			$savedAlerts = $row[11];
			$UCounty = $row[12];

			if ($savedAlerts =~ "l-$alertID") { $dontAdd = 1; }
			else {
				##-- no more than one message for any given user
				if (exists $alreadySent{"$myUIDxxxxx$UEmail"}) {
				}
				else {
					##-- only users in affected cities
					if ($citied > 0 && $miscities =~ "$UCity") {
						push(@ATSave,"$myUID %%%%% $UEmail %%%%% l-$alertID");
						$myUID = int($myUID);
						$alertURL = "l.htm?d=$myUID&t=ci";
						$emailData = "<a href=\"http://www.disasternotify.com/$alertURL\" title=\"Click for more info...\">Landslide!</a>";
						&SendAlert1;
						$alreadySent{"$myUIDxxxxx$UEmail"} = 1;
					}
					##-- only users in affected countie
					elsif ($miscounties =~ "$UCounty") {
						push(@ATSave,"$myUID %%%%% $UEmail %%%%% l-$alertID");
						$myUID = int($myUID);
						$alertURL = "l.htm?d=$myUID&t=co";
						$emailData = "<a href=\"http://www.disasternotify.com/$alertURL\" title=\"Click for more info...\">Landslide!</a>";
						&SendAlert1;
						$alreadySent{"$myUIDxxxxx$UEmail"} = 1;
					}
				}
			}
		}
		$sth->execute or die "Unable to execute query\n";
		$sth->finish;
		

		$dbh->disconnect;
		
		## print "$IL2 -- $alertID<br><br>\n";
		

		
		$countRuns++;
	}
}	









	##-- update relevant user alertStack
	if (@ATSave) {
		my $dbh = DBI->connect("DBI:mysql:DN_Master",$leLU,$leLP) or die "No db connection for: <b>DN_Master</b>\n";
		$dbh->{RaiseError} = 1;
		foreach $atsAVE (@ATSave) {
			@splitATSAVE = split(/ %%%%% /,$atsAVE);
			$Uid = $splitATSAVE[0];
			$Uem = $splitATSAVE[1];
			$Aid = $splitATSAVE[2];

			my $sth = $dbh->prepare("SELECT * FROM UserBase WHERE CustomerID='$Uid'");
			$sth->execute or die "Unable to execute query\n";
			my @row;
			while(@row = $sth->fetchrow_array) {
				$SAs = $row[11];
			}
			$sth->execute or die "Unable to execute query\n";
			$sth->finish;

			if ($SAs =~ "-") { $newAlerts =  $Aid . "-----" . $SAs; }
			else { $newAlerts =  $Aid; }

			my $sth = $dbh->prepare("UPDATE LOW_PRIORITY UserBase 
				SET Alerts='$newAlerts' 
				WHERE CustomerID='$Uid'");
			$sth->execute or die "Unable to execute query\n"; 
			$sth->finish;
		}
		$dbh->disconnect;
	}

print "DONE! - [$newlyAdded] New Alerts";


exit;