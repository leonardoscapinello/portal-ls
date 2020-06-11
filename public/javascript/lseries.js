let selectionRange;

$("[data-dropselect='open']").on("click", function () {

    let ts = $(this);

    if (!ts.is(".overlayer")) {

        ts.next(".overlayer").fadeIn(200, function () {
            $("body").css("overflow", "hidden");
            ts.nextAll(".more_options").stop(true, true).show(0).animate({
                opacity: 1
            }, 300).animate({
                maxHeight: "300px",
            }, 500);
        });

        $([document.documentElement, document.body]).animate({
            scrollTop: ts.offset().top - 150
        }, 350);

    }
});
$(".overlayer").on("click", function () {

    let ovrl = $(this);

    $(this).nextAll(".more_options").stop(true, true).animate({
        maxHeight: 0,
    }, 500).animate({
        opacity: 0,
    }, 100, function () {
        ovrl.fadeOut(200);
        $("body").css("overflow", "auto");
    });
});

$('.seasons-articles').owlCarousel({
    loop: true,
    margin: 10,
    items: 4,
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
            items: 4,
            nav: true,
            loop: false
        }
    }
});


$(".scrollTo").on("click", function () {
    let hr = $(this).attr("href");
    $([document.documentElement, document.body]).animate({
        scrollTop: $(hr).offset().top - 150
    }, 350, function () {
        document.querySelector(hr).click();
    });
});

$(window).bind("scroll", function () {
    $('.superFocus > p').removeClass('reading');
    $(".superFocus > p").withinviewport().each(function (index) {
        if (index === 0) $(this).addClass("reading");
    });
});


function fireElement(el, ms) {
    if (el !== null && el !== undefined) {
        let id = el.id;
        if (confirm(ms)) {
            $(`#${id}`).contents().unwrap();
            saveContent2User();
        }
    }
}

function createId(length) {
    let result = '';
    let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function isTextSelected() {
    let elementById = document.getElementById("serie_ctn");
    return elementContainsSelection(elementById);
}

function setElementTag(cname) {
    let randomId = createId(24);
    if (!isTextSelected()) return alert("Selecione um texto antes de fazer anotações.");
    let span = document.createElement("span");
    span.className = "user_highlighted " + cname;
    span.id = randomId;
    if (window.getSelection) {
        let sel = window.getSelection();
        if (sel.rangeCount) {
            let range = sel.getRangeAt(0).cloneRange();
            range.surroundContents(span);
            sel.removeAllRanges();
            sel.addRange(range);
        }
    }
    saveContent2User();
}

/*

    span.onclick = function () {
        fireElement(this);
    };
 */
$(document).on("click", ".user_highlighted", function () {
    let cl = $(this).attr("class");
    let ms = "Você deseja remover os estilos aplicados a esse trecho do texto?";
    if (cl === "user_highlighted bold") ms = "Você deseja remover o negrito desse trecho?";
    if (cl === "user_highlighted italic") ms = "Você deseja remover o itálico desse trecho?";
    if (cl === "user_highlighted highlight") ms = "Você deseja remover o marca texto desse trecho?";
    if (cl === "user_highlighted comment") {
        let id = $(this).attr("data-comment");
        $(`#${id}`).stop().fadeToggle(300);
        return;
    }
    fireElement(this, ms);
});

function setComment() {
    let tx = document.getElementById("comment_tx");
    if (tx.value !== "") {
        let randomId = createId(24);
        restoreSelection(selectionRange);
        if (!isTextSelected()) return alert("Selecione um texto antes de fazer anotações.");
        let span = document.createElement("span");
        span.id = "jobCommentElement";
        span.setAttribute("data-comment", randomId);
        if (window.getSelection) {
            let sel = window.getSelection();
            if (sel.rangeCount) {
                let range = sel.getRangeAt(0).cloneRange();
                range.surroundContents(span);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
        let jobCommentElement = document.getElementById("jobCommentElement");
        let postComment = document.createElement("span");
        postComment.id = randomId;
        postComment.className = "comment_main";
        postComment.innerHTML = `<span class="comment_dialog post-it yellow"><span class="comment_text">${tx.value}</span></span>`;
        jobCommentElement.className += "user_highlighted comment";
        jobCommentElement.appendChild(postComment);
        jobCommentElement.id = "surrounded_" + randomId;
        tx.value = "";
        $("#comment_dialog").fadeOut(300);
        $("#" + randomId).delay(1).fadeOut(300);
        saveContent2User();
        return true;
    } else {
        return alert("É necessário preencher sua anotação com um texto.");
    }
}

function saveSelection() {
    if (window.getSelection) {
        let sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            return sel.getRangeAt(0);
        }
    } else if (document.selection && document.selection.createRange) {
        return document.selection.createRange();
    }
    return null;
}

function restoreSelection(range) {
    if (range) {
        if (window.getSelection) {
            let sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
        } else if (document.selection && range.select) {
            range.select();
        }
    }
}


function openComment() {
    $("#comment_dialog").fadeIn(300);
    selectionRange = saveSelection();
}

function closeComment() {
    let tx = document.getElementById("comment_tx");
    tx.value = "";
    $("#comment_dialog").fadeOut(300);
}


function isOrContains(node, container) {
    while (node) {
        if (node === container) {
            return true;
        }
        node = node.parentNode;
    }
    return false;
}

function elementContainsSelection(el) {
    let selIn;
    if (window.getSelection) {
        selIn = window.getSelection();
        if (selIn.rangeCount > 0) {
            for (let i = 0; i < selIn.rangeCount; ++i) {
                if (!isOrContains(selIn.getRangeAt(i).commonAncestorContainer, el)) {
                    return false;
                }
            }
            return true;
        }
    } else if ((selIn = document.selection) && selIn.type !== "Control") {
        return isOrContains(selIn.createRange().parentElement(), el);
    }
    return false;
}

function saveContent2User() {
    let serie_ctn = $("#serie_ctn");
    let html_c = serie_ctn.html();
    if (html_c !== null && html_c !== undefined) {
        let serialized = {
            hash: serie_ctn.attr("data-content"),
            content: btoa(unescape(encodeURIComponent(html_c)))
        };
        $.ajax({
            url: "../../updateContent",
            type: "POST",
            data: serialized,
            cache: false
        });
    }
}

$(document).on("click", ".ajax-download", function (e) {
    e.preventDefault();
    let th = $(this);
    let old_tx = th.html();
    th.html(`<i class="fas fa-spinner fa-pulse"></i> Preparando`);
    let ifr = $('<iframe/>', {
        id: "document_downloader_main",
        src: th.attr("href"),
        style: 'display:none;',
        onload: function () {
            window.setTimeout(function(){
                th.html(old_tx);
            },1000);
        }
    });
    $('body').append(ifr);

});

