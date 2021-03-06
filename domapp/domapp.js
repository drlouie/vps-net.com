/*
################################################################
#   Program:    DOMapp                                         #
#   Author:     Luis Gustavo Rodriguez (drlouie)               #
#   Copyright:  (c) 2016 Luis G. Rodriguez                     #
#   Licensing:  MIT License                                    #
#   About                                                      #
#        Type:  Domain Name Search, Save and Registration App  #
#        For:   Godaddy, 1and1, domain.com                     #
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
*/
/* OBFUSCATION: of the following lines, obfuscatables contain ( = ) and (// ) */
/*<OBF>*/
// MyServerHTTPPort = DOMapp
// MyDomainURI = doMaIn
// MyAppProcessor = naMe
// TrueDisplayName = wEbSiTe
// AppServer = bUsiNeSS
// FullMobileAppVersion = ApPlICatIon
// MobileAppVersion = moBilE
// FullAppVersion = DoMAPP
// AppVersion = DomAiN
// DefaultViewport = lOOkUp
// HardenedViewport = sErVer
// SortOrder = vPS
// RefreshingAppList = vPn
// loadImage = hOsTinG
// isAndroid = aNdroiD
// isWebkit = wEbKiT
// isChrome = cHroMe
// isChromium = chRoMiuM
// isiOS = IoS
// gva = reGisTratIon
// getViewableArea = reGisTeR
// getAndSetAppOptions = aDdResS
// getAndSetRegistrars = reGiStRaR
// getDocumentSize = rEgiStRy
// clearDocumentLoadtimeState = weBPaGe
// DataLoadedOnce = dAtAbAse
// ParseAppData = iNtErNEt
// ToggleApp = pRoToCoL
// toggleMainMenuIcon = naMinG
// SetTouchFocus = tRaDemArK
// setViewport = sErVErS
// gvaWidth = owNeRShiP
// gvaHeight = bUy
// gdsWidth = wHoIS
// gdsHeight = fInD
// ScreenOrientation = hOsTed
// viewportIsSet = hoSt
// createdAppList = fULlY
// MySavedDomains = qUaLifIeD
// domainAlphabeticalSort = eMaIl
// TotalNumberOfSavedDomains = sErVice
// sortTheAppList = pRoViDer
// maxDocWidth = iP
// marginWidth = AddReSS
// searchWidth = SeARcH
// AppLoading = doMaINS
// AppVisible = doMaIN
// NoDomains = aVaiLaBIliTy
// appListScroll = dotCom
// getMySavedDomainNames = keYwOrD
// ShowButtonsHideActivity = doTnEt
// alphabeticallyOrderedDomains = nEtWOrkS
// chronologicalSort = nEtWoRk
// chronologicallyOrderedItems = iSp
// ParseAppList = checKer
// deleteDomainName = cHeCK
// runDoubleTap = vErIfY
// runSingleTap = AvaIlaBiliTy
// ActivateAppList = aVaILaBle
// checkDomainName = wHOIs
// whoisSearch = wEB
// AppMenuClickHandler = iNtERneT
// AppDomainListing = sErViCeS
// initiateRegistration = vIrTuaL
// myDomain = PrIvaTe
// processingDomainRequest = sErVerS
// DDomainSearchPrompt = aNd
// domainHasBeenSaved = nEtWoRKs
// endOfSearch = pRiVaCY
// extensionMatchSupported = eXtEnSioNs
// DomainToSearch = eXteNSion
// UpdatingDomainListDisplay = toPlEveL
// SaveTakenDomains = subDoMaiN
// isRegistering = neTwoRK
// DomainToSave = woRlD
// successStory = wIdE
// DomainExtentionList = WEb
// runSuccessfulLogin = wWw
// checkServerConnection = cOmPany
// LogoutExecutor = sErViCE
// saveMyDomainName = gOOgLe
// liveSearchMe = goDaDDy
// sizeTheSearchPane = neTsOl
// CatchListItemClick = piCkeR
// OrderByMeOptions = chOoSe
// AppOptionMarkup = loCaTe
// hideRefreshModal = reSeaRch
// toggleAppMenu = keYwOrDs
// clearEntireSearch = coUnTry
// clearSearchPane = cOdE
// activateAppOptionSwitches = sEcuRiTY
// AllRegistrars = sSL
// totalWidth = Ssl
// pullDownAction = DoMAINs
// pullUpAction = subDoMaiN
// runningDomainSearch = fiNder
// searchPaneScroll = NaMiNG
// nowSearchingButton = cOnVenTion
// makeSearchScroller = naMeD
// myWhoisResults = wHOIS
// countCPM = iNtErNET
// DomainsSaved = sEO
// cpContents = SEM
// DomainSearchPromptInner = EnGinE
/*</OBF>*/

var MyServerHTTPPort = '';
if (window.location.port == '80' || window.location.port == '443') { MyServerHTTPPort = ':'+window.location.port+''; }
var MyDomainURI = ''+window.location.protocol+'/' + '/'+window.location.host+''+MyServerHTTPPort+'';
var MyAppProcessor = '/domain-registration-search/find-my-domain.htm';
var TrueDisplayName = "User";
var AppServer = "";
var ChangeLog = "";
var AppVersion;
var FullAppVersion;
var MobileAppVersion;
var FullMobileAppVersion;

var IveSwipedApp = 0;
var IvePinchedApp = 0;
var IveScrolledApp = 0;
var IveZoomedApp = 0;

//-> defaults
var DefaultViewport = '';
var HardenedViewport = '';
var SortOrder = '';

var RefreshingAppList = 0;

var loadImage = '<center><span style="position:relative;top:6px;" title="Loading, please wait..."><img src="images/loadCircle.gif" width="18" height="15" border="0" alt="Loading, please wait..." style="padding-bottom:17px;"></span></center>';

//-> In the future, this may no longer be needed, but here for now, is needed
var ua = navigator.userAgent.toLowerCase();
var isAndroid = ua.indexOf("android") > -1;
var isWebkit = ua.indexOf("webkit") > -1;
var isChrome = ua.indexOf("chrome") > -1;
var isChromium = ua.indexOf("crios") > -1;
var isiOS = /iphone|ipod|ipad/.test( ua );


var isMobile = function(){
    if(typeof window.orientation !== 'undefined') return true;
    return false;
};

var EVENT_CONFIG = {
    CLICK: isMobile()?'touchstart':'click'
};

var gva;

var clearDocumentLoadtimeState = function() {
	stopAnimation();
	TheImageLoader = '';
	$("#loaderImage").remove();
	$("#isearch").hide();
	$("#isearch").html('');
	$("#AppList").css('visibility','visible').css('display','block');
	$("header").css('visibility','visible').css('display','block');
};

var DataLoadedOnce = 0;

var ParseAppData = function() {
	//-X> console.log('ParseAppData');
	clearDocumentLoadtimeState();
	if (DataLoadedOnce == 0) {
		$("form#QuickSearch").fadeTo(1,0.0).css('display','block').fadeTo(250,1.0);
		//-->> BUGTRACK: July 6
		ToggleApp();
	}
	DataLoadedOnce++;
	toggleMainMenuIcon('loading');

	//-> when choosing different view, resize and reset our viewport 
	//-->> IPHONE crashed caused us to move this back here again, removed from within SetTouchFocus()
	SetTouchFocus();
	$( window ).bind( "resize", function( event ) {
		setViewport();
		SetTouchFocus();
		//-> 2016
		window.scrollTo(0, 0);
	});	

};

var searchWidth;
var viewportIsSet = 0;
var setViewport = function() {
	if (Modernizr.touch) {
		gva = getViewableArea();

		var ScreenOrientation = (gva[0] > gva[1])? 90 : 0;
		// landscape mode
			DefaultViewport = 'width='+gva[0]+', height='+gva[1]+', maximum-scale=0.6175, initial-scale=0.6175, user-scalable=no';
			HardenedViewport = 'width='+gva[0]+', height='+gva[1]+', maximum-scale=0.6175, initial-scale=0.6175, user-scalable=no';
			if (
				//--> Not for webkit ios, but yes for chrome on same device (FYI: both safari and chrome are detected as webkit and safari on ios)
				//--> WHY THE NOT? iOS's Safari Browser displays this better with the default viewport, no need to remake the viewport for it, messes it all up
				// !(isWebkit && isiOS && !isChromium && !isWebView)
				// !(isWebkit && isiOS && !isChromium && !isWebView) && 
				//--> Not for webkit android, any variation, including chrome whom also reports itself as webkit, since it is afterall, a webkit based browser
				//--> WHY THE NOT? Android displays this better with the default viewport, no need to remake the viewport for it, messes it all up
				!(isAndroid && isWebkit)
			) {
				$('meta[name=viewport]').prop('content',DefaultViewport);
				viewportIsSet = 1;

				//--> Since safari, but not chromium, iOS has serious some bugs in displaying oriented content, we must scrollTo top 0 then back to our original spot upon changing of orientation
				//--> We also have to do other things like resize main content wrapper height, and reset iscroll area
				if (isWebkit && isiOS && !isChromium) {
					setTimeout(function(){
						//window.scrollTo(0, 1);
						//-> 2016
						window.scrollTo(0, 0);
					}, 5);
				}

			}
	}

	//--> Set .AppHolder AND #files_list_header_wrapper responsive widths
		//--> Must be scripted due to the fact we are using iscroll, which lacks content centering capacity
		//--> These variable values are exactly the same as found in ./css/main.css for: .AppHolder AND #files_list_header_wrapper
	gva = getViewableArea();
	marginWidth = 20;
	totalWidth = (gva[0] - (marginWidth * 2));
	maxDocWidth = 1920;
	maxWidth = 1872;
	minWidth = 550;
	setMinWidth = '';
	if (gva[0] <= maxDocWidth) {
		$(".AppHolder, #files_list_header_wrapper").css({'width':''+totalWidth+'px','margin':'0 '+marginWidth+'px 0 '+marginWidth+'px'});
	}
	else {
		totalWidth = maxWidth;
		marginWidth = ((gva[0] - maxWidth)/2);
		$(".AppHolder, #files_list_header_wrapper").css({'width':''+totalWidth+'px','margin':'0 '+marginWidth+'px 0 '+marginWidth+'px'});
	}
	searchWidth = (gva[0] - (44 + 60));
	if (searchWidth < 496) searchWidth = 496;
	$("form#QuickSearch, input#WebSearch, input#domain-search").css({'width':''+searchWidth+'px', 'min-width':''+searchWidth+'px'});
	sizeTheSearchPane(0);
};
var AppVisible = 0;
var AppLoading = 0;
var ToggleApp = function() {

	//-->> App List is empty, means we haven't loaded it yet, hence ourselves being in document loading mode
	if ($("#app-list").html() == '') {
		//-> initiate search upon this our data 
		liveSearchMe();

		AppLoading = 1;
		getMySavedDomainNames();
		// GetDeletedItemsList();
	}
	

	//-->> FLOWTRACK June 16, 2015
	//-->> list is currently not visible, lets make it visible
	//-->> TWO possibilities: We're here during loadtime, OR we're here when re-displaying domain list after having first displayed, then 'closed' the event form
	if (AppVisible == 0) {
		$("#DocumentTitle").css('display','none');
		$("#QuickSearch, #TopBar").show();
		$("#DocumentLoading").remove();
		$("#VirtualPrivateButtons").css('display','none');

		//->2015 v2
		//-->> FLOWTRACK June 16, 2015
		//-->> CHANGED: Here we only show if indeed we are past the AppLoading stage, meaning any time we are 're-showing' domain list
		//-->> FURTHERMORE: We moved to when we actually set AppLoading = 0 within ShowButtonsHideActivity
		if (AppLoading == 0) { 
			$("#AppList").css('visibility','visible').css('display','block');
		}

		AppVisible = 1;
		
	}

	//-->> BUGTRACK June 16, 2015
	//-->> RELEVANCE SEARCH
	//-->> the 'else' for AppVisible == 0 of this function
	else {
		$("#QuickSearch, #TopBar").hide();

		$("#AppList").hide();

		AppVisible = 0;
	}

	
	//-->> BUGTRACK June 16, 2015
	//-->> MOVED FROM FUNCTION LOCATION: WHY HERE BUT NOT ON THE 'else'?
	//-->> SO NOW we test for AppVisible == 1, and in essence, fixed and moved to the very end of the document loadtime flow
	if (AppVisible == 1) {
		ShowButtonsHideActivity();
		toggleMainMenuIcon('default');
	}

};
var NoDomainsTitle = 'You have no saved domain names';
var NoDomains = '<div class="my-domains no-domains"><div class="domain-action"><div></div></div><div class="data"><div class="subject" style="font-weight:normal" rel="no-rel" id="no-id">'+NoDomainsTitle+'</div></div></div>';

var hideRefreshModal = function() {
	if ($("#ActivityModal").length >= 1) {
		$('#ActivityModal').fadeTo('fast',0.00, function(){
			$(this).remove();
		});
	}
	toggleMainMenuIcon('default');
};
var createdAppList = 0;
var ParseAppList = function(MySavedDomains,TotalNumberOfSavedDomains) {
	//-> first time/pass only, meaning not for reparsing of list 
	if (createdAppList == 0) {
		$("#AppList, .AppHolder").css('display','block');
		//toggleMainMenuIcon('loading');
	}
	//-> secondary passes, meaning re-parsing list upon user action 
	else {
		$("#app-list").empty();
	}
	
	if ($('#the-domains').length == 0) {
		$('#app-list').append('<div id="the-domains" class="the-domains with-domain"><label for="the-domains"><div class="domain-list-title">Domains you\'ve saved</div><div class="saved-domain-name-list">'+NoDomains+'</div></label></div>');
		// hide not remove since our overall css relies on the first-child being present, that being the domain action
		$('.domain-action').hide();
	}
	if (TotalNumberOfSavedDomains >= 1) {
		$('.my-domains.no-domains').remove();
		for (var i=0; i<MySavedDomains.length; i++) {
			$('.saved-domain-name-list').append(NoDomains.replace('no-domains','saved-domain').replace('no-rel',i).replace('no-id',MySavedDomains[i].replace('[domain:{','').replace('}]','')).replace(NoDomainsTitle,MySavedDomains[i].replace('[domain:{','').replace('}]','')));
		}
	}

	//-> first time/pass only, meaning not for reparsing of list 
	if (createdAppList == 0) {
		toggleMainMenuIcon('default');
		appListScroll.refresh();
		//hideRefreshModal();
		//loaded();
	}
	//-> secondary passes, meaning re-parsing list upon user action 
	else {
		appListScroll.refresh();
	}
		
	createdAppList++;

	//-> don't show the OptionsMenu if nothing to show 
	//if ($('.my-domains.saved-domain').length <= 1) {
	//	$("#AppOptions, #OptionsMenu").hide();
	//}
	//-> default sort, rev chronological order 
	if (TotalNumberOfSavedDomains >= 1) {
		sortTheAppList(OrderByMeOptions[0]);
	}
	
};

