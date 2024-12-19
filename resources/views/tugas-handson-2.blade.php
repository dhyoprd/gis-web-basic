@extends('adminlte::page')

@section('title', 'Tugas HandsOn 2')

@section('content_header')
    <h1>Tugas 2 SIG</h1>
@stop

@section('css')
<style>
    #map {
        height: 600px;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .form-container {
        margin: 20px;
    }
    #markerForm, #polygonForm {
        margin-bottom: 20px;
    }
    input, textarea {
        margin-bottom: 10px;
    }
</style>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div id="map"></div>
            </div>
            <div class="col-md-4">
                <div class="form-container">
                    <h3>Tambah Marker</h3>
                    <form id="markerForm">
                        <input type="text" id="markerName" class="form-control" placeholder="Nama Lokasi" required>
                        <input type="text" id="markerLat" class="form-control" placeholder="Latitude" required>
                        <input type="text" id="markerLng" class="form-control" placeholder="Longitude" required>
                        <button type="submit" class="btn btn-success">Tambah Marker</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </form>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Polygon</h3>
                        </div>
                        <div class="card-body">
                            <form id="polygonForm">
                                @csrf
                                <div class="form-group">
                                    <label for="polygonName">Nama Polygon</label>
                                    <input type="text" class="form-control" id="polygonName" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="polygonCoordinates">Koordinat (JSON format)</label>
                                    <textarea class="form-control" id="polygonCoordinates" name="coordinates" rows="4" required></textarea>
                                    <small class="form-text text-muted">
                                        Format: [{"lat": -8.655, "lng": 115.217}, ...]
                                    </small>
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah Polygon</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <h3>Data Marker</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Latitude</th>
                                <th class="text-center">Longitude</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="markerTableBody">
                        </tbody>
                    </table>
                </div>

                <h3 class="mt-4">Data Polygon</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Koordinat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="polygonTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4lKVb0eLSNyhEO-C_8JoHhAvba6aZc3U"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Initialize map
    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -8.409518, lng: 115.188919 },
        zoom: 9
    });

    // Array untuk menyimpan marker yang aktif
    let activeMarkers = [];

    // Fungsi untuk membersihkan marker dari peta
    function clearMarkers() {
        activeMarkers.forEach(marker => marker.setMap(null));
        activeMarkers = [];
    }

    // Fungsi untuk memuat marker
    function loadMarkers() {
        clearMarkers();
        
        fetch('/api/markers', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    console.log('Error response:', text);
                    throw new Error('Network response was not ok');
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Loaded markers:', data);
            
            const tableBody = document.getElementById('markerTableBody');
            tableBody.innerHTML = '';
            
            if (Array.isArray(data)) {
                data.forEach(marker => {
                    // Add marker to map
                    const newMarker = new google.maps.Marker({
                        position: { 
                            lat: parseFloat(marker.latitude), 
                            lng: parseFloat(marker.longitude) 
                        },
                        map: map,
                        title: marker.name
                    });
                    
                    activeMarkers.push(newMarker);

                    // Add row to table
                    const row = `
                        <tr>
                            <td class="text-center">${marker.id}</td>
                            <td class="text-center">${marker.name}</td>
                            <td class="text-center">${marker.latitude}</td>
                            <td class="text-center">${marker.longitude}</td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm" onclick="viewMarker(${marker.latitude}, ${marker.longitude})">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteMarker(${marker.id})">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            } else {
                console.error('Invalid data format:', data);
            }
        })
        .catch(error => {
            console.error('Error loading markers:', error);
            Swal.fire('Error!', 'Gagal memuat data marker: ' + error.message, 'error');
        });
    }

    // Event listener untuk form marker
    document.getElementById('markerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const data = {
            name: document.getElementById('markerName').value,
            latitude: parseFloat(document.getElementById('markerLat').value),
            longitude: parseFloat(document.getElementById('markerLng').value)
        };

        fetch('/api/markers', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            Swal.fire({
                title: 'Berhasil!',
                text: 'Marker telah ditambahkan',
                icon: 'success'
            }).then(() => {
                this.reset();
                loadMarkers(); // Reload markers after adding
            });
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error!', 'Gagal menambahkan marker', 'error');
        });
    });

    // Function to view marker
    function viewMarker(lat, lng) {
        const position = { lat: parseFloat(lat), lng: parseFloat(lng) };
        map.setCenter(position);
        map.setZoom(15);
    }

    // Function to delete marker
    function deleteMarker(id) {
        Swal.fire({
            title: 'Hapus Marker?',
            text: "Anda yakin ingin menghapus marker ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                fetch(`/api/markers/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.log('Error response:', text);
                            throw new Error('Network response was not ok');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Delete response:', data);
                    Swal.fire(
                        'Terhapus!',
                        'Marker berhasil dihapus.',
                        'success'
                    ).then(() => {
                        loadMarkers(); // Reload markers after successful deletion
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error!',
                        'Gagal menghapus marker: ' + error.message,
                        'error'
                    );
                });
            }
        });
    }

    // Load markers when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadMarkers();
    });

    // Event listener untuk form polygon
    document.getElementById('polygonForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const coordinates = document.getElementById('polygonCoordinates').value;
        const name = document.getElementById('polygonName').value;

        try {
            // Parse coordinates from JSON string
            const coords = JSON.parse(coordinates);
            
            // Prepare the request body
            const requestData = {
                name: name,
                coordinates: coords  // Send the parsed array directly, not as a string
            };

            console.log('Sending data:', requestData); // Debug log

            fetch('/api/polygons', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        console.log('Error response:', text); // Debug log
                        throw new Error(text);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Polygon telah ditambahkan',
                    icon: 'success'
                }).then(() => {
                    this.reset();
                    loadPolygons();
                });
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Gagal menambahkan polygon: ' + error.message, 'error');
            });
        } catch (e) {
            console.error('Invalid coordinates format:', e);
            Swal.fire('Error!', 'Format koordinat tidak valid. Pastikan dalam format JSON yang benar.', 'error');
        }
    });

    // Array untuk menyimpan polygon yang aktif
    let activePolygons = [];

    // Function untuk membersihkan polygon dari peta
    function clearPolygons() {
        activePolygons.forEach(polygon => polygon.setMap(null));
        activePolygons = [];
    }

    // Function untuk memuat polygon
    function loadPolygons() {
        clearPolygons();
        
        fetch('/api/polygons')
            .then(response => response.json())
            .then(data => {
                console.log('Loaded polygons:', data);
                
                const tableBody = document.getElementById('polygonTableBody');
                tableBody.innerHTML = '';
                
                if (Array.isArray(data)) {
                    data.forEach(polygon => {
                        try {
                            // Parse coordinates from JSON string
                            const coords = JSON.parse(polygon.coordinates);
                            console.log('Parsed coordinates:', coords);
                            
                            // Convert coordinates to LatLng objects
                            const paths = coords.map(coord => ({
                                lat: parseFloat(coord.lat),
                                lng: parseFloat(coord.lng)
                            }));
                            
                            // Create polygon on map
                            const newPolygon = new google.maps.Polygon({
                                paths: paths,
                                strokeColor: "#FF0000",
                                strokeOpacity: 0.8,
                                strokeWeight: 2,
                                fillColor: "#FF0000",
                                fillOpacity: 0.35,
                                map: map
                            });
                            
                            activePolygons.push(newPolygon);

                            // Add row to table
                            const row = `
                                <tr>
                                    <td class="text-center">${polygon.id}</td>
                                    <td class="text-center">${polygon.name}</td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm" onclick="viewPolygon(${coords[0].lat}, ${coords[0].lng})">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deletePolygon(${polygon.id})">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            `;
                            tableBody.innerHTML += row;
                        } catch (e) {
                            console.error('Error processing polygon:', e, polygon);
                        }
                    });
                } else {
                    console.error('Invalid data format:', data);
                }
            })
            .catch(error => {
                console.error('Error loading polygons:', error);
                Swal.fire('Error!', 'Gagal memuat data polygon', 'error');
            });
    }

    // Function untuk menghapus polygon
    function deletePolygon(id) {
        Swal.fire({
            title: 'Hapus Polygon?',
            text: "Anda yakin ingin menghapus polygon ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/api/polygons/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(text);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Delete response:', data);
                    Swal.fire(
                        'Terhapus!',
                        'Polygon berhasil dihapus.',
                        'success'
                    ).then(() => {
                        loadPolygons(); // Reload polygons after deletion
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Gagal menghapus polygon: ' + error.message, 'error');
                });
            }
        });
    }

    // Function untuk melihat polygon
    function viewPolygon(lat, lng) {
        // Zoom ke lokasi yang dipilih
        map.setCenter({
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        });
        map.setZoom(15); // Sesuaikan level zoom sesuai kebutuhan
    }

    // Load polygons when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadPolygons();
    });
</script>
@stop 