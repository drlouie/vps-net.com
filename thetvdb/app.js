/* 
##################################################################
#   Program:        TheTVDB Guide (RESTful)                      #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2018 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:          API Strap                                #
#        Source:        TheTVDB.com                              #
#        Type:          Web Application                          #
#        Dependencies:  PHP::TVDB library (included)             #
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

var MyServerHTTPPort = '';
if (window.location.port == '80' || window.location.port == '443') { MyServerHTTPPort = ':'+window.location.port+''; }
var MyDomainURI = ''+window.location.protocol+'/' + '/'+window.location.host+''+MyServerHTTPPort+'';
var MyAppProcessor = '/thetvdb/thetvdb.php';
var ChangeLog = "";
var IveSwipedApp = 0;
var IvePinchedApp = 0;
var IveScrolledApp = 0;
var IveZoomedApp = 0;

//-> defaults
var DefaultViewport = '';
var HardenedViewport = '';
var SortOrder = '';

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

var clearDocumentLoadtimeState = function() {
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
var gva;
var setViewport = function() {
	if (Modernizr.touch) {
		gva = getViewableArea();

		var ScreenOrientation = (gva[0] > gva[1])? 90 : 0;
		// landscape mode
			DefaultViewport = 'width='+gva[0]+', height='+gva[1]+', maximum-scale=0.6175, initial-scale=0.6175, user-scalable=no';
			HardenedViewport = 'width='+gva[0]+', height='+gva[1]+', maximum-scale=0.6175, initial-scale=0.6175, user-scalable=no';
			if (
				!(isAndroid && isWebkit)
			) {
				$('meta[name=viewport]').prop('content',DefaultViewport);
				viewportIsSet = 1;

				//--> Since safari, but not chromium, iOS has serious bugs in displaying oriented content, we must scrollTo top 0 then back to our original spot upon changing of orientation
				//--> We also have to do other things like resize main content wrapper height, and reset iscroll area
				if (isWebkit && isiOS && !isChromium) {
					setTimeout(function(){
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
		getMySavedShows();
	}
	

	if (AppVisible == 0) {
		$("#DocumentTitle").css('display','none');
		$("#QuickSearch, #TopBar").show();
		$("#DocumentLoading").remove();
		$("#VirtualPrivateButtons").css('display','none');

		if (AppLoading == 0) { 
			$("#AppList").css('visibility','visible').css('display','block');
		}

		AppVisible = 1;
		
	}

	else {
		$("#QuickSearch, #TopBar").hide();

		$("#AppList").hide();

		AppVisible = 0;
	}

	
	if (AppVisible == 1) {
		ShowButtonsHideActivity();
		toggleMainMenuIcon('default');
	}

};
var NoShowsTitle = 'You have no saved shows';
var NoShows = '<div class="my-domains no-domains"><div class="domain-action"><div></div></div><div class="data"><div class="subject" style="font-weight:normal" rel="no-rel" id="no-id">'+NoShowsTitle+'</div></div></div>';

var hideRefreshModal = function() {
	if ($("#ActivityModal").length >= 1) {
		$('#ActivityModal').fadeTo('fast',0.00, function(){
			$(this).remove();
		});
	}
	toggleMainMenuIcon('default');
};
var createdAppList = 0;
var ParseAppList = function(MySavedShows,TotalNumberOfSavedItems) {
	//-> first time/pass only, meaning not for reparsing of list 
	if (createdAppList == 0) {
		$("#AppList, .AppHolder").css('display','block');
	}
	//-> secondary passes, meaning re-parsing list upon user action 
	else {
		$("#app-list").empty();
	}
	
	if ($('#the-domains').length == 0) {
		$('#app-list').append('<div id="the-domains" class="the-domains with-domain"><label for="the-domains"><div class="domain-list-title">Shows you\'ve saved</div><div class="saved-domain-name-list">'+NoShows+'</div></label></div>');
		// hide not remove since our overall css relies on the first-child being present, that being the domain action
		$('.domain-action').hide();
	}
	if (TotalNumberOfSavedItems >= 1) {
		$('.my-domains.no-domains').remove();
		for (var i=0; i<MySavedShows.length; i++) {
			var ItemId = '';
			var ItemName = '';
			/* 
				example data string: 
				series:{"73192":"Blade (2006)"}],[series:{"266657":"The Unexplained: Beyond The Grave (2013)"}]
			*/
			
			ItemId = MySavedShows[i].replace('[series:{','').replace('}]','').replace(/"/g,'').split(':')[0];
			ItemName = MySavedShows[i].replace('[series:{','').replace('}]','').replace(/"/g,'').split(':')[1];
			$('.saved-domain-name-list').append(NoShows.replace('no-domains','saved-domain').replace('no-rel',i).replace('no-id',ItemId).replace(NoShowsTitle,ItemName));
		}
	}

	//-> first time/pass only, meaning not for reparsing of list 
	if (createdAppList == 0) {
		toggleMainMenuIcon('default');
		/* removed at loadtime, nagging, AUG 2018 */
		/* appListScroll.refresh(); */
	}
	//-> secondary passes, meaning re-parsing list upon user action 
	else {
		appListScroll.refresh();
	}
		
	createdAppList++;

	//-> default sort, rev chronological order 
	if (TotalNumberOfSavedItems >= 1) {
		sortTheAppList(OrderByMeOptions[0]);
	}
	
};

