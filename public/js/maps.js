// Inisialisasi peta
var map = L.map('map').setView([-8.6500, 115.2167], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Event handler saat peta diklik
map.on('click', function(e) {
    // Dapatkan koordinat dari event click
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;
    
    console.log('Koordinat yang diklik:', lat, lng); // untuk debugging

    // Kirim data ke server
    $.ajax({
        url: '/markers',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            latitude: lat,
            longitude: lng,
            name: 'Marker Baru'
        },
        success: function(response) {
            console.log('Marker berhasil ditambahkan:', response);
            // Tambahkan marker ke peta
            L.marker([lat, lng]).addTo(map);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.log(xhr.responseText);
        }
    });
}); 