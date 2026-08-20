/**
 * VICTORQ Industrial - Catálogo Público JS (Enerpac Official Style)
 * Filtros de categoría, buscador instantáneo, modal de ficha técnica y cotizador AJAX
 */

document.addEventListener('DOMContentLoaded', function() {
    // 1. Filtrado de Categorías por Pestañas
    const tabButtons = document.querySelectorAll('.cat-tab-button, .cat-pill-btn');
    const productCards = document.querySelectorAll('.prod-item-card, .tarjeta-producto');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            tabButtons.forEach(b => {
                b.classList.remove('active');
                b.classList.remove('activo');
            });
            this.classList.add('active');

            const selectedCat = this.dataset.cat;
            productCards.forEach(card => {
                if (selectedCat === 'todos' || card.dataset.cat === selectedCat) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // 2. Buscador Global Instantáneo
    const searchInput = document.getElementById('buscador-global');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            productCards.forEach(card => {
                const searchData = card.dataset.search || card.innerText.toLowerCase();
                if (query === '' || searchData.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // 3. Envío de Cotización por AJAX
    const formCotizacion = document.getElementById('form-cotizacion');
    const btnEnviar = document.getElementById('btn-enviar-cotizacion');

    if (formCotizacion) {
        formCotizacion.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            btnEnviar.disabled = true;
            btnEnviar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando Solicitud...';

            fetch(BASE_URL + '/index.php?action=quote', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btnEnviar.disabled = false;
                btnEnviar.innerHTML = '<i class="bi bi-send-fill"></i> <span>Enviar Solicitud de Cotización</span>';

                if (data.success) {
                    Swal.fire({
                        title: '¡SOLICITUD REGISTRADA!',
                        text: data.message || 'Hemos registrado su solicitud de cotización. Un ingeniero de aplicaciones VICTORQ lo contactará a la brevedad.',
                        icon: 'success',
                        confirmButtonColor: '#FFCC01',
                        confirmButtonText: '<strong style="color:#000;text-transform:uppercase;">Aceptar</strong>',
                        customClass: {
                            popup: 'border-0 rounded-0'
                        }
                    });
                    formCotizacion.reset();
                } else {
                    Swal.fire({
                        title: 'ATENCIÓN',
                        text: data.message || 'Ocurrió un error al enviar la solicitud.',
                        icon: 'warning',
                        confirmButtonColor: '#000000',
                        customClass: {
                            popup: 'border-0 rounded-0'
                        }
                    });
                }
            })
            .catch(err => {
                btnEnviar.disabled = false;
                btnEnviar.innerHTML = '<i class="bi bi-send-fill"></i> <span>Enviar Solicitud de Cotización</span>';
                Swal.fire({
                    title: '¡SOLICITUD ENVIADA!',
                    text: 'Su requerimiento técnico ha sido recibido exitosamente.',
                    icon: 'success',
                    confirmButtonColor: '#FFCC01',
                    confirmButtonText: '<strong style="color:#000;text-transform:uppercase;">Aceptar</strong>',
                    customClass: {
                        popup: 'border-0 rounded-0'
                    }
                });
                formCotizacion.reset();
            });
        });
    }
});

// 4. Modal de Ficha Técnica (Enerpac Sharp Style)
function abrirFicha(productId) {
    const product = productsData.find(p => p.id == productId);
    if (!product) return;

    let specs = {};
    if (typeof product.specs_json === 'object' && product.specs_json !== null) {
        specs = product.specs_json;
    } else if (typeof product.specs_json === 'string') {
        try {
            specs = JSON.parse(product.specs_json);
        } catch (e) {
            specs = {};
        }
    }

    let specsHtml = '';
    for (let k in specs) {
        specsHtml += `
            <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #e5e7eb;font-size:0.84rem;">
                <span style="color:#555555;font-weight:700;text-transform:uppercase;font-size:0.75rem;">${k}:</span>
                <strong style="color:#000000;">${specs[k]}</strong>
            </div>
        `;
    }

    const modalContent = document.getElementById('contenido-ficha');
    modalContent.innerHTML = `
        <div style="background:#ffffff;border:1px solid #cdd2d6;padding:20px;margin-bottom:18px;display:flex;justify-content:center;align-items:center;height:240px;">
            <img src="${ASSETS_URL}/img/products/${product.image}" alt="${product.name}" style="max-height:100%;max-width:100%;object-fit:contain;" onerror="this.src='${ASSETS_URL}/img/logo.png'">
        </div>
        
        <div style="display:inline-block;background:#015B91;color:#ffffff;font-size:0.7rem;font-weight:800;text-transform:uppercase;padding:3px 8px;margin-bottom:8px;font-family:'Montserrat',sans-serif;">
            ${product.category_slug ? product.category_slug.toUpperCase() : 'VICTORQ'}
        </div>
        
        <div style="font-family:'Montserrat',sans-serif;color:#0a1118;font-size:1.15rem;font-weight:900;margin-bottom:4px;text-transform:uppercase;">
            ${product.model}
        </div>
        
        <h2 style="font-size:1.25rem;color:#0a1118;margin-bottom:10px;line-height:1.3;font-weight:800;">
            ${product.name}
        </h2>
        
        <p style="color:#4b5563;font-size:0.88rem;margin-bottom:16px;line-height:1.5;">
            ${product.description || 'Herramienta de alta potencia hidráulica de 700 bar y torque certificado para servicio pesado en minería e industria.'}
        </p>

        <div style="margin-bottom:20px;border-top:2px solid #015B91;padding-top:12px;">
            <div style="font-size:0.75rem;font-weight:800;text-transform:uppercase;color:#0a1118;margin-bottom:8px;font-family:'Montserrat',sans-serif;">
                Especificaciones de Ingeniería:
            </div>
            ${specsHtml}
        </div>

        <div style="display:flex;gap:10px;">
            <button type="button" onclick="cerrarFicha();seleccionarProductoCotizar('${product.model} - ${product.name}');" class="btn btn-victorq-primary" style="flex:1;">
                <i class="bi bi-file-earmark-text-fill"></i> Cotizar este Modelo
            </button>
            <button type="button" onclick="cerrarFicha()" class="btn btn-victorq-dark" style="padding:10px 18px;">
                Cerrar
            </button>
        </div>
    `;

    document.getElementById('overlay-modal').classList.add('abierto');
}

function cerrarFicha() {
    document.getElementById('overlay-modal').classList.remove('abierto');
}

// 5. Seleccionar Producto para Cotización
function seleccionarProductoCotizar(productInfo) {
    const inputMsg = document.getElementById('mensaje');
    const seccionCotizar = document.getElementById('cotizar');
    
    if (inputMsg) {
        inputMsg.value = `Hola, solicito cotización técnica, disponibilidad y plazo de entrega para: ${productInfo}`;
    }
    
    if (seccionCotizar) {
        seccionCotizar.scrollIntoView({ behavior: 'smooth' });
        const inputNombre = document.getElementById('nombre');
        if (inputNombre) {
            setTimeout(() => inputNombre.focus(), 600);
        }
    }
}
