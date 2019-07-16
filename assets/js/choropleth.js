(function ($) {

	$.fn.choropleth_map = function(){

		return this.each(function() {

      var $el 			 = jQuery( this ),
				data				 = {},
				geoCountries = {},
				regions_data = {},
				regions_url  = $el.data( 'regions-url' );

			if( $el.data('json') ){
				data = $el.data( 'json' );
			}

			if( data['region-lines'] == undefined ){
				data['region-lines'] = {};
			}

			if( data[ 'regions' ] ){
				regions_data = data[ 'regions' ];
			}



      // CREATE ELEMENTS ON THE FLY
      function createElements(){

        var $loader = jQuery( document.createElement( 'div' ) );
        $loader.addClass( 'loader' );
        $loader.html( "<h3 class='loadtext'><i class='fa fa-spinner fa-spin'></i> Loading data, please wait..</h3>" );
        $loader.appendTo( $el );

        var $map = jQuery( document.createElement( 'div' ) );
        $map.attr('id', 'map');
        $map.appendTo( $el );
			}

      function drawMap(){

				var zoomLevel = data['map']['desktop']['zoom'],
					center_lat	= data['map']['desktop']['lat'],
					center_lng 	= data['map']['desktop']['lng'];

				var window_width = jQuery( window ).width();
				if( window_width < 500 ){
					zoomLevel = data['map']['mobile']['zoom'];
				}
				else if( window_width < 768 ){
					zoomLevel = data['map']['tablet']['zoom'];
				}

				//SETUP BASEMAP
        var map = L.map('map').setView( [center_lat, center_lng], zoomLevel );

				drawBase( map, zoomLevel );

				drawRegionBoundaries( map );

				drawSelectedRegions( map );

				drawMarkers( map );

			}

			function drawBase( map, zoomLevel ){
				if( data['map']['base_url'] == undefined ){
					data['map']['base_url'] = 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}';
					//https://api.mapbox.com/styles/v1/mapbox/outdoors-v9/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2FtdnRob20xNiIsImEiOiJjanh3cWNhYWIwN2pmM2NudzNtcDV6N3VjIn0.MoTl8WNgKqxgaTUDSIDK-Q
				}

				//var hybAttrib = 'ESRI World Light Gray | Map data © <a href="http://openstreetmap.org" target="_blank">OpenStreetMap</a> contributors & <a href="http://datameet.org" target="_blank">Data{Meet}</a>';
				var hyb = new L.TileLayer( data['map']['base_url'], {minZoom: zoomLevel, maxZoom: 18, attribution: data['map']['attribution'], opacity:1}).addTo(map);

			}

			// ADD REGION BOUNDARIES
			function drawRegionBoundaries( map ){
				var gjLayerCountryLines = L.geoJson( geoCountries, { style: {
					"color"		: data['region-lines']['color'] ? data['region-lines']['color'] : '#000000',
					"weight"	: data['region-lines']['weight'] ? data['region-lines']['weight'] : 1,
					"opacity"	: data['region-lines']['opacity'] ? data['region-lines']['opacity'] : 1,
					"fillColor"		: '#ffffff',
					'fillOpacity'	: 0.8,
				} } );
				gjLayerCountryLines.addTo(map);
				map.setMaxBounds( gjLayerCountryLines.getBounds() );
			}

			// ADD SELECTED REGIONS BY THE USER FROM THE BACKEND
			function drawSelectedRegions( map ){
				var gjLayerCountries = L.geoJson( geoCountries, { style: styleRegion, onEachFeature: onEachCountry, filter: matchRegions } );
        gjLayerCountries.addTo(map);

				// ONLY ADD REGIONS THAT ARE AVAILABLE IN THE DATA
				function matchRegions( feature ) {
					if( feature.properties && regions_data[ feature.properties.SOVEREIGNT ] ) return true;
					return false;
				}
			}

			// ITERATE THROUGH THE LIST OF MARKERS ENTERRED BY THE USER
			function drawMarkers( map ){

				if( data['markers'] != undefined ){

					var markersLayer = [];

					var markersClusterGroup = L.markerClusterGroup();

					jQuery.each( data[ 'markers' ], function( i, marker ){
						if( marker['lat'] != undefined && marker['lng'] != undefined ){

							var icon = L.icon({
								iconUrl : marker['icon'],
								iconSize: [30, 30],
							});

							// ADD MARKER BASED ON LAT AND LNG
							var markerLayer = L.marker( [ marker['lat'], marker['lng'] ], { icon: icon } );

							// ADD POPUP FOR THE MARKER IF IT EXISTS
							if( marker['popup'] != undefined ){ markerLayer.bindPopup( marker['popup'] ); }

							// ADD MARKER TO THE LIST OF MARKERS
							//markersLayer.push( markerLayer );

							markersClusterGroup.addLayer( markerLayer );
						}

					} );

					markersClusterGroup.addTo( map );

					//L.layerGroup( markersLayer ).addTo(map);
				}
			}

      function styleRegion( feature ){
				var color = '#311B92';
				if( regions_data[ feature.properties.SOVEREIGNT ]['color'] ){ color = regions_data[ feature.properties.SOVEREIGNT ]['color']; }
				return {
          fillColor		: color,
          weight			: 1,
          opacity			: 0.4,
          color				: 'black',
          dashArray		: '1',
          fillOpacity	: 0.8
        };
			}

			function onEachCountry( feature, layer ) {
        //CONNECTING TOOLTIP AND POPUPS TO DISTRICTS
        layer.on({
          mouseover: highlightFeature,
          mouseout: resetHighlight
          //click: zoomToFeature
        });


        layer.bindTooltip( feature.properties.SOVEREIGNT, {
          direction : 'auto',
          className : 'countrylabel',
          permanent : false,
          sticky    : true
        } );

				if( regions_data[ feature.properties.SOVEREIGNT ] ['popup'] ){
					layer.bindPopup( regions_data[ feature.properties.SOVEREIGNT ] ['popup'], { maxWidth:600 } );
				}


      }

			function highlightFeature(e) {
        // REGION HIGHLIGHT ON MOUSEOVER
        var layer = e.target;

        layer.setStyle( {
          weight: 3,
          color: 'yellow',
          opacity: 0.9
        } );
        if ( !L.Browser.ie && !L.Browser.opera ) { layer.bringToFront(); }
      }

      function resetHighlight(e) {
        // RESET HIGHLIGHT ON MOUSEOUT
        var layer = e.target;
        layer.setStyle({
          weight	: 1,
          color		: 'black',
          opacity	: 0.4
        });
      }

      function zoomToFeature(e) {
        // PROBABLY THE MAP VARIABLE NEEDS TO BE A GLOBAL VARIABLE HERE
        map.fitBounds(e.target.getBounds());
      }

      // INITIALIZE FUNCTION
      function init(){

        // CREATE ALL THE DOM ELEMENTS FIRST
        createElements();

				jQuery.ajax({
				  dataType	: "json",
				  url				: regions_url,
				  success		: function( data ){

						geoCountries = data;

						// HIDE THE LOADER
		        $el.find('.loader').hide();


						// RENDER THE MAP IN THE CORRECT DOM
		        drawMap();
					}
				});

      }

      init();

    });
  };
}(jQuery));

jQuery(document).ready(function(){

  jQuery( '[data-behaviour~=choropleth-map]' ).choropleth_map();

});
