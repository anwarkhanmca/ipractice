$(document).ready(function(){    
  /*$(".address_search").click(function(){
	    
	});*/


    
});


var placeSearch, autocomplete;
  var componentForm = {
    //street_number: 'short_name',
    address1: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
  };

  function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
    	(document.getElementById('address1')), {types: ['geocode']}
    );

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
  }

  function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    var address = document.getElementById('address1').value;
    var addr_array = address.split(',');
    document.getElementById('address1').value = addr_array[0];
    console.log(address)

    var street_number = '';
    document.getElementById('address2').value 				= '';
    document.getElementById('address_city').value 		= '';
    document.getElementById('address_county').value 	= '';
    document.getElementById('address_postcode').value = '';
    document.getElementById('address_country').value 	= '';

    for (var i = 0; i < place.address_components.length; i++) {
      var addressType = place.address_components[i].types[0];
      /*if (componentForm[addressType]) {
        var val = place.address_components[i][componentForm[addressType]];
        document.getElementById(addressType).value = val;
      }*/
      //document.getElementById('address1').value 				= '';          
      
      /*if(addressType == 'street_number'){
      	street_number = place.address_components[i]['short_name'];
     		//document.getElementById('address1').value = street_number;
     		console.log("first :"+street_number)
      }

      if(addressType == 'route'){
      	var val = place.address_components[i]['short_name'];console.log(street_number)
      	document.getElementById('address1').value = street_number+' '+val;
      }*/
      if(addressType == 'locality'){
      	var val = place.address_components[i]['short_name'];
        document.getElementById('address2').value = val;
      }
      if(addressType == 'postal_town'){
        var val = place.address_components[i]['short_name'];
        document.getElementById('address_city').value = val;
        $.ajax({
          type: "POST",
          dataType:'json',
          url: '/onboarding/custom-checklist-action',
          data: { 'town':val, 'action':'getCountyByTown' },
          success : function(resp){
            document.getElementById('address_county').value = resp.county;
          }
        });
      }
      /*if(addressType == 'administrative_area_level_1'){
      	var val = place.address_components[i]['short_name'];
        document.getElementById('address_county').value = val;
      }*/
      if(addressType == 'country'){
      	var val = place.address_components[i]['long_name'];
      	$.ajax({
          type: "POST",
          dataType:'json',
          url: '/onboarding/custom-checklist-action',
          data: { 'country':val, 'action':'getCountryIdByCountryName' },
          success : function(resp){
            document.getElementById('address_country').value = resp.country_id;
          }
        });
        
      }
      if(addressType == 'postal_code'){
      	var val = place.address_components[i]['short_name'];
        document.getElementById('address_postcode').value = val;
      }
    }
  }


  function geolocate() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var geolocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        var circle = new google.maps.Circle({
          center: geolocation,
          radius: position.coords.accuracy
        });
        autocomplete.setBounds(circle.getBounds());
      });
    }
  }






