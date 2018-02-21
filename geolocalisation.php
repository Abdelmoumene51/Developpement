<script>
String.prototype.setCharAt = function(index,chr) {
	if(index > this.length-1) return str;
	return this.substr(0,index) + chr + this.substr(index+1);
}
function computeDistance(coords1,coords2)
{
	var earth_radius = 6378.137;
	var rlat1 = Math.PI * parseFloat(coords1.substring(0,coords1.indexOf(";")))/180;
	var rlng1 = Math.PI * parseFloat(coords1.substring(coords1.indexOf(";")+1))/180;
	var rlat2 = Math.PI * parseFloat(coords2.substring(0,coords2.indexOf(";")))/180;
	var rlng2 = Math.PI * parseFloat(coords2.substring(coords2.indexOf(";")+1))/180;
	var distLon = (rlng2 - rlng1)/2
	var distLat = (rlat2 - rlat1)/2
	var dist = (Math.sin(distLat) * Math.sin(distLat)) + Math.cos(rlat1) * Math.cos(rlat2) * (Math.sin(distLon) * Math.sin(distLon));
	dist = (2*Math.atan2(Math.sqrt(dist),Math.sqrt(1-dist))) * earth_radius;
	return dist;
}
function getLocation() {
	if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(getDistanceToCoords);
	} else {
		x.innerHTML = "Geolocation is not supported by this browser.";
	}
}
function getDistanceToCoords(position)
{
	var coords = position.coords.latitude + ';' + position.coords.longitude;
	console.log(coords);
	document.getElementById('result').innerHTML = computeDistance(coords,document.getElementById('coord3').value);
}
function getDistance()
{
	var coords1 = document.getElementById('coord1').value;
	var coords2 = document.getElementById('coord2').value;
	document.getElementById('result').innerHTML = computeDistance(document.getElementById('coord1').value,document.getElementById('coord2').value);
	//console.log(parseFloat(coords1.substring(0,coords1.indexOf(";")+1)));
}
function getCoords() {
	var adresse = document.getElementById('adresse').value;
	var finalAdresse = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
	var ville = document.getElementById('ville').value;
	var codePays = document.getElementById('code').value;
	for(var i=0 ; i<adresse.length; i++)
	{
		if(adresse.charAt(i) == ' ')
		{
			adresse = adresse.setCharAt(i,'+');
		}
	}
	finalAdresse += (adresse + (','));
	for(var i=0 ; i<ville.length; i++)
	{
		if(ville.charAt(i) == ' ')
		{
			ville = ville.setCharAt(i,'+');
		}
	}
	finalAdresse += (ville + ',+'+codePays);
	finalAdresse += '&key=AIzaSyDD289P5-HQDLIM7t2biWIroNHHtKH5lbI'
	let promise = new Promise((resolve, reject) => {
    fetch(finalAdresse).then(response => {
      if (response.ok) 
	  {
		const contentType = response.headers.get('Content-Type') || '';

		if (contentType.includes('application/json')) 
		{
			console.log(finalAdresse);
			response.json().then(obj => 
			{
				resolve(obj);
				document.getElementById('result').innerHTML = 'Coordonnées GPS : [' + obj["results"][0]["geometry"]["location"]["lat"] + ' ; ' + obj["results"][0]["geometry"]["location"]["lng"] + ']';
			}, error => {
				reject(new ResponseError('Invalid JSON: ' + error.message));
			});
		} 
		else if (contentType.includes('text/html')) 
		{
			response.text().then(html => {
			resolve({
				page_type: 'generic',
				html: html
			});
		}, error => {
			reject(new ResponseError('HTML error: ' + error.message));
			});
		} 
		else {
			reject(new ResponseError('Invalid content type: ' + contentType));
		}
      } 
	  else {
        if (response.status == 404) {
          reject(new NotFoundError('Page not found: ' + url));
        } else {
          reject(new HttpError('HTTP error: ' + response.status));
        }
      }
    }, error => {
      reject(new NetworkError(error.message));
    });
  });
  return promise;
}
function getAddress() 
{
	var finalAdresse = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=';
	finalAdresse += document.getElementById('gps').value;
	finalAdresse += '&key=AIzaSyDD289P5-HQDLIM7t2biWIroNHHtKH5lbI'
	let promise = new Promise((resolve, reject) => {
    fetch(finalAdresse).then(response => {
      if (response.ok) 
	  {
		const contentType = response.headers.get('Content-Type') || '';

		if (contentType.includes('application/json')) 
		{
			console.log(finalAdresse);
			response.json().then(obj => 
			{
				resolve(obj);
				document.getElementById('result').innerHTML = 'Adresse complète : ' + obj["results"][0]["formatted_address"];
			}, error => {
				reject(new ResponseError('Invalid JSON: ' + error.message));
			});
		} 
		else if (contentType.includes('text/html')) 
		{
			response.text().then(html => {
			resolve({
				page_type: 'generic',
				html: html
			});
		}, error => {
			reject(new ResponseError('HTML error: ' + error.message));
			});
		} 
		else {
			reject(new ResponseError('Invalid content type: ' + contentType));
		}
      } 
	  else {
        if (response.status == 404) {
          reject(new NotFoundError('Page not found: ' + url));
        } else {
          reject(new HttpError('HTTP error: ' + response.status));
        }
      }
    }, error => {
      reject(new NetworkError(error.message));
    });
  });
  return promise;
}
</script>
<h3>Entrer une adresse</h3>
<p>Adresse : <input type="text" id="adresse" /></p>
<p>Ville : <input type="text" id="ville" /></p>
<p>Code pays : <input type="text" id="code" /></p>
<button id="findGPS" onClick="getCoords()">Entrer</button>
<br>
<h3>Entrer des coordonnées GPS</h3>
<input type="text" id="gps" />
<button id="findAdress" onClick="getAddress()">Entrer</button>
<h3>Calculer distance</h3>
<input type="text" id="coord1" />
<input type="text" id="coord2" />
<button id="findAdress" onClick="getDistance()">Entrer</button>
<h3>Calculer distance à</h3>
GPS : <input type="text" id="coord3" /> 
<button id="getloc1" onClick="getLocation()">Entrer</button>
<p id="result"></p>