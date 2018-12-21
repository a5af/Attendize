<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- SEO -->
    <meta name="author" content="Equis Financial">
    <meta name="description" content="Equis Financial | {{$event->title}}">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{asset("assets/equis_page/assets/img/favicon.ico")}}">

    <!-- Page Title -->
    <title> Equis Financial | {{$event->title}}</title>
    <link rel="canonical" href="{{$event->event_url}}"/>

    <!-- Open Graph data -->
    <meta property="og:title" content="{{$event->title}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{$event->event_url}}?utm_source=fb"/>
    @if($event->images->count())
        <meta property="og:image"
              content="{{config('attendize.cdn_url_user_assets').'/'.$event->images->first()['image_path']}}"/>
    @endif
    <meta property="og:description" content="{{Str::words(strip_tags(Markdown::parse($event->description))), 20}}"/>
    <meta property="og:site_name" content="attend.xyb.cloud" />

    <!-- Bootstrap -->
    <link href="{{asset("assets/equis_page/assets/css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{asset("assets/equis_page/assets/css/toaster.css")}}" rel="stylesheet">

    <!-- Custom Google Font : Open Sans & Montserrat -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,600' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <!-- Plugins -->
    <link href="{{asset("assets/equis_page/assets/css/animate.css")}}" rel="stylesheet">
    <link href="{{asset("assets/equis_page/assets/css/slick.css")}}" rel="stylesheet">
    <link href="{{asset("assets/equis_page/assets/css/magnific-popup.css")}}" rel="stylesheet">
    <link href="{{asset("assets/equis_page/assets/css/font-awesome.css")}}" rel="stylesheet">
    <link href="{{asset("assets/equis_page/assets/css/streamline-icons.css")}}" rel="stylesheet">

    <!-- Event Style -->
    <link href="{{asset("assets/equis_page/assets/css/event.css")}}" rel="stylesheet">
    <link href="{{asset("assets/equis_page/assets/css/green.css")}}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="{{ asset('assets/equis_page/lib_pages/js/respond.min.js')}}"></script>
    <![endif]-->

    <script src="{{asset("assets/equis_page/lib_pages/js/modernizr.min.js")}}"></script>

    <!-- Subtle Loading bar -->
    <script src="{{asset("assets/equis_page/lib_pages/js/pace.js")}}"></script>
</head>

<body class="animate-page <%(ShowLoading && ShowLoading == true) ? 'loading' : 'loaded'%>" data-spy="scroll"
      data-target="#navbar" data-offset="100" ng-app="equis-events"
      ng-controller="EventsPHPController">
<!--Preloader div-->
<div class="cssload-container" id="loader-wrapper">
    <div class="cssload-whirlpool"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<toaster-container toaster-options="{'time-out': 3000}"></toaster-container>

<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top reveal-menu js-reveal-menu reveal-menu-hidden">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        <!--<a class="navbar-brand" href="#"><img src="{{asset("assets/equis_page/assets/img/EquisConvention_logo_new.png")}}" alt="Gather" height="50px"> </a>-->
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="#top">Home</a></li>
                <li><a href="#speakers">Speakers</a></li>
                <li><a href="#schedule">Schedule</a></li>
                <!--<li><a href="#gallery">Gallery</a></li>-->
                <li><a href="#pricing">Pricing</a></li>
                <li><a href="#sponsors" class="hidden-sm">Sponsors</a></li>
                <li><a href="#venue" class="hidden-sm">Venue</a></li>
                <li><a href="#contact">Contact</a></li>

                <li><a href="/login">My Account</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
<!-- // End Fixed navbar -->


@yield('content')

<section class="footer-action">

    <div class="container">

        <h4 class="headline-support wow fadeInDown">LET'S GATHER TOGETHER</h4>
        <h2 class="headline wow fadeInDown" data-wow-delay="0.1s">JOIN THE CONFERENCE</h2>

        <div class="footer_bottom-bg">

            <a class="btn btn-success btn-xl wow zoomIn"
               data-wow-delay="0.3s" href="" ng-click="gotoBook();">
                RESERVE MY SEAT</a>
        </div>

    </div>

</section>
<!-- end section.footer-action -->

<footer>

    <div class="social-icons">
        <a href="https://twitter.com/equisfi" class="wow zoomIn">
            <i class="fa fa-twitter"></i> </a>
        <a href="https://www.facebook.com/equisfinancial"
           class="wow zoomIn" data-wow-delay="0.2s"> <i class="fa fa-facebook"></i> </a>
        <a href="https://www.linkedin.com/company/equis-financial"
           class="wow zoomIn" data-wow-delay="0.4s">
            <i class="fa fa-linkedin"></i> </a>
    </div>
    <p>
        <small class="text-muted">Copyright © <?php echo date('Y');?>.
            Equis Financial, Inc. All rights reserved.
        </small>
    </p>

</footer>

<a href="#top" class="back_to_top"><img src="{{asset("assets/equis_page/assets/img/back_to_top.png")}}"
                                        alt="back to top"></a>


<!-- jQuery Library -->
<script src="{{asset("assets/equis_page/lib_pages/js/jquery.js")}}"></script>

<!-- Bootstrap JS -->
<script src="{{asset("assets/equis_page/lib_pages/js/bootstrap.min.js")}}"></script>

