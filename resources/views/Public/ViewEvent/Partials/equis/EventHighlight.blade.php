<header id="top" class="header-video-module">
    <div class="video-container">
        <div class="header">
            <div class="container">

                <div class="header_top-bg"><!--
                    <div class="logo">
                        <a href="#"><img src="{{asset("assets/equis_page/assets/img/EquisConvention_logo_new.png")}}" alt="event-logo" width="250px" style="margin-top:20px;"></a>
                    </div>-->
                </div>

                <h3 class="headline-support wow fadeInDown " style="color: white;">Join Us For</h3>
                <h1 class="headline wow fadeInDown" style="color: white;" data-wow-delay="0.1s">
                    {{$event->title}}
                </h1>

                <div class="when_where wow fadeIn" data-wow-delay="0.4s">
                    <p class="event_when">
                        {{ $event->start_date->format('D d M H:i A') }} -
                        @if($event->start_date->diffInHours($event->end_date) <= 12)
                            {{ $event->end_date->format('H:i A') }}
                        @else
                            {{ $event->end_date->format('D d M H:i A') }}
                        @endif
                    </p>
                    <p class="event_where">{{$event->venue_name}}</p>
                </div>

                <div class="header_bottom-bg" style="position: static;">
                <!--<img src={{asset("assets/equis_page/assets/img/event_sold_out.png")}}" style="height: 80px;z-index: 1;margin-left: 80px;margin-top: -7px;position: absolute;">-->
                    <a class="btn btn-default btn-xl" ng-click="gotoBook()">RESERVE MY SEAT</a>
                </div>

            </div>
            <!-- end .container -->
        </div>
        <div class="filter"></div>
        <video autoplay loop class="fillWidth video-header">
            <source src="https://s3.amazonaws.com/equis-crm/assets/video/EquisConferenceWebBackground.mp4"
                    type="video/mp4"/>
        </video>
        <div class="poster hidden">
            <img src="{{asset("assets/equis_page/assets/img/hyatt-new.jpg")}}" alt="event video poster">
        </div>
    </div>
</header>
<!-- end .header -->
<!--
 Highlight Section
 ====================================== -->
<section class="highlight" style="background:white;">

    <div class="container">
        <p class="lead text-center">

        {!! Markdown::parse($event->description) !!}
        </p>
        @if($event->images->count())
            <div class="row">
                <div class="col-md-5">
                    <div class="content event_poster">
                        <img alt="{{$event->title}}" src="{{config('attendize.cdn_url_user_assets').'/'.$event->images->first()['image_path']}}" property="image">
                    </div>
                </div>
            </div>

        @endif
        <div class="countdown_wrap">

            <h6 class="countdown_title text-center">EVENT WILL START IN</h6>

            <!-- Countdown JS for the Event Date Starts here.
            TIP: You can change your event time below in the Same Format.  -->

            <ul id="countdown" data-event-date="{{ $event->start_date->format('d F Y H:i:s')}}">
                <li class="wow zoomIn" data-wow-delay="0s">
                    <span class="days">00</span>
                    <p class="timeRefDays">days</p>
                </li>
                <li class="wow zoomIn" data-wow-delay="0.2s">
                    <span class="hours">00</span>
                    <p class="timeRefHours">hours</p>
                </li>
                <li class="wow zoomIn" data-wow-delay="0.4s">
                    <span class="minutes">00</span>
                    <p class="timeRefMinutes">minutes</p>
                </li>
                <li class="wow zoomIn" data-wow-delay="0.6s">
                    <span class="seconds">00</span>
                    <p class="timeRefSeconds">seconds</p>
                </li>
            </ul>
        </div>
        <!-- end .countdown_wrap -->

        <div class="text-center">

            <!-- Add to Calendar Plugin.
                 For Customization, Visit https://addtocalendar.com/ -->
            <span class="addtocalendar atc-style-theme">
                    <a class="atcb-link"><i class="fa fa-calendar"> </i> Add to My Calendar</a>
                    <var class="atc_event">
                        <var class="atc_date_start">{{ $event->start_date->format('Y-m-d H:i:s')}}</var>
                        <var class="atc_date_end">{{ $event->end_date->format('Y-m-d H:i:s')}}</var>
                        <var class="atc_timezone">America/New_York</var>
                        <var class="atc_title">{{ $event->title}}</var>
                        <var class="atc_description">{{ $event->description}}</var>
                        <var class="atc_location">{{ $event->venue_name}}</var>
                        <var class="atc_organizer">Equis Financial</var>
                        <var class="atc_organizer_email">aanderson@equisfinancial.com</var>
                    </var>
                </span>

        </div>

    </div>
    <!-- end .container -->

</section>
