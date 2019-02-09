#!/usr/bin/perl -s

##################################################################
#   Program:        Earth Health Monitor                         #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2006 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:      USGS Data Feed Analyzer                      #
#        Module:    USGS Volcano Data Processor                  #
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

require("/var/www/html/DN/adminAlert.nsp");
require("/var/www/html/DN/parse_query.nsp");
require("/var/www/html/DN/calcDistanceLatLon.nsp");
require("/var/www/html/DN/sendAlert1.nsp");

$noDateParse=1;
$amper = '&';
$ESCamper = "\\&";
require ("/var/www/html/DN/dateNew.nsp");

use locale;
use Text::Autoformat;
use Date::Manip;
use DBI;

my $dbh=DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>USGSFeeds: Remote</b>\n";
$dbh->{RaiseError}=1;
my $sth=$dbh->prepare("SELECT ReleaseID from VolcanoReleaseControl WHERE ControlID='1'");
$sth->execute or die "Sorry, no DB, please try again.\n";
my $row=$sth->fetchrow_arrayref;
$rid=$row->[0];
$sth->finish;
$dbh->disconnect;

my $dbh=DBI->connect("DBI:mysql:DN_Mapping",$leLU,$leLP) or die "Unable to connect to database: <b>Mapping: Local</b>\n";
$dbh->{RaiseError}=1;
my $sth=$dbh->prepare("SELECT StateID, StateName, StateAbrv FROM States");
$sth->execute or die "Unable to execute query\n";
my @row;
while(@row=$sth->fetchrow_array){$StateID=$row[0];
$StateName=$row[1];
$SABRV=$row[2];
push(@StateNames,"$StateName");
push(@StateABRV,"$SABRV");
$losSTATES{uc($SABRV)}=$StateName;
$losSTATESNamed{$StateID}=$StateName;
$losSTATESABR{$StateID}=$SABRV;
}$sth->finish;
$dbh->disconnect;

my $dbh=DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>USGSFeeds: Local</b>\n";
$dbh->{RaiseError}=1;
my $sth=$dbh->prepare("SELECT VID, Name FROM WorldVolcanoes");
$sth->execute or die "Unable to execute query\n";
my @row;
while(@row=$sth->fetchrow_array){
	$VID=$row[0];
	$VFN=$row[1];
	push(@VolcanoIDs,"$VID");
	push(@VolcanoNames,"$VFN");
}
$sth->finish;
$dbh->disconnect;
use LWP::Simple;
use CGI;
use CGI::Carp qw(fatalsToBrowser);
use XML::RSS;
use lib;
$rid++;
$url="http://volcanoes.usgs.gov/cap/cap_display.php?releaseid="."$rid";
$pg1=get($url);
$pg1=~s/'/`/gi;
$pg1=~s/$amper/$ESCamper/gi;
$pg1=~s/'/`/gi;
$em='<hr />Error opening /webdata/vhpcap.wr.usgs.gov/hans/access.log check file permissions.<hr />';
$pg1=~s/$em//gi;
$pg1=~s/cap://gi;
$countNews=0;
$nn=0;
$numAffected=0;
$cn=$rid;
my $dbh=DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>USGSFeeds: Remote</b>\n";
$dbh->{RaiseError}=1;
$countRuns=0;
$wasSame=0;
$wasNew=0;
if($pg1=~"</alert>"&&($pg1=~"DOI-USGS" || $pg1=~"," || $pg1=~"ma" || $pg1=~"of")){
	my $sth=$dbh->prepare("UPDATE LOW_PRIORITY VolcanoReleaseControl SET ReleaseID='$cn', ReleaseData='$pg1', ReleaseAggregated='$datetime', IsEmpty='N', FirstTimeEmpty='' WHERE ControlID='1'");
	$sth->execute or die "Unable to execute query\n";
	$sth->finish;
	$elCN=$cn;
	&saveRelease($pg1);
	&findLatestFeedID($cn);
	$wasNew=1;
}
elsif($pg1=~"</alert>"){
	if($IsEmpty eq "Y"&&$FirstTimeEmpty=~":"&&$FirstTimeEmpty ne "0000-00-00 00:00:00"){ 
		$miEQ="UPDATE LOW_PRIORITY VolcanoReleaseControl SET LastData='$pg1', LastCheckDate='$datetime' WHERE ControlID='1'";
		($FTE,$FTE2)=split(/ /,$FirstTimeEmpty);
		$FTE=~s/ //gi;
		$FTE=~s/://gi;
		$FTE=~s/-//gi;
		($TDT,$TDT2)=split(/ /,$datetime);
		$TDT=~s/ //gi;
		$TDT=~s/://gi;
		$TDT=~s/-//gi;
		$howLongEmpty=($TDT - $FTE);
		if($howLongEmpty > 0){ 
			$alertSubject="(bad USGS Volcano)";
			$alertData="USGSVF: ($cn) BEEN EMPTY FOR: $howLongEmpty Days [FROM:$FirstTimeEmpty TO:$datetime]";
			&alertADMIN;
			print "USGSVF: ($cn) BEEN EMPTY FOR: $howLongEmpty Days [FROM:$FirstTimeEmpty TO:$datetime]\n\n";
		}
	}
	else{
		$miEQ="UPDATE LOW_PRIORITY VolcanoReleaseControl SET LastData='$pg1', LastCheckDate='$datetime', IsEmpty='Y', FirstTimeEmpty='$datetime' WHERE ControlID='1'";
	}
	my $sth=$dbh->prepare("$miEQ");
	$sth->execute or die "Unable to execute query\n";
	$sth->finish;
	$wasSame=1;
}
$dbh->disconnect;

