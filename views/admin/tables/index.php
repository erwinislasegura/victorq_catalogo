<?php
$pageTitle = 'Tablas Técnicas de Ingeniería';
?>
<div class="card shadow-sm border-0 rounded-3 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-table text-primary me-2"></i>Tablas Técnicas y Especificaciones</h6>
            <span class="badge bg-secondary-subtle text-secondary"><?= count($tables) ?> tablas</span>
        </div>

        <?php if (Auth::can('tables', 'create')): ?>
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1.5 fw-semibold" data-bs-toggle="modal" data-bs-target="#newTableModal">
                <i class="bi bi-plus-lg"></i> <span>Nueva Tabla</span>
            </button>
        <?php endif; ?>
    </div>

    <div class="card-body p-3">
        <div class="accordion accordion-flush" id="tablesAccordion">
            <?php if (!empty($tables)): ?>
                <?php foreach ($tables as $i => $t): 
                    $headers = json_decode($t['headers_json'] ?? '[]', true) ?: [];
                    $rows = json_decode($t['rows_json'] ?? '[]', true) ?: [];
                ?>
                <div class="accordion-item border rounded-2 mb-2 overflow-hidden">
                    <h2 class="accordion-header" id="heading<?= $t['id'] ?>">
                        <button class="accordion-button <?= $i > 0 ? 'collapsed' : '' ?> py-2.5 px-3 bg-light text-dark fw-semibold text-xs" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $t['id'] ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
                            <div class="d-flex align-items-center justify-content-between w-100 me-3">
                                <div>
                                    <i class="bi bi-table text-primary me-2"></i>
                                    <strong><?= htmlspecialchars($t['title']) ?></strong>
                                    <?php if (!empty($t['subtitle'])): ?>
                                        <span class="text-muted fw-normal ms-2">— <?= htmlspecialchars($t['subtitle']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <span class="badge bg-dark-subtle text-dark"><?= count($rows) ?> filas</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse<?= $t['id'] ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" data-bs-parent="#tablesAccordion">
                        <div class="accordion-body p-3">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-striped text-xxs mb-2">
                                    <?php if (!empty($headers)): ?>
                                        <thead class="table-dark text-uppercase">
                                            <tr>
                                                <?php foreach ($headers as $h): ?>
                                                    <th><?= htmlspecialchars($h) ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                    <?php endif; ?>
                                    <tbody>
                                        <?php if (!empty($rows)): ?>
                                            <?php foreach ($rows as $row): ?>
                                                <tr>
                                                    <?php foreach ($row as $cell): ?>
                                                        <td><?= htmlspecialchars($cell) ?></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if (!empty($t['note'])): ?>
                                <small class="text-muted fst-italic d-block mt-1"><i class="bi bi-info-circle me-1"></i><?= htmlspecialchars($t['note']) ?></small>
                            <?php endif; ?>

                            <?php if (Auth::can('tables', 'delete')): ?>
                                <div class="text-end mt-2 pt-2 border-top">
                                    <a href="<?= ADMIN_URL ?>/?c=table&a=delete&id=<?= $t['id'] ?>" class="btn btn-xs btn-outline-danger btn-delete" data-name="<?= htmlspecialchars($t['title']) ?>">
                                        <i class="bi bi-trash"></i> Eliminar Tabla
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-4 text-muted">No se encontraron tablas técnicas registradas.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Nueva Tabla Técnica -->
<div class="modal fade" id="newTableModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= ADMIN_URL ?>/?c=table&a=create" method="POST">
                <div class="modal-header bg-light py-2.5">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-plus-circle text-primary me-2"></i>Nueva Tabla Técnica</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row g-2 mb-2.5">
                        <div class="col-md-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Título de la Tabla *</label>
                            <input type="text" class="form-control form-control-sm" name="title" required placeholder="Ej: Serie MXTA — Llaves de Cuadrante">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Subtítulo / Aplicación</label>
                            <input type="text" class="form-control form-control-sm" name="subtitle" placeholder="Ej: Especificaciones y dimensiones generales">
                        </div>
                    </div>

                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Encabezados (separados por coma)</label>
                        <input type="text" class="form-control form-control-sm" name="headers_csv" placeholder="Modelo, Torque mín., Torque máx., Cuadrante, Peso (kg)">
                        <small class="text-muted text-xxs">Ej: Modelo, Capacidad (ton), Carrera (mm), Presión máx.</small>
                    </div>

                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Filas de Datos (un registro por línea, columnas separadas por coma)</label>
                        <textarea class="form-control form-control-sm font-monospace text-xs" name="rows_csv" rows="5" placeholder="1 MXTA, 200, 1.830, 3/4&quot;, 1.8&#10;3 MXTA, 450, 4.510, 1&quot;, 4.2"></textarea>
                    </div>

                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Nota al Pie</label>
                        <input type="text" class="form-control form-control-sm" name="note" placeholder="Ej: Datos extraídos del catálogo técnico de ingeniería.">
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Guardar Tabla</button>
                </div>
            </form>
        </div>
    </div>
</div>
