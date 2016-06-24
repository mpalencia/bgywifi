<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                	<img src="{{asset('assets/images/AWHLogo.png')}}"  style="width: 237px; position: relative; top: -10px; height: 40px;"/>
                </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
              <!--   <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        @if(isset($unread_msg))
                        @foreach($unread_msg as $k=>$v)
                        <li>
                        	<a href="{{url('/')}}/admin/messages">
                                <div>
                                    <strong>{{$v->first_name}} {{$v->last_name}}</strong>
                                </div>
                                <div>{{$v->message}}</div>
                            </a>
                        </li>
                        @endforeach

                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="{{url('/')}}/admin/messages">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                        @else
                        <li style="padding:10px;"><strong>No Messages</strong></li>

                        @endif
                    </ul>
                </li> -->

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{url('/')}}/admin/profile_settings/{{\Auth::user()->id}}/edit"><i class="fa fa-user fa-fw"></i>User Profile</a></li>
                        <li><a href="{{url('/')}}/admin/account_settings/{{\Auth::user()->id}}/edit"><i class="fa fa-gear fa-fw"></i>Account Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="{{url('/')}}/admin/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
