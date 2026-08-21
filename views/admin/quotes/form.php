<?php
/**
 * Formulario de Creación / Emisión de Cotización Multiproducto (Admin)
 * Soporte para N productos, descuentos por ítem (% / $) y descuento general
 */
?>
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-file-earmark-plus-fill text-primary"></i>
            <span>Nueva Cotización Técnica Multiproducto</span>
        </h4>
        <p class="text-muted text-xs mb-0">Agregue múltiples productos del catálogo, aplique descuentos por ítem o descuento general con validez de 15 días.</p>
    </div>
    <a href="<?= ADMIN_URL ?>/?c=quote" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 text-xs">
        <i class="bi bi-arrow-left"></i> Volver al Listado
    </a>
</div>

<form action="<?= ADMIN_URL ?>/?c=quote&a=create" method="POST" id="form-create-quote">
    <!-- 1. DATOS DEL CLIENTE Y EMPRESA -->
    <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-building text-primary"></i>
                <span>1. Información del Cliente y Empresa</span>
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="company" class="form-label text-xs fw-semibold text-muted text-uppercase">Razón Social / Empresa *</label>
                    <input type="text" class="form-control form-control-sm" id="company" name="company" value="<?= htmlspecialchars($quote['company'] ?? '') ?>" required placeholder="Ej: Minera Escondida Ltda.">
                </div>

                <div class="col-md-2">
                    <label for="rut" class="form-label text-xs fw-semibold text-muted text-uppercase">RUT Empresa</label>
                    <input type="text" class="form-control form-control-sm font-monospace" id="rut" name="rut" value="<?= htmlspecialchars($quote['rut'] ?? '') ?>" placeholder="76.123.456-7">
                </div>

                <div class="col-md-3">
                    <label for="client_name" class="form-label text-xs fw-semibold text-muted text-uppercase">Nombre del Solicitante *</label>
                    <input type="text" class="form-control form-control-sm" id="client_name" name="client_name" value="<?= htmlspecialchars($quote['client_name'] ?? '') ?>" required placeholder="Ej: Ing. Rodrigo Soto">
                </div>

                <div class="col-md-3">
                    <label for="client_email" class="form-label text-xs fw-semibold text-muted text-uppercase">Correo Electrónico *</label>
                    <input type="email" class="form-control form-control-sm" id="client_email" name="client_email" value="<?= htmlspecialchars($quote['client_email'] ?? '') ?>" required placeholder="adquisiciones@empresa.cl">
                </div>

                <div class="col-md-4">
                    <label for="client_phone" class="form-label text-xs fw-semibold text-muted text-uppercase">Teléfono / Móvil</label>
                    <input type="text" class="form-control form-control-sm" id="client_phone" name="client_phone" value="<?= htmlspecialchars($quote['client_phone'] ?? '') ?>" placeholder="+56 9 8765 4321">
                </div>

                <div class="col-md-4">
                    <label for="faena" class="form-label text-xs fw-semibold text-muted text-uppercase">Faena / Destino de Entrega</label>
                    <input type="text" class="form-control form-control-sm" id="faena" name="faena" value="<?= htmlspecialchars($quote['faena'] ?? '') ?>" placeholder="Ej: Faena Cordillera / Antofagasta">
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label text-xs fw-semibold text-muted text-uppercase">Estado Inicial</label>
                    <select class="form-select form-select-sm" id="status" name="status">
                        <option value="quoted" selected>🟢 Cotizada (Lista para entrega)</option>
                        <option value="pending">🔴 Pendiente de Revisión</option>
                        <option value="in_review">🟡 En Evaluación Técnica</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="message" class="form-label text-xs fw-semibold text-muted text-uppercase">Observaciones / Requerimientos de Despacho</label>
                    <textarea class="form-control form-control-sm" id="message" name="message" rows="2" placeholder="Requerimientos de calibración, certificados de fábrica, pruebas de presión a 700 bar..."><?= htmlspecialchars($quote['message'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TABLA DE MÚLTIPLES PRODUCTOS Y DESCUENTOS -->
    <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-box-seam text-primary"></i>
                <span>2. Equipos Cotizados y Descuentos por Producto</span>
            </h6>
            <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1 text-xs fw-bold" id="btn-add-item">
                <i class="bi bi-plus-circle"></i>
                <span>Agregar Producto</span>
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 text-xs" id="itemsTable">
                    <thead class="table-light text-uppercase text-xxs text-muted">
                        <tr>
                            <th class="ps-3" style="min-width: 260px;">Equipo / Modelo</th>
                            <th class="text-center" style="width: 90px;">Cant.</th>
                            <th class="text-end" style="width: 140px;">Precio Unit. ($)</th>
                            <th class="text-center" style="width: 180px;">Descuento Ítem</th>
                            <th class="text-end" style="width: 140px;">Subtotal Neto</th>
                            <th class="text-center pe-3" style="width: 50px;"></th>
                        </tr>
                    </thead>
                    <tbody id="items-tbody">
                        <!-- FILA 1 POR DEFECTO -->
                        <tr class="item-row">
                            <td class="ps-3">
                                <select class="form-select form-select-sm select-product" name="items[0][product_id]" required>
                                    <option value="">-- Seleccionar Equipo --</option>
                                    <?php foreach ($products as $p): ?>
                                        <option value="<?= $p['id'] ?>" data-price="<?= (float)($p['price'] ?? 150000) ?>" data-model="<?= htmlspecialchars($p['model']) ?>">
                                            <?= htmlspecialchars($p['model']) ?> — <?= htmlspecialchars($p['name']) ?> ($<?= number_format((float)($p['price'] ?? 150000), 0, ',', '.') ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm text-center font-monospace fw-bold input-quantity" name="items[0][quantity]" value="1" min="1" max="999" required>
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm text-end font-monospace fw-bold input-price" name="items[0][price]" value="150000" min="0" step="1000" required>
                            </td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <select class="form-select select-discount-type" name="items[0][discount_type]" style="max-width: 65px;">
                                        <option value="%">%</option>
                                        <option value="$">$</option>
                                    </select>
                                    <input type="number" class="form-control font-monospace text-end input-discount-val" name="items[0][discount_val]" value="0" min="0" step="any" placeholder="0">
                                </div>
                            </td>
                            <td class="text-end font-monospace fw-bold text-primary item-line-subtotal">
                                $150.000
                            </td>
                            <td class="text-center pe-3">
                                <button type="button" class="btn btn-xs btn-outline-danger btn-remove-row" title="Eliminar fila">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1.5 text-xs fw-bold" id="btn-add-item-bottom">
                    <i class="bi bi-plus-lg"></i>
                    <span>Agregar Otro Producto al Presupuesto</span>
                </button>
                <span class="text-muted text-xxs">Puede modificar precios y aplicar descuentos individuales en cada fila.</span>
            </div>
        </div>
    </div>

    <!-- 3. DESCUENTO GENERAL Y RESUMEN FINANCIERO -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-3 bg-white h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-percent text-primary"></i>
                        <span>3. Descuento General y Notas Internas</span>
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label for="global_discount_val" class="form-label text-xs fw-semibold text-muted text-uppercase">Descuento General Adicional sobre el Total</label>
                        <div class="input-group input-group-sm" style="max-width: 250px;">
                            <select class="form-select" id="global_discount_type" name="global_discount_type" style="max-width: 80px;">
                                <option value="%">Porcentaje (%)</option>
                                <option value="$">Monto Fijo ($)</option>
                            </select>
                            <input type="number" class="form-control font-monospace text-end fw-bold" id="global_discount_val" name="global_discount_val" value="0" min="0" step="any" placeholder="0">
                        </div>
                        <small class="text-muted text-xxs d-block mt-1">Este descuento se aplica sobre el subtotal neto acumulado de todos los equipos.</small>
                    </div>

                    <div class="mb-0">
                        <label for="admin_notes" class="form-label text-xs fw-semibold text-muted text-uppercase">Notas de Seguimiento Interno</label>
                        <textarea class="form-control form-control-sm" id="admin_notes" name="admin_notes" rows="3" placeholder="Ej: Se acordó descuento comercial por volumen autorizado por gerencia..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-3 bg-white h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-calculator text-primary"></i>
                        <span>Resumen Financiero de la Propuesta</span>
                    </h6>
                </div>
                <div class="card-body p-4">
                    <table class="table table-sm table-borderless text-xs mb-3">
                        <tr>
                            <td class="text-muted">Subtotal Lista (Bruto):</td>
                            <td class="text-end font-monospace fw-bold text-dark" id="disp-subtotal-gross">$0 CLP</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Descuentos por Producto:</td>
                            <td class="text-end font-monospace fw-bold text-danger" id="disp-item-discounts">-$0 CLP</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Descuento General:</td>
                            <td class="text-end font-monospace fw-bold text-danger" id="disp-global-discount">-$0 CLP</td>
                        </tr>
                        <tr class="border-top">
                            <td class="fw-bold text-dark">Subtotal Neto:</td>
                            <td class="text-end font-monospace fw-bold text-dark fs-6" id="disp-subtotal-net">$0 CLP</td>
                        </tr>
                        <tr>
                            <td class="text-muted">I.V.A. (19%):</td>
                            <td class="text-end font-monospace fw-bold text-dark" id="disp-iva">$0 CLP</td>
                        </tr>
                        <tr class="border-top table-primary">
                            <td class="fw-bold text-uppercase fs-6 p-2">TOTAL GENERAL:</td>
                            <td class="text-end font-monospace fw-bold text-primary fs-5 p-2" id="disp-total">$0 CLP</td>
                        </tr>
                    </table>

                    <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-save-fill"></i>
                        <span>Guardar y Emitir Cotización Oficial</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- TEMPLATE PARA NUEVAS FILAS -->
<template id="row-template">
    <tr class="item-row">
        <td class="ps-3">
            <select class="form-select form-select-sm select-product" name="items[__INDEX__][product_id]" required>
                <option value="">-- Seleccionar Equipo --</option>
                <?php foreach ($products as $p): ?>
                    <option value="<?= $p['id'] ?>" data-price="<?= (float)($p['price'] ?? 150000) ?>" data-model="<?= htmlspecialchars($p['model']) ?>">
                        <?= htmlspecialchars($p['model']) ?> — <?= htmlspecialchars($p['name']) ?> ($<?= number_format((float)($p['price'] ?? 150000), 0, ',', '.') ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <input type="number" class="form-control form-control-sm text-center font-monospace fw-bold input-quantity" name="items[__INDEX__][quantity]" value="1" min="1" max="999" required>
        </td>
        <td>
            <input type="number" class="form-control form-control-sm text-end font-monospace fw-bold input-price" name="items[__INDEX__][price]" value="150000" min="0" step="1000" required>
        </td>
        <td>
            <div class="input-group input-group-sm">
                <select class="form-select select-discount-type" name="items[__INDEX__][discount_type]" style="max-width: 65px;">
                    <option value="%">%</option>
                    <option value="$">$</option>
                </select>
                <input type="number" class="form-control font-monospace text-end input-discount-val" name="items[__INDEX__][discount_val]" value="0" min="0" step="any" placeholder="0">
            </div>
        </td>
        <td class="text-end font-monospace fw-bold text-primary item-line-subtotal">
            $150.000
        </td>
        <td class="text-center pe-3">
            <button type="button" class="btn btn-xs btn-outline-danger btn-remove-row" title="Eliminar fila">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIndex = 1;
    const tbody = document.getElementById('items-tbody');
    const template = document.getElementById('row-template').innerHTML;

    function formatCLP(num) {
        return '$' + Math.round(num).toLocaleString('es-CL') + ' CLP';
    }

    function calculateAll() {
        let subtotalGross = 0;
        let totalItemDiscounts = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const selectProd = row.querySelector('.select-product');
            const inputQty = row.querySelector('.input-quantity');
            const inputPrice = row.querySelector('.input-price');
            const selectDiscType = row.querySelector('.select-discount-type');
            const inputDiscVal = row.querySelector('.input-discount-val');
            const lineSubtotalDisp = row.querySelector('.item-line-subtotal');

            const qty = Math.max(1, parseInt(inputQty.value) || 1);
            const price = Math.max(0, parseFloat(inputPrice.value) || 0);
            const discType = selectDiscType.value;
            const discVal = Math.max(0, parseFloat(inputDiscVal.value) || 0);

            const gross = qty * price;
            let discAmount = 0;
            if (discVal > 0) {
                discAmount = (discType === '%') ? (gross * (discVal / 100)) : Math.min(gross, discVal);
            }
            const lineNet = Math.max(0, gross - discAmount);

            lineSubtotalDisp.textContent = '$' + Math.round(lineNet).toLocaleString('es-CL');

            subtotalGross += gross;
            totalItemDiscounts += discAmount;
        });

        // Descuento General
        const globalDiscType = document.getElementById('global_discount_type').value;
        const globalDiscVal = Math.max(0, parseFloat(document.getElementById('global_discount_val').value) || 0);
        const subtotalAfterItems = Math.max(0, subtotalGross - totalItemDiscounts);

        let globalDiscAmount = 0;
        if (globalDiscVal > 0) {
            globalDiscAmount = (globalDiscType === '%') ? (subtotalAfterItems * (globalDiscVal / 100)) : Math.min(subtotalAfterItems, globalDiscVal);
        }

        const subtotalNet = Math.max(0, subtotalAfterItems - globalDiscAmount);
        const iva = Math.round(subtotalNet * 0.19);
        const total = subtotalNet + iva;

        document.getElementById('disp-subtotal-gross').textContent = formatCLP(subtotalGross);
        document.getElementById('disp-item-discounts').textContent = '-' + formatCLP(totalItemDiscounts);
        document.getElementById('disp-global-discount').textContent = '-' + formatCLP(globalDiscAmount);
        document.getElementById('disp-subtotal-net').textContent = formatCLP(subtotalNet);
        document.getElementById('disp-iva').textContent = formatCLP(iva);
        document.getElementById('disp-total').textContent = formatCLP(total);
    }

    function bindRowEvents(row) {
        const selectProd = row.querySelector('.select-product');
        const inputPrice = row.querySelector('.input-price');
        const btnRemove = row.querySelector('.btn-remove-row');

        if (selectProd) {
            selectProd.addEventListener('change', function() {
                const opt = this.options[this.selectedIndex];
                const pPrice = opt.getAttribute('data-price');
                if (pPrice) {
                    inputPrice.value = pPrice;
                }
                calculateAll();
            });
        }

        row.querySelectorAll('input, select').forEach(elem => {
            elem.addEventListener('input', calculateAll);
            elem.addEventListener('change', calculateAll);
        });

        if (btnRemove) {
            btnRemove.addEventListener('click', function() {
                if (document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    calculateAll();
                } else {
                    alert('La cotización debe contener al menos un producto.');
                }
            });
        }
    }

    function addRow() {
        const newHtml = template.replace(/__INDEX__/g, rowIndex++);
        const tempDiv = document.createElement('tbody');
        tempDiv.innerHTML = newHtml;
        const newRow = tempDiv.firstElementChild;
        tbody.appendChild(newRow);
        bindRowEvents(newRow);
        calculateAll();
    }

    document.getElementById('btn-add-item')?.addEventListener('click', addRow);
    document.getElementById('btn-add-item-bottom')?.addEventListener('click', addRow);

    document.getElementById('global_discount_type')?.addEventListener('change', calculateAll);
    document.getElementById('global_discount_val')?.addEventListener('input', calculateAll);

    // Inicializar filas existentes
    document.querySelectorAll('.item-row').forEach(bindRowEvents);
    calculateAll();
});
</script>
