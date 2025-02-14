// Javascript File
$(function () {
    // AOS js Initializations 
    AOS.init();

    // Scroll Spy
    $(document).on("scroll", onScroll);
    //smoothscroll
    function onScroll(event) {
        var scrollPos = $(document).scrollTop();
        $('.parallaxControls div.pointerDiv a').each(function () {
            var currLink = $(this);
            var refElement = $(currLink.attr("href"));
            if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                $('.parallaxControls div.pointerDiv').removeClass("active");
                currLink.parent('.pointerDiv').addClass("active");
            } else {
                currLink.removeClass("active");
            }
        });
    }

    //Desktop Menu
    if ($(window).width() > 991) {
        // Mega Menu on mouse hover js 
        $("header .dropdown").hover(
            function () {
                $('.dropdown-menu.shadow', this).fadeIn("fast");
            },
            function () {
                $('.dropdown-menu.shadow', this).fadeOut("fast");
            }
        );

        // Second level menu
        $(".dropdown.dropend").hover(
            function () {
                $('.dropdown-menu', this).fadeIn("fast");
            },
            function () {
                $('.dropdown-menu', this).fadeOut("fast");
            }
        );

        $('.singleColumn .dropdown-item').on('click', function (e) {
            // debugger;
            var href = $(this).prop('href');
            var hash1 = href.split('#')[1];
            $('.nav-tabs a[href="#' + hash1 + '"]').tab('show');
        });

        $('.nav-item .nav-link').on('click', function (e) {
            // debugger;
            var href = $(this).prop('href');
            var hash1 = href.split('#')[1];
            $('html,body').animate({
                scrollTop: $("#" + hash1).offset().top - 60
            }, 'slow');
        });

    }

    // MObile Menu 
    if ($(window).width() < 991) {
        $("header a").removeAttr("data-bs-toggle");
        $("header a").removeAttr("data-bs-auto-close");

        $("#MobileMenu").on('click', function () {
            $("#navbar-content").addClass('Open');
            $(".menuOverlay").addClass('active');
        });
        $("#parentCLose").on('click', function () {
            $(this).parents("#navbar-content").removeClass('Open');
            $(".menuOverlay").removeClass('active');
        });
        $(".submenu").on('click', function () {
            $(this).parents(".dropdown-menu").removeClass('OpenSubMenu show');
        });
        $(".closeMobileMenu").on('click', function () {
            $(this).parent(".dropdown-menu").removeClass('OpenSubMenu');
        });

        $(".dropdown-item, .dropdown .nav-link").click(function () {
            $(this).next('.dropdown-menu').addClass('OpenSubMenu');
        });

    }

    // REinitializer 
    $('.modal-carousel-control').click(function (e) {
        e.preventDefault();
        $('#main-carousel').carousel($(this).data());
    });

    // SLider COunter - HMOME CAROUSEL
    var totalItems = $('#main-carousel .carousel-item').length;
    var currentIndex = $('#main-carousel .carousel-item.active').index() + 1;
    $('#main-carousel .count').html("1" + '/' + totalItems);
    var $carousel = $('#main-carousel');
    $('#main-carousel').on('slid.bs.carousel', function () {
        var currentIndex1 = $('#main-carousel .carousel-item.active').index() + 1;
        $('#main-carousel .count').html(currentIndex1 + '/' + totalItems);
    });

    // SLider COunter - COMMUNITY CAROUSEL
    var totalItems12 = $('#community-carousel .carousel-item').length;
    var currentIndex12 = $('#community-carousel .carousel-item.active').index() + 1;
    $('#community-carousel .count').html(currentIndex12 + '/' + totalItems12);
    var $carousel = $('#community-carousel');
    $('#community-carousel').on('slid.bs.carousel', function () {
        var currentIndex11 = $('#community-carousel .carousel-item.active').index() + 1;
        $('#community-carousel .count').html(currentIndex11 + '/' + totalItems12);
    });

    // tabs class
    $("#SK-link").on('shown.bs.tab', function () {
        $('.founderTabs').addClass('active');
        $('.founderPage').addClass('active');
    });
    $("#KJ-link").on('shown.bs.tab', function () {
        $('.founderTabs').removeClass('active');
        $('.founderPage').removeClass('active');
    });

    // Floating thumbnail clicks
    $(".pointerDiv").on('click', function () {
        $(".pointerDiv").removeClass("active");
        $(this).addClass("active");
    });
    $(".pointerDiv").on('mouseover', function () {
        $(".pointerDiv").removeClass("active");
        $(this).addClass("active");
    });

    // Our FOunders 
    $(".verticalTabs .nav-link, .founderTabs .nav-link").on('shown.bs.tab', function () {
        AOS.refresh();
    });

    // For Archives Page

    $('.toggle-tabs .title').click(function () {
        if ($(this).parents('.toggle-tabs').hasClass('current')) {
            $(this).parents('.toggle-tabs').removeClass('current');
            $(this).next('.dropdown-content').slideUp();
        } else {
            $('.toggle-tabs').removeClass('current');
            $('.toggle-tabs .title').next('.dropdown-content').slideUp();
            $(this).parents('.toggle-tabs').addClass('current');
            $(this).next('.dropdown-content').slideDown();
        }

        $('.tab-content.hideresult').show();
        $('.tab-content.no-result1 .tab-pane').hide();
        $('.tab-content.no-result2 .tab-pane').hide();

        var mytabs = $(this).attr('data-mytabs');

        if ($(this).hasClass("title-dropdown")) {

        } else {
            $('.tab-content .tab-pane').removeClass('active');
            $('#' + mytabs).addClass('active');
        }
    });


    $("#novideo").click(function () {

        $('.tab-content.no-result1 .tab-pane').show();
        $('.tab-content.no-result2 .tab-pane').hide();
        $('.tab-content.hideresult').hide();
    });

    $("#nogallery").click(function () {

        $('.tab-content.no-result2 .tab-pane').show();
        $('.tab-content.no-result1 .tab-pane').hide();
        $('.tab-content.hideresult').hide();
    });

    if ($(window).width() < 500) {
        $(".dropdown-content .nav-link").on('click', function (e) {
            e.preventDefault();
            $('.tabs-sec').addClass('sticky');
            $('html, body').animate({
                scrollTop: $('#myTabContent').offset().top
            }, 100);

        });
    }


    // Page Jump 
    var hash = document.location.hash;
    if (hash) {
        $('html,body').animate({
            scrollTop: $(hash).offset().top - 60
        }, 'slow');
    }

    // Scroll Event for CLick to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 1000) {
            $(".toparrow").addClass('showbtn');
        } else {
            $(".toparrow").removeClass('showbtn');
        }
    });

    // Scroll Top animate 
    $(".toparrow a").on('click', function () {
        $("html, body").animate({ scrollTop: 0 }, 1000);
    });

    // Add active class to ta
    $(".verticalTabs .nav-tabs li a.nav-link").on('click', function () {
        $(".verticalTabs .nav-tabs li a.nav-link").removeClass('active');
        $(this).addClass('active');
    });

    // HomepageSLider js for retriggering after dynamic binding
    $("#home-slider .carousel-inner div:first-child").addClass("active");
    $('.carousel-control-prev').click(function () {
        // alert("prev");
        $('#main-carousel').carousel('prev');
    });
    $('.carousel-control-next').click(function () {
        // alert("next");
        $('#main-carousel').carousel('next');
    });

    // Tab set to fixed on scroll 
    var tabsPos = $('.verticalTabs').offset().top;
    console.log('tabsPos' + tabsPos);

    // var banner = $('.BannerSections').offset().top;
    // console.log('footerOffset' + footerOffset);

    var HeaderHeight = $('header').height();
    console.log('HeaderHeight' + HeaderHeight);

    // var StickyHeaderHeight = $('header.stickyHeader').height();
    // console.log('StickyHeaderHeight' + StickyHeaderHeight);

    // var maxY = tabsPos + HeaderHeight;
    // console.log('maxY' + maxY);

    $(window).scroll(function (evt) {
        var scrollEvent = $(window).scrollTop();
        if (scrollEvent >= tabsPos) {
            $('.verticalTabs').css({
                'position': 'fixed',
                'top': 0,
                'z-index': 9999,
            });
        } else {
            $('.verticalTabs').css({
                'position': 'relative',
                'top': 'auto',
                'z-index': 9,
            });
        }
    });

});