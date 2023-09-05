<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
    #map {
        height: 390px;
        width: 75%;
    }
    @import url('https://fonts.googleapis.com/css?family=Exo:400,700');

    *{
        margin: 0px;
        padding: 0px;
    }

    body{
        font-family: 'Exo', sans-serif;
    }


    .context {
        width: 100%;
        position: absolute;
        top:10vh;
        
    }

    .context h1{
        text-align: center;
        color: #fff;
        font-size: 50px;
    }


    .area{
        background: #001979;  
        width: 100%;
        height:100vh;
        
    
    }

    .circles{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .circles li{
        position: absolute;
        display: block;
        list-style: none;
        width: 20px;
        height: 20px;
        background: rgba(255, 255, 255, 0.2);
        animation: animate 25s linear infinite;
        bottom: -150px;
        
    }

    .circles li:nth-child(1){
        left: 25%;
        width: 80px;
        height: 80px;
        animation-delay: 0s;
    }


    .circles li:nth-child(2){
        left: 10%;
        width: 20px;
        height: 20px;
        animation-delay: 2s;
        animation-duration: 12s;
    }

    .circles li:nth-child(3){
        left: 70%;
        width: 20px;
        height: 20px;
        animation-delay: 4s;
    }

    .circles li:nth-child(4){
        left: 40%;
        width: 60px;
        height: 60px;
        animation-delay: 0s;
        animation-duration: 18s;
    }

    .circles li:nth-child(5){
        left: 65%;
        width: 20px;
        height: 20px;
        animation-delay: 0s;
    }

    .circles li:nth-child(6){
        left: 75%;
        width: 110px;
        height: 110px;
        animation-delay: 3s;
    }

    .circles li:nth-child(7){
        left: 35%;
        width: 150px;
        height: 150px;
        animation-delay: 7s;
    }

    .circles li:nth-child(8){
        left: 50%;
        width: 25px;
        height: 25px;
        animation-delay: 15s;
        animation-duration: 45s;
    }

    .circles li:nth-child(9){
        left: 20%;
        width: 15px;
        height: 15px;
        animation-delay: 2s;
        animation-duration: 35s;
    }

    .circles li:nth-child(10){
        left: 85%;
        width: 150px;
        height: 150px;
        animation-delay: 0s;
        animation-duration: 11s;
    }



    @keyframes animate {

        0%{
            transform: translateY(0) rotate(0deg);
            opacity: 1;
            border-radius: 0;
        }

        100%{
            transform: translateY(-1000px) rotate(720deg);
            opacity: 0;
            border-radius: 50%;
        }

    }

    .custom-alert {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 20%;
        justify-content: center;
        align-items: center;
    }

    .custom-alert-content {
        background: #fff;
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
    }

    #custom-alert-ok {
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }


    </style>
</head>

<body>
    <div class="area" >
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div >
    <div class="context">
        <div id="custom-alert" class="custom-alert">
            <div class="custom-alert-content">
                <p>...L'emplacement n'a pas été trouvé...</p>
            </div>
        </div>
        <form class='container' method='get'>
            <div class="row">
                <div class="col-5">
                    <input type="text" id="latitude" name='latitude' class="form-control  m-1 " placeholder='Latitude' required>
                </div>
                <div class="col-5">
                    <input type="text" id="longitude" name='longitude' class="form-control  m-1 " placeholder='Longitude' required>
                </div>
                <div class="col-2 ">
                    <button class="btn btn-outline-light m-1 w-100">Appliquer</button>
                </div>
            </div>
        </form> 
        <div class="container mt-1 w-100 mb-5">
            <center>
                <div class="input-group w-50 ">
                    <input type="text" id='address' class='form-control'>
                    <span class="input-group-text" id="search" role='button'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search-heart" viewBox="0 0 16 16">
                            <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018Z"/>
                            <path d="M13 6.5a6.471 6.471 0 0 1-1.258 3.844c.04.03.078.062.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1.007 1.007 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5ZM6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11Z"/>
                        </svg>
                    </span>
                </div>
            </center>
            
        </div>

        <div class="container">
            <center>
                <div id="map"></div>
            </center>
        </div>
    </div>   

    <?php
        if(!isset($_GET['latitude']) && !isset($_GET['longitude'])){  
            $latitude = 33.619337;
            $longitude =-7.499371;
        } else {
            $latitude = $_GET['latitude'];
            $longitude = $_GET['longitude'];
        }
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var latitude = <?php echo $latitude ?>;
        var longitude = <?php echo $longitude ?>;
        var map;

        $(document).ready(function () {
            $("#search").click(function () {
                findAddress($('#address').val());
            });
        });

        var addressArray = [];

        function findAddress(address) {
            var url = "https://nominatim.openstreetmap.org/search?format=json&limit=3&q=" + address;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    addressArray = data;
                    showAddress(); 
                })
                .catch(err => console.log(err));
        }
        function showAlert(message) {
            var customAlert = document.getElementById("custom-alert");
            var customAlertContent = document.querySelector(".custom-alert-content");

            customAlertContent.innerHTML = "<p>" + message + "</p>"+'<button id="custom-alert-ok">OK</button>';

            customAlert.style.display = "flex";

            var customAlertOK = document.getElementById("custom-alert-ok");
            customAlertOK.addEventListener("click", function () {
                customAlert.style.display = "none";
            });
        }
        function showAddress() {
            if (addressArray.length > 0) {
                latitude = parseFloat(addressArray[0].lat);
                longitude = parseFloat(addressArray[0].lon);
                
                marker.setLatLng([latitude, longitude]);
                map.setView([latitude, longitude], 12);
            }else{
                showAlert("...L'emplacement n'a pas été trouvé...");

            }
        }

        map = L.map('map').setView([latitude, longitude], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        var marker = L.marker([latitude, longitude]).addTo(map);

        var selector = L.control({
            position: 'topright'
        });

        var popup = L.popup();

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("Vous avez cliqué sur la carte à " + e.latlng.toString())
                .openOn(map);
        }

        map.on('click', onMapClick);


                
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
</body>

</html>