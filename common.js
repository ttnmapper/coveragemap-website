var getParameters = getJsonFromUrl();

var loadedGateways = {};
var gatewaysInView = [];

var default_zoom = true;
var zoom_override = false;

var gatewayMarkersNoCluster = L.featureGroup();

var layerControl = null;

var map;

function initMap() {

  map = L.map('map');

  if(findGetParameter("lat")!=null && findGetParameter("lon")!=null && findGetParameter("zoom")!=null) {
    map.setView([ findGetParameter("lat"), findGetParameter("lon") ], findGetParameter("zoom"));
    default_zoom = false;
    zoom_override = true;
  }
  else {
    b = JSON.parse(localStorage.getItem('bounds'));
    if (b == null)
    {
      map.setView(initialCoords, initialZoom);
    }
    else {
      try {
        map.fitBounds([[b._southWest.lat%90,b._southWest.lng%180],[b._northEast.lat%90,b._northEast.lng%180]]);
        default_zoom = false;
      } catch (err) {
        map.setView(initialCoords, initialZoom);
      }
    }
  }

  map.on('dragend', boundsChanged);
  map.on('zoomend', boundsChanged);

  //disable inertia because it is irritating and slow
  map.options.inertia=false;

  L.control.measure({
    position: 'topleft'
  }).addTo(map);

  map.attributionControl.setPrefix("Data layers &copy; TTN Mapper");
}

function addBackgroundLayers() {
  // https: also suppported.
  var Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
    fadeAnimation: false
  });

  // https: also suppported.
  var Stamen_TonerLite = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}.{ext}', {
    attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> | Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    subdomains: 'abcd',
    minZoom: 0,
    maxZoom: 20,
    ext: 'png',
    fadeAnimation: false
  });

  // if(isTtnMapperOrg) {
  //   var OpenStreetMap_Mapnik_Grayscale = L.tileLayer('https://maps.iotdash.nl/osm/{z}/{x}/{y}.png', {
  //     maxZoom: 20,
  //     attribution: '<a href="https://www.skylab.nl" title="Powered by SkyLab B.V.">Powered by SkyLab B.V.</a> | <a href="https://www.openstreetmap.org" title="&copy; OpenStreetMap">&copy; OpenStreetMap</a>',
  //     fadeAnimation: false,
  //     className: 'toGrayscale'
  //   });
  // } else {
    var OpenStreetMap_Mapnik_Grayscale = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 20,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      fadeAnimation: false,
      className: 'toGrayscale'
    });
  // }

  // https: also suppported.
  var Esri_WorldShadedRelief = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Shaded_Relief/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Tiles &copy; Esri &mdash; Source: Esri',
    maxZoom: 13,
    fadeAnimation: false
  });

  // https: also suppported.
  var OpenStreetMap_Mapnik = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  // var OpenStreetMap_Mapnik = L.tileLayer('https://maps.iotdash.nl/osm/{z}/{x}/{y}.png', {
    maxZoom: 20,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    // attribution: '<a href="https://www.skylab.nl" title="Powered by SkyLab B.V.">Powered by SkyLab B.V.</a> | <a href="https://www.openstreetmap.org" title="&copy; OpenStreetMap">&copy; OpenStreetMap</a>',
    fadeAnimation: false
  });

  switch (findGetParameter("layer")) {
    case "mapnik":
      OpenStreetMap_Mapnik.addTo(map);
      break;
    case "mapnik_grayscale":
      OpenStreetMap_Mapnik_Grayscale.addTo(map);
      break;
    case "terrain":
      Esri_WorldShadedRelief.addTo(map);
      break;
    case "satellite":
      Esri_WorldImagery.addTo(map);
      break;
    default:
      // use default layer
      Stamen_TonerLite.addTo(map);
  }

  var layerControlOptions = {};
  if (L.Browser.android || L.Browser.mobile /*|| L.Browser.touch*/ || L.Browser.retina) {
    console.log("Mobile Browser");
    console.log(L.Browser.android, L.Browser.mobile, L.Browser.touch, L.Browser.retina);
    layerControlOptions.collapsed = true;
    $("#legend").css({ visibility: "hidden"});
  } else {
    layerControlOptions.collapsed = false;
    $("#legend").css({ visibility: "visible"});
  }

  layerControl = L.control.layers(
    {
      "Stamen TonerLite": Stamen_TonerLite,
      "OSM Mapnik Grayscale": OpenStreetMap_Mapnik_Grayscale,
      "Terrain": Esri_WorldShadedRelief, 
      "OSM Mapnik": OpenStreetMap_Mapnik,
      "Satellite": Esri_WorldImagery
    },
    {},
    layerControlOptions
    );
  layerControl.addTo(map);
}

//Create a map that remembers where it was zoomed to
function boundsChanged () {
  boundsChangedCallback();
  localStorage.setItem('bounds', JSON.stringify(map.getBounds()));
  default_zoom = false;
}

