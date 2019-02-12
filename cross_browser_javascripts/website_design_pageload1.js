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
* Script: iFRAME 4ALL [ multi-browser iFrame renderer ]
* Author: Louie Rd (Luis Rodriguez) [ http://louierd.com/about/ ]
* Release: December 2001
* Version: 3.1
* Description: 	A successful attempt at creating a multi-browser interface to iFrames which nullified cross-browser bugs. 
*				This fix allowed previously incapable browsers to display and interpret general iFrame [virtual frame] structures, calls and layouts.
*/

function checkBrowser(){this.ver=navigator.appVersion;this.dom=document.getElementById?1:0;this.ie6=(this.ver.indexOf("MSIE 6")>-1&&this.dom)?1:0;this.ie5=(this.ver.indexOf("MSIE 5")>-1&&this.dom)?1:0;this.ie4=(document.all&&!this.dom)?1:0;this.ns5=(this.dom&&parseInt(this.ver)>=5)?1:0;this.ns4=(document.layers&&!this.dom)?1:0;this.bw=(this.ie5||this.ie4||this.ns4||this.ns5);return this};bw=new checkBrowser();function makeObj(obj,nest){nest=(!nest)?'':'document.'+nest+'.';this.css=bw.dom?document.getElementById(obj).style:bw.ie4?document.all[obj].style:bw.ns4?eval(nest+"document.layers."+obj):0;this.evnt=bw.dom?document.getElementById(obj):bw.ie4?document.all[obj]:bw.ns4?eval(nest+"document.layers."+obj):0;this.height=bw.ns4?this.css.document.height||this.css.clip.bottom:this.evnt.offsetHeight||this.css.pixelHeight;this.width=bw.ns4?this.css.document.width:this.evnt.offsetWidth;this.moveIt=b_moveIt;this.x;this.y;this.moveBy=b_moveBy;return this}function b_moveIt(x,y){this.x=x;this.y=y;this.css.left=this.x;this.css.top=this.y}function b_moveBy(x,y){this.moveIt(this.x+x,this.y+y)}function makeFrame(iframe,contdiv,textdiv,arrowdiv,usebuffer){this.loader=new makeObj(iframe,contdiv);if(arrowdiv)this.arrow=new makeObj(arrowdiv);this.usebuffer=(usebuffer||bw.ie4||(bw.ie5&&!bw.ie55)||bw.ns4)&&!bw.ns5;if(this.usebuffer){this.cont=new makeObj(contdiv);if(!bw.ns4){this.ifr=document.frames[iframe];this.text=new makeObj(textdiv)}else{this.text=this.loader};this.text.moveIt(0,0);if(arrowdiv)this.arrow.css.visibility='visible';this.checkloaded=ifr_checkloaded;this.up=ifr_up;this.down=ifr_down;}else if(bw.dom){this.loader.css.visibility='visible'}this.scroll=1;this.loadpage=ifr_loadpage;this.obj=iframe+"Object";eval(this.obj+"=this")}function ifr_up(speed){go=false;if(this.scroll){if(this.text.y<0){this.text.moveBy(0,speed);go=true}}if(go)setTimeout(this.obj+".up("+speed+")",20)}function ifr_down(speed){go=false;if(this.scroll){h=bw.ns4?this.text.css.document.height:this.text.evnt.offsetHeight;if(this.text.y>-h+this.cont.height){this.text.moveBy(0,-speed);go=true}}if(go)setTimeout(this.obj+".down("+speed+")",20)}function ifr_loadpage(url){if(bw.ns4)this.loader.css.load(url,780);else this.loader.evnt.src=url;if(this.usebuffer&&!bw.ns4&&!bw.ns5){setTimeout(this.obj+".checkloaded()",780)}if(this.usebuffer){this.text.moveIt(0,0)}}function ifr_checkloaded(){if(bw.ns6)this.text.evnt.innerHTML=this.ifr.document.getElementsByTagName("body")(0).innerHTML;if(this.ifr.document.readyState=="complete"){this.text.evnt.innerHTML=this.ifr.document.body.innerHTML}else setTimeout(this.obj+".checkloaded()",100)}function ifrinit(){frame=new makeFrame('divLoad','divCont','divIEText','divArrows',useBuffer)}useBuffer=0
