var g_iCount = new Number();

// CHANGE THE COUNTDOWN NUMBER HERE - ADD ONE TO IT //
var g_iCount = 15;
function startCountdown(){
	numberCountdown = document.getElementById("numberCountdown");
    if((g_iCount - 1) >= 0){
		g_iCount = g_iCount - 1;
        numberCountdown.innerHTML = 'This window will automatically forward itself in ' + g_iCount + ' seconds.' ;
        setTimeout('startCountdown()',1000);
    }
	else {
		runSwitch();
	}
}
var nowTo = '';
var tipTop = '';
function runSwitch() {
	elGo = '/index.htm';
	elTop = document.location;
	if (tipTop == 'parent') {
		elTop = parent.location;
	}
	if (nowTo != '') { 
		elGo = nowTo; 
	}
	elTop.href = elGo;
}


function triggerClose() {
	window.close();
}