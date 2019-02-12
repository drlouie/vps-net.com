$(document).ready(function() {
	var lastMain = '';
	var loadTimer = '';
	var hash = window.location.hash.substr(1);
	var rel = $('#web-design-scripts li a').each(function(){
		var rel = $(this).attr('rel');
		var href = $(this).attr('href');
		if(hash==rel.substr(0,rel.length-5)){
			var toLoad = hash+'.html #graphical-user-interface';
			$('#graphical-user-interface').load(toLoad)
		}
		$(this).click(function(){
			document.location.href = ''+href+'';
		});
	});

	$('#web-design-scripts li a').mouseover(function(){
		clearTimeout(loadTimer);

		if (lastMain != this) {

			$(lastMain).stop().animate({backgroundPosition:"(40px 35px)"}, {duration:1, complete:function(){
				$(lastMain).css({backgroundPosition: "-10px 35px"})
			}})

			var toLoad = $(this).attr('rel')+' #graphical-user-interface';
			loadTimer = setTimeout(function(){  $('#graphical-user-interface').hide('fast',loadContent);  }, 1 );
			$(this).stop().animate({backgroundPosition:"(-10px 94px)"}, {duration:10})
			// $('#load').remove();
			//$('#wrapper').append('');
			// $('#load').fadeIn('normal');
		
			// make document location refresh
			// window.location.hash = $(this).attr('rel').substr(0,$(this).attr('rel').length-5);
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
		var toLoad = $(this).attr('rel')+' #graphical-user-interface';
		loadTimer = setTimeout(function(){  $('#graphical-user-interface').hide('fast',loadContent);  }, 1 );
		$(this).stop().animate({backgroundPosition:"(-10px 94px)"}, {duration:10})
		// $('#load').remove();
		//$('#wrapper').append('');
		// $('#load').fadeIn('normal');
		
		// make document location refresh
		// window.location.hash = $(this).attr('rel').substr(0,$(this).attr('rel').length-5);
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
		var toLoad = $(this).attr('rel')+' #graphical-user-interface';
		loadTimer = setTimeout(function(){  $('#graphical-user-interface').hide('fast',loadContent);  }, 1 );
		
		$(this).stop().animate({backgroundPosition:"(-10px 94px)"}, {duration:10})
		// $('#load').remove();
		//$('#wrapper').append('');
		// $('#load').fadeIn('normal');
		
		// make document location refresh
		// window.location.hash = $(this).attr('rel').substr(0,$(this).attr('rel').length-5);
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

