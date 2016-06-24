@include('admin_includes/header')
<body>
	<input type="hidden" name="baseUrl" id="baseUrl" value="{{url('/')}}"/>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">


                    <div class="panel-heading">
                        <img src="{{asset('assets/images/AWHLogo.png')}}"  style="width: 330px;"/>
                        <h3 class="panel-title" style="text-align: center; margin-top: 10px;">Please Sign In</h3>
                    </div>
                    <div class="panel-body">

                        <form role="form" id="loginForm">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" id="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" id="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="button" class="btn btn-lg btn-success btn-block" name="loginBtn" id="loginBtn" onclick="brgy.submitLogin('loginForm');">Login</butto>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@include('admin_includes/footer')

</html>
