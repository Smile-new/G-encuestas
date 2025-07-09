<?php
// app/Helpers/comunidad_view_helper.php

if (!function_exists('renderizarRespuestas')) {
    /**
     * Renderiza recursivamente las respuestas de una publicación.
     * Este helper es utilizado por la vista para mantener el código más limpio.
     *
     * @param array $respuestas Array de respuestas a renderizar.
     * @param array|null $usuarioLogueado Datos del usuario logueado.
     * @param bool $esAdminGlobal Si el usuario logueado es administrador.
     */
    function renderizarRespuestas(array $respuestas, ?array $usuarioLogueado, bool $esAdminGlobal)
    {
        if (empty($respuestas)) {
            return;
        }

        foreach ($respuestas as $respuesta) {
            // Prepara las variables para esta respuesta
            // Asumimos que 'foto_path', 'nombre_completo_display' y 'fecha_creacion'
            // ya vienen procesadas y listas para mostrar desde el controlador.
            $defaultAvatarUrl = base_url('public/img_user/default-avatar.png');
            $avatarPathR = esc($respuesta['foto_path'] ?? $defaultAvatarUrl);
            $nombreCompletoR = esc($respuesta['nombre_completo_display'] ?? 'Usuario Desconocido');
            $fechaFormateadaR = esc($respuesta['fecha_creacion'] ?? 'Fecha desconocida'); // Ya viene formateada
            
            // Añadido para el indicador de edición, si existe (aunque no haya botón, la fecha de edición puede ser relevante)
            $fechaActualizacionDisplayR = esc($respuesta['fecha_actualizacion_display'] ?? ''); 

            $esAutorR = ($usuarioLogueado['id_usuario'] ?? null) === $respuesta['id_usuario'];
            $postIdR = esc($respuesta['id_publicacion']);

            // Contenido sin nl2br para el 'data-original-content', con nl2br para la visualización
            $replyContentRaw = esc($respuesta['contenido_publicacion'] ?? '');
            $replyContentDisplay = nl2br($replyContentRaw);
            
            // Determina si es una respuesta a otra respuesta (para indentación visual)
            $isReplyToReply = !empty($respuesta['id_publicacion_padre']);
            ?>
            <div class="post-card reply <?= $isReplyToReply ? 'reply-to-reply' : '' ?>" id="post-<?= $postIdR ?>" data-id="<?= $postIdR ?>" data-parent-id="<?= esc($respuesta['id_publicacion_padre']) ?>">
                <img src="<?= $avatarPathR ?>" alt="Avatar de <?= $nombreCompletoR ?>" class="post-author-avatar" onerror="this.onerror=null;this.src='<?= $defaultAvatarUrl ?>';">
                <div class="post-content-wrapper">
                    <div class="post-header">
                        <span class="post-author-name"><?= $nombreCompletoR ?></span>
                        <span class="post-date"><?= $fechaFormateadaR ?></span>
                        <?php if ($fechaActualizacionDisplayR): ?>
                            <span class="post-edited-indicator">(editado <?= $fechaActualizacionDisplayR ?>)</span>
                        <?php endif; ?>
                    </div>
                    <div class="post-body">
                        <div class="post-content-display">
                            <?= $replyContentDisplay ?>
                        </div>
                        </div>
                    <div class="post-actions">
                        <?php if (isset($usuarioLogueado['id_usuario'])): // Solo si hay un usuario logueado ?>
                            <button type="button" class="btn-action responder-btn" data-post-id="<?= $postIdR ?>">Responder</button>
                            <?php if ($esAutorR || $esAdminGlobal): ?>
                                <form action="<?= base_url('comunidad/eliminar/' . $postIdR) ?>" method="post" class="d-inline delete-post-form">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('¿Estás seguro de que quieres eliminar esta respuesta? Esta acción es irreversible.');">Eliminar</button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($usuarioLogueado['id_usuario'])): ?>
                        <div id="respuesta-form-<?= $postIdR ?>" class="responder-form-container new-post-form mt-3 d-none">
                            <h6>Responder a <?= $nombreCompletoR ?>:</h6>
                            <form class="form-ajax-respuesta" action="<?= base_url('comunidad/guardar') ?>" method="post" data-parent-id="<?= $postIdR ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_publicacion_padre" value="<?= $postIdR ?>">
                                <div class="form-group mb-2">
                                    <textarea name="contenido_publicacion" class="form-control" placeholder="Tu respuesta..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Enviar Respuesta</button>
                                <button type="button" class="btn btn-secondary btn-sm cancelar-respuesta-btn">Cancelar</button>
                            </form>
                        </div>
                    <?php endif; ?>

                    <div class="replies-list" id="replies-for-post-<?= $postIdR ?>">
                        <?php
                        // Llamada recursiva para las respuestas de esta respuesta
                        if (!empty($respuesta['respuestas'])) {
                            renderizarRespuestas($respuesta['respuestas'], $usuarioLogueado, $esAdminGlobal);
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
?>