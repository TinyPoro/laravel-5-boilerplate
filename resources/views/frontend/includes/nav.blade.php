<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 ce">
    @guest
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <a href="{{ route('frontend.index') }}" class="navbar-brand">{{ app_name() }}</a>

                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('labels.general.toggle_navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                @if (config('locale.status') && count(config('locale.languages')) > 1)
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownLanguageLink" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">{{ __('menus.language-picker.language') }} ({{ strtoupper(app()->getLocale()) }})</a>

                        @include('includes.partials.lang')
                    </div>
                @endif

                <div class="nav-item"><a href="{{route('frontend.auth.login')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.login')) }}">{{ __('navs.frontend.login') }}</a></div>

                @if (config('access.registration'))
                    <div class="nav-item"><a href="{{route('frontend.auth.register')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.register')) }}">{{ __('navs.frontend.register') }}</a></div>
                @endif
                <div class="nav-item"><a href="{{route('frontend.contact')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.contact')) }}">{{ __('navs.frontend.contact') }}</a></div>
            </ul>
        </div>
    @else
        <div class="headernav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 search hidden-xs hidden-sm col-md-3">
                        <div class="wrap">
                            <form action="/forum" method="get" class="form">
                                <div class="pull-left txt"><input type="text" name="category" class="form-control" placeholder="Tìm theo chủ đề"></div>
                                <div class="pull-right"><button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button></div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-5"></div>

                    <div class="col-lg-4 col-xs-12 col-sm-5 col-md-4 avt pull-right">
                        <div class="stnt pull-left">
                            <form action="create_news" method="get" class="form">
                                <button class="btn btn-primary">Tạo tin mới</button>
                            </form>
                        </div>
                        <div class="env pull-left"><i class="fa fa-envelope"></i></div>

                        <div class="avatar pull-left dropdown">
                            <a data-toggle="dropdown" href="#"><img src="{{url('img/avatar.jpg')}}" alt=""></a> <b class="caret"></b>
                            <div class="status green">&nbsp;</div>
                            <ul class="dropdown-menu" role="menu">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('frontend.user.account') }}">My Profile</a></li>
                                @can('view backend')
                                    <li><a href="{{ route('admin.dashboard') }}" class="dropdown-item">{{ __('navs.frontend.user.administration') }}</a></li>
                                @endcan
                                <li role="presentation"><a role="menuitem" tabindex="-2" href="#">Inbox</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-3" href="{{ route('frontend.auth.logout') }}">Log Out</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-4" href="04_new_account.html">Create account</a></li>
                            </ul>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    @endguest
</nav>
