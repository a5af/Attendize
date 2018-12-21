<!--
 Pricing
 ====================================== -->

<section class="pricing" id="pricing">

    <div class="container">

        <div class="section-title">
            <h4>PRICING</h4>
            <p>Choose your favorite pass for the event.</p>
        </div>

        <div class="row">
            <div class="col-md-4" ng-repeat="c in eventTickets">
                <div class="pricing-item  wow zoomIn" data-wow-duration="2s">
                    <div class="plan-name"><%c.title%></div>
                    <div class="price">
                        <span class="curr" ng-if="c.price>0">$</span>
                        <%c.price==0.00?'Free':c.price | number%><span></span>
                    </div>
                    <span ng-if="c.enddate != undefined">
                          Until <%c.enddate|formatdate:"MMMM dd, yyyy"%></span>
                    <br />
                    <br />
                    <ul class="plan-features">
                        <li ng-repeat="k in c.benefits | split track by $index"> <%k%> </li>
                    </ul>
                    <div class="choosebtn">
                        <a class="btn btn-outline btn-lg" href="#"
                           ng-click="pagereserveseatclick(c.id)">Choose <%c.title%></a>
                    </div>
                </div>

            </div>

        </div>
</section>
<!-- end section.pricing -->