var domainAlphabeticalSort = function(list, item, type) {
	var $divs = $(list);
    var alphabeticallyOrderedDomains = $divs.sort(function (a, b) {
		if (type == 'asc') {
			return $(a).find(item).text() > $(b).find(item).text() ? 1 : -1;
		}
		else {
			return $(a).find(item).text() < $(b).find(item).text() ? 1 : -1;
		}
    });
	return alphabeticallyOrderedDomains;
};
var chronologicalSort = function(list, item, type) {
	var $divs = $(list);
    var chronologicallyOrderedItems = $divs.sort(function (a, b) {
		if (type == 'asc') {
			return intpad($(a).find(item).attr('rel'),3) > intpad($(b).find(item).attr('rel'),3) ? 1 : -1;
		}
		else {
			return intpad($(a).find(item).attr('rel'),3) < intpad($(b).find(item).attr('rel'),3) ? 1 : -1;
		}
    });
	return chronologicallyOrderedItems;
};
var sortTheAppList = function(sortie) {
	SortOrder = sortie;
    //--> NEW
	if (sortie == 'OrderByDomain-Name-asc') {
		$("div.saved-domain-name-list").html(domainAlphabeticalSort('div.saved-domain','div.subject','asc'));
	}
	else if (sortie == 'OrderByDomain-Name-desc') {
		$("div.saved-domain-name-list").html(domainAlphabeticalSort('div.saved-domain','div.subject','desc'));
	}
	else if (sortie == 'OrderByChronologically-ASC') {
		$("div.saved-domain-name-list").html(chronologicalSort('div.saved-domain','div.subject','asc'));
	}
	else if (sortie == 'OrderByChronologically-DESC') {
		$("div.saved-domain-name-list").html(chronologicalSort('div.saved-domain','div.subject','desc'));
	}
	//-> activate click-through capability and the like, for items in list 
	ActivateAppList();
};
var intpad = function(num, size) {
    var s = "000000000" + num;
    return s.substr(s.length-size);
};

var ActivateAppList = function() {
	//-X> console.log('ActivateAppList');
	$('.my-domains.saved-domain').doubletap(runDoubleTap,runSingleTap);
};
var runDoubleTap = function(eve) {
	// taken or invalid, and make certain we have domain name only in the HTML, meaning no check-time content such as icons etc, before we make our change
	if (!$(eve).hasClass('available') && ($(eve).find('.subject').attr('id') == $(eve).find('.subject').html() || $(eve).find('.subject').html().toString().indexOf(' is taken...') != -1)) {
		$(eve).addClass('invalid').find('.subject').html('Delete ' + $(eve).find('.subject').attr('id') + '?');
		$(document).on(EVENT_CONFIG.CLICK, '.invalid .domain-action', function (e) {
			deleteDomainName($(eve));
			e.stopPropagation();
			e.preventDefault();
		});
	}
};
var runSingleTap = function(eve) {
	// only run if isn't in stalemate mode
	if (!$(eve).hasClass('available') && !$(eve).hasClass('taken') && !$(eve).hasClass('invalid')) {
		checkDomainName($(eve).find('.subject'));
	}
	else if (!$(eve).hasClass('invalid') && !$(eve).hasClass('available') && $(eve).hasClass('taken') && ($(eve).find('.subject').attr('id') == $(eve).find('.subject').html() || $(eve).find('.subject').html().toString().indexOf(' is taken...') != -1)) {
		$("#WebSearch").focus().blur();
		$("#WebSearch").val($(eve).find('.subject').attr('id'));
		searchIt($("#WebSearch"));
		$("li#mainsubmit input").css('display','none');
		window.setTimeout(function(){
			toggleMainMenuIcon('loading');
			$("#SearchResults").empty().html('<div class="search-results-row entered">You entered: <strong>'+$("#WebSearch").val()+'</strong><div>');
			whoisSearch(eve);
		},500);
	}
	// undelete it
	else if (!$(eve).hasClass('available') && !$(eve).hasClass('taken') && $(eve).find('.subject').html() == 'Delete ' + $(eve).find('.subject').attr('id') + '?') {
		$(eve).removeClass('invalid').find('.subject').html($(eve).find('.subject').attr('id'));
	}
};
var CatchListItemClick = function() {
	//-X> console.log('CatchListItemClick');
	//-> take this opportunity to flag all common gestures, to mitigate their effects, at various levels, for instance: doubletap.js
	$(function() {
		$(document).on(EVENT_CONFIG.CLICK, '#back-to-top', function (e) {
			backToTop();
		});

    });
};




var showingMoreFields = 0;
var startShowingMoreFields = function() {
	if (showingMoreFields == 0) {
	}
	showingMoreFields++;
};

var clickAppMenu = function() {
							//->only if app has finished loading
						if (AppLoading == 0) {
							if (AppVisible == 1) {

								//-> if search results are visible when we click the menu-line icon, we simply clearSearchPane() this time around 
								if ($("#WebSearch").val().length >= 1) {
									clearEntireSearch();
								}
								else if ($("#SearchResults").length >= 1) {
									clearSearchPane();
								}
								//-> otherwise, do the default, show the fly in menu 
								else {
									toggleAppMenu();
								}
							}
							else {
								//-> hide AppMenu 
								$("#AppMenu").css('display','none');
								AppVisible = 0;
								ToggleApp();
							}
						}
};
	
var NowShowingButtons = 0;
var ButtonHidingTimer = '';
var ButtonShowingSpeed = 500;
var ShowButtonsHideActivity = function() {

	if (NowShowingButtons == 0 && NowHidingButtons == 0 && KillButtons == 0) {
		NowShowingButtons = 1;

			if (AppLoading == 1) {
		
				$(document).on(EVENT_CONFIG.CLICK, '.app-menu-wrapper', function (e) {		
					//-> only if we are not currently in a 'loader' state 
					if ($(".app-menu").html().toString().indexOf('loader') != -1) {
						e.stopPropagation();
						e.preventDefault();
					}
					else {
						clickAppMenu();
					}
				});
				
				//- mobile(touch)
				$(document).on(EVENT_CONFIG.CLICK, '#LogOutTrigger, #FlyInMenu .logout', function () {
					//->only if app has finished loading
					if (AppLoading == 0) {
						logMeOut();
					}
				});
				$(document).on(EVENT_CONFIG.CLICK, '#LogOutTrigger, #FlyInMenu .app-refresh', function () {
					refreshTrigger();
				});

				

				//-->> FLOWTRACK June 16, 2015
				//-->> AppLoading still, finally set it to AppLoading = 0, end the domain list creation(pageload flow) phase
				$("#AppList").show(1000);
				AppLoading = 0;
				
				//-X> console.log('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
				//-X> console.log('THIS DENOTES THE END OF THE DOCUMENT LOADTIME FLOW');
				//-X> console.log('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
				
				if (Modernizr.touch) {
					$("body").addClass('mobile');
					if (!!isWebView) {
						$("body").addClass('webview');
					}
				}

				


				//-> bug fix, always catch app registration clicks, YAY! 
				CatchListItemClick();

			}
			//-->> FLOWTRACK June 16, 2015
			//-->> CAN only come through here when domain list has finished its initialization and loading
			else {
				//-->> THIS is set within toggleApp, therefore, we're in the process of showing event form if we are indeed true to AppVisible == 0 at this point in time in the flow
				//-->> HOWEVER we must keep in mind of this being here, for we don't want to trip this under any other circumstance
				if (AppVisible == 0) {
					//-->> BUGTRACK June 16, 2015
					//-->> MOVED FROM OUTSIDE THE 'AppLoading == 1 test'
					$("#DocumentTitle").css('display','inline-block').show();
				 	//$("#VirtualPrivateActivity").html('');
					//$("#VirtualPrivateActivity").hide();
					$("#VirtualPrivateButtons").show();
					//-->> FLOWTRACK June 16, 2015
					toggleMainMenuIcon('default');
				}
			}
			
			//-> run touch focus here as well, considering we just created menulines, need to remake it at loadttime 
			//-->> BUGTRACK June 16, 2015
			//-->> WHY do we have SetTouchFocus here? 
			//-->> ALREADY being called when we create menulines, or in essence, during a toggleMainMenuIcon('loading') or toggleMainMenuIcon('default') call
			//-->> REMOVED
			//-->> SetTouchFocus();

			NowShowingButtons = 0;
			
			//-> reset timer 
			ButtonShowingSpeed = 500;
			clearTimeout(ButtonHidingTimer);
		//});
	}
};

var refreshTrigger = function() {
						//->only if app has finished loading
						if (AppLoading == 0) {
							toggleMainMenuIcon('loading');
							$("#app-list").empty();
							appListScroll.refresh();
							hideAppMenu();
							getMySavedDomainNames();
							window.setTimeout(function(){
								toggleMainMenuIcon('default');
							},500);
						}
};

var OrderByMeOptions = new Array('OrderByChronologically-DESC','OrderByChronologically-ASC','OrderByDomain-Name-asc','OrderByDomain-Name-desc');
var AppOptionMarkup = '<div class="menu-content-spacer sub"></div><label for="%%OPTION_NAME%%" class="CheckboxLabel"><div class="child"><fieldset class="GeneralInformationField KeyPressCheckbox" style="font-size: initial;padding:0;border:0;background:none;"><div class="RightBorderDivider" style="font-size: 20px;">%%OPTION_TEXT%%</div><div class="OrderBy"><div class="CommonCheckbox"><input id="%%OPTION_NAME%%" type="checkbox" value="%%OPTION_VALUE%%" name="%%OPTION_NAME%%" tabindex="3" style="display:none;"><div class="icon">%%FA_ICON%%</div></div></div></fieldset></div></label>';

var getAndSetAppOptions = function() {
	for(var i = 0; i<OrderByMeOptions.length; i++){
		var MyAppOptionMarkup = AppOptionMarkup.replace(/%%OPTION_NAME%%/g,OrderByMeOptions[i]).replace('%%OPTION_TEXT%%',OrderByMeOptions[i].replace('OrderBy','').replace(/-/g,' ').replace('asc',' (ascending: a-z)').replace('desc',' (descending: z-a)').replace('ASC',' (as added: old to new)').replace('DESC',' (as added: new to old)'));
		MyAppOptionMarkup = MyAppOptionMarkup.replace('%%OPTION_VALUE%%','0').replace('%%FA_ICON%%','<i class="fa fa-square-o fa-2x"></i>');
		$('#AppOptions').append(MyAppOptionMarkup);
	}
	activateAppOptionSwitches();
};
var AllRegistrars;
var getAndSetRegistrars = function() {
	$.ajax({
		contentType: "application/json; charset=utf-8",
		url: ''+ MyAppProcessor + '?GetRegistrars=1',
		dataType:'jsonp',
		success: function(o) {
			if (o.success && o.registrars) {
				AllRegistrars = o.registrars;
			}
		}
	});
};

var activateAppOptionSwitches = function() {
	$(document).on(EVENT_CONFIG.CLICK, 'label[for=OrderByDomain-Name-asc], label[for=OrderByDomain-Name-desc], label[for=OrderByChronologically-ASC], label[for=OrderByChronologically-DESC]', function (e) {
	//-WAS
	//-$("label[for=OrderByDomain-Name-asc], label[for=OrderByDomain-Name-desc], label[for=OrderByChronologically-ASC], label[for=OrderByChronologically-DESC]").click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		//-> if isn't hidden 
		if (!$(this).parent().hasClass('hidden')) {
			$(this).parent().addClass('hidden');
		}
		
		$(this).parent().find('.righter').removeClass('fa-chevron-up').addClass('fa-chevron-down');
		//-> deactivate any child which has been clicked/activated 
		$(this).parent().find('.child.active').removeClass('active');

		OrderBySwitch($(this).attr('for').toString());
	});
	
	$(document).on(EVENT_CONFIG.CLICK, '#OrderByDomain-Name-asc, #OrderByDomain-Name-desc, #OrderByChronologically-ASC, #OrderByChronologically-DESC', function (e) {
	//-WAS
	//-$("#OrderByDomain-Name-asc, #OrderByDomain-Name-desc, #OrderByChronologically-ASC, #OrderByChronologically-DESC").click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		$("label[for="+$(this).attr('id')+"]").click();
	});
};


var AppMenuClickHandlerSet = 0;
var flyInMenuScroll;
var toggleAppMenu = function() {
	//-> toggles AppMenu on an off 
	//--> OLD VERSION
	//--> $("#AppMenu").css('display',($("#AppMenu").css('display') == 'none')?"block":"none");
	$("#FlyInMenu").css('display',($("#FlyInMenu").css('display') == 'none')?"block":"none");
	$("#FlyInMenu").css('right',($("#FlyInMenu").css('display') == 'none')?"-480px":"0px");
	$("header, footer, #AppList").animate().css('margin-left',($("#FlyInMenu").css('display') == 'none')?"":"-480px");
	
	
		//-> if ChangeLog not empty but #WhatsNew is, meaning first run only 
		if (ChangeLog != '' && $("#WhatsNew .LogEntry").length <= 0) {
			$("#WhatsNew").empty();
			ChangeLog = ChangeLog.split("\n\n\n");
			var TheChangeLog = '';
			for (i=0; i < ChangeLog.length; i++) {
				AChangeLog = ChangeLog[i].split("\n\n");

				for (i2=0; i2 < AChangeLog.length; i2++) {
					//--> app version and its release date, 1st line of any log entry
					if (i2 == 0) {
						var firstOne = (i >= 1)?'notfirst':'';
						ACLS = AChangeLog[i2].split("\n");
						//-> get rid of empty space bug 
						if (ACLS[0] == '') { ACLS.shift(); }
						
						//-> set app verison to first log's version, and only if its not empty as well as still set to our default, meaning it hasn't been updated by the end-user's mobile app version, which may differ from the latest version posted in the change.log file 
						if (i == 0) { 
							//-> considering this string will look like so: 0.07.0_0000 2015 07 23, we format it for purpose of display 
							
							if (ACLS[0].indexOf('_') != -1) {
								FindAppVersion = ACLS[0].split('_');
								DefineAppVersion = FindAppVersion[0].split('.');
								FullAppVersion = FindAppVersion[0].split(' ')[0];

								DefineMobileAppVersion = FindAppVersion[1].split(' ')[0].split('.');
								FullMobileAppVersion = FindAppVersion[1].split(' ')[0];
							}
							else {
								DefineAppVersion = ACLS[0].split('.');
								FullAppVersion = ACLS[0].split(' ')[0];
							}
							
//								alert('DefineAppVersion: ' + DefineAppVersion + ' FullAppVersion:' +FullAppVersion+ 'DefineMobileAppVersion: ' + DefineMobileAppVersion + ' FullMobileAppVersion:' +FullMobileAppVersion+ '');
							//-> anything before the underscore(_) is the web-based application version, whilst anything after is mobile app version 
							if (!!isWebView) {
								FullAppVersion = FullAppVersion.replace('_','.');
							}
							//-> therefore, for non-WebView(app) users, we don't show the mobile app version, just the web-based application version 
							else {
								RedefineVersion = DefineAppVersion[1].split('_')[0];
								DefineAppVersion[1] = RedefineVersion;
								FullAppVersion = FullAppVersion.split('_')[0];
							}
							
							AppVersion = 'v' + DefineAppVersion[0] + '.' + DefineAppVersion[1];
							//alert(ACLS[0] + ' to ' + AppVersion + ' and ' + FullAppVersion);
						}
						//ACLS[0] = '<div class="LogTitle">'+ ACLS[0] +'</div>';
						//ACLS[1] = '<div class="LogDate">'+ ACLS[1] +'</div>';
						//AChangeLog[i2] = ACLS.join('');
						AChangeLog[i2] = '<div class="LogTitle">Build '+ ACLS[0].split(' ')[0] +'<span class="log-date right-float">'+ACLS[0].split(' ')[1]+'</span></div>';

						$("#WhatsNew").append('<div class="LogEntry '+firstOne+'" rel="'+i+'">'+AChangeLog[i2]+'</div>');
					}
					//--> app description, anything beyond the 1st line of any log entry
					else {
						var LogData = AChangeLog[i2];
						//--> if our data is indeed a list
						if (AChangeLog[i2].indexOf('- ') != -1 && AChangeLog[i2].indexOf("\n") != -1) {
							//-> find DescriptionAreaTitle for our DescriptionArea(LogArea), if exists 
							var DescriptionAreaTitle = '';
							var shifted = AChangeLog[i2].split('\n');
							//-> if first item of DescriptionArea(LogArea) doesn't have a dash, we take it as being the DescriptionAreaTitle for our list 
							if (shifted[1].substring(0,1) != '-') {
								//-> format our DescriptionAreaTitle for display 
								DescriptionAreaTitle = '<div>' + shifted[1] + '</div>';
								//-> now remove the DescriptionAreaTitle from our list, to parse the rest cleanly 
								AChangeLog[i2] = AChangeLog[i2].split(shifted[1])[1];
							}
							AChangeLog[i2] = '<ul class="change-type"><li>' + AChangeLog[i2].split("\n  - ").join('</li><li>') + '</li></ul>';
							LogData = DescriptionAreaTitle + '<ul class="description-section">' + AChangeLog[i2].split("\n- ").join('</ul><ul class="description-list-item">') + '</ul>';
							SubList = '';
							TopSubList = '';
							SubSubList = '';
						}
						$("#WhatsNew .LogEntry[rel="+i+"]").append('<div class="LogData">'+LogData+'</div>');
						$("#WhatsNew .LogEntry[rel="+i+"] .LogData .description-section").each(function(i){
							$(this).find('ul.description-list-item').each(function(i) {
								imup = i++;
								$(this).addClass('n-'+Number(imup+1)+'');
								//console.log('IMUPPPPPPPPP:'+Number(imup+1));
							});
						});
						
					}
				}
				$("#WhatsNew .LogEntry[rel="+i+"] ul").each(function(){ if ($(this).text().length <= 0) { $(this).remove(); } });
				$("#WhatsNew .LogEntry[rel="+i+"] ol").each(function(){ if ($(this).text().length <= 0) { $(this).remove(); } });
			}
			$("#FlyInMenuHeader .version").html(AppVersion).attr('rel',FullAppVersion);

		}
	
	
	eHeader = $("header");
	eList = $("#AppList");
	$("#FlyInMenu").css({'height':''+Number(eHeader.height()) + Number(eList.height())+'px'});
	$("#FlyInMenuContentWrapper").css({'height':''+eList.height()+'px'});
	flyInMenuScroll = new IScroll('#FlyInMenuContentWrapper');
	AppMenuClickHandler();
	
};