function findGetParameter(parameterName) {
  var result = null;
  var tmp = [];
  var items = location.search.substr(1).split("&");
  for (var index = 0; index < items.length; index++) {
    tmp = items[index].split("=");
    if (tmp[0] === parameterName) {
      result = decodeURIComponent(tmp[1]);
    }
  }
  return result;
}

function getJsonFromUrl(url) {
  if(!url) url = location.href;
  var question = url.indexOf("?");
  var hash = url.indexOf("#");
  if(hash==-1 && question==-1) return {};
  if(hash==-1) hash = url.length;
  var query = question==-1 || hash==question+1 ? url.substring(hash) : 
  url.substring(question+1,hash);
  var result = {};
  query.split("&").forEach(function(part) {
    if(!part) return;
    part = part.split("+").join(" "); // replace every + with space, regexp-free version
    var eq = part.indexOf("=");
    var key = eq>-1 ? part.substr(0,eq) : part;
    var val = eq>-1 ? decodeURIComponent(part.substr(eq+1)) : "";
    var from = key.indexOf("[");
    if(from==-1) result[decodeURIComponent(key)] = val;
    else {
      var to = key.indexOf("]",from);
      var index = decodeURIComponent(key.substring(from+1,to));
      key = decodeURIComponent(key.substring(0,from));
      if(!result[key]) result[key] = [];
      if(!index) result[key].push(val);
      else result[key][index] = val;
    }
  });
  return result;
}


function formatTime(timestamp)
{
  if(timestamp === undefined) {
  	return "unknown";
  }
  var date = new Date(timestamp*1000);
  return date.toISOString();
}

function getDistance(lat1, lon1, lat2, lon2) {
  Number.prototype.toRad = function() {
    return this * Math.PI / 180;
  }

  var R = 6371000; // metre
  //has a problem with the .toRad() method below.
  var x1 = lat2-lat1;
  var dLat = x1.toRad();  
  var x2 = lon2-lon1;
  var dLon = x2.toRad();  
  var a = Math.sin(dLat/2) * Math.sin(dLat/2) + 
                  Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) * 
                  Math.sin(dLon/2) * Math.sin(dLon/2);  
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c;

  return d;
}

function getColour(data) {

  // TODO: if we use signal to determine colour

  var rssi = Number(data["rssi"]);
  var snr = Number(data["snr"]);

  if(snr<0) {
    rssi = rssi + snr;
  }

  colour = "#0000ff";
  if (rssi==0)
  {
    colour = "black";
  }
  else if (rssi<-120)
  {
    colour = "blue";
  }
  else if (rssi<-115)
  {
    colour = "cyan";
  }
  else if (rssi<-110)
  {
    colour = "green";
  }
  else if (rssi<-105)
  {
    colour = "yellow";
  }
  else if (rssi<-100)
  {
    colour = "orange";
  }
  else
  {
    colour = "red";
  }

  return colour;
}


function iconByNetworkId(networkId, lastHeardDate) {
  if(lastHeardDate < (Date.now() - (48*60*60*1000)) ) { // 24 hours
    return gatewayMarkerOffline;
  }
  return gatewayMarkerOnline;
}

function popUpHeader(gateway) {
  let header = `<b>${he.encode(gateway.name)}</b>`;
  header = `${header}<br>ID: ${gateway.gateway_id}`;
  header = `${header}<br>Network: ${gateway.network_id}`;
  header = `${header}<br><a target="_blank" href="https://explorer.helium.com/hotspots/${gateway.gateway_id}">View in Explorer</a>`
  return header;
}

function popUpDescription(gateway) {
  let description = "";

  if(Date.parse(gateway.last_heard) < (Date.now() - (48*60*60*1000)) ) {
    description += `<br>currently offline`;
  }

  const lastHeardTime = moment(gateway.last_heard);
  description += `
<br>Last heard: ${lastHeardTime.tz(moment.tz.guess()).format("llll zz")}
<br>Lat, Lon: ${gateway.latitude}, ${gateway.longitude}
<br>Altitude: ${gateway.altitude}m
`;

  if(gateway.attributes.mode !== undefined) {
    description += `<br>Mode: ${gateway.attributes.mode}`;
  }
  if(gateway.attributes.timestamp_added !== undefined) {
    const added = moment.unix(gateway.attributes.timestamp_added / 1000000000);
    description += `<br>Added: ${added.tz(moment.tz.guess()).format("llll zz")}`;
  }

  description += `
<br>Show only this hotspot's coverage as: 
<ul>
  <li>
    <a target="_blank" href="/heatmap/gateway/?gateway=${he.encode(gateway.gateway_id)}&network=${he.encode(gateway.network_id)}">heatmap</a>
  </li>
</ul>
`;

  return description;
}
