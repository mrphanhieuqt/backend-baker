
            <!-- {{Page}} -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-circle-o text-aqua"></i><span>{{Page}}</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ action('Admin\{{Page}}Controller@index') }}"><i class="fa fa-circle-o"></i>{{Page}} List</a></li>
                    <li><a href="{{ action('Admin\{{Page}}Controller@add') }}"><i class="fa fa-circle-o"></i>{{ trans('admin::messages.add') }}</a></li>
                </ul>
            </li>
            <!-- End {{Page}} -->