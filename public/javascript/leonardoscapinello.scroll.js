let nextURL;

function updateNextURL(doc) {
    nextURL = $(doc).find(".pagination__next").attr('href');
}

updateNextURL(document);

let $container = $('.blog-next-posts').infiniteScroll({
    path: function () {
        return nextURL;
    },
    append: '.post',
    history: 'push',
    historyTitle: true,
    scrollThreshold: 1100
});

$container.on('load.infiniteScroll', function (event, response) {
    updateNextURL(response);
});


$container.on('scrollThreshold.infiniteScroll', function () {
    $(".nextpost-widget").last().slideDown(300);
    $(".nextpost-widget").addClass("nxpwdgevt")
});

$container.on('history.infiniteScroll', function () {
    $(".nextpost-widget:not(:last)").slideUp(200, function () {
        $(this).remove();
    });
    //ga('set', 'page', location.pathname);
    //ga('send', 'pageview');
});


var lastScrollTop = 0;
$(window).scroll(function (event) {
    var st = $(this).scrollTop();
    if (st > lastScrollTop) {
        $(".nxpwdgevt").last().slideDown(300);
    } else {
        $(".nxpwdgevt").last().slideUp(300);
    }
    lastScrollTop = st;
});