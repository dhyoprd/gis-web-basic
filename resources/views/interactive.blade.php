<head>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    
</head>
<div class="form-container">
        <h3>Tambahkan Marker</h3>
        <form id="markerForm" method="POST" action="{{ url('api/markers') }}">
            @csrf
            <input type="text" id="markerName" placeholder="Nama Lokasi" required />
            <input type="text" id="markerLat" placeholder="Latitude" required />
            <input type="text" id="markerLng" placeholder="Longitude" required />
            <button type="submit">Tambah Marker</button>
        </form>

        <h3>Tambahkan Poligon</h3>
        <form id="polygonForm">
            <textarea id="polygonCoords" placeholder="Koordinat Poligon (JSON)" required></textarea>
            <button type="submit">Tambah Poligon</button>
        </form>
    </div>

    <style>
    .form-container {
        margin: 20px;
        padding: 20px;
        background: #f5f5f5;
        border-radius: 5px;
    }

    form {
        margin-bottom: 20px;
    }

    input, textarea {
        margin: 5px 0;
        padding: 5px;
        width: 100%;
    }

    button {
        padding: 8px 15px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    button:hover {
        background: #0056b3;
    }
    </style>

    <script type="text/javascript">
    // Tambahkan event listener untuk marker
    document.getElementById("markerForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const name = document.getElementById("markerName").value;
        const lat = parseFloat(document.getElementById("markerLat").value);
        const lng = parseFloat(document.getElementById("markerLng").value);

        fetch("{{url('api/markers')}}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ name, latitude: lat, longitude: lng }),
        })
        .then((res) => res.json())
        .then((data) => {
            alert("Marker ditambahkan!");
        });
    });

    // Tambahkan event listener untuk poligon
    document.getElementById("polygonForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const coords = JSON.parse(document.getElementById("polygonCoords").value);

        fetch("{{url('api/polygons')}}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ coordinates: coords }),
        })
        .then((res) => res.json())
        .then((data) => {
            alert("Polygon ditambahkan!");
        });
    });
    </script>
