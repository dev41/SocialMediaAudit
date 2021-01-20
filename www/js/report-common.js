if (isPdfReport === undefined) {
    var isPdfReport = false;
}
var overMax = 6;
var isMobile = false; //initiate as false
var csrfToken = $('meta[name="csrf-token"]').attr("content");
var requestsTotal = 1;
var requestsCompleted = 0;
var progressInterval;
var progressPercentsDone = 5;
var currentProgressAction = 'Analyzing Website';
var currentProgressActions = [];
var scores = {};
var RadarChart = {
    labels : [],
    datasets : []
};
var chartIndex = -1;
window.Yii = {
    t: function (text) {
        if (
            window.yiiTranslateSource !== undefined &&
            window.yiiTranslateSource[text] !== undefined
        ) {
            return window.yiiTranslateSource[text];
        }

        return text;
    }
};
var progressActions = {
    '/check-html.inc' : Yii.t('Rendering Website Live in a Browser'),
    '/check-social.inc' : Yii.t('Calling Social Networks'),
    'other' : Yii.t('Evaluating Website'),
};
var progressFunction = function(){
    progressPercentsDone++;
    $('.js-progress-bar').animate({
        width: progressPercentsDone + '%',
    }, 500);
    $('.js-progress-label').html(currentProgressAction + " - " + progressPercentsDone + Yii.t("% Complete"));
    if (progressPercentsDone >= 99) {
        clearInterval(progressInterval);
    }
}

$(function () {
    // device detection
    if(
        /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) ||
        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))
    ) {
        isMobile = true;
    }

    if (isMobile) {
        $('.wrapper').addClass('wrapper-mobile');
    }

    $('body').on('click', '.collapse-task', function() {
        var parent = $(this).parent(".task-list");
        parent.find(".over-max").hide();
        $(this).hide();
        parent.find('.expand-task').show();
    });
    $('body').on('click', '.expand-task', function() {
        var parent = $(this).parent(".task-list");
        parent.find(".over-max").show();
        $(this).hide();
        parent.find('.collapse-task').show();
    });

    $('.navbar-toggle').click(function(e){ //mobile menu
        e.preventDefault();
        if($(this).attr('data') == 'closed'){

            $('#navigation').show('slow');
            $(this).attr('data','opened');
            $('.nav>li.main_menu').show('slow');
            return false;
        }
        if( $(this).attr('data') == 'opened' ){
            $('#navigation').hide('slow');
            $(this).attr('data','closed');
            $('.nav>li.main_menu').hide('slow');
            return false;
        }

    });

    $('.js-progress-label').css('width', $('.progress-horizontal__bar').width());

    $("a.disabled, li.disabled a").click(function(){
        return false;
    });


    // scroll to sections
    // cache selectors
    var $topMenu = $("#navigation"),
        topMenuHeight = $topMenu.outerHeight() + 190,
        $menuItems = $topMenu.find("li"), // All list items
        $scrollItems = $menuItems.map(function(){ // Anchors corresponding to menu items
            var $item = $( '#' + $(this).attr("data-section") );
            if ($item.length) {
                return $item;
            }
        });


    // Bind to scroll
    $(window).scroll(function(){

        var fromTop = $(this).scrollTop() + topMenuHeight; // Get container scroll position
        var cur = $scrollItems.map(function(){ // Get id of current scroll item
            if ($(this).offset().top < fromTop){
                return this;
            }
        });

        // Get the id of the current element
        cur = cur[cur.length - 1];
        var id = cur && cur.length ? cur[0].id : "";

        $menuItems
            .removeClass('active_menu')
            .parent()
            .find('.menu-' + id)
            .addClass('active_menu');
    });

    $("a.scroll").click(function () {
        if($('body').width() < 768){
            $('.nav>li.main_menu').hide('slow');
        }
        // event.preventDefault();
        var elementClick = $(this).attr("href");
        //console.log(elementClick);
        if(elementClick === '#settings'){
            $('.tab-settings').removeClass('hidden');
            $('.block').addClass('hidden');
            var destination = 0;
        } else if(elementClick === '#userlist'){
            $('.tab-userlist').removeClass('hidden');
            $('.tab-settings').addClass('hidden');
            $('.block').addClass('hidden');
            var destination = 0;
        } else if(elementClick === '#competitors'){
            $('.tab-userlist').removeClass('hidden');
            $('.tab-settings').addClass('hidden');
            $('.block').removeClass('hidden');
            var destination = $('#competitors').offset().top;
        } else{
            $('.tab-userlist').addClass('hidden');
            $('.tab-settings').addClass('hidden');
            $('.block').removeClass('hidden');
            var destination = $(elementClick).offset().top;
        }

        if($(window).width() < 992){
            $('.navbar-toggle').removeClass('open');
            $('#navigation').hide('slow');
        }

        $('body,html').animate( {
            scrollTop: destination - 170
        }, 1500 );

        var tabs = $(this).closest('ul.tabs');
        if (tabs.length) {
            tabs.find('> li').removeClass('active');
            $(this).closest('li').addClass('active');
        }

        return false;
    });
    reInitDetailsButtons();

    $('#pdf-btn, #embed-btn').click(function(e){
        if($(this).attr('data') == 'popover'){
            e.preventDefault();
            popover_('#' + $(this).attr('id'));
        }else{
            window.location( $(this).attr('href') );
        }
    });

    // Copy link
    var clipboard = new Clipboard('.btn-shared_link');

    clipboard.on('success', function(e) {
        var error = $('.shared_link_error');
        error.show('slow');
        error.animate({opacity:1},1500);
        error.animate({opacity:0},1500);
        error.hide('slow');
        e.clearSelection();
    });

    $('body').on('click', 'a[href="#"]', function() {
        return false;
    });

    $('body').on('click', '.input-radio > label ~ span', function() {
        var input = $(this).closest('.input-radio').find('> input');
        input.prop('checked', !input.prop('checked'));
    });

    fixedNavTabs();
});

