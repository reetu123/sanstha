var map;
var geocoder;
// var incnumber = 0;
// var Markerdata = [];
var markers = [];
var cityCircles = [];
var autocomplete;
var componentForm = {
    locality: 'areacity',
    administrative_area_level_1: 'areastate',
    country: 'areacountry',
    postal_code: 'areapincode'
};
var AddresssForm = {
    locality: 'long_name',
    administrative_area_level_1: 'long_name',
    country: 'long_name',
    postal_code: 'short_name'
};

jQuery(document).on('submit','form.search_locations',function(){
    var lat = jQuery("#arealatitude").val();
    if (lat == '') {
        jQuery(".validation-message").show();
        return false;
    }else{
        jQuery(".validation-message").hide();
        return true;
    }
});

jQuery(document).on('submit','form.search_services',function(){
    var getService = jQuery("#get_service").val();
    if (getService == '') {
        jQuery(".validation-message-service").show();
        return false;
    }else{
        jQuery(".validation-message-service").hide();
        return true;
    }
});

jQuery(document).ready(function ($) {
    /* start */
    // jQuery('#areaSearchSub').prop('disabled', true);
    // document.getElementById("areaSearchSub").disabled = true;
    var pathArray = window.location.pathname.split('/');
    var firstLevelLocation = pathArray[1];
    var secondLevelLocation = pathArray[2];
    if (firstLevelLocation == 'search-tasker' || secondLevelLocation == 'search-tasker') {
        initSearchAutocomplete();
    }

    function initSearchAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('search_location')),
            {types: ['geocode']});
        autocomplete.addListener('place_changed', fillInAddress);
        autocomplete.setComponentRestrictions(
            {'country': ['ca']});
        google.maps.event.addDomListener(document.getElementById('search_location'), 'keydown', function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
            }
        });




      /*  document.getElementById('areaSearchSub').addEventListener('click', function (e) {

            // $(this).next().remove();
            if (document.getElementById('search_location').value == '' || document.getElementById('arealatitude').value == '' || document.getElementById('arealongitude').value == '') {
            e.preventDefault();
                $(this).after('<span class="validation-message error">\n' +
                    'Please enter a valid address\n' +
                    '</span>');
                
            }
        });*/


    }

    /* end */

    var mapStyle = [{
        'stylers': [{'visibility': 'on'}]
    },
    {
        'featureType': 'landscape',
        'elementType': 'geometry',
        'stylers': [{'visibility': 'on'}]
    },
    {
        'featureType': 'water',
        'elementType': 'geometry',
        'stylers': [{'visibility': 'on'}]
    }
    ];

    bounds = new google.maps.LatLngBounds();
    geocoder = new google.maps.Geocoder();


    var id = document.getElementById('map');
    if (id) {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom:4,
            // center: {lat: 34.068871, lng: -117.651215},
            center:{lat: 51.253777, lng: -85.323212},
            styles: mapStyle,
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
    }


    var id = document.getElementById('areaaddress');
    if (id) {

        initAutocomplete();
        google.maps.event.addDomListener(id, 'keydown', function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
            }
        });

        DrawMarkers();
    }




    function initAutocomplete() {

        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('areaaddress')),
            {types: ['geocode']});
        autocomplete.addListener('place_changed', fillInAddress);

        autocomplete.setComponentRestrictions(
            {'country': ['ca']});


        google.maps.event.addDomListener(document.getElementById('areaaddress'), 'keydown', function (event) {

            if (event.keyCode === 13) {
                event.preventDefault();
            }
        });

        document.getElementById('addarea').addEventListener('click', function (e) {

            e.preventDefault();

            $(this).next().remove();

            if (document.getElementById('areaaddress').value != '' && document.getElementById('radiuslength').value != '' && document.getElementById('arealatitude').value != '') {
                geocodeAddress(geocoder, map);
            } else {
                if (document.getElementById('areaaddress').value == '' || document.getElementById('arealatitude').value == '' || document.getElementById('arealongitude').value == '') {
                    $(this).after('<span class="validation-message error">\n' +
                        '        Please enter a valid address\n' +
                        '    </span>');
                } else {
                    $(this).after('');


                }
                if (document.getElementById('radius').value == '') {
                    $(this).after('<span class="validation-message error">\n' +
                        '        Please select radius\n' +
                        '    </span>')
                } else {
                    $(this).after('');

                }

            }

        });
    }



    function fillInAddress() {
        var place = autocomplete.getPlace();

        document.getElementById('arealatitude').value = place.geometry.location.lat();
        document.getElementById('arealongitude').value = place.geometry.location.lng();
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (AddresssForm[addressType]) {
                var val = place.address_components[i][AddresssForm[addressType]];
                document.getElementById(componentForm[addressType]).value = val;
            }
        }

        /*var country = document.getElementById('areacountry').value;
        if(country ==  'United States'){
            jQuery('#radius option:not(:selected)').prop('disabled', false);
        } else{
         jQuery('#radius option:not(:selected)').prop('disabled', true);
     }*/
 }


 function DrawMarkers() {
        // alert("in drawmarkers");
        removeMarkers();
        var bounds = new google.maps.LatLngBounds();

        // alert("marker data length is"+Markerdata.length);
        if (Markerdata != null && Markerdata.length > 0) {
            for (var i = 0; i < Markerdata.length; i++) {
                if (Markerdata[i] != null) {
                    var geoCode = new google.maps.LatLng(Markerdata[i][0], Markerdata[i][1]);
                    var marker = new google.maps.Marker({
                        position: geoCode,
                        map: map,
                    });

                    if(Markerdata[i][3] == 'km'){
                        var radius_region = parseInt(Markerdata[i][2], 10) * 1000;

                    }else{
                        var radius_region = parseInt(Markerdata[i][2], 10) * 1000 * 1.60934;
                    }
                    var cityCircle = new google.maps.Circle({
                        strokeColor: '#FF0000',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#FF0000',
                        fillOpacity: 0.35,
                        map: map,
                        radius: radius_region
                    });
                    cityCircle.bindTo('center', marker, 'position');
                    marker.cityCircle = cityCircle;
                    markers.push(marker);

                    bounds.union(cityCircle.getBounds());
                    map.fitBounds(bounds);
                }

            }
        }

    }

    function removeMarkers() {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
            markers[i].cityCircle.setMap(null)
        }
    }

    function geocodeAddress(geocoder, resultsMap) {
        var latitude = document.getElementById('arealatitude').value;
        var longitude = document.getElementById('arealongitude').value;
        var radius = document.getElementById('radiuslength').value;
        // alert(radius);
        // var radius_value = document.getElementById('radius').value;
        // alert(radius_value);
        // if(radius_value != ""){
        //     var radius_type = radius_value; 
        // }else{
            var radius_type = 'km';
        // }

        var incnumber = document.getElementById('incnumber').value;


        incnumber++;
        var data = [];
        data[0] = latitude;
        data[1] = longitude;
        data[2] = radius;
        data[3] = radius_type;
        // alert(incnumber);

        Markerdata[incnumber] = data;


        document.getElementById('incnumber').value = incnumber;
        var orignalData = $("#serve_area_wrapper");
        var copydata = orignalData.clone();

        
        $.each($(copydata).find('input,select'), function () {

            var startString = $(this).attr('name').split("[")[0];
            startString = startString.split("area_")[1];
            var endString = $(this).attr('name').split(".")[1];
            if (startString == 'areaaddress') {
                $(this).attr('readonly', 'readonly');
            }
            $(this).attr('name', startString + "[" + incnumber + "]");
            $(this).attr('id', $(this).attr('id') + incnumber);
            $(this).attr('mapid', incnumber);

        }),
        $.each($(copydata).find('a'), function () {
            $(this).attr('mapid', incnumber);
        }),
        $(copydata).find('select').each(function (index, item) {
            $(item).val(orignalData.find('select').eq(index).val());

        });
        $(copydata).removeAttr('id');
        $(copydata).addClass("serve_area_wrapper");

        console.log("copy data is"+copydata);
        $("div.serve_area_append_wrapper").append($(copydata));

        DrawMarkers();

        // alert("Now Incnumber"+incnumber);

        document.getElementById('areaaddress').value = '';
        document.getElementById('arealatitude').value = '';
        document.getElementById('arealongitude').value = '';
        $('#radius option:first-child').attr("selected", "selected");
    }



    //  $(".radius_change").bind("change paste keyup", function() {
    //    alert($(this).val()); 
    // });

    $(document).on("keyup", ".radius_change",function(e){
        e.preventDefault();
        var latitude = "";
        var longitude = "";
        var radius = $(this).val();

        var radius_type = $(this).closest("div.radius").find(".radius_update").val();
        var markerID = $(this).attr('mapid');
        // alert("Marker id is"+markerID);


        var lat = jQuery('#arealatitude' + markerID);
        var latitude = "";
        if (lat) {
            latitude = lat.val();
        }
        // var latitude = document.getElementById('arealatitude' + markerID).value;
        // alert("latitude is"+latitude);
        var long = jQuery('#arealongitude' + markerID);
        var longitude = "";
        if (long) {
            longitude = long.val();
        }
        // var longitude = document.getElementById('arealongitude' + markerID).value;
        // alert("longitude is"+longitude);
        var data = [];
        data[0] = latitude;
        data[1] = longitude;
        data[2] = radius;
        data[3] = radius_type;

        Markerdata[markerID] = data;

        DrawMarkers();
    });
    
    $(document).on('change', '.radius_update', function (e) {
        e.preventDefault();
        var radius = $(this).val();
        var markerID = $(this).attr('mapid');
        // alert("Marker id is"+markerID);
        var lat = jQuery('#arealatitude' + markerID);
        var latitude = "";
        if (lat) {
            latitude = lat.val();
        }
        var long = jQuery('#arealongitude' + markerID);
        var longitude = "";
        if (long) {
            longitude = long.val();
        }

        var data = [];
        data[0] = latitude;
        data[1] = longitude;
        data[2] = radius;

        Markerdata[markerID] = data;

        DrawMarkers();
    });

    jQuery(document).on('click', '.remove', function (e) {
        e.preventDefault();
        var mapid = $(this).attr('mapid');
        Markerdata[mapid] = null;
        DrawMarkers();
        $(this).parent().remove();
    });

});



 // jQuery(document).on('click','#addarea',function(e){
 //    alert(jQuery("#arealatitude").val());
 //         if(jQuery("#arealatitude").val() == ""){
 //            alert("empty");
 //            jQuery('#addarea').prop('disabled', true);
 //            return false;
 //         }else{
 //            alert("not empty");
 //            jQuery('#addarea').prop('disabled', false);
 //         }
 //    });