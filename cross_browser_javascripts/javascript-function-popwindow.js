/*
* 
* This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License along with this program; if not, write to:
* the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
* 
* Script: multi-browser New Window Opener [ Popup Window Controller ]
* Author: Louie Rd (Luis Rodriguez) [ http://louierd.com/about/ ]
* Release: October 28, 2002
* Updated On: March 17, 2010 [ie8]
* Version: 1.2
* Description: 	Allows for dynamic popup windows while automatically centering new window on screen.
*				Yes, I do know it looks dirty, but works and havent had the time to clean 'er up :(
* 				Did take the time to write this license up though :)
* 
*/

function popWindow(url,nombre,w,h,extras) {
	var todosExtras = new Array();
	if (window.open) {
		// fullscreen for newer browser renditions
		if (extras.indexOf("fullscreen") != -1) {
			//prior to msie 7, must also contain following:
			todosExtras.push('fullscreen=1');
			todosExtras.push('channelmode=1');
		}
		// RESIZE only for non full-screen views
		else {
			requestedWidth = w; requestedHeight = h;
			var windowX = (screen.width/2)-(requestedWidth/2);
			var windowY = (screen.height/2)-(requestedHeight/2);
			todosExtras.push('width='+w);
			todosExtras.push('height='+h);
			todosExtras.push('top=' + windowY);
			todosExtras.push('left=' + windowX);
		}

		if (extras.indexOf("status") != -1) { todosExtras.push('status=1'); }
		else { todosExtras.push('status=0'); }
		if (extras.indexOf("menubar") != -1) { todosExtras.push('menubar=1'); }
		else { todosExtras.push('menubar=0'); }
		if (extras.indexOf("titlebar") != -1) { todosExtras.push('titlebar=1'); }
		else { todosExtras.push('titlebar=0'); }
		if (extras.indexOf("toolbar") != -1) { todosExtras.push('toolbar=1'); }
		else { todosExtras.push('toolbar=0'); }
		if (extras.indexOf("scrollbars") != -1) { todosExtras.push('scrollbars=1'); }
		else { todosExtras.push('scrollbars=0'); }
		if (extras.indexOf("location") != -1) { todosExtras.push('location=1'); }
		else { todosExtras.push('location=0'); }
		if (extras.indexOf("addressbar") != -1) { todosExtras.push('addressbar=1'); }
		else { todosExtras.push('addressbar=0'); }
		if (extras.indexOf("directories") != -1) { todosExtras.push('directories=1'); }
		else { todosExtras.push('directories=0'); }		
		if (extras.indexOf("resizable") != -1) { todosExtras.push('resizable=1'); }
		else { todosExtras.push('resizable=0'); }

		var allExtras = todosExtras.join(",");

		var poppedWindow = window.open(url,nombre,''+allExtras+'');
		if (extras.indexOf("closeParent") != -1) { parent.window.close(); }
		else { poppedWindow.focus(); }
	}
	else {
		alert('Your security settings are not allowing our popup windows to function. Please make sure your security software allows popup windows from our site.');
	}
}



function remakeWindow(w,h) {
	window.resizeTo(w,h);
	windowW = w;
	windowH = h;
	var windowX = (screen.width/2)-(windowW/2);
	var windowY = (screen.height/2)-(windowH/2);
	window.moveTo(windowX, windowY);
	window.resizeTo(w,h);
}