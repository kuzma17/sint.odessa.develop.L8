@extends('layouts.container3')

@section('content')
    <h3>{{ $page->title }}</h3>

    <div class="map"  id="map"></div>
    <script type="text/javascript">
        var map;
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 11,
                center: {lat: 46.499583, lng: 30.7426}
            });

            var locations = [
                {
                    title: 'Главный офис. Адмиральский пр, 33а',
                    position: {lat: 46.43711, lng: 30.730315}
                    //icon: {
                    //   url: "images/markers/svg/Arrow_1.svg",
                    //   scaledSize: new google.maps.Size(96, 96)
                    //}

                },
                {
                    title: 'пл. Соборная 12',
                    position: {lat: 46.482146, lng: 30.730281}

                },
                {
                    title: 'Днепропетровская дор., 94',
                    position: {lat: 46.575718, lng: 30.7951071}


                },
                {
                    title: 'ул. Академика Королева, 33',
                    position: {lat: 46.400676, lng: 30.72347}

                }
            ];

            locations.forEach(function (element) {
                var marker = new google.maps.Marker({
                    position: element.position,
                    map: map,
                    title: element.title,
                    //icon: '/images/logo_icon.gif'
                });
                var contentString = '<div class="map_message">'+ element.title +'</div>';
                var infowindow = new google.maps.InfoWindow({
                    content: contentString});

                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map,marker);
                });
            });

        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-tzqTftm3ZEf0jOCDI9gpnXgpZRuZcTQ&callback=initMap"></script>
    <div class="content-page">
    {!! $page->content !!}
    </div>
@endsection