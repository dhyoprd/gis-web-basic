@extends('adminlte::page')

@section('title', 'Tugas HandsOn 1')

@section('content_header')
    <h1>Tugas 1 SIG Dhyo</h1>
    <h4>Interactive Map with Laravel</h4>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="map-container">
            <div id="leaflet-map"></div>
            <div id="google-map"></div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .map-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin: 20px auto;
    }

    #leaflet-map, #google-map {
        flex: 1 1 45%;
        height: 400px;
        min-width: 300px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
</style>
@stop

@section('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4lKVb0eLSNyhEO-C_8JoHhAvba6aZc3U"></script>
<script>
    // Leaflet map
    const leafletMap = L.map('leaflet-map').setView([-8.7984047, 115.1698715], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(leafletMap);

    const leafletMarker = L.marker([-8.7984047, 115.1698715]).addTo(leafletMap);
    leafletMarker.bindPopup("<b>Kantor:</b><br>Rektorat Universitas Udayana").openPopup();

    leafletMarker.on('click', () => {
        leafletMap.setView(leafletMarker.getLatLng(), 18); 
    });

    const leafletHomeMarker = L.marker([-8.599920738910951, 115.26925585735219]).addTo(leafletMap);
    leafletHomeMarker.bindPopup("<b>Rumah Saya</b><br>Narada Silver, Jalan Raya Celuk Sukawati Gianyar");

    leafletHomeMarker.on('click', () => {
        leafletMap.setView(leafletHomeMarker.getLatLng(), 18); 
    });

    // Google Map
    const googleMapDiv = document.getElementById('google-map');
    const googleMap = new google.maps.Map(googleMapDiv, {
        center: { lat: -8.7984047, lng: 115.1698715 },
        zoom: 15,
    });

    const googleMarker = new google.maps.Marker({
        position: { lat: -8.7984047, lng: 115.1698715 },
        map: googleMap,
        title: "Kantor: Rektorat Universitas Udayana",
    });

    const infoWindow = new google.maps.InfoWindow({
        content: "<b>Kantor:</b><br>Rektorat Universitas Udayana",
    });

    googleMarker.addListener('click', () => {
        infoWindow.open(googleMap, googleMarker);
        googleMap.setZoom(18); 
        googleMap.setCenter(googleMarker.getPosition()); 
    });

    const googleHomeMarker = new google.maps.Marker({
        position: { lat: -8.599920738910951, lng: 115.26925585735219 },
        map: googleMap,
        title: "Rumah Saya",
    });

    const homeInfoWindow = new google.maps.InfoWindow({
        content: "<b>Rumah Saya</b><br>Narada Silver, Jalan Raya Celuk Sukawati Gianyar",
    });

    googleHomeMarker.addListener('click', () => {
        homeInfoWindow.open(googleMap, googleHomeMarker);
        googleMap.setZoom(18); 
        googleMap.setCenter(googleHomeMarker.getPosition()); 
    });
</script>
@stop 