$passed=0;

if($wasSame == 1 || $wasNew == 1){
	$passed=1;
	if($wasSame != 0){
		print "USGSVF: [0] New Records. Same data as before.\n\n";
	}
	elsif($gc=~m/[0-9]*[-][0-9]*[-=]?/){
		$vID="$elCN";
		$UID, $UFirst, $ULast, $UEmail, $UID, $PPA, $alertURL, $emailData, $newCAC, $newCAV='';
		$doalert=0;
		$aurl="v.htm?d=";
		@alertLevels=('0','Undefined','Normal','Advisory','Watch','Warning');
		@aviationColorCodes=('0','Undefined','Green','Yellow','Orange','Red');
		$cac=0;
		$cav=0;
		foreach $ac (@alertLevels){if(lc($alertlevel)=~lc($ac)){
			$newCAC=$cac;
		}
		$cac++;
		}foreach $av (@aviationColorCodes){
			if(lc($aviation)=~lc($av)){
				$newCAV=$cav;
			}
			$cav++;
		}
		my $dbh=DBI->connect("DBI:mysql:DN_Master",$leLU,$leLP) or die "Unable to connect to database: <b>Master: Local</b>\n";
		$dbh->{RaiseError}=1;
		my $sth=$dbh->prepare("SELECT UserBase.CustomerID, UserBase.FirstName, UserBase.LastName, UserBase.Email, UserBase.Alerts, UserBase.PPA, PersonalProfiles.CustomerID, PersonalProfiles.Volcanoes FROM UserBase, PersonalProfiles WHERE (UserBase.CustomerID=PersonalProfiles.CustomerID AND PersonalProfiles.Volcanoes LIKE '%$gc%') ");
		$sth->execute or die "Unable to execute query\n";
		my @row;
		while(@row=$sth->fetchrow_array){ 
			$UID=$row[0];
			$UFirst=$row[1];
			$ULast=$row[2];
			$UEmail=$row[3];
			$SAs=$row[4];
			$PPA=$row[5];
			$CV=$row[7];
			if($CV=~"-----"&&$CV=~", "&&$gc=~m/[0-9]*[-][0-9]*[-=]?/&&$CV=~"$gc"&&$SAs !~ "v-$vID"){ 
				($As, $CAVWs)=split(/-----/,$CV);
				($al, $av)=split(/, /,$As);
				$al=int($al);
				$av=int($av);
				if($al > 0&&$av > 0){ 
					if($al >= $newCAC || $av >= $newCAV){ 
						$doalert=1;
						push(@userAlerts,"$UID-----$vID-----$areadesc-----$alertLevels[$newCAC]-----$aviationColorCodes[$newCAV]-----$PPA");
					}
				}
				else{ 
					$alertSubject="(bad USGS volcano profile config)";
					$alertData="USER [$UID] has bad USGS volcano profile config [$CV]";
					&alertADMIN;
					print "USGSVF: USER [$UID] has bad USGS volcano profile config [$CV]\n\n";
				}
			}
		}
		$sth->execute or die "Unable to execute query\n";
		$sth->finish;
		$dbh->disconnect;
		if(@userAlerts){ 
			foreach $lUA (@userAlerts){ 
				$TPPA=0;
				($USERID, $VOLCID, $ADESC, $ALC, $ACC, $TPPA)=split(/-----/,$lUA);
				$newAlerts='';
				$SAs='';
				my $dbh=DBI->connect("DBI:mysql:DN_Master",$leLU,$leLP) or die "Unable to connect to database: <b>Master: Local</b>\n";
				$dbh->{RaiseError}=1;
				my $sth=$dbh->prepare("SELECT CustomerID, Email, Alerts FROM UserBase WHERE CustomerID='$USERID'");
				$sth->execute or die "Unable to execute query\n";
				my $row=$sth->fetchrow_arrayref;
				$UEmail=$row->[1];
				$SAs=$row->[2];
				$sth->finish;
				$dbh->disconnect;
				if($SAs=~"v-$VOLCID"){
					$dontAdd=1;
				}
				else{
				push(@ATSave,"$USERID %%%%% $UEmail %%%%% v-$VOLCID");
				}
				if($TPPA eq "1"){ 
					$UID=int($USERID);
					if(exists $alreadySent{"$UIDxxxxx$UEmail"}){}
					else{ 
						$aed="$ADESC Update [Alert Level: $ALC] [Aviation Color Code: $ACC]";
						$alertURL=$aurl."$UID";
						$emailData=$aed;
						&SendAlert1;
						$nn++;
						$alreadySent{"$UIDxxxxx$UEmail"}=1;
					}
				}
			}
		}
		if(@ATSave){ require("/var/local/nmscontrol/savUA.nsp");
		}
		if($nn > 0){
			$nn=": [$nn users notified]";
		}
		if($numAffected > 0){
			$numAffected=": [$numAffected users affected]";
		}
		print "USGSVF:good [ $countNews New Volcanoes in USA ] $numAffected $nn";
	}
	else{
		$alertSubject="(missing USGS Volcano CAVW)";
		$alertData="USGSVF: ($elCN) MISSING CAVW";
		&alertADMIN;
		print "USGSVF: ($elCN) MISSING CAVW\n\n";
	}
	exit;
}
else{ 
	$alertSubject="(bad USGS Volcano)";
	$alertData="USGSVF: $cn [missing identifier OR eof]";
	&alertADMIN;
	print "USGSVF: $cn [missing identifier OR eof]\n\n";
	exit;
}
sub findLatestFeedID{
	my $newCN=$_[0];
	$newCN=$cn++;
	$miPagina=&suckit($newCN);
	$miPagina=~s/'/`/gi;
	$miPagina=~s/$amper/$ESCamper/gi;
	if($miPagina=~"DOI-USGS"&&($wasSame == 1 || $wasNew == 1)){
		if($rid != $newCN){
			 my $sth=$dbh->prepare("UPDATE LOW_PRIORITY VolcanoReleaseControl SET ReleaseID='$newCN', ReleaseData='$miPagina', ReleaseAggregated='$datetime', IsEmpty='N', FirstTimeEmpty='' WHERE ControlID='1'");
			$sth->execute or die "Unable to execute query\n";
			$sth->finish;
			$elCN=$newCN;
			&saveRelease($miPagina);
		}
		&findLatestFeedID($newCN);
	}
	else{
		if($IsEmpty eq "Y"&&$FirstTimeEmpty=~":"&&$FirstTimeEmpty ne "0000-00-00 00:00:00"){
			$miEQ="UPDATE LOW_PRIORITY VolcanoReleaseControl SET LastData='$miPagina', LastCheckDate='$datetime' WHERE ControlID='1'";
		}
		else{
			$miEQ="UPDATE LOW_PRIORITY VolcanoReleaseControl SET LastData='$miPagina', LastCheckDate='$datetime', IsEmpty='Y', FirstTimeEmpty='$datetime' WHERE ControlID='1'";
		}
		my $sth=$dbh->prepare("$miEQ");
		$sth->execute or die "Unable to execute query\n";
		$sth->finish;
	}
}
sub suckit{
	my $incn=$_[0];
	$ur="http://volcanoes.usgs.gov/cap/cap_display.php?releaseid="."$incn";
	$pg=get($ur);
	$pg=~s/'/`/gi;
	$pg=~s/$amper/$ESCamper/gi;
	return($pg);
}
$countNews=0;
sub saveRelease{
	my $inpg=$_[0];
	$countNews++;
	$identifier, $sender, $sent, $status, $msgtype, $scope, $references, $category, $event, $urgency, $severity, $certainty, $effective, $expires, $senderName, $headline, $MD, $web, $contact, $parameters, $areadesc, $gc, $alertlevel, $aviation='';
	$ActualData=$inpg;
	$inpg=~s/alert>/item>/gi;
	$inpg=~s/alert xmlns/item xmlns/gi;
	$ordm='&#176;
	';
	$ardm='°';
	$inpg=~s/CAVW#/CAVW=/gi;
	$inpg=~s/<\/p>//gi;
	$inpg=~s/<p>//gi;
	$inpg=~s/<\/i>//gi;
	$inpg=~s/<i>//gi;
	$inpg=~s/<\/strong>//gi;
	$inpg=~s/<strong>//gi;
	$inpg=~s/<\/center>//gi;
	$inpg=~s/<center>//gi;
	$inpg=~s/<\/em>//gi;
	$inpg=~s/<em>//gi;
	$inpg=~s/<br \/>//gi;
	$inpg=~s/<br>//gi;
	$inpg=~s/<br//gi;
	$inpg=~s/br \/>//gi;
	$inpg=~s/<\/b>//gi;
	$inpg=~s/<b>//gi;
	$inpg=~s/<b//gi;
	$inpg=~s/<\/b//gi;
	$inpg=~s/\/b>//gi;
	$inpg=~s/ / /gi;
	$inpg=~s/$ordm//gi;
	$inpg=~s/$ardm//gi;
	$inpg=~s/identifier><\/identifier/identifier>EMPTY<\/identifier/gi;
	$inpg=~s/sender><\/sender/sender>EMPTY<\/sender/gi;
	$inpg=~s/sent><\/sent/sent>EMPTY<\/sent/gi;
	$inpg=~s/status><\/status/status>EMPTY<\/status/gi;
	$inpg=~s/msgType><\/msgType/msgType>EMPTY<\/msgType/gi;
	$inpg=~s/scope><\/scope/scope>EMPTY<\/scope/gi;
	$inpg=~s/references><\/references/references>EMPTY<\/references/gi;
	$inpg=~s/category><\/category/category>EMPTY<\/category/gi;
	$inpg=~s/event><\/event/event>EMPTY<\/event/gi;
	$inpg=~s/urgency><\/urgency/urgency>EMPTY<\/urgency/gi;
	$inpg=~s/severity><\/severity/severity>EMPTY<\/severity/gi;
	$inpg=~s/certainty><\/certainty/certainty>EMPTY<\/certainty/gi;
	$inpg=~s/effective><\/effective/effective>EMPTY<\/effective/gi;
	$inpg=~s/expires><\/expires/expires>EMPTY<\/expires/gi;
	$inpg=~s/senderName><\/senderName/senderName>EMPTY<\/senderName/gi;
	$inpg=~s/headline><\/headline/headline>EMPTY<\/headline/gi;
	$inpg=~s/description><\/description/description>EMPTY<\/description/gi;
	$inpg=~s/web><\/web/web>EMPTY<\/web/gi;
	$inpg=~s/contact><\/contact/contact>EMPTY<\/contact/gi;
	$inpg=~s/parameter><\/parameter/parameter>EMPTY<\/parameter/gi;
	$inpg=~s/areaDesc><\/areaDesc/areaDesc>EMPTY<\/areaDesc/gi;
	$inpg=~s/geocode><\/geocode/geocode>EMPTY<\/geocode/gi;
	$ProcessedData=$inpg;
	$item="";
	$identifier="";
	$sender="";
	$sent="";
	$status="";
	$msgtype="";
	$scope="";
	$references="";
	$category="";
	$event="";
	$urgency="";
	$severity="";
	$certainty="";
	$effective="";
	$expires="";
	$senderName="";
	$headline="";
	$MD="";
	$web="";
	$contact="";
	$parameters="";
	$areadesc="";
	$gc="";
	$su="0";
	$usr="";
	$US="";
	$LT="";
	$NS="";
	$LN="";
	$EW="";
	$EV="0";
	my $rss=new XML::RSS(Style => 'Debug');
	eval{$rss->parse($inpg)};
	if($@){
		$alertSubject="(bad USGS Volcano data)";
		$alertData="USGSVF: $elCN [bad data - umatching-tags/unwanted-tags/empty-xml-fields in data?]";
		&alertADMIN;
		print "USGSVF: $elCN [bad data - umatching-tags/unwanted-tags/empty-xml-fields in data? - MANUAL INTERVENTION REQUIRED]\n\n";
	}
	else{
		foreach $item (@{$rss->{'items'}}){ 
			$identifier=$item->{identifier};
			$sender=$item->{sender};
			$sent=$item->{sent};
			$status=$item->{status};
			$msgtype=$item->{msgType};
			$scope=$item->{scope};
			$references=$item->{references};
			$category=$item->{category};
			$event=$item->{event};
			$urgency=$item->{urgency};
			$severity=$item->{severity};
			$certainty=$item->{certainty};
			$effective=$item->{effective};
			$expires=$item->{expires};
			$senderName=$item->{senderName};
			$headline=$item->{headline};
			$MD=$item->{description};
			$web=$item->{web};
			$contact=$item->{contact};
			$parameters=$item->{parameter};
			$areadesc=$item->{areaDesc};
			$gc=$item->{geocode};
			$countRuns++;
		}
		$identifier=~s/EMPTY//gi;
		$sender=~s/EMPTY//gi;
		$sent=~s/EMPTY//gi;
		$status=~s/EMPTY//gi;
		$msgtype=~s/EMPTY//gi;
		$scope=~s/EMPTY//gi;
		$references=~s/EMPTY//gi;
		$category=~s/EMPTY//gi;
		$event=~s/EMPTY//gi;
		$urgency=~s/EMPTY//gi;
		$severity=~s/EMPTY//gi;
		$certainty=~s/EMPTY//gi;
		$effective=~s/EMPTY//gi;
		$expires=~s/EMPTY//gi;
		$senderName=~s/EMPTY//gi;
		$headline=~s/EMPTY//gi;
		$MD=~s/EMPTY//gi;
		$web=~s/EMPTY//gi;
		$contact=~s/EMPTY//gi;
		$parameters=~s/EMPTY//gi;
		$areadesc=~s/EMPTY//gi;
		$gc=~s/EMPTY//gi;
		if($parameters=~"Aviation Color Code"&&$parameters=~"Alert Code"&&$parameters=~"=" ){ 
			$parameters=~s/Aviation Color Code//gi;
			$parameters=~s/Alert Code//gi;
			($blanker, $aviation, $alertlevel)=split(/=/,$parameters);
		}
		$headline=autoformat $headline,{case => 'title'};
		chomp($headline);
		$headline=~s/\n//gi;
		$cwccal=0;
		if($MD=~"Color Code"&&$MD=~"Alert Level"){ 
			@miDESC=split(/\n/,$MD);
			$realc=0;
			$TD="";
			foreach $mdesc (@miDESC){ 
				if($mdesc=~"Color Code" || $mdesc=~"Alert Level"){
					$cwccal=$realc;
				}
				elsif($cwccal > 0){ 
					$TD=$TD."$mdesc";
				}
				if($TD ne ""){
					$TD=$TD."\n";
				}
				$realc++;
			}
		}
		if($cwccal == 0){ 
			$TD=$MD;
		}
		$MD=$TD;
		$MD=~s/\n\n\n/\n\n/gi;
		$MD=~s/\n\n\n/\n\n/gi;
		$MD=~s/\n\n\n/\n\n/gi;
		$AD="";
		$LAT="";
		$LON="";
		$miAreaDesc="";
		if(length($areadesc) > 2){ 
			@rAD=split(/ /,$areadesc);
			$countNSEF=0;
			foreach $unad (@rAD){ 
				$sant='ST.';
				$santl='st.';
				$unad=~s/$sant/ST/gi;
				$unad=~s/$santl/st/gi;
				if($gc !~ m/[0-9]*[-][0-9]*[-=]?/&&$unad=~m/[0-9]*[-][0-9]*[-=]?/){ 
					$myGEO=$unad;
					$myGEO=~s/\(//gi;
					$myGEO=~s/\)//gi;
					$myGEO=~s/\[//gi;
					$myGEO=~s/\]//gi;
					$myGEO=~s/ //gi;
					$myGEO=~s/,//gi;
					$gc=$myGEO;
				}
				elsif($unad=~m/[0-9]*[.][0-9]*/){
				$unad=~s/ //gi;
				$unad=~s/,//gi;
				if($countNSEF == 0){ 
					$LAT="$unad";
					if($LAT=~"S"){
						$LAT=~s/S//gi;
						$LAT="-".$LAT;
					}
					$LAT=~s/N//gi;
				}
				else{ 
					$LON="$unad";
					if($LON=~"W"){
						$LON=~s/W//gi;
						$LON="-".$LON;
					}
					$LON=~s/E//gi;
				}
				$countNSEF++;
				}
				elsif($unad=~"Summit Elevation" || $unad=~"Elevation" || $unad=~"CAVW"){ }
				else{ 
					$miAreaDesc=$miAreaDesc." $unad";
				}
			}
		}
		$AD="$miAreaDesc";
		if($LAT eq "" || $LON eq ""){ 
			print "damm no lat/lon\n\n";
		}
		$gc=~s/CAVW=//gi;
		if($gc=~"Cascade Range"){
			$gc="";
		}
		if($gc=~m/[0-9]*[-][0-9]*[-=]?/){ 
			my $sth=$dbh->prepare("SELECT USRegion, Elevation, Name FROM WorldVolcanoes WHERE CAVW='$gc'");
			$sth->execute or die "Sorry, no DB, please try again.\n";
			my $row=$sth->fetchrow_arrayref;
			$US=$row->[0];
			$EV=$row->[1];
			$VN=$row->[2];
			$sth->finish;
			$su="$EV";
			$usr="$US";
			$areadesc="$VN Volcano";
		}
		if($su eq ""){
			$su="0";
		}
	}
	my $sth=$dbh->prepare("INSERT INTO VolcanoReleases (ReleaseID, DateTimeStamp, Effective, Expires, Headline, Web, Description, Contact, Identifier, Status, MsgType, Scope, Reference, Urgency, Severity, Certainty, AlertCode, AviationColorCode, Category, Sender, Sent, SenderName, Event, AreaDesc, GeoCode, USRegion, Latitude, Longitude, Elevation, ActualData, ProcessedData) VALUES ('$elCN','$datetime','$effective','$expires','$headline','$web','$MD','$contact','$identifier','$status','$msgtype','$scope','$references','$urgency','$severity','$certainty','$alertlevel','$aviation','$category','$sender','$sent','$senderName','$event','$areadesc','$gc','$usr','$LAT','$LON','$su','$ActualData','$ProcessedData')");
	$sth->execute or die "Unable to execute query\n";
	$sth->finish;
}
exit;
