<?php
/**
 * Date: 05/10/17
 * Time: 1:46 PM
 */

$class = "";


?>
<script>
    var Markerdata = [];
</script>

<div class="wrap">
    <?php
    if (isset($message) AND !empty($message)) {
        ?>

        <div class="alert <?php echo $class ?>" role="alert">
            <?php echo $message; ?>
        </div>

        <?php
    }
    ?>

    <div class="col-md-12 ">
        <?php if (isset($_GET['action']) && $_GET['action'] == 'view') { ?>
            <div class="table-backend">
                <div id="icon-users" class="icon32"></div>
                <?php
                if (isset($_GET['id'])) {
                    $locations = $this->km_get_row_by_id($_GET['id']);
                } else {
                    $locations = '';
                }


                ?>
                <h2>View User Location <a class="pull-right" href="<?php echo KM_LOCATION_URL . '?page=km-locations';
                    ?>">Back</a></h2>
                <table>
                    <tbody>
                    <?php if ($locations): ?>
                        <tr>
                            <th>ID</th>
                            <td><?php echo $locations->id; ?></td>
                        </tr>
                        <tr>
                            <th>User Name</th>
                            <td><?php echo get_userdata($locations->user_id)->display_name; ?></td>
                        </tr>
                        <tr>
                            <th>Latitude</th>
                            <td><?php echo $locations->latitude; ?></td>
                        </tr>
                        <tr>
                            <th>Longitude</th>
                            <td><?php echo $locations->longitude; ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php echo $locations->full_address; ?></td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td><?php echo $locations->city; ?> Star</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td><?php echo $locations->state; ?></td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td><?php echo $locations->country; ?></td>
                        </tr>
                        <tr>
                            <th>Radius</th>
                            <td><?php echo $locations->radius; ?> (in miles)</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="map" style="width: 100%;height: 500px"></div>
                            </td>
                        </tr>

                        <script>
                            var appendData = [];
                            appendData[0] = "<?php echo $locations->latitude; ?>";
                            appendData[1] = "<?php echo $locations->longitude; ?>";
                            appendData[2] = "<?php echo $locations->radius; ?>";
                            Markerdata[0] = appendData;
                        </script>


                        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc75Q9kXqU-DXijJUzbBwMYYtdXCfFAH8&libraries=places,drawing&callback=initAutocomplete"
                                async defer></script>
                        <script>
                            var $ = jQuery;

                            var map;
                            var geocoder;
                            var markers = [];
                            var cityCircles = [];
                            var autocomplete;


                            function initAutocomplete() {


                                map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 5,
                                    center: {lat: 63.3184475, lng: -125.3063377},
                                    mapTypeControl: false,
                                    rotateControl: false,
                                    streetViewControl: false,
                                    fullscreenControl: false,
                                    tilt: 0,
                                });

                                var boundsListener = google.maps.event.addDomListener((map), 'bounds_changed', function (event) {
                                    this.setZoom(this.getZoom());
                                    google.maps.event.removeListener(boundsListener);
                                });

                                geocoder = new google.maps.Geocoder();


                                DrawMarkers();

                            }


                            function DrawMarkers() {
                                removeMarkers();
                                bounds = new google.maps.LatLngBounds();
                                if (Markerdata != null && Markerdata.length > 0) {
                                    for (var i = 0; i < Markerdata.length; i++) {
                                        if (Markerdata[i] != null) {
                                            var geoCode = new google.maps.LatLng(Markerdata[i][0], Markerdata[i][1]);
                                            var marker = new google.maps.Marker({
                                                position: geoCode,
                                                map: map,
                                            });
                                            var cityCircle = new google.maps.Circle({
                                                strokeColor: '#FF0000',
                                                strokeOpacity: 0.8,
                                                strokeWeight: 2,
                                                fillColor: '#FF0000',
                                                fillOpacity: 0.35,
                                                map: map,
                                                radius: parseInt(Markerdata[i][2], 10) * 1000 * 1.60934
                                            });
                                            cityCircle.bindTo('center', marker, 'position');
                                            marker.cityCircle = cityCircle;
                                            markers.push(marker);

                                            bounds.union(cityCircle.getBounds());
                                        }
                                    }
                                    map.fitBounds(bounds);
                                }

                            }

                            function removeMarkers() {
                                for (var i = 0; i < markers.length; i++) {
                                    markers[i].setMap(null);
                                    markers[i].cityCircle.setMap(null)
                                }
                            }


                            var componentForm = {
                                locality: 'city',
                                administrative_area_level_1: 'state',
                                country: 'country',
                                postal_code: 'pincode'
                            };
                            var AddresssForm = {
                                locality: 'long_name',
                                administrative_area_level_1: 'long_name',
                                country: 'long_name',
                                postal_code: 'short_name'
                            };


                            function fillInAddress() {
                                var place = autocomplete.getPlace();
                                document.getElementById('latitude').value = place.geometry.location.lat();
                                document.getElementById('longitude').value = place.geometry.location.lng();
                                for (var i = 0; i < place.address_components.length; i++) {
                                    var addressType = place.address_components[i].types[0];
                                    if (AddresssForm[addressType]) {
                                        var val = place.address_components[i][AddresssForm[addressType]];
                                        document.getElementById(componentForm[addressType]).value = val;
                                    }
                                }
                                var radius = document.getElementById('radius').value;
                                geocodeAddress(geocoder, map, place.geometry.location.lat(), place.geometry.location.lng(), radius)
                            }


                            function geocodeAddress(geocoder, resultsMap, latitude, longitude, radius) {

                                var data = [];
                                data[0] = latitude;
                                data[1] = longitude;
                                data[2] = radius;
                                Markerdata[0] = data;
                                DrawMarkers();

                            }
                        </script>

                    <?php else: ?>
                        <tr>
                            <td>No Locations Found</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>

            <div id="icon-users" class="icon32"></div>
            <h2>User Locations</h2>


            <form id="events-filter" method="get">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>

                <?php
                if (class_exists("KM_Location_Tables")) {
                    $poll_list = new KM_Location_Tables();
                    $poll_list->prepare_items();
                    $poll_list->display();
                }
                ?>
            </form>

        <?php } ?>

    </div>
</div>
<style>
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0, 0, 0); /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content, #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }
        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }
        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 35px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }
</style>