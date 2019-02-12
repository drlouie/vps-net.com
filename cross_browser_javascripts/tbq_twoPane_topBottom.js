/* in the original format, within main doc, dollar signs ($) were escaped (\) */
/* OBFUSCATION: of the following lines, obfuscatables contain ( = ) and (// ) */
/*STARTOBF*/
// redrawDocument = rdD
// checkSize = cS
// reWindow = rW
// findWindowFramingArea = fwFA
// checkWindow = chW
// letsDrawDocument = LDDoc
// defaultWindowCheck = dWC
// docuReady = dxR
// currWidth = DHx
// currHeight = CRH1
// currW1 = DHx
// currH1 = CRH1
// highestW = ooP
// highestH = hTm
// highestDiffW = sSl
// highestDiffH = SeO
// calculatedAreaW = aPi
// calculatedAreaH = RsS
// calculatedAreaDiffW = pHp
// calculatedAreaDiffH = W3c
// windowFramingW = mP3
// windowFramingH = wFH
// msieAppName = msAN
// elUserAgent = eUA
// cWINw = NsFINw
// cWINh = PdF
// countTries = cT
/* ADDED FOR SEO/FUN (TtF=0,tTf=0,xSl=0,nSf=0) */
// ogFRAMEheight = ogRtF
// ogFRAMEwidth = ogwiKI
// lastShown = laSH
// lastShown = laSH
// hideMenu = hiM
// cualMenu = cMe
// FRAMEheight = RtF
// FRAMEwidth = wiKI
// nfh = JsP
// nfw = nSP
// hideMenus = hiMs
/*ENDOBF*/

var docuReady = 0;
var currWidth = '';
var currHeight = '';
var currW1 = 0;
var currH1 = 0;
var highestW = 0;
var highestH = 0;
var highestDiffW = 0;
var highestDiffH = 0;

var calculatedAreaW = 0;
var calculatedAreaH = 0;
var calculatedAreaDiffW = 0;
var calculatedAreaDiffH = 0;
var windowFramingW = 0;
var windowFramingH = 0;

var countTries = 0;
var naviG = navigator.userAgent;

function redrawDocument() {
	var	gva = getViewableArea();
	currWidth = gva[0];currHeight = gva[1];
	document.getElementById("PreviewScreen").style.width = '' + currWidth + 'px';
	document.getElementById("PreviewScreen").style.height = '' + currHeight + 'px';
	document.getElementById("PreviewScreen").style.clip = 'rect(0px,'+currWidth+'px,'+currHeight+'px,0px)';
	document.getElementById("ActivePreviewScreen").style.width = '' + currWidth + 'px';
	document.getElementById("ActivePreviewScreen").style.height = '' + currHeight + 'px';
	document.getElementById("ActivePreviewScreen").style.clip = 'rect(0px,'+currWidth+'px,'+currHeight+'px,0px)';
}
var checkWindow = function(ww,wh,dw,dh) {
	dW = Number(dw);
	dH = Number(dh);
	var cntsize = 0;
	var naviG = navigator.userAgent;
	var	mcz = checkSize();
};

