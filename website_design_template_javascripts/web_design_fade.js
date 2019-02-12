//////////////////////////////////////////////////////////////////////////////////
// DOM Fader V1.0.9
// (c) 2004 by Luis Gustavo Rodriguez <https://www.louierd.com>
// MIT License
//
// Please retain this copyright header in all versions of the script
//////////////////////////////////////////////////////////////////////////////////
/*/ VPS-NET-SCRIPTS: CROSS-BROWSER SLOW FADER JAVASCRIPT /*/
var cual = '';
var vis = '';
var sop = '';
var fop = '';
var currOpacity = '';
var voz = '';
var viz = '';

//--> functions for radioLayer
function slowFadeOut(cual,lapse) {
	cual = cual; lapse = lapse;
	voz.thisTimeout = window.setTimeout("fader('" + cual + "','hide','90','20','100')",lapse);
}
function slowFadeIn(cual,lapse) {
	cual = cual; lapse = lapse;
	viz.thisTimeout = window.setTimeout("fader('" + cual + "','show','01','90','00')",lapse);
}

//--> layer, show/hide, startOP, finishOP, currOP
var me = '';
function fader(cual, vis, sop, fop, currOpacity) {

	if (voz.thisTimeout) { window.clearTimeout(voz.thisTimeout); }
	if (viz.thisTimeout) { window.clearTimeout(viz.thisTimeout); }
	if (me.thisTimeout) { window.clearTimeout(me.thisTimeout); }
	
	currOpacity = Number(currOpacity);
	if (vis == 'show') {
		if (fop > currOpacity) { 
			newOpacity = Number(currOpacity + 1);
			currOpacity = newOpacity;
		}
	}
	else if (vis == 'hide') {
		if (fop < currOpacity) { 
			newOpacity = Number(currOpacity - 1);
			currOpacity = newOpacity;
		}

	}

	myLayer = document.getElementById(""+cual+"").style;
 	if (myLayer.MozOpacity)
		myLayer.MozOpacity="." + currOpacity + "";
	else if (myLayer.filter)
   		myLayer.filter = "Alpha(Opacity=" + currOpacity + ");";

	me.thisTimeout = window.setTimeout("fader('" + cual + "','" + sop + "','" + fop + "','" + vis + "','" + currOpacity + "')", 30);

}









window.status = "";