function runFacebookGenerators(results) {
    $('#facebook').removeClass('hidden');
    if (undefined !== results.facebookRecentPostsCount && results.facebookRecentPostsCount !== false) {
        $('.facebook-recent-details').html(results.facebookRecentPostsCount.answer);
    }
    if (undefined !== results.facebookRecentPostsVariety) {
        $('.field-facebookRecentPostsVariety .field-details').append(generateFacebookPostsVariety(results.facebookRecentPostsVariety));
    }
}

function runTwitterGenerators(results) {
    $('#twitter').removeClass('hidden');
    $('.field-twitterRecentBestPosts .field-details').append(generateTwitterBestPosts(results.twitterRecentBestPosts));
    $('.field-twitterRecentPostsVariety .field-details').append(generateTwitterPostsVariety(results.twitterRecentPostsVariety));

    if (results.twitterRecentPostsCount !== false) {
        $('.twitter-recent-details').html(results.twitterRecentPostsCount.answer);
    }
}

function runInstagramGenerators(results) {
    $('#instagram').removeClass('hidden');
    if (results.instagramRecentPostsCount !== false) {
        $('.instagram-recent-details').html(results.instagramRecentPostsCount.answer);
    }
}

function runYoutubeGenerators(results) {
    $('#youtube').removeClass('hidden');
    $('.field-youtubeRecentVideoCompletion .field-details').append(generateYoutubeVideoCompletionList(results.youtubeRecentVideoCompletion));
    $('.field-youtubeRecentBestVideos .field-details').append(generateYoutubeBestVideos(results.youtubeRecentBestVideos));

    if (results.youtubeRecentVideosCount !== false) {
        $('.youtube-recent-details').html(results.youtubeRecentVideosCount.answer);
    }
}

function generateSocialActivity(check) {
    if (check === false) {
        return '';
    }
    return '<div>\
    <div class="activity-item" align="center">\
        <div class="item-image-social facebook-image"></div>\
        <div class="item-content">\
            <p class="value-item">'+check.data["facebook_share"]+'</p>\
            <p class="title-item">Facebook</p>\
        </div>\
    </div>\
    <div class="activity-item" align="center">\
        <div class="item-image-social linkedin-image"></div>\
        <div class="item-content">\
            <p class="value-item">'+check.data["linkedin"]+'</p>\
            <p class="title-item">LinkedIn</p>\
        </div>\
    </div>\
    <div class="activity-item" align="center">\
        <div class="item-image-social pinterest-image"></div>\
        <div class="item-content">\
            <p class="value-item">'+check.data["pinterest_share"]+'</p>\
            <p class="title-item">Pinterest</p>\
        </div>\
    </div>\
    <div class="activity-item" align="center">\
        <div class="item-image-social stumbleupon-image"></div>\
        <div class="item-content">\
            <p class="value-item">'+check.data["stumbledupon"]+'</p>\
            <p class="title-item">Stumbleupon</p>\
        </div>\
    </div>\
    </div>';
}

