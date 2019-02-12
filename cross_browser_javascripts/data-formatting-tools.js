var Commify = function(number) {
	var cents = '';
	number = ''+number+'';
	newn = number.replace(',',''); 
	noCents = newn.replace('$','');
	if (noCents.indexOf('.') != -1) {
		newn2 = noCents.split('.');
		noCents = newn2[0];
		cents = '.' + newn2[1];
	}
	number = '' + noCents + '';
	if (Number(newn) > 999999) {
		alert('This field only accepts dollar amounts less than 1,000,000 (1 million)!');
		return '' + number + '' + cents + '';
	}
	else if (number.length > 3) {
		var mod = number.length % 3;
		var output = (mod > 0 ? (number.substring(0,mod)) : '');
		for (i=0 ; i < Math.floor(number.length / 3); i++) {
			if ((mod == 0) && (i == 0)) {
				output += number.substring(mod+ 3 * i, mod + 3 * i + 3);
			}
			else {
				output+= ',' + number.substring(mod + 3 * i, mod + 3 * i + 3);
			}
		}
		return (output + '' + cents + '');
	}
	else return '' + number + '' + cents + '';
};

var CurrencyFormatted = function(amount) {
	var i = parseFloat(amount);
	if(isNaN(i)) { i = 0.00; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	i = parseInt((i + .005) * 100);
	i = i / 100;
	s = new String(i);
	if(s.indexOf('.') < 0) { s += '.00'; }
	if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
	s = minus + s;
	return s;
};

var redondo = function(x) {
	return Math.round(x*100)/100;
};

var amtround = function(num) {
	numrnd = 0;
	numrnd = num * 100;
	numrnd = Math.round(numrnd);
	temp1 = numrnd.toString(10);
	temp1n = temp1.length;
	numrnd = temp1.substring(0,temp1n-2) + "." + temp1.substring(temp1n-2,temp1n);	
	numrnd = parseFloat(numrnd);
	return numrnd;
};