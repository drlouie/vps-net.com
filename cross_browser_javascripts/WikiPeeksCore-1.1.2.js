
/* OBFUSCATION: of the following lines, obfuscatables contain ( = ) and (// ) */
/*<OBF>*/
// parentAppendElement = iNTeRfACe
// tag = crOss_BRoWsEr
// elfarg = eNgINeeRINg
// whichitem = jAvAScrRIpT
// scrollToTop = dEvELoPMenT
// scrollToItem = wEbSITe
// titleHspace = fEEdS
// historyHspace = SeaRCh_eNGinE
// inDocuAn = oPTImiZaTiON
// fancyHref = rELaTiVE
// loadAnchors = coNtEnt
// myHistory = dAtA
// imselected = SeRVicEs
// scrollMaster = mArKeTiNG
/*</OBF>*/


// controlled(sliding) scrollTo inDocument Anchors
var mwbt=0;
var mwbh=0;
var fancySlide2 = function(swasher) { };
var fancyToggle2 = function(swasher) { };
var advertiseAmazon2 = function(swasher) { };
var whichFancySlide;
var whichFancyToggle;
var elDocumento;
var whichAdvertiser;
var innerOne = 0;
//-- set how much to scroll-up above the inDoc anchor
var topTheItem = -8;
if (!(!parent.document)) {
	//--> framed/iframe
	if (!(!parent.fancySlide)) {
		whichFancySlide = parent.fancySlide;
		whichFancyToggle = parent.fancyToggle;
		elDocumento = parent.document;
		whichAdvertiser = parent.advertiseAmazon;
	}
	//--> noframes
	else {
		whichFancySlide = fancySlide2;
		whichFancyToggle = fancyToggle2;
		elDocumento = document;
		whichAdvertiser = advertiseAmazon;
		innerOne = 1;
		topTheItem = -40;
	}
}
//--> noparent
else {
	whichFancySlide = fancySlide2;
	whichFancyToggle = fancyToggle2;
	elDocumento = document;
	whichAdvertiser = advertiseAmazon2;
	innerOne = 1;
	topTheItem = -40;
}
$(document).click(function(e) {
	console.log('Track: 1');
	var targ;
	var elfarg;
	var mtpn;
	if (!e) { var e = window.event; }
	if (e.target) { targ = e.target;  }
	else if (e.srcElement) { targ = e.srcElement; }
	// element clicked is the flat text of an A
	if ($(targ).is('a','href') || $(targ).is('h1','href') || $(targ).is('h2','href') || $(targ).is('h3','href') || $(targ).is('h4','href') || $(targ).is('h5','href')) {
		console.log('Track: 2a');
		if (!(!$(targ)[0]["href"])) {
			elfarg = $(targ)[0]["href"].toString();
			if (elfarg.indexOf(""+QueryString+"#") != -1) {
				scrollMaster(1,e,elfarg.split('#')[1],($(targ)[0].innerHTML).replace(/(<([^>]+)>)/ig,""));
			}
		}
	}
	// only if we find this inDocument anchor to be truly within current document location href
	// only matching for DNF and SPAN children of the eventANCHOR
	else if ($(targ).is('dfn') || $(targ).is('span') || $(targ).is('code') || $(targ).is('b') || $(targ).is('cite') || $(targ).is('samp')) {
		console.log('Track: 2b');
		myTarget = $(targ).get();
		if (!(!myTarget[0].parentNode)) {
			console.log('Track: 3a');
			// element parent.parent.parent matches inDocument anchor params
			mtpn = ""+myTarget[0].parentNode.parentNode.parentNode+"";
			if (mtpn.indexOf("?"+QueryString+"#") != -1) {
				console.log('Track: 4a');
				scrollMaster(2,e,mtpn.split('#')[1],(myTarget[0].parentNode.parentNode.parentNode.innerHTML).replace(/(<([^>]+)>)/ig,"")); 
			}
			else {
				console.log('Track: 4b');
				// element parent.parent matches inDocument anchor params
				mtpn = ""+myTarget[0].parentNode.parentNode+""; 
				if (mtpn.indexOf("?"+QueryString+"#") != -1) {
					console.log('Track: 5a');
					scrollMaster(3,e,mtpn.split('#')[1],(myTarget[0].parentNode.parentNode.innerHTML).replace(/(<([^>]+)>)/ig,"")); 
				}
				else {
					console.log('Track: 5b');
					// element parent matches inDocument anchor params
					mtpn = ""+myTarget[0].parentNode+""; 
					if (mtpn.indexOf("?"+QueryString+"#") != -1) { 
						console.log('Track: 6a');
						scrollMaster(4,e,mtpn.split('#')[1],(myTarget[0].parentNode.innerHTML).replace(/(<([^>]+)>)/ig,"")); 
					} 
				}	
			}
		}
	}
	// for any other clicks on document, we bring focus to this document and hide menu
	else {
		console.log('Track: 2c');
		if (!(!whichFancySlide)) { 
			console.log('Track: 3b');
			whichFancySlide(0); 
		}
	}
});
var ktfs=function(swasher){return false;};

