#!/usr/bin/perl -s

##################################################################
#   Program:        Earth Health Monitor                         #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2006 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:      USGS Data Feed Analyzer                      #
#        Module:    USGS Earthquake Data Monitor                 #
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

###---TESTED & WORKING 091909 :: LATEST ---###
require("/var/www/html/DN/adminAlert.nsp");
require("/var/www/html/DN/parse_query.nsp");
require("/var/www/html/DN/calcDistanceLatLon.nsp");
require("/var/www/html/DN/sendAlert1.nsp");
$noDateParse=1;
require ("/var/www/html/DN/dateNew.nsp");

use locale;
use Text::Autoformat;
use DBI;

my $dbh=DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>USGSFeeds</b>\n";
$dbh->{RaiseError}=1;
my $sth=$dbh->prepare("SELECT * FROM Earthquakes WHERE FeedID='1'");
$sth->execute or die "Sorry, no DB, please try again.\n";
my $row=$sth->fetchrow_arrayref;
$SFName=$row->[1];
$SFRSS=$row->[3];
$SFLastData=$row->[4];
$SFLastReportDate=$row->[5];
$sth->finish;
$dbh->disconnect;

my $dbh=DBI->connect("DBI:mysql:DN_Mapping",$leLU,$leLP) or die "Unable to connect to database: <b>Mapping</b>\n";
$dbh->{RaiseError}=1;
my $sth=$dbh->prepare("SELECT StateName, StateAbrv FROM States");
$sth->execute or die "Unable to execute query\n";
my @row;
while(@row=$sth->fetchrow_array){
	$StateName=$row[0];
	$SABRV=$row[1];
	push(@StateNames,"$StateName");
	push(@StateABRV,"$SABRV");
	$losSTATES{uc($SABRV)}=$StateName;
}
$sth->execute or die "Unable to execute query\n";
$sth->finish;
$dbh->disconnect;

use LWP::Simple;
use CGI;
use CGI::Carp qw(fatalsToBrowser);

my $ur="$SFRSS";
my $pg=get ($ur);
$pg=~s/'/"/gi;
$passed=0;
if($pg=~"</rss>" && $pg ne "$SFLastData"){
	my $dbh=DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>USGSFeeds</b>\n";
	$dbh->{RaiseError}=1;
	$passed=1;
	my $sth=$dbh->prepare("UPDATE LOW_PRIORITY Earthquakes SET LastData='$pg' WHERE FeedID='1'");
	$sth->execute or die "Unable to execute query\n";
	$sth->finish;
	$dbh->disconnect;
}
elsif($pg eq "$SFLastData"){
	print "USGS-EQ:good [No New Records] [Same data as before]";
	exit;
}
else{ 
	$passed=0;
	$alertSubject="(bad USGS Earthquake)";
	$alertData="";
	&alertADMIN;
	print "USGS-EQ:bad [USGS Earthquake DATA] [Did not pass primary tests]";
	exit;
}

use Text::Beautify;
use XML::RSS;
use lib;
$pg=~s/geo:lat/geolat/gi;
$pg=~s/geo:long/geolon/gi;
$pg=~s/geo:lon/geolon/gi;
my $rss=new XML::RSS(Style => 'Debug');
$rss->parse($pg);
$newlyAdded=0;
$countRuns=0;
$nn=0;
$numAffected=0;

my $dbh=DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>USGSFeeds</b>\n";
$dbh->{RaiseError}=1;
@NOAAHAC="";

