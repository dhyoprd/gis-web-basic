<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peta Interaktif</title>

  <!-- Input Leaflet.js CDN -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Memasukan Google Maps API -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4lKVb0eLSNyhEO-C_8JoHhAvba6aZc3U"></script>

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    h1 {
      text-align: center;
      padding: 10px;
    }

    .map-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin: 20px auto;
      max-width: 90%;
    }

    #leaflet-map, #google-map {
      flex: 1 1 45%;
      height: 400px;
    }
  </style>
</head>
<body>
  <h1>Tugas 1 SIG Dhyo</h1>
  <h2 style="text-align: center;">Interactive Map with Laravel</h2>

  <div class="map-container">
    <div id="leaflet-map"></div>
    <div id="google-map"></div>
  </div>

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

    // Menggunakan API Google Map
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
</body>
</html>