// history holder
var wIKi = [];
var pEeKS = new Array();
var apPlICAtIoN = function(node, text) {
	return wIKi[0] = {
		node: node,
		text: text
	}
};
// element attach w/listener [select list]
var parentAppendElement = function(node,tag,id) {
	if (!(!elDocumento)) {
		var ne = elDocumento.createElement(tag);
		if(id) ne.id = id;
		// common
		if (ne.addEventListener) {
			ne.addEventListener('focus', function(){if (!(!whichFancySlide)) { whichFancySlide(1)}}, false);
			ne.addEventListener('keyup', function(){scrollToItem(ne)}, false);
			ne.addEventListener('change', function(){scrollToItem(ne)}, false);
		}
		// msie
		else if (ne.attachEvent) {
			ne.attachEvent('onfocus', function(){if (!(!whichFancySlide)) { whichFancySlide(1)}} );
			ne.attachEvent('onkeyup', function(){scrollToItem(ne)}, false);
			ne.attachEvent('onchange', function(){scrollToItem(ne)} );
		}
		return node.appendChild(ne);
	}
};
var scrollToItem = function(whichitem) {
	if (!(!whichFancySlide) && !(!whichFancyToggle)) {
		whichFancySlide(0);
		whichFancyToggle(1);
		whichFancySlide(1);
	}
	if (!(whichitem.options[whichitem.selectedIndex].value.indexOf("EMPTYSPACE") != -1)) {
		// running scrollTop for topmost allows us to scroll to the very top, opposed to the common scrollTo with margin:true below
		if (whichitem.options[whichitem.selectedIndex].value.indexOf("topmost") != -1) { scrollToTop(); }
		else { 
			//offset so we don't scroll to the top of the text, but give it a whitespace (if pre-content allows) of 8px above
			$.scrollTo($($("#"+whichitem.options[whichitem.selectedIndex].value+"")), { axis:'y', duration: 750, offset: {top:topTheItem}}); 
			mwbt.innerHTML = logo+'<a title="Back to top" style="cursor:pointer;color:#266899;font-weight:bold;">'+myTitle+'</a>';
			if (mwbt.addEventListener) { mwbt.addEventListener('click',scrollToTop,false); }
			else if (mwbt.attachEvent) { mwbt.attachEvent('onclick',scrollToTop,false); }
		}
	}
	whichitem.selected = whichitem.selectedIndex;
};
var WikiPeeksTitleStyle = 'color:#000000;';
// can only happen when locSelList is available anyway
var scrollToTop = function() {
	//offset too much to top document, even past the topmost anchor [no whitespace above our final topmost position]
	$.scrollTo($($("a#topmost")), { axis:'y', duration: 750, offset: {top:-20}});
	// if pEeKS is empty then set the main item as title
	// was, strict
	// mwbt.innerHTML = logo+'<b title="Source '+source+': '+bpath+'" style="color:#000000;">'+myTitle+'</b>';
	// now customizable via variable
	mwbt.innerHTML = logo+'<b title="Source '+source+': '+bpath+'" style="'+WikiPeeksTitleStyle+'">'+myTitle+'</b>';

	if (mwbt.removeEventListener) { mwbt.removeEventListener('click',scrollToTop,false); }
	else if (mwbt.detachEvent) { mwbt.detachEvent('onclick',scrollToTop,false); }
	if (countAnchors > 0) {
		wiki_peeks_application_programming_api(0);
	}
	else {
		if (!(!elDocumento.getElementById("ActiveHistoryList"))) {
			elDocumento.getElementById("ActiveHistoryList").options[0].selected = true;
		}
	}
};
var getBarSizing = function() {
	// + 10/5 for margin-left space
	// fullW is full width of working area within bar
	titleHspace = (mwbt.clientWidth + 10);
	historyHspace = (mwbh.clientWidth + 5);
	totalW = (titleHspace + historyHspace);
	fullW = (fbsl.clientWidth);
};
var addAnchors = function() {
	if (!(!mwbh)) {
	// default anchors s
	mwbh.innerHTML = titleLink;
	newSelect = parentAppendElement(mwbh,'select','ActiveHistoryList');
	// default anchors e
	// :now if we are coming into doc with pre-selected anchor
	var fancyHref = ''+document.location+'';
	if (fancyHref.indexOf('#') != -1) {
		inDocuAn = fancyHref.split('#')[1];
		wiki_peeks_application_programming_api(inDocuAn);
	}
	// :else no anchor selected
	else { wiki_peeks_application_programming_api(0); }
	}
};
var doUnload = function() {
	if (!(!wbct)) { wbct.innerHTML = loadImage; }
};




