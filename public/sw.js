// Importar Dexie para manejar la base de datos desde el Service Worker
importScripts('https://cdn.jsdelivr.net/npm/dexie@latest/dist/dexie.js');

const CACHE_NAME = 'encuestador-v1.5'; // Incrementado para forzar la actualización
const DYNAMIC_CACHE = 'dynamic-encuestador-v1.5';
const STATIC_ASSETS = [
    '/home',
    '/formularios',
    '/perfil',
    '/js/offline_handler.js',
    'https://cdn.jsdelivr.net/npm/dexie@latest/dist/dexie.js'
];

// 1. Instalación: Guardar archivos estáticos básicos
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            console.log('PWA: Caché estático v1.5 guardado');
            return cache.addAll(STATIC_ASSETS);
        })
    );
    self.skipWaiting();
});

// 2. Activación: Limpieza de cachés antiguos
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.filter(key => key !== CACHE_NAME && key !== DYNAMIC_CACHE)
                    .map(key => caches.delete(key))
            );
        })
    );
    self.clients.claim();
});

// 3. Estrategia de Carga: Network First con fallback a Caché Dinámico
self.addEventListener('fetch', event => {
    if (event.request.method !== 'GET') return;

    event.respondWith(
        fetch(event.request)
            .then(networkResponse => {
                return caches.open(DYNAMIC_CACHE).then(cache => {
                    cache.put(event.request.url, networkResponse.clone());
                    return networkResponse;
                });
            })
            .catch(() => {
                return caches.match(event.request).then(cachedResponse => {
                    if (cachedResponse) return cachedResponse;

                    return new Response(
                        '<div style="text-align:center; padding:20px; font-family:sans-serif;">' +
                        '<h2>Encuesta no disponible offline</h2>' +
                        '<p>Por favor, sincroniza tus encuestas con internet antes de salir al campo.</p>' +
                        '<a href="/formularios" style="color:#f44336; font-weight:bold;">Regresar a la lista</a></div>',
                        { headers: { 'Content-Type': 'text/html; charset=utf-8' } }
                    );
                });
            })
    );
});

// 4. Sincronización de fondo (Background Sync)
self.addEventListener('sync', event => {
    if (event.tag === 'sync-encuestas') {
        event.waitUntil(enviarDatosPendientes());
    }
});

async function enviarDatosPendientes() {
    const db = new Dexie("PanelEncuestadorDB");
    db.version(3).stores({
        encuestas: '++id, data, timestamp',
        ubicaciones: '++id, data, timestamp',
        lista_maestra: 'id_encuesta, titulo, descripcion, activa'
    });

    if (!db.isOpen()) await db.open();

    // --- Sincronización de Encuestas (Procesamiento Secuencial) ---
    const encuestasPendientes = await db.encuestas.toArray();
    console.log(`PWA: Detectadas ${encuestasPendientes.length} encuestas para sincronizar.`);

    for (const e of encuestasPendientes) {
        try {
            const res = await fetch('/encuestas/guardar', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' 
                },
                body: JSON.stringify(e.data)
            });

            if (res.ok) {
                // Solo eliminamos si el servidor confirma recepción (Status 200)
                await db.encuestas.delete(e.id);
                console.log(`PWA: Encuesta #${e.id} sincronizada y eliminada.`);
            } else {
                console.warn(`PWA: El servidor rechazó la encuesta #${e.id}. Status: ${res.status}`);
            }
        } catch (err) { 
            console.error("PWA: Error de conexión durante el bucle. Reintentando más tarde.", err);
            return; // Detenemos el bucle si se pierde la conexión a mitad del proceso
        }
    }

    // --- Sincronización de Ubicaciones GPS (Envío por lote) ---
    const puntosGPS = await db.ubicaciones.toArray();
    if (puntosGPS.length > 0) {
        try {
            const res = await fetch('/encuestador/guardar_ubicacion_monitoreo', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ puntos: puntosGPS.map(u => u.data) })
            });
            if (res.ok) {
                await db.ubicaciones.clear();
                console.log("PWA: Historial GPS sincronizado correctamente.");
            }
        } catch (err) { 
            console.error("PWA: Fallo sincronización GPS:", err); 
        }
    }
}