function generateFacebookActivity(check) {
    if (check === false) {
        return '';
    }
    var html = '';
    if (check.data !== false) {
        html += '<br><br>\
            <div class="activity-item" align="center">\
                <div class="item-image-social facebook-image"></div>\
                <div class="item-content">\
                    <p class="value-item">'+check.data.likes+'</p>\
                    <p class="title-item">'+Yii.t("Page Likes")+'</p>\
                </div>\
            </div>\
            <div class="activity-item" align="center">\
                <div class="item-image-social facebook-image"></div>\
                <div class="item-content">\
                    <p class="value-item">'+check.data.talking+'</p>\
                    <p class="title-item">'+Yii.t("Talking About")+'</p>\
                </div>\
            </div>\
            ';
    }
    return html;
}

function generateFollowersActivity(check, imageClass) {
    if (check === false) {
        return '';
    }
    var html = '';
    if (check.data !== false) {
        html += '<br><br>\
            <div class="activity-item" align="center">\
                <div class="item-image-social '+imageClass+'-image"></div>\
                <div class="item-content">\
                    <p class="value-item">'+check.data.followers+'</p>\
                    <p class="title-item">'+Yii.t("Followers")+'</p>\
                </div>\
            </div>\
            ';
    }
    return html;
}

function generateYoutubeActivity(check) {
    if (check === false) {
        return '';
    }
    var html = '';
    if (check.data !== false) {
        html += '<br><br>\
            <div class="activity-item" align="center">\
                    <div class="item-image-social youtube-image"></div>\
                    <div class="item-content">\
                        <p class="value-item">'+check.data.subscribers+'</p>\
                        <p class="title-item">'+Yii.t("Followers")+'</p>\
                    </div>\
                </div>\
                <div class="activity-item" align="center">\
                    <div class="item-image-social youtube-image"></div>\
                    <div class="item-content">\
                        <p class="value-item">'+check.data.views+'</p>\
                        <p class="title-item">'+Yii.t("View Count")+'</p>\
                    </div>\
            </div>\
            ';
    }
    return html;
}

function generateYoutubeVideoCompletionList(check) {
    if (check === false || check.data.length == 0) {
        return '';
    }
    var html = '';
    html += '<div class="table-responsive"><table class="table table-striped"><tr>' +
        '<th width="50px">#</th>' +
        '<th>'+Yii.t("URL")+'</th>' +
        '<th>'+Yii.t("Title")+'</th>' +
        '<th>'+Yii.t("Description")+'</th>' +
        '<th>'+Yii.t("Tags")+'</th>' +
        '<th>'+Yii.t("Thumbnails")+'</th>' +
        '</tr>';

    for (i = 0; i < check.data.length; i++) {
        var video = check.data[i];
        html += '<tr>' +
            '<td width="50px">'+(parseInt(i) + 1)+'</td>' +
            '<td><a target="_blank" href="https://www.youtube.com/watch?v='+video.id+'">'+(video.snippet.title.length === 0? Yii.t("No Title") : video.snippet.title)+'</a></td>' +
            '<td>'+(video.snippet.title.length === 0? '<i class="md md-close text-danger"></i>':'<i class="md md-check text-success"></i>')+'</td>' +
            '<td>'+(video.snippet.description.length === 0? '<i class="md md-close text-danger"></i>':'<i class="md md-check text-success"></i>')+'</td>' +
            '<td>'+(video.snippet.tags.length === 0? '<i class="md md-close text-danger"></i>':'<i class="md md-check text-success"></i>')+'</td>' +
            '<td>'+(video.snippet.thumbnails.length === 0? '<i class="md md-close text-danger"></i>':'<i class="md md-check text-success"></i>')+'</td>' +
            '</tr>';
    }
    html += '</table></div>';
    return wrapInButton(html);
}

