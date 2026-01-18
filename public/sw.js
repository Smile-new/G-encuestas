// Importar Dexie para manejar la base de datos desde el Service Worker
importScripts('https://cdn.jsdelivr.net/npm/dexie@latest/dist/dexie.js');

const CACHE_NAME = 'encuestador-v1.3'; // Incrementamos a v1.3 para forzar la actualización en el navegador
const DYNAMIC_CACHE = 'dynamic-encuestador-v1.3';
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
            console.log('PWA: Caché estático guardado');
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
                        '<p>Debes abrir esta encuesta al menos una vez con internet para que se guarde en tu dispositivo.</p>' +
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
    // IMPORTANTE: La versión y los stores deben coincidir exactamente con offline_handler.js
    const db = new Dexie("PanelEncuestadorDB");
    db.version(2).stores({
        encuestas: '++id, data, timestamp',
        ubicaciones: '++id, data, timestamp'
    });

    // Sincronizar Encuestas
    const encuestas = await db.encuestas.toArray();
    for (const e of encuestas) {
        try {
            const res = await fetch('/encuestas/guardar', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(e.data)
            });
            if (res.ok) {
                await db.encuestas.delete(e.id);
                console.log("PWA: Encuesta sincronizada y eliminada de local.");
            }
        } catch (err) { 
            console.error("PWA: Error al sincronizar encuesta:", err); 
        }
    }

    // Sincronizar Ubicaciones (Batch)
    const ubicaciones = await db.ubicaciones.toArray();
    if (ubicaciones.length > 0) {
        try {
            const res = await fetch('/encuestador/guardar_ubicacion_monitoreo', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ puntos: ubicaciones.map(u => u.data) })
            });
            if (res.ok) {
                await db.ubicaciones.clear();
                console.log("PWA: Historial GPS sincronizado y limpiado.");
            }
        } catch (err) { 
            console.error("PWA: Error al sincronizar GPS:", err); 
        }
    }
}