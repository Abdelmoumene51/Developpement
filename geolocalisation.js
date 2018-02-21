var coords = "";
String.prototype.setCharAt = function(index,chr) {
	if(index > this.length-1) return str;
	return this.substr(0,index) + chr + this.substr(index+1);
}
function getLocation() {
	return new Promise(function(resolve)
	{
		if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
				console.log("loca")
				resolve(position.coords.latitude + ';' + position.coords.longitude);
			},null,{maximumAge:Infinity, timeout:10000, enableHighAccuracy:true});
		}
		else {
			x.innerHTML = "Geolocation is not supported by this browser.";
			resolve("");
		}
	});
}
async function computeDistanceWithAdress(adresse,ville)
{
	var gpsActuel,gpsObjet;
    gpsActuel = await getLocation();
	console.log(ville);
	gpsObjet = await getCoords(adresse,ville,"FR");
	coords = "";
	return computeDistance(gpsActuel,gpsObjet);
}
function computeDistance(coords1,coords2)
{
	console.log(coords1);
	var earth_radius = 6378.137;
	var rlat1 = Math.PI * parseFloat(coords1.substring(0,coords1.indexOf(";")))/180;
	var rlng1 = Math.PI * parseFloat(coords1.substring(coords1.indexOf(";")+1))/180;
	var rlat2 = Math.PI * parseFloat(coords2.substring(0,coords2.indexOf(";")))/180;
	var rlng2 = Math.PI * parseFloat(coords2.substring(coords2.indexOf(";")+1))/180;
	var distLon = (rlng2 - rlng1)/2
	var distLat = (rlat2 - rlat1)/2
	var dist = (Math.sin(distLat) * Math.sin(distLat)) + Math.cos(rlat1) * Math.cos(rlat2) * (Math.sin(distLon) * Math.sin(distLon));
	dist = (2*Math.atan2(Math.sqrt(dist),Math.sqrt(1-dist))) * earth_radius;
		console.log(dist);
	return dist;
}
function getDistance()
{
	var coords1 = document.getElementById('coord1').value;
	var coords2 = document.getElementById('coord2').value;
	document.getElementById('result').innerHTML = computeDistance(document.getElementById('coord1').value,document.getElementById('coord2').value);
}
function getCoords(adresse,ville,codePays) {
	var finalAdresse = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
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
			response.json().then(obj => 
			{
				obj = obj["results"][0]["geometry"]["location"]["lat"] + ';' + obj["results"][0]["geometry"]["location"]["lng"];
				resolve(obj);
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