html2element: (function ($) {
    "use strict";
    $(document).ready(function () {
        var items = mainscript.itemslength;
        $(".king-featured").owlCarousel({
            nav: true,
            margin: 0,
            center: true,
            loop: true,
            autoplay: true,
            items: items,
            responsive: {
                0: { items: 1 },
                600: { items: items },
                1000: { items: items },
            },
            navText: [
                '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
            ],
        });
        $(".king-featured-4, .king-featured-5").owlCarousel({
            nav: true,
            margin: 8,
            center: true,
            loop: true,
            autoplay: false,
            items: 1,
            navText: [
                '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
            ],
        });
        var miniitems = mainscript.miniitemslength;
        $(".king-editorschoice-owl").owlCarousel({
            margin: 15,
            loop: true,
            autoplay: true,
            dots: false,
            items: miniitems,
            responsive: {
                0: { items: 1 },
                600: { items: miniitems },
                1000: { items: miniitems },
            },
        });
        $(".header-search-form").click(function (event) {
            event.stopPropagation();
            $("div.king-search").addClass("active");
        });
        $(document).on("click", function () {
            $("div.king-search").removeClass("active");
        });
        $(".sidebar-ad").stick_in_parent({
            parent: "#primary",
            offset_top: 80,
        });
        $(".sticky-header-03").stick_in_parent({ parent: "#page" });
        $("#searchv2-button").on("click", function (event) {
            event.preventDefault();
            $("#live-search").addClass("active");
            setTimeout(function () {
                $(".live-header-search-field").focus();
            }, 700);
        });
        $("#live-search, #live-search .king-close").on(
            "click keyup",
            function (event) {
                if (
                    event.target == this ||
                    event.target.className == "king-close" ||
                    event.keyCode == 27
                ) {
                    $(this).removeClass("active");
                }
            }
        );
        var mas = mainscript.enablemas;
        if (mas) {
            var container = document.querySelector(
                ".king-grid-07 .site-main-top .king-posts, .king-grid-03 .site-main-top .king-posts, .king-grid-10 .site-main-top .king-posts, .content-story .king-posts"
            );
            var msnry = new Masonry(container, {
                columnWidth: ".grid-sizer",
                itemSelector: ".king-post-item",
                percentPosition: true,
            });
        }
        // var ias = $.ias({
        //     container: "#king-pagination-01",
        //     item: ".king-post-item",
        //     pagination: "#king-pagination-01 .posts-navigation",
        //     next: "#king-pagination-01 .nav-previous a",
        // });
        // if (mas) {
        //     ias.on("render", function (items) {
        //         $(items).css({ opacity: 0 });
        //     });
        //     ias.on("rendered", function (items) {
        //         msnry.appended(items);
        //         kinglazyload();
        //         kingbuckets();
        //     });
        // } else {
        //     ias.on("rendered", function (items) {
        //         kinglazyload();
        //         kingbuckets();
        //         $('[data-toggle="tooltip"]').tooltip();
        //     });
        // }
        // var inumber = mainscript.infinitenumber;
        // var lmoretext = mainscript.lmore;
        // var lmoreftext = mainscript.lmoref;
        // ias.extension(
        //     new IASSpinnerExtension({
        //         html:
        //             '<div class="switch-loader"><span class="loader"></span></div>',
        //     })
        // );
        // ias.extension(
        //     new IASTriggerExtension({ offset: inumber, text: lmoretext })
        // );
        // ias.extension(
        //     new IASNoneLeftExtension({
        //         html:
        //             '<div class="load-nomore"><span>' +
        //             lmoreftext +
        //             "</span></div>",
        //     })
        // );
        $("#modal-url").click(function () {
            $(this).focus();
            $(this).select();
            document.execCommand("copy");
            $(this).next(".copied").show();
        });
        $("#t09-toggle").click(function (e) {
            var temp09 = $("div.header-template-09");
            e.stopPropagation();
            if (temp09.hasClass("active")) {
                temp09.removeClass("active");
                $(this).attr("aria-toggle", "false");
            } else {
                temp09.addClass("active");
                $(this).attr("aria-toggle", "true");
            }
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        function kinglazyload() {
            var lazyItems = [].slice.call(
                document.querySelectorAll("[data-king-img-src]")
            );
            if ("IntersectionObserver" in window) {
                var options = { rootMargin: "300px" };
                var lazyItemObserver = new IntersectionObserver(function (
                    entries
                ) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            var lazyItem = entry.target;
                            var imgSrc = lazyItem.getAttribute(
                                "data-king-img-src"
                            );
                            if (imgSrc) {
                                if (lazyItem.classList.contains("king-lazy")) {
                                    lazyItem.addEventListener(
                                        "load",
                                        function () {
                                            lazyItem.style.height = "";
                                            lazyItem.style.width = "";
                                            lazyItem.classList.add("loaded");
                                            lazyItem.removeAttribute(
                                                "data-king-img-src"
                                            );
                                            lazyItemObserver.unobserve(
                                                lazyItem
                                            );
                                        }
                                    );
                                    lazyItem.src = imgSrc;
                                    var srcset = lazyItem.getAttribute(
                                        "data-king-img-srcset"
                                    );
                                    if (srcset) {
                                        lazyItem.setAttribute("srcset", srcset);
                                        lazyItem.removeAttribute(
                                            "data-king-img-srcset"
                                        );
                                    }
                                    lazyItem.parentNode.classList.add(
                                        "img-loaded"
                                    );
                                } else {
                                    lazyItem.style.backgroundImage =
                                        "url('" + imgSrc + "')";
                                    lazyItem.classList.add("loaded");
                                    lazyItem.removeAttribute(
                                        "data-king-img-src"
                                    );
                                    lazyItemObserver.unobserve(lazyItem);
                                }
                            }
                        }
                    });
                },
                options);
                lazyItems.forEach(function (lazyItem) {
                    lazyItemObserver.observe(lazyItem);
                });
            } else {
                lazyItems.forEach(function (lazyItem) {
                    if (lazyItem.classList.contains("king-lazy")) {
                        lazyItem.style.height = "";
                        lazyItem.style.width = "";
                        lazyItem.src = lazyItem.getAttribute(
                            "data-king-img-src"
                        );
                        var srcset = lazyItem.getAttribute(
                            "data-king-img-srcset"
                        );
                        if (srcset) {
                            lazyItem.setAttribute("srcset", srcset);
                            lazyItem.removeAttribute("data-king-img-srcset");
                        }
                        lazyItem.parentNode.classList.add("img-loaded");
                        lazyItem.classList.add("loaded");
                        lazyItem.removeAttribute("data-king-img-src");
                    } else {
                        lazyItem.style.backgroundImage =
                            "url('" +
                            lazyItem.getAttribute("data-king-img-src") +
                            "')";
                        lazyItem.classList.add("loaded");
                        lazyItem.removeAttribute("data-king-img-src");
                    }
                });
            }
        }
        kinglazyload();
        $(document).on("click", "#ntoggle", function (b) {
            b.preventDefault();
            $.ajax({
                type: "post",
                url: mainscript.ajaxurl,
                data: { action: "king_show_notify" },
                success: function (b) {
                    $("#king-notify-inside").html(b);
                    $("#notifybox").removeClass("notify");
                },
            });
        });
        $(document).on("click", ".king-clean", function (b) {
            b.preventDefault();
            $.ajax({
                type: "post",
                url: mainscript.ajaxurl,
                data: { action: "king_clean_notify" },
                success: function (b) {
                    $("#king-notify-inside").html(b);
                },
            });
        });
        $(document).on("click", "#ftoggle", function (b) {
            b.preventDefault();
            $.ajax({
                type: "post",
                url: mainscript.ajaxurl,
                data: { action: "king_show_flag" },
                success: function (b) {
                    $("#kingflagin").html(b);
                    $("#flagbox").removeClass("notify");
                },
            });
        });
        $(document).on("click", ".follow-button", function () {
            var b = $(this),
                c = b.attr("data-post-id");
            b = b.attr("data-nonce");
            var d = $(".follow-button-" + c);
            var e = d.next("#follow-loader");
            "" !== c &&
                $.ajax({
                    type: "POST",
                    url: mainscript.ajaxurl,
                    data: {
                        action: "king_process_simple_follow",
                        post_id: c,
                        nonce: b,
                    },
                    beforeSend: function () {
                        e.html('&nbsp;<div class="loader">Loading...</div>');
                    },
                    success: function (a) {
                        d.html(a.icon + a.count);
                        "unfollowd" === a.status
                            ? (d.prop("title", mainscript.follow),
                              d.removeClass("followd"))
                            : (d.prop("title", mainscript.unfollow),
                              d.addClass("followd"));
                        e.empty();
                    },
                });
            return !1;
        });
        $("div.tagfollow a").on("click", function (b) {
            b.preventDefault();
            var c = $(this);
            b = c.attr("href");
            $.ajax({
                type: "POST",
                url: mainscript.ajaxurl,
                data: { action: "king_follow_tags", to_follow: b },
                beforeSend: function () {
                    c.next(".tagloader").html('<div class="loader"></div>');
                },
                success: function (a) {
                    "added_like" === a
                        ? c.addClass("followed")
                        : c.removeClass("followed");
                    c.next(".tagloader").empty();
                },
            });
        });
        function kingbuckets() {
            if (typeof $.fn.magnificPopup === "function") {
                $(".bucket-button").magnificPopup({
                    type: "ajax",
                    closeOnBgClick: true,
                    closeBtnInside: false,
                    preloader: true,
                    tLoading: '<div class="loader"></div>',
                    mainClass: "bucket-modal",
                    callbacks: {
                        ajaxContentAdded: function () {
                            kingbucketing();
                        },
                    },
                });
                $(".king-share-link").magnificPopup({
                    type: "ajax",
                    closeOnBgClick: false,
                    closeBtnInside: false,
                    preloader: true,
                    tLoading: '<div class="loader"></div>',
                    removalDelay: 120,
                    mainClass: "share-modal",
                    callbacks: {
                        parseAjax: function (mfpResponse) {
                            mfpResponse.data = mfpResponse.data;
                        },
                    },
                });
            }
        }
        kingbuckets();
        function kingbucketing() {
            $(document).on("click", ".king-collection-add", function (b) {
                b.preventDefault();
                var c = $(this),
                    cid = c.data("collid"),
                    pid = c.data("pid"),
                    tid = c.data("tid");
                $.ajax({
                    type: "POST",
                    url: mainscript.ajaxurl,
                    data: {
                        action: "king_bucket",
                        cid: cid,
                        pid: pid,
                        tid: tid,
                    },
                    beforeSend: function () {
                        c.addClass("effect");
                    },
                    success: function (f) {
                        if ("1" === f) {
                            c.addClass("king-bucketed");
                        } else {
                            c.removeClass("king-bucketed");
                        }
                        setTimeout(function () {
                            c.removeClass("effect");
                        }, 700);
                    },
                });
            });
            $(document).on("submit", "form.create-bucket", function (b) {
                b.preventDefault();
                var c = $(this);
                var title = c.find('input[name="king_ctitle"]').val();
                var pri = c.find('input[name="king_cprv"]:checked').val();
                var desc = c.find('textarea[name="king_cdesc"]').val();
                var nonce = $("#king_ccollecn_nonce").val();
                $.ajax({
                    type: "POST",
                    url: mainscript.ajaxurl,
                    data: {
                        action: "king_create_bucket",
                        title: title,
                        pri: pri,
                        desc: desc,
                        nonce: nonce,
                    },
                    beforeSend: function () {
                        c.addClass("effect");
                    },
                    success: function (f) {
                        if ("1" === f) {
                            var burl = $("#king-burl").val();
                            const instance = $.magnificPopup.instance;
                            instance.open({
                                callbacks: {
                                    beforeAppend() {
                                        instance.waitingForAjax = false;
                                    },
                                    parseAjax(response) {
                                        instance.currTemplate = { ajax: true };
                                        instance.waitingForAjax = true;
                                    },
                                },
                                items: { src: burl, type: "ajax" },
                            });
                            instance.ev.off("mfpBeforeChange.ajax");
                        }
                        setTimeout(function () {
                            c.removeClass("effect");
                        }, 700);
                    },
                });
            });
            $(document).on("click", ".create-bucket-link", function (b) {
                b.preventDefault();
                $(".king-collection-up").hide();
                $(".king-collection-form").addClass("show-form");
            });
        }
        $(".live-header-search-field, .header-search-field").on(
            "keyup",
            function (b) {
                b.preventDefault();
                b = $(this).val();
                var c = { action: "king_live_search", keyword: b };
                3 <= b.length &&
                    $.ajax({
                        type: "POST",
                        url: mainscript.ajaxurl,
                        data: c,
                        beforeSend: function () {
                            $("#king-results").html(
                                '<div class="king-search-results"><div class="loader"></div></div>'
                            );
                        },
                        success: function (b) {
                            $("#king-results").html(b);
                        },
                    });
            }
        );
        function king_vote() {
            $(document).on("click", ".king-vote-icon", function () {
                var button = $(this);
                var ld = button.data("action");
                var div = button.parent();
                var nonce = div.data("nonce");
                var id = div.data("id");
                var count = div.data("number");
                var format = div.data("format");
                $.ajax({
                    type: "POST",
                    url: mainscript.ajaxurl,
                    data: {
                        action: "king_vote_ajax",
                        post_id: id,
                        type: ld,
                        format: format,
                        nonce: nonce,
                    },
                    beforeSend: function () {
                        if (!div.hasClass("voted")) {
                            button.addClass("clicked");
                        }
                    },
                    success: function (a) {
                        if (a.done) {
                            var number = div.find(".king-vote-count");
                            button.addClass("active");
                            if ("voted" === a.status) {
                                div.addClass(a.status);
                                div.removeClass("unvoted");
                                if ("like" === ld) {
                                    number.html(count + 1);
                                    div.data("number", count + 1);
                                } else {
                                    number.html(count - 1);
                                    div.data("number", count - 1);
                                }
                            } else {
                                div.addClass(a.status);
                                div.removeClass("voted");
                                button.removeClass("active");
                                if ("like" === ld) {
                                    number.html(count - 1);
                                    div.data("number", count - 1);
                                } else {
                                    number.html(count + 1);
                                    div.data("number", count + 1);
                                }
                            }
                            button.removeClass("clicked");
                        }
                    },
                });
            });
        }
        king_vote();
    });
})(jQuery);