function cleanArray(actual){
  var newArray = new Array();
  for(var i = 0; i<actual.length; i++){
      if (actual[i]){
        newArray.push(actual[i]);
    }
  }
  return newArray;
}

var hideAppMenu = function() {
	//-> find all lists with 'extra' content aka: sub-menu items 
	$("#FlyInMenuContent .menu-content .menu-content-item.extra").each(function(){
		//-> if isn't hidden 
		if (!$(this).hasClass('hidden')) {
			$(this).addClass('hidden');
		}
		$(this).find('.righter').removeClass('fa-chevron-up').addClass('fa-chevron-down');
		//-> deactivate any child which has been clicked/activated 
		$(this).find('.child.active').removeClass('active');
		flyInMenuScroll.refresh();
	});
	//-> toggles AppMenu on an off 
	//--> OLD VERSION
	//--> $("#AppMenu").css('display','none');
	$("#FlyInMenu").css('display','none');
	$("#FlyInMenu").css('right','-480px');
	$("header, footer, #AppList").css('margin-left','');
};

var OrderBySwitchScrollerOffset = 0;
var AppMenuClickHandler = function() {
	if (AppMenuClickHandlerSet == 0) {
		AppMenuClickHandlerSet = 1;
		//-> only if AppMenu displayed 
		if ($("#FlyInMenu").css('display') == 'block') {
			//-> clicks upon elements hide AppMenu
			$(document).on(EVENT_CONFIG.CLICK, '.main-menu', function (e) {
			//-WAS
			//-$(".main-menu").click(function(){
				hideAppMenu();
			});
			$(document).on(EVENT_CONFIG.CLICK, '.ps-scrollbar-y', function (e) {
				hideAppMenu();
			});
			$(document).on(EVENT_CONFIG.CLICK, '#FlyInMenuHeader .back-to-list', function (e) {
				hideAppMenu();
			});


			$(document).on(EVENT_CONFIG.CLICK, '#FlyInMenuContent .menu-content .menu-content-item.extra .inner', function (e) {
			//-WAS
			//-$("#FlyInMenuContent .menu-content .menu-content-item.extra .inner").click(function(){

				if ($(this).parent().hasClass('hidden')) {
					$(this).parent().removeClass('hidden');
					$(this).parent().find('.righter').removeClass('fa-chevron-down').addClass('fa-chevron-up');
				}
				else {
					$(this).parent().addClass('hidden');
					$(this).parent().find('.righter').removeClass('fa-chevron-up').addClass('fa-chevron-down');
					//-> deactivate any child which has been clicked/activated 
					// $(this).parent().find('.child.active').removeClass('active');
				}
				
				OrderBySwitchScrollerOffset = $("#FlyInMenuContent").offset().top - 61;
				//console.log(OrderBySwitchScrollerOffset);
				flyInMenuScroll.refresh();
			});

			
			$(document).on(EVENT_CONFIG.CLICK, '#FlyInMenuContent .menu-content .menu-content-item.extra .child', function (e) {
			//-WAS
			//-$("#FlyInMenuContent .menu-content .menu-content-item.extra .child").click(function(e){
				//-> deactivate any sibling(child) which has been clicked/activated 
				$(this).parent().find('.child.active').removeClass('active');
				//-> deactivate any sibling(child) which has been clicked/activated 
				$(this).addClass('active');
			});
			
			$(document).on(EVENT_CONFIG.CLICK, 'label[for=SaveTaken]', function (e) {
				e.preventDefault();
				e.stopPropagation();
				SaveTaken();
			});
			$(document).on(EVENT_CONFIG.CLICK, '#SaveTaken', function (e) {
				e.preventDefault();
				e.stopPropagation();
				$("label[for=SaveTaken]").click();
			});


		}
	}
};


var NowHidingButtons = 0;
var IncomingActivity = '';
var NoLoaderImage = 0;
var HideButtonsShowActivity = function() {
	//-X> console.log('HideButtonsShowActivity');
		//-> only one call at a time, no hiccups in the process, hence panels with info behind shown buttons 
		if (NowShowingButtons == 0 && NowHidingButtons == 0) {
			NowHidingButtons = 1;
			//$("#VirtualPrivateButtons").stop().animate({top: "-40px"}, 1,function() {
				$("#VirtualPrivateButtons").hide();
			//});
			//$("#VirtualPrivateActivity").html('');
		}
};

	var AppDomainListing = [];
	var AppDomainListingObject = function(eventcreator, url, created, lastmodified, dtstamp, dtstart, dtend, uid, sequence, summary, description, location, rrule, allday, ics) {
		// console.log('AppDomainListObject');
		return AppDomainListing[0] = {
			eventcreator: eventcreator, 
			url: url, 
			created: created,
			lastmodified: lastmodified,
			dtstamp: dtstamp,
			dtstart: dtstart,
			dtend: dtend,
			uid: uid,
			sequence: sequence,
			summary: summary,
			description: description,
			location: location,
			rrule: rrule,
			ics: ics
		}
	};

	var DomainExtentionList = [];
	var DomainExtentionListObject = function(level, extension, supported) {
		return DomainExtentionList[0] = {
			level: level, 
			extension: extension,
			supported: supported
		}
	};	

	var SearchTimer = '';
	var clickedResult = 0;
	var WebSearchBlur = '';
	var lastSearchString = '';

	var liveSearchMe = function() {
		//-> console.log('liveSearchMe');
		$("#WebSearch").focus(function(e){
			console.log($("#SearchResultsWrapper").length + ' XXX ' + $(e).value);
			//-> if SearchResultsWrapper pane doesn't exist or our search value NOT present or search value IS present and value equals mydomain.com
			focusedOnSearch(e);

			//-> if we come into focus and our last search term is still in place, run a search against it 
			if ($("#WebSearch").val().toString().length >= 1) {
				// searchIt($("#WebSearch"));
			}
			else {
				// clearSearchPane();
			}
		});


		$("#WebSearch").blur(function(e){
			//-X> console.log('#WebSearch blurred');
			if (WebSearchBlur != '') {
				clearTimeout(WebSearchBlur);
				WebSearchBlur = '';
			}
			if (SearchTimer == '') {
				WebSearchBlur = window.setTimeout(function(){
					if ($("#WebSearch").val().toString().length <= 0) {
						 $("#SearchResultsWrapper").remove();
				 		 //$("#QuickSearch .fa-times-circle").remove();
						$("li#mainsubmit input").css('display','none');
						$("#WebSearch").css({'padding-right':'15px'});

						toggleMainMenuIcon('default');
					}
					else if ($("#WebSearch").val().toString().length >= 1 && $("#SearchResultsWrapper").length >= 1 && !($("#SearchResultsWrapper").hasClass('noblur'))) {
						//-> give ourselves some time to figure if we are ready for blur, if so kill search results 
						$(this).timeout = setTimeout(function(){
							 // $("#SearchResults").remove();
							 $("#SearchResultsWrapper").removeClass('noblur');
						},250);
					}
				},200);
			}

		});

		$("#WebSearch").keyup(function(e) {
			if (isRegistering == 1) {
				clearEntireSearch();
			}
			//-> bug when reSearch is called, in that we lose our SearchResults screen, check for it, and if missing, add it 
			if ($("#SearchResultsWrapper").length <= 0 || !$(e).value || (!!$(e).value && ($(e).value == 'mydomain.com'))) {
				focusedOnSearch(e);
			}
			if ($("#WebSearch").val().toString().length >= 1) {
				//-> run search against entry 
				searchIt(e);
			}
			else {
				clearSearchPane();
			}
		});
		
		$("#WebSearch").change(function(e) {
			if (isRegistering == 1) {
				clearEntireSearch();
			}
			//-> bug when reSearch is called, in that we lose our SearchResults screen, check for it, and if missing, add it 
			if ($("#SearchResultsWrapper").length <= 0 || !$(e).value || (!!$(e).value && ($(e).value == 'mydomain.com'))) {
				focusedOnSearch(e);
			}
			if ($("#WebSearch").val().toString().length >= 1) {
				//-> run search against entry 
				searchIt(e);
			}
			else {
				clearSearchPane();
			}
		});
		
	};
	
	var focusedOnSearch = function(e) {
		if ($("#SearchResultsWrapper").length <= 0 || !$(e).value || (!!$(e).value && ($(e).value == 'mydomain.com'))) {
			$(e).value = '';
			if ($("#SearchResultsWrapper").length <= 0) {
				$("#AppList").prepend('<div id="SearchResultsWrapper" class="seethrough-pane"><div id="SearchResults" style="overflow:hidden;"></div></div>');
				$("li#mainsubmit input").css('display','none');
				$("#WebSearch").css({'padding-right':'15px'});
			}
			eForm = $("#AppList");
			//.$("#SearchResults").css({'width':''+eForm.width()+'px','height':''+eForm.height()+'px'});
			$("#SearchResults").css({'width':''+eForm.width()+'px'});
			//$("#QuickSearch .fa-times-circle").remove();
		}
		//-> set background and font color for WebSearch input field, while in focus
		$(e).css('background-color','rgb(252,252,252)').css('color','rgb(17,17,17)');
	};

	var clearSearchPane = function() {
		//-X> console.log('clearSearchPane');
		if ($("#SearchResultsWrapper").hasClass('cover-pane')) {
			$("#SearchResultsWrapper").removeClass('cover-pane');
		}
		$("#SearchResults").html('');
		$("li#mainsubmit input").css('display','none');
		$("#WebSearch").css({'padding-right':'15px'});
		isRegistering = 0;
	};
	var clearEntireSearch = function() {
		clearSearchPane();
		$("#SearchResultsWrapper").removeClass('noblur');
		$("#SearchResultsWrapper").remove();
		//--> Clear Search Term(s)
		$("#WebSearch").val('');
		if ($("#WebSearch").is(":focus")) { $("#WebSearch").blur(); }
		//$("#QuickSearch .fa-times-circle").remove();
		$("li#mainsubmit input").css('display','none');
		$("#WebSearch").css({'padding-right':'15px'});
		resetSearch();
		toggleMainMenuIcon('default');
	};
	var AmSearching = 0;
	var searchIt = function(e) {
		AmSearching = 1;
		//-X> console.log('searchIt');
		if ($("#WebSearch").val().toString().length >= 1) {
			if ($("#SearchResultsWrapper").length >= 1) {
				$("#SearchResultsWrapper").addClass('cover-pane');
			}
			if ($(".app-menu-wrapper a").find('.fa-plus-square-o').length <= 0) {
				toggleMainMenuIcon('cancel');
			}
			//-> undermine overflow of typed search input by dynamically setting padding-right of input field, to take into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field
			$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});
			$("li#mainsubmit input").css('display','inline-block');
		}

		// $('input#WebSearch').keyup(function (e) {
			if ($("#WebSearch").hasClass('must-clear')) {
				resetSearch();
				//reSearch();
			}
			else {
				if (e.keyCode == 13) {
					toggleMainMenuIcon('loading');
					runDomainSearch(document.forms["QuickSearch"]);
					return false;
				}
				//-> backspace/del 
				//-> if keycode is backspace(8) and lastSearch is not empty 
				//else if (e.keyCode == 8 && lastSearch != '') {
					//clearSearchPane();
					//reSearch();
					//lastSearch = '';
					//alert('delete search field');
				//}
				else {
					//-> 2016
					var wsval = $("#WebSearch").val().toLowerCase();
					$("#WebSearch").val(wsval.replace(/[^a-z-.]/gi, ''));
					
					// if truly a possible domain name, meaning meets minimal requirements, name, period and extension
					if ((/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$/.test($("#WebSearch").val())) || (/(?:\.[a-zA-Z]{1,})+$/.test($("#WebSearch").val()))) {
						// lastSearchString allows us to negate recurrence of run due to unfocus/refocus type events
						if (lastSearchString == '' || lastSearchString != $("#WebSearch").val()) {
							associativeSearch();
						}
					}
					else {
						if (isSubdomain($("#WebSearch").val())) {
							// lastSearchString allows us to negate recurrence of run due to unfocus/refocus type events
							if (lastSearchString == '' || lastSearchString != $("#WebSearch").val()) {
								associativeSearch();
							}
						}
						else {
							$("#SearchResults .search-results-row.extension").remove();
							$("#SearchResults .search-results-row.exact").remove();
							console.log('IS NOT');
						}
					}
					lastSearchString = $("#WebSearch").val();
				}
				//-> countCPM = how many times reSearch has been called, so by removing one from that count to get true amount of total times searched 
				searchReport(countCPM-1);
			}
		// });
			
	};
