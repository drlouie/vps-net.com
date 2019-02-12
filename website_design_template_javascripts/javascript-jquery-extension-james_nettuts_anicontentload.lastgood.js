$(document).ready(function() {
	var lastMain = '';
	var loadTimer = '';
	var hash = window.location.hash.substr(1);
	var href = $('#web-design-scripts li a').each(function(){
		var href = $(this).attr('href');
		if(hash==href.substr(0,href.length-5)){
			var toLoad = hash+'.html #graphical-user-interface';
			$('#graphical-user-interface').load(toLoad)
		}
	});

	$('#web-design-scripts li a').mouseover(function(){
		clearTimeout(loadTimer);

		if (lastMain != this) {

			$(lastMain).stop().animate({backgroundPosition:"(40px 35px)"}, {duration:1, complete:function(){
				$(lastMain).css({backgroundPosition: "-10px 35px"})
			}})

			var toLoad = $(this).attr('href')+' #graphical-user-interface';
			loadTimer = setTimeout(function(){  $('#graphical-user-interface').hide('fast',loadContent);  }, 1 );
			$(this).stop().animate({backgroundPosition:"(-10px 94px)"}, {duration:10})
			// $('#load').remove();
			//$('#wrapper').append('');
			// $('#load').fadeIn('normal');
		
			// make document location refresh
			// window.location.hash = $(this).attr('href').substr(0,$(this).attr('href').length-5);
			function loadContent() {
				$('#graphical-user-interface').load(toLoad,'',showNewContent())
			}
			function showNewContent() {
				$('#graphical-user-interface').show('normal',hideLoader());
			}
			function hideLoader() {
			// $('#load').fadeOut('normal');
			}
		}

		lastMain = this;
		return false;
	});

	$('#web-design-scripts li a').focus(function(){
		clearTimeout(loadTimer);

		if (lastMain != this) {
			$(lastMain).stop().animate({backgroundPosition:"(40px 35px)"}, {duration:1, complete:function(){
				$(lastMain).css({backgroundPosition: "-10px 35px"})
			}})
		var toLoad = $(this).attr('href')+' #graphical-user-interface';
		loadTimer = setTimeout(function(){  $('#graphical-user-interface').hide('fast',loadContent);  }, 1 );
		$(this).stop().animate({backgroundPosition:"(-10px 94px)"}, {duration:10})
		// $('#load').remove();
		//$('#wrapper').append('');
		// $('#load').fadeIn('normal');
		
		// make document location refresh
		// window.location.hash = $(this).attr('href').substr(0,$(this).attr('href').length-5);
		function loadContent() {
			$('#graphical-user-interface').load(toLoad,'',showNewContent())
		}
		function showNewContent() {
			$('#graphical-user-interface').show('normal',hideLoader());
		}
		function hideLoader() {
			// $('#load').fadeOut('normal');
		}
		}

		lastMain = this;
		return false;
	});	
	
	$('#web-design-scripts li a').click(function(){
		clearTimeout(loadTimer);

		if (lastMain != this) {
			$(lastMain).stop().animate({backgroundPosition:"(40px 35px)"}, {duration:1, complete:function(){
				$(lastMain).css({backgroundPosition: "-10px 35px"})
			}})
		var toLoad = $(this).attr('href')+' #graphical-user-interface';
		loadTimer = setTimeout(function(){  $('#graphical-user-interface').hide('fast',loadContent);  }, 1 );
		
		$(this).stop().animate({backgroundPosition:"(-10px 94px)"}, {duration:10})
		// $('#load').remove();
		//$('#wrapper').append('');
		// $('#load').fadeIn('normal');
		
		// make document location refresh
		// window.location.hash = $(this).attr('href').substr(0,$(this).attr('href').length-5);
		function loadContent() {
			$('#graphical-user-interface').load(toLoad,'',showNewContent())
		}
		function showNewContent() {
			$('#graphical-user-interface').show('normal',hideLoader());
		}
		function hideLoader() {
			// $('#load').fadeOut('normal');
		}
		}

		lastMain = this;
		return false;
	
	});

	$('#web-design-scripts li a').mouseout(function(){
		return false;
	});

	$('#web-design-scripts li a').keyup(function(){
		return false;
	});
	/*mainMenuFocus onload set by templater*/
	if (setMainMenuFocus != 0) { 
		// SETUP FOCUS
		// -- >> alert(setMainMenuFocus); 
		if ($('#web-design-scripts ul ')) $('#web-design-scripts ul ').focus(); 
		if ($('#website-tools-and-widgets')) $('#website-tools-and-widgets').focus();
	}
});

