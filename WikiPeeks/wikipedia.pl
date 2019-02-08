#!/usr/bin/perl -s

##################################################
#   Program:    WikiPeeks for Wikipedia          #
#   Author:     Luis Gustavo Rodriguez (drlouie) #
#   Copyright:  (c) 2009 Luis G. Rodriguez       #
#   Licensing:  MIT License                      #
##################################################################################
#                                                                                #
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

use LWP::Simple;
use CGI;
use CGI::Carp qw(fatalsToBrowser);
use HTML::TokeParser;
use HTML::ResolveLink;

#-- just do it this way to defeat warning of used once
if (!$NOSPAM) { $NOSPAM = 1; }
require($HTTPRoot."q.nsp");

##-- force HTTPS for all calls
$forcedPROTOCOL = 'https';

$mua = $ENV{'SCRIPT_NAME'};
$host = $ENV{'HTTP_HOST'};
$appLoc = $forcedPROTOCOL . '://' . $host . '' . $mua;
$source = 'WikiPedia';
#- $sourceFull = 'World Wide Web Consortium';
$langu = 'en';

$sourceDomain = $langu.'.wikipedia.org';
$elURL = $forcedPROTOCOL . '://'.$sourceDomain.'/';
$contentROOT = $forcedPROTOCOL . '://'.$sourceDomain.'/wiki/';
$forsl = '/';

$sourceURL = $forcedPROTOCOL . "://" . $sourceDomain . "";

#- print "Content-type: text/html\n\n";

($sec,$min,$hour,$mday,$mon,$year,$wday) = (localtime(time))[0,1,2,3,4,5,6];
$time = sprintf("%02d:%02d:%02d",$hour,$min,$sec);
#-print "query $time<br><br>";

$ms = "Perl";
if ($FORM{'st'} && length($FORM{'st'}) >= 3) { $ms = "$FORM{'st'}"; }
	$ms =~ s/%2F/$forsl/gi;
	$ms =~ s/%3A/:/gi;

	$requery = $ms;
	$requery =~ s/ /_/gi;
	##-- get base href [true source document path]
	my $bp;
	$bp = $contentROOT . "" . "$requery";

        use Text::Tiki;
        my $tiki = new Text::Tiki;
        $tiki->wiki_implicit_links(1);
        $tiki->wiki_prefix($forcedPROTOCOL . '://'.$ENV{"SERVER_NAME"}.''.$mua.'?st=');
        $tiki->interwiki_links(1);
        $tiki->interwiki_table(
                        { 
                                wikipedia=>$forcedPROTOCOL . '://'.$langu.'2.wikipedia.org/wiki/',
                                joi=>$forcedPROTOCOL . '://joi.ito.com/joiwiki/',
                                atom=>$forcedPROTOCOL . '://www.intertwingly.net/wiki/pie/'
                        }
                );

        $tiki->macro_handler('BR', \&html_break, 'inline');

use MediaWiki::API;

my $MWAPI = MediaWiki::API->new({api_url => $forcedPROTOCOL . '://'.$sourceDomain.'/w/api.php', files_url => $forcedPROTOCOL . '://'.$sourceDomain.'/',});
  
  # log in to the wiki
  $MWAPI->login( { lgname => 'MediaWiki_API_Username', lgpassword => 'MediaWiki_API_PASSWORD' } );

##- remove all errors, we need no spit back
##-    || die $MWAPI->{error}->{code} . ': ' . $MWAPI->{error}->{details};

	
# Retrieve TestPage content
if (length($ms) >= 3) {
	
	##-- make sure to clean up the hex in the url, for instance special characters in latin: José_de_Jesús_Méndez_Vargas
	$cleanSearchString = $ms;
	utf8::decode($cleanSearchString);

	my $page = $MWAPI->get_page( { title => $cleanSearchString } );
	#$text = $page->{'*'};
	$text = $page->{'*'};
	#$texto = $tiki->format($text);
}


$elTitle = $ms;
$elTitle =~ s/_/ /gi;

my $output = $MWAPI->api({
   action => 'parse',
   text   => $text,
   prop   => 'text',
});

