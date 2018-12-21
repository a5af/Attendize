<aside class="sidebar sidebar-left sidebar-menu">
    <section class="content">
        <h5 class="heading">Organiser Menu</h5>

        <ul id="nav" class="topmenu">
            @role(['owner', 'admin'])
            <li class="{{ Request::is('*dashboard*') ? 'active' : '' }}">
                <a href="{{route('showOrganiserDashboard', array('organiser_id' => $organiser->id))}}">
                    <span class="figure"><i class="ico-home2"></i></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            @endrole
            <li class="{{ Request::is('*events*') ? 'active' : '' }}">
                <a href="{{route('showOrganiserEvents', array('organiser_id' => $organiser->id))}}">
                    <span class="figure"><i class="ico-calendar"></i></span>
                    <span class="text">Events</span>
                </a>
            </li>
            @role('owner')
            <li class="{{ Request::is('*customize*') ? 'active' : '' }}">
                <a href="{{route('showOrganiserCustomize', array('organiser_id' => $organiser->id))}}">
                    <span class="figure"><i class="ico-cog"></i></span>
                    <span class="text">Customize</span>
                </a>
            </li>
            @endrole
        </ul>
    </section>
</aside>
