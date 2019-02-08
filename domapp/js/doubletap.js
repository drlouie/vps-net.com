/*!
* jQuery Double Tap Plugin.
*
* Copyright (c) 2010 Raul Sanchez (http://www.appcropolis.com)
*
* Dual licensed under the MIT and GPL licenses:
* http://www.opensource.org/licenses/mit-license.php
* http://www.gnu.org/licenses/gpl.html
*/
(function($){
    // Determine if we on iPhone or iPad
    var isiOS = false;
    var agent = navigator.userAgent.toLowerCase();
    if(agent.indexOf('iphone') >= 0 || agent.indexOf('ipad') >= 0){
           isiOS = true;
    }
    $.fn.doubletap = function(onDoubleTapCallback, onTapCallback, delay){
        var eventName, action, evHolder;
        delay = delay == null? 300 : delay;
        eventName = isiOS == true? 'touchend' : 'click';
        $(this).bind(eventName, function(event){
            var now = new Date().getTime();
            var lastTouch = $(this).data('lastTouch') || now + 1 /** the first time this will make delta a negative number */;
            var delta = now - lastTouch;
            clearTimeout(action);
            if(delta<300 && delta>0){
//				$("#UsersName").html('double tap');
//                   alert('double tap');
                if(onDoubleTapCallback != null && typeof onDoubleTapCallback == 'function'){
					if (Modernizr.touch) {
						event.preventDefault();
						//if (delta > 100) {
							//alert(delta);
							onDoubleTapCallback($(this));
						//}
					}
					else {
						onDoubleTapCallback($(this));
					}
                }
            }else{
                $(this).data('lastTouch', now);
				evHolder = $(this);
                action = setTimeout(function(evt){
//				$("#UsersName").html('single tap');
                    //alert(IveScrolledCalendar);
                    if(IveSwipedApp == 0 && IvePinchedApp == 0 && IveScrolledApp == 0 && IveZoomedApp == 0 && onTapCallback != null && typeof onTapCallback == 'function'){
						onTapCallback(evHolder);
                    }
					else if (onTapCallback != null && typeof onTapCallback == 'function') {
						IveSwipedApp = 0;
						IvePinchedApp = 0;
						IveScrolledApp = 0;
						IveZoomedApp = 0;
					}
                    clearTimeout(action);   // clear the timeout
                }, delay, [event]);
            }
            $(this).data('lastTouch', now);
        });
    };
})(jQuery);