foreach $item (@{$rss->{'items'}}){
	$Title=$item->{title};
	$Link=$item->{link};
	$Description=$item->{description};
	$PubDate=$item->{pubDate};
	$Lat=$item->{geolat};
	$Lon=$item->{geolon};
	$pd=$PubDate;
	$pd=~s/,//gi;
	($DaySpelled1, $Da1, $Mo1, $Yr1, $Ti1, $TimeZone1)=split(/ /,$pd);
	chomp($Mo1);
	$Mo1=~s/\s+/ /g;
	$esteDate=$Yr1.'-'.$los_months_abrv{$Mo1}.'-'.$Da1.' '.$Ti1;
	$EID=0;
	my $sth=$dbh->prepare("SELECT EarthquakeID FROM EarthquakesRecorded WHERE (PubDate='$esteDate') AND (Link='$Link')");
	$sth->execute or die "Sorry, no DB, please try again.\n";
	my $row=$sth->fetchrow_arrayref;
	$EID=$row->[0];
	$sth->finish;
	
	if($EID == 0){
		@splitT=split(/, /,$Title);
		@reverseT=reverse @splitT;
		$al=$reverseT[0];
		$al=~s/Southeastern //gi;
		$al=~s/Southwestern //gi;
		$al=~s/Northeastern //gi;
		$al=~s/Northwestern //gi;
		$al=~s/ Peninsula//gi;
		$al=~s/Central //gi;
		$al=~s/Southern //gi;
		$al=~s/Northern //gi;
		$al=~s/Offshore //gi;
		$al=~s/Off the coast of //gi;
		$al=~s/ region//gi;
		$al=~s/gulf of //gi;
		$al=~s/south of //gi;
		$al=~s/north of //gi;
		$al=~s/west of //gi;
		$affected=0;
		$csn=0;
		foreach $SN (@StateNames){
			if($SN eq "$al"){
				$affected=1;
				$NOAAHAC[$countRuns]="$Title-----$Link-----$PubDate-----$Lat-----$Lon-----1-----$SN";
			}
		}
		if($affected eq "0"){
			$NOAAHAC[$countRuns]="$Title-----$Link-----$PubDate-----$Lat-----$Lon-----0";
		}
	} $countRuns++;
}
$dbh->disconnect;

@NOAAHAC=reverse @NOAAHAC;
foreach $IL (@NOAAHAC){
	@splitIN=split(/-----/,$IL);
	$inT=$splitIN[0];
	$inL=$splitIN[1];
	$inD=$splitIN[2];
	$inLA=$splitIN[3];
	$inLO=$splitIN[4];
	$inSN=$splitIN[6];
	$foundOne=0;
	$INDd="";
	if($inD=~","){
		$inD=~s/,//gi;
		($DaySpelled, $Da, $Mo, $Yr, $Ti, $TimeZone)=split(/ /,$inD);
		chomp($Mo);
		$Mo=~s/\s+/ /g;
		$newDate=$Yr.'-'.$los_months_abrv{$Mo}.'-'.$Da.' '.$Ti;
		@splitT=split(/, /,$inT);
		$fullMag=$splitT[0];
		($crap, $magz)=split(/ /,$fullMag);
		$INDd=$inL;
		my $dbh=DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>USGSFeeds</b>\n";
		$dbh->{RaiseError}=1;
		my $sth=$dbh->prepare("INSERT INTO EarthquakesRecorded (EarthquakeID, DateTimeStamp, ActualData, Link, Lat, Lon, PubDate, Magnitude)  VALUES (Null, '$datetime', '$IL', '$inL', '$inLA', '$inLO', '$newDate', '$magz')");
		$sth->execute or die "Unable to execute query\n";
		$sth->finish;
		$dbh->disconnect;
		if(length($inSN) > 2){
			push(@newQuakes,"$IL-----$magz");
		}
	}
}