my ($junk, $html) = each(%{$output->{'parse'}->{'text'}});


	##-- make any internal document anchors clear by adding the query string to its link
	$linkREW = '<a href="#'; 
	$linkREWR = '<a target="_self" href="?'.$ENV{'QUERY_STRING'}.'#';
	$html =~ s/$linkREW/$linkREWR/gi;
	$html =~ s/$linkREW/$linkREWR/gi;
	##-- make all anchors clear by splitting making sure they all rest within their own line
	$linkREW2 = '</a>'; 
	$linkREW2R = "</a>WACHAPOPTHATLINK\n";
	$html =~ s/$linkREW2/$linkREW2R/gi;


	#-- clean links [make them absolute based on remote path]
  	my $count;
  	my $resolver = HTML::ResolveLink->new(
   	  	base => $contentROOT,
   		callback => sub {
			my($uri, $old) = @_;
     		$count++;
   		},
	);
	$html = $resolver->resolve($html);


    ## make sure we dont parse unwantables [simply REWRITE THE URL as a flag for later processing]
	use HTML::RewriteAttributes::Links;
    HTML::RewriteAttributes::Links->rewrite($html, sub {
        my ($tag, $attr, $value) = @_;
		##-- filter these link types, we dont wanna try parse these types of documents
		##-- m/[^0-9a-zA-Z-_\.\@]/
		#-if ($value =~ '\.gzip' || $value =~ '\.doc' || $value =~ '\.xls' || $value =~ '\.ent' || $value =~ '\.mp3' || $value =~ '\.avi' || $value =~ '\.mpg' || $value =~ '\.mpeg' || $value =~ '\.au' || $value =~ '\.mov' || $value =~ '\.dtd' || $value =~ '\.xml' || $value =~ '\.xsl' || $value =~ '\.zip' || $value =~ '\.ps' || $value =~ '\.pdf' || $value =~ '\.tar' || $value =~ '\.tgz' || $value =~ '\.gz' || $value =~ '\.png' || $value =~ '\.jpg' || $value =~ '\.jpeg' || $value =~ '\.gif' || $value =~ '\.svg') {
		if ($value =~ m/\.gzip$/i || $value =~ m/\.doc$/i || $value =~ m/\.xls$/i || $value =~ m/\.ent$/i || $value =~ m/\.mp3$/i || $value =~ m/\.avi$/i || $value =~ m/\.mpg$/i || $value =~ m/\.mpeg$/i || $value =~ m/\.au$/i || $value =~ m/\.mov$/i || $value =~ m/\.dtd$/i || $value =~ m/\.xml$/i || $value =~ m/\.xsl$/i || $value =~ m/\.zip$/i || $value =~ m/\.ps$/i || $value =~ m/\.pdf$/i || $value =~ m/\.tar$/i || $value =~ m/\.tgz$/i || $value =~ m/\.gz$/i || $value =~ m/\.png$/i || $value =~ m/\.jpg$/i || $value =~ m/\.jpeg$/i || $value =~ m/\.gif$/i || $value =~ m/\.svg$/i || $value =~ m/\.ogg$/i || $value =~ m/\.ogv$/i) {
			if ($value =~ $contentROOT) {
				$noInternal = $contentROOT."NOGOODHERE/";
				$valueNew = $value;
				$valueNew =~ s/$contentROOT/$noInternal/gi;
				$html =~ s/$value/$valueNew/gi;
			}
		}
		##- we remove BAD CHARACTERS on the inDocument anchor points [only for anchors within this document we are presenting, anything else will be shown as normal]
		##- the need replacing these points is based on the fact the scrollTo script fails on these types of inDocument anchors, so be safe and overwrite
		##- periods replaced with - for consistency
		if ($value =~ '#' && $value =~ '\?'.$ENV{'QUERY_STRING'}.'#') {
			$oneBack="";##--$oneBack= add OneBack var
			($oneBack, $anchor) = split(/#/,$value);
			##-- example: h-4.1
			##-- these cause jQuery errors, so get rid of 'em
			##-- sometimes we catch non internal-anchors with pound (#) therefore we must check to make sure we haven't done such, if so nevermind it
			if ($anchor =~ m/[^0-9a-zA-Z-_]/ && ($anchor !~ '=' && $anchor !~ '&amp;')) {
				$NEWanchor = $anchor;
				$NEWanchor =~ s/\./-/gi;
				$NEWanchor =~ s/[^0-9a-zA-Z-_]//g; 
				$html =~ s/$anchor/$NEWanchor/gi;
			}
		}
    });

	##-- OLD WAY TO GET BODY SEEMS SLOWER
	##-- split text into DocumentArray by newline
	##-@elDocu = split(/\n/,$html);

	##-- get title [no longer needed but cool, so keep for later use] (now used to verify the existence of a title in the document, since some docs are missing head but have title, body and headContents)
	#$p = HTML::TokeParser->new( \$html );
	#if ($p->get_tag("title")) {
	#	$myTitle = $p->get_trimmed_text;
	#}

	##-- get title [no longer needed but cool, so keep for later use] (now used to verify the existence of a title in the document, since some docs are missing head but have title, body and headContents)	
	$myTitle = $elTitle;
	
	
	##-- REMOVED $myBody portion, not needed with wikipedia [if found to be needed, easily reimplemented using w3c]

	##-- any /wiki/?st= calls turned to local calls
	$linkEXT1 = $forcedPROTOCOL . '://'.$sourceDomain.'/wiki/\?st=';  
	$linkEXT1R = '?st=';
	$html =~ s/$linkEXT1/$linkEXT1R/gi;

	##-- anything flagged as NOGOODHERE is given back to wiki to process [target: VPS-NET-COM-WikiPeeks-Wikipedia]
	$linkEXT2 = '<a href="/wiki/NOGOODHERE/';  
	$linkEXT2x2 = '<a href="' . $forcedPROTOCOL . '://'.$sourceDomain.'/wiki/NOGOODHERE/';
	$linkEXT2R = '<a target="VPS-NET-COM-WikiPeeks-Wikipedia" href="' . $forcedPROTOCOL . '://'.$sourceDomain.'/wiki/';
	$html =~ s/$linkEXT2/$linkEXT2R/gi;
	$html =~ s/$linkEXT2x2/$linkEXT2R/gi;

	##-- forward all Portal: calls to Wikipedia
	$linkEXTX = '<a href="/wiki/Portal:';  
	$linkEXTXx2 = '<a href="' . $forcedPROTOCOL . '://'.$sourceDomain.'/wiki/Portal:';
	$linkEXTXR = '<a target="VPS-NET-COM-WikiPeeks-Wikipedia" href="' . $forcedPROTOCOL . '://'.$sourceDomain.'/wiki/Portal:';
	$html =~ s/$linkEXTX/$linkEXTXR/gi;
	$html =~ s/$linkEXTXx2/$linkEXTXR/gi;

	##-- any /wiki/Special:BookSources calls turned to local calls for our own book lookup/advertising system
	$linkEXT3 = '<a href="' . $forcedPROTOCOL . '://'.$sourceDomain.'/wiki/Special:BookSources/';
	$linkEXT3x2 = '<a href="/wiki/Special:BookSources/';
	##-- considering the href is already been used to bubblepopup, can be rewritten on the fly as we do with runBookReference for external linking to original wikipedia location
	$linkEXT3R = '<a target="Wiki-Peeks-Dontates-To-Its-Sources-Through-Advertisement-Revenue" id="" class="WikiPeeksReferences" onClick="runBookReference(this,\'' . $forcedPROTOCOL . '://'.$sourceDomain.'/wiki/Special:BookSources/\');" href="international-standard-book-number-lookup.htm?feed=WikiPeeksBookReference&ad=a&isbn=';
	$html =~ s/$linkEXT3/$linkEXT3R/gi;
	$html =~ s/$linkEXT3x2/$linkEXT3R/gi;
	
	##-- any root /wiki/ calls turned to local calls
	$linkEXT4 = '<a href="/wiki/';  
	$linkEXT4x2 = '<a href="' . $forcedPROTOCOL . '://'.$sourceDomain.'/wiki/';
	$linkEXT4R = '<a target="_self" href="?st=';
	$html =~ s/$linkEXT4/$linkEXT4R/gi;
	$html =~ s/$linkEXT4x2/$linkEXT4R/gi;

	##-- root domain calls turned to full outgoing calls [target: VPS-NET-COM-WikiPeeks-Wikipedia]
	$linkEXT5 = '<a href="/'; 
	$linkEXT5R = '<a target="VPS-NET-COM-WikiPeeks-Wikipedia" href="' . $forcedPROTOCOL . '://'.$sourceDomain.'/';
	$html =~ s/$linkEXT5/$linkEXT5R/gi;

	##-- anything not fished out till now [target: VPS-NET-COM-WikiPeeks-Wikipedia]
	$linkEXT6 = '<a href="' . $forcedPROTOCOL . '://';
	$linkEXT6R = '<a target="VPS-NET-COM-WikiPeeks-Outgoing" href="' . $forcedPROTOCOL . '://';
	$html =~ s/$linkEXT6/$linkEXT6R/gi;

	##-- anything that not local goes out [target: VPS-NET-COM-WikiPeeks-Wikipedia]
	$linkEXT7 = '<a rel="nofollow"';
	$linkEXT7R = '<a target="VPS-NET-COM-WikiPeeks-Outgoing" rel="nofollow"';
	$html =~ s/$linkEXT7/$linkEXT7R/gi;

	##-- imagemaps [target: VPS-NET-COM-WikiPeeks-Wikipedia]
	$linkEXT8 = 'coords=';
	$linkEXT8R = 'target="VPS-NET-COM-WikiPeeks-Outgoing" coords=';
	$html =~ s/$linkEXT8/$linkEXT8R/gi;

	$html =~ s/Sorry, your browser either has JavaScript disabled or does not have any supported player./Your browser has no supported audio player./gi;
	$html =~ s/ to play the clip in your browser./ to play audio./gi;
	$linkEXT2013x1 = '">download a player</a>';
	$linkEXT2013x1R = '">get a player</a>';
	$html =~ s/$linkEXT2013x1/$linkEXT2013x1R/gi;
	$linkEXT2013x2 = '">download the clip</a>';
	$linkEXT2013x2R = '">get the clip</a>';
	$html =~ s/$linkEXT2013x2/$linkEXT2013x2R/gi;
	
	##-- find inDocument anchor links, for onload javascript array [toc(table of contents) only]
	##-- we feed this into a page default js array as our WikiBoard History Selector base
	##-- if none no base
	##-- base + then anything added afterward, base always base

    use HTML::Obliterate qw(extirpate_html);
	$finalBody = $html;
	$finalBody =~ s/\n/ /gi;
	$finalBody =~ s/: /\: /gi;
	$finalBody =~ s/  / /gi;
	$finalBody =~ s/"//gi;

	##-- ready the TOC list for js input [our final toc list pre-processor]
	$myQS = '\?'.$ENV{'QUERY_STRING'}.'';
	#-$myQSA = $myQS.'\#';

	@elDocuFinal2 = split(m/(<a \b[^>].*?<\/a>)/,$finalBody);
	foreach $_ (@elDocuFinal2){
		if ($_ =~ /(<a \b[^>]*)/i && $_ =~ '#') {
			if (!$firstFind) { $firstFind = 'tocnumber'; }
			if ($_ =~ ' class=tocnumber') {
				$innerAnchor = "";
				$anchorText = "";
				
				##-- remove left and right prenthesis from in doc anchor points [otherwise no list will be generated]
				$_ =~ s/\(//g;
				$_ =~ s/\)//g;

				##-- affect all instances in line
				$ox = 0;
				$ox = m/(<a \b[^>]*>.*?<\/a>)/i;
				if ($ox == 1) {
					@elOXN = split(/\>/,$1);
					foreach $eeox (@elOXN) {
						$eeox =~ s/$myQS//gi;
						if ($eeox =~ / href=#/i) {
							@losEEOX= split(/=/,$eeox);
							foreach $leex (@losEEOX) {
								if ($leex =~ '#') {
									$innerAnchor = $leex;
									$twoBack="";
									($innerAnchor, $twoBack) = split(/ /,$leex);
									$innerAnchor =~ s/\#//gi;
									## print "$innerAnchor\n";
								}
							}
						}
						else {
							if ($anchorText ne "") {
								$anchorText = $anchorText . ">" . $eeox;
							}
							else {
								$anchorText = $eeox . ">";
							}
						}
					}
					if ($innerAnchor ne "" && $anchorText ne ""){
						my $cleanAnchorText = extirpate_html( $anchorText.">" );
						$cleanAnchorText =~ s/      / /gi; $cleanAnchorText =~ s/     / /gi; $cleanAnchorText =~ s/    / /gi; $cleanAnchorText =~ s/   / /gi; $cleanAnchorText =~ s/  / /gi;
						if (length($cleanAnchorText) > 100) {
							$cleanAnchorText = substr $cleanAnchorText, 0, 100;
							@myCAT = split(/ /,$cleanAnchorText);
							pop(@myCAT);
							$cleanAnchorText = join(' ',@myCAT) . '...';
						}
						utf8::encode($innerAnchor);
						utf8::encode($cleanAnchorText);
						push(@losInAnchors,$innerAnchor."%%%%%xxxxx%%%%%".$cleanAnchorText); 
						$innerAnchor = "";
						$anchorText = "";
					}
				}
			}
		}
	}



	##-- clean the title remove unicode non-breaking space
	$myTitle =~ s/\xa0/ /gi;
	$myTitle =~ s/&nbsp;//gi;
	##-- just in case
	$myTitle =~ s/\n//gi;


	$linkREV2 = "</a>WACHAPOPTHATLINK\n";
	$linkREV2R = "</a>";
	$html =~ s/$linkREV2/$linkREV2R/gi;

	##-- use body to test for most repeated words in document, for targted marketing
	$dontWantCommons = ' a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9 frame table draft content write writing description source resource page box circle mark format formatting new old work first second thrid fourth fifth sixth seventh eighth ninth tenth last call end group version review edition candidate about note draft see match than any more each one two value with should other may use type three four five six seven eight nine ten if all they on its model can by and that or given for a in space name value to an which must used when are as this be of will the is not it property section link request document form script media drafts tables ';
	###-- only first 100 lines meaning, which when full consist of 1024 characters each, hence 102400 char length
	if (length($html) >= 102401) { $testMyBody = substr $html, 0, 102400; }
	else { $testMyBody = $html; }
	$testMyBody = lc(extirpate_html( $testMyBody ));
	$testMyBody =~ s/,//gi;
	$testMyBody =~ s/'//g;
	$testMyBody =~ s/-//g;
	$testMyBody =~ s/"//gi;
	$testMyBody =~ s/\t//gi;
	$testMyBody =~ s/\n//gi;
	$testMyBody =~ s/\r//gi;
	##-- regex escapables
	$testMyBody =~ s/\?//gi;
	$testMyBody =~ s/\\//gi;
	$testMyBody =~ s/\}//gi;
	$testMyBody =~ s/\{//gi;
	$testMyBody =~ s/\)//gi;
	$testMyBody =~ s/\(//gi;
	$testMyBody =~ s/\|//gi;
	$testMyBody =~ s/\[//gi;
	$testMyBody =~ s/\]//gi;
	$testMyBody =~ s/\+//gi;
	$testMyBody =~ s/\*//gi;
	$testMyBody =~ s/\$//gi;
	$testMyBody =~ s/\^//gi;

	my $myCommonKeys = '';
	@mySPB = split(/ /,$testMyBody);
	my %hash = ();
	## the interesting bit ##
	map {$hash{$_}++} @mySPB;
	##-- if a keyword exists more than 35 times, must be hghly relevant
	for (keys %hash){ $myCommonKeys .= " $_ " if($hash{$_}>35) };
	##-- try again
	$myCommonKeys =~ s/  / /g;
	
	##--remove trailing and leading spaces
	$myCommonKeys =~ s/^\s*(\S*(?:\s+\S+)*)\s*$/$1/;

	my $myMostRelevantKeys = '';
	if ($myCommonKeys =~ " ") {
		@mck = split(/ /,$myCommonKeys);
		foreach $unmck (@mck) {
			utf8::encode($unmck);
			if ($dontWantCommons =~ m/$unmck/) {
				##-- use oppty to reset this var [overcome warning]
				$testMyBody = 1; 
			}
			else {
				if ($myTitle =~ m/$unmck/i) {
					if ($unmck =~ "css") { $unmck = "css"; }
					push(@finalImportantKeys,$unmck);
				}
			}
		}
		## is also in title
		if (@finalImportantKeys) {
			$myMostRelevantKeys = " " . join(' ',@finalImportantKeys) . " ";
		}
	}


	##-- if not replaced these bring up improper materials [sexual content]
	$myMostRelevantKeys =~ s/ dom / document object model /gi;

	##-- quick clean
	$myMostRelevantKeys =~ s/ css / cascading style sheets /gi;
	$myMostRelevantKeys =~ s/ html50 / html 5.0 /gi;
	$myMostRelevantKeys =~ s/ html40 / html 4.0 /gi;

	##--remove trailing and leading spaces
	$myMostRelevantKeys =~ s/^\s*(\S*(?:\s+\S+)*)\s*$/$1/;

	$countAnchors = int(@losInAnchors);
	



$myWikiPeeksWikipediaScript = '<script language="javascript" type="text/javascript" src="/interface_design_templater.php?q=1&p=WPWPHS"></script>';

print "Content-type: text/html\n\n";


### WARNING: EDGE(MSIE)  ###
#- HTML1524: Invalid HTML5 DOCTYPE. Consider using the interoperable form "!DOCTYPE html>". -#

print qq~
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" dir="ltr">
<head>
<title>$elTitle (Wikipedia)</title>
<meta http-equiv="X-UA-Compatible" content="IE = 8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
~;

$bp =~ s/'//g;
$bp =~ s/"//g;
$myTitle =~ s/"//g;
$myTitle =~ s/'//g;
$myTitle =~ s/\n//g;
$myTitle =~ s/\r//g;
$source =~ s/'//g;
$source =~ s/"//g;
$ms =~ s/'//g;
$ms =~ s/"//g;
$myMostRelevantKeys =~ s/'//g;
$myMostRelevantKeys =~ s/"//g;

# REMOVED FROM <!--GEOIPLOOKUP-->
# <script src="$forcedPROTOCOL://bits.wikimedia.org/geoiplookup"></script>
print qq~
<meta name="generator" content="MediaWiki 1.17wmf1" />
<link rel="alternate" type="application/x-wiki" title="Edit this page" href="$sourceURL/w/index.php?title=$myTitle&amp;action=edit" />
<link rel="edit" title="Edit this page" href="$sourceURL/w/index.php?title=$myTitle&amp;action=edit" />
<link rel="search" type="application/opensearchdescription+xml" href="$sourceURL/w/opensearch_desc.php" title="Wikipedia (en)" />
<link rel="EditURI" type="application/rsd+xml" href="$sourceURL/w/api.php?action=rsd" />
<link rel="copyright" href="$forcedPROTOCOL://creativecommons.org/licenses/by-sa/3.0/" />
<link rel="alternate" type="application/atom+xml" title="Wikipedia Atom feed" href="$sourceURL/w/index.php?title=Special:RecentChanges&amp;feed=atom" />
<meta name="ResourceLoaderDynamicStyles" content="" />
<style type="text/css">a:lang(ar),a:lang(kk-arab),a:lang(mzn),a:lang(ps),a:lang(ur){text-decoration:none}</style>
<!--GEOIPLOOKUP-->


<link rel="stylesheet" href="$sourceURL/w/load.php?debug=false&amp;lang=en&amp;modules=ext.cite.styles%7Cext.echo.badgeicons%7Cext.echo.styles.badge%7Cext.gadget.DRN-wizard%2CReferenceTooltips%2CWatchlistBase%2CWatchlistGreenIndicators%2Ccharinsert%2Cfeatured-articles-links%2CformWizard%2Cgeonotice%2CrefToolbar%2Cswitcher%2Cteahouse%7Cext.pygments%2CwikimediaBadges%7Cext.tmh.thumbnail.styles%7Cext.uls.nojs%7Cext.visualEditor.desktopArticleTarget.noscript%7Cmediawiki.legacy.commonPrint%2Cshared%7Cmediawiki.sectionAnchor%7Cmediawiki.skinning.interface%7Cskins.vector.styles%7Cwikibase.client.init&amp;only=styles&amp;skin=vector"/>
<meta name="ResourceLoaderDynamicStyles" content=""/>
<link rel="stylesheet" href="$sourceURL/w/load.php?debug=false&amp;lang=en&amp;modules=site.styles&amp;only=styles&amp;skin=vector"/>
<!--<script async="" src="$sourceURL/w/load.php?debug=false&amp;lang=en&amp;modules=startup&amp;only=scripts&amp;skin=vector"></script>-->
<meta name="generator" content="MediaWiki 1.28.0-wmf.14"/>
<meta name="referrer" content="origin-when-cross-origin"/>
<link rel="alternate" href="android-app://org.wikipedia/http/en.m.wikipedia.org/wiki/Facebook_Platform"/>
<link rel="alternate" type="application/x-wiki" title="Edit this page" href="$sourceURL/w/index.php?title=Facebook_Platform&amp;action=edit"/>
<link rel="edit" title="Edit this page" href="$sourceURL/w/index.php?title=Facebook_Platform&amp;action=edit"/>
<link rel="apple-touch-icon" href="$sourceURL/static/apple-touch/wikipedia.png"/>
<link rel="shortcut icon" href="$sourceURL/static/favicon/wikipedia.ico"/>
<link rel="canonical" href="$sourceURL/wiki/Facebook_Platform"/>
<link rel="dns-prefetch" href="//meta.wikimedia.org" />

<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-library-jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-yui-extension-container_core-min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-yui-extension_connection-min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-jquery-extension_scrollTo-min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-jquery-extension_localscroll.min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-jquery-extension_bubblepopup.v2.3.1.min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-jquery-extension_fancybox-1.3.1.pack.js"></script>
<script language="javascript" type="text/javascript" src="/interface_design_templater.php?q=1&p=CHS"></script>
<script language="javascript" type="text/javascript">
	var logo = '<span id="WikiPeeksLogo"><a target="Wikipedia" title="Wikipedia, The Free Encyclopedia" href="$elURL"><img height="28" title="Wikipedia, The Free Encyclopedia" src="$forcedPROTOCOL://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Wikipedia-logo-$langu.png/29px-Wikipedia-logo-$langu.png"></a><img height="22" width="15" title="Web Development Resources - Webmaster Tools" src="/web_design_imagery/spacer.gif"></span>';
	var QueryString = '$ENV{'QUERY_STRING'}';
	var bpath = '$bp';
	var myTitle='$myTitle';
	var source = '$source';
	var appLoc = '$appLoc';
	var titleLink = '<span style="position:relative;top:1px;left:0px;"><a href="javascript:addBookmark(\\''+appLoc+'?'+QueryString+'\\', \\'WikiPeeks ('+source+') '+myTitle+'\\');" onMouseOver="iHover(this.firstChild,1);" onMouseOut="iHover(this.firstChild,0);" title="Add to Favorites: ('+source+') '+myTitle+'"><img src="/web_design_imagery/WikiBarLink-off.gif" width="14" height="14" border="0" alt="Add to Favorites: ('+source+') '+myTitle+'" name="WikiBarLink" id="WikiBarLink"></a><span> &nbsp;</span>';
	if (myTitle == '') { titleLink = ''; }
	var loadImage = '<span style="position:relative;top:2px;left:0px;" title="Loading, please wait..."><img src="/web_design_imagery/loadCircle.gif" width="18" height="15" border="0" alt="Loading, please wait..."></span>';
	var countAnchors = parseFloat($countAnchors);
	var delimiter = ':: ';
	var topTitle = '$myTitle';
</script>
<script language="javascript" type="text/javascript" src="/interface_design_templater.php?q=1&p=AHS"></script>
<script language="javascript" type="text/javascript" src="/interface_design_templater.php?q=1&p=WPCHS"></script>
~;

##-- write out ogg player js for eligible dox
if ($html =~ m/wikimedia/i && $html =~ m/ogg/i) {
	#print qq~
	#<script src="$forcedPROTOCOL://bits.wikimedia.org/w/extensions-1.18/OggHandler/OggPlayer.js?12" type="text/javascript"></script>
	#<style type="text/css" media="all">
	#.ogg-player-options { border: solid 1px #ccc; padding: 2pt; text-align: left; font-size: 10pt; }
	#.center .ogg-player-options ul { margin: 0.3em 0px 0px 1.5em; }
	#</style>
	#~;
}

if (@losInAnchors > 0) {
	##-->> appendDefaultAnchors is now wiki_peeks_application_programming_api
	##-->> activeContent is now wIKi
	##-->> anchorHistory is now pEeKS
	##-->> historyContentObject is now apPlICAtIoN

	push(@todasLasPartes,'if(!wIKi["topmost"]){pEeKS.push("topmost");wIKi["topmost"]=apPlICAtIoN("topmost","");}');
	foreach $unAnch (@losInAnchors) {
		($id,$name) = split(/%%%%%xxxxx%%%%%/,$unAnch);
		##-- remove carriage returns or endline whitespace
		$name =~ s/\xa0/ /gi; $name =~ s/\r//gi; $name =~ s/\n//gi;
		$id =~ s/\xa0/ /gi; $id =~ s/\r//gi; $id =~ s/\n//gi;
		push(@todasLasPartes,'if(!wIKi["'.$id.'"]){pEeKS.push("'.$id.'");wIKi["'.$id.'"]=apPlICAtIoN("'.$id.'",": '.$name.'");}');
	}
	push(@todasLasPartes,'for(var i=0;i<pEeKS.length;i++){if (!(!newSelect)){newSelect.options[i]=new Option(wIKi[pEeKS[i]].text);newSelect.options[i].value=pEeKS[i];if(pEeKS[i]==selected){newSelect.options[i].selected=true;}}}');
}

print qq~
<script language="javascript" type="text/javascript">
var wiki_peeks_application_programming_api = function(selected) {@todasLasPartes};
</script> $myWikiPeeksWikipediaScript
~;

##-- inner FB is different from outer[original: WikiPeeksHeader]
$fbTheCSS = `cat javascript-jquery-extension_fancybox-1.3.1.css`;
$fbTheCSS =~s/fancybox-close/WikiPeeksHeader/gi;
$fbTheCSS =~s/topbar-right/WikiPeeksHeaderRight/gi;
print qq~
<link rel="stylesheet" type="text/css" href="/jquery.bubblepopup.v2.3.1.css">
<style type="text/css">
$fbTheCSS
</style>
<link rel="stylesheet" type="text/css" href="/interface_design_templater.php?q=1&p=AHCSS">
<link rel="stylesheet" type="text/css" href="/interface_design_templater.php?q=1&p=FBHCSS">
<link rel="stylesheet" type="text/css" href="/interface_design_templater.php?q=1&p=CHCSS">
<style type="text/css">
#WikiPeeksHeader {background-image: url('/web_design_imagery/WikiBoardTopBarBacker_span.png');background-repeat: repeat-x;background-position: 0px 0px;}
#WikiPeeksHeaderRight {background-image: url('/web_design_imagery/WikiBoardTopBarBacker_span.png');background-repeat: repeat-x;background-position: 0px 0px;}
#WikiBoardBarTitle{ padding-bottom:5px; }
#WikiBoardBarHistory{ padding-bottom:10px; }
#WikiPeeksLogo { position:relative;top:-3px; }
#WikiBoardBarAd { margin-bottom:2px;}
.WikiPeeksLibrary .WikiPeeksAdPreviewAuthor .sub, 
.WikiPeeksLibrary .WikiPeeksAdPreviewNotes .sub, 
.WikiPeeksLibrary .WikiPeeksAdPreviewPrice .sub, 
.WikiPeeksLibrary .WikiPeeksAdPreviewPublisher .sub { font-size:10px; color:#000000; }
.WikiPeeksLibrary .WikiPeeksAdPreviewPrice .price { color:#990000; padding-left:0px; }
.WikiPeeksLibrary .WikiPeeksAdPreviewPrice .advertiser { font-size:10px; }
.WikiPeeksLibrary .WikiPeeksAdPreviewNotes {  padding:5px 0px 0px 15px; }
.WikiPeeksLibrary .WikiPeeksAdPreviewNotes ul { padding:0px 0px 5px 5px; }
.WikiPeeksLibrary .WikiPeeksAdPreviewAuthor a { color:#266899; }
.WikiPeeksLibrary .WikiPeeksAdPreviewAuthor a:hover { color:#CC0000; }

.WikiPeeksLibrary .WikiPeeksAdWrap, .WikiPeeksLibrary .DonateNow { border:#F1F6F8 1px solid; }
.WikiPeeksLibrary .DonateNow a { color:#266899; }
.WikiPeeksLibrary .DonateNow a:hover { color:#CC0000; }
.WikiPeekLibrary { padding:5px 15px 15px 15px; }
.WikiPeekStore { padding:0px 15px; }
.WikiPeeksLibrary .CheckItOutLibraries { position:relative; top:0px; left:0px; cursor:pointer; }
.WikiPeeksLibrary .CheckItOutLibrary { display:none; position:relative; top:5px; left:-5px; list-style:none; }
.WikiPeeksLibrary .WorldCat { color:#266899; }
.WikiPeeksLibrary .WorldCat:hover { color:#CC0000; }
.WikiPeeksLibrary .CheckItOutLibrary a { color:#266899; text-decoration:none; }
.WikiPeeksLibrary .CheckItOutLibrary a:hover { color:#CC0000; }
.WikiPeeksLibrary .DonateNow { background-color: #FCFCFC; color: #000000; }
.WikiPeeksLibrary a img.WikiPeeksAdPreviewImage { border:#D5E1EA 1px solid; max-width:250px; overflow:hidden; }

.WikiPeeksLibrary .WikiPeeksActions { position:absolute; top:21px; right:90px; height:19px; }
.WikiPeeksLibrary .WikiPeeksActions .WikiActs { cursor:pointer; background-image:url('/web_design_imagery/WikiPeeks/actions_off_left.png'); background-repeat:no-repeat; background-position:0 0; padding-top:3px; padding-bottom:3px; }
.WikiPeeksLibrary .WikiPeeksActions .WikiActs .WikiAct {  background-image:url('/web_design_imagery/WikiPeeks/actions_off_right.png'); background-repeat:no-repeat; background-position:top right; padding-top:3px; padding-bottom:3px; }
.WikiPeeksLibrary .WikiPeeksActions .WikiActs .WikiAct span { background-image:url('/web_design_imagery/WikiPeeks/actions_off_center.png'); background-repeat:repeat-x; background-position:0 0; padding:3px; padding-left:6px; padding-right:3px; margin-left:8px; margin-right:8px; }
.WikiPeeksLibrary .WikiPeeksActions .WikiActs:hover { cursor:pointer; background-image:url('/web_design_imagery/WikiPeeks/actions_over_left.png'); }
.WikiPeeksLibrary .WikiPeeksActions .WikiActs:hover .WikiAct {  background-image:url('/web_design_imagery/WikiPeeks/actions_over_right.png'); }
.WikiPeeksLibrary .WikiPeeksActions .WikiActs:hover .WikiAct span { background-image:url('/web_design_imagery/WikiPeeks/actions_over_center.png'); }
.WikiPeeksLibrary .WikiPeeksActions .WikiActs:hover a { text-decoration:none; color:#CC0000; }
.WikiPeeksLibrary .WikiPeeksActions .WikiActs .WikiAct span a { position:relative; top:-1px; }

.WikiPeeksLibrary .WikiPeeksStorePrice .price { color:#990000; padding-left:0px; }
.WikiPeeksLibrary .WikiPeeksStorePrice .advertiser { font-size:10px; }
.WikiPeeksLibrary .WikiPeeksStoreActions { height:20px; font-size:11px; text-decoration:none; position:relative; top:5px; left:5px; }
.WikiPeeksLibrary .WikiPeeksStoreActions .WikiStoreActs { cursor:pointer;  }
.WikiPeeksLibrary .WikiPeeksStoreActions .WikiStoreActs:hover a { color:#CC0000; }
.WikiPeeksLibrary .WikiPeeksStoreActions .WikiStoreActs a { color:#000000; }
.WikiPeeksLibrary .WikiPeeksStoreActions .selected a { color:#990000; }
.WikiPeeksLibrary .WikiPeeksStoreActions .WikiStoreActs .WikiStoreAct span a { position:relative; top:-1px; }

.mediaContainer, .mediaContainer audio , .mediaContainer source { font-size:9px;font-family:arial narrow,arial; max-width:200px; height:auto; }
</style>
</head>
<body style="margin:0;padding-left:0;padding-right:0px;background-color:#FFFFFF;background:#FFFFFF;" onbeforeunload="doUnload();">
<a name="topmost" id="topmost"></a>
<!--<body style="margin:0;padding:30px;background:#F7F7F7;">-->
<!--<div style="padding-bottom:20px;position:absolute;left:0px;top:0px;">$bp</div>-->
<!--<div style="background:#FFFFFF;border-top:#ABADB3 1px solid; border-left:#E2E3EA 1px solid; border-right:#E2E3EA 1px solid; border-bottom:#E3E9EF 1px solid;">-->
<div id="WikiWrap">
~;
##-- PREVIOUS LINE WAS JUST <div> BUT CHANGED TO CURRENT LAYOUT TO HELP IOS WITH SCROLLING ISSUES


##-- print out the top and bottom wikipeeks bars
print qq~
<div id="WikiPeeksHeader" style="z-index:10000;visibility:hidden; display:none; padding-left: 1px; padding-right: 1px; top: 0px; left:0px; height: 29px; overflow-x: hidden; overflow-y: hidden; position:fixed; width:100%;">
	<div id="WikiPeeksHeaderRight">
		<div id="topbar-center">
			<table width="100%" height="29" cellpadding="0" cellspacing="0">
				<tbody>
					<tr valign="bottom">
						<td align="left" width="80%" style="padding-left:7px;padding-bottom:6px;" nowrap="1"><div id="Wiki-Peeks-Document-Header"><span id="Document-Title">Wiki Peeks</span><span id="Wiki-Peeks-Content-Source"></span><span id="Wiki-Peeks-Content-Search"><!--<a href="javascript:fancyLoad('/w3c.htm?st=/TR/');" title="Search the W3C Standards and Drafts">search</a>--></span></div></td>
						<td align="right" width="20%" style="padding-bottom:7px;padding-right:5px;"><!--<a href="javascript:;" class="WikiPeeksClose">close &nbsp;X</a>--></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div id="WikiPeeksFooter" style="z-index:10000;visibility:hidden; display:none; padding-left: 1px; padding-right: 1px; bottom: 0px; left:0px; height: 56px; overflow-x: hidden; overflow-y: hidden; position:fixed; width:100%;">
	<div id="WikiPeeksSlider" style="left: 0px; background-image: url($forcedPROTOCOL://myvirtualprivate.com/web_design_imagery/information-technology-tools-footer-background-bottom.png); background-attachment: initial; background-origin: initial; background-clip: initial; background-color: initial; position: relative; top: 0px; height: 56px; overflow-x: hidden; overflow-y: hidden; display: block; background-position: 0px -2px; background-repeat: repeat no-repeat; ">
		<div style="padding-top:2px;">
			<table width="100%" cellpadding="0" cellspacing="0" style="height:56px;">
				<tbody>
					<tr valign="bottom">
						<td align="left" nowrap="1"><div id="WikiBoardBarTitle"></div></td>
						<td align="left" nowrap="1"><div id="WikiBoardBarHistory"></div></td>
						<td width="100%" nowrap="1"><div id="WikiBoardBarSpacer"></div></td>
						<td align="right" nowrap="1">
							<div id="WikiBoardBarAd">
								<div id="WikiBoardBarAdDisplay"></div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
~;

print qq~
<div style="text-align:left;padding:50px;">
~;

## some length padding 200 must be made for basic result information [example of basic output shown above]
if (length($html) > (length($ms) + 200)) { print "<h1 id=\"firstHeading\" class=\"firstHeading\">$elTitle</h1>"; }
else { print "<h1 id=\"firstHeading\" class=\"firstHeading\">No results for: <em>$ms</em></h1>"; }

##-- WAS
##-$html =~ s/[^[:ascii:]]+//g;
#print qq~ $html ~;

##-- IS
##-- kill wide character in print issue due to utf8 encoding
my $ustring1 = $html;
binmode DATA, ":utf8";
my $ustring2 = <DATA>;
binmode STDOUT, ":utf8";
print "$ustring1$ustring2";

print '<div style="padding:15px;"><table width="100%" cellpadding="0" cellspacing="0" style="background:#FFFFFF;"><tr><td width="50%"></td><td align="right"><a href="' . $forcedPROTOCOL . '://www.mediawiki.org/"><img src="' . $forcedPROTOCOL . '://upload.wikimedia.org/wikipedia/commons/d/d4/Poweredby_mediawiki_88x31.png" height="31" width="88" alt="Powered by MediaWiki" /></a> &nbsp; <a target="VPS-NET-COM-WikiPeeks-Wikimedia" href="' . $forcedPROTOCOL . '://wikimediafoundation.org/"><img src="//'.$sourceDomain.'/images/wikimedia-button.png" width="88" height="31" alt="Wikimedia Foundation"/></a></td></tr></table></div>';
print '</div></div>';

$cleanSearchString =~ s/'//g;

##-- we want targetted results for these, therefore we will force them
if (lc($cleanSearchString) =~ "guru") {
	$myMostRelevantKeys = 'Internet Guru';
	$cleanSearchString = 'Technology Guru';
}

##-- ccTLD calls hence .com .net etc
$checkForStartingPeriod = substr $cleanSearchString, 1;
if ($checkForStartingPeriod == '.' && (length($cleanSearchString) == 3 || length($cleanSearchString) == 4 || length($cleanSearchString) == 5)) {
	$myMostRelevantKeys = 'ccTLD';
}

print qq~
<script language="javascript" type="text/javascript">
var mostRelevantKeys = '$myMostRelevantKeys';
var msour = '$cleanSearchString';
</script>
<script language="javascript" type="text/javascript" src="/interface_design_templater.php?q=1&p=WPCFS"></script>
<script language="javascript" type="text/javascript">
if (!(!parent.document.getElementById("WikiBoardBarTitle"))) {
	if (!(!mwbt) && (mwbt!=0)) {
		wbct.innerHTML = '<a href="javascript:fancyLoad(\\'/wikipedia.htm?st=Main_Page\\');" title="Wikipedia, The Free Encyclopedia is written collaboratively by largely anonymous Internet volunteers who write without pay. Anyone with Internet access can write and make changes to Wikipedia articles. Users can contribute anonymously, under a pseudonym, or with their real identity, if they choose.">Wikipedia, The Free Encyclopedia</a>';
		wbcs.innerHTML = '<!--<a href="javascript:fancyLoad(\\'/wikipedia.htm?st=Main_Page\\');" title="Search Wikipedia, The Free Encyclopedia">search</a>-->';
		parent.wikiResource = 'Wikipedia, The Free Encyclopedia';
	}
	
}
</script>
</body>
</html>
~;

exit;