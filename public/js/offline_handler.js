/**
 * PWA Offline Handler para Panel de Encuestador
 * Maneja la persistencia local con Dexie.js y el registro del Service Worker.
 */

// 1. Configuración de la Base de Datos Local (IndexedDB)
// Se incrementa a versión 2 para aplicar cambios en el esquema sin errores
const db = new Dexie("PanelEncuestadorDB");
db.version(2).stores({
    encuestas: '++id, data, timestamp', // Tabla para formularios
    ubicaciones: '++id, data, timestamp' // Tabla para historial GPS
});

// 2. Registro del Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        // Registro desde la raíz para control total del scope
        navigator.serviceWorker.register('/sw.js')
            .then(reg => {
                console.log("PWA: Service Worker registrado con éxito. Scope:", reg.scope);
                
                // Intentar sincronización inicial al cargar si hay red
                if (navigator.onLine && reg.sync) {
                    reg.sync.register('sync-encuestas');
                }
            })
            .catch(err => {
                console.error("PWA: Error Crítico al registrar Service Worker:", err);
            });
    });
} else {
    console.error("PWA: Los Service Workers no son compatibles o el sitio no es seguro (Falta HTTPS).");
}

// 3. Interceptor Universal de Formularios
document.addEventListener('submit', async (e) => {
    // Verificamos que sea el formulario de guardar encuestas
    if (e.target.action.includes('encuestas/guardar')) {
        
        // Si no hay conexión, procesamos de forma local
        if (!navigator.onLine) {
            e.preventDefault(); 
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());

            /** * Captura del ID de usuario: Aseguramos que el ID vaya en el paquete,
             * ya que la sesión puede expirar durante la sincronización de fondo.
             */
            const idUsuarioElement = document.getElementById('id_usuario_sesion');
            if (idUsuarioElement) {
                data.id_usuario = idUsuarioElement.value;
            }

            try {
                // Guardar en la base de datos interna del navegador
                await db.encuestas.add({ 
                    data: data, 
                    timestamp: Date.now() 
                });

                // Notificar al Service Worker para sincronizar al recuperar señal
                const reg = await navigator.serviceWorker.ready;
                if (reg.sync) {
                    await reg.sync.register('sync-encuestas');
                }

                alert("¡Modo Offline! Encuesta guardada en el dispositivo. Se enviará automáticamente al detectar internet.");
                
                // Redirección suave a la lista de formularios
                window.location.href = '/formularios';
                
            } catch (error) {
                console.error("PWA: Error al guardar en Dexie:", error);
                alert("Hubo un error al guardar los datos localmente.");
            }
        }
    }
});

/**
 * 4. Funciones para el monitoreo GPS Offline
 */
async function registrarUbicacionOffline(lat, lng) {
    const dataUbicacion = {
        latitud: lat,
        longitud: lng,
        time: Date.now()
    };

    if (navigator.onLine) {
        try {
            await fetch('/encuestador/guardar_ubicacion_monitoreo', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dataUbicacion)
            });
        } catch (e) {
            // Si el fetch falla por inestabilidad de red, respaldar en Dexie
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
        console.log("PWA: Coordenada GPS respaldada en Dexie (Offline).");
    } catch (err) {
        console.error("PWA: Error al respaldar ubicación:", err);
    }
}