<!-- 3rd party Plugins -->
<script src="{{asset("assets/equis_page/lib_pages/js/countdown.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/wow.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/slick.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/magnific-popup.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/validate.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/appear.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/count-to.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/nicescroll.js")}}"></script>

<!-- Google Map -->
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCfvZOgAqbvwp4WL6Fp_SATn0SkXHH9IY8&sensor=false"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/infobox.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/google-map.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/directions.js")}}"></script>

<!-- JS Includes -->
<script src="{{asset("assets/equis_page/lib_pages/js/subscribe.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/contact_form.js")}}"></script>
<!-- Main Script -->
<script src="{{asset("assets/equis_page/lib_pages/js/main.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/angular.js")}}"></script>
<script src="{{asset("assets/equis_page/lib_pages/js/toaster.js")}}"></script>

<!-- EVENTS NG CONTROLLER -->
<script>

    var app = angular.module('equis-events', ['toaster'], function ($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

    app.service('CONSTANTS', function () {
        return {
            FIELDS_MISSING: 'Please fill all required details',
            UNKNOWN_ERROR: 'Unknown error occurred!',
            ACCOUNT_DISABLED: 'Your account is disabled. Please contact Equis Financial',
            TERMS: 'Please accept the Terms and Conditions',


        };
    });

    app.service('anchorSmoothScroll', function ($document, $window) {

      var document = $document[0];
      var window = $window;

      function getCurrentPagePosition(window, document) {
        // Firefox, Chrome, Opera, Safari
        if (window.pageYOffset) return window.pageYOffset;
        // Internet Explorer 6 - standards mode
        if (document.documentElement && document.documentElement.scrollTop)
          return document.documentElement.scrollTop;
        // Internet Explorer 6, 7 and 8
        if (document.body.scrollTop) return document.body.scrollTop;
        return 0;
      }

      function getElementY(document, element) {
        var y = element.offsetTop;
        var node = element;
        while (node.offsetParent && node.offsetParent != document.body) {
          node = node.offsetParent;
          y += node.offsetTop;
        }
        return y;
      }

      this.scrollDown = function (startY, stopY, speed, distance) {

        var timer = 0;

        var step = Math.round(distance / 25);
        var leapY = startY + step;

        for (var i = startY; i < stopY; i += step) {
          setTimeout("window.scrollTo(0, " + leapY + ")", timer * speed);
          leapY += step;
          if (leapY > stopY) leapY = stopY;
          timer++;
        }
      };

      this.scrollUp = function (startY, stopY, speed, distance) {

        var timer = 0;

        var step = Math.round(distance / 25);
        var leapY = startY - step;

        for (var i = startY; i > stopY; i -= step) {
          setTimeout("window.scrollTo(0, " + leapY + ")", timer * speed);
          leapY -= step;
          if (leapY < stopY) leapY = stopY;
          timer++;
        }
      };

      this.scrollToTop = function (stopY) {
        scrollTo(0, stopY);
      };

      this.scrollTo = function (elementId, speed) {
        // This scrolling function
        // is from http://www.itnewb.com/tutorial/Creating-the-Smooth-Scroll-Effect-with-JavaScript

        var element = document.getElementById(elementId);

        if (element) {
          var startY = getCurrentPagePosition(window, document);
          var stopY = getElementY(document, element);

          var distance = stopY > startY ? stopY - startY : startY - stopY;

          if (distance < 100) {
            this.scrollToTop(stopY);

          } else {

            var defaultSpeed = Math.round(distance / 100);
            speed = speed || (defaultSpeed > 20 ? 20 : defaultSpeed);

            if (stopY > startY) {
              this.scrollDown(startY, stopY, speed, distance);
            } else {
              this.scrollUp(startY, stopY, speed, distance);
            }
          }

        }

      };

    });

    app.filter('formatdate', ['$filter', function ($filter) {
        return function (input, format) {
            if (input === null) {
                return "";
            }
            //var format
            //if (attr.format)

            return $filter('date')(new Date(input), format);
        };
    }]);

    app.filter('split', function () {
        return function (input) {
            if (angular.isDefined(input) && input !== null) {
                return input.split(/\n/);
            } else {
                return '';
            }
        };
    });

    app.controller('EventsPHPController', function ($scope, $rootScope, $http, $timeout,
                                                    $filter, toaster, $window, $location, CONSTANTS, anchorSmoothScroll) {
        $scope.paypalmodalvisible = false;
        $scope.registermodalvisible = false;
        $scope.loggedin = false;
        $scope.InstalmentDetails = false;
        //$scope.IsShow = false;
        $scope.userdetails = {
            username: '',
            password: ''
        };

        $scope.SendMessage = function (event_id) {
            if (!$scope.EventMessage.$valid) {
                toaster.pop('warning', '', CONSTANTS.FIELDS_MISSING, 5000);
                return false;
            }

            $http.post('/e/'+event_id+'/contact_organiser', $scope.EventUserSend).then(function (data) {
                if ( data.data.status === 'success') {
                    toaster.pop('success', '', data.data.message, 5000);
                    location.reload();

                }
                else {
                    toaster.pop('warning', '', data.data.message, 5000);

                }
            }, function (status) {
                toaster.pop('error', '', status, 5000);
            })
        };


        $scope.gotoBook = function () {
          var old = $location.hash();
          $location.hash('book');
          anchorSmoothScroll.scrollTo('book');
          $location.hash(old);
        };

    });
</script>
</body>

</html>
