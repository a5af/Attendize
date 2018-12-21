<section id="contact" class="container">

    <div class="section-title">
        <h5>SEND US A MESSAGE</h5>
        <p>If you have any questions about the event,
            please contact us directly. We will respond for sure.</p>
        @if($event->organiser->enable_organiser_page)
            <a href="{{route('showOrganiserHome', [$event->organiser->id, Str::slug($event->organiser->name)])}}" title="Organiser Page">
                {{$event->organiser->name}}
            </a>
        @else
            {{$event->organiser->name}}
        @endif
    </div>
    <div class="contact-form bottom-space-xl wow fadeInUp">

        <form name="EventMessage" id="EventMessage">
            <div class="row">

                <div class="col-md-6 col-md-offset-3">


                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" class="form-control"
                               ng-model="EventUserSend.name"
                               name="name" placeholder="Name" required>

                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control"
                               ng-model="EventUserSend.email" name="email"
                               placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control"
                               ng-model="EventUserSend.phone" name="phone"
                               placeholder="Phone Number" required>
                    </div>

                    <div class="form-group">
                        <label>Your Message</label>
                        <textarea class="form-control" name="message" rows="6"
                                  ng-model="EventUserSend.message"
                                  placeholder="Enter your message here" required> </textarea>
                    </div>

                    <div class="text-center top-space">
                        <button type="submit"
                                class="btn btn-success btn-block btn-lg"
                                ng-click="SendMessage({{$event->id}});" name="submit"
                                id="js-contact-btn">Send Message
                        </button>
                        <div id="js-contact-result"
                             data-success-msg="Form submitted successfully."
                             data-error-msg="Oops. Something went wrong."></div>
                    </div>

                </div>
            </div>
        </form>
    </div>

</section>
