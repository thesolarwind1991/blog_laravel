<!DOCTYPE html>
<html lang="ru" class="no-js">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? env('APP_NAME') }}</title>
    <link href="{{ asset('css/media_query.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/owl.theme.default.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/style_1.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <!-- Modernizr JS -->
    <script src="{{ asset('js/modernizr-3.5.0.min.js') }}"></script>
</head>
<body>
<div class="container-fluid fh5co_header_bg">
    <div class="container">
        <div class="row">
            <div class="col-12 fh5co_mediya_center">
                @isset($admin) <i class="far fa-user text-danger mr-2"></i> @endisset
                @isset($user) <i class="far fa-user text-success mr-2"></i> @endisset
                <a href="{{route('index')}}" class="color_fff fh5co_mediya_setting"><i
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
                    <a href="{{ route('auth.logout') }}" class="color_fff fh5co_mediya_setting">Выйти</a>

                @endif
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 fh5co_padding_menu">
                <a href="{{ route('index') }}"><img src="{{ asset('images/logo.png') }}" alt="img" class="fh5co_logo_width"/></a>
            </div>
            <div class="col-12 col-md-9 align-self-center fh5co_mediya_right">
                <!--<div class="text-center d-inline-block">
                    <a class="fh5co_display_table"><div class="fh5co_verticle_middle"><i class="fa fa-search"></i></div></a>
                </div>
                <div class="text-center d-inline-block">
                    <a class="fh5co_display_table"><div class="fh5co_verticle_middle"><i class="fa fa-linkedin"></i></div></a>
                </div>
                <div class="text-center d-inline-block">
                    <a class="fh5co_display_table"><div class="fh5co_verticle_middle"><i class="fa fa-google-plus"></i></div></a>
                </div>
                <div class="text-center d-inline-block">
                    <a href="https://twitter.com/fh5co" target="_blank" class="fh5co_display_table"><div class="fh5co_verticle_middle"><i class="fa fa-twitter"></i></div></a>
                </div>
                <div class="text-center d-inline-block">
                    <a href="https://fb.com/fh5co" target="_blank" class="fh5co_display_table"><div class="fh5co_verticle_middle"><i class="fa fa-facebook"></i></div></a>
                </div>-->
                <div class="d-inline-block text-center dd_position_relative">
                    <form action="{{ route('blog.search') }}" class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" name="query"
                               placeholder="Поиск по блогу" aria-label="Search">
                        <button class="btn btn-outline-info my-2 my-sm-0"
                                type="submit">Искать</button>
                    </form>
                </div>
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
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('index') }}">Главная <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('blog.index') }}">Блоги <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="">Теги <span class="sr-only">(current)</span></a>
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
                    <li class="nav-item ">
                        <a class="nav-link" href="">Контакты <span class="sr-only">(current)</span></a>
                    </li>
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
           <div class="col-md-3 animate-box" data-animate-effect="fadeInRight">
               <div>
                   <div class="fh5co_heading fh5co_heading_border_bottom pt-3 py-2 mb-4">Категории</div>
               </div>
               @include('layout.part.categories');
               @include('layout.part.popular-tags');
               <div>
                   <div class="fh5co_heading fh5co_heading_border_bottom pt-3 py-2 mb-4">Страницы</div>
               </div>
               @include('layout.part.all-pages');
           </div>
       </div>

            <!--<div class="row mx-0">
            <div class="col-md-8 animate-box" data-animate-effect="fadeInLeft">
                <div>
                    <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">News</div>
                </div>
                <div class="row pb-4">
                    <div class="col-md-5">
                        <div class="fh5co_hover_news_img">
                            <div class="fh5co_news_img"><img src="images/nathan-mcbride-229637.jpg" alt=""/></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="col-md-7 animate-box">
                        <a href="single.html" class="fh5co_magna py-2"> Magna aliqua ut enim ad minim veniam quis
                            nostrud quis xercitation ullamco. </a> <a href="#" class="fh5co_mini_time py-3"> Thomson Smith -
                            April 18,2016 </a>
                        <div class="fh5co_consectetur"> Amet consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                        </div>
                    </div>
                </div>
                <div class="row pb-4">
                    <div class="col-md-5">
                        <div class="fh5co_hover_news_img">
                            <div class="fh5co_news_img"><img src="images/ryan-moreno-98837.jpg" alt=""/></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <a href="single.html" class="fh5co_magna py-2"> Magna aliqua ut enim ad minim veniam quis
                            nostrud quis xercitation ullamco. </a> <a href="#" class="fh5co_mini_time py-3"> Thomson Smith -
                            April 18,2016 </a>
                        <div class="fh5co_consectetur"> Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                            commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                            dolore.
                        </div>
                        <ul class="fh5co_gaming_topikk pt-3">
                            <li> Why 2017 Might Just Be the Worst Year Ever for Gaming</li>
                            <li> Ghost Racer Wants to Be the Most Ambitious Car Game</li>
                            <li> New Nintendo Wii Console Goes on Sale in Strategy Reboot</li>
                            <li> You and Your Kids can Enjoy this News Gaming Console</li>
                        </ul>
                    </div>
                </div>
                <div class="row pb-4">
                    <div class="col-md-5">
                        <div class="fh5co_hover_news_img">
                            <div class="fh5co_news_img">
                                <img src="images/photo-1449157291145-7efd050a4d0e-578x362.jpg" alt=""/>
                            </div>
                            <div></div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <a href="single.html" class="fh5co_magna py-2"> Magna aliqua ut enim ad minim veniam quis
                            nostrud quis xercitation ullamco. </a> <a href="#" class="fh5co_mini_time py-3"> Thomson Smith -
                            April 18,2016 </a>
                        <div class="fh5co_consectetur"> Quis nostrud xercitation ullamco laboris nisi aliquip ex ea commodo
                            consequat.
                        </div>
                    </div>
                </div>
                <div class="row pb-4">
                    <div class="col-md-5">
                        <div class="fh5co_hover_news_img">
                            <div class="fh5co_news_img"><img src="images/office-768x512.jpg" alt=""/></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <a href="single.html" class="fh5co_magna py-2"> Magna aliqua ut enim ad minim veniam quis
                            nostrud quis xercitation ullamco. </a> <a href="#" class="fh5co_mini_time py-3"> Thomson Smith -
                            April 18,2016 </a>
                        <div class="fh5co_consectetur"> Amet consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 animate-box" data-animate-effect="fadeInRight">
                <div>
                    <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Tags</div>
                </div>
                <div class="clearfix"></div>
                <div class="fh5co_tags_all">
                    <a href="#" class="fh5co_tagg">Business</a>
                    <a href="#" class="fh5co_tagg">Technology</a>
                    <a href="#" class="fh5co_tagg">Sport</a>
                    <a href="#" class="fh5co_tagg">Art</a>
                    <a href="#" class="fh5co_tagg">Lifestyle</a>
                    <a href="#" class="fh5co_tagg">Three</a>
                    <a href="#" class="fh5co_tagg">Photography</a>
                    <a href="#" class="fh5co_tagg">Lifestyle</a>
                    <a href="#" class="fh5co_tagg">Art</a>
                    <a href="#" class="fh5co_tagg">Education</a>
                    <a href="#" class="fh5co_tagg">Social</a>
                    <a href="#" class="fh5co_tagg">Three</a>
                </div>
                <div>
                    <div class="fh5co_heading fh5co_heading_border_bottom pt-3 py-2 mb-4">Most Popular</div>
                </div>
                <div class="row pb-3">
                    <div class="col-5 align-self-center">
                        <img src="images/download (1).jpg" alt="img" class="fh5co_most_trading"/>
                    </div>
                    <div class="col-7 paddding">
                        <div class="most_fh5co_treding_font"> Magna aliqua ut enim ad minim veniam quis nostrud.</div>
                        <div class="most_fh5co_treding_font_123"> April 18, 2016</div>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-5 align-self-center">
                        <img src="images/allef-vinicius-108153.jpg" alt="img" class="fh5co_most_trading"/>
                    </div>
                    <div class="col-7 paddding">
                        <div class="most_fh5co_treding_font"> Enim ad minim veniam nostrud xercitation ullamco.</div>
                        <div class="most_fh5co_treding_font_123"> April 18, 2016</div>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-5 align-self-center">
                        <img src="images/download (2).jpg" alt="img" class="fh5co_most_trading"/>
                    </div>
                    <div class="col-7 paddding">
                        <div class="most_fh5co_treding_font"> Magna aliqua ut enim ad minim veniam quis nostrud.</div>
                        <div class="most_fh5co_treding_font_123"> April 18, 2016</div>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-5 align-self-center"><img src="images/seth-doyle-133175.jpg" alt="img"
                                                              class="fh5co_most_trading"/></div>
                    <div class="col-7 paddding">
                        <div class="most_fh5co_treding_font"> Magna aliqua ut enim ad minim veniam quis nostrud.</div>
                        <div class="most_fh5co_treding_font_123"> April 18, 2016</div>
                    </div>
                </div>
            </div>
        </div>-->
        <!--<div class="row mx-0">
            <div class="col-12 text-center pb-4 pt-4">
                <a href="#" class="btn_mange_pagging"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp; Previous</a>
                <a href="#" class="btn_pagging">1</a>
                <a href="#" class="btn_pagging">2</a>
                <a href="#" class="btn_pagging">3</a>
                <a href="#" class="btn_pagging">...</a>
                <a href="#" class="btn_mange_pagging">Next <i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp; </a>
            </div>
        </div>-->

    </div>
