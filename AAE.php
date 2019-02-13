<?php 

################################################################
#   Program:    Ask An Expert                                  #
#   Author:     Luis Gustavo Rodriguez (drlouie)               #
#   Copyright:  (c) 2016 Luis G. Rodriguez                     #
#   Licensing:  MIT License                                    #
#   About                                                      #
#        Type:  Email form                                     #
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

	$phpCompileOS = $_SERVER["SERVER_SOFTWARE"];
	if (stristr($phpCompileOS, 'WIN') !== FALSE) {
		$HTTPRoot = 'H:/dvwf/rbsd_IO/vhosts/vsnet/htdocsNEW/';
	}
	else { $HTTPRoot = '/var/www/vps-net.com/htdocs/'; }

	/*define local working table*/
	define("VPSSQL_DB_NAME", "vpsnetcom");

	/** load VPS-DB-CONFIG */
	require_once($HTTPRoot.'vps-config.php' );

	// read cart cookie
	$OpenCanvasDesign = $_COOKIE["OpenCanvasDesign"];

	$isgood = '0';
	if ( isset($_REQUEST['AAEFirst']) ) {
		$vAAEFirst = $_REQUEST['AAEFirst'];
		$vAAELast = $_REQUEST['AAELast'];
		$vAAEEmail = $_REQUEST['AAEEmail'];
		$vAskAnExpert = $_REQUEST['AskAnExpert'];
		$isgood = '1';
	}
	else {
		$vAAEFirst = 'First Name';
		$vAAELast = 'Last Name';
		$vAAEEmail = 'E-Mail Address';
		$vAskAnExpert = 'How may our expert technical or friendly support staff be of assistance?';
	}

	if (strlen($OpenCanvasDesign) > 10) {
		$inUID = $OpenCanvasDesign;
		$USCART = $db->get_row("SELECT * FROM customerScarts WHERE UID = '$inUID'");
		if (strpos($USCART->EA, '@') !== false) {
			$vAAEEmail = $USCART->EA;
			if (isNotEmpty($USCART->CID)) {
				$inUID = $USCART->CID;
				$CUSTOMER = $db->get_row("SELECT * FROM CustomersNEW WHERE CustomerID = '$inUID'");
				if (isNotEmpty($CUSTOMER->FName)) { 
					$vAAEFirst = $CUSTOMER->FName;
					$vAskAnExpert = 'Welcome back '.$vAAEFirst.', our expert technical and friendly support staff are ready to assist you. Any questions?';
				}
				if (isNotEmpty($CUSTOMER->LName)) { $vAAELast = $CUSTOMER->LName; }
			}
		}
	}

	$dAskAnExpert = $vAskAnExpert;

	function isNotEmpty($incoming) {
		return !empty($incoming) || is_numeric($incoming);
	}

