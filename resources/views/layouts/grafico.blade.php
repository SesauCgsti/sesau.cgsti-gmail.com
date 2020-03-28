<!DOCTYPE HTML>
<html>

<head>
	<script src="{{ asset('js/app.js') }}" defer></script>


	<script src="/leaflet/axios.min.js"></script>
	{{-- <script>
		window.addEventListener('orientationchange', function(){ 
		switch(window.orientation) 
		{ case -90: 
		case 90: console.log(window.orientation) 
			$('body').removeClass('landscape') ; 
			break; 
			default:			
			alert('portrait') 	
			$('body').addClass('landscape') 		
		
		console.log(window.orientation); 
				break; 
		}
	 });
	
	</script> --}}

</head>

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>
.centro{
	margin-top: 2%;
	margin-bottom: 2%;
}
</style>
</head>

<body class="bg-dark container-fluid centro ">
	@yield('content')
</body>

</html>