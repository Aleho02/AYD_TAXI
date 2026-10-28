@extends('layouts.app')

@section('title', 'Panel Pasajero')

@section('content')
<!-- Leaflet CSS & JS para Geolocalización en Tiempo Real -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.85rem; font-weight: 800;">Panel del Pasajero</h1>
    <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.25rem;">
        Bienvenido/a, {{ $passenger->name }}. Selecciona tu origen y destino en el mapa geoespacial del Valle de Ubaté o escribe la dirección para solicitar tu taxi.
    </p>
</div>

<!-- Formulario + Mapa Geoespacial para Solicitar Taxi -->
<div class="card" style="margin-bottom: 1.5rem; border-color: rgba(245, 158, 11, 0.4);">
    <div class="card-header" style="flex-wrap: wrap; gap: 0.75rem;">
        <h3 class="card-title"><i class="bi bi-geo-alt-fill" style="color: var(--primary); margin-right: 0.5rem;"></i> Solicitar un Taxi con Geolocalización GPS</h3>
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <span class="status-badge status-success"><i class="bi bi-broadcast"></i> Satélite Ubaté Activo</span>
            <span class="brand-badge">Base $5.000 + $1.500/km</span>
        </div>
    </div>

    <!-- Controles del Mapa Interactivo -->
    <div style="display: flex; flex-wrap: wrap; gap: 0.65rem; align-items: center; justify-content: space-between; margin-bottom: 0.85rem; background: rgba(15, 23, 42, 0.55); padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid var(--border-color);">
        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center;">
            <span style="font-size: 0.82rem; color: var(--text-muted); font-weight: 600;">Modo de clic en el mapa:</span>
            <button type="button" id="btnModeOrigin" class="btn btn-primary btn-sm" onclick="setMapMode('origin')">
                <i class="bi bi-geo-alt-fill"></i> 1. Marcar Origen (Recogida)
            </button>
            <button type="button" id="btnModeDest" class="btn btn-secondary btn-sm" onclick="setMapMode('destination')">
                <i class="bi bi-flag-fill"></i> 2. Marcar Destino
            </button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="useMyGPSLocation()" title="Obtener ubicación actual del navegador">
                <i class="bi bi-crosshair"></i> Usar mi GPS actual
            </button>
            <a id="btnOpenGoogleMaps" href="https://www.google.com/maps/dir/?api=1&origin=5.3080,-73.8150&destination=5.3165,-73.8210&travelmode=driving" target="_blank" rel="noopener" class="btn btn-secondary btn-sm" style="background-color: #2563eb; color: #fff;" title="Abrir navegación paso a paso en Google Maps">
                <i class="bi bi-google"></i> Abrir en Google Maps
            </a>
        </div>

        <div id="nearestTaxiBanner" style="font-size: 0.82rem; color: #34d399; font-weight: 600;">
            <i class="bi bi-taxi-front-fill"></i> Calculando taxi más cercano...
        </div>
    </div>

    <!-- Mapa Leaflet Valle de Ubaté -->
    <div id="ubateMap" style="width: 100%; height: 340px; border-radius: 10px; border: 1px solid var(--border-color); margin-bottom: 1.25rem; z-index: 1;"></div>

    <!-- Puntos rápidos de referencia en Ubaté -->
    <div style="display: flex; flex-wrap: wrap; gap: 0.45rem; align-items: center; margin-bottom: 1.25rem; font-size: 0.78rem;">
        <span style="color: var(--text-muted); font-weight: 600;"><i class="bi bi-lightning-charge-fill" style="color: var(--primary);"></i> Puntos rápidos Ubaté:</span>
        <button type="button" class="btn btn-secondary btn-sm" style="padding: 0.2rem 0.55rem; font-size: 0.75rem;" onclick="setPresetLocation(5.3080, -73.8150, 'Parque Principal de Ubaté, Cra. 7')">Parque Principal</button>
        <button type="button" class="btn btn-secondary btn-sm" style="padding: 0.2rem 0.55rem; font-size: 0.75rem;" onclick="setPresetLocation(5.3165, -73.8210, 'Hospital El Salvador de Ubaté, Cl. 10')">Hospital El Salvador</button>
        <button type="button" class="btn btn-secondary btn-sm" style="padding: 0.2rem 0.55rem; font-size: 0.75rem;" onclick="setPresetLocation(5.3042, -73.8178, 'Terminal de Transportes de Ubaté')">Terminal de Transportes</button>
        <button type="button" class="btn btn-secondary btn-sm" style="padding: 0.2rem 0.55rem; font-size: 0.75rem;" onclick="setPresetLocation(5.3086, -73.8142, 'Basílica Menor del Santo Cristo de Ubaté')">Basílica Menor</button>
        <button type="button" class="btn btn-secondary btn-sm" style="padding: 0.2rem 0.55rem; font-size: 0.75rem;" onclick="setPresetLocation(5.3128, -73.8115, 'Universidad de Cundinamarca - Sede Ubaté')">Univ. Cundinamarca</button>
        <button type="button" class="btn btn-secondary btn-sm" style="padding: 0.2rem 0.55rem; font-size: 0.75rem;" onclick="setPresetLocation(5.3060, -73.8130, 'Plaza de Mercado de Ubaté')">Plaza de Mercado</button>
    </div>

    <form action="{{ route('pasajero.trips.store') }}" method="POST" id="requestTaxiForm">
        @csrf
        <input type="hidden" id="origin_latitude" name="origin_latitude" value="{{ old('origin_latitude', '5.3080000') }}">
        <input type="hidden" id="origin_longitude" name="origin_longitude" value="{{ old('origin_longitude', '-73.8150000') }}">
        <input type="hidden" id="destination_latitude" name="destination_latitude" value="{{ old('destination_latitude', '5.3165000') }}">
        <input type="hidden" id="destination_longitude" name="destination_longitude" value="{{ old('destination_longitude', '-73.8210000') }}">

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; align-items: start;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="origin_address" class="form-label">
                    <span style="color: #10b981;">●</span> Dirección de Origen (Recogida)
                </label>
                <input type="text" id="origin_address" name="origin_address" class="form-control" value="{{ old('origin_address', 'Parque Principal de Ubaté, Cra. 7') }}" placeholder="Selecciona en el mapa o escribe aquí" required>
                <div id="originCoordsLabel" style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.25rem; font-family: monospace;">
                    GPS: 5.3080, -73.8150
                </div>
                @error('origin_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="destination_address" class="form-label">
                    <span style="color: #ef4444;">●</span> Dirección de Destino
                </label>
                <input type="text" id="destination_address" name="destination_address" class="form-control" value="{{ old('destination_address', 'Hospital El Salvador de Ubaté, Cl. 10') }}" placeholder="Selecciona en el mapa o escribe aquí" required>
                <div id="destCoordsLabel" style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.25rem; font-family: monospace;">
                    GPS: 5.3165, -73.8210
                </div>
                @error('destination_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="distance_km" class="form-label">Distancia Calculada (km)</label>
                <input type="number" step="0.01" min="0.1" max="150" id="distance_km" name="distance_km" class="form-control" value="{{ old('distance_km', '2.4') }}" required>
                <div id="durationPreview" style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.25rem;">
                    Tiempo est. de viaje: ~5 min
                </div>
                @error('distance_km')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="driver_id" class="form-label">Conductor Asignado / Cercano</label>
                <select id="driver_id" name="driver_id" class="form-control">
                    <option value="">Asignar cualquier conductor cercano</option>
                    @foreach($availableDrivers as $driver)
                        <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                            {{ $driver->name }} {{ $driver->vehicle ? '(' . $driver->vehicle->license_plate . ')' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('driver_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.06);">
            <div style="display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap;">
                <div>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Tarifa Estimada (Haversine):</span>
                    <span id="farePreview" style="font-size: 1.35rem; font-weight: 800; color: var(--primary); margin-left: 0.4rem;">$8.600 COP</span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 0.7rem 1.5rem; font-size: 0.95rem;">
                <i class="bi bi-send-fill"></i> Solicitar Servicio Ahora
            </button>
        </div>
    </form>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Conductores cercanos en Ubaté -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Taxis Disponibles Cercanos</h3>
            <span class="status-badge status-success">GPS Activo</span>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.85rem;">
            @forelse($availableDrivers as $driver)
                <div style="display: flex; align-items: center; justify-content: space-between; background: rgba(15, 23, 42, 0.4); padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid var(--border-color);">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        @if($driver->photo_path)
                            <img src="{{ asset('storage/' . $driver->photo_path) }}" alt="{{ $driver->name }}" class="avatar">
                        @else
                            <div class="avatar">{{ substr($driver->name, 0, 1) }}</div>
                        @endif
                        <div>
                            <div style="font-weight: 600; font-size: 0.9rem;">{{ $driver->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">
                                Placa: {{ $driver->vehicle ? $driver->vehicle->license_plate : 'En proceso' }} | {{ $driver->vehicle ? $driver->vehicle->model : '' }}
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="status-badge status-success">Disponible</span>
                        <button type="button" class="btn btn-primary btn-sm" onclick="selectDriver({{ $driver->id }})" title="Seleccionar este conductor">
                            Elegir
                        </button>
                    </div>
                </div>
            @empty
                <p style="color: var(--text-muted); text-align: center; padding: 1rem;">No hay taxis disponibles en este instante en la zona.</p>
            @endforelse
        </div>
    </div>

    <!-- Historial de Viajes del Pasajero -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mis Viajes Recientes</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Origen / Destino</th>
                        <th>Conductor</th>
                        <th>Tarifa Est.</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trips as $trip)
                        <tr>
                            <td>
                                <div style="font-weight: 600; font-size: 0.88rem;">{{ $trip->origin_address }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);"><i class="bi bi-arrow-right"></i> {{ $trip->destination_address }} ({{ $trip->distance_km }} km)</div>
                            </td>
                            <td style="font-size: 0.82rem; color: var(--text-muted);">
                                {{ $trip->driver ? $trip->driver->name : 'Por asignar' }}
                            </td>
                            <td style="font-weight: 700; color: var(--primary);">${{ number_format($trip->estimated_fare, 0, ',', '.') }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                    @if($trip->status === 'completado')
                                        <span class="status-badge status-success">Completado</span>
                                    @elseif($trip->status === 'cancelado')
                                        <span class="status-badge status-danger">Cancelado</span>
                                    @elseif($trip->status === 'en_camino')
                                        <span class="status-badge status-warning">En camino</span>
                                    @elseif($trip->status === 'solicitado')
                                        <span class="status-badge status-info">Solicitado</span>
                                    @else
                                        <span class="status-badge status-info">{{ ucfirst($trip->status) }}</span>
                                    @endif

                                    @if(in_array($trip->status, ['solicitado', 'aceptado', 'en_camino']))
                                        <form action="{{ route('pasajero.trips.cancel', $trip) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro/a de que deseas cancelar este servicio de taxi?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Cancelar servicio">
                                                <i class="bi bi-x-circle"></i> Cancelar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 1.5rem;">No has realizado viajes aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const availableDrivers = @json($availableDrivers);
    let currentMapMode = 'origin';

    // Inicializar Mapa en Villa de San Diego de Ubaté vinculado con capas de Google Maps
    const googleStreets = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: '&copy; Google Maps - Valle de Ubaté'
    });

    const googleHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: '&copy; Google Maps Satélite - Valle de Ubaté'
    });

    const openStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    });

    const map = L.map('ubateMap', {
        center: [5.3110, -73.8165],
        zoom: 15,
        layers: [googleStreets]
    });

    L.control.layers({
        "Google Maps (Calles)": googleStreets,
        "Google Satélite (Híbrido)": googleHybrid,
        "OpenStreetMap": openStreetMap
    }, null, { position: 'topright' }).addTo(map);

    // Iconos personalizados
    const originIcon = L.divIcon({
        className: '',
        html: '<div style="background:#10b981;color:#fff;width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.5);font-weight:800;font-size:13px;">A</div>',
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });

    const destIcon = L.divIcon({
        className: '',
        html: '<div style="background:#ef4444;color:#fff;width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.5);font-weight:800;font-size:13px;">B</div>',
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });

    const taxiIcon = L.divIcon({
        className: '',
        html: '<div style="background:#f59e0b;color:#000;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #000;box-shadow:0 2px 8px rgba(0,0,0,0.6);font-size:16px;"><i class="bi bi-taxi-front-fill"></i></div>',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    });

    // Marcadores de Origen y Destino arrastrables
    let originMarker = L.marker([5.3080, -73.8150], { draggable: true, icon: originIcon })
        .addTo(map)
        .bindPopup('<b>Punto de Recogida (Origen)</b>');

    let destMarker = L.marker([5.3165, -73.8210], { draggable: true, icon: destIcon })
        .addTo(map)
        .bindPopup('<b>Punto de Destino</b>');

    let routeOutline = L.polyline([], {
        color: '#0f172a',
        weight: 8,
        opacity: 0.7,
        lineCap: 'round',
        lineJoin: 'round'
    }).addTo(map);

    let routeLine = L.polyline([], {
        color: '#f59e0b',
        weight: 5,
        opacity: 0.95,
        lineCap: 'round',
        lineJoin: 'round'
    }).addTo(map);

    // Mostrar conductores disponibles en el mapa
    availableDrivers.forEach(driver => {
        const lat = parseFloat(driver.latitude || 5.3114);
        const lng = parseFloat(driver.longitude || -73.8182);
        const plate = driver.vehicle ? driver.vehicle.license_plate : 'Sin placa';
        L.marker([lat, lng], { icon: taxiIcon })
            .addTo(map)
            .bindPopup(`<b>${driver.name}</b><br>Taxi: ${plate}<br><button type="button" onclick="selectDriver(${driver.id})" style="margin-top:5px;padding:3px 8px;background:#f59e0b;border:none;border-radius:4px;cursor:pointer;font-weight:700;">Elegir este taxi</button>`);
    });

    function calculateHaversineKm(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function setMapMode(mode) {
        currentMapMode = mode;
        const btnOrigin = document.getElementById('btnModeOrigin');
        const btnDest = document.getElementById('btnModeDest');
        if (mode === 'origin') {
            btnOrigin.className = 'btn btn-primary btn-sm';
            btnDest.className = 'btn btn-secondary btn-sm';
        } else {
            btnOrigin.className = 'btn btn-secondary btn-sm';
            btnDest.className = 'btn btn-primary btn-sm';
        }
    }

    async function reverseGeocode(lat, lng, inputId) {
        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
            const data = await res.json();
            if (data && data.display_name) {
                const parts = data.display_name.split(',').slice(0, 3).join(',');
                document.getElementById(inputId).value = parts;
            }
        } catch (e) {
            // Si falla la red, conserva el nombre o coordenadas
        }
    }

    let routingRequestId = 0;

    async function syncGeolocationData() {
        const oPos = originMarker.getLatLng();
        const dPos = destMarker.getLatLng();

        document.getElementById('origin_latitude').value = oPos.lat.toFixed(7);
        document.getElementById('origin_longitude').value = oPos.lng.toFixed(7);
        document.getElementById('destination_latitude').value = dPos.lat.toFixed(7);
        document.getElementById('destination_longitude').value = dPos.lng.toFixed(7);

        document.getElementById('originCoordsLabel').textContent = `GPS: ${oPos.lat.toFixed(4)}, ${oPos.lng.toFixed(4)}`;
        document.getElementById('destCoordsLabel').textContent = `GPS: ${dPos.lat.toFixed(4)}, ${dPos.lng.toFixed(4)}`;

        const gmapsBtn = document.getElementById('btnOpenGoogleMaps');
        if (gmapsBtn) {
            gmapsBtn.href = `https://www.google.com/maps/dir/?api=1&origin=${oPos.lat.toFixed(6)},${oPos.lng.toFixed(6)}&destination=${dPos.lat.toFixed(6)},${dPos.lng.toFixed(6)}&travelmode=driving`;
        }

        updateNearestTaxiBanner(oPos.lat, oPos.lng);

        const currentReq = ++routingRequestId;
        try {
            // Consultar motor de enrutamiento vial OSRM para seguir calles y carreras reales
            const url = `https://router.project-osrm.org/route/v1/driving/${oPos.lng},${oPos.lat};${dPos.lng},${dPos.lat}?overview=full&geometries=geojson&steps=true`;
            const response = await fetch(url);
            const data = await response.json();

            if (currentReq !== routingRequestId) return;

            if (data && data.code === 'Ok' && data.routes && data.routes.length > 0) {
                const route = data.routes[0];
                // Convertir coordenadas GeoJSON [lng, lat] a Leaflet [lat, lng]
                const streetCoords = route.geometry.coordinates.map(coord => [coord[1], coord[0]]);
                routeOutline.setLatLngs(streetCoords);
                routeLine.setLatLngs(streetCoords);

                // Distancia vial exacta por las calles (en km) y duración real
                const roadDistKm = Math.max(0.2, route.distance / 1000);
                const roadDurationMin = Math.max(2, Math.ceil(route.duration / 60));

                document.getElementById('distance_km').value = roadDistKm.toFixed(2);
                updateFarePreview(roadDurationMin);
                return;
            }
        } catch (err) {
            // Fallback en caso de no haber conexión al servidor de rutas
        }

        // Fallback si OSRM no responde
        routeOutline.setLatLngs([oPos, dPos]);
        routeLine.setLatLngs([oPos, dPos]);
        const distKm = Math.max(0.2, calculateHaversineKm(oPos.lat, oPos.lng, dPos.lat, dPos.lng));
        document.getElementById('distance_km').value = distKm.toFixed(2);
        updateFarePreview();
    }

    function updateNearestTaxiBanner(lat, lng) {
        const banner = document.getElementById('nearestTaxiBanner');
        if (!availableDrivers || availableDrivers.length === 0) {
            banner.innerHTML = '<span style="color:#f87171;">Sin taxis activos en este instante</span>';
            return;
        }
        let nearest = null;
        let minDist = Infinity;
        availableDrivers.forEach(d => {
            const dLat = parseFloat(d.latitude || 5.3114);
            const dLng = parseFloat(d.longitude || -73.8182);
            const dist = calculateHaversineKm(lat, lng, dLat, dLng);
            if (dist < minDist) {
                minDist = dist;
                nearest = d;
            }
        });
        if (nearest) {
            const eta = Math.max(1, Math.ceil(minDist * 2));
            const plate = nearest.vehicle ? nearest.vehicle.license_plate : '';
            banner.innerHTML = `<i class="bi bi-taxi-front-fill"></i> Taxi más cercano: <b>${nearest.name} (${plate})</b> a ${minDist.toFixed(2)} km (~${eta} min)`;
        }
    }

    map.on('click', function (e) {
        if (currentMapMode === 'origin') {
            originMarker.setLatLng(e.latlng);
            reverseGeocode(e.latlng.lat, e.latlng.lng, 'origin_address');
            setMapMode('destination');
        } else {
            destMarker.setLatLng(e.latlng);
            reverseGeocode(e.latlng.lat, e.latlng.lng, 'destination_address');
        }
        syncGeolocationData();
    });

    originMarker.on('dragend', function () {
        const pos = originMarker.getLatLng();
        reverseGeocode(pos.lat, pos.lng, 'origin_address');
        syncGeolocationData();
    });

    destMarker.on('dragend', function () {
        const pos = destMarker.getLatLng();
        reverseGeocode(pos.lat, pos.lng, 'destination_address');
        syncGeolocationData();
    });

    function setPresetLocation(lat, lng, label) {
        const latlng = L.latLng(lat, lng);
        if (currentMapMode === 'origin') {
            originMarker.setLatLng(latlng);
            document.getElementById('origin_address').value = label;
            setMapMode('destination');
        } else {
            destMarker.setLatLng(latlng);
            document.getElementById('destination_address').value = label;
        }
        map.panTo(latlng);
        syncGeolocationData();
    }

    function useMyGPSLocation() {
        if (!navigator.geolocation) {
            alert('Tu navegador no soporta geolocalización GPS.');
            return;
        }
        navigator.geolocation.getCurrentPosition(
            function (pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                const latlng = L.latLng(lat, lng);
                originMarker.setLatLng(latlng);
                map.setView(latlng, 16);
                reverseGeocode(lat, lng, 'origin_address');
                syncGeolocationData();
                setMapMode('destination');
            },
            function () {
                alert('No se pudo obtener el GPS actual. Puedes hacer clic directamente en el mapa de Ubaté.');
            }
        );
    }

    function updateFarePreview(customMinutes = null) {
        const distInput = document.getElementById('distance_km');
        const farePreview = document.getElementById('farePreview');
        const durationPreview = document.getElementById('durationPreview');
        const dist = parseFloat(distInput.value) || 0;
        const rawFare = 5000 + (dist * 1500);
        const roundedFare = Math.max(6000, Math.round(rawFare / 100) * 100);
        const estMinutes = customMinutes !== null ? customMinutes : Math.max(3, Math.ceil(dist * 2));
        farePreview.textContent = '$' + roundedFare.toLocaleString('es-CO') + ' COP';
        if (durationPreview) {
            durationPreview.textContent = `Ruta óptima por calles: ~${estMinutes} min`;
        }
    }

    function selectDriver(driverId) {
        const driverSelect = document.getElementById('driver_id');
        driverSelect.value = driverId;
        const originInput = document.getElementById('origin_address');
        originInput.focus();
        originInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    document.getElementById('distance_km').addEventListener('input', updateFarePreview);
    syncGeolocationData();
</script>
@endsection