function generateYoutubeBestVideos(check) {
    if (check === false || check.data.length == 0) {
        return '';
    }
    var html = '';
    for (i = 0; i < check.data.length; i++) {
        var video = check.data[i];
        html += '<div class="col-xs-12 col-sm-6 col-md-4">' +
            '<div class="card card-2 text-center">' +
                '<div class="card__top">' +
                    '<a target="_blank" href="https://www.youtube.com/watch?v='+video.id+'">' +
                        '<img alt="" src="'+video.snippet.thumbnails.medium.url+'"/>' +
                    '</a>' +
                '</div>' +
                '<div class="card__body">' +
                    '<h4>'+video.snippet.title+'</h4>' +
                '</div>' +
                '<div class="card__bottom text-center">' +
                    '<div class="card_youtube">' +
                        '<span class="h6">'+video.statistics.viewCount+'</span>' +
                        '<i class="fa fa-eye"></i>' +
                    '</div>' +
                    '<div class="card_youtube">' +
                        '<span class="h6">'+video.statistics.likeCount+'</span>' +
                        '<i class="fa fa-thumbs-up"></i>' +
                    '</div>' +
                    '<div class="card_youtube">' +
                        '<span class="h6">'+video.statistics.dislikeCount+'</span>' +
                        '<i class="fa fa-thumbs-down"></i>' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '</div>';
    }
    return html;
}

function generateTwitterBestPosts(check) {
    if (check === false || check.data.length == 0) {
        return '';
    }
    var html = '';
    var tweetUrl;
    var tweet;
    var tweetDate;
    for (i = 0; i < check.data.length; i++) {
        tweet = check.data[i];
        tweetUrl = null;
        if (undefined !== tweet.entities.media) {
            tweetUrl = tweet.entities.media[0].url;
        } else if (tweet.entities.urls.length > 0) {
            tweetUrl = tweet.entities.urls[0].url;
        }
        tweetDate = new Date(tweet.created_at);
        html += '<div class="col-xs-12 col-sm-6 col-md-4">' +
            '<div class="card card-1 boxed boxed--sm boxed--border">' +
                '<div class="card__top">' +
                    '<div class="card__avatar">' +
                        '<img alt="" src="'+tweet.user.profile_image_url+'" />' +
                        '<span><strong>'+tweet.user.name+'</strong></span>' +
                    '</div>' +
                    '<div class="card__meta">' +
                        tweetDate.toLocaleDateString() +
                        '<i class="icon icon--sm socicon socicon-twitter icon"></i>' +
                    '</div>' +
                '</div>' +
                '<div class="card__body">';
        if (null !== tweetUrl) {
            html += '<a target="_blank" href="'+tweetUrl+'">' +
                    '<h4>'+tweet.full_text+'</h4>' +
                '</a>'
        } else {
            html += '<h4>'+tweet.full_text+'</h4>';
        }
        html += '</div>' +
                '<div class="card__bottom">' +
                    '<ul class="list-inline">';
        if (tweet.favorite_count > 0) {
            html += '<li class="list-inline-item"><div class="card__action">' +
                        '<i class="fa fa-heart"></i> '+ tweet.favorite_count +
                    '</div></li>';
        }
        html += '<li class="list-inline-item"><div class="card__action">' +
                            '<i class="fa fa-retweet"></i> '+ tweet.retweet_count +
                        '</div></li>' +
                    '</ul>' +
                '</div>' +
            '</div>' +
            '</div>';
    }
    return html;
}

function generateTwitterPostsVariety(check) {
    // re-use
    return generateFacebookPostsVariety(check);
}

function generateFacebookPostsVariety(check) {
    if (check === false) {
        return '';
    }
    var percent;
    var html;

    if (check.data.total === 0) return html;
    percent = Math.round(100*check.data.with_text/check.data.total);
    html = '<div class="progress-horizontal">\n' +
        '  <div class="progress-horizontal__bar" data-value="'+percent+'">\n' +
        '      <div class="progress-horizontal__progress" style="width: '+percent+'%;"></div>\n' +
        '  </div><span class="progress-horizontal__label h5">With text: '+percent+'%</span>\n' +
        '</div>';
    percent = Math.round(100*check.data.with_link/check.data.total);
    html += '<div class="progress-horizontal">\n' +
        '  <div class="progress-horizontal__bar" data-value="'+percent+'">\n' +
        '      <div class="progress-horizontal__progress" style="width: '+percent+'%;"></div>\n' +
        '  </div><span class="progress-horizontal__label h5">With link: '+percent+'%</span>\n' +
        '</div>';
    percent = Math.round(100*check.data.with_image/check.data.total);
    html += '<div class="progress-horizontal">\n' +
        '  <div class="progress-horizontal__bar" data-value="'+percent+'">\n' +
        '      <div class="progress-horizontal__progress" style="width: '+percent+'%;"></div>\n' +
        '  </div><span class="progress-horizontal__label h5">With image: '+percent+'%</span>\n' +
        '</div>';
    percent = Math.round(100*check.data.with_video/check.data.total);
    html += '<div class="progress-horizontal">\n' +
        '  <div class="progress-horizontal__bar" data-value="'+percent+'">\n' +
        '      <div class="progress-horizontal__progress" style="width: '+percent+'%;"></div>\n' +
        '  </div><span class="progress-horizontal__label h5">With video: '+percent+'%</span>\n' +
        '</div>';
    return html;
}

