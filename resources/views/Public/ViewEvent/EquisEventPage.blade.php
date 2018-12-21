@extends('Public.ViewEvent.Layouts.EquisEventPage')

@section('content')

    @include('Public.ViewEvent.Partials.equis.EventHighlight')
    @include('Public.ViewEvent.Partials.equis.EventBook')
    @include('Public.ViewEvent.Partials.equis.EventAccommodationHighlight')
    @include('Public.ViewEvent.Partials.equis.EventSpeaker')
    @include('Public.ViewEvent.Partials.equis.EventSchedule')
    @include('Public.ViewEvent.Partials.equis.EventBenefits')
    @include('Public.ViewEvent.Partials.equis.EventPricing')
    @include('Public.ViewEvent.Partials.equis.EventTwitter')
    @include('Public.ViewEvent.Partials.equis.EventFaq')




    <!--
     Our Sponsors
     ====================================== -->

    <section class="sponsors" id="sponsors">

        <div class="container">
            <div class="section-title wow fadeInUp">
                <h4>Our Carrier Partners</h4>
                <p>Get training and information on the industry’s best new products from leading carriers.</p>
            </div>

            <div class="sponsor-slider wow bounceIn">
                <div><img src="{{asset("assets/equis_page/assets/img/sponsors/foresters.jpg")}}"
                          width="189" height="72" class="img-responsive center-block" alt="Foresters"></div>
                <div><img src="{{asset("assets/equis_page/assets/img/sponsors/rna.jpg")}}"
                          width="189" height="72" class="img-responsive center-block" alt="RNA"></div>
                <div><img src="{{asset("assets/equis_page/assets/img/sponsors/cfg.jpg")}}"
                          width="189" height="72" class="img-responsive center-block" alt="CFG"></div>
                <div><img src="{{asset("assets/equis_page/assets/img/iq-1.png" )}}"
                    width="189" height="72" class="img-responsive center-block" alt="MOO">
                </div>

            </div>
        </div>
        <!-- end .container -->
    </section>
    <!-- end section.sponsors -->
    <!--
     Mailchimp Subscribe
     ====================================== -->

    <div class="highlight">
        <div class="container">
            <div class="row">
                <!--<form action="" method="post" class="form subscribe-form" id="subscribeform">-->
                <form name="EventSubscribeForm">
                    <div class="form-group col-md-3 hidden-sm">
                        <h6 class="susbcribe-head wow fadeInLeft">
                            SUBSCRIBE
                            <small>TO OUR CONVENTION NEWSLETTER</small>
                        </h6>
                    </div>
                    <div class="form-group col-sm-8 col-md-6 wow fadeInRight">
                        <label class="sr-only">Email address</label>
                        <input type="email" ng-model="EventSubscribe.email"
                               class="form-control input-lg" placeholder="Enter your email"
                               name="email" id="email" required>
                        <div id="js-subscribe-result" class="text-center"
                             data-success-msg="Almost finished. Please check your email and verify."
                             data-error-msg="Oops. Something went wrong."></div>
                    </div>
                    <div class="form-group col-sm-4 col-md-3">
                        <button type="submit" class="btn btn-lg btn-success btn-block"
                                id="js-subscribe-btn" ng-click="SubscribeMailchipEvent();">
                            Subscribe Now →
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- //  end .highlight -->
    <!--
     Location Map
     ====================================== -->

    <div class="g-maps" id="venue">

        <div class="map" id="map_canvas" data-maplat="28.382107" data-maplon="-81.510234"
             data-mapzoom="6" data-color="blue" data-height="400"
             data-img="{{asset("assets/equis_page/assets/img/marker.png")}}"
             data-info=" 1 Grand Cypress Blvd<br/> Orlando, FL 32836"></div>

    </div>
    <!-- end div.g-maps -->
    <!-- ::: BEGIN-VENUE ::: -->
    <section id="directions" class="directions vertical-space-lg">

        <div class="container">
            <div class="section-title wow fadeInUp top-space-sm">
                <h4>GET DIRECTIONS</h4>
                <p>Fill the form below to get directions to our event location</p>
            </div>

            <div class="row">

                <div class="col-sm-6">

                    <form action="/routebeschrijving" onsubmit="calcRoute();return false;"
                          id="routeForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="routeStart">Direction From:</label>
                                    <input type="text" id="routeStart"
                                           class="form-control" placeholder="Miami, FL">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="routeVia">Via
                                        <small>(Optional)</small>
                                    </label>
                                    <input type="text" class="form-control"
                                           id="routeVia" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only">Travel mode:</label>

                            <label class="radio-inline" for="travelMode1">
                                <input type="radio" name="travelMode" id="travelMode1"
                                       value="DRIVING" checked/> Driving
                            </label>
                            <label class="radio-inline" for="travelMode2">
                                <input type="radio" name="travelMode" id="travelMode2"
                                       value="BICYCLING"/> Bicycling
                            </label>
                            <label class="radio-inline" for="travelMode3">
                                <input type="radio" name="travelMode" id="travelMode3"
                                       value="TRANSIT"/> Public transport
                            </label>
                            <label class="radio-inline" for="travelMode4">
                                <input type="radio" name="travelMode" id="travelMode4"
                                       value="WALKING"/> Walking
                            </label>

                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fa fa-location-arrow"></i> Get Directions
                            </button>
                        </div>
                    </form>

                </div>

                <div class="col-sm-6">
                    <div class="directions-results">

                        <div id="directionsPanel">
                            <div class="direction-text">
                                Enter Direction from and Travel Mode from the left
                                form to see directions.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--end-of-row-->
        </div>

    </section>
    <!-- ::: END MAP ::: -->
    <!--
     Contact us
     ====================================== -->

    <div class="highlight">
        <div class="container">

            <div class="row">
                <div class="col-sm-6">
                    <div class="contact-box">
                        <img src="{{asset("assets/equis_page/assets/img/location-icon.png")}}" alt="location icon"
                             class="wow zoomIn">
                        <h5>ADDRESS</h5>
                        <p>
                            1 Grand Cypress Blvd
                            <br>Orlando, Florida
                            <br> (407) 239-1234
                            <br>Time: 10:00 AM to 09:00 PM
                        </p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="contact-box">
                        <img src="{{asset("assets/equis_page/assets/img/email-icon.png")}}" alt="email icon"
                             class="wow zoomIn" data-wow-delay="0.3s">
                        <h5>CONTACT</h5>
                        <p>
                            Alaina Anderson <br>Assistant Director of Communications <br>
                            828-299-9600 <br>
                            <a href="mailto:aanderson@equisfinancial.com">aanderson@equisfinancial.com</a>

                        </p>

                    </div>
                </div>
            </div>
            <!--  // end .row -->
        </div>
    </div>
    <!-- //  end .highlight -->

    @include('Public.ViewEvent.Partials.equis.EventOrganiserSection')
    <!-- // end .container -->
    <!--
     Footer Call to Action
     ====================================== -->


    <script>

      window.intercomSettings = {
        app_id: '{{config('services.intercom.app_id')}}',
      };

     @if($is_logged_in === true)
         window.intercomOnUpdateSettings = {
            email: "{{$logged_user->email}}", // Email address
            user_hash: "{{  hash_hmac('sha256',$logged_user->email,config('services.intercom.key')) }}",
            name: "{{ $logged_user->first_name }} {{ $logged_user->last_name }}",
            phone: "{{ $logged_user->phone }}"
         };
     @endif

      //Intercom Snippet
      (function(){var w=window;var ic=w.Intercom;
        if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}
        else{var d=document;var i=function(){i.c(arguments)};i.q=[];
          i.c=function(args){i.q.push(args)};w.Intercom=i;
          function l(){var s=d.createElement('script');
            s.type='text/javascript';s.async=true;
            s.src='https://widget.intercom.io/widget/vc8192a9';
            var x=d.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s,x);}
          if(w.attachEvent){w.attachEvent('onload',l);}
          else{w.addEventListener('load',l,false);}}})();

      Intercom('onShow', function() { // Do stuff
        Intercom('update', window.intercomOnUpdateSettings);
      });
    </script>


@stop

