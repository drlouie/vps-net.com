<?php
################################################################
#   Program:    Request API Access to HTML-O                   #
#   Author:     Luis Gustavo Rodriguez (drlouie)               #
#   Copyright:  (c) 2016 Luis G. Rodriguez                     #
#   Licensing:  MIT License                                    #
#   About                                                      #
#        Type:  Email form.                                    #
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

?>


		<div id="HTML-O-AccessRequest">
			<table width="920" cellpadding="0" cellspacing="0" celborder="0" class="nobord">
				<tr class="nobord" height="1">
					<td class="nobord"><div class="HTMLoNocont" style="width:670px;height:1px;overflow:hidden;clip:rect(0px,670px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="670" height="45" border="0"></div></td>
					<td class="nobord"><div class="HTMLoNocont" style="width:30px;height:1px;overflow:hidden;clip:rect(0px,30px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="30" height="45" border="0"></div></td>
					<td class="nobord"><div class="HTMLoNocont" style="width:220px;height:1px;overflow:hidden;clip:rect(0px,220px,1px,0px);"><img src="/web_design_imagery/spacer.gif" width="220" height="45" border="0"></div></td>
				</tr>
				<tr class="nobord" height="45">
					<td class="nobord" valign="top" align="left">
					<div id="AccessForm" class="HTMLoWrapper" style="padding-bottom:0px;">
						<form name="HTML-O-Access">
						<div id="ObfuscatorAccessPrompt" class="HTMLoPrompt">Fill out the Access Request form to get your FREE HTML-O Website Widget Code!</div>
						<div id="ObfuscatorAccessForm" class="HTMLoFormContainer">
							<fieldset class="HTMLoFieldset">
								<legend class="HTMLoLegend" style="margin-bottom:0px;">&nbsp;<font style="font-weight:bold;">Form:</font> Access Request for <font style="color:#0078AD;">HTML-O</font>&nbsp;</legend>
								<div class="HTMLoInstructions"><center>Information we collect allows us an insight on how and where our content is being utilized.</center></div>
								<div id="HTMLoCodeRequest">
									<table width="548" cellpadding="0" cellspacing="0" border="0">
										<tr valign="bottom">
											<td align="right" style="padding-bottom:4px;padding-top:8px;padding-right:18px;" class="vFormTitle"><b><font class="commonHelper" title="This form field is required.">*</font> <label for="DomainWebsiteURL" id="label_DomainWebsiteURL">Domain or Website URL</label></b> <a href="javascript:void(0);" title="Maximum 25 characters allowed [ a-z 0-9 ] ( eg: ActionJackson )" class="commonHelper">what?</a></td>
											<td rowspan="8" align="center"><div style="background-image:url('/website_design_template_images/verticalDottie.gif');background-repeat:repeat-y;width:1px;height:166px;overflow:hidden;clip:rect(0px 1px 166px 0px);"></div></td>
											<td align="left" style="padding-bottom:4px;padding-top:8px;padding-left:18px;" class="vFormTitle"><b><label for="Feedback" id="label_Feedback">Feedback or suggestions welcome:</label></b></td>
										</tr>
										<tr valign="bottom">
											<td align="right" style="padding-bottom:14px;padding-right:18px;"><input tabindex="6" class="commonInput" type="text" maxlength="25" name="DomainWebsiteURL" id="DomainWebsiteURL" value="" style="width:256px;" onFocus="formLabelFlipper(this,1);" onBlur="formLabelFlipper(this,0);" %%DomainWebsiteURL%%></td>
											<td rowspan="4" valign="top" align="left" style="padding-bottom:14px;padding-left:18px;"><textarea tabindex="7" name="Feedback" id="Feedback" class="HTML-O-Feedback" onFocus="formLabelFlipper(this,1);" onBlur="formLabelFlipper(this,0);"></textarea></td>
										</tr>
										<tr>
											<td align="right" style="padding-right:0px;"><div style="background-image:url('/website_design_template_images/horizontalDottie.gif');background-repeat:repeat-x;width:250px;height:1px;overflow:hidden;clip:rect(0px 250px 1px 0px);"></div></td>
										</tr>
										<tr>
											<td align="right" style="padding-bottom:4px;padding-top:8px;padding-right:18px;" class="vFormTitle"><b><label for="WebsiteEntityName" id="label_WebsiteEntityName">Website or Entity Name</label></b> <a href="javascript:void(0);" title="Maximum 25 characters allowed [ a-z 0-9 ] ( eg: ActionJackson )" class="commonHelper">why?</a></td>
										</tr>
										<tr>
											<td align="right" style="padding-bottom:14px;padding-right:18px;"><input tabindex="8" class="commonInput" type="password" maxlength="25" name="WebsiteEntityName" id="WebsiteEntityName" value="" style="width:236px;" onFocus="formLabelFlipper(this,1);" onBlur="formLabelFlipper(this,0);"></td>
										</tr>
										<tr>
											<td colspan="3" align="center"><div style="background-image:url('/website_design_template_images/horizontalDottie.gif');background-repeat:repeat-x;width:440px;height:1px;overflow:hidden;clip:rect(0px 440px 1px 0px);"></div></td></tr>
										</tr>
										<tr>
											<td align="right" style="padding-bottom:4px;padding-top:8px;padding-right:18px;" class="vFormTitle"><b><font class="commonHelper" title="This form field is required.">*</font> <label for="fn" id="label_fn">Full Name</label></b> <a href="javascript:void(0);" title="Maximum 25 characters allowed [ a-z 0-9 ] ( eg: ActionJackson )" class="commonHelper">or login</a></td>
											<td align="left" style="padding-bottom:4px;padding-top:8px;padding-left:18px;" class="vFormTitle"><b><font class="commonHelper" title="This form field is required.">*</font> <label for="em" id="label_em">Email Address</label></b> <a href="javascript:void(0);" title="Maximum 25 characters allowed [ a-z 0-9 ] ( eg: ActionJackson )" class="commonHelper">why?</a></td>
										</tr>
										<tr>
											<td align="right" style="padding-bottom:14px;padding-right:18px;"><input tabindex="9" class="commonInput" type="text" maxlength="25" name="fn" id="fn" value="" style="width:206px;" onFocus="formLabelFlipper(this,1);" onBlur="formLabelFlipper(this,0);" %%FullName%%></td>
											<td align="left" style="padding-bottom:14px;padding-left:18px;"><input tabindex="10" class="commonInput" type="text" maxlength="150" name="em" id="em" value="" style="width:206px;" onFocus="formLabelFlipper(this,1);" onBlur="formLabelFlipper(this,0);" %%Email%%></td>
										</tr>
										<tr>
											<td colspan="3" align="center"><div style="background-image:url('/website_design_template_images/horizontalDottie.gif');background-repeat:repeat-x;width:400px;height:1px;overflow:hidden;clip:rect(0px 400px 1px 0px);"></div></td></tr>
										</tr>
										<tr>
											<td colspan="3" align="center"><div id="ReadTOS"><label for="TOS" id="label_TOS">Please check the information you've entered above (feel free to change anything you like), and review the Terms of Service below.</label></div></td>
										</tr>
										<tr>
											<td colspan="3" align="center"><div id="TOSTextarea"><textarea tabindex="11" class="TOS" name="TOS" id="TOS" onFocus="formLabelFlipper(this,1);" onBlur="formLabelFlipper(this,0);" rows="10"></textarea></div></td>
										</tr>
										<tr>
											<td colspan="3" align="center"><div style="background-image:url('/website_design_template_images/horizontalDottie.gif');background-repeat:repeat-x;width:400px;height:1px;overflow:hidden;clip:rect(0px 400px 1px 0px);"></div></td></tr>
										</tr>
										<tr>
											<td rowspan="5" align="right" valign="top" style="padding-right:14px;padding-top:16px;padding-bottom:14px;">
									
												<table width="206" cellpadding="0" cellspacing="0" border="0">
													<tr valign="top">
														<td align="left"><div id="FreeCaptchaChallenge" onClick="freeCaptcha('click');" onMouseOver="freeCaptcha(1);" onMouseOut="freeCaptcha(0);"><img src="/freeCaptcha/?" width="170" id="cFreeCaptcha" class="cFreeCaptcha" name="cFreeCaptcha" border="0"></div></td>
														<td align="center" style="padding:10px;">
														<div id="FreeCaptchaReChallenge" onClick="freeCaptcha('click');" onMouseOver="freeCaptcha(1);" onMouseOut="freeCaptcha(0);"><img src="/web_design_imagery/rFreeCaptcha_off.gif" width="20" height="20" id="rFreeCaptcha" name="rFreeCaptcha" class="rFreeCaptcha" border="0" valign="right"></div>
														<div id="FreeCaptcha-Text-to-Speech" onClick="freeCaptcha('text-to-speech');" onMouseOver="freeCaptcha(3);" onMouseOut="freeCaptcha(2);"><a href="/freeCaptcha/text-to-speech/?" target="FreeCaptchaTTS"><img src="/web_design_imagery/aFreeCaptcha_off.gif" width="20" height="20" id="aFreeCaptcha" name="aFreeCaptcha" class="aFreeCaptcha" border="0" valign="right"></a></div>
														</td>
													</tr>
													<tr><td colspan="2" style="padding-top:10px;padding-bottom:10px;"><div id="FreeCaptchaPromptLabel"><label for="Challenge" class="FreeCaptchaPromptLabel"><div id="FreeCaptchaPrompt">Type all the characters you see in the challenge code picture above.</div></label></div></td></tr>
													<tr><td colspan="2" align="left"><div id="FreeCaptchaInput"><input tabindex="12" class="commonInput" type="text" maxlength="7" name="Challenge" id="Challenge" value="" style="width:206px;" onFocus="formLabelFlipper(this,1);" onBlur="formLabelFlipper(this,0);"></div></td></tr>
													<tr><td colspan="2" style="padding-top:2px;"><div id="FreeCaptchaInfo">Letters are not case-sensitive</div></td></tr>
												</table>

											</td>
											<td rowspan="5" align="center" style="background-image:url('/website_design_template_images/verticalDottie.gif');background-repeat:repeat-y;"><div style="width:1px;height:170px;overflow:hidden;clip:rect(0px 1px 170px 0px);"></div></td>
											<td align="left" valign="top" style="padding-left:14px;padding-top:14px;padding-bottom:14px;"><div style="float:left;padding-right:12px;"><input tabindex="13" name="AgreeTOS" id="AgreeTOS" type="checkbox" value="AcceptTOS" onFocus="formLabelFlipper(this,1);" onBlur="formLabelFlipper(this,0);" checked></div><div class="AgreeTOS"><label for="AgreeTOS" id="label_AgreeTOS">I accept and agree to the Terms of Service above and the <font style="color:#133CBC">Privacy Policy</u>.</label></div></td>
										</tr>
										<tr>
											<td align="left"><div style="background-image:url('/website_design_template_images/horizontalDottie.gif');background-repeat:repeat-x;width:240px;height:1px;overflow:hidden;clip:rect(0px 240px 1px 0px);"></div></td></tr>
										</tr>
										<tr>
											<td align="left" valign="top" style="padding-left:14px;padding-top:14px;padding-bottom:14px;"><div style="height:40px;float:left;padding-right:12px;"><input tabindex="14" name="OptIn" id="OptIn" type="checkbox" onFocus="formLabelFlipper(this,1);" onBlur="formLabelFlipper(this,0);" value="AcceptTOS" checked></div><div class="AgreeTOS"><label for="OptIn" id="label_OptIn">Please send me info about new widgets, site updates, product specials and relative offers via email.</label></div></td>
										</tr>
										<tr>
											<td align="left"><div style="background-image:url('/website_design_template_images/horizontalDottie.gif');background-repeat:repeat-x;width:240px;height:1px;overflow:hidden;clip:rect(0px 240px 1px 0px);"></div></td></tr>
										</tr>
										<tr>
											<td align="left" style="padding-left:14px;padding-top:14px;padding-bottom:12px;"><input tabindex="15" type="submit" class="HTMLoButtons" style="width:250px;font-weight:bold;" value="Get my HTML-O Widget Code!"/></td>
										</tr>
									</table>
								</div>
							</fieldset>
						</div>
						</form>
					</div>
					</td>
					<td colspan="2" valign="top" align="left">
						<div id="AccessInformation"><div><a href="/internet-development-tools/html-data-obfuscation-web-tool.php" title="HTML and Data Obfuscation Tool for Webmasters, Website Owners and Web Content Providers"><img src="/web_design_imagery/html-data-obfuscation-tab.jpg" width="137" height="60" border="0" alt="HTML and Data Obfuscation Tool for Webmasters, Website Owners and Web Content Providers"></a></div><div class="AccessInfoExtras">Works with HTML, XHTML, CSS, Javascript, XML and XSL.</div><div class="AccessInfoExtras">FREE HTML Widget for all mobile content developers, website  owners and webmasters.</div><div class="AccessInfoExtras">Output of HTML-O is an HTML generating Cross-browser JavaScript.</div><div class="AccessInfoExtras">Output is compatible with the latest versions of MSIE, Safari, Opera, Mozilla, Chrome and other JavaScript enabled Internet browsers.</div><div class="AccessInfoExtras">You can add the HTML-O Website Widget to as many sites as you please. All you need to do is request an access code for every unique domain name.</div></div>
					</td>
				</tr>
			</table>
			</div>