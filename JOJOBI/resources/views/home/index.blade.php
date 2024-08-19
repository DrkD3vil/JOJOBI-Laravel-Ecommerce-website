
<!DOCTYPE html>
<html lang="en">

<head>
@include('home.cssfile')
</head>

<body>
	<!-- top-header -->
	@include('home.header')
	<!-- shop locator (popup) -->
	<!-- Button trigger modal(shop-locator) -->
	@include('home.locator')
	<!-- //shop locator (popup) -->
	<!-- signin Model -->
	@include('home.signin_model')
	<!-- //signup Model -->
	<!-- //header-bot -->
	<!-- navigation -->
	@include('home.navigation')
	<!-- //navigation -->
	<!-- banner -->
	@include('home.banner')
	<!-- //banner -->

	<!-- top Products -->
	@include('home.top_products')
	<!-- //top products -->
	<!-- special offers -->
	@include('home.special_offer')
	<!-- //special offers -->
	<!-- newsletter -->
	@include('home.newsletter')
	<!-- //newsletter -->
	@include('home.footer')

	@include ('home.jsfiles')

</body>

</html>