var isSubdomain = function(url) {
	if (!!url) {
		//-> 
		//->	min .[1]
		//->	min2 .[2].
		//->
		var regex = new RegExp(/^([a-z]+\:\/{1})?([\w-]+\.[\w-]+\.)$/);
		return !!url.match(regex); // make sure it returns boolean
	}
	return false;
};
var resetSearch = function() {
	if (lastSearch != $("#WebSearch").val()) {
		$("#WebSearch").removeClass('must-clear');
		$("#mainsubmit").empty().html('<input type="submit" value="Find Domain">');
		lastSearch = '';
		lastSearchString = '';
		//-> remove all old .domain-name-search results content
		$(".domain-name-search").remove();
		if (searchPaneScroll != '') {
			searchPaneScroll.refresh();
			searchPaneScroll.destroy();
			searchPaneScroll = '';
		}
		//-> update the 'You entered: xxx' display
		$("#SearchResults .search-results-row.entered strong").html($("#WebSearch").val());
		$("li#mainsubmit input").css('display','none');
	}
};
var associativeSearch = function() {
	var extension;
	var exact = new Array();
	var match = new Array();
	var filter = extension, countFound = 0, countParsed = 0, matching, entered;
	$("#SearchResults .search-results-row.similar").remove();

	$.each(DomainExtentionList, function(idx, obj) {
		var extensionLevel = obj.level.toString();
		var extension = obj.extension.toString();
		var extensionSupported = obj.supported.toString();
		var aValue = $("#WebSearch").val().split('.');
		aValue.shift();
		entered = '.'+aValue.join('.');
		if ($("#WebSearch").val().toString().indexOf('.') != -1) {
			matching = '.'+aValue.join('.');
			if (extension == matching) {
				console.log('exact: '+matching + ' ' + extension);
				exact.push(extension);
				countFound++;
			}
			else if (extension.indexOf(matching) != -1) {
				console.log('match: '+matching + ' ' + extension);
				match.push(extension);
				countFound++;
			}
		}
	});
	if (exact.length == 1) {
		console.log(exact.length + ' ||| ' + entered.length);
		if ($("#SearchResults .search-results-row.entered strong").length >= 1) {
			if ($("#SearchResults .search-results-row.exact strong").length >= 1) {
				$("#SearchResults .search-results-row.exact strong").html(entered);
			}
			else {
				$('<div class="search-results-row exact">Exact match: <strong>'+entered+'</strong><div>').insertAfter("#SearchResults .search-results-row.extension");
			}
		}
	}
	else {
		$("#SearchResults .search-results-row.exact").remove();
	}
	
	if (countFound >= 1) {
		if ($("#SearchResults .search-results-row.entered strong").length >= 1) {
			if ($("#SearchResults .search-results-row.extension strong").length >= 1) {
				$("#SearchResults .search-results-row.extension strong").html(entered);
			}
			else {
				$('<div class="search-results-row extension">Extension entered: <strong>'+entered+'</strong><div>').insertAfter("#SearchResults .search-results-row.entered");
			}
		}
		if (match.length >= 1) { $("#SearchResults").append('<div class="search-results-row similar"><span style="position:relative;float:left;">Similar extensions:&nbsp;</span><span style="position:relative;float:left;font-weight:bold;">'+match.join(',&nbsp;</span><span style="position:relative;float:left;font-weight:bold;">')+'</span></div>'); }
	}
	return countFound;
};

var searchReport = function(count) {
		if ($("#SearchResults .search-results-row.entered strong").length >= 1) {
			$("#SearchResults .search-results-row.entered strong").html($("#WebSearch").val());
		}
		else {
			$("#SearchResults").html('<div class="search-results-row entered">You entered: <strong>'+$("#WebSearch").val()+'</strong><div>');
		}
	if (SearchTimer != '') {
		clearTimeout(SearchTimer);
		SearchTimer = '';
	}
	AmSearching = 0;
};



var isValidEmailAddress = function(emailAddress) {
		//-X> console.log('isValidEmailAddress');
	var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};

var ReloadHome = function() {
	//-X> console.log('ReloadHome');
	MyHREF = parent.location.href;
	MyHREF = MyHREF.split("?");
	//-> reassignWebView allows us to do just that, forward the wvc(WebViewCall) to our document reload 
	reassignWebView = '';
	if (!!isWebView) { reassignWebView = '&wvc=1'; }
	parent.location.href = ''+ MyHREF[0] +'?'+ new Date().getTime() + '' + reassignWebView;
};

var KillButtons = 0;


	window.addEventListener('load', function() {
		var textInput = document.querySelector('input');

		FastClick.attach(document.body);
		Array.prototype.forEach.call(document.getElementsByClassName('firstFocus'), function(testEl) {
			testEl.addEventListener('click', function() {
				textInput.focus();
			}, false)
		});
	}, false);


var OrderBySwitch = function(WhichOrderBy) {
	//-X> console.log('OrderBySwitch');
	//-> if OrderByType not empty, then we append it to the name of the option, to make data tracking easier 
	//-> if (OrderByType != '') { OrderByType = '-' + OrderByType; } 

	$("#"+WhichOrderBy+"").val(($("#"+WhichOrderBy+"").val() == '1')?'0':'1');
	if ($("#"+WhichOrderBy+"").val() == '0') {
		$("label[for="+WhichOrderBy+"] .OrderBy .CommonCheckbox .icon").html('<i class="fa fa-square-o fa-2x"></i>');
	}
	else {
		$("label[for="+WhichOrderBy+"] .OrderBy .CommonCheckbox .icon").html('<i class="fa fa-check-square fa-2x"></i>');
	}

	if (!!OrderBySwitchScrollerOffset) { 
		flyInMenuScroll.refresh();
		flyInMenuScroll.scrollTo(0,OrderBySwitchScrollerOffset);
	}
	
	MakeOrderBySwitch(WhichOrderBy);
	
	if ($("#FlyInMenu").css('display') == 'block') {
		hideAppMenu();
	}

	if (TotalNumberOfSavedDomains >= 2) {
		sortTheAppList(WhichOrderBy);
		// refresh the scroller on the list
		appListScroll.refresh();
		
		//--> make this domain registerable
		$(document).on(EVENT_CONFIG.CLICK, '.my-domains.saved-domain.available', function (e) {
			initiateRegistration($(this).find('.data .subject').attr('id'));
		});

	}


	//-X> console.log('OrderBySwitchURL:'+""+MyAppProcessor+"?Callback=1&Organizer="+$("#Organizer").val()+"&SetAppOption=1&AppOptionName="+WhichOrderBy+"&AppOptionValue="+$("#"+WhichOrderBy+"").val()+"&"+new Date().getTime()+""+'');
};
var MakeOrderBySwitch = function(WhichOrderBy) {
	$("#OrderByMe").html(cImageSrcToo.replace('fa-3x ',''));

	//jQuery.ajax({
	//	crossDomain: 'true',
	//	url: ""+MyAppProcessor+"?Callback=1&Organizer="+$("#Organizer").val()+"&SetAppOption=1&AppOptionName="+WhichOrderBy+"&AppOptionValue="+$("#"+WhichOrderBy+"").val()+"&"+new Date().getTime()+"",
    //  	cache: false,
	//    type: "GET",
	//}).done(function (response) {
		//-> only if successful do we continue with clean our list 
		//if (response == 'success') {
			//-> deselecting an option: if no other options are selected, select the default 
			if ($("#"+WhichOrderBy+"").val() == '0') {
				CheckForEmptyOrderBy();
			}
			//-> selecting an option 
			else {
				$("#OrderByMe").html('by ' +$("#"+WhichOrderBy+"").attr('id').toString().replace('OrderBy','').replace(/-/g,' ').replace('asc','(a-z)').replace('desc','(z-a)').replace('ASC',' (old to new)').replace('DESC',' (new to old)').replace('Chronologically','Chronological Order'));
				
				$("#FlyInMenuContent .OrderBy input").each(function(){
					//-> find any options that are selected, then force an unselect on them 
					if ($(this).attr('id') != WhichOrderBy && $(this).val() == '1') {
						ClearLastOrderBy($(this).attr('id'));
					}
				});

			}
		//}
	//});

};
var CheckForEmptyOrderBy = function() {
	//-> if no other options are selected in the list, select the default 
	if ($("#FlyInMenuContent .OrderBy input[value=1]").length == 0) {
		OrderBySwitch(OrderByMeOptions[0]);
	}
};
var ClearLastOrderBy = function(ClearWho) {
	//jQuery.ajax({
	//	crossDomain: 'true',
	//	url: ""+MyAppProcessor+"?Callback=1&Organizer="+$("#Organizer").val()+"&SetAppOption=1&AppOptionName="+ClearWho+"&AppOptionValue=0&"+new Date().getTime()+"",
	//	cache: false,
	//	type: "GET",
	//}).done(function (response) {
		$("#"+ClearWho+"").val('0');
		$("label[for="+ClearWho+"] .OrderBy .CommonCheckbox .icon").html('<i class="fa fa-square-o fa-2x"></i>');
		flyInMenuScroll.refresh();
	//});
};

//-> we save taken for use during session only, not on the server side 
var SaveTakenDomains = 0;
var UpdatingDomainListDisplay = 0;
//-> user must set 'save taken domains automatically' with every new session 
var SaveTaken = function() {
	if (UpdatingDomainListDisplay == 0) {
		UpdatingDomainListDisplay = 1;
		//-X> console.log('SaveTaken');
		
		$("#SaveTaken").val(($("#SaveTaken").val() == '1')?'0':'1');
		instantiateSaveTakenSwitch();
		hideAppMenu();
		
		appListScroll.refresh();
		
		UpdatingDomainListDisplay = 0;
	}
};

var instantiateSaveTakenSwitch = function() {
	if ($("#SaveTaken").val() == '0') {
		$(".SaveTaken .CommonCheckbox .icon").html('<i class="fa fa-square-o fa-2x"></i>');
		SaveTakenDomains = 0;
	}
	else {
		$(".SaveTaken .CommonCheckbox .icon").html('<i class="fa fa-check-square fa-2x"></i>');
		SaveTakenDomains = 1;
	}
};


//-> LOADER IMAGE START 
var cSpeed=8;
var cWidth=100;
var cHeight=100;
var cTotalFrames=12;
var cFrameWidth=100;
var cImageSrc='<i class="loader fa fa-cog fa-spin fa-5x fa-fw margin-bottom" style="color:rgba(71,71,71,0.2);"></i><div class="domapp-loading">DOMapp loading...</div>';
var cImageSrcToo='<i class="loader fa fa-cog fa-spin fa-3x fa-fw margin-bottom" style="color:rgba(71,71,71,0.2);"></i>';
var cImageTimeout=false;
var cIndex=0;
var cXpos=0;
var cPreloaderTimeout=false;
var SECONDS_BETWEEN_FRAMES=0;
var loaderTarget = 'loaderImage';

var startAnimation = function() {
		//-X> console.log('startAnimation');
	if (loaderTarget == 'LoginLoader') { 
		//document.getElementById(loaderTarget).style.backgroundImage='url('+cImageSrcToo+')';
		$('#'+loaderTarget+'').html(cImageSrcToo);
	}
	else {
		//document.getElementById(loaderTarget).style.backgroundImage='url('+cImageSrc+')';
		//$('#'+loaderTarget+'').css('background-image','url('+cImageSrc+')');
		$('#'+loaderTarget+'').html(cImageSrc);
	}
	//$('#'+loaderTarget+'').css('width',''+cWidth+'px');
	
	//$('#'+loaderTarget+'').css('height',''+cHeight+'px');
	

	//FPS = Math.round(100/(maxSpeed+2-speed));
	//FPS = Math.round(100/cSpeed);
	//SECONDS_BETWEEN_FRAMES = 1 / FPS;
	//cPreloaderTimeout=setTimeout('continueAnimation()', SECONDS_BETWEEN_FRAMES/1000);
};
	
var continueAnimation = function(){
	//cXpos += cFrameWidth;
	//increase the index so we know which frame of our animation we are currently on
	//cIndex += 1;
	//if our cIndex is higher than our total number of frames, we're at the end and should restart
	//if (cIndex >= cTotalFrames) {
	//	cXpos =0;
		//cIndex=0;
	//}
	//if(document.getElementById(loaderTarget))
	//	document.getElementById(loaderTarget).style.backgroundPosition=(-cXpos)+'px 0';
		
	//cPreloaderTimeout=setTimeout('continueAnimation()', SECONDS_BETWEEN_FRAMES*1000);
};
	
var stopAnimation = function(){
		//-X> console.log('stopAnimation');
		$("#loadtime").remove();
	clearTimeout(cPreloaderTimeout);
	cPreloaderTimeout=false;
};
	
var imageLoader = function(s, fun) {
		//-X> console.log('imageLoader');
	clearTimeout(cImageTimeout);
	cImageTimeout=0;
	$('#'+loaderTarget+'').html(s);
	cImageTimeout=setTimeout(fun, 0);
};
//-> LOADER IMAGE END


//-> START LOGIN FORM 
var TheImageLoader = '';
//var WebSearch;
//var RegisterNowCall;
//var ViewAccountCall;
//var ViewNoteRequest;

var isWebView;
var isIframed;

var OnlyShowInitialSearchForm;

var AutoLogoutMinion = '';
var LogoutExecutor = '';