if(@newQuakes){
	my $dbh=DBI->connect("DBI:mysql:DN_Mapping",$leLU,$leLP) or die "Unable to connect to database: <b>Mapping</b>\n";
	$dbh->{RaiseError}=1;
	use Math::Round qw(round);
	foreach $NQ (@newQuakes){
		@splitNQ=split(/-----/,$NQ);
		$nqT=$splitNQ[0];
		$nqL=$splitNQ[1];
		$nqD=$splitNQ[2];
		$nqLA=$splitNQ[3];
		$nqLO=$splitNQ[4];
		$nqSN=$splitNQ[6];
		$nqMAG=$splitNQ[7];
		$lastInfo="";
		$closestInfo="";
		if($splitNQ[5] eq "1"){
			$CountFINDS=0;
			@nqLA1=split(/\./, $nqLA);
			@nqLO1=split(/\./, $nqLO);
			$nqLAT=$nqLA1[0].".";
			$nqLON=$nqLO1[0].".";
			$sd="250000";
			$closestInfo="";
			$cl="";
			my $sth=$dbh->prepare("SELECT * FROM States WHERE StateName LIKE '%$nqSN%'");
			$sth->execute or die "Unable to execute query\n";
			my @row;
			while(@row=$sth->fetchrow_array){
				$uscStateName=$row[1];
				$uscSABRV=$row[2];
				$uscID=$row[8];
			} 
			$sth->execute or die "Unable to execute query\n";
			$sth->finish;
			my $sth=$dbh->prepare("SELECT * FROM USPS_AIS_GEO WHERE State='$uscSABRV'");
			$sth->execute or die "Unable to execute query\n";
			my @row;
			while(@row=$sth->fetchrow_array){
				my $ZIP=$row[1];
				my $CIT=$row[2];
				my $LAT=$row[6];
				my $LON=$row[7];
				$CIT=~s/'//gi;
				my $mydistance=distance($LAT, $LON, $nqLA, $nqLO, "M");
				if($mydistance < $sd && int($ZIP) > 100){
					$sd=round($mydistance);
					$cl="$ZIP-----$CIT-----$uscStateName-----$sd-----$LAT-----$LON-----$nqLA-----$nqLO-----$nqT-----$nqL-----$nqD-----$nqMAG";
				}
			} 
			$sth->execute or die "Unable to execute query\n";
			$sth->finish;
			if($cl ne ""){
				push(@validEQs,"$cl");
			}
		}
	}
	$dbh->disconnect;
} 
use LWP::Simple;
use CGI;
use CGI::Carp qw(fatalsToBrowser);
$countVEQ=0;
foreach $VEQ (@validEQs){
	@splitVEQ=split(/-----/,$VEQ);
	$zee=$splitVEQ[0];
	if(length($zee) < 5){
		if(length($zee) == 4){
			$zee= "0".$zee;
		}
		if(length($zee) == 3){
			$zee= "00".$zee;
		}
	} 
	$magn=sprintf("%.1f", $splitVEQ[11]);
	$within=50;
	if($magn>6.2){
		$within=300;
	}
	elsif($magn>5.5){
		$within=200;
	}
	elsif($magn>4.8){
		$within=175;
	}
	elsif($magn>4.1){
		$within=150;
	}
	elsif($magn>3.4){
		$within=125;
	}
	elsif($magn>2.7){
		$within=75;
	}
	$inZIP=$zee;
	@losDistances='';
	$lat1='0';
	$lon1='0';
	my $dbh=DBI->connect("DBI:mysql:DN_Mapping",$leLU,$leLP) or die "Unable to connect to database: <b>Mapping: Local</b>\n";
	$dbh->{RaiseError}=1;
	my $sth=$dbh->prepare("select Latitude,Longitude FROM USPS_AIS_GEO WHERE ZipCode='$inZIP'");
	$sth->execute or die "Unable to execute query\n";
	my @row;
	while(@row=$sth->fetchrow_array){
		$lat1=$row[0];
		$lon1=$row[1];
	}
	if($lat1 ne '0' && $lon1 ne '0'){
		my $sth=$dbh->prepare("select ZipCode,Latitude,Longitude, acos((SIN( PI()* $lat1 /180 )*SIN( PI()*Latitude/180 ))+(cos(PI()* $lat1 /180)*COS( PI()*Latitude/180) *COS(PI()*Longitude/180-PI()* $lon1 /180)))* 3963.191 AS DISTANCE FROM USPS_AIS_GEO WHERE 1=1 AND 3963.191 * ACOS( (SIN(PI()* $lat1 /180)*SIN(PI() * Latitude/180)) + (COS(PI()* $lat1 /180)*cos(PI()*Latitude/180)*COS(PI() * Longitude/180-PI()* $lon1 /180))) <= $within ORDER BY 3963.191 * ACOS((SIN(PI()* $lat1 /180)*SIN(PI()*Latitude/180)) + (COS(PI()* $lat1 /180)*cos(PI()*Latitude/180)*COS(PI() * Longitude/180-PI()* $lon1 /180)))");
		$sth->execute or die "Unable to execute query\n";
		my @row;
		while(@row=$sth->fetchrow_array){my $dzip=$row[0];
		my $dlat=$row[1];
		my $dlon=$row[2];
		my $ddist=$row[3];
		$thisdist=sprintf("%.2f", $ddist);
		push(@losDistances,"$dzip-----$thisdist");
		} $sth->finish;
		$dbh->disconnect;
		$zips="";
		$cz=0;
		$lz="";
		foreach $bydistance (@losDistances){($lz,$dfe)=split(/-----/,$bydistance);
		$dfe=~s/ miles//gi;
		if($cz eq "0"){$zips="$lz ::::: $dfe";
		}else{$zips=$zips."xxxxx"."$lz ::::: $dfe";
		} $cz++;
		} $cleanzips=' ::::: xxxxx';
		$zips=~s/$cleanzips//gi;
		$validEQs[$countVEQ]=$validEQs[$countVEQ]."-----"."$zips";
		$countVEQ++;
	}
}
if(@validEQs){
	foreach $VEQ (@validEQs){
		@splitVEQf=split(/-----/,$VEQ);
		$myDesc=$splitVEQf[10];
		$theLAT=$splitVEQf[6];
		$theLON=$splitVEQf[7];
		$theT=$splitVEQf[8];
		$theL=$splitVEQf[9];
		$theZIPS=$splitVEQf[12];
		@splitDesc=split(/:/,$myDesc);
		$theDesc=$theLAT."-----".$theLON."-----".$splitDesc[0].":".$splitDesc[1];
		my $dbh=DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>USGSFeeds</b>\n";
		$dbh->{RaiseError}=1;
		my $sth=$dbh->prepare("UPDATE LOW_PRIORITY EarthquakesRecorded SET Title='$theT', ProcessedData='$VEQ' WHERE ActualData LIKE '%$myDesc%'");
		$sth->execute or die "Unable to execute query\n";
		$sth->finish;
		my $sth=$dbh->prepare("SELECT EarthquakeID, ActualData FROM EarthquakesRecorded WHERE ActualData LIKE '%$myDesc%'");
		$sth->execute or die "Unable to execute query\n";
		my @row;
		while(@row=$sth->fetchrow_array){
			$EID=$row[0];
		} 
		$sth->execute or die "Unable to execute query\n";
		$sth->finish;
		$dbh->disconnect;
		if($splitVEQf[12]=~" ::::: "){
			push(@alertsToSend,"$EID %%%%% $theZIPS");
		}
	}
}
if(@alertsToSend){
	my $dbh=DBI->connect("DBI:mysql:DN_Master",$leLU,$leLP) or die "Unable to connect to database: <b>Master</b>\n";
	$dbh->{RaiseError}=1;
	foreach $ATS (@alertsToSend){
		 @afz="";
		$zips="";
		$PPA=0;
		@splitATS=split(/ %%%%% /,$ATS);
		$alertID=int($splitATS[0]);
		$zips=$splitATS[1];
		if($zips=~" ::::: " && $zips=~"xxxxx"){
			if($zips=~"xxxxx"){
				@afz=split(/xxxxx/,$ATS);
			} 
			elsif($zips=~" ::::: "){
				$afz[0]=$ATS;
			}
			if(@afz){
				foreach $AZ (@afz){
					$PPA=0;
					$wantsEQ=0;
					@splitAZ=split(/ ::::: /,$AZ);
					$acz=$splitAZ[0];
					 my $sth=$dbh->prepare("SELECT UserBase.CustomerID, UserBase.FirstName, UserBase.LastName, UserBase.Email, UserBase.Alerts, UserBase.PPA, PersonalProfiles.CustomerID, PersonalProfiles.EarthQuake FROM UserBase, PersonalProfiles WHERE (UserBase.Zip='$acz' AND UserBase.CustomerID = PersonalProfiles.CustomerID)");
					$sth->execute or die "Unable to execute query\n";
					my @row;
					while(@row=$sth->fetchrow_array){
						$UID=$row[0];
						$UFirst=$row[1];
						$ULast=$row[2];
						$UEmail=$row[3];
						$savedAlerts=$row[4];
						$PPA=$row[5];
						$wantsEQ=$row[7];
						if($savedAlerts=~"e-$alertID"){$dontAdd=1;
						}else{
							if(exists $alreadySaved{"$$UID %%%%% $UEmail %%%%% e-$alertID"}){}else{
								$alreadySaved{"$UID %%%%% $UEmail %%%%% e-$alertID"}=1;
								push(@ATSave,"$UID %%%%% $UEmail %%%%% e-$alertID");
								$UID=int($UID);
								if($PPA eq "1" && $wantsEQ eq "1"){
									if(exists $alreadySent{"$UIDxxxxx$UEmail"}){} 
									else{ $alertURL="e.htm?d=$UID";
										$emailData="<a href=\"http://www.disasternotify.com/$alertURL\" title=\"Click for more info...\">Earthquake!</a>";
										&SendAlert1;
										$nn++;
										$alreadySent{"$UIDxxxxx$UEmail"}=1;
									}
								}
							}
						}
					}
					$sth->execute or die "Unable to execute query\n";
					$sth->finish;
				}
			}
		}
	}
	$dbh->disconnect;
	if(@ATSave){
		require("/var/local/nmscontrol/savUA.nsp");
	}
	if($nn > 0){
	$nn=": [$nn users notified]";
	}
	if($numAffected > 0){
		$numAffected=": [$numAffected users affected]";
	}
}
print "USGS-EQ:good [".int(@validEQs)." New Quakes in USA ] $numAffected $nn";
exit;
