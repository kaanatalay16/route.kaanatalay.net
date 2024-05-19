var map = tt.map({
    key: 'iGig6LJKC6QWBSQOcqsRN58yTLM8wTJY',
    container: 'map',
    dragPan: !isMobileOrTablet()
});
map.addControl(new tt.FullscreenControl());
map.addControl(new tt.NavigationControl());
function createMarkerElement(type) {
    var element = document.createElement('div');
    var innerElement = document.createElement('div');
    element.className = 'route-marker';
    innerElement.className = 'icon tt-icon -white -' + type;
    element.appendChild(innerElement);
    return element;
}
function addMarkers(feature) {
    var startPoint, endPoint;
    if (feature.geometry.type === 'MultiLineString') {
        startPoint = feature.geometry.coordinates[0][0]; //get first point from first line
        endPoint = feature.geometry.coordinates.slice(-1)[0].slice(-1)[0]; //get last point from last line
    } else {
        startPoint = feature.geometry.coordinates[0];
        endPoint = feature.geometry.coordinates.slice(-1)[0];
    }
    new tt.Marker({ element: createMarkerElement('start') }).setLngLat(startPoint).addTo(map);
    new tt.Marker({ element: createMarkerElement('finish') }).setLngLat(endPoint).addTo(map);
}
function findFirstBuildingLayerId() {
    var layers = map.getStyle().layers;
    for (var index in layers) {
        if (layers[index].type === 'fill-extrusion') {
            return layers[index].id;
        }
    }
    throw new Error('Map style does not contain any layer with fill-extrusion type.');
}
map.once('load', function() {
    tt.services.calculateRoute({
        key: 'iGig6LJKC6QWBSQOcqsRN58yTLM8wTJY',
        traffic: false,
        locations: '4.8786,52.3679:4.8798,52.3679'
    })
        .then(function(response) {
            var geojson = response.toGeoJson();
            map.addLayer({
                'id': 'route',
                'type': 'line',
                'source': {
                    'type': 'geojson',
                    'data': geojson
                },
                'paint': {
                    'line-color': '#4a90e2',
                    'line-width': 8
                }
            }, findFirstBuildingLayerId());
            addMarkers(geojson.features[0]);
            var bounds = new tt.LngLatBounds();
            geojson.features[0].geometry.coordinates.forEach(function(point) {
                bounds.extend(tt.LngLat.convert(point));
            });
            map.fitBounds(bounds, { duration: 0, padding: 50 });
        });
});
