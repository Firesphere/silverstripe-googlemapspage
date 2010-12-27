<?php

class GoogleMapsDecorator extends DataObjectDecorator {
	
	public function extraStatics(){
		return array (
	 		"db" => array(
				"Latitudes" => "Varchar",
				"Longitudes" => "Varchar",
				"Address" => "Varchar(600)",
				"MapType" => "Enum('roadmap, satellite, terrain, hybrid')",
				"MarkerSize" => "Enum('tiny, mid, small')",
				"MarkerColor" => "Enum('black, brown, green, purple, yellow, blue, gray, orange, red, white')",
				"MarkerLabel" => "Enum('A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z')"
			)
		);
	}  
	
	public function updateCMSFields($fields){
		$fields->addFieldsToTab("Root.Content.Maps", array(
			new TextField("Latitudes"),
			new TextField("Longitudes"),
			new TextField("Address"),
			new DropdownField("MapType", "Type", array(
				"roadmap" => "roadmap",
				"satellite" => "satellite",
				"terrain" => "terrain",
				"hybrid" => "hybrid"
			)),
			new LiteralField("Markers", "<h2>Marker settings</h2>"),
			new DropdownField("MarkerSize", "Marker size", array(
				"tiny" => "tiny", 
				"mid" => "mid", 
				"small" => "small"
			)), 
			new DropdownField("MarkerColor", "Marker color", array(
				"black" => "black", 
				"brown" => "brown", 
				"green" => "green",   
				"purple" => "purple", 
				"yellow" => "yellow", 
				"blue" => "blue",
				"gray" => "gray", 
				"orange" => "orange", 
				"red" => "red", 
				"white" => "white"
			)), 
			new DropdownField("MarkerLabel", "Marker label", array(
				"A" => "A", 
				"B" => "B", 
				"C" => "C",   
				"D" => "D", 
				"E" => "E", 
				"F" => "F",
				"G" => "G", 
				"H" => "H", 
				"I" => "I", 
				"J" => "J",
				"K" => "K", 
				"L" => "L", 
				"M" => "M",   
				"N" => "N", 
				"O" => "O", 
				"P" => "P",
				"Q" => "Q", 
				"R" => "R", 
				"S" => "S", 
				"T" => "T",
				"U" => "U",   
				"V" => "V", 
				"W" => "W", 
				"X" => "X",
				"Y" => "Y", 
				"Z" => "Z"
			)),
		));   
	}   
	
	function js(){          
		Requirements::javascript(THIRDPARTY_DIR . "/jquery/jquery.js");
		Requirements::javascript("http://maps.google.com/maps/api/js?sensor=true"); 
		$latitudes = $this->owner->Latitudes ? $this->owner->Latitudes : 0;
		$longitudes = $this->owner->Longitudes ? $this->owner->Longitudes : 0;
		$address = $this->owner->Address;
		$mapType = strtoupper($this->owner->MapType);
		$markerSize = $this->owner->MarkerSize;
		$markerColor = $this->owner->MarkerColor;
		$markerLabel = $this->owner->MarkerLabel;
		Requirements::customScript(<<<JS
			jQuery(document).ready(function(){ 
				var map;
				address = "$address";
				if(address != ""){
					geocoder = new google.maps.Geocoder();
					geocoder.geocode( { 'address': address}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) { 
					        var myOptions = {
						      zoom: 8,
						      center: results[0].geometry.location,
						      mapTypeId: google.maps.MapTypeId.{$mapType}
						    };
						    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);  
							var marker = new google.maps.Marker({
					            map: map, 
					            position: results[0].geometry.location
					        }); 
						} else {
					  		alert("Geocode was not successful for the following reason: " + status);
					    }
					}); 
			    }else{ 
					var latlng = new google.maps.LatLng($latitudes, $longitudes);
				    var myOptions = {
				      zoom: 8,
				      center: latlng,
				      mapTypeId: google.maps.MapTypeId.{$mapType}
				    };
				    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); 
					var marker = new google.maps.Marker({
			            map: map, 
			            position: latlng
			        });
				}
			}); 
JS
);
	}	
	
}