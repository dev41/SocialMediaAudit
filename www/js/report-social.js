$(function () {
    // report requests

    if (typeof scoreGrades !== 'undefined') { // start only on report page
        progressInterval = setInterval(progressFunction, 500);
        switch (socialNetwork) {
            case 'youtube':
                getChecksResult("/check-youtube.inc", {'wid':websiteId,"pid":socialProfile}, function (results) {
                    runYoutubeGenerators(results);
                });
                break;
            case 'twitter':
                getChecksResult("/check-twitter.inc", {'wid':websiteId,"pid":socialProfile}, function (results) {
                    runTwitterGenerators(results);
                });
                break;
            case 'facebook':
                requestsTotal = 2;
                getChecksResult("/check-facebook.inc", {'wid':websiteId,"pid":socialProfile}, function (results) {
                    runFacebookGenerators(results);
                });
                getChecksResult("/check-facebook-posts.inc", {'wid':websiteId,"pid":socialProfile}, function (results) {
                    runFacebookGenerators(results);
                });
                break;
            case 'instagram':
                getChecksResult("/check-instagram.inc", {'wid':websiteId,"pid":socialProfile}, function (results) {
                    runInstagramGenerators(results);
                });
                break;
        }
    }
});