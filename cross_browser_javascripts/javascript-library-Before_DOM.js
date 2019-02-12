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
* Script: Before DOM [ B4DOM ]
* Author: Louie Rd (Luis Rodriguez) [ http://louierd.com/about/ ]
* Release: 2002
* Version: 1.6
* Description: 	A successful attempt at creating a multi-browser interface to the DOM which nullified cross-browser bugs. 
*				This fix allowed previously incapable browsers to display and interpret general DOM structures, calls and layouts.
*/
if(!document.getElementById){document.getElementById=fEl;document.allLayers=new Array();}if(!document.getElementsByTagName||document.all){document.getElementsByTagName=fTa;}function fTa(a1){var ns4=this.layers;var dl=this.allLayers;if(ns4&&!dl.length){var lay=ns4.length?ns4[0]:false;for(var i=0;lay;i++){dl[i]=dl[lay.id]=lay;lay.style=new Object();lay.style.par=lay;set_nsStyle(lay.style);lay=lay.above;}}if(this.body){if(this.all){dl=a1=="*"?this.all:this.all.tags(a1)}else{dl=this.body.getElementsByTagName(a1)}}if(!dl.item){dl.item=fitm}if(!dl.namedItem){dl.namedItem=fitm}return dl;}function fEl(a1){if(this.layers){return this.allLayers[a1]||this.getElementsByTagName()[a1]}return this.all[a1];}function nHeight(a1,a2,a3){this.par.clip.height=parseInt(a3);return fnsHeight(this.par)}function nWidth(a1,a2,a3){this.par.clip.width=parseInt(a3);return fnsWidth(this.par)}function nLeft(a1,a2,a3){this.par.left=parseInt(a3);return a3}function nTop(a1,a2,a3){this.par.top=parseInt(a3);return a3}function nzIndex(a1,a2,a3){return this.par.zIndex=a3}function nVisible(a1,a2,a3){this.par.visibility=a3;return a3}function nClip(a1,a2,a3){var s=a3.split(" ");if(s.length<4){s=a3.split(",")}var c=this.par.clip;var p=parseInt;c.top=p(s[0].substr(5));c.right=p(s[1]);c.bottom=p(s[2]);c.left=p(s[3]);return fnsClip(c);}function nbgColor(a1,a2,a3){this.par.bgColor=a3.toLowerCase()=='transparent'?null:a3;return a3;}function nbgImage(a1,a2,a3){this.par.background.src=a3.substring(a3.indexOf("(")+1,a3.indexOf(")"))||null;return a3;}function set_nsStyle(t){var p=t.par;t.height=fnsHeight(p)+"px";t.width=fnsWidth(p)+"px";t.left=p.left+"px";t.top=p.top+"px";t.zIndex=p.zIndex;t.visibility=fnsV(p.visibility);t.clip=fnsClip(p.clip);t.backgroundColor="";t.backgroundImage="";t.watch("height",nHeight);t.watch("width",nWidth);t.watch("left",nLeft);t.watch("top",nTop);t.watch("zIndex",nzIndex);t.watch("visibility",nVisible);t.watch("clip",nClip);t.watch("backgroundImage",nbgImage);t.watch("backgroundColor",nbgColor);}function fnsV(vis){if(vis=='hide')return 'hidden';if(vis=='show')return 'visible';return 'inherit';}function fnsClip(c){return "rect("+c.top+"px "+c.right+"px "+c.bottom+"px "+c.left+"px)"}function fnsHeight(p){return Math.max(p.clip.height,p.document.height)}function fnsWidth(p){return Math.max(p.clip.width,p.document.width)}function Height(){return this.innerHeight||document.body.clientHeight}function Width(){return this.innerWidth||document.body.clientWidth}function fitm(a1){return this[a1]}