function updatePercentageInChart(section, chart) {
    if (!scores[section]) {
        return;
    }

    var percentage = Math.round(100 * scores[section].score / scores[section].max);
    percentage = (percentage > 100) ? 100 : percentage;

    var charts = $(chart);

    charts.each(function () {
        var c = $(this);

        if (isPdfReport) {
            c.data('easyPieChart').options.animate.duration = 1;
        }

        c.data('easyPieChart').update(percentage);
        c.find('.radial__label').html(percentage + '%');
        c.attr('data-value', percentage);
    });

    var messages = scoreMessage(section, percentage);
    $('.'+section+'-score-message').text(messages.title);
    if (messages.description !== undefined) {
        $('.'+section+'-score-description').text(messages.description);
    }
}

function getChecksResult(checkUrl, postData, callback) {
    if (undefined === progressActions[checkUrl]) currentProgressAction = progressActions['other'];
    else currentProgressAction = progressActions[checkUrl];
    currentProgressActions[checkUrl] = currentProgressAction;
    $.post(checkUrl, postData, function (response) {
        delete currentProgressActions[checkUrl];
        currentProgressAction = currentProgressActions[Object.keys(currentProgressActions)[0]];
        // default behaviour
        updateProgressBar();
        // do nothing on fail and skip user's callback
        if (response.success !== true) {
            // other HTML related checks
            if (checkUrl == "/check-html.inc") {
                requestsCompleted = requestsTotal - 1;
                updateProgressBar();
            }

            if ( response.message ){

                $('.js-ajax-alert')
                    .removeClass('hidden')
                    .find('.alert__body')
                    .append(response.message);
                $(".js-progress-container").hide();
            }
            return false;
        }

        var recommendationsCount = 0;

        // parse each check
        $.each(response.results, function (i, check) {
            // skip empty check
            if (check === false || check.passed === undefined) {
                return;
            }

            if (check.recommendation) {
                recommendationsCount++;
            }

            var icon = 'bg-icon-inverse';
            if (check.passed === true) {
                icon = 'bg-icon-success';
            } else if (check.passed === false) {
                icon = 'bg-icon-danger';
            }

            $(".field-"+check.name+" .answer")
                .html(check.answer)
                .closest('.js-social-card-container')
                .fadeIn()
                .closest('.container')
                .show()
                .find('.radial')
                .closest('.js-social-card-container')
                .show()
            ;

            // subsection
            $(".field-"+check.name).closest('.panel-inverse').show();
            $(".field-"+check.name+" .bg-icon").addClass(icon);
            displayRecommendation(check);
            if (typeof scoreGrades !== 'undefined') {
                updateScore(check.section, check);
                updateScore('website', check);
                updateScore('social', check);
            }
        });

        $('#recommendation_count').html(recommendationsCount);

        updatePercentageInChart('website', '.js-website-result-chart');
        updatePercentageInChart('facebook', '.js-facebook-result-chart');
        updatePercentageInChart('twitter', '.js-twitter-result-chart');
        updatePercentageInChart('instagram', '.js-instagram-result-chart');
        updatePercentageInChart('youtube', '.js-youtube-result-chart');
        updatePercentageInChart('linkedIn', '.js-linkedin-result-chart');

        // user's functions
        if (callback !== undefined) {
            callback(response.results);
        }
    }).fail(function(response) {
        // update progress and do nothing
        updateProgressBar();
        // other HTML related checks
        if (checkUrl == "/check-html.inc") {
            updateProgressBar();
            updateProgressBar();
            updateProgressBar();
        }
        if ( response.responseJSON.message ){
            $('.js-ajax-alert')
                .removeClass('hidden')
                .find('.alert__body')
                .append(response.responseJSON.message);
            $(".js-progress-container, #results, #recommendation, .tabs").hide();
        }
        return false;
    });
}

