/**
 * PWA Offline Handler - Panel de Encuestador v1.6
 * Maneja la persistencia local con Dexie.js y el ciclo de vida del Service Worker.
 */

// 1. Configuración de la Base de Datos Local (IndexedDB)
// Mantenemos la versión 3 para asegurar la existencia de 'lista_maestra'
const db = new Dexie("PanelEncuestadorDB");
db.version(3).stores({
    encuestas: '++id, data, timestamp',     // Formularios guardados sin internet
    ubicaciones: '++id, data, timestamp',   // Historial de coordenadas GPS
    lista_maestra: 'id_encuesta, titulo, descripcion, activa' // Lista oficial de encuestas
});

// 2. Registro y Control del Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => {
                console.log("PWA: Service Worker activo. Scope:", reg.scope);
                
                /**
                 * TRUCO DE ACTUALIZACIÓN:
                 * Fuerza al navegador a revisar si hay una versión nueva (v1.6) 
                 * en el servidor cada vez que se carga la página.
                 */
                reg.update();

                // Intentar sincronización de fondo si el navegador lo soporta
                if (navigator.onLine && reg.sync) {
                    reg.sync.register('sync-encuestas');
                }
            })
            .catch(err => console.error("PWA: Error al registrar SW:", err));
    });
}

// 3. Interceptor de Formularios (Guardado Offline)
document.addEventListener('submit', async (e) => {
    // Detectamos la ruta de guardado de CodeIgniter 4
    if (e.target.action.includes('encuestas/guardar')) {
        
        if (!navigator.onLine) {
            e.preventDefault(); 
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());

            // Adjuntar ID de usuario desde el campo oculto para evitar pérdida de sesión
            const idUsuarioElement = document.getElementById('id_usuario_sesion');
            if (idUsuarioElement) {
                data.id_usuario = idUsuarioElement.value;
            }

            try {
                // Guardar en Dexie (Almacenamiento local persistente)
                await db.encuestas.add({ 
                    data: data, 
                    timestamp: Date.now() 
                });

                // Registrar evento de sincronización para cuando vuelva el internet
                const reg = await navigator.serviceWorker.ready;
                if (reg.sync) {
                    await reg.sync.register('sync-encuestas');
                }

                alert("¡Guardado localmente! La encuesta se enviará automáticamente cuando recuperes la conexión.");
                
                // Redirección a la lista para seguir trabajando
                window.location.href = '/formularios';
                
            } catch (error) {
                console.error("PWA: Error en IndexedDB:", error);
                alert("Error crítico: No se pudo guardar la encuesta en el dispositivo.");
            }
        }
    }
});

/**
 * 4. Gestión de Geolocalización Offline
 * Captura y almacena coordenadas incluso sin señal de red.
 */
async function registrarUbicacionOffline(lat, lng) {
    const dataUbicacion = {
        latitud: lat,
        longitud: lng,
        time: Date.now()
    };

    if (navigator.onLine) {
        try {
            // Intento de envío en tiempo real
            await fetch('/encuestador/guardar_ubicacion_monitoreo', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dataUbicacion)
            });
        } catch (e) {
            respaldarUbicacionLocal(dataUbicacion);
        }
    } else {
        respaldarUbicacionLocal(dataUbicacion);
    }
}

async function respaldarUbicacionLocal(data) {
    try {
        await db.ubicaciones.add({
            data: data,
            timestamp: Date.now()
        });
        console.log("PWA: Coordenada GPS guardada en el dispositivo (Modo Offline).");
    } catch (err) {
        console.error("PWA: Error al respaldar GPS localmente:", err);
    }
}