let networks = [
    {
        network_id: 'NS_HELIUM://000024',
        network_name: 'Helium The People\'s Network',
        gateway_layer_name: 'Helium LongFi Hotspots',
        default_shown: true
    },
    {
        network_id: 'NS_TTS_V3://ttn@000013',
        network_name: 'TTN V3',
        gateway_layer_name: 'TTN V3 Gateways',
        default_shown: false
    },
];

var gateway_layers = [];

// Cache to know which z5 tiles of gateways have already been fetched.
const z5cache = [];

setUp().then(r => {
});

async function setUp() {
    $("#legend").load("/legend.html");
    $("#legend").css({visibility: "visible"});

    await initMap();

    addBackgroundLayers();
    addForegroundLayers();
    // getGatewaysInView();

    // gatewayMarkers.addTo(map);
    //gatewayMarkersNoCluster.addTo(map);
}

// Callback to refresh layers when the maps was panned or zoomed
function boundsChangedCallback() {
    // Refresh the visible gateways, which will also trigger a layer refresh
    // getGatewaysInView();
    if (map.getZoom() >= 7) {
        // loadGatewaysBetweenLongitudes();
        // loadGatewaysInView();
        loadNewZ5Tiles();
    } else {
        // markers.clearLayers();
    }
}

function addForegroundLayers() {
    var tms_url = 'https://tms.ttnmapper.org/circles/network/{networkid}/{z}/{x}/{y}.png';

    for (const network of networks) {
        var coveragetiles = L.tileLayer(tms_url, {
            networkid: encodeURIComponent(network.network_id),
            maxNativeZoom: 19,
            maxZoom: 20,
            zIndex: 10,
            opacity: 0.5
        });
        layerControl.addOverlay(coveragetiles, network.network_name + " Heatmap");
        if (network.default_shown) {
            coveragetiles.addTo(map);
        }

        CreateGatewayLayers(network);
    }

    setTimeout(boundsChangedCallback, 1000);
}

function CreateGatewayLayers(network) {
    console.log(network.network_name, network.default_shown);

    const markers = L.markerClusterGroup({
        spiderfyOnMaxZoom: true,
        // showCoverageOnHover: false,
        // zoomToBoundsOnClick: false,
        maxClusterRadius: 50,
        chunkedLoading: true,
        chunkInterval: 100, // default=200
        chunkDelay: 100, //default=50
    });

    layerControl.addOverlay(markers, network.gateway_layer_name);
    if (network.default_shown) {
        markers.addTo(map);
    }

    gateway_layers[network.network_id] = markers;
}

function lon2tile(lon, zoom) {
    return (Math.floor((lon + 180) / 360 * Math.pow(2, zoom)));
} // x
function lat2tile(lat, zoom) {
    return (Math.floor((1 - Math.log(Math.tan(lat * Math.PI / 180) + 1 / Math.cos(lat * Math.PI / 180)) / Math.PI) / 2 * Math.pow(2, zoom)));
} // y
function tile2lon(x, z) {
    return (x / Math.pow(2, z) * 360 - 180);
}

function tile2lat(y, z) {
    const n = Math.PI - 2 * Math.PI * y / Math.pow(2, z);
    return (180 / Math.PI * Math.atan(0.5 * (Math.exp(n) - Math.exp(-n))));
}

function loadNewZ5Tiles() {
    for (const network of networks) {
        const network_id = network.network_id; //'NS_HELIUM://000024';
        console.log("Loading gateways for ", network_id)

        const west = map.getBounds().getWest();
        const east = map.getBounds().getEast();
        const north = map.getBounds().getNorth();
        const south = map.getBounds().getSouth();

        const minX = lon2tile(west, 5);
        const maxX = lon2tile(east, 5);
        const minY = lat2tile(north, 5);
        const maxY = lat2tile(south, 5);

        for (let x = minX; x <= maxX; x++) {
            for (let y = minY; y <= maxY; y++) {

                // Create cache if it does not exist
                if (z5cache[network.network_id] === undefined) {
                    z5cache[network.network_id] = [];
                }
                if (z5cache[network.network_id][x] === undefined) {
                    z5cache[network.network_id][x] = [];
                }

                if (z5cache[network.network_id][x][y] === undefined) {
                    console.log("Getting gateways in", x, y);
                    z5cache[network.network_id][x][y] = true;

                    // document.getElementById('progress').style.display = 'block'; // show - use this for block elements (div, p)

                    fetch("https://api.ttnmapper.org/network/" + encodeURIComponent(network_id) + "/gateways/z5tile/" + x + "/" + y)
                        .then(response => {
                            return response.json();
                        })
                        .then(data => {

                            for (const gateway of data) {
                                let lastHeardDate = Date.parse(gateway.last_heard);

                                // Only add gateways last heard in past 5 days
                                if (lastHeardDate > (Date.now() - (5 * 24 * 60 * 60 * 1000))) {
                                    let marker = L.marker(
                                        [gateway.latitude, gateway.longitude],
                                        {
                                            icon: iconByNetworkId(network_id, lastHeardDate)
                                        });
                                    const gwDescriptionHead = popUpHeader(gateway);
                                    const gwDescription = popUpDescription(gateway);
                                    marker.bindPopup(`${gwDescriptionHead}<br>${gwDescription}`);
                                    gateway_layers[network.network_id].addLayer(marker);
                                }
                            }
                            // document.getElementById('progress').style.display = 'none'; // hide
                        }).catch(reason => {
                        console.log("Fetch error", reason);
                        // document.getElementById('progress').style.display = 'none'; // hide
                    });
                }
            }
        }
    }
}