$(document).ready(function() {

	// WebSearch = getParameterByName('websearch');
	//RegisterNowCall = getParameterByName('newevent');
	//ViewAccountCall = getParameterByName('vpn');
	isWebView = getParameterByName('wvc');
	isIframed = getParameterByName('iframed');
	AppVersion = getParameterByName('ver');

	if (!!AppVersion && (AppVersion != '0.0.0' && AppVersion.indexOf('.') == 1)) {
		fullAppVersion = AppVersion.split('.');
		if (!isNaN(fullAppVersion[0]) && !isNaN(fullAppVersion[1])) {
			$('.welcome-prompt .version').html($('.welcome-prompt .version').html() + '.'+Number(fullAppVersion[0]) +'.'+ Number(fullAppVersion[1]));
			$('.welcome-prompt .version').attr('rel',$('.welcome-prompt .version').attr('rel') +'_' + AppVersion);
		}
	}

	isWebViewInteractiveLogin = getParameterByName('iisearch');

	OnlyShowInitialSearchForm = getParameterByName('DisplayInitialSearchForm');
	
	//if (!!isWebViewInteractiveLogin && !!window.parent.document) {
		//alert('k');
		//window.parent.close();
	//}
	//-> not for chrome, but yes for webview (a variation of chromium)
	if (!!isWebView) {
		$('body').addClass('wvc');
	}
	if (!!isIframed) {
		//alert('am iframed');
		$('body').addClass('iframed');
	}

	
	//-> removed LOADER 2015 
	TheImageLoader = new imageLoader(cImageSrc, 'startAnimation()');
	if (!!OnlyShowInitialSearchForm) {
		toggleInitialSearchForm(1);
	}
	else {
		var ServerConnected = checkServerConnection();
	}
	$('#QuickSearch').submit(function(e){
		toggleMainMenuIcon('loading');
		runDomainSearch(document.forms["QuickSearch"]);
		return false;
	});

	
	//-> we only need type=url for mobile, hence the modified digital keyboard entry with domain centric input capability, if we don't do this, then prompts given to non-mobile device user, hence desktop chrome will see "Please enter a URL" even if entered 
	//-> "sign out" only for mobile devices 
	if (!Modernizr.touch) {
		$("#WebSearch").attr('type','text').removeAttr('pattern');
		//$("#FlyInMenu .app-refresh-spacer, #FlyInMenu .logout").css('display','none');
		$("#FlyInMenu .logout .inner").html('Restart application<i class="righter fa fa-gears fa-1_3x"></i>');
	}




	//-> get app change log 
	jQuery.ajax({
		crossDomain: 'true',
		url: ''+ MyAppProcessor + '?GetChangeLog=1',
      	cache: false,
	    type: "GET",
	}).done(function (response) {
		if (response.indexOf("Fixes") != -1 || response.indexOf("Updates") != -1 || response.indexOf("Pending") != -1) {
			ChangeLog = response;
		}
	});
	
	setViewport();
	SetTouchFocus();


	getAndSetAppOptions();
	getAndSetRegistrars();
	
});
var AutoLoginExecutor = function() {
	if ($("#ActivityModal").length <= 0) {
		$("body").prepend('<div id="ActivityModal" class="seethrough-pane" style=""></div>');
	}
	$("#ActivityModal").css({'width':'100%','height':'100%','position':'absolute','top':'0','left':'0'});
		
	CancelActionType = (Modernizr.touch)?'tap the screen':'move your mouse or use your keyboard';
	$('#ActivityModal').html('<div class="modal"><div class="modal-header">Automatic Logout in Progress</div><div class="modal-content">Your inactivity is set to automatically log you out. To stop this from happening, '+CancelActionType+'.</div><div>');
	LogoutExecutor = window.setTimeout(function(){
			//-X> console.log('auto logged out');
			AutoLogout = 1;
			logMeOut();
	},60000);
};
var SetTouchFocus = function() {
	//-X> console.log('SetTouchFocus');

	//-> cancels zooming upon focus ios/touch/mobile 
	//-> hint, simply kill the Modernizr.touch to test on all devices 
	if (Modernizr.touch) {
		//$('#metaviewport').prop('content',DefaultViewport);
		$("input[type=text], input[type=email], input[type=date], input[type=number], textarea, fieldset input").focus(function(){
			gva = getViewableArea();
			//$('footer').hide().css('position','absolute').css('bottom','').css('top',''+($(document).outerHeight()-40)+'px').show();
			$('header').hide().css('position','absolute').css('top','').show();
			//$('#metaviewport').prop('content',HardenedViewport);
		});
		$("input[type=text], input[type=email], input[type=number], textarea, fieldset input").blur(function(){
			//$('#metaviewport').prop('content',DefaultViewport);
			//$('footer').css('position','fixed').css('top','').css('bottom','0');
			$('header').css('position','fixed').css('bottom','').css('top','0');
		});
		
		
	}
	
	//-->> BUGTRACK June 16, 2015
	//-->> MOVED FROM ParseAppData to here, shouldn't have been there to begin with
	//-> when choosing different view, resize and reset our viewport 
	//-->> FIRES OFF MANY TIMES, OF COURSE, ONLY ON RESIZE OF SCREEN, WHILE BROWSER IS INSTANTIATING A RESIZE, FOR ANY PURPOSE, BUT ONLY DURING WINDOW RESIZE(MORESO ON MANUAL BROWSER WINDOW RESIZES) FOR PROGRAMMATIC ARE FAST AND ONLY FIRE OFF A FEW TIMES OF THIS EVENT, OR DOCUMENT RESIZE, SO NOT ALL THE TIME PER SE
	//-->> WILL LEAVE IT HERE FOR NOW. ITS A NECESSARY EVIL

	//-->> BUGTRACK June 18, 2015
	//-->> KILLER BUG!!!!!
	//-->> LOOKS TO BE CAUSING ISSUES ON IPHONE, ON RESIZE, FREEZES CLIENT WHILE THIS FUNCTION IS BEING PERFORMED WHICH MAY TAKE A LONG TIME IF CLIENT IS RESIZING ITS FRAME SIZE IN ANY WAY (HENCE SHOWING HIDING VIRTUAL KEYBOARD)
	//-->> MOVING BACK TO ITS ORIGINAL LOCATION

	
	//-->> BUGWHACK June 16, 2015
	$('textarea').elastic();
		
};



var ActiveAppName = '0.1';
var DomainExtensionData;
var TopLevelDomainExtensions;
var SecondLevelDomainExtensions;
var checkServerConnection = function() {
	//-X> console.log('checkServerConnection');
	//--> Adding the following here, gives us the following error:
	//--> Synchronous XMLHttpRequest on the main thread is deprecated because of its detrimental effects to the end user's experience. For more help, check http://xhr.spec.whatwg.org/.
	//--> jquery-1.9.1.js:8492
	//->
	//->	jQuery.ajax({
	//->		url: ''+ MyAppProcessor + '?GetAppServer=1',
	//->	}).done(function (name) {
	//->		AppServer = name;
	//->	});
	//->/
	
	//-> get initial domain extension data 
				$.ajax({
					contentType: "application/json; charset=utf-8",
					url: ''+ MyAppProcessor + '?GetAppData=1',
					dataType:'jsonp',
					success: function(o) {
						//alert(o.success);
						if (o.success && o.toplevel && o.secondlevel) {
							var CountDomainExtensions = 0;
							//console.log(o.toplevel);
							DomainExtentionList = [];
							//TopLevelDomainExtensions = o.toplevel.split(',');
							//SecondLevelDomainExtensions = o.secondlevel.split(',');
							for (var i=0; i<o.toplevel.length; i++) {
								//console.log(TopLevelDomainExtensions[i] + ' ' + TopLevelDomainExtensions[i].replace('+.','.') + ' ' + ((TopLevelDomainExtensions[i].indexOf('+.') != -1) ? 'yes':'no'));
								DomainExtentionList[CountDomainExtensions] = DomainExtentionListObject('1', o.toplevel[i].replace('+.','.'), ((o.toplevel[i].indexOf('+.') != -1) ? 'yes':'no'));
								CountDomainExtensions++;
							}
							for (var i=0; i<o.secondlevel.length; i++) {
								//console.log(SecondLevelDomainExtensions[i] + ' ' + SecondLevelDomainExtensions[i].replace('+.','.') + ' ' + ((TopLevelDomainExtensions[i].indexOf('+.') != -1) ? 'yes':'no'));
								DomainExtentionList[CountDomainExtensions] = DomainExtentionListObject('2', o.secondlevel[i].replace('+.','.'), ((o.secondlevel[i].indexOf('+.') != -1) ? 'yes':'no'));
								CountDomainExtensions++;
							}
						}
					}
				});
	

	//-> hide isearch form 
	//toggleInitialSearchForm(0);
	runSuccessfulLogin(1);
};

var runSuccessfulLogin = function(actiontimer) {
	//-X> console.log('runSuccessfulLogin');

	//-> here's where the magic continues, we close mobile window or InAppBrowser window, which then allows us to capture that at the mobile device level, to process other inline functions 
	if (!!OnlyShowInitialSearchForm && !!window.parent.document) {
		//alert(!!window.parent.document.getElementsByTagName("iframe")[0]);
		window.parent.document.location.href = "mobile/reisearch-successful";
	}
	else if (!!isWebViewInteractiveLogin && !!window.parent.document) {
		window.parent.document.location.href = "mobile/close";
	}
	//-> if no magic needed, then continue on as before the magic was added :) 
	else {

		ParseAppData();
		//--> Inactivity timeout auto-logout
		//--> to re-implement auto-logout timeout functionality just uncommon next line:
		// initializeAutoIdleLogout();
	}
	
};

var initializeAutoIdleLogout = function() {
	$.idleTimer(240000);
	$(document).bind("idle.idleTimer", function(){
		AutoLogoutMinion = setTimeout(AutoLoginExecutor,5000);
		//-X> console.log('idle!');
	});
	$(document).bind("active.idleTimer", function(){
		clearTimeout(AutoLogoutMinion);
		AutoLogoutMinion = '';
		clearTimeout(LogoutExecutor);
		LogoutExecutor = '';
		//-X> console.log('no longer idle');
		$('#ActivityModal').fadeTo('fast',0.00, function(){
			$(this).remove();
		});
	});
};


var MainMenuIconState = '';
var BackToAppIcon = '<div id="AppIcon"><i class="fa fa-plus-square-o fa-3x cancel"></i></div>';
var MenuLinesIcon = '<div id="AppTab" class="menuholder"><div class="menulines"></div><div class="menulines"></div><div class="menulines"></div></div>';
var BreathingMenu = '';
var lastMenuState = '';
var toggleMainMenuIcon = function(instate) {
					
	
	//-X> console.log('toggleMainMenuIcon:'+instate+'');
	//if (lastMenuState != instate) {
		if (instate == 'loading') {
			$(".app-menu-wrapper a").html('').html('<span style="position:relative;left:1px;top:3px;"><i class="loader fa fa-cog fa-spin fa-2x fa-fw margin-bottom" style="color:rgba(71,71,71,0.2);font-size:2.6em;"></i></span>');
		}
		else if (instate == 'cancel') {
			$(".app-menu-wrapper a").html('').html(BackToAppIcon);
			if (lastMenuState != instate) { SetTouchFocus(); }
		}
		else {
			// quickly test all conditions by replacing following line
			// if (instate == 'updated' || instate == 'nochange') {
			
			//-->> FLOWTRACK June 16, 2015
			//-->> NEW EVENTS or CALENDAR CHANGED, refresh list prompt
			//-->> CALENDAR MONITOR needs to be reactivated
			//-->> RELATED functions and variables: checkServerStatus and ActiveChecker
			if (instate == 'updated') {
				//--> remove BreathingMenu functionality 
				//--> BreathingMenu = setTimeout('BreathingAppMenu()', 2500);
				//--> but do still show Refresh App link in fly in menu, meaning as soon as event list is updated, it would have become and stayed visible

			}
			else if (instate != 'nochange') {
				if (AppVisible == 0) {
					$(".app-menu-wrapper a").html('').html(BackToAppIcon);
					//-->> BUGTRACK June 16, 2015
					//-->> WHY is this here? Guessing it has to do with the fact we can always RESET this here, quickly, meaning as new form elements are shown or hidden from view, aka EVENT form fields
					//-->> AND even if the answer to why is right, does this really have to be here? When toggling the menu state? I think not, maybe move it back to toggleApp?
					//-->> FOR now will leave here, unless I think of a reason to move it elsewhere.
					if (lastMenuState != instate) { SetTouchFocus(); }
				}
				else {
					$(".app-menu-wrapper a").html('').html(MenuLinesIcon);
					//-->> BUGTRACK June 16, 2015
					//-->> WHY is this here? Guessing it has to do with the fact we can always RESET this here, quickly, meaning as new form elements are shown or hidden from view, aka SEARCH form field
					//-->> AND even if the answer to why is right, does this really have to be here? When toggling the menu state? I think not, maybe move it back to toggleApp?
					//-->> OR maybe liveSearchMe, an instance in which the SEARCH form is shown?
					//-->> FOR now will leave here, unless I think of a reason to move it elsewhere.
					if (lastMenuState != instate) { SetTouchFocus(); }
				}
			}
		}
	//}
	//else {
	//	console.log('toggleMainMenuIcon is already instate: '+instate+'');
	//}
	lastMenuState = instate;
};

var AppMenuBlinker = function() {
			//-X> console.log('AppMenuBlinker');
	clearTimeout(AppBlinker);
};

//-> keep breathing until they reload the page, in essence, clearing the 'new event' flag, that is, until new event(s) show up again 
var BreathingAppMenu = function() {
	clearTimeout(BreathingMenu);
	$(".app-menu-wrapper div:first").stop().animate({opacity: 0.25}, 1000)
    	.animate({opacity: 0.95}, 1000)
    	.animate({opacity: 0.25}, 1000)
    	.animate({opacity: 0.95}, 1000);

};
var toggleInitialSearchForm = function(switcher) {

			
		if (switcher == 0) {
			//-> removed LOADER 2015 
			//--> TheImageLoader = new imageLoader(cImageSrc, 'startAnimation()');
			$("#isearch").css('display','none');
			$("#submit").prop('disabled','disabled');
			$("#isearch fieldset").each(function(){  $(this).fadeTo('fast','0.00');  });
			$("#isearch h1").hide('fast',function(){ $(this).html('Loading'); $(this).show('fast'); });
			$(document).prop('title', 'DOMapp v'+ActiveAppName+'');
			$("#InitialSearchForm").hide();
			$("#LoadInitialization").show();
		}
		else {
			
			$("#submit").prop('disabled','');
			$("#isearch h1").show('fast',function(){ 
				$(this).html('<div style="font-size: 34px; padding-bottom:4px;position:relative;top:-10px;">DOMapp</div>').css('margin-bottom','20px').show('fast'); 
			});
			$(document).prop('title', 'DOMapp v'+ActiveAppName+'');
			$("#isearch fieldset").each(function(){  $(this).fadeTo('fast','1.00');  });
			$("#InitialSearchForm").show();
			$("#isearch").css('display','inline-block');
			$("#LoadInitialization").hide();

			stopAnimation();
			TheImageLoader = '';
			$("#loaderImage").remove();
		}

			//-X> console.log('toggleInitialSearchForm');


};


var resetLoaderState = function() {
			//-X> console.log('resetLoaderState');
	stopAnimation();
	TheImageLoader = '';
	$(".loadingImage").remove();

	cSpeed=8;
	cWidth=100;
	cHeight=100;
	cTotalFrames=12;
	cFrameWidth=100;
};

var AutoLogout = 0;
var logMeOut = function() {
	//-> during WebView logout we don't log them out of the web application, we simply sign them out of mobile device app 
	if (!!AutoLogout && !!isWebView && !!window.parent.document) {
		window.parent.document.location.href = "mobile/auto-logout";
	}
	else if (!!isWebView && !!window.parent.document) {
		window.parent.document.location.href = "mobile/logout";
	}
	else {
		$.ajax({
			crossDomain: 'true',
			url:""+MyAppProcessor+"?logout=1",
			cache: false,
			type: "GET",
			contentType: "application/json; charset=utf-8",
			dataType: 'text',
			success:function(){
				ReloadHome();
			}
		});
	}
};

