(function ($) {
  "use strict";

  
  let html = document.documentElement;
  let geexTheme = localStorage.theme;
  let geexThemeLayout = localStorage.layout;
  let geexThemeNavbar = localStorage.navbar;

  let darkMode = geexTheme === "dark";
  let rtlLayout = geexThemeLayout === "rtl";
  let topMenu = geexThemeNavbar === "top";

  
  if (geexTheme) {
    html.setAttribute("data-theme", geexTheme);

    if (geexTheme === "dark") {
      localStorage.theme === "dark";
      $(".geex-customizer__btn--light").removeClass("active");
      $(".geex-customizer__btn--dark").addClass("active");
    } else {
      localStorage.theme === "light";
    }
  }

  
  if (geexThemeLayout) {
    html.setAttribute("dir", geexThemeLayout);

    if (geexThemeLayout === "rtl") {
      localStorage.themeLayout === "rtl";
      $(".geex-customizer__btn--ltr").removeClass("active");
      $(".geex-customizer__btn--rtl").addClass("active");
    } else {
      localStorage.themeLayout === "ltr";
    }
  }

  
  if (geexThemeNavbar) {
    html.setAttribute("data-nav", geexThemeNavbar);

    if (geexThemeNavbar === "top") {
      localStorage.themeNavbar === "top";
      $(".geex-customizer__btn--side").removeClass("active");
      $(".geex-customizer__btn--top").addClass("active");
    } else {
      localStorage.themeNavbar === "side";
    }
  }

  
  function darkTheme(e) {
    let geexTheme = "dark";
    localStorage.theme = geexTheme;
    document.documentElement.setAttribute("data-theme", geexTheme);

    darkMode = true;
  }

  
  function lightTheme(e) {
    let geexTheme = "light";
    localStorage.theme = geexTheme;
    document.documentElement.setAttribute("data-theme", geexTheme);

    darkMode = false;
  }

  
  function rtlTheme(e) {
    let geexThemeLayout = "rtl";
    localStorage.layout = geexThemeLayout;
    document.documentElement.setAttribute("dir", geexThemeLayout);

    rtlLayout = true;
  }

  
  function ltrTheme(e) {
    let geexThemeLayout = "ltr";
    localStorage.layout = geexThemeLayout;
    document.documentElement.setAttribute("dir", geexThemeLayout);

    rtlLayout = false;
  }

  
  function topTheme(e) {
    let geexThemeNavbar = "top";
    localStorage.navbar = geexThemeNavbar;
    document.documentElement.setAttribute("data-nav", geexThemeNavbar);

    topMenu = true;
  }

  
  function sideTheme(e) {
    let geexThemeNavbar = "side";
    localStorage.navbar = geexThemeNavbar;
    document.documentElement.setAttribute("data-nav", geexThemeNavbar);

    topMenu = false;
  }

  
  $(".geex-customizer__btn--light").click(function () {
    $(".geex-customizer__btn--dark").removeClass("active");
    $(".geex-customizer__btn--light").addClass("active");

    lightTheme();
  });

  
  $(".geex-customizer__btn--dark").click(function () {
    $(".geex-customizer__btn--light").removeClass("active");
    $(".geex-customizer__btn--dark").addClass("active");

    darkTheme();
  });

  
  $(".geex-customizer__btn--ltr").click(function () {
    $(".geex-customizer__btn--rtl").removeClass("active");
    $(".geex-customizer__btn--ltr").addClass("active");

    ltrTheme();

    
    
    
    
    
  });

  
  $(".geex-customizer__btn--rtl").click(function () {
    $(".geex-customizer__btn--ltr").removeClass("active");
    $(".geex-customizer__btn--rtl").addClass("active");

    rtlTheme();
  });

  
  $(".geex-customizer__btn--side").click(function () {
    $(".geex-customizer__btn--top").removeClass("active");
    $(".geex-customizer__btn--side").addClass("active");

    sideTheme();
  });

  
  $(".geex-customizer__btn--top").click(function () {
    $(".geex-customizer__btn--side").removeClass("active");
    $(".geex-customizer__btn--top").addClass("active");

    topTheme();
  });

  
  function addActiveClass(pageSlug) {
    let menuLinks = $(".geex-header__menu__link, .geex-sidebar__menu__link");
    menuLinks.removeClass("active");

    
    menuLinks.each(function () {
      let menuItemPath = $(this).attr("href");
      let menuItemName = menuItemPath.split("/").pop().split(".")[0];
      if (menuItemName === pageSlug || menuItemName + "#" === pageSlug) {
        let menuParent = $(this)
          .closest(".has-children")
          .find("ul")
          .siblings("a");
        $(this).addClass("active");
        menuParent.addClass("active");
        menuParent.siblings(".geex-sidebar__submenu").slideDown();
      } else if (pageSlug === "" || pageSlug === "#") {
        $(".geex-header__menu__link").first().addClass("active");
        $(".geex-sidebar__menu__link").first().addClass("active");

        $(".geex-header__menu__link")
          .first()
          .siblings(".geex-header__submenu")
          .find(".geex-header__menu__link")
          .first()
          .addClass("active");
        $(".geex-header__menu__link")
          .first()
          .siblings(".geex-header__submenu")
          .slideDown();

        $(".geex-sidebar__menu__link")
          .first()
          .siblings(".geex-sidebar__submenu")
          .find(".geex-sidebar__menu__link")
          .first()
          .addClass("active");
        $(".geex-sidebar__menu__link")
          .first()
          .siblings(".geex-sidebar__submenu")
          .slideDown();
      }
    });
  }

  
  let path = window.location.pathname;
  let pathSegments = path.split("/");
  let pageSlug = pathSegments[pathSegments.length - 1].split(".")[0];

  addActiveClass(pageSlug);

  $(".geex-sidebar__menu__link").click(function () {
    let $clickedItem = $(this);

    
    $clickedItem.toggleClass("active");
    $clickedItem.siblings(".geex-sidebar__submenu").slideToggle();

    
    $(".geex-sidebar__menu__link").not($clickedItem).removeClass("active");
    $(".geex-sidebar__menu__link")
      .not($clickedItem)
      .siblings(".geex-sidebar__submenu")
      .slideUp();
  });

  
  $(".geex-btn__customizer").click(function () {
    $(".geex-customizer").toggleClass("active");
    $("body").addClass("overlay_active");
  });

  
  $(".geex-customizer-overlay, .geex-btn__customizer-close").click(function () {
    $(".geex-customizer").removeClass("active");
    $("body").removeClass("overlay_active");
  });

  
  $(".geex-btn__toggle-sidebar").click(function (e) {
    e.preventDefault();
    $(".geex-sidebar").toggleClass("active");
    $(".geex-sidebar").animate({
      width: "toggle",
    });
    $("body").addClass("overlay_active");
  });

  
  $(".geex-sidebar__close").click(function (e) {
    e.preventDefault();
    $(".geex-sidebar").removeClass("active");
    $(".geex-sidebar").animate({
      width: "toggle",
    });
    $("body").removeClass("overlay_active");
  });

  $(document).ready(function () {
    function toJalali(gy, gm, gd) {
      var g_d_m = [
        0,
        31,
        (gy % 4 == 0 && gy % 100 != 0) || gy % 400 == 0 ? 29 : 28,
        31,
        30,
        31,
        30,
        31,
        31,
        30,
        31,
        30,
        31,
      ];
      var jy = gy <= 1600 ? 0 : 979;
      gy -= gy <= 1600 ? 621 : 1600;
      var gy2 = gm > 2 ? gy + 1 : gy;
      var days =
        365 * gy +
        Math.floor((gy2 + 3) / 4) -
        Math.floor((gy2 + 99) / 100) +
        Math.floor((gy2 + 399) / 400) -
        80 +
        gd;
      for (var i = 0; i < gm; i++) days += g_d_m[i];
      jy += 33 * Math.floor(days / 12053);
      days %= 12053;
      jy += 4 * Math.floor(days / 1461);
      days %= 1461;
      if (days > 365) {
        jy += Math.floor((days - 1) / 365);
        days = (days - 1) % 365;
      }
      var jm, jd;
      if (days < 186) {
        jm = 1 + Math.floor(days / 31);
        jd = 1 + (days % 31);
      } else {
        jm = 7 + Math.floor((days - 186) / 30);
        jd = 1 + ((days - 186) % 30);
      }
      return [jy, jm, jd];
    }

    function fromJalali(jy, jm, jd) {
      var gy = jy <= 979 ? 621 : 1600;
      jy -= jy <= 979 ? 0 : 979;
      var days =
        365 * jy +
        Math.floor(jy / 33) * 8 +
        Math.floor(((jy % 33) + 3) / 4) +
        78 +
        jd;
      if (jm < 7) days += (jm - 1) * 31;
      else days += (jm - 7) * 30 + 186;
      gy += 400 * Math.floor(days / 146097);
      days %= 146097;
      if (days > 36524) {
        gy += 100 * Math.floor(--days / 36524);
        days %= 36524;
        if (days >= 365) days++;
      }
      gy += 4 * Math.floor(days / 1461);
      days %= 1461;
      if (days > 365) {
        gy += Math.floor((days - 1) / 365);
        days = (days - 1) % 365;
      }
      var gd, gm;
      var sal_a = [
        0,
        31,
        (gy % 4 == 0 && gy % 100 != 0) || gy % 400 == 0 ? 29 : 28,
        31,
        30,
        31,
        30,
        31,
        31,
        30,
        31,
        30,
        31,
      ];
      for (gm = 0; gm < 13 && days >= sal_a[gm]; gm++) days -= sal_a[gm];
      gd = days + 1;
      return [gy, gm, gd];
    }

    $("input[type='date']").on("focus", function () {
      var $input = $(this);
      var today = new Date();
      var jDate = toJalali(
        today.getFullYear(),
        today.getMonth() + 1,
        today.getDate()
      );

      var $calendar = $("<div class='calendar-container'></div>");
      for (var d = 1; d <= 31; d++) {
        $calendar.append(
          "<div data-day='" +
            d +
            "'>" +
            d +
            "/" +
            jDate[1] +
            "/" +
            jDate[0] +
            "</div>"
        );
      }

      $("body").append($calendar);
      $calendar
        .css({
          top: $input.offset().top + $input.outerHeight(),
          left: $input.offset().left,
        })
        .fadeIn();

      $calendar.find("div").on("click", function () {
        var selectedDay = $(this).data("day");
        var selectedDate = [jDate[0], jDate[1], selectedDay];
        var gDate = fromJalali(
          selectedDate[0],
          selectedDate[1],
          selectedDate[2]
        );
        $input.val(selectedDate.join("/"));
        $calendar.remove();
      });

      $(document).on("click", function (e) {
        if (
          !$(e.target).closest(".calendar-container, .jalali-datepicker").length
        ) {
          $calendar.remove();
        }
      });
    });
  });

  
  $("#geex-content__filter__label").click(function () {
    
  });
  
  

  
  $(".geex-content__toggle__btn").click(function (e) {
    e.preventDefault();
    $(this).toggleClass("active");
    $(this).siblings(".geex-content__toggle__content").slideToggle();
  });

  
  $(".geex-btn__toggle-task").click(function (e) {
    e.preventDefault();
    $(this).toggleClass("active");
    $(".geex-content__todo__sidebar").slideToggle();
  });

  
  $(".geex-content__calendar__toggle").click(function (e) {
    e.preventDefault();
    $(this).toggleClass("active");
    $(".geex-content__calendar__sidebar").slideToggle();
  });

  
  $(".geex-content__chat__toggle").click(function (e) {
    e.preventDefault();
    $(this).toggleClass("active");
    $(".geex-content__chat__sidebar").slideToggle();
  });

  
  $(".geex-content__chat__action__toggle__btn").click(function (e) {
    e.preventDefault();
    $(this).toggleClass("active");
    $(this)
      .siblings(".geex-content__chat__action__toggle__content")
      .slideToggle();
  });

  
  $(".geex-content__header__quickaction__link").click(function (e) {
    e.preventDefault();
    var $popup = $(this).siblings(".geex-content__header__popup");

    $popup.slideToggle();
    $(".geex-content__header__popup").not($popup).slideUp(0);
  });

  
  $(".geex-btn__add-modal").click(function () {
    $(".geex-content__modal__form").addClass("active");
    $("body").addClass("overlay_active");
  });

  
  $(".geex-content__modal__form__close").click(function () {
    $(".geex-content__modal__form").removeClass("active");
    $("body").removeClass("overlay_active");
  });

  
  $(".geex-content__chat__header__filter__mute-btn").click(function (e) {
    e.preventDefault();
    $(this).toggleClass("active");
  });

  
  $(".geex-content__chat__header__filter__btn").click(function (e) {
    e.preventDefault();

    var $clickedItem = $(this);

    
    $clickedItem.toggleClass("active");

    
    $clickedItem
      .siblings(".geex-content__chat__header__filter__content")
      .slideToggle();

    
    $(".geex-content__chat__header__filter__btn")
      .not($clickedItem)
      .removeClass("active");
    $(".geex-content__chat__header__filter__btn")
      .not($clickedItem)
      .siblings(".geex-content__chat__header__filter__content")
      .slideUp();
  });

  
  $(".toggle-password-type").click(function (e) {
    e.preventDefault();
    const input = $(this).siblings("input");

    if (input.attr("type") === "password") {
      $(this).removeClass("uil-eye");
      $(this).addClass("uil-eye-slash");
      input.attr("type", "text");
    } else {
      $(this).addClass("uil-eye");
      $(this).removeClass("uil-eye-slash");
      input.attr("type", "password");
    }
  });

  
  $(".geex-content__invoice__chat__toggler").click(function (e) {
    e.preventDefault();
    var $invoiceChatContent = $(this).siblings(
      ".geex-content__invoice__chat__wrapper"
    );

    $invoiceChatContent.stop().animate(
      {
        width: "toggle", 
        opacity: "toggle", 
      },
      300
    ); 
  });

  
  let day = document.querySelector(".geex-countdown__days");
  let hour = document.querySelector(".geex-countdown__hours");
  let minute = document.querySelector(".geex-countdown__minutes");
  let second = document.querySelector(".geex-countdown__seconds");

  function setCountdown() {
    
    let countdownDate = new Date("Jan 01, 2026 16:40:25").getTime();

    
    let updateCount = setInterval(function () {
      
      let todayDate = new Date().getTime();

      
      let distance = countdownDate - todayDate;

      let days = Math.floor(distance / (1000 * 60 * 60 * 24));

      let hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );

      let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

      let seconds = Math.floor((distance % (1000 * 60)) / 1000);

      
      if (day) {
        day.textContent = days;
      }
      if (hour) {
        hour.textContent = hours;
      }
      if (minute) {
        minute.textContent = minutes;
      }
      if (second) {
        second.textContent = seconds;
      }

      
      if (distance < 0) {
        clearInterval(updateCount);
        document.getElementById("geex-countdown").innerHTML =
          "<h1>EXPIRED</h1>";
      }
    }, 300);
  }

  setCountdown();

  
  let swiperContainer = document.querySelector(".swiper-container");
  let swiper =
    swiperContainer &&
    new Swiper(swiperContainer, {
      loop: true, 
      freeMode: true,
      reverseDirection: true,
      slidesPerView: 3,
      spaceBetween: 0,
      rtl: true,
      navigation: {
        nextEl: ".swiper-btn-next",
        prevEl: ".swiper-btn-prev",
      },
      breakpoints: {
        
        0: {
          slidesPerView: 1,
        },
        
        992: {
          slidesPerView: 2,
        },
        
        1600: {
          slidesPerView: 3,
        },
      },
    });

  let testiContainer = document.querySelector(".testi-container");
  let testi =
    testiContainer &&
    new Swiper(testiContainer, {
      loop: true, 
      freeMode: true,
      reverseDirection: true,
      slidesPerView: 1,
      spaceBetween: 0,
      navigation: {
        nextEl: ".swiper-btn-next",
        prevEl: ".swiper-btn-prev",
      },
    });

  
  if ($(".geex-content__chat__editor").length) {
    tinymce.init({
      selector: ".geex-content__chat__editor", 
    });
  }

  
  if ($("#geex-calendar").length) {
    $("#geex-calendar").fullCalendar({
      themeSystem: "jquery-ui",
      navLinks: true,
      height: 650,
      header: {
        left: "title, prev, next",
        right: "month,agendaWeek,agendaDay",
      },
      eventLimit: true,
      direction: 'rtl',
      locale: 'fa',
      firstDay: 6,
      buttonText: {
        today: 'امروز',
        month: 'ماه',
        week: 'هفته',
        day: 'روز',
        list: 'برنامه',
        more: 'بیشتر',
        close: 'بستن',
        noEvents: 'هیچ رویدادی برای نمایش وجود ندارد'
      },
      allDayText: 'تمام روز',
      moreLinkText: function(n) {
        return '+بیشتر ' + n;
      },
      noEventsMessage: 'هیچ رویدادی برای نمایش وجود ندارد',
      monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
      monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
      dayNames: ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
      dayNamesShort: ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
      dayNamesMin: ['ی', 'د', 'س', 'چ', 'پ', 'ج', 'ش'],
      weekHeader: 'هفته',
      weekNumberTitle: 'ه',
      weekNumberCalculation: 'ISO',
      eventRender: function (event, element, view) {
        var theDate = event.start;
        var endDate = event.dowend;
        var startDate = event.dowstart;

        if (theDate >= endDate) {
          return false;
        }

        if (theDate <= startDate) {
          return false;
        }
      },
      events: [
        {
          title: "رویداد تمام روز",
          start: "2025-03-01"
        },
        {
          title: "رویداد طولانی",
          start: "2025-03-07",
          end: "2025-03-10"
        },
        {
          groupId: "999",
          title: "رویداد تکرار شونده",
          start: "2025-03-09T16:00:00+00:00"
        },
        {
          groupId: "999",
          title: "رویداد تکرار شونده",
          start: "2025-03-16T16:00:00+00:00"
        },
        {
          title: "کنفرانس",
          start: "2025-03-20",
          end: "2025-03-22"
        },
        {
          title: "جلسه",
          start: "2025-03-21T10:30:00+00:00",
          end: "2025-03-21T12:30:00+00:00"
        },
        {
          title: "ناهار",
          start: "2025-03-21T12:00:00+00:00"
        },
        {
          title: "جشن تولد",
          start: "2025-03-22T07:00:00+00:00"
        },
        {
          url: "http://google.com/",
          title: "کلیک برای گوگل",
          start: "2025-03-28"
        }
      ],
      businessHours: [
        {
          dow: [1, 2, 3, 4, 5],
          start: "08:00",
          end: "16:30",
        },
      ],
      minTime: "06:00",
      maxTime: "21:00",
    });
  }

  
  let lineOptions = {
    series: [
      {
        name: "محصول 1",
        data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30, 45],
      },

      {
        name: "محصول 2",
        data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39, 51],
      },
    ],

    chart: {
      fontFamily: "Jost, sans-serif",
      height: 335,
      type: "area",
      background: "transparent",
      toolbar: {
        show: false,
      },
    },

    xaxis: {
      type: "category",
      categories: [
        "14:00",
        "14:10",
        "14:20",
        "14:30",
        "14:40",
        "14:50",
        "14:60",
        "15:00",
        "15:10",
        "15:20",
        "15:30",
      ],
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      crosshairs: {
        show: false,
      },
    },
    yaxis: {
      labels: {
        offsetX: -10,
      },
      title: {
        style: {
          fontSize: "0px",
        },
      },
      min: 0,
      max: 75,
      tickAmount: 3,
    },
    colors: ["#FFBB54", "#00A389"],
    fill: {
      colors: ["transparent", "transparent"],
      type: ["solid", "solid"],
    },

    legend: {
      show: true,
      position: "top",
      horizontalAlign: "right",
    },
    stroke: {
      width: [5, 5],
      curve: "smooth",
    },
    markers: {
      show: false,
    },
    labels: {
      show: false,
    },
    dataLabels: {
      enabled: false,
    },

    grid: {
      show: true,
      xaxis: {
        lines: {
          show: true,
        },
      },
      yaxis: {
        lines: {
          show: true,
        },
      },
      column: {
        opacity: 0.2,
      },
    },

    tooltip: {
      enabled: true,
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        return (
          '<div class="custom-tooltip">' +
          '<span class="custom-tooltip__title">' +
          w.globals.series[seriesIndex][dataPointIndex] +
          " درخواست</span>" +
          '<span class="custom-tooltip__subtitle"> از ' +
          w.globals.seriesNames[seriesIndex] +
          "</span>" +
          "</div>"
        );
      },
    },

    responsive: [
      {
        breakpoint: 1024,
        options: {
          chart: {
            height: 300,
          },
        },
      },
      {
        breakpoint: 1366,
        options: {
          chart: {
            height: 350,
          },
        },
      },
    ],
  };

  let lineChartContainer = document.querySelector("#line-chart");
  let lineChart =
    lineChartContainer && new ApexCharts(lineChartContainer, lineOptions);
  lineChart && lineChart.render();

  
  let bitcoinOptions = {
    series: [
      {
        name: "خرید",
        data: [9400, 9200, 9700, 9400, 9200, 9600],
      },

      {
        name: "فروش",
        data: [9150, 9650, 9350, 9750, 9250, 9650],
      },
    ],

    chart: {
      fontFamily: "Jost, sans-serif",
      height: 335,
      type: "area",
      background: "transparent",
      toolbar: {
        show: false,
      },
    },

    xaxis: {
      type: "category",
      categories: [
        "3:00 PM",
        "4:00 PM",
        "5:00 PM",
        "6:00 PM",
        "7:00 PM",
        "8:00 PM",
      ],
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      crosshairs: {
        show: false,
      },
    },
    yaxis: {
      labels: {
        offsetX: -10,
      },
      title: {
        style: {
          fontSize: "0px",
        },
      },
      min: 9100,
      max: 9800,
      tickAmount: 3,
      opposite: true,
    },
    colors: ["#00A389", "#FF5B5B"],
    fill: {
      colors: ["transparent", "transparent"],
      type: ["solid", "solid"],
    },

    legend: {
      show: true,
      position: "top",
      horizontalAlign: "right",
      fontSize: "16px",
      fontWeight: 500,
    },
    stroke: {
      width: [5, 5],
      curve: "smooth",
    },
    markers: {
      show: false,
    },
    labels: {
      show: false,
    },
    dataLabels: {
      enabled: false,
    },

    grid: {
      show: true,
      xaxis: {
        lines: {
          show: true,
        },
      },
      yaxis: {
        lines: {
          show: true,
        },
        horizontalAlign: "right",
      },
      column: {
        opacity: 0.2,
      },
    },

    tooltip: {
      enabled: true,
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        return (
          '<div class="custom-tooltip">' +
          '<span class="custom-tooltip__title">' +
          w.globals.series[seriesIndex][dataPointIndex] +
          " درخواست</span>" +
          '<span class="custom-tooltip__subtitle"> از ' +
          w.globals.seriesNames[seriesIndex] +
          "</span>" +
          "</div>"
        );
      },
    },

    responsive: [
      {
        breakpoint: 1024,
        options: {
          chart: {
            height: 300,
          },
        },
      },
      {
        breakpoint: 1366,
        options: {
          chart: {
            height: 350,
          },
        },
      },
    ],
  };

  
  let bitcoinChartContainer = document.querySelector("#bitcoin-chart");
  let bitcoinChart =
    bitcoinChartContainer &&
    new ApexCharts(bitcoinChartContainer, bitcoinOptions);
  bitcoinChart && bitcoinChart.render();

  
  let ethererumChartContainer = document.querySelector("#ethererum-chart");
  let ethererumChart =
    ethererumChartContainer &&
    new ApexCharts(ethererumChartContainer, bitcoinOptions);
  ethererumChart && ethererumChart.render();

  
  let litecoinChartContainer = document.querySelector("#litecoin-chart");
  let litecoinChart =
    litecoinChartContainer &&
    new ApexCharts(litecoinChartContainer, bitcoinOptions);
  litecoinChart && litecoinChart.render();

  
  let activityOptions = {
    series: [
      {
        name: "سود شما",
        data: [23, 11, 22, 27, 13, 22, 37, 21],
      },

      {
        name: "خریدs",
        data: [30, 25, 36, 30, 45, 35, 64, 52],
      },

      {
        name: "فروشs",
        data: [70, 60, 43, 38, 40, 55, 24, 16],
      },
    ],

    chart: {
      fontFamily: "Jost, sans-serif",
      height: 335,
      type: "area",
      background: "transparent",
      toolbar: {
        show: false,
      },
    },

    xaxis: {
      type: "category",
      categories: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      crosshairs: {
        show: false,
      },
    },
    yaxis: {
      labels: {
        offsetX: -10,
      },
      title: {
        style: {
          fontSize: "0px",
        },
      },
      min: 0,
      max: 75,
      tickAmount: 3,
    },
    colors: ["#AB54DB", "#00A389", "#FF5B5B"],
    fill: {
      colors: ["transparent", "transparent", "transparent"],
      type: ["solid", "solid", "solid"],
    },

    legend: {
      show: true,
      position: "top",
      horizontalAlign: "left",
    },
    stroke: {
      width: [5, 5, 5],
      curve: "smooth",
    },
    markers: {
      show: false,
    },
    labels: {
      show: false,
    },
    dataLabels: {
      enabled: false,
    },

    grid: {
      show: true,
      xaxis: {
        lines: {
          show: true,
        },
      },
      yaxis: {
        lines: {
          show: true,
        },
      },
      column: {
        opacity: 0.2,
      },
    },

    tooltip: {
      enabled: true,
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        
        let value = w.globals.series[seriesIndex][dataPointIndex];
        var maxValue = Math.max(...series[0]);
        var percentage = ((value / maxValue) * 10).toFixed(0);

        return (
          '<div class="custom-tooltip">' +
          '<span class="custom-tooltip__title">' +
          percentage +
          "%</span>" +
          '<span class="custom-tooltip__subtitle">' +
          value +
          " بازدیدکنندگان</span>" +
          "</div>"
        );
      },
    },

    responsive: [
      {
        breakpoint: 1024,
        options: {
          chart: {
            height: 300,
          },
        },
      },
      {
        breakpoint: 1366,
        options: {
          chart: {
            height: 350,
          },
        },
      },
    ],
  };

  let activityChartContainer = document.querySelector("#market-activity-chart");
  let activityChart =
    activityChartContainer &&
    new ApexCharts(activityChartContainer, activityOptions);
  activityChart && activityChart.render();

  
  let barOptions = {
    series: [
      {
        data: [40, 31, 40, 10, 40, 36, 32],
      },
    ],
    chart: {
      height: 250,
      type: "bar",
      toolbar: {
        show: false,
      },
    },
    colors: ["#AB54DB26"],
    plotOptions: {
      bar: {
        columnWidth: 50,
        borderRadius: 12,
      },
    },
    dataLabels: {
      enabled: false,
    },

    xaxis: {
      categories: [
        "جمعه",
        "پنج شنبه",
        "چهارشنبه",
        "سه شنبه",
        "دوشنبه",
        "یک شنبه",
        "شنبه",
      ],
      position: "bottom",
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      crosshairs: {
        show: false,
      },
      tooltip: {
        enabled: false,
      },
    },
    yaxis: {
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      labels: {
        show: false,
      },
    },

    grid: {
      show: false,
      padding: { left: -20, right: -20, top: 0, bottom: 0 },
    },

    tooltip: {
      enabled: true,

      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        
        let value = w.globals.series[seriesIndex][dataPointIndex];
        var maxValue = Math.max(...series[0]);
        var percentage = ((value / maxValue) * 10).toFixed(0);

        return (
          '<div class="custom-tooltip">' +
          '<span class="custom-tooltip__title">' +
          percentage +
          "%</span>" +
          '<span class="custom-tooltip__subtitle">' +
          value +
          " بازدیدکنندگان</span>" +
          "</div>"
        );
      },
    },
  };

  let barChartContainer = document.querySelector("#column-chart");
  let barChart =
    barChartContainer && new ApexCharts(barChartContainer, barOptions);
  barChart && barChart.render();

  
  let pieOptions = {
    series: [44, 55, 41],
    labels: ["سرورهای ثابت", "سرورهای پایین", "درحال اجرا"],
    colors: ["#AB54DB", "#EF9A91", "#F1E6B9"],
    plotOptions: {
      pie: {
        expandOnClick: false,
        startAngle: 0,
        dataLabels: {
          enabled: false,
        },
        customScale: 1, 
      },
      stroke: {
        width: 25, 
        colors: ["transparent"], 
      },
    },
    chart: {
      height: "350px",
      type: "donut",
    },
    responsive: [
      {
        breakpoint: 576,
        options: {
          chart: {
            height: "550px",
          },
        },
      },
    ],
    legend: {
      show: true,
      position: "bottom",
      fontSize: "14px",
      fontWeight: 500,
      formatter: function (seriesName, opts) {
        let data = opts.w.globals.seriesTotals[opts.seriesIndex];
        return seriesName + ":  " + data;
        
      },
    },
    responsive: [
      {
        breakpoint: 480,
        options: {
          chart: {
            width: 200,
          },
          legend: {
            position: "bottom",
          },
        },
      },
    ],
  };

  let pieChartContainer = document.querySelector("#pie-chart");
  let pieChart =
    pieChartContainer && new ApexCharts(pieChartContainer, pieOptions);
  pieChart && pieChart.render();

  
  let summaryOptions = {
    series: [30, 34, 6, 30],
    labels: ["Ethereum", "Litecoin", "Ripple", "Bitcoin"],
    colors: ["#00ADA3", "#374C98", "#23292F", "#FFBB54"],
    plotOptions: {
      pie: {
        expandOnClick: false,
        startAngle: 0,
        dataLabels: {
          enabled: false,
        },
        customScale: 1, 
      },
      stroke: {
        width: 25, 
        colors: ["transparent"], 
      },
    },
    chart: {
      height: "350px",
      type: "donut",
    },
    responsive: [
      {
        breakpoint: 576,
        options: {
          chart: {
            height: "550px",
          },
        },
      },
    ],
    legend: {
      show: true,
      position: "bottom",
      fontSize: "14px",
      fontWeight: 500,
      formatter: function (seriesName, opts) {
        let data = opts.w.globals.seriesTotals[opts.seriesIndex];
        return seriesName + ":  " + data;
        
      },
    },
    responsive: [
      {
        breakpoint: 480,
        options: {
          chart: {
            width: 200,
          },
          legend: {
            position: "bottom",
          },
        },
      },
    ],
  };

  let summaryChartContainer = document.querySelector("#summary-chart");
  let summaryChart =
    summaryChartContainer &&
    new ApexCharts(summaryChartContainer, summaryOptions);
  summaryChart && summaryChart.render();

  
  let stackOptions = {
    chart: {
      type: "bar",
      height: 350,
      stacked: true,
      toolbar: {
        show: false,
      },
    },
    series: [
      {
        name: "محصول A",
        data: [2, 5, 1, 7, 2, 4, 1, 4],
        dataLabels: false,
      },
      {
        name: "محصول B",
        data: [1, 3, 2, 8, 3, 7, 3, 2],
        dataLabels: false,
      },
      {
        name: "محصول C",
        data: [1, 7, 5, 3, 2, 4, 5, 3],
        dataLabels: false,
      },
    ],
    xaxis: {
      type: "category",
      categories: [
        "جمعه",
        "پنج شنبه",
        "چهارشنبه",
        "سه شنبه",
        "دوشنبه",
        "یک شنبه",
        "شنبه",
      ],
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      crosshairs: {
        show: false,
      },
    },
    yaxis: {
      opposite: true,
      labels: {
        show: true,
        formatter: function (val) {
          return val + " AM";
        },
        offsetX: -17,
      },
      min: 0,
      max: 10,
      tickAmount: 5,
    },
    legend: {
      show: false,
    },
    grid: {
      show: false,
      padding: {
        left: -10,
        right: 0,
      },
    },
    tooltip: {
      enabled: false,
    },
    dataLabels: {
      enabled: false,
    },
    plotOptions: {
      bar: {
        columnWidth: 18,
        borderRadius: 0,
      },
    },
  };

  let stackChartContainer = document.querySelector("#stack-chart");
  let stackChart =
    stackChartContainer && new ApexCharts(stackChartContainer, stackOptions);
  stackChart && stackChart.render();

  
  let incomeOptions = {
    series: [
      {
        data: [40, 32, 45, 65, 23, 54, 23],
      },
    ],

    chart: {
      height: 350,
      type: "bar",
      toolbar: {
        show: false,
      },
    },

    colors: ["#1BD5FE"],

    fill: {
      type: "gradient",
      gradient: {
        type: "vertical",
        shadeIntensity: 1,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100],
        gradientToColors: ["#216BDB"],
      },
    },

    plotOptions: {
      bar: {
        columnWidth: 50,
        borderRadius: 12,
      },
    },

    dataLabels: {
      enabled: false,
    },

    xaxis: {
      categories: [
        "جمعه",
        "پنج شنبه",
        "چهارشنبه",
        "سه شنبه",
        "دوشنبه",
        "یک شنبه",
        "شنبه",
      ],
      position: "bottom",
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      crosshairs: {
        show: false,
      },
      tooltip: {
        enabled: false,
      },
    },

    yaxis: {
      labels: {
        show: true,
        offsetX: 0,
      },
      min: 0, 
      max: 70,
      tickAmount: 3,
    },

    grid: {
      show: true,
      padding: { left: 0, right: 0, top: 0, bottom: 0 },
    },

    tooltip: {
      enabled: true,
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        
        let value = w.globals.series[seriesIndex][dataPointIndex];
        var maxValue = Math.max(...series[0]);
        var percentage = ((value / maxValue) * 10).toFixed(0);

        
        var mouseX = window.mouseX || 0;
        var mouseY = window.mouseY || 0;

        
        var tooltipX = mouseX - 50;
        var tooltipY = mouseY - 30; 

        return (
          '<div class="custom-tooltip" style="left:' +
          tooltipX +
          "px; top:" +
          tooltipY +
          'px;">' +
          '<span class="custom-tooltip__title">$' +
          percentage +
          "</span>" +
          '<span class="custom-tooltip__subtitle">' +
          value +
          " بازدیدکنندگان</span>" +
          "</div>"
        );
      },
    },
  };

  let incomeChartContainer = document.querySelector("#income-chart");
  let incomeChart =
    incomeChartContainer && new ApexCharts(incomeChartContainer, incomeOptions);
  incomeChart && incomeChart.render();

  
  let expenseOptions = {
    series: [
      {
        data: [40, 32, 45, 65, 23, 54, 23],
      },
    ],

    chart: {
      height: 350,
      type: "bar",
      toolbar: {
        show: false,
      },
    },

    colors: ["#FFBB54"],

    fill: {
      type: "gradient",
      gradient: {
        type: "vertical",
        shadeIntensity: 1,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100],
        gradientToColors: ["#FF3300"],
      },
    },

    plotOptions: {
      bar: {
        columnWidth: 50,
        borderRadius: 12,
      },
    },

    dataLabels: {
      enabled: false,
    },

    xaxis: {
      categories: [
        "جمعه",
        "پنج شنبه",
        "چهارشنبه",
        "سه شنبه",
        "دوشنبه",
        "یک شنبه",
        "شنبه",
      ],
      position: "bottom",
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      crosshairs: {
        show: false,
      },
      tooltip: {
        enabled: false,
      },
    },

    yaxis: {
      labels: {
        show: true,
        offsetX: 0,
      },
      min: 0, 
      max: 70,
      tickAmount: 3,
    },

    grid: {
      show: true,
      padding: { left: 0, right: 0, top: 0, bottom: 0 },
    },

    tooltip: {
      enabled: true,
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        
        let value = w.globals.series[seriesIndex][dataPointIndex];
        var maxValue = Math.max(...series[0]);
        var percentage = ((value / maxValue) * 10).toFixed(0);

        
        var mouseX = window.mouseX || 0;
        var mouseY = window.mouseY || 0;

        
        var tooltipX = mouseX - 50;
        var tooltipY = mouseY - 30; 

        return (
          '<div class="custom-tooltip" style="left:' +
          tooltipX +
          "px; top:" +
          tooltipY +
          'px;">' +
          '<span class="custom-tooltip__title">$' +
          percentage +
          "</span>" +
          '<span class="custom-tooltip__subtitle">' +
          value +
          " بازدیدکنندگان</span>" +
          "</div>"
        );
      },
    },
  };

  let expenseChartContainer = document.querySelector("#expense-chart");
  let expenseChart =
    expenseChartContainer &&
    new ApexCharts(expenseChartContainer, expenseOptions);
  expenseChart && expenseChart.render();

  if ($("#chart-5").length) {
    var options = {
      series: [80],
      chart: {
        height: 120,
        type: "radialBar",
      },
      plotOptions: {
        show: false,
        radialBar: {
          show: false,
          dataLabels: {
            show: false,
          },
        },
      },
      stroke: {
        width: 1, 
        colors: ["transparent"], 
      },
      fill: {
        type: "gradient",
        gradient: {
          shade: "dark",
          type: "horizontal",
          shadeIntensity: 1,
          gradientToColors: ["#0061FF"],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 0.5,
          stops: [0, 100],
        },
      },
      labels: ["Median Ratio"],
    };
    var chart = new ApexCharts(document.querySelector("#chart-5"), options);
    chart.render();
  }

  if ($("#chart-6").length) {
    var optionsTwo = {
      series: [50],
      chart: {
        height: 120,
        type: "radialBar",
      },
      plotOptions: {
        show: false,
        radialBar: {
          show: false,
          dataLabels: {
            show: false,
          },
        },
      },
      stroke: {
        width: 1, 
        colors: ["transparent"], 
      },
      fill: {
        type: "gradient",
        gradient: {
          shade: "#34A853",
          type: "horizontal",
          shadeIntensity: 1,
          gradientToColors: ["#34A853"],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100],
        },
      },
      labels: ["Median Ratio"],
    };
    var chart = new ApexCharts(document.querySelector("#chart-6"), optionsTwo);
    chart.render();
  }

  if ($("#chart-7").length) {
    var optionsThree = {
      series: [70],
      chart: {
        height: 120,
        type: "radialBar",
      },
      plotOptions: {
        show: false,
        radialBar: {
          show: false,
          dataLabels: {
            show: false,
          },
        },
      },
      stroke: {
        width: 1, 
        colors: ["transparent"], 
      },
      fill: {
        type: "gradient",
        gradient: {
          shade: "#0364B8",
          type: "horizontal",
          shadeIntensity: 1,
          gradientToColors: ["#0364B8"],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100],
        },
      },
      labels: ["Median Ratio"],
    };

    var chart = new ApexCharts(
      document.querySelector("#chart-7"),
      optionsThree
    );
    chart.render();
  }

  if ($("#chart-8").length) {
    var optionsFour = {
      series: [30],
      chart: {
        height: 120,
        type: "radialBar",
      },
      plotOptions: {
        show: false,
        radialBar: {
          show: false,
          dataLabels: {
            show: false,
          },
        },
      },
      stroke: {
        width: 1, 
        colors: ["transparent"], 
      },
      fill: {
        type: "gradient",
        gradient: {
          shade: "#8AD2F7",
          type: "horizontal",
          shadeIntensity: 1,
          gradientToColors: ["#8AD2F7"],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 0.5,
          stops: [0, 100],
        },
      },
      labels: ["Median Ratio"],
    };

    var chart = new ApexCharts(document.querySelector("#chart-8"), optionsFour);
    chart.render();
  }

  
  $(document).ready(function () {
    var drake = dragula([
      document.querySelector("#one"),
      document.querySelector("#two"),
      document.querySelector("#three"),
      document.querySelector("#four"),
      document.querySelector("#five"),
      document.querySelector("#won"),
    ]);

    drake.on("drag", function (el) {
      el.classList.add("gu-transit");
    });

    drake.on("drop", function (el) {
      el.classList.remove("gu-transit");
    });
  });
})(jQuery);

