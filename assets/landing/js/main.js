jQuery(function () {
    //smoothscroll
    var $root = $('html, body');
    $('a[href^="#"]').click(function () {
        $root.animate({
            scrollTop: $($.attr(this, 'href')).offset().top - $('#brandLogo').height() + 5
        }, 1000);
        return false;
    });
    //parallax
    $(window).enllax();
    //slick slider
    $('#hightlights-recipes').slick({
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 3,
        dots: true,
        arrows: false,
        focusOnSelect: true,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1,
                    infinite: false
                }
            }
        ]
    });
    $('#sec1-slide').slick({
        centerMode: true,
        centerPadding: '00px',
        slidesToShow: 3,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    dots: true,
                    centerPadding: '00px',
                    slidesToShow: 1,
                    infinite: false
                }
            }
        ]
    });
    $('#famous-people').slick({
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 3,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    dots: true,
                    centerPadding: '00px',
                    slidesToShow: 1,
                    infinite: false
                }
            }
        ]
    });
    $('#sec6').slick({
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 3,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    dots: true,
                    centerPadding: '00px',
                    slidesToShow: 1,
                    infinite: false
                }
            }
        ]
    });
    //easy responsive tab
    $('#tabs1').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion           
        width: 'auto', //auto or any custom width
        fit: true,   // 100% fits in a container
        closed: true, // Close the panels on start, the options 'accordion' and 'tabs' keep them closed in there respective view types
        activate: function () { },  // Callback function, gets called if tab is switched
        tabidentify: 'tabs1', // The tab groups identifier *This should be a unique name for each tab group and should not be defined in any styling or css file.
        
    });
    //activate all tabs in small devices
    if (window.innerWidth <= 768) {
        $(".resp-tabs-container>div").addClass("resp-tab-content-active");
        $(".resp-tabs-container > h2").unbind("click");
    }
    //lazy load settings
    //scene preset
    $("#slick-slide10").css({ opacity: 0.0, transform: "translateX(-100px)" });
    $("#slick-slide11").css({ opacity: 0.0, transform: "translateX(-100px)" });
    $("#slick-slide12").css({ opacity: 0.0, transform: "translateX(-100px)" });
    $("#sec1-scene1").css({ opacity: 0.0, transform: "translateX(-100px)" });
    $("#sec1-scene2").css({ opacity: 0.0, transform: "translateX(-100px)" });
    $("#sec1-scene3").css({ opacity: 0.0, transform: "translateX(-100px)" });
    $("#sec21").css({ opacity: 0.0, transform: "scale(0.6)" });
    $("#sec22").css({ opacity: 0.0});
    $("#sec23").css({ opacity: 0.0, transform: "scale(0.6)" });
    $("#sec24").css({ opacity: 0.0});
    $("#sec25").css({ opacity: 0.0, transform: "scale(0.6)" });
    $("#sec41").css({ opacity: 0.0, transform: "scale(0.6)" });
    $("#sec42").css({ opacity: 0.0, transform: "scale(0.6)" });
    $("#sec43").css({ opacity: 0.0, transform: "scale(0.6)" });
    $("#head-decor-1").css({ opacity: 0.0, transform: "scale(0.6) translateY(300px)"  });
    $("#head-decor-2").css({ opacity: 0.0, transform: "scale(0.6) translateY(200px)" });
    $("#famous-overlay").css({ transform: "translateY(400px)" });
    //init controller
    var controller = new ScrollMagic.Controller();
    //create a scene
    new ScrollMagic.Scene({
        triggerElement: "#sec1",
        offset: 200     
    })
        .setTween("#slick-slide10", 0.3, { opacity: 1.0, transform: "translateX(0px)" })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec1",
        offset: 200
    })
        .setTween("#slick-slide11", { opacity: 1.0, transform: "translateX(0px)", delay: 0.2 })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec1",
        offset: 200
    })
        .setTween("#slick-slide12", { opacity: 1.0, transform: "translateX(0px)", delay: 0.4 })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec1",
        offset: 200
    })
        .setTween("#sec1-scene1", 0.3, { opacity: 1.0, transform: "translateX(0px)" })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec1",
        offset: 200
    })
        .setTween("#sec1-scene2", { opacity: 1.0, transform: "translateX(0px)", delay: 0.2 })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec1",
        offset: 200
    })
        .setTween("#sec1-scene3", { opacity: 1.0, transform: "translateX(0px)", delay: 0.4 })
        .addTo(controller);
    new ScrollMagic.Scene({
        triggerElement: "#sec2",
        offset: 000
    })
        .setTween("#sec21", { opacity: 1.0, transform: "scale(1.0)", delay: 0.0 })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec21",
        offset: 200
    })
        .setTween("#sec22", { opacity: 1.0, delay: 0.4 })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec21",
        offset: -50
    })
        .setTween("#sec23", { opacity: 1.0, transform: "scale(1.0)", delay: 0.4 })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec23",
        offset: 200
    })
        .setTween("#sec24", { opacity: 1.0, delay: 0.4 })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec23",
        offset: -50
    })
        .setTween("#sec25", { opacity: 1.0, transform: "scale(1.0)", delay: 0.4 })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec4",
        offset: -100
    })
        .setTween("#sec41", { opacity: 1.0, transform: "scale(1.0)", delay: 0.4 })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec4",
        offset: -100
    })
        .setTween("#sec42", { opacity: 1.0, transform: "scale(1.0)", delay: 0.4 })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec4",
        offset: -100
    })
        .setTween("#sec43", { opacity: 1.0, transform: "scale(1.0)", delay: 0.4 })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#headNav",
        offset: 0
    })
        .setTween("#head-decor-1", { opacity: 1.0, transform: "scale(1.0) translateY(0px)" })
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#headNav",
        offset: 0
    })
        .setTween("#head-decor-2", { opacity: 1.0, transform: "scale(1.0) translateY(0px)", delay: 0.5})
        .addTo(controller);
    //
    new ScrollMagic.Scene({
        triggerElement: "#sec3",
        offset: 0,
        duration: 1200
    })
        .setTween("#famous-overlay", { transform: "translateY(0px)" })
        .addTo(controller);
    if (isMobile) {
        //hide logo
        //
        new ScrollMagic.Scene({
            triggerElement: "#sec1",
            offset: 0,
            duration: 600
        })
            .setTween("#headNav", { transform: "translateY(-42px)" })
            .addTo(controller);
    }

    //hide nav on click
    $('.nav a, .nav-overlay').on('click', function () {       
        $('.navbar-toggler').click()
    });

    $('#online-support-hide').click(function() {
        var cookieName = 'hide_online_support_window';
        setCookie(cookieName, true, 1);
        $(this).hide();
        $('#online-support-body').hide();
    });
    $('#online-support-title').click(function() {
        var cookieName = 'hide_online_support_window';
        if(getCookie(cookieName))
            setCookie(cookieName, true, -1);
        $('#online-support-hide').show();
        $('#online-support-body').show();
    });
});

function setCookie(cname, cvalue, exdays)
{
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0;i < ca.length;i ++)
    {
        var c = ca[i];
        while(c.charAt(0) == ' ')
        {
            c = c.substring(1);
        }
        if(c.indexOf(name) == 0)
        {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}