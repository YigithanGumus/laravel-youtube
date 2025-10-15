<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{$title ?? config('app.name')}}</title>

	@stack('header')
	@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
<div id="app">
 @yield('content')

</div>

<script>
	const vueMixinFunctions = [
		() => ({
			data() {
				return {
					showModal: false
				}
			},
			components: {
				Modal
			},
				watch: {
				"appStore": function(){
					this.appStore.setAuth(@json(auth()->user()));
					this.appStore.setEnv({
						APP_NAME: '{{config('app.name')}}',
						APP_ENV: '{{env('APP_ENV')}}',
						MODULE_NAME: 'MAIN'
					})
				}
			}
		})
	];
</script>
@stack('footer')

</body>
</html>
