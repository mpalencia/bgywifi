<!DOCTYPE html>
<html lang="en">

<head>
    @include('header')
   	@yield('head')

</head>

<body>
    <input type="hidden" name="baseUrl" id="baseUrl" value="{{url('/')}}"/>
    @yield('modals')

    @include('nav')

    @yield('content')

	<!--@include('footer')-->

	<!-- Global JS Script -->
	@include('scripts')

	<!-- Custom JS Scripts -->
    @yield('customScripts')

</body>

</html>
