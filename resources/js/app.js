import '../css/app.css';
import 'leaflet/dist/leaflet.css';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';

if (document.querySelector('[data-live-map]')) {
    import('./map/index.js');
}
