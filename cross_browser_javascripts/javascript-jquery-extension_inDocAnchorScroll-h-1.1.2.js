/* controlled(sliding) scrollTo inDocument Anchors */
var mwbt=0;
var mwbh=0;
$(document).click(function(e) {
  	var targ;
  	var elfarg;
	var mtpn;
  if (!e) var e = window.event;
  if (e.target) targ = e.target
  else if (e.srcElement) targ = e.srcElement
	/* element clicked is the flat text of an A */
	if ($(targ).is('a','href') || $(targ).is('h1','href') || $(targ).is('h2','href') || $(targ).is('h3','href') || $(targ).is('h4','href') || $(targ).is('h5','href')) {
		if (!(!$(targ)[0]["href"])) {
			elfarg = $(targ)[0]["href"].toString();
			if (elfarg.indexOf(""+QueryString+"#") != -1) {
				scrollMaster(1,e,elfarg.split('#')[1],($(targ)[0].innerHTML).replace(/(<([^>]+)>)/ig,""));
			}
		}
	}
	/* only if we find this inDocument anchor to be truly within current document location href */
	/* only matching for DNF and SPAN children of the eventANCHOR */
	else if ($(targ).is('dfn') || $(targ).is('span') || $(targ).is('code') || $(targ).is('b') || $(targ).is('cite') || $(targ).is('samp')) {
		myTarget = $(targ).get();
	  	if (!(!myTarget[0].parentNode)) {
			/* element parent.parent.parent matches inDocument anchor params */
			mtpn = ""+myTarget[0].parentNode.parentNode.parentNode+"";
			if (mtpn.indexOf("?"+QueryString+"#") != -1) { scrollMaster(2,e,mtpn.split('#')[1],(myTarget[0].parentNode.parentNode.parentNode.innerHTML).replace(/(<([^>]+)>)/ig,"")); }
			else { 
				/* element parent.parent matches inDocument anchor params */ mtpn = ""+myTarget[0].parentNode.parentNode+""; if (mtpn.indexOf("?"+QueryString+"#") != -1) {scrollMaster(3,e,mtpn.split('#')[1],(myTarget[0].parentNode.parentNode.innerHTML).replace(/(<([^>]+)>)/ig,"")); }
				else { /* element parent matches inDocument anchor params */ mtpn = ""+myTarget[0].parentNode+""; if (mtpn.indexOf("?"+QueryString+"#") != -1) { scrollMaster(4,e,mtpn.split('#')[1],(myTarget[0].parentNode.innerHTML).replace(/(<([^>]+)>)/ig,"")); } }
			}
		}
	}
	/* for any other clicks on document, we bring focus to this document and hide menu */
	else {
		if (!(!parent)) { if (!(!parent.fancySlide)) { parent.fancySlide(0); } }
	}
});