/*
WHAT MOST BROWSERS DO:
window.open(highestscreen) MAY open window with a size smaller than actual screen available space,
to counter we must tell chrome to resize itself to highest screen, which will fix the window.size issue...
NOW: we find real document.innerSize
*/
function checkSize() {
	var	gva = getViewableArea();
	currW1 = gva[0];currH1 = gva[1];
	// if takes a bit more to capture requested sizing then simply try again
	if ((currW1 == 0 || currH1 == 0) && countTries < 3) { setTimeout(checkSize,100); }
	else {
		/* remaking window to large gives us highest window document.innerSize availability */
		remakeWindow(screen.width,screen.height);
		// capture final w/h
		setTimeout(reWindow,100);
	}
	countTries++;
}
/* help find true document.innerSize */
/* remaking window to 500x500 gives us window.framing sizing hence status/address/scroll bars */
function reWindow() {
	var gva2 = getViewableArea();
	highestW = gva2[0];
	highestH = gva2[1];
	highestDiffW = (screen.width - highestW);
	highestDiffH = (screen.height - highestH);
	// capture final w/h
	remakeWindow(500,500);
	setTimeout(findWindowFramingArea,100);
}
/* finds true windowFraming area and document.innerSize */
function findWindowFramingArea() {
	var gva3 = getViewableArea();
	calculatedAreaW = gva3[0];calculatedAreaH = gva3[1];
	// if document.innerSize is lower than what requested for window size [then our resizing worked]
	if (calculatedAreaW < 500 || calculatedAreaH < 500) { calculatedAreaDiffW = (500 - calculatedAreaW); calculatedAreaDiffH = (500 - calculatedAreaH); }
	// if isn't set the common params...
	else { calculatedAreaDiffW = 20; calculatedAreaDiffH = 50; }
	windowFramingW = calculatedAreaDiffW;
	windowFramingH = calculatedAreaDiffH;
/*
	document.getElementById("body").style.overflow = 'scroll';
	var gva4 = getViewableArea();
	windowFramingWithVScrollW = gva4[0];windowFramingWithVScrollH = gva4[1];
	if (windowFramingWithVScrollW < 500 || windowFramingWithVScrollH < 500) { 
		windowFramingWithVScrollDiffW = (500 - windowFramingWithVScrollW); 
		windowFramingWithVScrollDiffH = (500 - windowFramingWithVScrollW);
	}
	
	alert('nW: '+windowFramingWithVScrollDiffW+' H: '+windowFramingWithVScrollDiffH+' dW: '+windowFramingWithXScrollW+' dH: '+windowFramingWithXScrollH);

*/

//	document.getElementById("out").innerHTML='HIGHEST POSSIBLE INNER.DOCUMENT W: '+highestW+' H: '+highestH+' <br>FULLDIFF W: '+highestDiffW+' H: '+highestDiffH+
//	'<br><br>CA W: '+calculatedAreaW+' H: '+calculatedAreaH+'<br>CADIFF W: '+windowFramingW+' H: '+windowFramingH+'';

// SCROLLBAR SIZE: MSIE = 20px, ALL OTHERS 12px
// FORCE SCROLLBAR: MSIE = nothing special, while ALL OTHERS overflowX or overflowY is needed

//	alert('dW: '+dW+' dH: '+dH);
//	alert('dW: '+dW+' dH: '+dH);
	var msieAppName = 'Microsoft Internet Explorer';
	var elUserAgent = ''+navigator.userAgent+'';
	
	if (navigator.appName == msieAppName) { elScroll = 20; }
	else { elScroll = 12; }
	// top 10px/bottom 10px menu offset [closed position] +2 for frame border top1px bot1px
	dH = dH + 42;
	// left/right menu triggers +2 for frame border left1px right1px
	dW = dW + 20;
	if (dW > highestW) {
		dW = highestW;
		dH = Number(dH+elScroll);
		// no forced scroll bars for msie or chrome
		if (navigator.appName == msieAppName || elUserAgent.indexOf('Chrome') != -1) {
			// msie will always have statusbar so must take this info consideration
			if (navigator.appName == msieAppName) {
				dW = Number(highestW - elScroll) - 6;
			}
		}
		else { document.getElementById("PreviewScreen").style.overflowX = 'scroll'; }
	}
	if (dH > highestH) {
		dH = highestH;
		dW = Number(dW+elScroll);
		// no forced scroll bars for msie or chrome
		if (navigator.appName == msieAppName || elUserAgent.indexOf('Chrome') != -1) {
			// msie will always have statusbar so must take this info consideration
			if (navigator.appName == msieAppName) {
				dH = Number(highestH - elScroll) - 6;
			}
		}
		else { document.getElementById("PreviewScreen").style.overflowY = 'scroll';	}
	}
	// for bottom and top bars

	nW = Number(windowFramingW + Number(dW));
	nH = Number(windowFramingH + Number(dH));
//	alert('highestW: '+highestW+' highestH: '+highestH);
	
	//alert('nW: '+nW+' H: '+nH+' dW: '+dW+' dH: '+dH+' wfW: '+windowFramingW+' wfH: '+windowFramingH+'');

	remakeWindow(''+nW+'',''+nH+'');

	// top 10px/bottom 10px menu offset [closed position] +2 for frame border top1px bot1px
	dH = dH - 40 - 2;
	// left/right menu triggers +2 for frame border left1px right1px
	dW = dW - 20 - 2;

	// top/bottom menu widths [add 2 back in]
	document.getElementById("ActiveMenuDataTop").style.width = '' + (dW+2) + 'px';
	document.getElementById("ActiveMenuDataBot").style.width = '' + (dW+2) + 'px';
	$(".ActiveMenuHBar").animate({width:'' + (dW+2) + 'px'}, {duration:400});
	$(".ActiveMenuHLine").animate({width:'' + (dW+2) + 'px'}, {duration:400});

	document.getElementById("PreviewScreen").style.width = '' + dW + 'px';
	document.getElementById("PreviewScreen").style.height = '' + dH + 'px';
	document.getElementById("PreviewScreen").style.clip = 'rect(0px,'+dW+'px,'+dH+'px,0px)';
	document.getElementById("ActivePreviewScreen").style.width = '' + dW + 'px';
	document.getElementById("ActivePreviewScreen").style.height = '' + dH + 'px';
	document.getElementById("ActivePreviewScreen").style.clip = 'rect(0px,'+dW+'px,'+dH+'px,0px)';
}

