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