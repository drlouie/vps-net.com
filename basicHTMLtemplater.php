<?php
/**
 * UI-Templating System
 *
 * @author       L Rodriguez <drlouie@louierd.com>
 * @domain		LouieRd.com
 *
*/

function commonCSS($agente, $mainHeaderIllustration) {

$cs1 = ".stretch { background:url(//louierd.com/website_design_imagery/netmedia-solutions-stretcher.png) repeat-x left 340px; }\n";
$cs2 = ".NetMedia-Solutions-Web-Development { background:url(//louierd.com/website_design_imagery/web-development-vps-net-netmedia-solutions.png) no-repeat left top; }\n";
$cs3 = ".NetMedia-Solutions-Website-Development { background:url(".$mainHeaderIllustration.") no-repeat left top; }\n";

##-- pass valid W3C [case -insensitive]
if(stristr($agente,'W3C') === FALSE) {
	
	##-- find MSIE versions lower than 7
	if (strstr($agente,'MSIE')) {
		$aparts = split(";",$agente);
		foreach ($aparts as &$ap) {
			if (strstr($ap,'MSIE')) {
				$ap = str_replace("MSIE", "", $ap);
				$ap = str_replace(" ", "", $ap);
				
				list($vers,$subv) = explode(".", $ap);
				$miAP = (int)$vers;
				##-- MISE is lower than version 7 [force png transparency support]
				if ($miAP <= 6) {
					###-- bad MSIE support for background placement/tiling using filters [kill it, looks best without]
					#$cs1 = ".stretch {filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='//louierd.com/website_design_imagery/netmedia-solutions-stretcher.png',sizingMethod='scale');}";
					$cs1 = "\n";
					$cs2 = ".NetMedia-Solutions-Web-Development {filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='//louierd.com/website_design_imagery/web-development-netmedia-solutions.png'); BACKGROUND-REPEAT: no-repeat; BACKGROUND-ALIGN: left top;}\n";
					$cs3 = ".NetMedia-Solutions-Website-Development {filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='".$mainHeaderIllustration."'); BACKGROUND-REPEAT: no-repeat; BACKGROUND-ALIGN: left top;}\n";
					$msie = "style=\"cursor:pointer;\" onClick=\"javascript:location.href='/website_design_showcase.htm';\"";
				}
			}
		}
		$cs3 = $cs3 . ".fieldset { margin:5px; padding-top:0px; }\n";
	}
	else {
		##-- force fieldset for all non MSIE
		$cs3 = $cs3 . "fieldset { border:#D5DFE5 1px solid; border-radius: 0.5em; -moz-border-radius: 0.5em; }\n";
	}
	$nonW3ChtmlValid = 'http://validator.w3.org/check?uri=http%3A%2F%2Fwww.vps-net.com%2F';
	$nonW3CcssValid = 'http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fwww.vps-net.com%2F';
	$nonW3CxmlValid = 'http://www.w3.org/2001/03/webdata/xsv?style=xsl&amp;docAddrs=http%3A%2F%2Fwww.vps-net.com%2FShowcases%2FOC1.xml';
}

return array($cs1, $cs2, $cs3, $msie, $nonW3ChtmlValid, $nonW3CcssValid, $nonW3CxmlValid);


}


