<div id="uLogin" data-ulogin="display=panel;theme=classic;fields=first_name,email;optional=nickname,phone,photo,city;providers=google,facebook,twitter,instagram,linkedin;redirect_uri={{ urlencode('http://'.$_SERVER['HTTP_HOST']) }}/ulogin;mobilebuttons=0;"></div>
@section('js_ulogin')
    <script src="//ulogin.ru/js/ulogin.js"></script>
@endsection