</div>
<div class="container-fluid pb-4 pt-5">
    <div class="container animate-box">
        <div>
            <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Новинки книги</div>
        </div>
        <div class="owl-carousel owl-theme" id="slider2">
            <div class="item px-2">
                <div class="fh5co_hover_news_img">
                    <div class="fh5co_news_img"><img src="{{ asset('images/39-324x235.jpg') }}" alt=""/></div>
                    <div>
                        <a href="#" class="d-block fh5co_small_post_heading"><span class="">Воспоминание о будущем</span></a>
                        <div class="c_g"><i class="fa fa-clock-o"></i> Окт 16,2017</div>
                    </div>
                </div>
            </div>
            <div class="item px-2">
                <div class="fh5co_hover_news_img">
                    <div class="fh5co_news_img"><img src="{{ asset('images/joe-gardner-75333.jpg') }}" alt=""/></div>
                    <div>
                        <a href="#" class="d-block fh5co_small_post_heading"><span class="">Обитель ангельской пустоты</span></a>
                        <div class="c_g"><i class="fa fa-clock-o"></i> Дек 20,2017</div>
                    </div>
                </div>
            </div>
            <div class="item px-2">
                <div class="fh5co_hover_news_img">
                    <div class="fh5co_news_img"><img src="{{ asset('images/ryan-moreno-98837.jpg') }}" alt=""/></div>
                    <div>
                        <a href="#" class="d-block fh5co_small_post_heading"><span class="">Бессмертный Дали</span></a>
                        <div class="c_g"><i class="fa fa-clock-o"></i> Июн 5,2019</div>
                    </div>
                </div>
            </div>
            <div class="item px-2">
                <div class="fh5co_hover_news_img">
                    <div class="fh5co_news_img"><img src="{{ asset('images/seth-doyle-133175.jpg') }}" alt=""/></div>
                    <div>
                        <a href="#" class="d-block fh5co_small_post_heading"><span class="">Офицер 1812 года</span></a>
                        <div class="c_g"><i class="fa fa-clock-o"></i> Авг 18,2018</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid fh5co_footer_bg pb-3">
    <div class="container animate-box">
        <div class="row">
            <div class="col-12 spdp_right py-5"><img src="{{ asset('images/white_logo.png') }}" alt="img" class="footer_logo"/></div>
            <div class="clearfix"></div>
            <div class="col-12 col-md-4 col-lg-3">
                <div class="footer_main_title py-3"> О нас</div>
                <div class="footer_sub_about pb-3"> Коммерческий проект блоги для программиста, а также литература в жанре
                    фантастики, прозы, сююреализма. Основные материалы для веб-программиста, чтобы успешно выполнять проекты
                    и справляться с поставленными задачами.
                </div>
                <div class="footer_mediya_icon">
                    <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                            <div class="fh5co_verticle_middle"><i class="fa fa-linkedin"></i></div>
                        </a></div>
                    <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                            <div class="fh5co_verticle_middle"><i class="fa fa-google-plus"></i></div>
                        </a></div>
                    <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                            <div class="fh5co_verticle_middle"><i class="fa fa-twitter"></i></div>
                        </a></div>
                    <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                            <div class="fh5co_verticle_middle"><i class="fa fa-facebook"></i></div>
                        </a></div>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-2">
                <div class="footer_main_title py-3"> Категории</div>
                <ul class="footer_menu">
                    <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Веб-программирование</a></li>
                    <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Программирование</a></li>
                    <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Алгоритмы</a></li>
                    <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Backend-технологии</a></li>
                    <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Frontend-технологии</a></li>
                    <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Управление проектами</a></li>
                    <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Техническая литература</a></li>
                    <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Теги</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-5 col-lg-3 position_footer_relative">
                <div class="footer_main_title py-3"> Последние события</div>
                <div class="footer_makes_sub_font"> Дек 31, 2022</div>
                <a href="#" class="footer_post pb-4"> Поздравляем с наступающим новым 2023 годом! </a>
                <div class="footer_makes_sub_font"> Янв 1, 2023</div>
                <a href="#" class="footer_post pb-4"> Новый год наступил! С праздником!</a>
                <div class="footer_makes_sub_font"> Янв 7, 2023</div>
                <a href="#" class="footer_post pb-4"> Со светлым рождеством Христовым! </a>
                <div class="footer_position_absolute"><img src="{{ asset('images/footer_sub_tipik.png') }}" alt="img" class="width_footer_sub_img"/></div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 ">
                <div class="footer_main_title py-3"> Последние фото</div>
                <a href="#" class="footer_img_post_6"><img src="{{ asset('images/allef-vinicius-108153.jpg') }}" alt="img"/></a>
                <a href="#" class="footer_img_post_6"><img src="{{ asset('images/32-450x260.jpg') }}" alt="img"/></a>
                <a href="#" class="footer_img_post_6"><img src="{{ asset('images/download (1).jpg') }}" alt="img"/></a>
                <a href="#" class="footer_img_post_6"><img src="{{ asset('images/science-578x362.jpg') }}" alt="img"/></a>
                <a href="#" class="footer_img_post_6"><img src="{{ asset('images/vil-son-35490.jpg') }}" alt="img"/></a>
                <a href="#" class="footer_img_post_6"><img src="{{ asset('images/zack-minor-15104.jpg') }}" alt="img"/></a>
                <a href="#" class="footer_img_post_6"><img src="{{ asset('images/download.jpg') }}" alt="img"/></a>
                <a href="#" class="footer_img_post_6"><img src="{{ asset('images/download (2).jpg') }}" alt="img"/></a>
                <a href="#" class="footer_img_post_6"><img src="{{ asset('images/ryan-moreno-98837.jpg') }}" alt="img"/></a>
            </div>
        </div>
        <div class="row justify-content-center pt-2 pb-4">
            <div class="col-12 col-md-8 col-lg-7 ">
                <div class="input-group">
                    <span class="input-group-addon fh5co_footer_text_box" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                    <input type="text" class="form-control fh5co_footer_text_box" placeholder="Введите свой E-mail..." aria-describedby="basic-addon1">
                    <a href="#" class="input-group-addon fh5co_footer_subcribe" id="basic-addon12"> <i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Subscribe</a>
                </div>
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

</body>
</html>
