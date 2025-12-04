var today = new Date();
var mm = today.getMonth(); //January is 0!
var yyyy = today.getFullYear();
date.setDate(1);
date.setMonth(mm);
date.setYear(yyyy);

window.onload = function() {
};

document.onkeydown = function(evt) {
    evt = evt || window.event;
    switch (evt.keyCode) {
        case 37:
            previousMonth();
            break;
        case 39:
            nextMonth();
            break;
    }
};

// Converts day ids to the relevant string
function dayOfWeekAsString(dayIndex) {
        return ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"][dayIndex];
    }
    // Converts month ids to the relevant string
function monthsAsString(monthIndex) {
    return ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"][monthIndex];
}
    // Converts month ids to the relevant string
function monthsArabicAsString(monthIndex) {
    var ad = ["ديسمبر","نوفمبر","أكتوبر","سبتمبر","أغسطس","يوليو","يونيو","مايو","ابريل","مارس","فبراير","يناير"];
    ad = ad.reverse();
    return ad[monthIndex];
}

// Creates a day element
function createCalendarDay(num, day, mon, year) {
    var currentCalendar = document.getElementById("calendar");

    var newDay = document.createElement("div");
    var date = document.createElement("p");
    var dayElement = document.createElement("p");

    date.innerHTML = num;
    dayElement.innerHTML = day;

    newDay.className = "calendar-day ";

	cDate = num + "-" + mon + "-" +year;

	if(eventDates.includes(cDate))
		newDay.className = "calendar-day hasEvent";

    // Set ID of element as date formatted "8-January" etc
    newDay.id = num + "-" + mon + "-" +year;

    newDay.appendChild(date);
    // newDay.appendChild(dayElement);
    currentCalendar.appendChild(newDay);
}

// Clears all days from the calendar
function clearCalendar() {
    var currentCalendar = document.getElementById("calendar");

    currentCalendar.innerHTML = "";
}

// Go to year
function gotoYear(y) {
    clearCalendar();
    date.setYear(y);
    createMonth(date.getMonth(),y);
}

// Go to year
function gotoMonth(m) {
    clearCalendar();
    date.setMonth(m);
    createMonth(m,date.getYear());
}

// Clears the calendar and shows the next month
function nextMonth() {
    clearCalendar();

    date.setMonth(date.getMonth() + 1);

    createMonth();
}

// Clears the calendar and shows the previous month
function previousMonth() {
    clearCalendar();
    date.setMonth(date.getMonth() - 1);
    var val = date.getMonth();
    createMonth();
}

// Creates and populates all of the days to make up the month
function createMonth(m,y) {
    var currentCalendar = document.getElementById("calendar");

    var dateObject = new Date();
    dateObject.setDate(date.getDate());
    dateObject.setMonth(date.getMonth());
    dateObject.setYear(date.getFullYear());

	if(m)
		dateObject.setMonth(m);

	if(y)
		dateObject.setYear(y);


    createCalendarDay(dateObject.getDate(), dayOfWeekAsString(dateObject.getDay()), monthsAsString(dateObject.getMonth()), dateObject.getFullYear());

    dateObject.setDate(dateObject.getDate() + 1);

    while (dateObject.getDate() != 1) {
        createCalendarDay(dateObject.getDate(), dayOfWeekAsString(dateObject.getDay()), monthsAsString(dateObject.getMonth()), dateObject.getFullYear());
        dateObject.setDate(dateObject.getDate() + 1);
    }


    // Set the text to the correct month
    var currentMonthText = document.getElementById("current-month");
    currentMonthText.innerHTML = "<span class=en>"+monthsAsString(date.getMonth()) + "</span><span class='year'>" + date.getFullYear() + "</span><span class=ar>" + monthsArabicAsString(date.getMonth())+"</span>";

	days = $('.calendar-day').length;

	if(days<43){
		for(x=1;x<(43-days);x++){
			$('#calendar').append('<div class="calendar-day gray" id="'+x+'-'+monthsAsString(date.getMonth()+1)+'-'+date.getFullYear()+'"><p>'+x+'</p></div>');
		}
	}

	prevMonth = 1;
	nexMonth = 1;

	if( (date.getMonth()-1) < 0 )
		prevMonth = 11;
	else
		prevMonth = date.getMonth()-1;

	if ( date.getMonth() == 11 )
		nexMonth = 0;
	else
		nexMonth = date.getMonth()+1;

	$('.next.label').empty().append("<span><span class='ar'>"+monthsArabicAsString(nexMonth)+"</span><br>"+monthsAsString(nexMonth)+"</span>");
	$('.previous.label').empty().append("<span><span class='ar'>"+monthsArabicAsString(prevMonth)+"</span><br>"+monthsAsString(prevMonth)+"</span>");
    getCurrentDay();

	$('.hasEvent').each(function(){
		$(this).wrap( "<a href='"+eventDates[$(this).attr('id')]+"'></a>" );
	});
}


function getCurrentDay() {

    // Create a new date that will set as default time
    var todaysDate = new Date();
    var today = todaysDate.getDate();
    var currentMonth = todaysDate.getMonth();
    var currentYear = todaysDate.getFullYear();
    var thisMonth = monthsAsString(currentMonth);
    // Find element with the ID for today
    //currentDay = document.getElementById(today + "-" + thisMonth + "-" + currentYear);
    //currentDay.className = "calendar-day today";
}

$('#datepicker .year a').on('click',function(e){
	e.preventDefault();

	gotoYear($(this).attr('data-year'));
});

$('#datepicker .month a').on('click',function(e){
	e.preventDefault();

	gotoMonth($(this).attr('data-month'));
});

$('html').click(function(e) {
  //if clicked element is not your element and parents aren't your div
  if (e.target.id != '#datepicker' && e.target.id != '#current-month' && $(e.target).parents('#datepicker').length == 0 && $(e.target).parents('#current-month').length == 0) {
    $('#datepicker').hide();
  }
});

$('#current-month').click(function() {
	if($('#datepicker').hasClass('active')){
		$('#datepicker').removeClass('active').hide();
	}
	else {
		$('#datepicker').addClass('active').show();
	}

});