var alphabeticalSort = function(list, item, type) {
	var $divs = $(list);
    var alphabeticallyOrderedItems = $divs.sort(function (a, b) {
		if (type == 'asc') {
			return $(a).find(item).text() > $(b).find(item).text() ? 1 : -1;
		}
		else {
			return $(a).find(item).text() < $(b).find(item).text() ? 1 : -1;
		}
    });
	return alphabeticallyOrderedItems;
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
var intpad = function(num, size) {
    var s = "000000000" + num;
    return s.substr(s.length-size);
};
var sortTheAppList = function(sortie) {
	SortOrder = sortie;
    //--> NEW
	if (sortie == 'OrderBySeries-Name-asc') {
		$("div.saved-domain-name-list").html(alphabeticalSort('div.saved-domain','div.subject','asc'));
	}
	else if (sortie == 'OrderBySeries-Name-desc') {
		$("div.saved-domain-name-list").html(alphabeticalSort('div.saved-domain','div.subject','desc'));
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

var ActivateAppList = function() {
	//-X> console.log('ActivateAppList');
	$('.my-domains.saved-domain').doubletap(runDoubleTap,runSingleTap);

};
var runDoubleTap = function(eve) {
	if (!$(eve).hasClass('available')) {
		$(eve).addClass('invalid').find('.subject').html('Delete ' + $(eve).find('.subject').text() + '?');
		$(document).on(EVENT_CONFIG.CLICK, '.invalid .domain-action', function (e) {
			
			/* AUG 2018 - make sure we have the right data set before acting upon it otherwise delete functionality bugs out (tries to act upon taps without (eve) handler and subsequent data, product of click-through handling) */
			if ($(eve).html().indexOf('domain-action') != -1) {
				deleteListItem($(eve));
			}
			e.stopPropagation();
			e.preventDefault();
		});
	}
};
var runSingleTap = function(eve) {
	if ($(eve).html().indexOf('subject') != -1) {
		// only run if isn't in stalemate mode
		if (!$(eve).hasClass('available') && !$(eve).hasClass('taken') && !$(eve).hasClass('invalid')) {
			getSeriesEpisodes($(eve).find('.data .subject').attr('id'),$(eve).find('.data .subject').text());
		}
		// undelete it
		else if (!$(eve).hasClass('available') && !$(eve).hasClass('taken') && $(eve).find('.subject').html() == 'Delete ' + $(eve).find('.subject').attr('id') + '?') {
			$(eve).removeClass('invalid').find('.subject').html($(eve).find('.subject').attr('id'));
		}
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
//var ButtonHidingTimer = '';
//var ButtonShowingSpeed = 500;
var ShowButtonsHideActivity = function() {

	if (NowShowingButtons == 0) {
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
				
				$(document).on(EVENT_CONFIG.CLICK, '#LogOutTrigger, #FlyInMenu .app-refresh', function () {
					refreshTrigger();
				});

				

				//-->> FLOWTRACK June 16, 2015
				//-->> AppLoading still, finally set it to AppLoading = 0, end the saved data list creation(pageload flow) phase
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
			//-->> CAN only come through here when data list has finished its initialization and loading
			else {
				//-->> THIS is set within toggleApp, therefore, we're in the process of showing event form if we are indeed true to AppVisible == 0 at this point in time in the flow
				//-->> HOWEVER we must keep in mind of this being here, for we don't want to trip this under any other circumstance
				if (AppVisible == 0) {
					$("#DocumentTitle").css('display','inline-block').show();
					$("#VirtualPrivateButtons").show();
					toggleMainMenuIcon('default');
				}
			}


			NowShowingButtons = 0;
			
			//-> reset timer 
			//ButtonShowingSpeed = 500;
			//clearTimeout(ButtonHidingTimer);
	}
};

var refreshTrigger = function() {
	//->only if app has finished loading
	if (AppLoading == 0) {
		toggleMainMenuIcon('loading');
		$("#app-list").empty();
		appListScroll.refresh();
		hideAppMenu();
		getMySavedShows();
		window.setTimeout(function(){
			toggleMainMenuIcon('default');
		},500);
	}
};

var OrderByMeOptions = new Array('OrderByChronologically-DESC','OrderByChronologically-ASC','OrderBySeries-Name-asc','OrderBySeries-Name-desc');
var AppOptionMarkup = '<div class="menu-content-spacer sub"></div><label for="%%OPTION_NAME%%" class="CheckboxLabel"><div class="child"><fieldset class="GeneralInformationField KeyPressCheckbox" style="font-size: initial;padding:0;border:0;background:none;"><div class="RightBorderDivider" style="font-size: 20px;">%%OPTION_TEXT%%</div><div class="OrderBy"><div class="CommonCheckbox"><input id="%%OPTION_NAME%%" type="checkbox" value="%%OPTION_VALUE%%" name="%%OPTION_NAME%%" tabindex="3" style="display:none;"><div class="icon">%%FA_ICON%%</div></div></div></fieldset></div></label>';

var getAndSetAppOptions = function() {
	for(var i = 0; i<OrderByMeOptions.length; i++){
		var MyAppOptionMarkup = AppOptionMarkup.replace(/%%OPTION_NAME%%/g,OrderByMeOptions[i]).replace('%%OPTION_TEXT%%',OrderByMeOptions[i].replace('OrderBy','').replace(/-/g,' ').replace('asc',' (ascending: a-z)').replace('desc',' (descending: z-a)').replace('ASC',' (as added: old to new)').replace('DESC',' (as added: new to old)'));
		MyAppOptionMarkup = MyAppOptionMarkup.replace('%%OPTION_VALUE%%','0').replace('%%FA_ICON%%','<i class="fa fa-square-o fa-2x"></i>');
		$('#AppOptions').append(MyAppOptionMarkup);
	}
	activateAppOptionSwitches();
};

var activateAppOptionSwitches = function() {
	$(document).on(EVENT_CONFIG.CLICK, 'label[for=OrderBySeries-Name-asc], label[for=OrderBySeries-Name-desc], label[for=OrderByChronologically-ASC], label[for=OrderByChronologically-DESC]', function (e) {
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
	
	$(document).on(EVENT_CONFIG.CLICK, '#OrderBySeries-Name-asc, #OrderBySeries-Name-desc, #OrderByChronologically-ASC, #OrderByChronologically-DESC', function (e) {
		e.preventDefault();
		e.stopPropagation();
		$("label[for="+$(this).attr('id')+"]").click();
	});
};

var AppVersion;
var FullAppVersion;
var MobileAppVersion;
var FullMobileAppVersion;
var AppMenuClickHandlerSet = 0;
var flyInMenuScroll;
var toggleAppMenu = function() {
	//-> toggles AppMenu on an off 
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
						}
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
				hideAppMenu();
			});
			$(document).on(EVENT_CONFIG.CLICK, '.ps-scrollbar-y', function (e) {
				hideAppMenu();
			});
			$(document).on(EVENT_CONFIG.CLICK, '#FlyInMenuHeader .back-to-list', function (e) {
				hideAppMenu();
			});


			$(document).on(EVENT_CONFIG.CLICK, '#FlyInMenuContent .menu-content .menu-content-item.extra .inner', function (e) {

				if ($(this).parent().hasClass('hidden')) {
					$(this).parent().removeClass('hidden');
					$(this).parent().find('.righter').removeClass('fa-chevron-down').addClass('fa-chevron-up');
				}
				else {
					$(this).parent().addClass('hidden');
					$(this).parent().find('.righter').removeClass('fa-chevron-up').addClass('fa-chevron-down');
				}
				
				OrderBySwitchScrollerOffset = $("#FlyInMenuContent").offset().top - 61;
				//console.log(OrderBySwitchScrollerOffset);
				flyInMenuScroll.refresh();
			});

			
			$(document).on(EVENT_CONFIG.CLICK, '#FlyInMenuContent .menu-content .menu-content-item.extra .child', function (e) {
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





	var SearchTimer = '';
	var WebSearchBlur = '';
	var lastSearchString = '';

	var liveSearchMe = function() {
		//-> console.log('liveSearchMe');
		$("#WebSearch").focus(function(e){
			console.log($("#SearchResultsWrapper").length + ' XXX ' + $(e).value);
			//-> if SearchResultsWrapper pane doesn't exist or our search value NOT present or search value IS present and value equals Search
			focusedOnSearch(e);
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
						$("li#mainsubmit input").css('display','none');
						$("#WebSearch").css({'padding-right':'15px'});

						toggleMainMenuIcon('default');
					}
					else if ($("#WebSearch").val().toString().length >= 1 && $("#SearchResultsWrapper").length >= 1 && !($("#SearchResultsWrapper").hasClass('noblur'))) {
						//-> give ourselves some time to figure if we are ready for blur, if so kill search results 
						$(this).timeout = setTimeout(function(){
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
			if ($("#SearchResultsWrapper").length <= 0 || !$(e).value || (!!$(e).value && ($(e).value == 'Search'))) {
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
			if ($("#SearchResultsWrapper").length <= 0 || !$(e).value || (!!$(e).value && ($(e).value == 'Search'))) {
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
		if ($("#SearchResultsWrapper").length <= 0 || !$(e).value || (!!$(e).value && ($(e).value == 'Search'))) {
			$(e).value = '';
			if ($("#SearchResultsWrapper").length <= 0) {
				$("#AppList").prepend('<div id="SearchResultsWrapper" class="seethrough-pane"><div id="SearchResults" style="overflow:hidden;"></div></div>');
				$("li#mainsubmit input").css('display','none');
				$("#WebSearch").css({'padding-right':'15px'});
			}
			eForm = $("#AppList");
			$("#SearchResults").css({'width':''+eForm.width()+'px'});
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
		if (pushedState >= 1) {
			window.history.pushState({page: 'TheTVDB Guide'},'TheTVDB Guide','/thetvdb/');
			pushedState = 0;
		}
	};
	var clearEntireSearch = function() {
		clearSearchPane();
		$("#SearchResultsWrapper").removeClass('noblur');
		$("#SearchResultsWrapper").remove();
		//--> Clear Search Term(s)
		$("#WebSearch").val('');
		if ($("#WebSearch").is(":focus")) { $("#WebSearch").blur(); }
		$("li#mainsubmit input").css('display','none');
		$("#WebSearch").css({'padding-right':'15px'});
		resetSearch();
		toggleMainMenuIcon('default');
		
		if (pushedState >= 1) {
			window.history.pushState({page: 'TheTVDB Guide'},'TheTVDB Guide','/thetvdb/');
			pushedState = 0;
		}
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

			if ($("#WebSearch").hasClass('must-clear')) {
				resetSearch();
			}
			else {
				//-> return/enter
				if (e.keyCode == 13) {
					runSeriesSearch(document.forms["QuickSearch"]);
					return false;
				}
				//-> escape
				else if (e.keyCode == 27) {
					clearEntireSearch();
				}
				//-> backspace || delete
				else if (e.keyCode == 8 || e.keyCode == 46) {
					clearSearchPane();
				}
				else {
					//-> 2016
					var wsval = $("#WebSearch").val().toLowerCase();
					$("#WebSearch").val(wsval.replace(/[^a-z\d\-_\s\.]/gi, ''));
					

					$("#SearchResults .search-results-row.extension").remove();
					$("#SearchResults .search-results-row.exact").remove();
					console.log('IS NOT');
					lastSearchString = $("#WebSearch").val();
				}
				//-> countCPM = how many times reSearch has been called, so by removing one from that count to get true amount of total times searched 
				searchReport(countCPM-1);
			}
			
	};
var resetSearch = function() {
	if (lastSearch != $("#WebSearch").val()) {
		$("#WebSearch").removeClass('must-clear');
		$("#mainsubmit").empty().html('<input type="submit" value="Find Show">');
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



var ReloadHome = function() {
	//-X> console.log('ReloadHome');
	MyHREF = parent.location.href;
	MyHREF = MyHREF.split("?");
	//-> reassignWebView allows us to do just that, forward the wvc(WebViewCall) to our document reload 
	reassignWebView = '';
	if (!!isWebView) { reassignWebView = '&wvc=1'; }
	parent.location.href = ''+ MyHREF[0] +'?'+ new Date().getTime() + '' + reassignWebView;
};

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

	if (TotalNumberOfSavedItems >= 2) {
		sortTheAppList(WhichOrderBy);
		// refresh the scroller on the list
		appListScroll.refresh();
		
		//--> register this as a handler
		$(document).on(EVENT_CONFIG.CLICK, '.my-domains.saved-domain.available', function (e) {
			console.log('getSeriesEpisodes from list after OrderBySwitch');
			getSeriesEpisodes($(this).find('.data .subject').attr('id'),$(this).find('.data .subject').text());
		});

	}


	//-X> console.log('OrderBySwitchURL:'+""+MyAppProcessor+"?Callback=1&Organizer="+$("#Organizer").val()+"&SetAppOption=1&AppOptionName="+WhichOrderBy+"&AppOptionValue="+$("#"+WhichOrderBy+"").val()+"&"+new Date().getTime()+""+'');
};
var MakeOrderBySwitch = function(WhichOrderBy) {
	$("#OrderByMe").html(cImageSrcToo.replace('fa-3x ',''));

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

};
var CheckForEmptyOrderBy = function() {
	//-> if no other options are selected in the list, select the default 
	if ($("#FlyInMenuContent .OrderBy input[value=1]").length == 0) {
		OrderBySwitch(OrderByMeOptions[0]);
	}
};
var ClearLastOrderBy = function(ClearWho) {
		$("#"+ClearWho+"").val('0');
		$("label[for="+ClearWho+"] .OrderBy .CommonCheckbox .icon").html('<i class="fa fa-square-o fa-2x"></i>');
		flyInMenuScroll.refresh();
};


//-> LOADER IMAGE START 
var cImageSrc='<i class="loader fa fa-cog fa-spin fa-5x fa-fw margin-bottom" style="color:rgba(71,71,71,0.2);"></i><div class="app-loading">loading...</div>';
var cImageSrcToo='<i class="loader fa fa-cog fa-spin fa-3x fa-fw margin-bottom" style="color:rgba(71,71,71,0.2);"></i>';
var cImageTimeout=false;
var loaderTarget = 'loaderImage';

var startAnimation = function() {
		//-X> console.log('startAnimation');
	if (loaderTarget == 'LoginLoader') { 
		$('#'+loaderTarget+'').html(cImageSrcToo);
	}
	else {
		$('#'+loaderTarget+'').html(cImageSrc);
	}
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

var isWebView;
var isIframed;

var OnlyShowInitialSearchForm;


$(document).ready(function() {

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
	
	//-> not for chrome, but yes for webview (a variation of chromium)
	if (!!isWebView) {
		$('body').addClass('wvc');
	}
	if (!!isIframed) {
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
		//runSeriesSearch(document.forms["QuickSearch"]);
		return false;
	});

	
	//-> we only need type=url for mobile, hence the modified digital keyboard entry with domain centric input capability, if we don't do this, then prompts given to non-mobile device user, hence desktop chrome will see "Please enter a URL" even if entered 
	//-> "sign out" only for mobile devices 
	//-> ALSO in 2018, since iOS is having nagging issues we also set type=text and remove pattern for input
	if (!Modernizr.touch || !!isiOS) {
		$("#WebSearch").attr('type','text').removeAttr('pattern');
		$("#FlyInMenu .logout .inner").html('Restart application<i class="righter fa fa-gears fa-1_3x"></i>');
	}

	
	$(document).on(EVENT_CONFIG.CLICK, '#FlyInMenu .logout', function (e) {
		ReloadHome();
	});



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
	
});

var SetTouchFocus = function() {
	//-X> console.log('SetTouchFocus');

	//-> cancels zooming upon focus ios/touch/mobile 
	//-> hint, simply kill the Modernizr.touch to test on all devices 
	if (Modernizr.touch) {
		$("input[type=text], fieldset input").focus(function(){
			gva = getViewableArea();
			$('header').hide().css('position','absolute').css('top','').show();
		});
		$("input[type=text], fieldset input").blur(function(){
			$('header').css('position','fixed').css('bottom','').css('top','0');
		});
	}
	

	
		
};



var ActiveAppName = '0.1';
var checkServerConnection = function() {
	//-> get initial data -> handshake
	$.ajax({
		contentType: "application/json; charset=utf-8",
		url: ''+ MyAppProcessor + '?Handshake=1',
		dataType:'jsonp',
		success: function(o) {
			if (o.success) {
				runSuccessfulHandshake();
			}
		}
	});
};

var runSuccessfulHandshake = function() {
	//-X> console.log('runSuccessfulHandshake');

	//-> here's where the magic continues, we close mobile window or InAppBrowser window, which then allows us to capture that at the mobile device level, to process other inline functions 
	if (!!OnlyShowInitialSearchForm && !!window.parent.document) {
		window.parent.document.location.href = "mobile/reisearch-successful";
	}
	else if (!!isWebViewInteractiveLogin && !!window.parent.document) {
		window.parent.document.location.href = "mobile/close";
	}
	else {
		ParseAppData();
	}
	
};



var BackToAppIcon = '<div id="AppIcon"><i class="fa fa-plus-square-o fa-3x cancel"></i></div>';
var MenuLinesIcon = '<div id="AppTab" class="menuholder"><div class="menulines"></div><div class="menulines"></div><div class="menulines"></div></div>';
var lastMenuState = '';
var toggleMainMenuIcon = function(instate) {
					
	
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
			
			if (instate != 'nochange') {
				if (AppVisible == 0) {
					$(".app-menu-wrapper a").html('').html(BackToAppIcon);
					if (lastMenuState != instate) { SetTouchFocus(); }
				}
				else {
					$(".app-menu-wrapper a").html('').html(MenuLinesIcon);
					if (lastMenuState != instate) { SetTouchFocus(); }
				}
			}
		}
	lastMenuState = instate;
};


var toggleInitialSearchForm = function(switcher) {

			
		if (switcher == 0) {
			//-> removed LOADER 2015 
			$("#isearch").css('display','none');
			$("#submit").prop('disabled','disabled');
			$("#isearch fieldset").each(function(){  $(this).fadeTo('fast','0.00');  });
			$("#isearch h1").hide('fast',function(){ $(this).html('Loading'); $(this).show('fast'); });
			$(document).prop('title', 'TheTVDB Guide v'+ActiveAppName+'');
			$("#InitialSearchForm").hide();
			$("#LoadInitialization").show();
		}
		else {
			
			$("#submit").prop('disabled','');
			$("#isearch h1").show('fast',function(){ 
				$(this).html('<div style="font-size: 34px; padding-bottom:4px;position:relative;top:-10px;">TheTVDB Guide</div>').css('margin-bottom','20px').show('fast'); 
			});
			$(document).prop('title', 'TheTVDB Guide v'+ActiveAppName+'');
			$("#isearch fieldset").each(function(){  $(this).fadeTo('fast','1.00');  });
			$("#InitialSearchForm").show();
			$("#isearch").css('display','inline-block');
			$("#LoadInitialization").hide();

			
			TheImageLoader = '';
			$("#loaderImage").remove();
		}

			//-X> console.log('toggleInitialSearchForm');


};



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




var pushedState = 0;
var lastSearch = '';
var runningSeriesSearch = 0;
var SizeTheResults = '';
var runSeriesSearch = function(acual) {
	var StringToSearch = $("#WebSearch").val().toString();
	if (runningSeriesSearch == 0 && StringToSearch.toString().length >= 3 && lastSearch != StringToSearch) {
		runningSeriesSearch = 1;
		searchActivity = $('#Search-Series-Names-IP-Address-Lookup .text');
		
		if ((/^[a-z\d\-_\s\.]+$/.test(StringToSearch))) {
				toggleMainMenuIcon('loading'); 
				$("#SearchResults .domain-name-search-error").remove();
				
				lastSearch = StringToSearch;
				//-> update the 'You entered: xxx' display
				$("#SearchResults .search-results-row.entered strong").html(StringToSearch);
					$('#mainsubmit').empty();
					//-> undermine overflow of typed search input by dynamically setting padding-right of input field, to to into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field
					$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});
					
					if (isRegistering == 0) {
						toggleMainMenuIcon('loading'); 
						$.ajax({
							timeout: 20000,
							contentType: "application/json; charset=utf-8",
							url: ''+ MyAppProcessor + '?'+new Date().getTime()+'&v=2&search='+StringToSearch+'',
							dataType:'jsonp',
							success: function (o) {
								if(!!o) {
									if (o.error && (o.data)) {
										$(".domain-name-search-error").remove();

										/* NoMatch */
										if (o.error.indexOf('NoMatch') != -1) {
											var milliseconds = (new Date).getTime();
											$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-error whois '+milliseconds+'" style="cursor:pointer;"><strong>No shows found</strong><div class="domain-name-search-error-info">There are no shows matching your search criteria. Check your search terminology and try your search again. Care to try again?</div></div>');
											$(document).on(EVENT_CONFIG.CLICK, '#SearchResults .domain-name-search.whois.'+milliseconds+'', function (e) {
												clearEntireSearch();
											});
										}
										else {
											if (o.error.indexOf('Invalid characters') != -1) {
												$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-error"><strong>Error: '+o.error+'</strong><div class="domain-name-search-error-info">'+o.data+'</div></div>');
											}
											else {
												$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search search-results-row domain-name-search-error">Try again!</div>');
											}
											sizeTheSearchPane(1);
										}
									}
									else if (o.success && (o.data)) {
										// switched from o.data = Available to o.success, for o.data now contains series search results
										if (o.success.indexOf('Available') != -1) {
											/* 
												transparent: domain-name-search search-results-row
												blue: domain-name-search-info
												yellow: domain-name-search-warning
												red: domain-name-search-error
												green: domain-name-search-available
												gray: domain-name-search-option
											*/
											console.log(o.data);
											var SeriesID = '';
											var FirstAired = '';
											var Overview = '';
											var Network = '';
											var Banner = '';
											var SeriesName = '';
											var IMDBLink = '';
											for (var sd=0; sd<o.data.length; sd++) {
												SeriesID, FirstAired, Overview, Network, Banner, SeriesName, IMDBLink = '';
												if (!!o.data[sd]["SeriesName"]) {
													SeriesName = o.data[sd]["SeriesName"];
												}
												if (!!o.data[sd]["FirstAired"] && (o.data[sd]["FirstAired"].indexOf("-") != -1)) {
													AiredYear = o.data[sd]["FirstAired"].split("-")[0];
													/* only if our string is truly 4 character number */
													if (AiredYear.length == 4 && !isNaN(AiredYear)) {
														FirstAired = ' ('+AiredYear+')';
													}
												}
												if (!!o.data[sd]["Overview"]) {
													Overview = ' ('+o.data[sd]["Overview"]+')';
												}
												if (!!o.data[sd]["Network"]) {
													Network = ' ('+o.data[sd]["Network"]+')';
												}
												if (!!o.data[sd]["banner"] && ((o.data[sd]["banner"].indexOf('/banners/blank/') == -1))) {
													Banner = ' <div class="series-header-image"><img src="'+o.data[sd]["banner"]+'"></div>';
												} else { Banner = ''; }
												if (!!o.data[sd]["seriesid"]) {
													SeriesID = o.data[sd]["seriesid"];
												}
												if (!!o.data[sd]["IMDB_ID"]) {
													IMDBLink = '<div class="imdb-link"><a href="https://www.imdb.com/title/' + o.data[sd]["IMDB_ID"] + '/" target="IMDB" class="bolder" onClick="javascript:this.stopPropagation();this.preventDefault();">IMDB Profile</a></div>';
												}												
												$("#SearchResults").append('<div class="domain-name-search domain-name-search-option '+SeriesID+'" id="'+SeriesName+'" data-name="'+SeriesName+''+FirstAired+'" data-id="'+SeriesID+'">'+Banner+'<div class="series-title"><strong>'+SeriesName+''+FirstAired+''+Network+'</strong></div><div class="domain-name-search-available-info">'+Overview+''+IMDBLink+'</div></div>');
												
												$(document).on(EVENT_CONFIG.CLICK, '.domain-name-search.domain-name-search-option.'+SeriesID+'', function (e) {
													console.log('getSeriesEpisodes from runSeriesSearch -> Available');
													var MyId = $(this).attr('data-id');
													var MyName = $(this).attr('data-name');
													/* clear it otherwise can't continue the next process */
													
													getSeriesEpisodes(MyId,MyName);
												});
												if (sd+1==o.data.length) {
													sizeSearchResultScrollingPane();
												}
											}
											

										}
									}
								}

							},
							error: function (msg) {
								$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-error"><strong>Error: Try again</strong><div class="domain-name-search-error-info">We apologize,&nbsp;looks like there\'s a problem fulfilling your query,&nbsp;please feel free to try again. Make certain you are using proper syntax,&nbsp;and only using characters allowed in show names,&nbsp;within your search string.</div></div>');
								if ($(".app-menu-wrapper a").find('.fa-plus-square-o').length <= 0) {

								}
							},
							complete: function() {
								pushedState++;
								window.history.pushState({page: StringToSearch}, "Series Search: "+StringToSearch+"", "/thetvdb/series/search/"+StringToSearch.replace(' ','-').toLowerCase());
								endOfSearch();
									toggleMainMenuIcon('cancel');
							}
						});
					}

			
		}
		else {
			$("#SearchResults").html($("#SearchResults").html() + '<div class="domain-name-search domain-name-search-error"><strong>Error: Try again</strong><div class="domain-name-search-error-info">We apologize,&nbsp;looks like there\'s a problem fulfilling your query,&nbsp;please feel free to try again. Make certain you are using proper syntax,&nbsp;and only using characters allowed in domain names,&nbsp;within your search string.</div></div>');
			endOfSearch();
		}

	}
	else {
		endOfSearch();
	}
};

var makeSearchScroller = function() {
	if (searchPaneScroll != '') {
		searchPaneScroll.scrollTo(0,0);
		searchPaneScroll.refresh();
	}
	searchPaneScroll = new iScroll('SearchResultsWrapper');
};


var endOfSearch = function() {
	if (!Modernizr.touch) {
		$('#mainsubmit input').focus();
	}
	runningSeriesSearch = 0;
	$("#WebSearch").addClass('must-clear');
	toggleMainMenuIcon('cancel');
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

var MySavedShows = new Array();
var TotalNumberOfSavedItems = 0;
var getMySavedShows = function() {
	$.ajax({
		contentType: "application/json; charset=utf-8",
		url: ''+ MyAppProcessor + '?'+new Date().getTime()+'&read=1',
		dataType:'jsonp',
		success: function(o) {
			if(o.success && o.domains) {
				TotalNumberOfSavedItems = !!o.domains.length?(o.domains.length):0;
				if (TotalNumberOfSavedItems >= 1) {
					MySavedShows = o.domains;
				}
			}
			ParseAppList(MySavedShows,TotalNumberOfSavedItems);
		},
		error: function(o) {
			ParseAppList(MySavedShows,TotalNumberOfSavedItems);
		}
	});
};

var saveMyShow = function(id) {
	$('#mainsubmit').html('<input type="button" value="Saving Show" style="background-color:#111;">');
	//-> undermine overflow of typed search input by dynamically setting padding-right of input field, to to into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field
	$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});

	// var ShowToSave = $("#WebSearch").val().toString();
	var ShowToSave = id;
	var ShowTitle = $("#WebSearch").val().toString();
	
	console.log(ShowToSave);
	searchActivity = $('#Search-Series-Names-IP-Address-Lookup .text');
	$.ajax({
		type: "GET",
		contentType: "application/json; charset=utf-8",
		/* s = save switch */
		url: ''+ MyAppProcessor + '?'+new Date().getTime()+'&update='+ShowToSave+'',
		dataType:'text',
		success: function (o) {
			if(!!o) {
				if (o == ShowToSave || o == 'You previously saved:') {
						if (!MySavedShows || (!!MySavedShows && MySavedShows.indexOf(ShowToSave) == -1)) {
							// add one to tally of total number 'saved' domains
							TotalNumberOfSavedItems++;
							//-> only if doesn't already exist 
							if ($("#the-domains").html().toString().indexOf('id="'+ShowToSave+'"') == -1) {
								// add it to the list as available
								$('.saved-domain-name-list').prepend(NoShows.replace('no-domains','saved-domain available').replace('no-rel',TotalNumberOfSavedItems).replace('no-id',ShowToSave).replace(NoShowsTitle,ShowTitle));
								//-> remove 'no saved domain names' list item if exists 
								$('.my-domains.no-domains').remove();
								// sort the list
								sortTheAppList(SortOrder);
								// refresh the scroller on the list
								appListScroll.refresh();
								
								//--> register this element's handler
								$(document).on(EVENT_CONFIG.CLICK, '.my-domains.saved-domain.available', function (e) {
									console.log('getSeriesEpisodes from saveMyShow (button)');
									getSeriesEpisodes(ShowToSave,ShowTitle);
								});
							}
						}
						// only add to tally if truly new item
						if (o == ShowToSave) { 
							if (!MySavedShows || (!!MySavedShows && MySavedShows.indexOf(ShowToSave) == -1)) {
								MySavedShows.push(ShowToSave);
							}
						}
						
						$('#mainsubmit').html('<input type="button" value="Show Was Saved!" style="background-color:#65983A;">');
						//-> undermine overflow of typed search input by dynamically setting padding-right of input field, to to into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field
						$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});
							window.setTimeout(function(){ 
								clickAppMenu();
								$("#WebSearch").blur();
							}, 2000);
				}
				else {
					window.setTimeout(function(){ 
						clickAppMenu();
						$("#WebSearch").blur();
					}, 2000);
				}
			}
		}
	});
		

};

var isRegistering = 0;
/* initiateRegistration = getSeriesEpisodes */
var getSeriesEpisodes = function(seriesId,seriesName) {
	toggleMainMenuIcon('loading');

	console.log('getSeriesEpisodes: '+ seriesId);
	if (isRegistering == 0 && !isNaN(seriesId) && !!seriesName) {
		/* clear our reporting area, start anew */
		/* OriginalSearchHeader: <div class="search-results-row entered">You entered: <strong>blade</strong><div></div></div> */
		// var OriginalSearchHeader = "" + $("#SearchResults .search-results-row.entered").html() + "";
		$("#SearchResultsWrapper").remove();
		// $("#SearchResults .domain-name-search").remove();
		console.log('continue with getSeriesEpisodes: '+ seriesId);
		isRegistering = 1;
		
		if ($("#SearchResultsWrapper").length <= 0) {
			//OriginalSearchHeader = OriginalSearchHeader.replace('You entered:','You requested episodes for:');
			$("#AppList").prepend('<div id="SearchResultsWrapper" class="seethrough-pane"><div id="SearchResults" style="overflow:hidden;"><div class="search-results-row entered">You requested episodes for: <strong>'+seriesName+'</strong></div></div></div>');
			$("li#mainsubmit input").css('display','none');
			$("#SearchResultsWrapper").addClass('cover-pane');

			eForm = $("#AppList");
			$("#SearchResults").css({'width':''+eForm.width()+'px'});


			$("#WebSearch").val(seriesName);
			//$("#WebSearch").val("");

					
			$.ajax({
				type: "GET",
				contentType: "application/json; charset=utf-8",
				url: ''+ MyAppProcessor + '?'+new Date().getTime()+'&GetEpisodes='+seriesId+'',
				dataType:'jsonp',
				success: function (o) {
					/* error with seriesId, no data found */
					if (!!o.Error) {
						console.log('error with seriesId: '+o.Error+'');
						console.log();
					}
					/* data found */
					else if (!!o.data) {
						console.log('series episodes data found: '+o.data+'');
						console.log(o.data);
						for (var i=0; i<o.data.length; i++) {
							var ImageFileName = '';
							var EpisodeName = '';
							var AiredEpisodeNumber = '';
							var airedSeason = '';
							var Overview = '';
							if (!!o.data[i]["filename"] && (o.data[i]["filename"].indexOf('/banners/blank/') == -1)) { ImageFileName = '<td class="series-episode" align="center"><img src="' + o.data[i]["filename"] + '"></td>'; }
							if (!!o.data[i]["episodeName"]) { EpisodeName = o.data[i]["episodeName"]; }
							if (!!o.data[i]["airedEpisodeNumber"]) { AiredEpisodeNumber = o.data[i]["airedEpisodeNumber"]; }
							if (!!o.data[i]["airedSeason"]) { airedSeason = o.data[i]["airedSeason"]; }
							if (!!o.data[i]["overview"]) { Overview = '<div class="domain-name-registrar-info">' + o.data[i]["overview"] + "</div>"; }
							
							$("#SearchResults").html($("#SearchResults").html() +
							'<div class="domain-name-search domain-name-search-option" style="" rel="#000">' +
								'<table width="100%" cellpadding="0" cellspacing="0" border="0">' +
									'<tr>' +
										ImageFileName +
										'<td class="registrar-info">' +
											'<div class="registrar-title">' +
												'<strong><span style="color:#000">' + EpisodeName + '</span> (Episode ' + AiredEpisodeNumber + ', Season ' + airedSeason + ')</strong>' +
											'</div>' +
											Overview +
										'</td>' +
									'</tr>' +
								'</table>' +
							'</div>');
							if (i+1==o.data.length) {
								sizeSearchResultScrollingPane();
							}
						}
						/* saved already */
						if ($("div#"+seriesId+"").length <= 0) {
							$('#mainsubmit').html('<input type="button" value="Save This Show" onClick="javascript:saveMyShow(\''+seriesId+'\');" style="background-color:#65983A;">');
						}
						/* just saved */
						else {
							// $('#mainsubmit').html('<input type="button" value="Delete This Show" onClick="javascript:deleteListItem(\''+seriesId+'\');" style="background-color:rgb(203,64,64);">');
						}
						
						
					}
					/* unverifiable data error */
					else {
						console.log('unverifiable data error: '+o+'');
					}
					if ($(".app-menu-wrapper a").find('.fa-plus-square-o').length <= 0) {
						toggleMainMenuIcon('cancel');
					}
				},
				/* error with request */
				error: function(o) {
					console.log('request error: '+o+'');
					if ($(".app-menu-wrapper a").find('.fa-plus-square-o').length <= 0) {
						toggleMainMenuIcon('cancel');
					}
				},
				complete: function() {
					pushedState++;
					window.history.pushState({page: "Episodes: "+ seriesId +""}, "Episode list for "+seriesName+"", "/thetvdb/series/"+seriesName.replace(/ /g,'-').replace(/--/g,'-').replace(/[^0-9a-z-]/gi, '').toLowerCase()+"/episodes");
				}
				
			});			
			


			
		}
		//-> set background and font color for WebSearch input field, while in focus
		$("#WebSearch").css('background-color','rgb(252,252,252)').css('color','rgb(17,17,17)');
	}
};
var sizeSearchResultScrollingPane = function() {
	
	sizeTheSearchPane(0);
											
	if (SizeTheResults != '') {
		clearTimeout(SizeTheResults);
		SizeTheResults = '';
	}						
	/* timeout to make certain we've loaded most, if not all, imagery */											
	SizeTheResults = window.setTimeout(function(){
		sizeTheSearchPane(1);
	},500);
												
	/* undermine overflow of typed search input by dynamically setting padding-right of input field, to to into account the size of the overlaid submit button, hence text won't flow under the submit button over the input field */
	$("#WebSearch").css({'padding-right':''+($("#WebSearch").outerWidth() - ($("#WebSearch").outerWidth() - $("#mainsubmit input").outerWidth() - 20))+'px'});

	endOfSearch();
};




		var processingDataRequest = '';

		var deleteListItem = function(item){
				if (processingDataRequest == '') {
					

					//console.log('done'+$('.my-domains').length);
					//-> if no more listings, add 'no domains saved' list item 
					if ($('.my-domains').length == 1) {
						$('.saved-domain-name-list').html(NoShows);
						// hide not remove since our overall css relies on the first-child being present, that being the domain action
						$('.domain-action').hide();
					}

					processingDataRequest = 1;
					var myItem = '';
					/* from showEpisodes list */
					if (!isNaN(item)) {
						myItem = item;
						item = $("div#"+item+"").parent().parent();
						clearEntireSearch();
					}
					else {
						myItem = $(item).find('.subject').attr('id');
					}
					
						$(item).find('.data, .domain-action').remove();
						$( item ).animate({
							width: "12px",
						}, 500, function() {
							$(item).remove();
							appListScroll.refresh();
						});		

						$.ajax({
							type: "GET",
							contentType: "application/json; charset=utf-8",
							url: ''+ MyAppProcessor + '?'+new Date().getTime()+'&delete='+myItem+'',
							dataType:'text',
							success: function(o) {
								if(!!o) {
									processingDataRequest = '';
									if (o.indexOf('deleted') != -1) {
										TotalNumberOfSavedItems--;
									}
								}
							}
						});

				}
		};

						

var processAjaxData = function(response, urlPath) {
     document.getElementById("content").innerHTML = response.html;
     document.title = response.pageTitle;
     window.history.pushState({"html":response.html,"pageTitle":response.pageTitle},"", "/thetvdb/"+urlPath);
};