function updateProgressBar() {
    requestsCompleted++;
    progress = Math.round(95 * (requestsCompleted / requestsTotal) + 5);
    if (progress > progressPercentsDone) progressPercentsDone = progress;
    progressPercentsDone = Math.min(progressPercentsDone, 99);
    if (currentProgressAction === undefined) currentProgressAction = Yii.t('Finalizing Results');

    if (requestsCompleted == requestsTotal) {
        $('.js-progress-bar').css('width', '100%');
        $('.js-progress-label').html(Yii.t('Finalizing Results') + " - 100" + Yii.t("% Complete"));
        setTimeout(function () {
            $('.js-progress-container').animate({
                opacity: '0'
            }, 'slow');
        }, 2000);
    }
}

function displayRecommendation(check) {

    if (check.recommendation === null) {
        return false;
    }

    var container = $('.js-recommendation-container');
    var item = $('.js-recommendation-template').html();

    item = item.replace(/\{title\}/g, check.name).replace(/\{content\}/g, check.recommendation);
    container.append($(item));
}

function getSectionName(section) {
    var sections = {
        'seo' : Yii.t("SEO"),
        'performance' : Yii.t("Performance"),
        'ui' : Yii.t("Mobile & UI"),
        'social' : Yii.t("Social"),
        'security' : Yii.t("Security")
    };
    if (section in sections){
        return sections[section];
    } else {
        return Yii.t("Other Improvements");
    }
}

function updateScore(section, check) {
    $('.'+section+'-hidden').show();
    // skip unscorable checks (with maxScore = 0)
    if (check.maxScore === 0 || check.maxScore === undefined) {
        return false;
    }

    if (scores[section] === undefined) {

        scores[section] = {
            'score':0,
            'max':0
        };

    }
    scores[section].max += check.maxScore;
    if (check.passed) {
        scores[section].score += check.score;
    }
}

function calculateGrade(percentage) {
    var grade = 'F-';
    for (var minScore in scoreGrades) {
        if (percentage >= minScore) {
            grade = scoreGrades[minScore];
        }
    }
    return grade;
}

function scoreMessage(section, score) {
    var minScores = Object.keys(scoreMessages[section]).sort().reverse();
    for (var i in minScores) {
        if (score >= minScores[i]){
            return scoreMessages[section][minScores[i]];
        }
    }
}

function showDetails(block){

	$('.btn-show-'+block).hide('slow');
	$('.'+block).show('slow');
	$('.btn-hide-'+block).show('slow');
}

function hideDetails(block){

	$('.'+block).hide('slow');
	$('.btn-hide-'+block).hide('slow');
	$('.btn-show-'+block).show('slow');
}

function showMore(block){

	$('.btn-show-'+block).hide('slow');
	$('.'+block).show('slow');
	$('.btn-hide-'+block).show('slow');
}

function hideMore(block){

	$('.'+block).hide('slow');
	$('.btn-hide-'+block).hide('slow');
	$('.btn-show-'+block).show('slow');
	var destination = $('#'+block).offset().top;
	$('body,html').animate({
        scrollTop: destination + 50
    }, 1500);
}

function popover_(element){

	var visibility 			= $(element).attr('data-visibility');
	var pdfbtn_width 		= $(element).outerWidth();
	var pdfbtn_height 		= $(element).outerHeight();
	var position 			= $(element).offset();
	var pdfbtn_left   		= position.left;
	var pdfbtn_top  		= position.top;

	if(visibility == 'hidden'){
		if(element == '#embed-btn'){
			pdfbtn_left = pdfbtn_left + 54;
		}

		$('#popover329171').css({
            'left':pdfbtn_left - (pdfbtn_width/2),
            'top': pdfbtn_top + pdfbtn_height
        }).show();

		$(element).attr('data-visibility','visibile');
	} else {
		$('#popover329171').hide();
		$(element).attr('data-visibility','hidden');
	}

}

function hexToRgb(hex) {
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
    });
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? [
        parseInt(result[1], 16),
        parseInt(result[2], 16),
        parseInt(result[3], 16)
    ] : null;
}