function defaultWindowCheck() {
	var msieAppName = 'Microsoft Internet Explorer';
	var elUserAgent = ''+navigator.userAgent+'';
	var elFIRE = 0;
	// ONLY FIRED from fullscreen sized popup windows
	// for all non msie [find root cause of this bug - disable this to rebug]
	// all browsers minus msie have width issue which hides part of the horizontal scroll bar on generic HTML documents
	// we resize to smaller viewport to make sure scrollbar shows fully [makes for nice looking framed keyport - we can reset screen's position and size to hide all possibilities of viewsource - but people will find what they want to find]

		var cWINw = document.getElementById("PreviewScreen").style.width;
		var cWINh = document.getElementById("PreviewScreen").style.height;
		cWINw = parseFloat(cWINw.replace('px', ''));
		cWINh = parseFloat(cWINh.replace('px', ''));

	if (!(navigator.appName == msieAppName)) {
		// only for firefox [needs to be forced to scroll vertically]
		if (elUserAgent.indexOf('Firefox') != -1) {
			document.getElementById("PreviewScreen").style.overflowY = 'scroll';
			// make it smaller by 2px only firefox
			elFIRE = 2;
		}
	}
		// make ALL smaller by 2px only firefox
		var elALL = 20 - elFIRE;
		var elALLh = elALL + 20;
		document.getElementById("PreviewScreen").style.width = parseFloat(cWINw - 5 - elALL) + 'px';
		document.getElementById("PreviewScreen").style.height = parseFloat(cWINh - 5 - elALLh) + 'px';
		document.getElementById("ActivePreviewScreen").style.width = parseFloat(cWINw - 4 - elALL) + 'px';
		document.getElementById("ActivePreviewScreen").style.height = parseFloat(cWINh - 4 - elALLh) + 'px';
}






	function letsDrawDocument() {
		redrawDocument();
	}
	
	

	
	
	
	
	
