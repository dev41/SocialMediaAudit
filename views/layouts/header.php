<?php
$isSuspended = false;

if (($identity = Yii::$app->user->identity) && $identity->isSuspended()){
    $isSuspended = true;
}

?>
<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">
            <!-- Logo container-->
            <div class="logo">
                <a class="logo">
                    <span></span>
                </a>
                <a href="/">
                    <div class="site_logo"></div>
                    <!-- @todo @merge 03.09.2018 <span>
                        <div class="site_logo"></div>
                    </span> -->
                </a>
            </div>
            <!-- End Logo container-->
            <?php if ( !$isSuspended && empty($this->params['agency']) ){ ?>
                <form onsubmit="window.location='/website/'+$(this).find('input').val().toLowerCase().replace(/^https?:\/\//i,'').replace(/\/$/i, '');return false" role="search"
                      class="m-l-30 navbar-left app-search pull-left top-search-form hidden-xs hidden-sm">
                    <input type="text" name="Website[domain]" placeholder="Audit Website..." class="form-control">
                    <a href="" onclick="$(this).closest('form').submit();return false"><i class="fa fa-search"></i></a>
                </form>

                <form onsubmit="window.location='/'+$(this).find('input').val().toLowerCase().replace(/^https?:\/\//i,'').replace(/\/$/i, '');return false" role="search"
                      class="navbar-left app-mobile-search pull-left top-search-form w-100 hidden">
                    <input type="text" name="Website[domain]" placeholder="Audit Website..." class="form-control w-100">
                    <a href="" onclick="$(this).closest('form').submit();return false"><i class="fa fa-search"></i></a>
                </form>
            <?php } ?>

            <div class="menu-extras">

                <ul class="nav navbar-nav navbar-right pull-right navbar-right-abs">

                    <?php if (Yii::$app->user->isGuest) { ?>
                        <li id="nav-menu-item-3752" class="main_menu menu-item menu-item-type-post_type menu-item-object-page  narrow">
                            <a href="/login" class="">
                                <span class="item_outer">
                                    <span class="item_inner">
                                        <span class="menu_icon_wrapper"><i class="menu_icon blank fa"></i></span>
                                        <span class="item_text">Login</span>
                                    </span>
                                    <span class="plus"></span>
                                </span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <li><button onclick="window.location='/dashboard'" class="btn btn--primary waves-effect waves-light btn-dashboard hidden-xs hidden-sm">Back to Dashboard</button></li>
                        <li class="dropdown user_dropdown">
                            <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
                                <span class="mini-stat-icon bg-white" style="float: right; margin-right: -10px;"><i class="ion-android-contacts text-primary"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/dashboard"><i class="ti-settings m-r-5"></i> Dashboard</a></li>
                                <li><a href="/logout"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php } ?>


                </ul>
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle collapsed" data="closed">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>
        </div>
    </div>

</header>
<!-- End Navigation Bar-->