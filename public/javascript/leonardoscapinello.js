window.setTimeout(function () {
    $('.blog-carousel').owlCarousel({
        loop: true,
        margin: 10,
        items: 3,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: false
            },
            1360: {
                items: 3,
                nav: true,
                loop: false
            }
        }
    });
    $('.series-carousel').owlCarousel({
        loop: false,
        margin: 10,
        items: 6,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1.4,
                center: true,
                loop: true,
                nav: true
            },
            420: {
                items: 1.9,
                loop: true,
                center: true,
                nav: false
            },
            530: {
                items: 2.24,
                loop: true,
                center: true,
                nav: false
            },
            680: {
                items: 2.8,
                nav: false
            },
            760: {
                items: 3,
                nav: false
            },
            800: {
                items: 3.3,
                nav: false
            },
            920: {
                items: 3.8,
                nav: false
            },
            1000: {
                items: 4.2,
                nav: false
            },
            1060: {
                items: 4.8,
                nav: false
            },
            1120: {
                items: 5.2,
                nav: false
            },
            1360: {
                items: 6,
                nav: true,
            }
        }
    });
    if ($(window).outerWidth() <= 960) {
        $(".blog-carousel-side").addClass("owl-carousel");
        $('.blog-carousel-side').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 1,
                    nav: false
                }
            }
        });
        $(".profile-blocks").addClass("owl-carousel");
        $('.profile-blocks').owlCarousel({
            loop: false,
            items: 3,
            margin: 10,
            responsiveClass: true,
            URLhashListener: true,
            autoplayHoverPause: false,
            startPosition: 'URLHash',
            center: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                360: {
                    items: 2,
                    nav: true
                },
                420: {
                    items: 2,
                    nav: false
                },
                620: {
                    items: 3,
                    nav: false
                },
                970: {
                    items: 1,
                    nav: false
                }
            }
        });
    }
    $(".hide-nm,.show-nm").on("click touch", function () {
        $(".nav-menu").animate({width: 'toggle'}, 350);
    });

    $('.mp-arrow-scroll').on("click touch", function () {
        $('html,body').animate({
            scrollTop: $("#ini-content").offset().top
        }, 'slow');
    });

    $(".phone_with_ddd").mask("(00) 00000-0000");
    $(".header-outer-size").css("height", ($(".header--company").outerHeight() - 6) + "px");


    function setActiveToHash() {
        if (window.location.hash !== -1) {
            let hash = window.location.hash.substring(1);
            if (typeof ld !== 'undefined' && typeof ld === 'function') {
                ld(hash);
            }
            var element = document.getElementById(hash + "_ac");
            if (element !== null && element !== undefined) {
                element.className += " active ";
            }
        }
    }

    window.setTimeout(function () {
        setActiveToHash();
    }, 100);

}, 100);
