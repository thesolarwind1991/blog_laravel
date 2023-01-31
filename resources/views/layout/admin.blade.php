<!DOCTYPE html>
<html lang="ru" class="no-js">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? 'Панель управления администратора' }}</title>
    <link href="{{ asset('css/media_query.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/owl.theme.default.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/style_1.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Modernizr JS -->
    <script src="{{ asset('js/modernizr-3.5.0.min.js') }}"></script>
</head>
<body>
<div class="container-fluid fh5co_header_bg">
    <div class="container">
        <div class="row">
            <div class="col-12 fh5co_mediya_center"><a href="{{route('index')}}" class="color_fff fh5co_mediya_setting"><i
                        class="fa fa-clock-o"></i>@currentdate</a>
                @guest
                    <div class="d-inline-block fh5co_trading_posotion_relative">
                        <a href="{{ route('auth.login') }}" class="treding_btn">Вход</a>
                        <div class="fh5co_treding_position_absolute"></div>
                    </div>
                    <a href="{{ route('auth.register') }}" class="color_fff fh5co_mediya_setting">Регистрация</a>
                @else
                    <div class="d-inline-block fh5co_trading_posotion_relative">
                        <a href="{{ route('user.index') }}" class="treding_btn">Личный кабинет</a>
                        <div class="fh5co_treding_position_absolute"></div>
                    </div>
                    <a href="{{ route('auth.logout') }}" class="color_fff fh5co_mediya_setting">Выйти |</a>
                @endif
                <a href="{{ route('index') }}" class="color_fff fh5co_mediya_setting">Сайт |</a>
                <a href="{{ route('admin.index') }}"class="color_fff fh5co_mediya_setting">Админка |</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 fh5co_padding_menu">
                <a href="{{ route('admin.index') }}"><img src="{{ asset('images/logo.png') }}" alt="img" class="fh5co_logo_width"/></a>
            </div>
            <div class="col-12 col-md-9 align-self-center fh5co_mediya_right">
                <div class="d-inline-block text-center dd_position_relative ">
                    <select class="form-control fh5co_text_select_option">
                        <option>Русский </option>
                        <option>English </option>
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid bg-faded fh5co_padd_mediya padding_786">
    <div class="container padding_786">
        <nav class="navbar navbar-toggleable-md navbar-light ">
            <button class="navbar-toggler navbar-toggler-right mt-3" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation"><span class="fa fa-bars"></span></button>
            <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}" alt="img" class="mobile_logo_width"/></a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">Контент <span class="sr-only">(current)</span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink_1">
                            @perm('manage-posts')
                                <a class="dropdown-item" href="{{ route('admin.post.index') }}">Посты</a>
                            @endperm
                            @perm('manage-comments')
                                <a class="dropdown-item" href="{{ route('admin.comment.index') }}">Комментарии</a>
                            @endperm
                            @perm('manage-categories')
                                <a class="dropdown-item" href="{{ route('admin.category.index') }}">Категории</a>
                            @endperm
                            @perm('manage-tags')
                            <a class="dropdown-item" href="{{ route('admin.tag.index') }}">Теги</a>
                            @endperm

                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton3" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">Пользователи<span class="sr-only">(current)</span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink_1">
                            @perm('manage-users')
                                <a class="dropdown-item" href="{{ route('admin.user.index') }}">Пользователи</a>
                            @endperm

                            <a class="dropdown-item" href="{{ route('admin.role.index') }}">Роли</a>
                        </div>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('admin.page.index') }}">Страницы <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="">Корзина <span class="sr-only">(current)</span></a>
                    </li>

                    <!--<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">Авторы <span class="sr-only">(current)</span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink_1">
                            <a class="dropdown-item" href="#">Action in</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton3" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">Community<span class="sr-only">(current)</span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink_1">
                            <a class="dropdown-item" href="#">Action in</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>-->

                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="container-fluid pb-4 pt-4 paddding">
    <div class="container paddding">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible mt-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ $message }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible mt-4" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row mx-0">
            <div class="col-md-8 animate-box" data-animate-effect="fadeInLeft">
                @yield('content')
            </div>
        </div>

    </div>
</div>

<div class="container-fluid fh5co_footer_right_reserved">
    <div class="container">
        <div class="row  ">
            <div class="col-12 col-md-6 py-4 Reserved"> © Copyright 2023, Все права защищены. </div>
            <div class="col-12 col-md-6 spdp_right py-4">
                <a href="" class="footer_last_part_menu">Главная</a>
                <a href="" class="footer_last_part_menu">Блоги</a>
                <a href="" class="footer_last_part_menu">Теги</a>
                <a href="" class="footer_last_part_menu">Контакты</a></div>
        </div>
    </div>
</div>

<div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<!--<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
        crossorigin="anonymous"></script>
<!-- Waypoints -->
<script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
<!-- Main -->
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
</script>
<script type="text/javascript">
    CKEDITOR.replace('content', {
        filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
</body>
</html>