/*JOINED HERE - this part on was set after hlS(hideLoadscreen) script in OG setup*/



	var ogFRAMEheight = '';
	var ogFRAMEwidth = '';
	var lastShown = '';
	var showMenu = function(cualMenu) {
			if (lastShown != cualMenu) {
				hideMenu(lastShown);
			}
			lastShown = cualMenu;

				$("#"+cualMenu+"").stop().animate({height:"50px"}, {duration:400});
				if (ogFRAMEheight == '') { 
					FRAMEheight = parseFloat($("#PreviewScreen").css("height"));
					ogFRAMEheight = FRAMEheight;
				}else { FRAMEheight = ogFRAMEheight; }
				if (ogFRAMEwidth == '') { 
					FRAMEwidth = parseFloat($("#PreviewScreen").css("width"));
					ogFRAMEwidth = FRAMEwidth; 
				} else { FRAMEwidth = ogFRAMEwidth; }
				// 6 for bot and 50 for top
				nfh = parseFloat(FRAMEheight - (50 - 15)) +"px";
				$("#ActivePreviewScreen").stop().animate({height:nfh}, {duration:400, complete:function(){
						$("#PreviewScreen").css({height: nfh})
					}});
				
				document.getElementById("ActiveMenuDataTop").innerHTML = '1 ' + ogFRAMEheight + ' ' + nfh + '::';
	};
	var hideMenu = function(ls) {
		if (ls != '') {
			$("#"+ls+"").stop().animate({height:"15px"}, {duration:400});
			//  reset frame back to original sizing
			lastShown = '';
		}
		if (ogFRAMEheight != '') {
			nfh = ogFRAMEheight +"px";
			$("#ActivePreviewScreen").stop().animate({height:nfh}, {duration:400});
			$("#PreviewScreen").css({height: nfh});
			document.getElementById("ActiveMenuDataTop").innerHTML = '2 ' + ogFRAMEheight + ' ' + nfh + '::';
		}
		if (ogFRAMEwidth != 0) {
			nfw = ogFRAMEwidth +"px";
			$("#ActivePreviewScreen").stop().animate({height:nfw}, {duration:400});
		}

	};
	var hideMenus = function() {
	//alert(ogFRAMEheight);
		if (ogFRAMEheight != '' && lastShown != '') {
			nfh = ogFRAMEheight +"px";
			$("#ActivePreviewScreen").stop().animate({height:nfh}, {duration:400,queue:false});
			$("#PreviewScreen").css({height: nfh});
			$("#ActiveMenuDataTop").stop().animate({height:"15px"}, {duration:400,queue:true});
			$("#ActiveMenuDataBot").stop().animate({height:"15px"}, {duration:400,queue: true});
			//$("#ActivePreviewScreen").stop().animate({height:nfh}, {duration:400});
			document.getElementById("ActiveMenuDataTop").innerHTML = '3 ' + ogFRAMEheight + ' ' + document.getElementById("PreviewScreen").style.height + ' ' + document.getElementById("ActivePreviewScreen").style.height + '';
		}
//			$("#PreviewScreen").css({height: nfh});
//			$("#ActivePreviewScreen").css({height: nfh});
//		$("#"+lastShown+"").stop().animate({height:"15px"}, {duration:400});
		//  reset frame back to original sizing
//		if (ogFRAMEheight != 0) {
//			nfh = ogFRAMEheight +"px";
//			$("#ActivePreviewScreen").stop().animate({height:nfh}, {duration:400});
//			$("#PreviewScreen").css({height: nfh});
//			$("#ActivePreviewScreen").css({height: nfh});
//			document.getElementById("ActiveMenuDataTop").innerHTML = '3 ' + ogFRAMEheight + ' ' + document.getElementById("PreviewScreen").style.height + ' ' + document.getElementById("ActivePreviewScreen").style.height + '';
//		}
//		if (ogFRAMEwidth != 0) {
//			nfw = ogFRAMEwidth +"px";
//			$("#ActivePreviewScreen").stop().animate({height:nfw}, {duration:400});
//		}
//		lastShown = '';
	};