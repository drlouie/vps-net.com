function checkInputZip(c){if(window.event&&window.event.keyCode){var b=c.value;var d=window.event.keyCode;if(d>47&&d<58){b=c.value;return;}else if(d==13){return;c.parent.submit();}else{window.event.returnValue=null;}}}
var e=new Array();var a=0;
function showSpanners(){if(document.getElementById&&a==0){document.getElementById("spannerL").style.backgroundImage="url('DisasterNotifyImages/tableMidSpanner.gif')";document.getElementById("spannerR").style.backgroundImage="url('DisasterNotifyImages/tableMidSpanner.gif')";a++;}}
