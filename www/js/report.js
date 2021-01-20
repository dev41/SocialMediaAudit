$(function () {
    // report requests

    if (typeof scoreGrades !== 'undefined') { // start only on report page
        progressInterval = setInterval(progressFunction, 500);
        requestsTotal = 6;
        getChecksResult("/check-html.inc", {'wid':websiteId}, function (results) {

            reInitDetailsButtons();
            //console.log(results);

            if (results.hasFacebook !== false && results.hasFacebook.passed === true) {
                getChecksResult("/check-facebook.inc", {'wid':websiteId,"pid":results.hasFacebook.value}, function (results) {
                    runFacebookGenerators(results);
                });
                getChecksResult("/check-facebook-posts.inc", {'wid':websiteId,"pid":results.hasFacebook.value}, function (results) {
                    runFacebookGenerators(results);
                });
            } else {
                updateProgressBar();
                updateProgressBar();
            }

            if (results.hasInstagram !== false && results.hasInstagram.passed === true) {
                getChecksResult("/check-instagram.inc", {'wid':websiteId,"pid":results.hasInstagram.value}, function (results) {
                    runInstagramGenerators(results);
                });
            } else {
                updateProgressBar();
            }

            if (results.hasTwitter !== false && results.hasTwitter.passed === true) {
                getChecksResult("/check-twitter.inc", {'wid':websiteId,"pid":results.hasTwitter.value}, function (results) {
                    runTwitterGenerators(results);
                });
            } else {
                updateProgressBar();
            }

            if (results.hasYoutube !== false && results.hasYoutube.passed === true) {
                getChecksResult("/check-youtube.inc", {'wid':websiteId,"pid":results.hasYoutube.value}, function (results) {
                    runYoutubeGenerators(results);
                });
            } else {
                updateProgressBar();
            }

        });
    }
});