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
* Script: multi-browser GVA (Get Viewable Area - Browser Display) 
* Author: Louie Rd (Luis Rodriguez)
* Description: 	Gets the width and height of the client's workable area by way of DOM
* 
*/
var gvaWidth = 0, gvaHeight = 0, gdsWidth = 0, gdsHeight = 0;
function getViewableArea() {
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

function getDocumentSize() { gdsWidth = document.body.clientWidth; gdsHeight = document.body.clientHeight; return [gdsWidth, gdsHeight]; }