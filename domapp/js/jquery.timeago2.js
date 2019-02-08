/**
 * Timeago is a jQuery plugin that makes it easy to support automatically
 * updating fuzzy timestamps (e.g. "4 minutes ago" or "about 1 day ago").
 *
 * @name timeago2
 * @version 1.4.3
 * @requires jQuery v1.2.3+
 * @author Ryan McGeary
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 * For usage and examples, visit:
 * http://timeago2.yarp.com/
 *
 * Copyright (c) 2008-2015, Ryan McGeary (ryan -[at]- mcgeary [*dot*] org)
 */

(function (factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else if (typeof module === 'object' && typeof module.exports === 'object') {
    factory(require('jquery'));
  } else {
    // Browser globals
    factory(jQuery);
  }
}(function ($) {
  $.timeago2 = function(timestamp) {
    if (timestamp instanceof Date) {
      return inWords(timestamp);
    } else if (typeof timestamp === "string") {
      return inWords($.timeago2.parse(timestamp));
    } else if (typeof timestamp === "number") {
      return inWords(new Date(timestamp));
    } else {
      return inWords($.timeago2.datetime(timestamp));
    }
  };
  var $t = $.timeago2;

  $.extend($.timeago2, {
    settings: {
      refreshMillis: 60000,
      allowPast: false,
      allowFuture: true,
      localeTitle: false,
      cutoff: 0,
      strings: {
        prefixAgo: null,
        prefixFromNow: "",
        suffixAgo: "",
        suffixFromNow: "",
        inPast: '',
        seconds: "<1m",
        minute: "1m",
        minutes: "%dm",
        hour: "1h",
        hours: "%dh",
        day: "1d",
        days: "%dd",
        month: "1mo",
        months: "%dmo",
        year: "1y",
        years: "%dy",
        wordSeparator: "",
        numbers: []
      }
    },

    inWords: function(distanceMillis) {
      if(!this.settings.allowPast && ! this.settings.allowFuture) {
          throw 'timeago2 allowPast and allowFuture settings can not both be set to false.';
      }

      var $l = this.settings.strings;
      var prefix = $l.prefixAgo;
      var suffix = $l.suffixAgo;
      if (this.settings.allowFuture) {
        if (distanceMillis < 0) {
          prefix = $l.prefixFromNow;
          suffix = $l.suffixFromNow;
        }
      }

      if(!this.settings.allowPast && distanceMillis >= 0) {
        return this.settings.strings.inPast;
      }

      var seconds = Math.abs(distanceMillis) / 1000;
      var minutes = seconds / 60;
      var hours = minutes / 60;
      var days = hours / 24;
      var years = days / 365;

      function substitute(stringOrFunction, number) {
        var string = $.isFunction(stringOrFunction) ? stringOrFunction(number, distanceMillis) : stringOrFunction;
        var value = ($l.numbers && $l.numbers[number]) || number;
        return string.replace(/%d/i, value);
      }

      var words = seconds < 45 && substitute($l.seconds, Math.round(seconds)) ||
        seconds < 90 && substitute($l.minute, 1) ||
        minutes < 45 && substitute($l.minutes, Math.round(minutes)) ||
        minutes < 90 && substitute($l.hour, 1) ||
        hours < 24 && substitute($l.hours, Math.round(hours)) ||
        hours < 42 && substitute($l.day, 1) ||
        days < 30 && substitute($l.days, Math.round(days)) ||
        days < 45 && substitute($l.month, 1) ||
        days < 365 && substitute($l.months, Math.round(days / 30)) ||
        years < 1.5 && substitute($l.year, 1) ||
        substitute($l.years, Math.round(years));

      var separator = $l.wordSeparator || "";
      if ($l.wordSeparator === undefined) { separator = " "; }
      return $.trim([prefix, words, suffix].join(separator));
    },

    parse: function(iso8601) {
      var s = $.trim(iso8601);
      s = s.replace(/\.\d+/,""); // remove milliseconds
      s = s.replace(/-/,"/").replace(/-/,"/");
      s = s.replace(/T/," ").replace(/Z/," UTC");
      s = s.replace(/([\+\-]\d\d)\:?(\d\d)/," $1$2"); // -04:00 -> -0400
      s = s.replace(/([\+\-]\d\d)$/," $100"); // +09 -> +0900
      return new Date(s);
    },
    datetime: function(elem) {
      var iso8601 = $t.isTime(elem) ? $(elem).attr("datetime") : $(elem).attr("title");
      return $t.parse(iso8601);
    },
    isTime: function(elem) {
      // jQuery's `is()` doesn't play well with HTML5 in IE
      return $(elem).get(0).tagName.toLowerCase() === "time"; // $(elem).is("time");
    }
  });

  // functions that can be called via $(el).timeago2('action')
  // init is default when no action is given
  // functions are called with context of a single element
  var functions = {
    init: function(){
      var refresh_el = $.proxy(refresh, this);
      refresh_el();
      var $s = $t.settings;
      if ($s.refreshMillis > 0) {
        this._timeago2Interval = setInterval(refresh_el, $s.refreshMillis);
      }
    },
    update: function(time){
      var parsedTime = $t.parse(time);
      $(this).data('timeago2', { datetime: parsedTime });
      if($t.settings.localeTitle) $(this).attr("title", parsedTime.toLocaleString());
      refresh.apply(this);
    },
    updateFromDOM: function(){
      $(this).data('timeago2', { datetime: $t.parse( $t.isTime(this) ? $(this).attr("datetime") : $(this).attr("title") ) });
      refresh.apply(this);
    },
    dispose: function () {
      if (this._timeago2Interval) {
        window.clearInterval(this._timeago2Interval);
        this._timeago2Interval = null;
      }
    }
  };

  $.fn.timeago2 = function(action, options) {
    var fn = action ? functions[action] : functions.init;
    if(!fn){
      throw new Error("Unknown function name '"+ action +"' for timeago2");
    }
    // each over objects here and call the requested function
    this.each(function(){
      fn.call(this, options);
    });
    return this;
  };

  function refresh() {
    //check if it's still visible
    if(!$.contains(document.documentElement,this)){
      //stop if it has been removed
      $(this).timeago2("dispose");
      return this;
    }

    var data = prepareData(this);
    var $s = $t.settings;

    if (!isNaN(data.datetime)) {
      if ( $s.cutoff == 0 || Math.abs(distance(data.datetime)) < $s.cutoff) {
        $(this).text(inWords(data.datetime));
      }
    }
    return this;
  }

  function prepareData(element) {
    element = $(element);
    if (!element.data("timeago2")) {
      element.data("timeago2", { datetime: $t.datetime(element) });
      var text = $.trim(element.text());
      if ($t.settings.localeTitle) {
        element.attr("title", element.data('timeago2').datetime.toLocaleString());
      } else if (text.length > 0 && !($t.isTime(element) && element.attr("title"))) {
        element.attr("title", text);
      }
    }
    return element.data("timeago2");
  }

  function inWords(date) {
    return $t.inWords(distance(date));
  }

  function distance(date) {
    return (new Date().getTime() - date.getTime());
  }

  // fix for IE6 suckage
  document.createElement("abbr");
  document.createElement("time");
}));







