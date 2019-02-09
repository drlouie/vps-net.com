#!/usr/bin/perl -s

##################################################################
#   Program:        Earth Health Monitor                         #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2006 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:      USGS Data Feed Analyzer                      #
#        Module:    USGS Volcano Data Monitor                    #
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
require("/var/www/html/DN/dateNew.nsp");
use locale;
use Text::Autoformat;
use Date::Manip;
use DBI;

my $dbh=DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>USGSFeeds: Local</b>\n";
$dbh->{RaiseError}=1;
my $sth=$dbh->prepare("SELECT * FROM Volcanoes WHERE FeedID='1'");
$sth->execute or die "Sorry, no DB, please try again.\n";
my $row=$sth->fetchrow_arrayref;
$SFName=$row->[1];
$SFRSS=$row->[3];
$SFLastData=$row->[4];
$SFLastReportDate=$row->[5];
$sth->finish;
$dbh->disconnect;

my $dbh=DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>USGSFeeds: Local</b>\n";
$dbh->{RaiseError}=1;
my $sth=$dbh->prepare("SELECT * FROM VolcanoReleaseControl WHERE ControlID='1'");
$sth->execute or die "Sorry, no DB, please try again.\n";
my $row=$sth->fetchrow_arrayref;
$ReleaseID=int($row->[1]);
$LastData=$row->[2];
$LastCheckDate=$row->[3];
$IsEmpty=$row->[6];
$FirstTimeEmpty=$row->[7];
$sth->finish;
$dbh->disconnect;

use LWP::Simple;
use CGI;
use CGI::Carp qw(fatalsToBrowser);

my $url="$SFRSS";
my $page=get ($url);
$page=~s/'/`/gi;
$page=~s/'/`/gi;
$passed=0;

if($page=~"</rss>" && $page ne "$SFLastData"){
	my $dbh=DBI->connect("DBI:mysql:DN_USGSFeeds",$leLU,$leLP) or die "Unable to connect to database: <b>USGSFeeds: Local</b>\n";
	$dbh->{RaiseError}=1;
	$passed=1;
	my $sth=$dbh->prepare("UPDATE LOW_PRIORITY Volcanoes SET LastData='$page' WHERE FeedID='1'");
	$sth->execute or die "Unable to execute query\n";
	$sth->finish;
	$dbh->disconnect;
}
elsif($page eq "$SFLastData"){
	print "Same data as before. [GOOD]";
	exit;
}
else{
	$passed=0;
	$alertSubject="(no/bad USGS Volcano VCAP)";
	$alertData="";
	&alertADMIN;
	print "No/Bad USGS Volcano VCAP data.";
	exit;
}
use XML::RSS;
use lib;
$page=~s/georss:point/geopoint/gi;
$page=~s/volcano:alertlevel/volcanoalertlevel/gi;
$page=~s/volcano:colorcode/volcanocolorcode/gi;
my $rss=new XML::RSS(Style => 'Debug');
$rss->parse($page);
$newlyAdded=0;
$countItems=0;
$countBadCapDATA=0;
$currCapID=0;
$isNewItem=0;
foreach $item (@{$rss->{'items'}}){
	$Title=$item->{title};
	$Description=$item->{description};
	$Link=$item->{link};
	$LatLon=$item->{geopoint};
	$AlertLevel=$item->{volcanoalertlevel};
	$ColorCode=$item->{volcanocolorcode};
	my $urlL="$Link";
	if($urlL=~"="){
		my ($locat,$idee)=split(/=/,$urlL);
		if(int($idee) > int($ReleaseID)){
			if($isNewItem < int($idee)){ 
				$isNewItem=int($idee);
			}
		}
	}
	else{
		$alertSubject="(bad USGS Volcano Data - missing QS)";
		$alertData="";
		&alertADMIN;
		print "Bad USGS Volcano data: MISSING [ query string ] AND/OR [ Volcano Alert Level ]";
		exit;
	}
}
if($isNewItem > 0){
	$alertSubject="(unbalanced USGS Volcano data)";
	$alertData="maybe some empty alerts were released by USGS";
	&alertADMIN;
	print "USGS Volcano RSS FeedID we found ($isNewItem) is NEWER than PROCESSOR/AGGREGATOR ControlID ($ReleaseID).";
	exit;
}
print "USGSVCAP [GOOD]";
exit;