?>
<style type="text/css">
#comments-form-message { width:190px; display: block; border: 1px dashed #AAB19E; margin:7px 0 0 0; color:#000000; font-size: 11px; -moz-border-radius:2px; -webkit-border-radius:2px; border-radius:2px; }
#comments-form-message.comments-form-message-error { border: 1px dashed #E98D8D; }
.comments-form-message-error { padding: 7px 7px 7px 34px; text-align:left; background: #F5CCCC url(/web_design_imagery/website_design_communications/icon_error.png) no-repeat 9px 50%; }
.comments-form-message-info { padding: 7px 7px 7px 34px; text-align:left; background: #F9F9F9 url(/web_design_imagery/website_design_communications/information.png) no-repeat 9px 50%; }
.comments-form-message-optin { padding: 14px; text-align:center; background: #F9F9F9; }
.comments-form-message-time { padding: 7px 7px 7px 34px; text-align:left; background: #F9F9F9 url(/web_design_imagery/website_design_communications/clock.png) no-repeat 9px 50%; }
</style>
<script type="text/javascript" language="Javascript">
var FN = "First Name"; var LN = "Last Name"; var EM = "E-Mail Address"; var QU = "<?php echo $dAskAnExpert;?>";
var thyFN = '';var thyLN = '';var thyEM = '';var thyQU = '';
var vaae = function() {
var Dom = YAHOO.util.Dom;
Dom.get("Ask-An-Expert-Roundabout").innerHTML = '<span style="position:relative;top:3px;left:-3px;" title="Loading, please wait..."><img src="/web_design_imagery/loadCircle.gif" width="18" height="15" border="0" alt="Loading, please wait..."></span>';
Dom.get("AAESubmit").disabled = true;
Dom.get("AAEReset").disabled = true;
Dom.get("AAESubmit").value = 'Verifying Input';
var edrop = ""; var tff = "";
thyFN = document.aae.AAEFirst.value;
thyLN = document.aae.AAELast.value;
thyEM = document.aae.AAEEmail.value;
thyQU = document.aae.AskAnExpert.value;
//if (thyFN == FN || thyFN == "" || thyFN == " " || thyFN.length <= 0) { edrop += "\n     - Your First Name is missing"; if (tff == "") { tff = "AAEFirst"; } }else if (thyFN.length <= 2) { edrop += "\n     - Your First Name must be greater than 2 characters in length"; if (tff == "") { tff = "AAEFirst"; } }
//if (thyLN == LN || thyLN == "" || thyLN == " " || thyLN.length <= 0) { edrop += "\n     - Your Last Name is missing"; if (tff == "") { tff = "AAELast"; } }else if (thyLN.length <= 2) { edrop += "\n     - Your Last Name must be greater than 2 characters in length"; if (tff == "") { tff = "AAELast"; } }
//if (thyEM == "" || thyEM == EM)	{ edrop += "\n     - Your Email Address is missing"; if (tff == "") { tff = "AAEEmail"; } } else if ((thyEM.indexOf('@') == -1) || (thyEM.indexOf('.') == -1)) {edrop += "\n     - Your Email Address's Format should be: user@domain.com";if (tff == "") { tff = "AAEEmail"; }}if ((thyEM.indexOf(',') != -1)) {edrop += "\n     - Commas are not allowed in email addresses";if (tff == "") { tff = "AAEEmail"; }}if ((thyEM.indexOf(';') != -1)) {edrop += "\n     - Semicolons are not allowed in email addresses";if (tff == "") { tff = "AAEEmail"; }}if ((thyEM.indexOf(':') != -1)) {edrop += "\n     - Colons are not allowed in email addresses";if (tff == "") { tff = "AAEEmail"; }}if ((thyEM.indexOf('&') != -1)) {edrop += "\n     - Ampersands are not allowed in email addresses";if (tff == "") { tff = "AAEEmail"; }}
//if (thyQU == QU || thyQU == "" || thyQU == " " || thyQU.length <= 0) { edrop += "\n     - Your Question(s) or Issue is missing"; if (tff == "") { tff = "AskAnExpert"; } }else if (thyQU.length <= 2) { edrop += "\n     - Question(s) must be greater than 2 characters"; if (tff == "") { tff = "AskAnExpert"; } }
if (edrop != "") {
    edrop ="___________________________________________                   \n\n" + "  Your request cannot be processed because one\n  or more fields are either blank or filled incorrectly:\n" + "___________________________________________                   \n\n" +
    edrop + "\n\n___________________________________________                   " + "\n\n   To continue, check fields and submit form again!" + "\n___________________________________________";
    alert(edrop);
	showMess();
	document.aae[tff].focus();
}
// good
else {
	Dom.get("AAESubmit").value = 'Asking Expert';
	stcf(1);
}
return false;
};
var stcf = function(tracer) {
	if (tracer == 2) { acting='optin=1'; } else { acting='qifm=1'; }
	var Dom = YAHOO.util.Dom;
	var formObject = document.getElementById('AAE');
	YAHOO.util.Connect.setForm(formObject);
	var lUrl = '/customer-communication-panel.htm';
	var callback = {
		success: function(o) { 
			lUrl = ''; 
			if(o.responseText !== undefined) { 
				if (tracer == 1 && (o.responseText == 'Message sent.' || o.responseText == 'Message Sent')) {
					Dom.get("AAESubmit").value = 'Accepted';
					$("#Ask-An-Expert-Roundabout").html(' ');
					Dom.get("Ask-An-Expert-Console").innerHTML = '<div id="comments-form-message" class="comments-form-message-info" style="display: none; opacity: 0; padding-top:10px;"><div>Your message has been successfully submitted, thank you.</div></div>';
					// request opt-in 
					if (o.responseText == 'Message sent.') { $("#comments-form-message").fadeTo('slow','1.00',function(){setTimeout(optInMess,5000)}); }
					// no opt-in request
					else { $("#comments-form-message").css('display','block').fadeTo('slow','1.00',function(){setTimeout(hideMess,5000)}); }
					Dom.get("AskAnExpert").value = QU;
				}
				else if(tracer == 1) {
					Dom.get("AAESubmit").value = 'Declined';
					$("#Ask-An-Expert-Roundabout").html(' ');
					Dom.get("Ask-An-Expert-Console").innerHTML = '<div id="comments-form-message" class="comments-form-message-error" style="display: none; opacity: 0; padding-top:10px;"><div>'+o.responseText+'</div></div>';
					if (o.responseText.indexOf('first') != -1){ document.aae["AAEFirst"].focus(); }
					if (o.responseText.indexOf('last') != -1){ document.aae["AAELast"].focus(); }
					if (o.responseText.indexOf('email') != -1){ document.aae["AAEEmail"].focus(); }
					if (o.responseText.indexOf('question') != -1){ document.aae["AskAnExpert"].focus(); }
					$("#comments-form-message").css('display','block').fadeTo('slow','1.00',function(){setTimeout(hideMess,5000)});
				}
				// tracer2 (optin) nothing happens, done silently :)
			}
		}
	};
	var transaction = YAHOO.util.Connect.asyncRequest("POST", lUrl, callback, acting);
};
var hideMess = function() {
	$("#comments-form-message").fadeTo('slow','0.00',function(){$("#comments-form-message").css('display','none').css('opacity','0');});
	showMess();
};
var optInMess = function() {
	var Dom = YAHOO.util.Dom;
	$("#comments-form-message div").fadeTo('fast','0.00').html('<span title="Would you like to receive coupons, sales and special promotions from Virtual Private Servers and Networks (VPS-NET), or from authorized third parties selected by VPS-NET?">Would you like to receive coupons, sales and special promotions from Virtual Private Servers and Networks (VPS-NET), or from authorized third parties selected by VPS-NET?</span>').fadeTo('slow','1.00');
	$("#comments-form-message").removeAttr('class').attr('class','comments-form-message-optin').fadeTo('slow','1.00',function(){
		$("#AAESubmit").hide();
		$("#AAEReset").hide();
		var rbut = '<input type="button" tabindex="105" id="MYID" class="commonButtons" style="padding:1px;font-size:11px;" value="MYVALUE" onClick="MYCLICK" title="MYTITLE" />';
		optin = rbut;
		optout = rbut;
		optin = optin.replace('MYID','OptIn').replace('MYVALUE','Yes, Opt-In').replace('MYTITLE','Yes, Opt-In').replace('MYCLICK',"optInMailer('Yes');");
		optout = optout.replace('MYID','OptOut').replace('MYVALUE','No').replace('MYTITLE','No, Opt-Out').replace('MYCLICK',"optInMailer('No');");
		$("#Ask-An-Expert-Roundabout").html('<center>'+optin+''+optout+'</center>');
		$("#OptIn").css('width','auto').css('padding-left','14px').css('padding-right','14px');
		$("#OptOut").css('font-weight','normal').css('width','auto').css('padding-left','7px').css('padding-right','7px');
	});
};
var optInMailer = function(opt) {
	//alert(opt);
	var startThanks = 'We thank you, once again,';
	var ThanksForJoining = '';
	if (opt=='Yes') { stcf(2); startThanks = 'Oh cool! Thanks again'; ThanksForJoining = ' and for opting-in'; }
	$("#Ask-An-Expert-Roundabout").html(' ');
	$("#comments-form-message").removeAttr('class').attr('class','comments-form-message-time');
	$("#comments-form-message div").fadeTo('fast','0.00').html(startThanks+' for taking the time to contact us'+ThanksForJoining+'.').fadeTo('slow','1.00',function(){setTimeout(hideMess,5000)});
}
var showMess = function() {
	var Dom = YAHOO.util.Dom;
	Dom.get("Ask-An-Expert-Roundabout").innerHTML = '';
	Dom.get("AAESubmit").value = 'Ask An Expert';
	Dom.get("AAESubmit").disabled = false;
	Dom.get("AAEReset").disabled = false;
	$("#AAESubmit").show();
	$("#AAEReset").show();
};
var foaae = function(cual) { if (cual) { if (cual.name) { myn = cual.name; myv = cual.value; if (myn == "AAEFirst" && (myv == FN || myv == "" || myv == " ")) { cual.value = ""; } if (myn == "AAELast" && (myv == LN || myv == "" || myv == " ")) { cual.value = ""; } if (myn == "AAEEmail" && (myv == EM || myv == "" || myv == " ")) { cual.value = ""; } if (myn == "AskAnExpert" && (myv == QU || myv == "" || myv == " ")) { cual.value = ""; } var este = cual; } } };
var baae = function(cual) { if (cual) { if (cual.name) { myn = cual.name; myv = cual.value; if (myn == "AAEFirst" && (myv == "" || myv == " ")) { cual.value = FN; } if (myn == "AAELast" && (myv == "" || myv == " ")) { cual.value = LN; } if (myn == "AAEEmail" && (myv == "" || myv == " ")) { cual.value = EM; } if (myn == "AskAnExpert" && (myv == "" || myv == " ")) { cual.value = QU; }	 var este = cual; } } };
var raae = function() { docaae = document.aae;docaae.AAEFirst.value = FN; docaae.AAELast.value = LN; docaae.AAEEmail.value = EM; docaae.AskAnExpert.value = QU; return false; };
</script>

			<div id="Ask-An-Expert">
			<?php 
				$tAAEFirst = '';
				$tAAELast = '';
				$tAAEFirst = '';
				$tAskAnExpert = '';
				$tAAEbutton = '';
				$tAAEbuttonR = '';
				#if ($isgood === '1') {
				#	$tAAEFirst = 'readonly';
				#	$tAAELast = 'readonly';
				#	$tAAEEmail = 'readonly';
				#	$tAskAnExpert = 'readonly';
				#	$tAAEbutton = 'disabled';
				#	$tAAEbuttonR = 'disabled';
				#} 
			?>
				<form name="aae" onSubmit="return vaae();" method="post" id="AAE">
				<input type="hidden" name="Source" value="HTML-O">
				<table width="220" cellpadding="0" cellspacing="0" border="0" class="nobord" style="cursor:help;" title="Questions? Let our Talented Website Designers and Expert Internet Development team assist you today!">
					<tr class="nobord">
						<td class="nobord"><div class="HTMLoNocont" style="width:220px;height:87px;overflow:hidden;clip:rect(0px,220px,87px,0px);"><img src="/web_design_imagery/spacer.gif" width="220" height="87" border="0"></div></td>
					</tr>
					<tr class="nobord">
						<td class="nobord" align="right" style="padding-top:5px;"><input tabindex="101" type="text" maxlength="25" name="AAEFirst" title="Type your First Name" id="AAEFirst" class="AAEinput" style="cursor:help;" value="<?php echo $vAAEFirst;?>" <?php echo $tAAEFirst;?> onFocus="foaae(this);" onBlur="baae(this);" /></td>
					</tr>
					<tr class="nobord">
						<td class="nobord" align="right" style="padding-top:5px;"><input tabindex="101" type="text" maxlength="25" name="AAELast" title="Type your Last Name" id="AAELast" class="AAEinput" style="width:140px;cursor:help;" value="<?php echo $vAAELast;?>" <?php echo $tAAELast;?>  onFocus="foaae(this);" onBlur="baae(this);" /></td>
					</tr>
					<tr class="nobord">
						<td class="nobord" align="right" style="padding-top:5px;"><input tabindex="102" type="text" maxlength="25" name="AAEEmail" title="Type your email address, it's validity will be checked." id="AAEEmail" class="AAEinput" style="width:160px;cursor:help;" value="<?php echo $vAAEEmail;?>" <?php echo $tAAEEmail;?> onFocus="foaae(this);" onBlur="baae(this);" /></td>
					</tr>
					<tr class="nobord">
						<td class="nobord" align="right" style="padding-top:5px;"><textarea tabindex="103" name="AskAnExpert" class="HTMLoTextarea" style="cursor:help;" id="AskAnExpert" title="Type in your question, comment or issue and please feel free to be as descriptive as you'd like." <?php echo $tAskAnExpert;?> onFocus="foaae(this);" onBlur="baae(this);"><?php echo $vAskAnExpert;?></textarea></td>
					</tr>
					<tr class="nobord">
						<td class="nobord" align="center"><div id="Ask-An-Expert-Console"></div></td>
					</tr>
					<tr class="nobord">
						<td class="nobord" align="right" style="padding-top:5px;"><span id="Ask-An-Expert-Roundabout"></span><input type="submit" id="AAESubmit" tabindex="104" class="commonButtons" style="padding:2px;font-size:11px;font-weight:bold;width:130px;" value="Ask An Expert" <?php echo $tAAEbutton;?> /><input type="button" tabindex="105" id="AAEReset" class="commonButtons" style="padding:2px;font-size:11px;font-weight:bold;width:70px;" value="Reset" <?php echo $tAAEbuttonR;?> onClick="raae();" /></td>
					</tr>
				</table>
				</form>
			</div>