/* TIMEAGO HELPER.JS */
var zeropad = function (num) {
  return ((num < 10) ? '0' : '') + num;
};
var iso8601 = function (date) {
  return date.getUTCFullYear()
    + "-" + zeropad(date.getUTCMonth()+1)
    + "-" + zeropad(date.getUTCDate())
    + "T" + zeropad(date.getUTCHours())
    + ":" + zeropad(date.getUTCMinutes())
    + ":" + zeropad(date.getUTCSeconds()) + "Z";
};

function prepareDynamicDates() {
  $('abbr.loaded').attr("title", iso8601(new Date()));
  $('abbr.modified').attr("title", iso8601(new Date(document.lastModified)));
}

function loadNumbers() {
  jQuery.timeago2.settings.strings.numbers = ["zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine"];
}
function unloadNumbers() {
  jQuery.timeago2.settings.strings.numbers = [];
}

function loadCutoffSetting() {
	jQuery.timeago2.settings.cutoff = 7*24*60*60*1000;
}

function unloadCutoffSetting() {
	jQuery.timeago2.settings.cutoff = 0;
}

function setupDisposal() {
  jQuery.timeago2.settings.refreshMillis = 50;
  $('abbr.disposal').attr("title", iso8601(new Date())).timeago2();
}

function loadPigLatin() {
  jQuery.timeago2.settings.strings = {
    suffixAgo: "ago-hay",
    suffixFromNow: "omNow-fray",
    seconds: "ess-lay an-thay a-hay inute-may",
    minute: "about-hay a-hay inute-may",
    minutes: "%d inutes-may",
    hour: "about-hay an-hay hour-hay",
    hours: "about-hay %d hours-hay",
    day: "a-hay ay-day",
    days: "%d ays-day",
    month: "about-hay a-hay onth-may",
    months: "%d onths-may",
    year: "about-hay a-hay ear-yay",
    years: "%d years-yay"
  };
}