var submitActDEFAULT = 'Log In';
var submitActiveDEFAULT = 'Trying';
var cancelActDEFAULT = 'Cancel';
var submitAct = submitActDEFAULT;
var submitActive = submitActiveDEFAULT;
var cancelAct = cancelActDEFAULT;
var hasClicked = 0;
var enableCom = function() {
			//-X> console.log('enableCom');
	$("#VirtualPrivateLoginActions").html('<span id="VirtualPrivateLoginActivity"></span><span id="VirtualPrivateCommentButtons"><button name="submit" id="submit">Log In</button><!--<a href="">Keep me logged in</a>--></span>');
	$("#submit").val(submitAct);
	$("#VirtualPrivateLoginActivity").html('');
	$("#submit").prop('disabled','');
	hasClicked = 0;
};
var actiontimer = 5000;
var refreshActions = function(callback) {
				//-X> console.log('refreshActions callback: '+callback+' actiontimer:'+actiontimer+'');

    window.setTimeout(function() {
		$('#isearch-form-message').fadeTo('fast','0.00',function(){
			$('#VirtualPrivateLoginActions').fadeTo('fast','0.00',function(){
				$(this).fadeTo('fast','0.00', function(){
					// otherwise is default 5000 timer, enableCom/reset
					if (actiontimer == 5000 || actiontimer == 100) {
						actiontimer = 5000;
						enableCom();
						$(this).fadeTo('slow','1.00', callback);
					}
    				// isearch success timer at 1500, triggers new actions
					else if (actiontimer == 1500) {
						TheImageLoader = new imageLoader(cImageSrcToo, 'startAnimation()');

						$(this).fadeTo('fast','0.00', function() {
							$(this).fadeTo('slow','1.00', function() {
								//-> destroy the isearch form 
								$("#isearch h1").fadeTo('fast','0.00',function(){
									$("#isearch fieldset").each(function(){ 
										$(this).fadeTo('fast','0.00'); 
									});
									
									runSuccessfulLogin(actiontimer);
								});
							});
						});
					}
					// isearch error timer at 4500, triggers new actions
					else if (actiontimer == 4500) {
						//-X> console.log('step 6 --- ' + actiontimer + '');
						$(this).fadeTo('fast','0.00', function() {
							$(this).html('<div id="isearch-form-message" class="isearch-form-message-error">Make sure your username and password are correct, then try again.</div>');
							$(this).fadeTo('slow','1.00', function() {
								$(this).fadeTo(6000,'0.00', function() {
									$("#username").select();
									//reset action timer
									// yep reset buttons, running 100 timer
									actiontimer = 100;
									refreshActions(function() { });
								});
							});
						});
					}
				});
			});
		});
	}, actiontimer);
};
var actionMessage = function(mymessage) {
				//-X> console.log('actionMessage: ' +mymessage+'');
	// which one was flagged as bad
	if (mymessage.indexOf("TryAgain!") != -1) {
		mymessage = mymessage.replace('TryAgain!','');
	}
	$('#VirtualPrivateLoginActions').fadeTo('fast','0.00',function(){
		$(this).html(mymessage).fadeTo('slow','1.00',function(){
			refreshActions(function() { });
		});
	});
};
//->END LOGIN FORM

//-> DOM SIZER 
var gvaWidth = 0, gvaHeight = 0, gdsWidth = 0, gdsHeight = 0;
function getViewableArea() {
				//-X> console.log('getViewableArea');
	if( typeof( window.innerWidth ) == 'number' ) {
    	//Non-IE
    	gvaWidth = window.innerWidth;
    	gvaHeight = window.innerHeight;
  	}
	else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    	//IE 6+ in 'standards compliant mode'
    	gvaWidth = document.documentElement.clientWidth;
    	gvaHeight = document.documentElement.clientHeight;
  	}
	else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    	//IE 4 compatible
    	gvaWidth = document.body.clientWidth;
    	gvaHeight = document.body.clientHeight;
	}
	return [gvaWidth, gvaHeight];
}

function getDocumentSize() { 
				//-X> console.log('getDocumentSize');

	gdsWidth = document.body.clientWidth; gdsHeight = document.body.clientHeight; return [gdsWidth, gdsHeight]; 
}




//-> START: PAGE PULL UP/DOWN SCRIPT 
var appListScroll,
	pullDownEl, pullDownOffset,
	pullUpEl, pullUpOffset;

function pullDownAction () {
}
var loaded = function() {
	pullDownEl = document.getElementById('pullDown');
	pullDownOffset = pullDownEl.offsetHeight;
	pullUpEl = document.getElementById('pullUp');	
	pullUpOffset = pullUpEl.offsetHeight;
	appListScroll = new iScroll('AppList', {
		useTransition: false,
		topOffset: pullDownOffset,
		onRefresh: function () {
		},
		onScrollMove: function () {
		},
	});
	
	setTimeout(function () { document.getElementById('AppList').style.left = '0'; }, 800);
	
	//-> 2016
	$(window).scroll(function (event) {
		window.scrollTo(0, 0);
		return false;
	});
	
};
document.addEventListener('DOMContentLoaded', function () { setTimeout(loaded, 200); }, false);
//-> END: PAGE PULL UP/DOWN SCRIPT 

var SearchInputDefaultWidth;
var SearchInputAutcomplete;
var backToTop = function () {
	appListScroll.scrollToElement('#the-domains', 250, -20);
	appListScroll.refresh();
};






var getParameterByName = function(name) {
				//-X> console.log('getParameterByName: name'+name+'');

    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
};







var extensionMatchSupported = function(StringToSearch) {
	var supported = 0;
	var level = '';
	var extension;
	var exact = new Array();
	var matchType = new Array();
	var filter = extension, matching, entered;
	$.each(DomainExtentionList, function(idx, obj) {
		var extensionLevel = obj.level.toString();
		var extension = obj.extension.toString();
		var extensionSupported = obj.supported.toString();
		var aValue = StringToSearch.split('.');
		aValue.shift();
		entered = '.'+aValue.join('.');
		if (StringToSearch.indexOf('.') != -1) {
			matching = '.'+aValue.join('.');
			if (extension == matching) {
				exact.push(extension);
				if (extensionSupported == 'yes') {
					supported = 1;
					level = extensionLevel;
				}
			}
		}
	});
	if (exact.length != 1) {
		matching = '';
		level = '';
	}
	matchType.push(supported);
	matchType.push(matching);
	matchType.push(level);
	return matchType;
};



var lastSearch = '';
var lookupText = '';
var lookupAct = '';
var runningDomainSearch = 0;
var runDomainSearch = function(acual) {
	// lastSearch = '';
	var DomainToSearch = $("#WebSearch").val().toString();
	if (runningDomainSearch == 0 && DomainToSearch.toString().length >= 3 && lastSearch != DomainToSearch) {
		runningDomainSearch = 1;
		searchActivity = $('#Search-Domain-Names-IP-Address-Lookup .text');
		//logoActivity = $('#domapplogo');
		//domapplogo = '<img src="images/domapp_mini.png" style="padding: 15px 18px;">';
		if (DomainToSearch.indexOf('mydomain.com') != -1) { 
			runningDomainSearch = 0; 
			toggleMainMenuIcon('cancel'); 
			return false;
		}
		else if ((/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$/.test(DomainToSearch)) || (/(?:\.[a-zA-Z]{1,})+$/.test(DomainToSearch))) {
			var extensionIsSupported = extensionMatchSupported(DomainToSearch);
			if (!extensionIsSupported[0]) {
				var MatchedUnsupported = ' our search doesn\'t support';
				//alert(extensionIsSupported[2]);
				if (extensionIsSupported[1] != '') {
					MatchedUnsupported = ' while we recognize it,&nbsp;our search doesn\'t support <span class="bolder">'+extensionIsSupported[1]+'</span>,';
				}
				$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-error"><strong>Error: Unsupported Extension</strong><div class="domain-name-search-error-info">We apologize,&nbsp;'+MatchedUnsupported+' the extension you entered,&nbsp;feel free to try a different extension with the same domain name.</div></div>');
				//->nowSearchingButton();
				endOfSearch();
			}
			else {
				//alert(extensionIsSupported[2]);
				
				$("#SearchResults .domain-name-search-error").remove();
				if (lookupText == '') { lookupText = searchActivity.html();  lookupAct = $('#mainsubmit').html(); }
				
				lastSearch = DomainToSearch;
				
				//-> update the 'You entered: xxx' display
				$("#SearchResults .search-results-row.entered strong").html(DomainToSearch);
				
				//toggleMainMenuIcon('loading');
				

				//if (!/^(http(s)?\/\/:)?(www\.)?[a-zA-Z\-]{3,}(\.(com|net|org))?$/.test(DomainToSearch)) {
				//	runningDomainSearch = 0;
				//	$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-error">Invalid characters.</div>');
				//}
				//else {
					var ActivePromptText = 'Now Searching';
					var ActiveContinueText = 'Save This Domain';
					//logoActivity.html('<span style="position:relative;top:0px;left:0px;" title="Searching...">'+domapplogo+'</span>');
					//$('#mainsubmit').html('<input type="button" value="'+ActivePromptText+'" onClick="javascript:void(0);" style="background-color:#111;">');
					$('#mainsubmit').empty();
					//-> undermine overflow of typed search input by dynamically setting padding-right of input field, to to into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field
					$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});
					
					if (isRegistering == 1) {
					}
					else {

						$.ajax({
							timeout: 20000,
							contentType: "application/json; charset=utf-8",
							url: ''+ MyAppProcessor + '?'+new Date().getTime()+'&v=2&d='+DomainToSearch+'&st='+SaveTakenDomains+'',
							dataType:'jsonp',
							success: function (o) {
								if(!!o) {
									if (o.error && (o.data)) {
										$(".domain-name-search-error").remove();

										if (o.error.indexOf('Taken') != -1) {
											
											//-> only if doesn't already exist 
											if ($("#the-domains").html().toString().indexOf('id="'+DomainToSearch+'"') == -1 && SaveTakenDomains == 1) {
												// add one to tally of total number 'saved' domains, even if this is a temporary save, aka will be gone 
												TotalNumberOfSavedDomains++;
												
												// add it to the list as 'taken'
												$('.saved-domain-name-list').prepend(NoDomains.replace('no-domains','saved-domain taken').replace('no-rel',TotalNumberOfSavedDomains).replace('no-id',DomainToSearch).replace(NoDomainsTitle,DomainToSearch + " is taken..."));
												//-> remove 'no saved domain names' list item if exists 
												$('.my-domains.no-domains').remove();
												// sort the list
												sortTheAppList(SortOrder);
												// refresh the scroller on the list
												appListScroll.refresh();

												//--> make this domain registerable
												$(document).on(EVENT_CONFIG.CLICK, '.my-domains.saved-domain.available', function (e) {
													initiateRegistration($(this).find('.data .subject').attr('id'));
												});


											}

											
												//$(this).html('<div class="domain-name-search domain-name-search-taken">'+o+':</div>');
												//$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap input').css('padding-left',''+(searchActivity.width()+20)+'px');
												// $("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search search-results-row domain-name-search-taken">'+o.data+':</div>');
												$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-error whois" style="cursor:pointer;"><strong>Error: Taken</strong><div class="domain-name-search-error-info">Oops, your domain name is unavailable, as it is currently registered by a person or entity. Would you like to know who owns or has operational control over this domain? Simply tap this content area to initiate a <span class="bolder">whois search</span> on the domain.</div></div>');
												$(document).on(EVENT_CONFIG.CLICK, '#SearchResults .domain-name-search.whois', function (e) {
													toggleMainMenuIcon('loading');
													whoisSearch(e); 
												});

												//$("#WebSearch").val('').prop('value','');
												//reSearchButton();

												endOfSearch();
										}
										else {
												if (o.error.indexOf('Invalid characters') != -1 || o.error.indexOf('Undefined extension') != -1 || o.error.indexOf('Invalid extension') != -1) {
													
													
													o.data = o.data.replace('domain extension','<span class="bolder">domain extension</span>').replace('.com','<span class="bolder">.com</span>').replace('.net','<span class="bolder">.net</span>').replace('.info','<span class="bolder">.info</span>');
													$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-error"><strong>Error: '+o.error+'</strong><div class="domain-name-search-error-info">'+o.data+'</div></div>');
													//$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-info"><strong>Country code top-level domain (ccTLD)</strong><div class="domain-name-search-error-info">More information about country code top-level domain (ccTLD) extensions.</div></div><div></div>');
													//$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-info right"><strong>Country code second-level domain (ccSLD)</strong><div class="domain-name-search-error-info">More information about country code second-level domain (ccTLD) extensions.</div></div><div></div>');
													// $("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-action">something</div>');
													
													
													sizeTheSearchPane(1);
												
												}
												else {
													$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search search-results-row domain-name-search-error">Try again!</div>');
												}
												
												//$("#WebSearch").val('').prop('value','');
												//reSearchButton();
												
												//$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap input').css('padding-left',''+(searchActivity.width()+20)+'px');

												endOfSearch();
										}
									}
									else if (o.success && (o.data)) {
										if (o.data.indexOf('Available') != -1) {
												//$(this).html('<div class="domain-name-search domain-name-search-available">'+o+':</div>');
												//$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap input').css('padding-left',''+(searchActivity.width()+20)+'px');

												//$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search search-results-row domain-name-search-available" title="Congratulations, '+DomainToSearch+' is available!"> '+DomainToSearch+' is available!</div>');

													$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-available"><strong>Congratulations!</strong><div class="domain-name-search-available-info">Your domain name is available for registration,&nbsp;please remember to save it. Saving your domain name will allow you to register it at your lesisure,&nbsp;as well as make it available to you for quick reference into the future.</div></div>');
													$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-warning"><strong>Saving is not registering</strong><div class="domain-name-search-error-info">While saving your domain is important,&nbsp;it is not as important as registering your domain name with an accredited <span class="bolder">domain name registrar</span>. After saving your domain,&nbsp;select it from your list to continue with registration.</div></div><div></div>');
												sizeTheSearchPane(1);
												
												$('#mainsubmit').html('<input type="button" value="'+ActiveContinueText+'" onClick="javascript:saveMyDomainName();" style="background-color:#65983A;">');
												//-> undermine overflow of typed search input by dynamically setting padding-right of input field, to to into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field
												$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});						

												
												endOfSearch();
										}
									}
								}
							},
							error: function (msg) {
									//$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search search-results-row domain-name-search-error">Try again!</div>');
									$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-error"><strong>Error: Try again</strong><div class="domain-name-search-error-info">We apologize,&nbsp;looks like there\'s a problem fulfilling your query,&nbsp;please feel free to try again. Make certain you are using proper syntax,&nbsp;and only using characters allowed in domain names,&nbsp;within your search string.</div></div>');

									//$(this).html('<div class="domain-name-search domain-name-search-error">Try again!</div>');
									//$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap input').css('padding-left',''+(searchActivity.width()+20)+'px');
								
									//reSearchButton();
									
									endOfSearch();
							}
						});
					}
				//}
			}

			
		}
		else {
			$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-error"><strong>Error: Try again</strong><div class="domain-name-search-error-info">We apologize,&nbsp;looks like there\'s a problem fulfilling your query,&nbsp;please feel free to try again. Make certain you are using proper syntax,&nbsp;and only using characters allowed in domain names,&nbsp;within your search string.</div></div>');
			//reSearchButton();
			endOfSearch();
		}

	}
	else {
		//reSearchButton();
		endOfSearch();
	}
};

var reSearchButton = function() {
	$('#mainsubmit').html('<input type="reset" class="research no-click" value="New Search?" style="background-color:#111;">');
	//-> undermine overflow of typed search input by dynamically setting padding-right of input field, to to into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field
	$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});
	
	$(document).on(EVENT_CONFIG.CLICK, '#mainsubmit input', function (e) {
		reSearch();
	});
};

