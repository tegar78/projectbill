(function ($) {
  "use strict"; // Start of use strict

  // Mobile sidebar helper functions
  function closeMobileSidebar() {
    $("body").removeClass("sidebar-open");
    $("body").css("overflow", "");
  }

  function toggleMobileSidebar() {
    $("body").toggleClass("sidebar-open");
    if ($("body").hasClass("sidebar-open")) {
      $("body").css("overflow", "hidden");
      if (document.activeElement && typeof document.activeElement.blur === 'function') {
        document.activeElement.blur();
      }
      if (typeof $ === 'function' && $.fn && $.fn.select2) {
        try { $('select').select2('close'); } catch (err) {}
      }
    } else {
      $("body").css("overflow", "");
    }
  }

  // Toggle the side navigation
  $("#sidebarToggleTop").on('click', function (e) {
    e.preventDefault();
    if ($(window).width() < 768) {
      toggleMobileSidebar();
    } else {
      $("body").toggleClass("sidebar-toggled");
      $(".sidebar").toggleClass("toggled");
      if ($(".sidebar").hasClass("toggled")) {
        $('.sidebar .collapse').collapse('hide');
      }
    }
  });

  $("#sidebarToggle").on('click', function (e) {
    e.preventDefault();
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    }
  });

  // Close Mobile Sidebar button and Backdrop tap
  $(document).on('click', '#sidebarCloseBtn, #sidebarBackdrop', function (e) {
    e.preventDefault();
    closeMobileSidebar();
  });

  // Close on Escape key
  $(document).on('keyup', function (e) {
    if (e.key === "Escape" && $("body").hasClass("sidebar-open")) {
      closeMobileSidebar();
    }
  });

  // Close Mobile Sidebar when clicking on navigation links (not accordion toggles)
  $(document).on('click', '#accordionSidebar .nav-item a:not([data-toggle="collapse"])', function () {
    if ($(window).width() < 768) {
      closeMobileSidebar();
    }
  });

  // Set title attributes for native tooltip on collapsed sidebar
  function initSidebarTooltips() {
    $('#accordionSidebar .nav-item .nav-link').each(function () {
      var text = $(this).find('span').text().trim();
      if (text && !$(this).attr('title')) {
        $(this).attr('title', text);
      }
    });
  }
  initSidebarTooltips();

  // Close any open menu accordions or mobile drawer when window is resized
  $(window).resize(function () {
    if ($(window).width() >= 768) {
      closeMobileSidebar();
    }
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function (e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear & Topbar scroll elevation
  $(document).on('scroll', function () {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 10) {
      $('.topbar.nm-topbar').addClass('topbar-scrolled');
    } else {
      $('.topbar.nm-topbar').removeClass('topbar-scrolled');
    }

    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function (e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });

})(jQuery); // End of use strict
