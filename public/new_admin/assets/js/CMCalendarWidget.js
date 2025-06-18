var scriptName = "embed.js"; //name of this script, used to get reference to own tag
var Objparam;
var timeoutfunction = null;
var ZionPath = "https://app.channelmanager.com.au/";
var jqueryPath = "/website-pmb-new/assets/vendor/jquery/jquery.min.js";
var jqueryVersion = "1.8.3";
var Datepickerjs = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js";
var bootStrapCssPath = "/website-pmb-new/assets/css/lib/bootstrap.min.css";
var Datepickercss = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css";
var Bootstrapjs = "/website-pmb-new/assets/lib/js/bootstrap.min.js";
var momentjs = "/website-pmb-new/assets/vendor/jquery/moment.min.js";
var jQueryScriptOutputted = false;
var styleEl = document.createElement('style');
var html4 = "<div class='zioncalendar'></div><div class='zioncalendar'></div><div class='zioncalendar'></div><div class='zioncalendar'></div>";
var html3 = "<div class='zioncalendar'></div><div class='zioncalendar'></div><div class='zioncalendar'>";
var html2 = "<div class='zioncalendar'></div><div class='zioncalendar'>";
styleEl.innerHTML = '.zioncalendar,.datepicker {display: inline-block;} #ZionCalendarWidget .zioncalendar:not(:first-child) th.prev {visibility: hidden;} #ZionCalendarWidget .zioncalendar:not(:last-child) th.next {visibility: hidden;} #ZionCalendarWidget .zioncalendar:first-child th.prev{cursor: pointer;} #ZionCalendarWidget .zioncalendar:last-child th.next {cursor: pointer;} #ZionCalendarWidget .zioncalendar:first-child table tr td.old,#ZionCalendarWidget .zioncalendar:last-child table tr td.new{visibility: hidden;} .zioncalendar table, td, tr {border: 0px;}';
document.head.appendChild(styleEl);
var active_dates = [];
var inactive_dates = [];
var halfactive_dates = [];
var IsVisibilityCheck = true;
function initJQuery() {
    if (typeof (jQuery) == 'undefined') {
        if (!jQueryScriptOutputted) {
            jQueryScriptOutputted = true;
            // loadScript(jqueryPath);
            document.write('<script type="text/javascript" src= "' + jqueryPath  +'"></script>');
        }
        timeoutfunction = setTimeout(initJQuery, 500);
    }
    else if(typeof (moment) == "undefined" || moment.version == undefined) {
        loadScript(momentjs);
        timeoutfunction = setTimeout(initJQuery, 500);
    }
    else {
        if (typeof ($) == 'undefined') {
            $ = window.jQuery;
        }

        var loadBootstrapJs = true;
        try {
            var vernums = $.fn.tooltip.Constructor.VERSION.split('.');
            if (parseInt(vernums[0]) >= 3 && parseInt(vernums[1]) >= 3 && parseInt(vernums[2]) >= 6) {
                loadBootstrapJs = false;
            }
        } catch (e) {

        }
        if (loadBootstrapJs) {
            loadScript(Bootstrapjs);
        }

        if (typeof ($.fn.datepicker) == 'undefined') {
            //loadScript(Bootstrapjs);
            loadScript(Datepickerjs); 
        }
        clearTimeout(timeoutfunction);
        $(function () {
            var getparam = $('#ZionCalendarWidgetId');
            var paramdetail = getparam[0].innerHTML;
            Objparam = JSON.parse(paramdetail);
            var CD = parseInt(Objparam.CD);
            if (CD <= 2 || !CD || CD == NaN) {
                Objparam.CD = 2;
                $('#ZionCalendarWidget').html(html2);
            }
            else if (CD == 3) {
                $('#ZionCalendarWidget').html(html3);
            }
            else if (CD >= 4) {
                Objparam.CD = 4;
                $('#ZionCalendarWidget').html(html4);
            }

            var CurrentDate = new Date();
            var Fromdate = moment(CurrentDate).startOf('month').format("YYYY-MM-DD");
            var ToDate = moment(CurrentDate).add(parseInt(Objparam.CD - 1),'months').endOf('month').format("YYYY-MM-DD");

            if (Objparam.SId == Objparam.RId) {
                $.getJSON(ZionPath + 'Supplier/Widget/CheckAvailabilityForcalendarWidget?jsoncallback=?', { SupplierId: Objparam.SId, Fromdate: Fromdate, ToDate: ToDate, RoomId: '0' }, function (data) {
                    var object = JSON.parse(data);
                    LoadCalendarData(object);
                });
            } else {
                $.getJSON(ZionPath + 'Supplier/Widget/CheckAvailabilityForcalendarWidget?jsoncallback=?', { SupplierId: Objparam.SId, Fromdate: Fromdate, ToDate: ToDate, RoomId: Objparam.RId }, function (data) {
                    var object = JSON.parse(data);
                    LoadCalendarData(object);
                })
            }
            loadcalendarcss();
            // keep month in sync
            $('.zioncalendar').on('changeMonth', function (e) {
                IsVisibilityCheck = false;
                var SetSelectDate = moment(e.date).startOf('month');
                var Todaydate = moment().startOf('month');
                if (SetSelectDate.isAfter(Todaydate) && !(Todaydate.isSame(SetSelectDate))) {
                    $(".zioncalendar:first-child th.prev").css('visibility', 'visible');
                }
                else
                {
                    $(".zioncalendar:first-child th.prev").css('visibility', 'hidden');
                }
                    var setprenext = $('.zioncalendar');
                    var positionOfTarget = setprenext.index(e.target);
                    if (positionOfTarget == 0) {
                        var Fromdate = moment(e.date).startOf('month').format("YYYY-MM-DD");
                        var ToDate = moment(e.date).add(parseInt(Objparam.CD - 1), 'months').endOf('month').format("YYYY-MM-DD");
                    }
                    else {
                        var ToDate = moment(e.date).endOf('month').format("YYYY-MM-DD");
                        var Fromdate = moment(e.date).add(-parseInt(Objparam.CD - 1), 'months').startOf('month').format("YYYY-MM-DD");
                    }

                    if (Objparam.SId == Objparam.RId) {
                        $.getJSON(ZionPath + 'Supplier/Widget/CheckAvailabilityForcalendarWidget?jsoncallback=?', { SupplierId: Objparam.SId, Fromdate: Fromdate, ToDate: ToDate, RoomId: '0' }, function (data) {
                            var object = JSON.parse(data);
                            LoadCalendarData(object,e);
                        });
                    } else {

                        $.getJSON(ZionPath + 'Supplier/Widget/CheckAvailabilityForcalendarWidget?jsoncallback=?', { SupplierId: Objparam.SId, Fromdate: Fromdate, ToDate: ToDate, RoomId: Objparam.RId }, function (data) {
                            var object = JSON.parse(data);
                            LoadCalendarData(object, e);
                        })
                    }
                    loadcalendarcss();
            });

            // keep dates in sync
            $('.zioncalendar').on('changeDate', function (e) {
                var AD = moment(e.date).format("YYYY-MM-DD");
                var Todaydate = moment().format("YYYY-MM-DD");
                var SetAD = moment(AD, "YYYY-MM-DD");
                var SetTodaydate = moment(Todaydate, "YYYY-MM-DD");
                if (SetTodaydate.isSame(SetAD) || SetTodaydate.isBefore(SetAD)) {
                    var DD = moment(e.date).add(1, 'day').format("YYYY-MM-DD");
                    var url = ZionPath + 'BookNow/' + convertToSlug(Objparam.SNAME) + '-' + Objparam.SId + '?AD=' + AD + '&DD=' + DD + '&A=2&C=0';
                    if (Objparam.SId == Objparam.RId) {
                        //window.location = ZionPath + 'BookNow/' + convertToSlug(Objparam.SNAME) + '-' + Objparam.SId + '?AD=' + AD + '&DD=' + DD + '&A=2&C=0';
                    }
                    else {
                        url=url+'&RID=' + Objparam.RId + '';
                        //window.location = ZionPath + 'BookNow/' + convertToSlug(Objparam.SNAME) + '-' + Objparam.SId + '?AD=' + AD + '&DD=' + DD + '&A=2&C=0&RID=' + Objparam.RId + '';
                    }
                    if (Objparam.S && Objparam.S!='') {
                        url = url + '&S=' + Objparam.S;
                    }
                    window.location = url;
                    var calendars = $('.zioncalendar');
                    var target = e.target;
                    var newDates = $(target).datepicker('getUTCDates');
                    calendars.each(function () {
                        if (this === e.target) {
                            return;
                        }
                        // setUTCDates triggers changeDate event
                        // could easily run into an infinite loop
                        // therefore we check if currentDates equal newDates
                        var currentDates = $(this).datepicker('getUTCDates');
                        if (
                          currentDates &&
                          currentDates.length === newDates.length &&
                          currentDates.every(function (currentDate) {
                                    return newDates.some(function (newDate) {
                              return currentDate.toISOString() === newDate.toISOString();
                        })
                        })
                        ) {
                            return;
                        }

                        $(this).datepicker('setUTCDates', newDates);
                    });
                    loadcalendarcss();
                }
                else
                {
                    loadcalendarcss();
                }
            });

        });
    }
}

