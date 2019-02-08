#!/usr/bin/perl -w

##################################################################
#   Program:        Wikipeeks for W3C TR Data                    #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2009 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:      ISBN                                         #
#        Source:    ISBNDB                                       #
#        Example:   Biblio, eBooks, Libraries (WorldCat), Amazon #
#        Type:      Technical Documents                          #
#           Sub-type:   Standards and Drafs                      #
#        Source:    World Wide Web Consortirum (w3c.org)         #
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

use LWP::Simple;
use CGI;
use CGI::Carp qw(fatalsToBrowser);
use HTML::SimpleLinkExtor;
use HTML::TokeParser;
use HTML::ResolveLink;

#-- just do it this way to defeat warning of used once
if (!$NOSPAM) { $NOSPAM = 1; }
require($HTTPRoot."q.nsp");
$ms = $FORM{'st'};print "Content-type: text/html\n\n";

$mua = $ENV{'SCRIPT_NAME'};
$host = $ENV{'HTTP_HOST'};
$appLoc = 'http://' . $host . '' . $mua;
$source = 'W3C';
#- $sourceFull = 'World Wide Web Consortium';
$sourceDomain = 'www.w3.org';

$elURL = 'http://'.$sourceDomain.'/';
$contentROOT = 'http://'.$sourceDomain.'/TR/';
$contentROOTDoubleSlash = 'http://'.$sourceDomain.'//TR/';
$forsl = '/';
if (!$FORM{'st'}) { $ms = 'TR/xhtml1/'; }
else {
	$ms =~ s/%2F/$forsl/gi;
	$ms =~ s/%3A/:/gi;
}

	##-- get base href [document path]
	my $bp;
	if ($ms =~ $forsl) {
		my $rear = substr $ms, -1;
		@myPath = split(/\//,$ms);
		#-- if last character is a forwardslash
		if ($rear eq $forsl) { $bp = $elURL.join($forsl,@myPath).$forsl; }
		#-- everything else [remove last piece of URL which would be a FILE or QUERY STRING, unless is NAMED DIRECTORY]
		else {
			@myCUTPath = @myPath;
			my $myDestinationFile = pop(@myCUTPath);
			##-- if NAMED DIRECTORY :: these need to be escaped for a prematch \ . ^ $ * + ? { } [ ] ( ) |
			if (($myDestinationFile !~ m/\./i) && ($myDestinationFile !~ m/=/i) && ($myDestinationFile !~ m/\?/i)) {
				$bp = $elURL.join($forsl,@myPath);
			}
			##-- everything else [FILE or QUERY STRING]
			else {
				$bp = $elURL.join($forsl,@myCUTPath);
			}
		}
	}
	else { $bp = $elURL; }
	## if base path doesn't have a trailing forward slash we need to add it
	if ((substr $bp, -1) ne $forsl) { $bp .= $forsl; }

	@myTruePath = split(/\//,$bp);
	pop(@myTruePath);
	$oneBack = join($forsl,@myTruePath);
	pop(@myTruePath);
	$twoBack = join($forsl,@myTruePath);

	$oneBackLoco = $oneBack;
	$oneBackLoco =~ s/$elURL//gi;
	$twoBackLoco = $twoBack;
	$twoBackLoco =~ s/$elURL//gi;

	##-- get the document
	if ($ms =~ "http:") { 
		$text = get($ms); 
		$docloc = $ms;
	}
	else { 
		$text = get("$elURL".$ms); 
		$docloc = "$elURL".$ms;
	}
	
	$html = $text;
	##-- setup the document for our parser
	##-- make sure HEAD BODY open & close ARE ON OWN LINE [splitting using newline]
	##-- do the same to P to cut off the logo from top
	$html =~ s/<head>/\n<head>\n/gi;
	$html =~ s/<\/head>/\n<\/head>\n/gi;
	$html =~ s/<body>/\n<body>\n/gi;
	$html =~ s/<\/body>/\n<\/body>\n/gi;
	$html =~ s/<p>/\n<\!--changed--><p>/gi;
	$html =~ s/<\/p>/<\/p><\!--changed-->\n/gi;
	$html =~ s/<div class=\"head\">/<div class=\"head\">\n/gi;
	
	##-- ONLY DOUBLE PREN NEEDS BE REMOVED, ONLY THIS CAUSES o jQuery error
	##-- remove left and right prenthesis [only matching need be removed]
	$mypren = '&#40;&#41;';
	$html =~ s/\(\)//g;

	#-- clean links [make them absolute based on remote path]
  	my $count;
  	my $resolver = HTML::ResolveLink->new(
   	  	base => $bp,
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
		#-if ($value =~ '\.gzip' || $value =~ '\.doc' || $value =~ '\.xls' || $value =~ '\.ent' || $value =~ '\.mp3' || $value =~ '\.avi' || $value =~ '\.mpg' || $value =~ '\.mpeg' || $value =~ '\.au' || $value =~ '\.mov' || $value =~ '\.dtd' || $value =~ '\.xml' || $value =~ '\.xsl' || $value =~ '\.zip' || $value =~ '\.ps' || $value =~ '\.pdf' || $value =~ '\.tar' || $value =~ '\.tgz' || $value =~ '\.gz') {
		if ($value =~ m/\.gzip$/i || $value =~ m/\.doc$/i || $value =~ m/\.xls$/i || $value =~ m/\.ent$/i || $value =~ m/\.mp3$/i || $value =~ m/\.avi$/i || $value =~ m/\.mpg$/i || $value =~ m/\.mpeg$/i || $value =~ m/\.au$/i || $value =~ m/\.mov$/i || $value =~ m/\.dtd$/i || $value =~ m/\.xml$/i || $value =~ m/\.xsl$/i || $value =~ m/\.zip$/i || $value =~ m/\.ps$/i || $value =~ m/\.pdf$/i || $value =~ m/\.tar$/i || $value =~ m/\.tgz$/i || $value =~ m/\.gz$/i) {
			if ($value =~ $contentROOT) {
				$noInternal = $contentROOT."NOGOODHERE/";
				$valueNew = $value;
				$valueNew =~ s/$contentROOT/$noInternal/gi;
				$html =~ s/$value/$valueNew/gi;
			}
		}
		##- we are BAD CHARACTERS on the inDocument anchor points [only for anchors within this document we are presenting, anything else will be shown as normal]
		##- the need replacing these points is based on the fact the scrollTo script fails on these types of inDocument anchors, so be safe and overwrite
		##- periods replaced with - for consistency
		if ($value =~ '#' && $value =~ '\?'.$ENV{'QUERY_STRING'}.'#') {
			##--$oneBack= take oppty to clear this now [overcome warning]
			($oneBack, $anchor) = split(/#/,$value);
			##-- example: h-4.1
			##-- these cause jQuery errors, so get rid of 'em
			##-WAS JUST 
			##-if ($anchor =~ '\.') {
			##-WAS 2
			##-if ($anchor =~ '\.' || $anchor =~ ':') {$NEWanchor = $anchor;$NEWanchor =~ s/\./-/gi;$html =~ s/$anchor/$NEWanchor/gi;}
			##-NOW IS [remove all naughties]
			if ($anchor =~ m/[^0-9a-zA-Z-_]/) {
				$NEWanchor = $anchor;
				$NEWanchor =~ s/\./-/gi;
				$NEWanchor =~ s/[^0-9a-zA-Z-_]//g; 
				$html =~ s/$anchor/$NEWanchor/gi;
			}
		}
    });

	##-- split text into DocumentArray by newline
	@elDocu = split(/\n/,$html);




	##-- get head contents
	my $myHead;
	foreach $_ (@elDocu){
		#-- some documents missing head closer [so cut it at body opener]
    	if(/<HEAD>/i .. /<BODY/i ) {
        	if ($_ ne '<head>' && $_ ne '</head>' && $_ !~ '<body') {
				$myHead .= $_ . "\n";
			}
    	}
	}

	##-- get title [no longer needed but cool, so keep for later use] (now used to verify the existence of a title in the document, since some docs are missing head but have title, body and headContents)
	$p = HTML::TokeParser->new( \$html );
	if ($p->get_tag("title")) {
		$myTitle = $p->get_trimmed_text;
	}
	

	##-- get body contents
	my $myBody;
	foreach $_ (@elDocu){
    	if(/<BODY/i .. /<\/BODY>/i ) {
        	if ($_ !~ '<body' && $_ ne '</body>' && $_ ne '</body>') {
					##-- if inDocument ANCHOR :: these need to be escaped for a prematch \ . ^ $ * + ? { } [ ] ( ) |
					##-- EXAMPLES: <a name="anchorname" OR <a target="target" name="anchorname"
					# if ($_ =~ /(<a \b[^>]*>.*?<\/a>)/i && $_ =~ /( name=)/i) {
					# 	$_ =~ s/(<a \b[^>]*>.*?<\/a>)/<span class="anchor-spacer">$1<\/span>/gi;
					# }
					##-- adding an id= to mirror the name=
					##-- if is an <a ANCHOR inDoc anchor point, with its name= one the same line
					##-- might be more than one <a ANCHOR so make sure to affect all name= anchors
					
					##--- updated 112011 [remove all bad characters - and overcome string processing errors prev-versions' line 196 using doc: TR/CSS21/indexlist.html]
					##-- KILL BAD ACTORS IN-DOC ANCHORS [this doc only]
					##-- checks are now case-insensitive
					if ($_ =~ /(<a)/i && $_ =~ /( name=)/i) {
						##-- must assign an ID to anchors without, scrollTo
						@myLineAnch = split(/<a/,$_);
						foreach $MLA (@myLineAnch) {
							if ($MLA =~ /(name=)/i && $MLA !~ /(id=)/i) {
								@myanch = split(/ /,$MLA);
								$newA = '';
								foreach $ma(@myanch) {
									if ($ma =~ /(name=)/i) {
										$newA = 1;
										$elNom = $ma;
										my ($fi,$sec,$thir) = split(/"/,$elNom);

										##-- if naughty characters, kill em off, replace name with clean 
										##-- we allow : and . for appearance, wheras everything else is functional
										##-- in previous process we remove . and : from the actual javascripting portion
										if ($sec =~ m/[^0-9a-zA-Z-_:\.]/) { $_ = $_; $newA = 0; }
										else { 
											$suNAME = 'name="'.$sec.'"';
											$newID = 'id="'.$sec.'"';
										}
									}
								}
								if ($newA == 1 && $suNAME && $newID) { 
									$_ =~ s/$suNAME/$suNAME $newID/gi;
								}
							}
						}
					}

					$myBody .= "\n" . $_;
			}
    	}
	}




	##-- didnt find head at first pass, head tag missing, but we found $myBody [will test for title]
	if (!$myHead && $myBody && (length($myBody) > 0)) {


		##-- we found $myTitle 
		if (length($myTitle) > 0) {
			##-- only if we have a well formed title and existence of body open tag
			if ($html =~ '<title' && $html =~ '</title' && $html =~ '<body') {
				$html =~ s/<title>/\n<head>\n<title>/gi;
				$html =~ s/<body/\n<\/head>\n<body/gi;

				##-- try for head again
				@elDocu2 = split(/\n/,$html);
				foreach $_ (@elDocu2){
	    			if(/<HEAD>/i .. /<\/HEAD>/i ) {
        				if ($_ ne '<head>' && $_ ne '</head>') {
							$myHead .= $_ . "\n";
						}
    				}
				}
			}
		}
	}
	
	##-- didnt find head at 2nd pass and/or empty title and/or empty body
	if ($myHead && $myBody && (length($myHead) <= 0 || length($myBody) <= 0 || length($myTitle) <= 0)) {
		$myTitle = 'Redirecting to $source: $docloc';
		$myHead = '<meta http-equiv="Refresh" content="URL=$docloc" \>';
		$myBody = 'There was an error parsing this document, we are now forwarding you to its location at '.$sourceDomain;
		exit;
	}
	
	## DO IT ourselves (maybe when we upgrade back to a faster server package we can run these quickly)
	##- ONCE WE TAG it with our TARGET=, we've altered the link from its original format and will not alter it furthermore [finalized link]


	##-- clean up our changes to the original markup
	$myBody =~ s/\n<\!--changed--><p>/<p>/gi;
	$myBody =~ s/<\/p><\!--changed-->\n/<\/p>/gi;


	##-- inDocument ANCHORS will be resolving back to current URL/PAGE [won't request new doc from our server, simple jump down/up]
	$linkEXT1 = ' href="'.$bp.'#';
	$linkEXT1R = ' target="_self" href="#';
	$myBody =~ s/$linkEXT1/$linkEXT1R/gi;


	##-- Root /TR/
	$linkEXT2 = ' href="'.$contentROOT.'"';
	$linkEXT2R = ' href="'.$contentROOT.'"';
	$myBody =~ s/$linkEXT2/$linkEXT2R/gi;


	##-- /TR/[1998|WAI|DTD] urls and [NOGOODHERE] our own flags
	$linkEXT3x1 = '<a href="'.$contentROOT.'NOGOODHERE/';
	$linkEXT3Rx1 = '<a target="World-Wide-Web-Consortium" href="'.$contentROOT;
	$linkEXT3x3 = '<a href="'.$contentROOT.'1998';
	$linkEXT3Rx3 = '<a target="World-Wide-Web-Consortium" href="'.$contentROOT.'1998';

	#--want
	$linkEXT3x2x1 = '<a href="'.$contentROOT.'WAI-AUTOOLS/';
	$linkEXT3Rx2x1 = '<a target="_self" href="?st=TR/WAI-AUTOOLS/';
	#--not want
	$linkEXT3x2x2 = '<a href="'.$contentROOT.'WAI';
	$linkEXT3Rx2x2 = '<a target="World-Wide-Web-Consortium" href="'.$contentROOT.'WAI';

	##-working drafts
	$linkEXT3x4 = '<a href="'.$contentROOT.'WD';
	$linkEXT3Rx4 = '<a target="World-Wide-Web-Consortium" href="'.$contentROOT.'WD';

	##-notes
	$linkEXT3x5 = '<a href="'.$contentROOT.'NOTE';
	$linkEXT3Rx5 = '<a target="World-Wide-Web-Consortium" href="'.$contentROOT.'NOTE';
	$myBody =~ s/$linkEXT3x1/$linkEXT3Rx1/gi;
	$myBody =~ s/$linkEXT3x2x1/$linkEXT3Rx2x1/gi;
	$myBody =~ s/$linkEXT3x2x2/$linkEXT3Rx2x2/gi;
	$myBody =~ s/$linkEXT3x3/$linkEXT3Rx3/gi;
	$myBody =~ s/$linkEXT3x4/$linkEXT3Rx4/gi;
	$myBody =~ s/$linkEXT3x5/$linkEXT3Rx5/gi;
	
	##-- if $myBody still contains NOGOODHERE beyond this point [catch it]


	##-- all other /TR/ urls
	$linkEXT3 = '<a href="'.$contentROOT;
	$linkEXT3x2 = '<a href="'.$contentROOTDoubleSlash;
	$linkEXT3R = '<a target="_self" href="?st=TR/';
	$myBody =~ s/$linkEXT3/$linkEXT3R/gi;
	$myBody =~ s/$linkEXT3x2/$linkEXT3R/gi;


	##-- all other /TR/ class=normative|rel=dc:replaces|class=tocxref|class=noxref
	@elDocuLast = split(/\n/,$myBody);
	$linkEXT4x1 = ' href="'.$contentROOT;
	$linkEXT4Rx1 = ' href="?st=TR/';
	$target = 'target="_self"';
	foreach $myLINE (@elDocuLast){
		if ($myLINE =~ /(<a \b[^>]*)/i && $myLINE =~ ' href="'.$contentROOT.'') {
			if ($myLINE !~ ' target="_self"' && $myLINE !~ ' target="World-Wide-Web-Consortium"') {
				##-- affect all instances in line
				@myLineAnch2 = split(/<a/,$myLINE);
				foreach $_ (@myLineAnch2) {
					$ox = 0;
					$_ = '<a'.$_;
					$ox = m/(<a \b[^>]*)/i;
					if ($ox == 1) {
						$oxNo = $1;
						$oxN = $oxNo;
						if ($oxNo =~ $linkEXT4x1) {
							$oxN =~ s/$linkEXT4x1/$linkEXT4Rx1/gi;
							$myBody =~ s/$oxNo/$oxN $target/gi;
						}
					}
				}
			}
		}
	}

	
	###--NEW 2013 -- REMOVE MAST/HEADER AGAIN (w3c must have upped it)
	##-- REMOVE
	##-- BEGIN: <div id="w3c_mast">
	##-- END: w3c_mast -->
	$myBody =~ s/(<div[^>]+?id="w3c_mast"[^>]*>.*?w3c_mast -->)//gsmi;
	$myBody =~ s/(<div[^>]+?id="w3c_logo_shadow"[^>]*>.*?<\/div>)//gsmi;
	$myBody =~ s/(<div[^>]+?class="w3c_leftCol"[^>]*>.*?<\/div>)//gsmi;
	
	##--WORK ON THIS (to allow main form based navigation from MAIN /TR/ page)
	##--$myBody =~ s/http:\/\/www.w3.org\/TR\/view/\/w3c.htm?st=\/TR\//gsmi;
	##--FOR NOW REMOVE THE FORM
	$myBody =~ s/(<form[^>]+?id="w3c_toggle_include"[^>]*>.*?<\/form>)//gsmi;

	###--NEW 2013 -- REMOVE FOOTER SCRIPTS, FOR IT KILLS OURS
	##-- REMOVE 
	##-- BEGIN: <div id="w3c_scripts">
	##-- END: </script></div>
	$myBody =~ s/(<div[^>]+?id="w3c_scripts"[^>]*>.*?<\/script><\/div>)//gsmi;


	##-- some of these eluded us in the previous process, kill em now!
	$linkEXT4x4 = '<a class="noxref" href="'.$contentROOT;
	$linkEXT4Rx4 = '<a class="noxref" href="?st=TR/';
	$myBody =~ s/$linkEXT4x4/$linkEXT4Rx4/gi;

	##-- RootURL
	$linkEXT2 = '<a href="';
	$linkEXT2R = '<a target="World-Wide-Web-Consortium" href="';
	$myBody =~ s/$linkEXT2/$linkEXT2R/gi;

	##-- clean up our markup changes
	$linkNG = 'NOGOODHERE/';
	$myBody =~ s/$linkNG//gi;


















	##-- find inDocument anchor links, for onload javascript array [toc(table of contents) only]
	##-- we feed this into a page default js array as our WikiBoard History Selector base
	##-- if none no base
	##-- base + then anything added afterward, base always base

    use HTML::Obliterate qw(extirpate_html);
	$finalBody = $myBody;
	$finalBody =~ s/\n/ /gi;
	$finalBody =~ s/: /\: /gi;
	$finalBody =~ s/  / /gi;
	$finalBody =~ s/"//gi;
	$repTOC1 = '<a ';
	$repTOC2 = '<a class=tocxie ';

	##-- ready the TOC list for js input [our final toc list pre-processor]
	$myQS = '\?'.$ENV{'QUERY_STRING'}.'';
	$myQSA = $myQS.'\#';


	@elDocuFinal = split(m/(<a \b[^>].*?<\/a>)/,$finalBody);
	@elDocuFinalLIST = split(m/(<div\b[^>]*>.*?<\/div>)/,$finalBody);
	@elDocuFinalLIST2 = split(m/(<p\b[^>]*>.*?<\/p>)/,$finalBody);
	##-- make it to where anchors within the UL class=TOC are tocx for next process
	##-- some items within the TOC, table-of-contents, are not flagged as such, find 'em and flag em for nxt proc
	if ($finalBody !~ 'class=tocxref' && $finalBody !~ 'class=noxref') {
		##-- first try UL toc, most used in documents
		if ($finalBody =~ '<ul class=toc') {
			foreach $_ (@elDocuFinal){
    			if(/<ul class=toc/i .. /<\/ul>/i ) {
					if ($_ !~ '<ul' && $_ !~ '</ul>') {
						if ($_ =~ / href=#/i || $_ =~ $myQS) {
							$_ =~ s/$repTOC1/$repTOC2/gi;
						}
					}
					push(@elDocuFinal2,$_);
				}
			}
		}
		##-- second try P class=toc, 2nd most used in documents
		if (!@elDocuFinal2 && $finalBody =~ '<p class=toc') {
			foreach $_ (@elDocuFinal){
    			if(/<p class=toc/i .. /<\/p>/i) {
					if ($_ !~ '<p' && $_ !~ '</p>') {
						if ($_ =~ / href=#/i || $_ =~ $myQS) {
							$_ =~ s/$repTOC1/$repTOC2/gi;
						}
					}
					push(@elDocuFinal2,$_);
				}
			}
		}

		##-- third try by OL list only if table of contents exists in this div section
		if (!@elDocuFinal2 && ($finalBody =~ 'Table of Contents' || $finalBody =~ 'minitoc')) {
			foreach $myLIST (@elDocuFinalLIST){
    			if($myLIST =~ 'Table of Contents') { 
					@misTOC = split(m/(<a \b[^>].*?<\/a>)/,$myLIST);
					## print "$myLIST\n\n\n\n";
				}
			}
			if (!@misTOC) {
				foreach $myLIST (@elDocuFinalLIST2){
    				if($myLIST =~ 'minitoc' && $myLIST =~ $myQSA) {
						@misTOC2 = split(m/(<a \b[^>].*?<\/a>)/,$myLIST);
						## print "$myLIST\n\n\n\n";
					}
				}
			}
			if (@misTOC || @misTOC2) {
				foreach $_ (@misTOC) {
    				if(/<ol/i .. /<\/ol>/i) {
						if ($_ !~ '<ol' && $_ !~ '</ol>') {
							if ($_ =~ / href=#/i || $_ =~ $myQSA) {
								## print "$_\n";
								$_ =~ s/$repTOC1/$repTOC2/gi;
							}
						}
						push(@elDocuFinal2,$_);
					}
				}
				if (!@elDocuFinal2) {
					foreach $_ (@misTOC2) {
						if ($_ =~ / href=#/i || $_ =~ $myQSA) {
							## print "$_\n";
							$_ =~ s/$repTOC1/$repTOC2/gi;
						}
						push(@elDocuFinal2,$_);
					}
				}
			}

		}
	}
	##-- menu items are already pre-flagged for us by 'class=tocxref' 'class=noxref'
	else {
		@elDocuFinal2 = @elDocuFinal;
	}

	foreach $_ (@elDocuFinal2){
		if ($_ =~ /(<a \b[^>]*)/i && $_ =~ '#') {
			if (!$firstFind) { $firstFind = 'tocxref'; }
			if (($_ =~ ' class=tocxref' || ($firstFind ne "tocxref" && $_ =~ ' class=noxref') || $_ =~ ' class=tocxie') && $_ =~ ' target=_self' && $_ !~ ' target=World-Wide-Web-Consortium') {
				$innerAnchor = "";
				$anchorText = "";

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
									##--$twoBack= take oppty to clear this now [overcome warning]
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
	
	## for redirects we will simply re-search without our playground [original WikiPedia ONLY]
	## [[if we are being given a redirect, some other alternative feeds might come through this channel but at this time we only know of redirects so act on the first avail.]]



	###-- 2017
	##-- HTTP vs HTTPS fix
	
	$httpEX = 'http:'.$forsl.''.$forsl;
	$doubleForsl = $forsl . '' . $forsl;

	$myHead =~ s/$httpEX/$doubleForsl/gi;
	$myBody =~ s/$httpEX/$doubleForsl/gi;

	
	
	
###-- 2013
$indexDocTypeCSS = '';
$titlePosition = 'top:1px;left:0px;';
##-- dont run keyword search on 2008 root, too slow
if ($myHead =~ 'http://www.w3.org/2008/site/css/minimum') {
	##-- rudimentary fix, no lnger needed overwritten using vertical-align:top
	##-- SO MUCH TROUBLE FOR vertical-align LOL!! hence: .WikiPeeksAdWrap
	
	#--$indexDocTypeCSS = '#WikiPeeks, #WikiPeeks a[href]:link, #WikiPeeks table, #WikiPeeks tr, #WikiPeeks td, #WikiPeeks span, #WikiPeeks div { border:none; } #WikiPeeksFooter div, #WikiPeeksFooter img, #WikiPeeksFooter span, #WikiBoardBarHistory { position:relative; top:5px; left:0px; } #topbar-center { padding-top:6px; }  ';
	#--$titlePositionScript = '$(document).ready(function(){$("#titleLINKER").css(\'top\',\'15px\').css(\'left\',\'1px\');});';
	
	$myMostRelevantKeys = 'World-Wide-Web Consortium';
}
else {
	##-- use body to test for most repeated words in document, for targted marketing
	$dontWantCommons = ' a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9 frame table draft content write writing description source resource page box circle mark format formatting new old work first second thrid fourth fifth sixth seventh eighth ninth tenth last call end group version review edition candidate about note draft see match than any more each one two value with should other may use type three four five six seven eight nine ten if all they on its model can by and that or given for a in space name value to an which must used when are as this be of will the is not it property section link request document form script media drafts tables ';
	$testMyBody = $myBody;
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

	my $noBotTopPad = '';
	if ($myBody=~"navbar") { $noBotTopPad = 'padding-top:10px;padding-bottom:40px;'; }

	#$todosAnchors = join("\n",@losInAnchors);
	$countAnchors = int(@losInAnchors);


}

$bp =~ s/'//g;
$bp =~ s/"//g;
$myTitle =~ s/"//g;
$myTitle =~ s/'//g;
$source =~ s/'//g;
$source =~ s/"//g;
$ms =~ s/'//g;
$ms =~ s/"//g;
$myMostRelevantKeys =~ s/'//g;
$myMostRelevantKeys =~ s/"//g;

print qq~
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" dir="ltr">
<!-- $bp -->
<head>
<meta http-equiv="X-UA-Compatible" content="IE = 8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css" />
~; 
if ($myHead) { print $myHead; } print qq~
<link rel="stylesheet" type="text/css" href="w3c.css">
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-library-jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-yui-extension-container_core-min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-yui-extension_connection-min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-jquery-extension_scrollTo-min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-jquery-extension_localscroll.min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-jquery-extension_bubblepopup.v2.3.1.min.js"></script>
<script language="javascript" type="text/javascript" src="/cross_browser_javascripts/javascript-jquery-extension_fancybox-1.3.1.pack.js"></script>
<script language="javascript" type="text/javascript" src="/interface_design_templater.php?q=1&p=CHS"></script>
<script language="javascript" type="text/javascript">
	var logo = '<span id="WikiPeeksLogo"><a target="World-Wide-Web-Consortium" title="W3C (World Wide Web Consortium)" href="$elURL"><img height="28" width="33" title="W3C (World Wide Web Consortium)" src="/web_design_imagery/w3c-logo.gif"></a><img height="28" width="8" title="Web Development Resources - Webmaster Tools" src="/web_design_imagery/spacer.gif"></span>';
	var QueryString = '$ENV{'QUERY_STRING'}';
	var bpath = '$bp';
	var myTitle='$myTitle';
	var source = '$source';
	var appLoc = '$appLoc';
	var titleLink = '<span id="titleLINKER" style="position:relative;$titlePosition"><a href="javascript:addBookmark(\\''+appLoc+'?'+QueryString+'\\', \\'WikiPeeks ('+source+') '+myTitle+'\\');" onMouseOver="iHover(this.firstChild,1);" onMouseOut="iHover(this.firstChild,0);" title="Add to Favorites: ('+source+') '+myTitle+'"><img src="/web_design_imagery/WikiBarLink-off.gif" width="14" height="14" border="0" alt="Add to Favorites: ('+source+') '+myTitle+'" name="WikiBarLink" id="WikiBarLink"></a><span> &nbsp;</span>';
	if (myTitle == '') { titleLink = ''; }
	var loadImage = '<span style="position:relative;top:2px;left:0px;" title="Loading, please wait..."><img src="/web_design_imagery/loadCircle.gif" width="18" height="15" border="0" alt="Loading, please wait..."></span>';
	var countAnchors = parseFloat($countAnchors);
	var delimiter = ':: ';
	var topTitle = '$myTitle';
</script>
<script language="javascript" type="text/javascript" src="/interface_design_templater.php?q=1&p=AHS"></script>
<script language="javascript" type="text/javascript" src="/interface_design_templater.php?q=1&p=WPCHS"></script>
~;

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
</script>
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
#WikiBoardBarTitle{ padding-bottom:11px; }
#WikiBoardBarHistory{ padding-bottom:10px; }
#WikiPeeksLogo { position:relative;top:6px; }
#WikiBoardBarAd { margin-bottom:2px; }
#WikiPeeks, th, td, a { font-family:Tahoma,Arial,Helvetica; }
#WikiPeeks a, #WikiPeeks a:active, #WikiPeeks a:visited { color: inherit; text-decoration:none; }
#WikiPeeks a[href], #WikiPeeks a[href]:active, #WikiPeeks a[href]:visited { color: #266899; text-decoration:none; }
#WikiPeeks a[href]:visited { color:#18415F; }
#WikiPeeks a[href]:hover { color:#CC0000; }
#WikiPeeksHeader a { background:none; color:#266899; }
#WikiPeeksHeader a:hover { background:none; color:#CC0000; }
.WikiPeeksAdWrap table, .WikiPeeksAdWrap table td, .WikiPeeksAdWrap table tbody, .WikiPeeksAdWrap table tr, .WikiPeeksAdWrap table th { border:0px none; border-collpase:separate; vertical-align:top; }
.WikiPeeksAdWrap .DonComTD { vertical-align:bottom; }
#WikiPeeks table, #WikiPeeks table td, #WikiPeeks table tbody, #WikiPeeks table tr, #WikiPeeks table th { border:0px none; margin:0; padding:0; border-collpase:separate; vertical-align:bottom; }
#WikiPeeks, #WikiPeeks a[href]:link, #WikiPeeks table, #WikiPeeks tr, #WikiPeeks td, #WikiPeeks span, #WikiPeeks div { border:none; } 
.WikiPeeksAdWrap a, #WikiPeeksHeader span, #WikiPeeksHeader a, #WikiBoardBarTitle img, #WikiBoardBarTitle span, #WikiBoardBarTitle a {border:none;}
</style>
</head>
<body style="margin:0;padding:0 0 0 27px; background-color:#FFFFFF;background:#FFFFFF;" onbeforeunload="doUnload();">
<a name="topmost" id="topmost"></a>
<!--<body style="margin:0;padding:30px;background:#F7F7F7;">-->
<!--<div style="padding-bottom:20px;position:absolute;left:0px;top:0px;">$bp</div>-->
<!--<div style="background:#FFFFFF;border-top:#ABADB3 1px solid; border-left:#E2E3EA 1px solid; border-right:#E2E3EA 1px solid; border-bottom:#E3E9EF 1px solid;">-->
<div id="WikiPeeks">
~;



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
	<div id="WikiPeeksSlider" style="left: 0px; background-image: url(//vps-net.com/web_design_imagery/information-technology-tools-footer-background-bottom.png); background-attachment: initial; background-origin: initial; background-clip: initial; background-color: initial; position: relative; top: 0px; height: 56px; overflow-x: hidden; overflow-y: hidden; display: block; background-position: 0px -2px; background-repeat: repeat no-repeat; ">
		<div style="padding-top:2px;">
			<table width="100%" cellpadding="0" cellspacing="0" style="height:56px;">
				<tbody>
					<tr valign="bottom">
						<td align="left" nowrap="1"><div id="WikiBoardBarTitle"></div></td><td align="left" nowrap="1"><div id="WikiBoardBarHistory"></div></td>
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

$bodyPadding = '50px';
##-- if we have the main navbars, we need more padding at the bottom of the page, clear WikiPeeks Footer
##-- <div class="navbar" align="center">
if ($myBody =~ m/(<div[^>]+?class="navbar"[^>]*>.*?>)/) { $bodyPadding = '50px 50px 70px 50px'; }

print qq~
<div style="text-align:left;padding:$bodyPadding;$noBotTopPad">
<div id="content">
~;

$myBody =~ s/[^[:ascii:]]+//g;


print qq~ $myBody ~;


print qq~</div></div></div>
</body>
<script language="javascript" type="text/javascript">
var mostRelevantKeys = '$myMostRelevantKeys';
var msour = '$ms';
</script>
<script language="javascript" type="text/javascript" src="/interface_design_templater.php?q=1&p=WPCFS"></script>
<script language="javascript" type="text/javascript">
var meinHREF = 'javascript:document.location.href=\\'/w3c.htm?st=/TR/\\';';
/*framed*/
if (!(!parent.fancyLoad)) {
	meinHREF = 'javascript:fancyLoad(\\'/w3c.htm?st=/TR/\\');';
}
/* else { $titlePositionScript } */
if (!(!mwbt)) {
	if (mwbt!=0) {
		wbct.innerHTML = '<a href="'+meinHREF+'" title="The World Wide Web Consortium (W3C) is an international community where Member organizations, a full-time staff, and the public work together to develop Web standards. Led by Web inventor Tim Berners-Lee and CEO Jeffrey Jaffe, the mission of W3C is to lead the Web to its full potential. These are their lastest Working Standards and Drafts.">World Wide Web Consortium: Standards and Drafts</a>';
		wbcs.innerHTML = '<!--<a href="javascript:fancyLoad(\\'/w3c.htm?st=/TR/\\');" title="Search the W3C Standards and Drafts">search</a>-->';
		parent.wikiResource = 'The World-Wide-Web Consortium (W3C)';
	}
}
</script>
</html>
~; 

exit;
