var mwbt=0;var mwbh=0;var fancySlide2=function(swasher){};var fancyToggle2=function(swasher){};var advertiseAmazon2=function(swasher){};var whichFancySlide;var whichFancyToggle;var elDocumento;var whichAdvertiser;var innerOne=0;var elDocumento;var topTheItem=-8;if(!(!parent.document)){if(!(!parent.fancySlide)){whichFancySlide=parent.fancySlide;whichFancyToggle=parent.fancyToggle;elDocumento=parent.document;whichAdvertiser=parent.advertiseAmazon;}else{whichFancySlide=fancySlide2;whichFancyToggle=fancyToggle2;elDocumento=document;whichAdvertiser=advertiseAmazon;innerOne=1;topTheItem=-40;}}else{whichFancySlide=fancySlide2;whichFancyToggle=fancyToggle2;elDocumento=document;whichAdvertiser=advertiseAmazon2;innerOne=1;topTheItem=-40;}$(document).click(function(e){var targ;var eNgINeeRINg;var mtpn;if(!e){var e=window.event;}if(e.target){targ=e.target;}else if(e.srcElement){targ=e.srcElement;}if($(targ).is('a','href')||$(targ).is('h1','href')||$(targ).is('h2','href')||$(targ).is('h3','href')||$(targ).is('h4','href')||$(targ).is('h5','href')){if(!(!$(targ)[0]["href"])){eNgINeeRINg=$(targ)[0]["href"].toString();if(eNgINeeRINg.indexOf(""+QueryString+"#")!=-1){mArKeTiNG(1,e,eNgINeeRINg.split('#')[1],($(targ)[0].innerHTML).replace(/(<([^>]+)>)/ig,""));}}}else if($(targ).is('dfn')||$(targ).is('span')||$(targ).is('code')||$(targ).is('b')||$(targ).is('cite')||$(targ).is('samp')){myTarget=$(targ).get();if(!(!myTarget[0].parentNode)){mtpn=""+myTarget[0].parentNode.parentNode.parentNode+"";if(mtpn.indexOf("?"+QueryString+"#")!=-1){mArKeTiNG(2,e,mtpn.split('#')[1],(myTarget[0].parentNode.parentNode.parentNode.innerHTML).replace(/(<([^>]+)>)/ig,""));}else{mtpn=""+myTarget[0].parentNode.parentNode+"";if(mtpn.indexOf("?"+QueryString+"#")!=-1){mArKeTiNG(3,e,mtpn.split('#')[1],(myTarget[0].parentNode.parentNode.innerHTML).replace(/(<([^>]+)>)/ig,""));}else{mtpn=""+myTarget[0].parentNode+"";if(mtpn.indexOf("?"+QueryString+"#")!=-1){mArKeTiNG(4,e,mtpn.split('#')[1],(myTarget[0].parentNode.innerHTML).replace(/(<([^>]+)>)/ig,""));}}}}}else{ if(!(!whichFancySlide)){whichFancySlide(0);}}});var ktfs=function(swasher){return false;};var wIKi=[];var pEeKS=new Array();var apPlICAtIoN=function(node,text){return wIKi[0]={node:node,text:text}};var iNTeRfACe=function(node,crOss_BRoWsEr,id){if(!(!elDocumento)){var ne=elDocumento.createElement(crOss_BRoWsEr);if(id) ne.id=id;if(ne.addEventListener){ne.addEventListener('focus',function(){if(!(!whichFancySlide)){whichFancySlide(1)}},false);ne.addEventListener('keyup',function(){wEbSITe(ne)},false);ne.addEventListener('change',function(){wEbSITe(ne)},false);}else if(ne.attachEvent){ne.attachEvent('onfocus',function(){if(!(!whichFancySlide)){whichFancySlide(1)}});ne.attachEvent('onkeyup',function(){wEbSITe(ne)},false);ne.attachEvent('onchange',function(){wEbSITe(ne)});}return node.appendChild(ne);}};var wEbSITe=function(jAvAScrRIpT){if(!(!whichFancySlide)&&!(!whichFancyToggle)){whichFancySlide(0);whichFancyToggle(1);whichFancySlide(1);}if(!(jAvAScrRIpT.options[jAvAScrRIpT.selectedIndex].value.indexOf("EMPTYSPACE")!=-1)){if(jAvAScrRIpT.options[jAvAScrRIpT.selectedIndex].value.indexOf("topmost")!=-1){dEvELoPMenT();}else{$.scrollTo($($("#"+jAvAScrRIpT.options[jAvAScrRIpT.selectedIndex].value+"")),{axis:'y',duration:750,offset:{top:topTheItem}});mwbt.innerHTML=logo+'<a title="Back to top" style="cursor:pointer;color:#266899;font-weight:bold;">'+myTitle+'</a>';if(mwbt.addEventListener){mwbt.addEventListener('click',dEvELoPMenT,false);}else if(mwbt.attachEvent){mwbt.attachEvent('onclick',dEvELoPMenT,false);}}}jAvAScrRIpT.selected=jAvAScrRIpT.selectedIndex;};var WikiPeeksTitleStyle='color:#000000;font-weight:bold;';var dEvELoPMenT=function(){$.scrollTo($($("a#topmost")),{axis:'y',duration:750,offset:{top:-20}});mwbt.innerHTML=logo+'<b title="Source '+source+':'+bpath+'" style="'+WikiPeeksTitleStyle+'">'+myTitle+'</b>';if(mwbt.removeEventListener){mwbt.removeEventListener('click',dEvELoPMenT,false);}else if(mwbt.detachEvent){mwbt.detachEvent('onclick',dEvELoPMenT,false);}if(countAnchors>0){wiki_peeks_application_programming_api(0);}else{if(!(!elDocumento.getElementById("ActiveHistoryList"))){elDocumento.getElementById("ActiveHistoryList").options[0].selected=true;}}};var getBarSizing=function(){fEEdS=(mwbt.clientWidth+10);SeaRCh_eNGinE=(mwbh.clientWidth+5);totalW=(fEEdS+SeaRCh_eNGinE);fullW=(fbsl.clientWidth);};var addAnchors=function(){if(!(!mwbh)){mwbh.innerHTML=titleLink;newSelect=iNTeRfACe(mwbh,'select','ActiveHistoryList');var rELaTiVE=''+document.location+'';if(rELaTiVE.indexOf('#')!=-1){oPTImiZaTiON=rELaTiVE.split('#')[1];wiki_peeks_application_programming_api(oPTImiZaTiON);}else{wiki_peeks_application_programming_api(0);}}};var doUnload=function(){if(!(!wbct)){wbct.innerHTML=loadImage;}};var WikiPeeksTitleStyleActive='cursor:pointer;color:#266899;font-weight:bold;';var mArKeTiNG=function(source,e,myt,texter){if(!(!mwbt)){coNtEnt=countAnchors;if(myt!=0||!(myt.indexOf("EMPTYSPACE")!=-1)){e.preventDefault();mytee=$("#"+myt+"").get();$.scrollTo($($(mytee)),{axis:'y',duration:750,offset:{top:topTheItem}});if(mwbt!=0){if(!wIKi[myt]){if(coNtEnt<=0){if(!wIKi["topmost"]){pEeKS.push("topmost");wIKi["topmost"]=apPlICAtIoN("topmost","");}pEeKS.push(myt);wIKi[myt]=apPlICAtIoN(myt,delimiter+''+texter);}}mwbt.innerHTML=logo+'<a title="Back to top" style="'+WikiPeeksTitleStyleActive+'">'+topTitle+'</a>';if(mwbt.addEventListener){mwbt.addEventListener('click',dEvELoPMenT,false);}else if(mwbt.attachEvent){mwbt.attachEvent('onclick',dEvELoPMenT,false);}var dAtA;var SeRVicEs;mwbh.innerHTML=titleLink;newSelect=iNTeRfACe(mwbh,'select','ActiveHistoryList');wiki_peeks_application_programming_api(myt);if(pEeKS.length>0){for(var i=0;i< pEeKS.length;i++){SeRVicEs='';newSelect.options[i]=new Option(wIKi[pEeKS[i]].text);newSelect.options[i].value=pEeKS[i];if(pEeKS[i]==myt){newSelect.options[i].selected=true;}}}if(!(!whichFancySlide)&&!(!whichFancyToggle)){whichFancySlide(0);whichFancyToggle(1);whichFancySlide(1);}}}}};