//if (window.jQuery === undefined || window.jQuery.fn.jquery !== jqueryVersion) {

var isBootstrap = false;
var setTimeOut = false;
    for (var i = 0; i < document.styleSheets.length; i++) {
        if (document.styleSheets[i].href && (document.styleSheets[i].href.match("/bootstrap.min.css") || document.styleSheets[i].href.match("/bootstrap.css"))) {
            isBootstrap = true;
            break;
        }
    }
    if (isBootstrap != true) {
        loadCss(bootStrapCssPath);
    }           
    loadCss(Datepickercss);
    //loadScript(jqueryPath);
    //loadScript(momentjs);
    //loadScript(Datepickerjs);
    
//setTimeout(initJQuery, 1000);
    if (typeof (moment) == "undefined" || moment.version == undefined) {
        loadScript(momentjs);
        setTimeOut = true;
    }
    if (window.jQuery === undefined) {
        loadScript(jqueryPath);
        clearTimeout(timeoutfunction);
        timeoutfunction = setTimeout(initJQuery, 1000);
    }
    else {
        var vernums = window.jQuery.fn.jquery.split('.');
        //When jQuery version less than 1.8.3 then load our jquery other wise work with latest one.
        if (parseInt(vernums[0]) > 1 || (parseInt(vernums[0]) >= 1 && parseInt(vernums[1]) >= 8 && parseInt(vernums[2]) > 3)) {
            //initJQuery();
        }
        else {
            loadScript(jqueryPath);
            //setTimeout(initJQuery, 1000);
            setTimeOut = true;
        }
        if (setTimeOut == true) {
            clearTimeout(timeoutfunction);
            timeoutfunction= setTimeout(initJQuery, 1000);
        } else { initJQuery(); }
    }