function loadRussian() {
  (function() {
    function numpf(n, f, s, t) {
      // f - 1, 21, 31, ...
      // s - 2-4, 22-24, 32-34 ...
      // t - 5-20, 25-30, ...
      var n10 = n % 10;
      if ( (n10 == 1) && ( (n == 1) || (n > 20) ) ) {
        return f;
      } else if ( (n10 > 1) && (n10 < 5) && ( (n > 20) || (n < 10) ) ) {
        return s;
      } else {
        return t;
      }
    }

    jQuery.timeago2.settings.strings = {
      prefixAgo: null,
      prefixFromNow: "через",
      suffixAgo: "назад",
      suffixFromNow: null,
      seconds: "меньше минуты",
      minute: "минуту",
      minutes: function(value) { return numpf(value, "%d минута", "%d минуты", "%d минут"); },
      hour: "час",
      hours: function(value) { return numpf(value, "%d час", "%d часа", "%d часов"); },
      day: "день",
      days: function(value) { return numpf(value, "%d день", "%d дня", "%d дней"); },
      month: "месяц",
      months: function(value) { return numpf(value, "%d месяц", "%d месяца", "%d месяцев"); },
      year: "год",
      years: function(value) { return numpf(value, "%d год", "%d года", "%d лет"); }
    };
  })();
}

function resetRefreshMillis() {
  jQuery.timeago2.settings.refreshMillis = 60000;
}

function loadMillis() {
  var millisSubstitution = function(number, millis) { return millis + " milliseconds"; };
  jQuery.timeago2.settings.strings = {
    suffixAgo: "ago",
    suffixFromNow: "from now",
    seconds: millisSubstitution,
    minute: millisSubstitution,
    minutes: millisSubstitution,
    hour: millisSubstitution,
    hours: millisSubstitution,
    day: millisSubstitution,
    days: millisSubstitution,
    month: millisSubstitution,
    months: millisSubstitution,
    year: millisSubstitution,
    years: millisSubstitution
  };
}

function loadNoSpaces() {
  jQuery.extend(jQuery.timeago2.settings.strings, {
    minutes: "%dminutes",
    wordSeparator: ""
  });
}

function loadNullSpaces() {
  jQuery.extend(jQuery.timeago2.settings.strings, {
    minutes: "%dminutes",
    wordSeparator: null
  });
}

function loadYoungOldYears() {
  jQuery.extend(jQuery.timeago2.settings.strings, {
    years: function(value) { return (value < 21) ? "%d young years" : "%d old years"; }
  });
}

function loadDoNotAllowFuture() {
  var mockDateToUse = "2010-01-01";
  $.timeago2.settings.allowFuture = false;
  enableMockedDate(mockDateToUse);
}

function unloadDoNotAllowFuture() {
  $.timeago2.settings.allowFuture = true;
  disableMockedDate();
}

function loadDoNotAllowPast() {
  var mockDateToUse = "2010-01-01";
  $.timeago2.settings.allowFuture = true;
  $.timeago2.settings.allowPast = false;
  $.timeago2.settings.strings.inPast = "in the past";
  enableMockedDate(mockDateToUse);
}

function unloadDoNotAllowPast() {
  $.timeago2.settings.allowFuture = true;
  $.timeago2.settings.allowPast = true;
  disableMockedDate();
}

function enableMockedDate(dateToReturn) {
  var mockDate = dateToReturn;
  window.NativeDate = Date;
  window.Date = function () {
    if(arguments.length === 0) {
      return new window.NativeDate(mockDate);
    } else if(arguments.length === 1) {
      return new window.NativeDate(arguments[0]);
    } else  if(arguments.length === 7) {
      return new window.NativeDate(arguments[0], arguments[1], arguments[2], arguments[3], arguments[4], arguments[5], arguments[6]);
    } else {
      throw "Mocking Date with this number of parameters is not implemented.";
    }
  }
}

function disableMockedDate() {
  window.Date = window.NativeDate;
  delete window.NativeDate;
}
