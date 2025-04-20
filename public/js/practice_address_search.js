var autocomplete;


function initAutocomplete1() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  autocomplete = new google.maps.places.Autocomplete(
  	(document.getElementById('phy_address1')), {types: ['geocode']}
  );

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  var address = document.getElementById('phy_address1').value;
  var addr_array = address.split(',');
  document.getElementById('phy_address1').value = addr_array[0];
  console.log(address)

  var street_number = '';
  document.getElementById('phy_address2').value 				= '';
  document.getElementById('phy_city').value 		= '';
  document.getElementById('phy_state').value 	= '';
  document.getElementById('phy_zip').value = '';
  document.getElementById('phy_country_id').value 	= '';

  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];

    if(addressType == 'locality'){
    	var val = place.address_components[i]['short_name'];
      document.getElementById('phy_address2').value = val;
    }
    if(addressType == 'postal_town'){
      var val = place.address_components[i]['short_name'];
      document.getElementById('phy_city').value = val;
      $.ajax({
        type: "POST",
        dataType:'json',
        url: '/onboarding/custom-checklist-action',
        data: { 'town':val, 'action':'getCountyByTown' },
        success : function(resp){
          document.getElementById('phy_state').value = resp.county;
        }
      });
    }
    if(addressType == 'country'){
    	var val = place.address_components[i]['long_name'];
    	$.ajax({
        type: "POST",
        dataType:'json',
        url: '/onboarding/custom-checklist-action',
        data: { 'country':val, 'action':'getCountryIdByCountryName' },
        success : function(resp){
          document.getElementById('phy_country_id').value = resp.country_id;
        }
      });
      
    }
    if(addressType == 'postal_code'){
    	var val = place.address_components[i]['short_name'];
      document.getElementById('phy_zip').value = val;
    }
  }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
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






