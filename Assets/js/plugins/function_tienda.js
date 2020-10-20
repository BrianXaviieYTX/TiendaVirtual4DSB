// 
mapboxgl.accessToken = 'pk.eyJ1IjoiYnJpYW54YXZpZXJjYnMiLCJhIjoiY2tmOGNpOWljMGF2NTJ4cnE4aHp6ZWZ3YSJ9.9njMW5tPZloGrhHyptDlNg';
let map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [0.040200, -78.142180],
    zoom: 15
});
map.addControl(new mapboxgl.NavigationControl());