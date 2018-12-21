<!-- end section.highlight -->
<section  id="book"  class="highlight" style="background:white;">

    <div class="container">

        <script>
            function resizeIframe(obj) {
                obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
            }
        </script>
        <!--Attendize.com Ticketing Embed Code-->
        <iframe id="bookiframe" style='overflow:hidden; min-height: 350px;' frameBorder='0'
                seamless='seamless' width='100%' height='100%'
                src='{{route('showEmbeddedEventPage',['event_id'=>$event->id])}}'
                vspace='0' hspace='0'
                scrolling='auto'
                allowtransparency='true'
                scrolling="no" onload="resizeIframe(this)">

        </iframe>
        <!--/Attendize.com Ticketing Embed Code-->

    </div>
    <!-- end .container -->

</section>