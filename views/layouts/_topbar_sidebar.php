<?php

/* @var $this yii\web\View */

$this->registerJs("
function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = \"; expires=\" + date.toGMTString();
    } else {
        expires = \"\";
    }
    document.cookie = encodeURIComponent(name) + \"=\" + encodeURIComponent(value) + expires + \"; path=/\";
}

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + \"=\";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, \"\", -1);
}

// init
$('.open-left').on('click touch', function(){
    if ($('.left.side-menu').is(':visible')) { // we need to close it
        if ($('.report-wrapper').length > 0) $('body').removeClass('report-sidebar');
        $('.left.side-menu').hide();
        if (!$('body').hasClass('sidebar-closed')) $('body').addClass('sidebar-closed');
        createCookie('sidebar-closed', '1', 30);
    } else { // we need to open it
        if ($('.report-wrapper').length > 0) $('body').addClass('report-sidebar');
        $('.left.side-menu').show();
        $('body').removeClass('sidebar-closed');
        eraseCookie('sidebar-closed');
    }
});
");
if (isset($_COOKIE['sidebar-closed'])) {
    $this->params['bodyClass'] = isset($this->params['bodyClass']) ? $this->params['bodyClass'].' sidebar-closed' : 'sidebar-closed';
}
?>
<div class="topbar-left">
    <div class="text-center">
        <a href="/" class="logo">
            <i class="icon-c-logo"></i>
            <?php if ( \Yii::$app->request->isMainDomain() ) { ?>
                <img class="black-logo" src="../../img/social-media-audit-logo.png" />
                <img class="white-logo" src="../../img/social-media-audit-logo-white.png" />
            <?php } ?>
        </a>
    </div>
</div>
<nav class="navbar-custom navbar-with-sidebar">
    <ul class="list-inline float-right mb-0">
        <li class="list-inline-item dropdown notification-list">
            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <span class="mini-stat-icon"><i class="ion-android-contacts"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">

                <!-- item-->
                <a href="/myaccount" class="dropdown-item notify-item">
                    <i class="md md-account-circle"></i> <span>My Account</span>
                </a>

                <!-- item-->
                <a href="/logout" class="dropdown-item notify-item">
                    <i class="md md-settings-power"></i> <span>Logout</span>
                </a>

            </div>
        </li>
    </ul>
    <ul class="list-inline menu-left mb-0">
        <li style="float:left" id="navigation-tour">
            <button class="button-menu-mobile open-left">
                <i class="ti-menu"></i>
            </button>
        </li>
        <?php if ( !Yii::$app->user->identity->isSuspended() ) { ?>
            <li class="hide-phone app-search">
                <form role="search" class="" onsubmit="window.location='/'+$(this).find('input').val().toLowerCase().replace(/^https?:\/\//i,'').replace(/\/$/i, '');return false" >
                    <input id="audit-settings" name="Website[domain]" type="text" placeholder="Run a Quick Audit..." class="form-control">
                    <a href="" onclick="$(this).closest('form').submit();return false"><i class="fa fa-search"></i></a>
                </form>
            </li>
        <?php } ?>
    </ul>
</nav>