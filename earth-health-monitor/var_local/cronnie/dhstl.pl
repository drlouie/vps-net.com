#!/usr/bin/perl -s

##################################################################
#   Program:        Earth Health Monitor                         #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2006 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:      Website Query: Threat Level Image (DHS)      #
#        Module:    DHS Threat Level Monitor                     #
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

require("/var/www/html/DN/parse_query.nsp");
require("/var/www/html/DN/adminAlert.nsp");
require("/var/www/html/DN/sendAlert1.nsp");
$noDateParse=1;
require ("/var/www/html/DN/dateNew.nsp");
use locale;
use DBI;
use LWP::Simple;
use CGI;
use CGI::Carp qw(fatalsToBrowser);
my $url="http://www.dhs.gov/";
my $urlI="http://www.dhs.gov/threat_level/current_new.gif";
my $CURRPage=get ($url);
$theDT=$datetime;
if($CURRPage=~"current_new.gif" && $CURRPage=~"threat"){
	$SeekString='<img src="/threat_level/current_new.gif" alt="Current National Threat Level is elevated" /></a>';
	@lePagina=split(/\n/,$CURRPage);
	$cp=0;
	foreach $lp (@lePagina){
		if($lp=~"$SeekString"){
			$containerLine=$lp;
			$afterContainer=int($cp+1);
		}$cp++;
	}
	$theDESC='';
	$Sought1='<a href="/';
	$Replace1='<a target="DHS" style="color:#000000" href="http://www.DHS.GOV/';
	$myDesc=$lePagina[$afterContainer];
	if($myDesc=~$Sought1){
		$miDESC=$myDesc;
		$miDESC=~s/$Sought1/$Replace1/gi;
		@SthaD=split("p>", $miDESC);
		$theDESC="<p>" . $SthaD[1] . "p>";
	}
	$containerLiner=lc($containerLine);
	if($containerLiner=~"low"){
		$currLevel='Low';
		$currLevelNum='1';
	}
	if($containerLiner=~"guarded"){
		$currLevel='Guarded';
		$currLevelNum='2';
	}
	if($containerLiner=~"elevated"){
		$currLevel='Elevated';
		$currLevelNum='3';
	}
	if($containerLiner=~"high"){
		$currLevel='High';
		$currLevelNum='4';
	}
	if($containerLiner=~"severe"){
		$currLevel='Severe';
		$currLevelNum='5';
	}
	$TD=lc($theDESC);
	if($TD=~"low"){
		$ASLevel='Low';
		$ASLevelNum='1';
	}
	if($TD=~"guarded"){
		$ASLevel='Guarded';
		$ASLevelNum='2';
	}
	if($TD=~"elevated"){
		$ASLevel='Elevated';
		$ASLevelNum='3';
	}
	if($TD=~"high"){
		$ASLevel='High';
		$ASLevelNum='4';
	}
	if($TD=~"severe"){
		$ASLevel='Severe';
		$ASLevelNum='5';
	}
	my $dbh=DBI->connect("DBI:mysql:DN_Federal",$leLU,$leLP) or die "Unable to connect to database: <b>Federal: Local</b>\n";
	$dbh->{RaiseError}=1;
	my $sth=$dbh->prepare("SELECT EntryID, CurrentLevel, LevelNumber, AirlineSectorLevel, ASLevelNumber, DateOfChange FROM DHS_ThreatAdvisoryLevel ORDER BY EntryID DESC limit 0, 1");
	$sth->execute or die "Unable to execute query\n";
	my @row;
	while(@row=$sth->fetchrow_array){
		$EID=$row[0];
		$CL=$row[1];
		$CLI=$row[2];
		$AS=$row[3];
		$ASI=$row[4];
		$LastChanged=$row[5];
	}
	$sth->execute or die "Unable to execute query\n";
	$sth->finish;
	$dbh->disconnect;
	
	if(lc($currLevel) ne lc($CL) || lc($ASLevel) ne lc($AS)){
	
		my $dbh=DBI->connect("DBI:mysql:DN_Federal",$leLU,$leLP) or die "Unable to connect to database: <b>Federal</b>\n";
		 $dbh->{RaiseError}=1;
		my $sth=$dbh->prepare("INSERT INTO DHS_ThreatAdvisoryLevel (EntryID, CurrentLevel, LevelNumber, AirlineSectorLevel, ASLevelNumber, DateOfChange, LatestData, LastChecked) VALUES (Null, '$currLevel', '$currLevelNum', '$ASLevel', '$ASLevelNum', '$theDT', '$theDESC', '$theDT')");
		$sth->execute or die "Unable to execute query\n";
		$sth->finish;
		$dbh->disconnect;
		
		open(DHSTLIFILE,">/var/local/feeder/dhstli.nsf") || &error('can not write to /var/local/feeder/dhstli.nsf');
		flock(DHSTLIFILE, 2);
		print DHSTLIFILE "$currLevel" . "\t" . "$theDT" . "\t" . "$ASLevel";
		flock(DHSTLIFILE, 8);
		close(DHSTLIFILE);
		
		$alertEm=1;
	}
	else {
		&updateLoggie;
		print "DHS-TL: good";
	}
}
else {
	$passed="0";
	$alertSubject="(DHS source error/changed)";
	$alertData="";
	&alertADMIN;
	print "DHS-TL: bad";
}

if($alertEm){

	$aType="dhstl";
	$aurl="h.htm?d=";
	$aed="<a href=\"http://www.disasternotify.com/$alertURL\" title=\"Threat Level Changed to $currLevel\">Homeland Security</a>";
	require("/var/local/nmscontrol/au.nsp");
	require("/var/local/nmscontrol/dnessh.nsp");
	
	$filedate=$theDT;
	$filedate=~s/://gi;
	$filedate=~s/-//gi;
	$filedate=~s/ //gi;
	
	$sftp->put("/var/local/feeder/dhstli.nsf", "/home/content/d/1/s/d1sasterhost/feed/dhstli.nsf");
}

sub updateLoggie {
	my $dbh=DBI->connect("DBI:mysql:DN_Federal",$leLU,$leLP) or die "Unable to connect to database: <b>Federal: Local</b>\n";
	$dbh->{RaiseError}=1;
	my $sth=$dbh->prepare("UPDATE DHS_ThreatAdvisoryLevel set LastChecked='$theDT' where EntryID=$EID");
	$sth->execute or die "Unable to execute query\n";
	$sth->finish;
	$dbh->disconnect;
}

exit;
