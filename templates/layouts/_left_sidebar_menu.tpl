
            <!-- {{Page}} -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-circle-o text-aqua"></i><span>{{Page}}</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/admin/{{page}}')}}"><i class="fa fa-circle-o"></i>{{Page}} List</a></li>
                    <li><a href="{{url('/admin/{{page}}/add')}}"><i class="fa fa-circle-o"></i>Add {{Page}}</a></li>
                </ul>
            </li>
            <!-- End {{Page}} -->