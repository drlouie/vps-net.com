//preload stars
pic1= new Image(); pic1.src="/website_design_template_images/website_design_starRate_whiteBG_" + "0" + "star.gif";
pic2= new Image(); pic2.src="/website_design_template_images/website_design_starRate_whiteBG_" + ".5" + "star.gif";
pic3= new Image(); pic3.src="/website_design_template_images/website_design_starRate_whiteBG_" + "1" + "star.gif";
pic4= new Image(); pic4.src="/website_design_template_images/website_design_starRate_whiteBG_" + "1.5" + "star.gif";
pic5= new Image(); pic5.src="/website_design_template_images/website_design_starRate_whiteBG_" + "2" + "star.gif";
pic6= new Image(); pic6.src="/website_design_template_images/website_design_starRate_whiteBG_" + "2.5" + "star.gif";
pic7= new Image(); pic7.src="/website_design_template_images/website_design_starRate_whiteBG_" + "3" + "star.gif";
pic8= new Image(); pic8.src="/website_design_template_images/website_design_starRate_whiteBG_" + "3.5" + "star.gif";
pic9= new Image(); pic9.src="/website_design_template_images/website_design_starRate_whiteBG_" + "4" + "star.gif";
pic10= new Image(); pic10.src="/website_design_template_images/website_design_starRate_whiteBG_" + "4.5" + "star.gif";
pic11= new Image(); pic11.src="/website_design_template_images/website_design_starRate_whiteBG_" + "5" + "star.gif";

var currStar = 0;
var currID = 0;
var defStar = 0;
var starChart = new Array();
function setDefaultStar(nume, stid) { starChart[stid] = nume; }
function setCurrentStar(nume, starid) { 
	currStar = nume; currID = starid; 
}
function resetStars() {
	if (currID > 0 && starChart[currID] > 0) { 
		document.images["StarRates_"+currID+""].src = '/website_design_template_images/website_design_starRate_whiteBG_' + starChart[currID] + 'star.gif'; 
	}
}
function mouseStars(nume) {
	if (currID > 0 && nume > 0) { document.images["StarRates_"+currID+""].src = '/website_design_template_images/website_design_starRate_whiteBG_' + nume + 'star.gif'; }
}
function rateMe(whoStars) { alert(currID); resetStars(); }