var WikiPeeksTitleStyleActive = 'cursor:pointer;color:#266899;font-weight:bold;';
var scrollMaster = function(source,e,myt,texter) {
	if (!(!mwbt)) {
		console.log('Track: 7');
		loadAnchors = countAnchors;
		if (myt != 0 || !(myt.indexOf("EMPTYSPACE") != -1)) { 
			console.log('Track: 8');
			e.preventDefault();
			mytee = $("#"+myt+"").get();
			$.scrollTo($($(mytee)), { axis:'y', duration: 750, offset: {top:topTheItem}});
			if (mwbt!=0) {
				console.log('Track: 9');
				if (!wIKi[myt]) {
					if (loadAnchors <= 0) {
						if (!wIKi["topmost"]) {
							pEeKS.push("topmost");
							wIKi["topmost"] = apPlICAtIoN("topmost", "");
						}
						pEeKS.push(myt);
						wIKi[myt] = apPlICAtIoN(myt,delimiter+''+texter);
					}
				}
				mwbt.innerHTML = logo+'<a title="Back to top" style="'+WikiPeeksTitleStyleActive+'">'+topTitle+'</a>';
				if (mwbt.addEventListener) {
					mwbt.addEventListener('click',scrollToTop,false);
				} 
				else if (mwbt.attachEvent) {
					mwbt.attachEvent('onclick',scrollToTop,false);
				}

				var myHistory;
				var imselected;
				mwbh.innerHTML = titleLink;
				newSelect = parentAppendElement(mwbh,'select','ActiveHistoryList');
				wiki_peeks_application_programming_api(myt);
				if (pEeKS.length > 0) {
					for(var i=0; i< pEeKS.length; i++) {
						imselected = '';
						newSelect.options[i] = new Option(wIKi[pEeKS[i]].text);
						newSelect.options[i].value = pEeKS[i];
						if (pEeKS[i] == myt) { newSelect.options[i].selected = true; }
					}
				}
				if (!(!whichFancySlide) && !(!whichFancyToggle)) {
					whichFancySlide(0);
					whichFancyToggle(1);
					whichFancySlide(1);
				}
			}
		}
	}
};