function drawOverviewChart() {
    if (scores.length === 0) {
        return;
    }

    RadarChart.labels = [];
    RadarChart.datasets = [];
    var rgb = overviewChartColors[0]+", "+overviewChartColors[1]+", "+overviewChartColors[2];
    var values = [];
    var sectionName;
    var sections = {
        'seo' : Yii.t("SEO"),
        'performance' : Yii.t("Performance"),
        'ui' : Yii.t("Mobile & UI"),
        'social' : Yii.t("Social"),
        'security' : Yii.t("Security")
    };
    for (var i in scores) {

        if ( !(i in sections) ) {
            continue;
        }
        sectionName = getSectionName(i);
        RadarChart.labels.push(sectionName);
        values.push(Math.floor(100*scores[i].score/scores[i].max));
    }
    if (values.length < 3) {
        $("#radar").attr('height', 0);
        return;
    } else {
        $("#radar").attr('height', 240);
    }

    RadarChart.datasets.push({
        fillColor : "rgba("+rgb+", 0.5)",
        strokeColor : "rgba("+rgb+", 0.8)",
        pointColor : "rgba("+rgb+", 1)",
        pointStrokeColor : "#fff",
        data : values
    });

    $.ChartJs.respChart($("#radar"), 'Radar', RadarChart, chartIndex);
    chartIndex ++;
}

function reInitDetailsButtons() {
    $('body').off('click','.js-collapse-in');
    $('body').off('click','.js-collapse-out');

    $('body').on('click','.js-collapse-in',function(){
        var $expander  = $(this);
        var $container = $expander.closest('.js-collapse-parent');
        $expander.slideUp();
        $container.find('.js-collapse-target').slideDown(500,function(){
            //
        });
    });
    $('body').on('click','.js-collapse-out',function(){
        var $collapser = $(this);
        var $container = $collapser.closest('.js-collapse-parent');
        var $expander  = $container.find('.js-collapse-in');
        $container.find('.js-collapse-target').slideUp(500,function(){
            $expander.slideDown();
        });
        var top = $container.find('.js-collapse-target').offset().top;
        var v_top = $(document).scrollTop();

        var v_bottom = $(document).scrollTop()+$(window).height();
        if( !(top >= v_top && top <= v_bottom) ){
            $("html, body").stop().animate({
                scrollTop: top - ($(window).height()/2)
            }, 500);
        }
    });
}

function reInitRecommendationButtons() {
    $(".recommendations-filter-category").off("click", ".filter-button");
    $(".recommendations-filter-category").on("click", ".filter-button", function () {
        setTimeout(function () {
            var activeCats = {};
            $(".recommendations-filter-category .filter-button.active").each(function() {
                activeCats[$(this).data("category")] = true;
            });
            if (Object.keys(activeCats).length == 0) {
                $("#recommendations > div.recommendation-item").removeClass("row-hidden").fadeIn();
            } else {
                $("#recommendations > div.recommendation-item").each(function() {
                    if ($(this).data("category") in activeCats) {
                        $(this).removeClass("row-hidden").fadeIn();
                    } else {
                        $(this).fadeOut().addClass("row-hidden");
                    }
                });
            }
        }, 100);
    });
}

function wrapInButton(html) {
    if (html == '') return '';
    return '<div class="js-collapse-parent">\n' +
'                                            <a class="btn btn--primary js-collapse-in">'+Yii.t("Show details")+'</a>\n' +
'                                            <div class="js-collapse-target collapse">\n' +
'                                                <div class="answer headers field-value-table clearfix">' + html + '</div>\n' +
'                                                <a class="btn btn-warning js-collapse-out">'+Yii.t("Hide details")+'</a>\n' +
'                                            </div>\n' +
'                                        </div>';
}

/**
 *
 * @param replacePairs
 * @returns {string}
 */
String.prototype.strtr = function (replacePairs) {
    "use strict";
    var str = this.toString(), key, re;
    for (key in replacePairs) {
        if (replacePairs.hasOwnProperty(key)) {
            re = new RegExp(key, "g");
            str = str.replace(re, replacePairs[key]);
        }
    }
    return str;
};

function fixedNavTabs(e) {
    var navTabs = $('.js-navigation-tabs'),
        body = $(document.body),
        offset = navTabs.offset();

    if (!navTabs.length) {
        return;
    }

    $(window).scroll(function(e) {
        if (offset.top - window.scrollY < 20) {
            body.addClass('navigation-tabs-fixed');
        } else {
            body.removeClass('navigation-tabs-fixed');
        }
    });

}