var nowSearchingButton = function() {
	$('#mainsubmit').html('<input type="reset" class="research no-click" value="Searching..." style="background-color:#111;">');
	//-> undermine overflow of typed search input by dynamically setting padding-right of input field, to to into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field
	$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});
	$(document).on(EVENT_CONFIG.CLICK, '#mainsubmit input', function (e) {
		reSearch();
	});
};

var makeSearchScroller = function() {
	if (searchPaneScroll != '') {
		searchPaneScroll.scrollTo(0,0);
		searchPaneScroll.refresh();
	}
	searchPaneScroll = new iScroll('SearchResultsWrapper');
};

var whoisSearch = function(e) {
	var DomainToSearch = $("#WebSearch").val().toString();
	if (runningDomainSearch == 0 && DomainToSearch.toString().length >= 3) {
		runningDomainSearch = 1;
		
		searchActivity = $('#Search-Domain-Names-IP-Address-Lookup .text');
		//logoActivity = $('#domapplogo');
		//domapplogo = '<img src="images/domapp_mini.png" style="padding: 15px 18px;">';
		if (DomainToSearch.indexOf('mydomain.com') != -1) { runningDomainSearch = 0; toggleMainMenuIcon('cancel'); return false; }
		else {
			//-> update the 'You entered: xxx' display
			$("#SearchResults .domain-name-search.whois").remove();
			// $("#SearchResults .search-results-row.entered").html('Whois: <strong>' + $("#WebSearch").val() + '</strong>');
			$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-info whois"><strong>Whois: ' + $("#WebSearch").val() + '</strong><div class="domain-name-search-whois-info">Now querying...</div></div>');

			var lUrl = '/domain-registration-search/whois-protocol-query-search-lookup.htm?d='+DomainToSearch+'';
			$.ajax({
				timeout: 20000,
				url: lUrl+"&"+new Date().getTime()+"",
				success: function (o) {	
					if(!!o) {
						if (o.indexOf('JUSTOUTSTANDING!') != -1) {
							myWhoisResults = o;
							myWhoisResults = myWhoisResults.replace('JUSTOUTSTANDING!','').replace('<br><br>','<br>');
								
							if (o.indexOf('No match for domain') != -1) {
								$('.domain-name-search.whois').addClass('domain-name-search-error').removeClass('domain-name-search-info');
								$(".domain-name-search-whois-info").html("No record found.");
							}
							else {
								$('.domain-name-search.whois').addClass('domain-name-search-available').removeClass('domain-name-search-info');
								$(".domain-name-search-whois-info").html("Record has been successfully found.");
								$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search"><fieldset><div>'+myWhoisResults+'</div></fieldset></div>');
								sizeTheSearchPane(1);
							}
							countCPM++;
						}
						else {
							$('.domain-name-search.whois').addClass('domain-name-search-error').removeClass('domain-name-search-info');
							$(".domain-name-search-whois-info").html("No record found.");
						}
						endOfSearch();
					}
				},
				error: function (o) {
					$('.domain-name-search.whois').addClass('domain-name-search-error').removeClass('domain-name-search-info');
					$(".domain-name-search-whois-info").html("Error processing request.");
					endOfSearch();
				}
			});
		}
	}
};

var endOfSearch = function() {
	if (!Modernizr.touch) {
		$('#mainsubmit input').focus();
	}
	runningDomainSearch = 0;
	$("#WebSearch").addClass('must-clear');
	toggleMainMenuIcon('cancel');
	//->$('#mainsubmit').empty();
	$("#SearchResults .search-results-row.extension, #SearchResults .search-results-row.similar, #SearchResults .search-results-row.whois").remove();
};

var searchPaneScroll = '';
var sizeTheSearchPane = function(makeScroller) {
	//-> 22px is the margin on left, right and between the two panes
	$("#SearchResultsWrapper, #SearchResults").css({'width':''+$("#AppList").width()+'px'});
	$(".domain-name-search.domain-name-search-info.left, .domain-name-search.domain-name-search-info.right").css({'max-width':($("#SearchResultsWrapper").width()-22-22-160)/2+'px','width':($("#SearchResultsWrapper").width()-22-22-160)/2+'px'});

	if ($("#SearchResults .domain-name-search fieldset div").length >= 1) {
		$("#SearchResults .domain-name-search fieldset div").width($('.domain-name-search.whois').width()).css({'max-width':$('.domain-name-search.whois').width()+'px','overflow-x':'auto'});
	}
	
	if (!!makeScroller) {
		makeSearchScroller();
	}
};

var countCPM = 1;
var reSearch = function() {
	clearEntireSearch();

	if (lookupText != '') {
		if (countCPM == 5) {
			//$('#Search-Domain-Names-IP-Address-Lookup .text').html('<div id="domain-name-search" class="domain-name-search-error">Save limit reached:</div>');
			//$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap input').css('padding-left',''+(searchActivity.width()+20)+'px');
			//$('#mainsubmit').html('');
			//$("#WebSearch").val('Maximum five(5) domain names');
			//$("#WebSearch").prop('disabled','disabled');
		}
		else {
			//$('#Search-Domain-Names-IP-Address-Lookup .text').html(lookupText);
			//$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap input').css('padding-left','80px');
			//$('#mainsubmit').html(lookupAct);
			//$("#WebSearch").val('');
		}
	}
	if (!$("#WebSearch").is(":focus")) { $("#WebSearch").focus(); }
};

var MySavedDomains = new Array();
var TotalNumberOfSavedDomains = 0;
var getMySavedDomainNames = function() {
	$.ajax({
		contentType: "application/json; charset=utf-8",
		url: ''+ MyAppProcessor + '?'+new Date().getTime()+'&g2=1',
		dataType:'jsonp',
		success: function(o) {
			if(o.success && o.domains) {
				TotalNumberOfSavedDomains = !!o.domains.length?(o.domains.length):0;
				if (TotalNumberOfSavedDomains >= 1) {
					MySavedDomains = o.domains;
				}
			}
			ParseAppList(MySavedDomains,TotalNumberOfSavedDomains);
		},
		error: function(o) {
			ParseAppList(MySavedDomains,TotalNumberOfSavedDomains);
		}
	});
};

var saveMyDomainName = function() {
	// searchActivity.html('<span style="position:relative;top:0px;left:0px;" title="Saving..."><img src="/web_design_imagery/loadCircle.gif" width="18" height="15" border="0" alt="Saving..." style="padding-right:10px;"></span>');
	$('#mainsubmit').html('<input type="button" value="Saving Domain" style="background-color:#111;">');
	//-> undermine overflow of typed search input by dynamically setting padding-right of input field, to to into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field
	$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});

	var DomainToSave = $("#WebSearch").val().toString();
	
	$.ajax({
		type: "GET",
		contentType: "application/json; charset=utf-8",
		url: ''+ MyAppProcessor + '?'+new Date().getTime()+'&s='+DomainToSave+'',
		dataType:'text',
		success: function (o) {
			if(!!o) {
				if (o == DomainToSave || o == 'You previously saved:') {
					searchActivity.fadeTo('fast','0.00',function() {
						if (!MySavedDomains || (!!MySavedDomains && MySavedDomains.indexOf(DomainToSave) == -1)) {
							// add one to tally of total number 'saved' domains
							TotalNumberOfSavedDomains++;
							//-> only if doesn't already exist 
							if ($("#the-domains").html().toString().indexOf('id="'+DomainToSave+'"') == -1) {
								// add it to the list as available
								$('.saved-domain-name-list').prepend(NoDomains.replace('no-domains','saved-domain available').replace('no-rel',TotalNumberOfSavedDomains).replace('no-id',DomainToSave).replace(NoDomainsTitle,DomainToSave));
								//-> remove 'no saved domain names' list item if exists 
								$('.my-domains.no-domains').remove();
								// sort the list
								sortTheAppList(SortOrder);
								// refresh the scroller on the list
								appListScroll.refresh();
								
								//--> make this domain registerable
								$(document).on(EVENT_CONFIG.CLICK, '.my-domains.saved-domain.available', function (e) {
									initiateRegistration(DomainToSave);
								});
							}
						}
						// only add to tally if truly new domain
						if (o == DomainToSave) { 
							if (!MySavedDomains || (!!MySavedDomains && MySavedDomains.indexOf(DomainToSave) == -1)) {
								MySavedDomains.push(DomainToSave);
							}
						}
						
						$('#mainsubmit').html('<input type="button" value="Domain Was Saved!" style="background-color:#65983A;">');
						//-> undermine overflow of typed search input by dynamically setting padding-right of input field, to to into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field
						$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});

						
						//$(this).html('<div id="domain-name-search" class="domain-name-search-saved">Saved!</div>');
						//$('#Search-Domain-Names-IP-Address-Lookup li .domain-name-search-form-control-wrap input').css('padding-left',''+(searchActivity.width()+20)+'px');

						// update top bar
						//$("#gui-register-a-domain-text div nobr").html('Saved Domains: '+TotalNumberOfSavedDomains+'');

						
						$(this).fadeTo('slow','1.00',function() {
							window.setTimeout(function(){ 
								// reSearch();
								//$(".app-menu-wrapper").click();
								clickAppMenu();
								$("#WebSearch").blur();

								successStory = '<b style="color:#266899">'+o+'</b> has been saved!';
								if (o == 'You previously saved:') { successStory = 'You had previously saved that domain.'; }
								domainHasBeenSaved('<center>'+successStory+'</center>');
							}, 2000);
						});
					});
				}
				else {
					// searchActivity.html('<div id="domain-name-search" class="domain-name-search-error">'+o+'</div>');
					$(this).fadeTo('slow','1.00',function() {
							window.setTimeout(function(){ 
								// reSearch();
								//$(".app-menu-wrapper").click();
								clickAppMenu();
								$("#WebSearch").blur();

							}, 2000);
					});
				}
			}
		}
	});
		

};

var isRegistering = 0;
var initiateRegistration = function(domainname) {
	if (isRegistering == 0) {
		isRegistering = 1;
		
		if ($("#SearchResultsWrapper").length <= 0) {
			$("#AppList").prepend('<div id="SearchResultsWrapper" class="seethrough-pane"><div id="SearchResults" style="overflow:hidden;"></div></div>');
			$("li#mainsubmit input").css('display','none');
			$("#SearchResultsWrapper").addClass('cover-pane');

			eForm = $("#AppList");
			$("#SearchResults").css({'width':''+eForm.width()+'px'});
			//$("#SearchResults").html('<div class="search-results-row entered">Register: <strong>'+domainname+'</strong><div>');
			if ($(".app-menu-wrapper a").find('.fa-plus-square-o').length <= 0) {
				toggleMainMenuIcon('cancel');
			}

			$("#WebSearch").val(domainname);

			//$("#SearchResults").html('<div class="search-results-row"><strong>Congratulations!</strong><div class="domain-name-search-available-info">Your domain name is still available for registration. Simply select any one of the accredited registrars listed below to begin the process of registration.</div></div>');
			//$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-option"><div class="registrar-title"><strong>Choose GoDaddy LLC.</strong></div><div class="domain-name-registrar-info"><div class="domain-action"><div></div></div></div></div><div></div>');
			//sizeTheSearchPane(1);
						//$("#SearchResults").html('<div class="search-results-row select-registrar">Register your domain name</div>');
						//$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-option"><div class="registrar-title"><strong>With GoDaddy LLC.</strong></div><div class="domain-name-registrar-info"><div class="domain-action"><div></div></div></div></div><div></div>');
						//$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-option selected"><div class="registrar-title"><strong>With 1and1</strong></div><div class="domain-name-registrar-info"><div class="domain-action"><div></div></div></div></div><div></div>');
			if (!!AllRegistrars) {
				for (var i=0; i<AllRegistrars.length; i++) {
					//alert(AllRegistrars[i]["Other"]);
					
					if (AllRegistrars[i]["Other"].indexOf('UK2') != -1) {
						// <-- lines with double forward-slash are removed by the minifying process, therefore it will break the script if it isn't circumvented!!!
						var cjTrackingURL = 'http:/' + '/www.qksrv.net/click-3747342-10852739?SID=&URL=';
						var UK2NetURL =  '/' + 'www.uk2.net/domain-names/search-results/?domain='+domainname+'';
						var fullURL = cjTrackingURL + encodeURIComponent(UK2NetURL);
						AllRegistrars[i]["Other"] = AllRegistrars[i]["Other"].replace('action=""','action="'+fullURL+'"');
					}
					
					var parseIt = 1;
					//-> if mobile device 
					if (Modernizr.touch) {
						//-> 1and1 form doesn't work/resolve for mobile 
						if (AllRegistrars[i]["Other"].indexOf('1and1') != -1) {
							parseIt = 0;
						}
					}
					if (parseIt == 1) {
						$("#SearchResults").html($("#SearchResults").html() +
						'<div class="domain-name-search domain-name-search-option" style="padding:0;margin:10px;background-image:url('+AllRegistrars[i]["DisplayImage"].replace('tag','large-logo')+');" rel="'+AllRegistrars[i]["BorderStyle"]+'">' +
							'<table width="100%" cellpadding="0" cellspacing="0" border="0">' +
								'<tr>' +
									'<td class="registrar-logo" align="center">' +
										'<img src="/domapp/'+AllRegistrars[i]["DisplayImage"]+'" class="registrar-logo-tag">'+
									'</td>' +
									'<td class="registrar-info">' +
										'<div class="registrar-title">' +
											'<strong>Register domain with <span style="color:'+AllRegistrars[i]["BorderStyle"]+'">'+AllRegistrars[i]["Advertiser"]+'</span></strong>' +
										'</div>' +
										'<div class="domain-name-registrar-info">' +
											AllRegistrars[i]["AdText"] +
										'</div>' +
									'</td>' +
									'<td class="register-button">' +
										'<div class="register-button-wrapper" style="">' +
											'<div class="domain-action"></div>' +
										'</div>' +
									'</td>' +
								'</tr>' +
							'</table>' +
							AllRegistrars[i]["Other"] +
						'</div>');
					}
				}
				$(document).on(EVENT_CONFIG.CLICK, '.domain-name-search.domain-name-search-option', function (e) {
					console.log('clicked');
					$(this).find('form').each(function(){
						$(this).submit();
					});
				});
			}
			else {
				$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-option"><div class="registrar-title"><strong>No registrars available at this time, please try again later.</strong></div></div>');
			}
						
						sizeTheSearchPane(1);

			//$("#mainsubmit").empty().html('<input type="button" value="Register Now" onClick="javascript:registerMyDomainName();" style="background-color:#65983A;">');
			$("#mainsubmit").empty();
			$("li#mainsubmit input").css('display','inline-block');

			//-> undermine overflow of typed search input by dynamically setting padding-right of input field, to to into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field
			$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});						
			endOfSearch();
		}
		//-> set background and font color for WebSearch input field, while in focus
		$("#WebSearch").css('background-color','rgb(252,252,252)').css('color','rgb(17,17,17)');
	}
};

	var domainHasBeenSaved = function(resulta) {
		var cpContents = $("#PromptSpace");
		//if (jQuery.browser.msie) {
		//	$('.DomainSearchPromptInner').css('border','0').css('background','none');
		//	$('#DomainSearchPM1').css('border','0').css('background','none');
		//	$('#DomainSearchPM2').css('border','0').css('background','none');
		//	$('#DomainSearchPM3').css('border','0').css('background','none');
		//	$('#DomainSearchPM4').css('border','0').css('background','none');
		//	$('#DomainSearchPM5').css('border','0').css('background','none');
		//}


		if (countCPM == 5) {
			var DDomainSearchPrompt5 = $("#DomainSearchPrompt5"); 
			var DomainSearchPromptInner5 = $("#DomainSearchPromptInner5");
			var dcp5 = document.createElement("div");
   			dcp5.timeout = setTimeout(function(){ 
				DomainSearchPromptInner5.innerHTML = resulta;
				DC5 = "DomainSearchPM"+countCPM+"";
				dcp5 = DDomainSearchPrompt5.firstChild;
				cpContents.append(dcp5);
				divBlink(''+DC5+'',5);
				countCPM++;
	   		}, 1);
			window.timeout = setTimeout(function(){ 
				$('#DomainSearchPM5').hide(10,function(){
					cpContents.remove(dcp5);
				});
		    }, 10000);
		}
		else if (countCPM == 4) {
			var DDomainSearchPrompt4 = $("#DomainSearchPrompt4"); 
			var DomainSearchPromptInner4 = $("#DomainSearchPromptInner4");
			var dcp4 = document.createElement("div");
   			dcp4.timeout = setTimeout(function(){ 
				DomainSearchPromptInner4.innerHTML = resulta;
				DC4 = "DomainSearchPM"+countCPM+"";
				dcp4 = DDomainSearchPrompt4.firstChild;
				cpContents.append(dcp4);
				divBlink(''+DC4+'',5);
				countCPM++;
	   		}, 1);
			window.timeout = setTimeout(function(){ 
				$('#DomainSearchPM4').hide(10,function(){
					cpContents.remove(dcp4);
				});
		    }, 10000);
		}
		else if (countCPM == 3) {
			var DDomainSearchPrompt3 = $("#DomainSearchPrompt3"); 
			var DomainSearchPromptInner3 = $("#DomainSearchPromptInner3");
			var dcp3 = document.createElement("div");
   			dcp3.timeout = setTimeout(function(){ 
				DomainSearchPromptInner3.innerHTML = resulta;
				DC3 = "DomainSearchPM"+countCPM+"";
				dcp3 = DDomainSearchPrompt3.firstChild;
				cpContents.append(dcp3);
				divBlink(''+DC3+'',5);
				countCPM++;
	   		}, 1);
			window.timeout = setTimeout(function(){ 
				$('#DomainSearchPM3').hide(10,function(){
					cpContents.remove(dcp3);
				});
		    }, 10000);
		}
		else if (countCPM == 2) {
			var DDomainSearchPrompt2 = $("#DomainSearchPrompt2");
			var DomainSearchPromptInner2 = $("#DomainSearchPromptInner2");
			var dcp2 = document.createElement("div");
   			dcp2.timeout = setTimeout(function(){ 
				DomainSearchPromptInner2.innerHTML = resulta;
				DC2 = "DomainSearchPM"+countCPM+"";
				dcp2 = DDomainSearchPrompt2.firstChild;
				cpContents.append(dcp2);
				divBlink(''+DC2+'',5);
				countCPM++;
	   		}, 1);
			window.timeout = setTimeout(function(){ 
				$('#DomainSearchPM2').hide(10,function(){
					cpContents.remove(dcp2);
				});
		    }, 10000);
		}
		else {
			var DDomainSearchPrompt1 = $("#DomainSearchPrompt1");
			var DomainSearchPromptInner1 = $("#DomainSearchPromptInner1");
			var dcp1 = document.createElement("div");
    		dcp1.timeout = setTimeout(function(){ 
				DomainSearchPromptInner1.innerHTML = resulta;
				DC1 = "DomainSearchPM"+countCPM+"";
				dcp1 = DDomainSearchPrompt1.firstChild;
				cpContents.append(dcp1);
				divBlink(''+DC1+'',5);
				countCPM++;
		    }, 1);
			window.timeout = setTimeout(function(){ 
				$('#DomainSearchPM1').hide(10,function(){
					cpContents.remove(dcp1);
				});
		    }, 10000);


		}



		// yummy, thanks jquery ;)
		//swapDomainState();



	};
	