//}
//else {
//    initJQuery();
//}

//http://lukencode.com/2013/01/24/jsonp-embeddable-widget-template/
function loadScript(src, onLoad) {
 //var sj = document.createElement('script');
 //       sj.type = 'text/javascript';
 //       sj.async = true;
 //       sj.src = src;
 //       sj.addEventListener ? sj.addEventListener('load', onLoad, false) : sj.attachEvent('onload', onLoad);
 //       var s = document.getElementsByTagName('script')[0];
 //       s.parentNode.insertBefore(sj, s);
    var script_tag = document.createElement('script');
    script_tag.setAttribute("type", "text/javascript");
    script_tag.setAttribute("src", src);
    script_tag.setAttribute('defer', '');
    if (script_tag.readyState) {
        script_tag.onreadystatechange = function () {
            if (this.readyState == 'complete' || this.readyState == 'loaded') {
                onLoad();
            }
        };
    } else {
        script_tag.onload = onLoad;
    }
    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
    //document.write('<script type="text/javascript" src="'+src+'"></script>');
}

/******** helper function to load external css  *********/
function loadCss(href) {
    var link_tag = document.createElement('link');
    link_tag.setAttribute("type", "text/css");
    link_tag.setAttribute("rel", "stylesheet");
    link_tag.setAttribute("href", href);
    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(link_tag);
}

