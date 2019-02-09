#!/usr/bin/perl -s

##################################################################
#   Program:        Earth Health Monitor                         #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2006 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:      Web Query: Moon Phases                       #
#        Module:    Moon Phase Manager                           #
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
require("/var/www/html/DN/sendAlert1.nsp");
require("/var/www/html/DN/parse_query.nsp");
$noDateParse=1;
require("/var/www/html/DN/dateNew.nsp");

use locale;
use DBI;use LWP::Simple;
use CGI;
use CGI::Carp qw(fatalsToBrowser);

my $url="http://i.ngen-io.us/dfm.htm";

my $CURRPage=get($url);

$subreaker='<br />';

print $CURRPage;

if($CURRPage=~"Moon Phase"&&$CURRPage=~$subreaker){
	@splitP=split(/\n/,$CURRPage);
	foreach $unaL (@splitP){
		if($unaL=~"Moon Phase"&&$unaL=~$subreaker){
			($crappity,$mmpl)=split(/$subreaker/,$unaL);
		}
	}
	if($mmpl){
		$lndr='</td></tr>';
		$mmpl=~s/$lndr//gi;
		if(length($mmpl)>5){
			$theMoonPhase="$mmpl";
			my $dbh=DBI->connect("DBI:mysql:DN_WeatherCom",$leLU,$leLP) or die "Unable to connect to database: WeatherCom: Local\n";
			$dbh->{RaiseError}=1;
			$passed=1;
			my $sth=$dbh->prepare("INSERT INTO USMoonPhaseRecorder (MPRID,CurrentPhase,DateTimeStamp) VALUES (Null,'$theMoonPhase','$datetime')");
			$sth->execute or die "Unable to execute query\n";
			$sth->finish;
			$theMoonPhase=~s/ //gi;
			open(MOONFILE,">/var/local/feeder/moon.nsf") || &error('can not write to /var/local/feeder/moon.nsf');
			flock(MOONFILE, 2);
			print MOONFILE "$theMoonPhase";
			flock(MOONFILE, 8);
			close(MOONFILE);$wroteLocal=1;
			$dbh->disconnect;
		}
		else {
			$alertSubject="(!!bad moon value WU [ MASTER moonie ] [ $value ]!!)";
			$alertData="";
			&alertADMIN;
		}
	}
}
else {
	$alertSubject="(!!bad moon feedback WU [ MASTER moonie ] was looking for [ WU: 90210 ]!!)";
	$alertData="";
	&alertADMIN;
}

if($passed && $wroteLocal){
	require("/var/local/nmscontrol/dnessh.nsp");
	$filedate=$datetime;
	$filedate=~s/://gi;
	$filedate=~s/-//gi;
	$filedate=~s/ //gi;
	$sftp->put("/var/local/feeder/moon.nsf", "/home/content/d/1/s/d1sasterhost/feed/moon.nsf");
}
else{
	$alertSubject="(!!bad moon date save WU [ MASTER moonie ] was looking for [ did not pass or write ]!!)";
	$alertData="";
	&alertADMIN;
}
exit;