var divBlink = function(quien,timesBlink) {
	for (var i=0; i<timesBlink; i++) {
		//if(!jQuery.browser.msie) {
			$('#'+quien+'').fadeOut(100);
			$('#'+quien+'').fadeIn(1000);
		//}
	}
	//if (jQuery.browser.msie && oldBG) { $('#'+quien+'').css('background',""+oldBG+""); }
};



		var processingDomainRequest = '';
		var checkDomainName = function(domain) {
			var myDomain = $(domain).attr('id');
			console.log($(domain).html());
			if (processingDomainRequest == '') {
				// walk around DOM find our target
				// var myIcon = $(domain).parent().parent().find('.minidomain').parent().html();
				// myIcon = $(domain).parent().parent().find('.minidomain');
				// myIcon.css('background','url(/web_design_imagery/loadCircle.gif) 1px 1px no-repeat').attr('title','Checking availability for domain: '+myDomain+'');
				processingDomainRequest = myDomain;
				$(domain).html('<div id="domain-name-inline-search">'+myDomain+'</div>');
				$(domain).find('#domain-name-inline-search').fadeOut('fast',function(){
					$(domain).html('<div id="domain-name-inline-search" class="checking">checking...</div>');
				});
				toggleMainMenuIcon('loading');
				$.ajax({
					type: "GET",
					contentType: "application/json; charset=utf-8",
					url: ''+ MyAppProcessor + '?'+new Date().getTime()+'&d='+myDomain+'',
					dataType:'text',
					success: function(o) {
						if(!!o) {
							processingDomainRequest = '';
							toggleMainMenuIcon('default');
							if (o.indexOf('Taken') != -1) {
								// myIcon.css('background','url(/web_design_imagery/website_design_communications/domain-name-taken.png) 1px 1px no-repeat').attr('title','Domain no longer available: '+myDomain+', please remove it from your list.');
								$(domain).parent().parent().addClass('taken');
								$(domain).html('<div id="domain-name-inline-search" class="domain-name-search-taken">taken</div>');
								window.setTimeout(function(){ 
									$(domain).find('#domain-name-inline-search').fadeOut('fast',function(){
										$(domain).html(myDomain);
										// myIcon.attr('title','Domain no longer available, click to remove: '+myDomain+'');
										// dont reset icon on taken (leave as flagged)
										// myIcon.parent().html('<a class="minidomain active" title="Click to remove: '+myDomain+'" onClick="javascript:deleteDomainName(this);"></a>');
									});
						  		}, 2000);
							}
							else if (o.indexOf('Available') != -1) {
								// myIcon.css('background','url(/web_design_imagery/website_design_communications/star_boxed_half.png) 1px 1px no-repeat').attr('title','Domain still available: '+myDomain+', you should register it before someone else does.');
								$(domain).parent().parent().addClass('available');
								$(domain).html('<div id="domain-name-inline-search" class="domain-name-search-available">available</div>');
								window.setTimeout(function(){ 
									$(domain).find('#domain-name-inline-search').fadeOut('fast',function(){
										$(domain).html(myDomain);
										//--> make this domain registerable
										
										//-NEW TWO
											$(domain).parent().parent().click(function(){
												initiateRegistration(myDomain);
											});

										// myIcon.parent().html('<a class="minidomain active" title="Click to remove: '+myDomain+'" onClick="javascript:deleteDomainName(this);"></a>');
									});
					  			}, 2000);
							}
							else {
								// myIcon.css('background','url(/web_design_imagery/website_design_communications/domain-name-error.png) 1px 1px no-repeat').attr('title','Error: ('+o+')');
								$(domain).parent().parent().addClass('invalid');
								if (o.indexOf('Invalid characters') != -1 || o.indexOf('Undefined extension') != -1 || o.indexOf('Invalid extension') != -1) {
									$(domain).html('<div id="domain-name-inline-search" class="domain-name-search-error">'+o+'</div>');
								}
								else {
									$(domain).html('<div id="domain-name-inline-search" class="domain-name-search-error">Try again!</div>');
								}
								window.setTimeout(function(){ 
									$(domain).find('#domain-name-inline-search').fadeOut('fast',function(){
										$(domain).html(myDomain);
										// dont reset icon on error (leave as flagged)
										// myIcon.parent().html('<a class="minidomain active" title="Click to remove: '+myDomain+'" onClick="javascript:deleteDomainName(this);"></a>');
									});
					  			}, 2000);
							}
						}
					},
					error: function(o) {
						processingDomainRequest = '';
						toggleMainMenuIcon('default');
						// myIcon.css('background','url(/web_design_imagery/website_design_communications/domain-name-error.png) 1px 1px no-repeat').attr('title','Verification did not initialize, please try again later.');
						$(domain).parent().parent().addClass('invalid');
						$(domain).html('<div id="domain-name-inline-search" class="domain-name-search-error">Try again!</div>');
						window.setTimeout(function(){ 
							$(domain).find('#domain-name-inline-search').fadeOut('fast',function(){
								$(domain).html(myDomain);
								// myIcon.parent().html('<a class="minidomain active" title="Click to remove: '+myDomain+'" onClick="javascript:deleteDomainName(this);"></a>');
							});
			  			}, 2000);

					}
				});
				return false;
			}
		};
		var DomainsSaved = TotalNumberOfSavedDomains;
		var deleteDomainName = function(mein){
				if (processingDomainRequest == '') {
					

					//console.log('done'+$('.my-domains').length);
					//-> if no more listings, add 'no domains saved' list item 
					if ($('.my-domains').length == 1) {
						$('.saved-domain-name-list').html(NoDomains);
						// hide not remove since our overall css relies on the first-child being present, that being the domain action
						$('.domain-action').hide();
					}

					processingDomainRequest = 1;
					// var theTR = $(mein).parent().parent().html();
					// var domainTABLE = $(mein).parent().parent().parent().parent().parent().html();
					// alert($('.Activity').GetBubblePopupMarkup());
					var meinDomain = $(mein).find('.subject').attr('id');
					
					$(mein).find('.data, .domain-action').remove();
					$( mein ).animate({
						width: "12px",
					}, 500, function() {
						$(mein).remove();
						appListScroll.refresh();
					});
					
					//-> only delete anything that isn't taken, for taken items have not been saved 
					if (!$(mein).hasClass('taken')) {
						

						$.ajax({
							type: "GET",
							contentType: "application/json; charset=utf-8",
							url: ''+ MyAppProcessor + '?'+new Date().getTime()+'&r='+meinDomain+'',
							dataType:'text',
							success: function(o) {
								if(!!o) {
									if (o.indexOf('Removed') != -1) {
										// make new domain name stack from netsol form for netsol and godaddy stack
										//var oldDomainStack = ''+$('input#domainNames').val()+'';
										//newDomainStack = oldDomainStack.replace(''+meinDomain+',','').replace(','+meinDomain+'','').replace(''+meinDomain+'','');
										//netsol
										//$('input#domainNames').val(''+newDomainStack+'');
										//godaddy
										//$('input#domainToCheck').val(''+newDomainStack+'');

										//var DomainActivityBubbleHTML = $('.Activity').GetBubblePopupMarkup();
										//clean up the any messy markup spacing
										//DomainActivityBubbleHTML = ''+DomainActivityBubbleHTML.replace(/\\t/g,'').replace(/> </g,'><')+'';
										
										TotalNumberOfSavedDomains--;
										DomainsSaved--;
										
										//var PendingRegistrationBubbleHTML = $('#PendingRegistration').GetBubblePopupMarkup();
										// update pending registration menu
										//penReg = ''+$('#PendingRegistration').html()+'';
										//$('#PendingRegistration').html(penReg.replace('('+(DomainsSaved+1)+')','('+(DomainsSaved)+')'));


										if (DomainsSaved == 0) {
											//DomainTable = $('.DomainTable').html().replace(theTR,'<tr><td class="nodomains" width="100%"><a href="/domain-registration-search/internet-domain-name-registration.php" target="_top" class="nodomains" title="You no longer have any domains names to register, would you like to search for a domain to register?">None: Search Domains</a></td><td class="nodomains"><a class="minisearch active" href="/domain-registration-search/internet-domain-name-registration.php" target="_top" title="You no longer have any domains names to register, would you like to search for a domain to register?"></a></td></tr>');
											// -- replace TR with new content
											//$('.DomainTable').html(DomainTable);
											//newDomainTable = "<table width='100%' class='DomainTable' cellpadding='3' cellspacing='0' border='0'>"+DomainTable+"</table>";
											//$('.Activity').SetBubblePopupInnerHtml("<div style='padding:5px 4px 3px 4px; font-size:9px;max-width:250px;font-family:verdana,arial,helvetica;'><div style='padding:0px;font-weight:bold;color:#555555;'>Domain Names You Have Saved:</div><br><div class='Domain-Registration-Pending'>"+newDomainTable+"</div>$domainTableFoot</div>");
											//$('#PendingRegistration').RemoveBubblePopup();
											//$('#PendingRegistration').hide('slow',function(){
												// canvas
											//	$('#UserSettings').RemoveBubblePopup();
											//	$('#UserSettings').hide('slow');
											//});
										}
										else {
											// if coming down to three remove extra spacing that compensates for scrollbar area
											//if (DomainsSaved == 3) {
												//$('.minidomain').css('left','0px');
											//}
											// -- remove the TR
											//$('#'+contentID+'').remove();
											//DomainTable = $('.DomainTable').html().replace(theTR,'');
											//newDomainTable = "<table width='100%' class='DomainTable' cellpadding='3' cellspacing='0' border='0'>"+DomainTable+"</table>";
											//$('.Activity').SetBubblePopupInnerHtml("<div style='padding:5px 4px 3px 4px; font-size:9px;max-width:250px;font-family:verdana,arial,helvetica;'><div style='padding:0px;font-weight:bold;color:#555555;'>Domain Names You Have Saved:</div><br><div class='Domain-Registration-Pending'>"+newDomainTable+"</div>$domainTableFoot</div>");
										}
						
						
										// update parent domain registration main menu
										//if (!(!parent.SavedDomains)) {
											//alert(parent.SavedDomains);
											//parent.SavedDomains = DomainsSaved;
											//parent.swapDomainState();
										//}
										
										processingDomainRequest = '';

									}
								}
							}
						});
					}
					else {
						processingDomainRequest = '';
					}
				}
		};

						
		var registerDomainWith = function(domainform,registrar) {
			console.log('submitted');
			var trueValue = document.getElementById('WebSearch').value;
			$(".domainToCheck").val(trueValue);
			
			if (Modernizr.touch) {
				if (!!isWebView) {
					//-> UK2 only needs its preformed action as the URL to submit unto
					if (registrar == 'UK2') {
						window.parent.document.location.href = "mobile/url/"+$(domainform).attr('action')+"";
					}
					//-> For everyone else we create the URL to submit unto by way of form serialization
					else {
						window.parent.document.location.href = "mobile/url/" +$(domainform).attr('action')+($(domainform).serialize().indexOf("?") != -1 ? '&' : '?')+$(domainform).serialize()+"";
					}
					return false;
				}
			}
			return true;
		};