function loadcalendarcss() {
    $(".datepicker td,.datepicker th").css("color", Objparam.FC);
    $(".zioncalendar").css("background-color", Objparam.BC);
    $(".zioninactiveclass").css("background", Objparam.FBC);
    $(".zionactiveclass").css("background", Objparam.AC);
    $(".zionhalfactiveclass").css("background", 'linear-gradient(135deg, ' + Objparam.AC + ',' + Objparam.AC + ' 49%, transparent 51%, transparent)');
   }

function LoadCalendarData(data, e) {
    active_dates = [];
    inactive_dates = [];
    halfactive_dates = [];
    data.forEach(function (detail, key) {
        detail.RoomDate = moment(detail.RoomDate,"DD-MM-YYYY").format("YYYY-MM-DD");
        if ((detail.TotalAllocation - detail.Booked) == 0 || detail.StopSell==true) {
            inactive_dates.push(detail.RoomDate);
        }
        else if ((detail.TotalAllocation - detail.Booked) == detail.TotalAllocation) {
            active_dates.push(detail.RoomDate);
        }
        else {
            halfactive_dates.push(detail.RoomDate);
        }
    })
    if (e) {
        var target = e.target;
        var date = e.date;
        var calendars = $('.zioncalendar');
        var positionOfTarget = calendars.index(target);
        var callength = calendars.length;
        calendars.each(function (index) {
            //if (this === target) {
            //    return;
            //}
            var newDate = new Date(date);
            var datedate = null;
            if (positionOfTarget == (callength-1))
            {
                datedate = moment(newDate).add(index - (callength - 1), 'M').format('YYYY-MM-DD');
            }
            else if (positionOfTarget == 0)
            {
                if (index == 0) {
                    datedate = moment(newDate).add(0 , 'M').format('YYYY-MM-DD');
                }
                else {
                    datedate = moment(newDate).add(index, 'M').format('YYYY-MM-DD');
                }
            }
            $(this).datepicker('_setDate', datedate, 'view');
        });
    }
   
    LoadDatePicker();
}

function LoadDatePicker(howManyTimeCalled)
{
    try {
        $('.zioncalendar').map(function (index) {
            $(this).datepicker({
                defaultViewDate: {
                    year: (new Date()).getFullYear(),
                    month: (new Date()).getMonth() + index,
                    date: 1
                },
                format: 'yyyy-mm-dd',
                multidate: false,
                updateViewDate: false,
                maxViewMode: 0,
                datesDisabled: inactive_dates,
                beforeShowDay: function (date) {
                    var Todaydate = moment();
                    Todaydate.set({ hour: 0, minute: 0, second: 0, millisecond: 0 });
                    var showdate = moment(date);
                    var d = date;
                    var curr_date = (d.getDate() < 10 ? '0' : '') + d.getDate();
                    var curr_month = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1); //Months are zero based
                    var curr_year = d.getFullYear();
                    var formattedDate = curr_year + "-" + curr_month + "-" + curr_date;
                    if (showdate.isBefore(Todaydate)) {
                        return {
                            classes: 'disabled disabled-date'
                        };
                    }
                    if ($.inArray(formattedDate, active_dates) != -1) {
                        return {
                            classes: 'zionactiveclass'
                        };
                    }
                    if ($.inArray(formattedDate, inactive_dates) != -1) {
                        return {
                            classes: 'disabled disabled-date zioninactiveclass'
                        };
                    }
                    if ($.inArray(formattedDate, halfactive_dates) != -1) {
                        return {
                            classes: 'zionhalfactiveclass'
                        };
                    }
                   
                },
            });

            loadcalendarcss();
        });
        if (IsVisibilityCheck == true) {
            $(".zioncalendar:first-child th.prev").css('visibility', 'hidden');
        }
    } catch (e) {
        if (howManyTimeCalled != undefined && howManyTimeCalled == 1) {
            $('#ZionCalendarWidget').html('<b>Sorry something wrong while display widget so please refresh page again.</b>');
        } else {
            loadScript(Datepickerjs);
            setTimeout(function () { LoadDatePicker(1) }, 500);
        }
    }
}
function convertToSlug(Text) {
    return Text
        .toLowerCase()
        .replace(/[^-\w? ]+/g, '')
        .replace(/ +/g, '-')
    ;
}