function commonHead($c1, $c2, $c3, $header, $documentTitle, $mainKeys, $fluffKeys, $metaDesc, $headScripts, $headCSS) {

return "
<!-- website design, web design, web designers, and website development -->
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<head>
<title>".$documentTitle."</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<meta name=\"keywords\" content=\"".$mainKeys.", ".$fluffKeys."\">
<meta name=\"description\" content=\"".$metaDesc."\">
".$headScripts."
<style type=\"text/css\">
body { margin:0; border:0; background:#fff url('//louierd.com/website_design_imagery/website_design_netmedia_solutions.jpg') no-repeat 0 0; }
".$headCSS."
font{color:#000000;}
a:hover{color:#CC0000}
".$c1."
".$c2."
".$c3."
</style>
</head>
<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#414477\" alink=\"#414477\" vlink=\"#666666\">
<div id=\"netmedia-solutions\" class=\"stretch\" style=\"width:100%\">
<div style=\"width:1px;height:1px;visibility:hidden;overflow:hidden;clip:rect(1px,1px,1px,1px);color:#FFFFFF;font-size:1px;\">Website Design - Website Development - Creative Design - Internet Design - Internet Development - Information Technology - IT Development - Flash - XML - DHTML - Actionscript - CSS - AJAX - Mod Perl - PHP</div>
<center>
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
    <tr><td><div style=\"position:relative;width:562px;height:108px;top:0px;left:-100px;\" class=\"NetMedia-Solutions-Web-Development\"><img src=\"//louierd.com/website_design_imagery/technology-spacer.gif\" border=\"0\" width=\"562\" height=\"108\" alt=\"Web Development by NetMedia Solutions\"></div></td></tr>
    <tr>
		<td height=\"12\" valign=\"top\" align=\"right\" width=\"100%\">
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	    		<tr>
      				<td><img src=\"//louierd.com/website_design_imagery/technology-spacer.gif\" width=\"22\" height=\"6\" border=\"0\" alt=\"\"></td>
      				<td><img src=\"//louierd.com/website_design_imagery/netmedia-solutions-website-design.gif\" border=\"0\" width=\"66\" height=\"6\" alt=\"NetMedia Solutions - Website Design\"></td>
      				<td><img src=\"//louierd.com/website_design_imagery/technology-spacer.gif\" width=\"58\" height=\"6\" border=\"0\" alt=\"\"></td>
	      			<td><img src=\"//louierd.com/website_design_imagery/netmedia-solutions-ecommerce.gif\" width=\"70\" height=\"6\" alt=\"NetMedia Solutions - E-Commerce Systems\"></td>
      				<td><img src=\"//louierd.com/website_design_imagery/technology-spacer.gif\" width=\"58\" height=\"6\" border=\"0\" alt=\"\"></td>
    		  		<td><img src=\"//louierd.com/website_design_imagery/netmedia-solutions-cloud-applications.gif\" width=\"112\" height=\"6\" alt=\"NetMedia Solutions - Cloud Application Development\"></td>
      				<td><img src=\"//louierd.com/website_design_imagery/technology-spacer.gif\" width=\"58\" height=\"6\" border=\"0\" alt=\"\"></td>
	    	  		<td><img src=\"//louierd.com/website_design_imagery/netmedia-solutions-mobile-applications.gif\" width=\"116\" height=\"6\" alt=\"NetMedia Solutions - Mobile Application Development [ WAP ]\"></td>
      				<td><img src=\"//louierd.com/website_design_imagery/technology-spacer.gif\" width=\"58\" height=\"6\" border=\"0\" alt=\"\"></td>
      				<td><img src=\"//louierd.com/website_design_imagery/netmedia-solutions-marketing.gif\" width=\"60\" height=\"6\" alt=\"NetMedia Solutions - Internet Marketing\"></td>
      				<td><img src=\"//louierd.com/website_design_imagery/technology-spacer.gif\" width=\"22\" height=\"6\" border=\"0\" alt=\"\"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div id=\"espacio0\" style=\"width:500px;height:40px;clip:rect(0px,500px,40px,0px);overflow:hidden;\"><img src=\"//louierd.com/website_design_imagery/technology-spacer.gif\" width=\"1\" height=\"40\" border=\"0\" alt=\"\"></div>
".$header."
";

}


function commonFoot() {

return "
</center>
<div style=\"width:1px;height:1px;visibility:hidden;overflow:hidden;clip:rect(1px,1px,1px,1px);color:#FFFFFF;font-size:1px;\">Website Design - Website Development - Creative Design - Internet Design - Internet Development - Information Technology - IT Development - Flash - XML - DHTML - Actionscript - CSS - AJAX - Mod Perl - PHP</div>
</div>
</body>
</html>
";

}
?>
