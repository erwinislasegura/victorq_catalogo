</main>

<!-- ADMIN FOOTER -->
<footer class="admin-footer text-white-50 text-xs mt-auto">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
        <div>
            &copy; <?= date('Y') ?> <strong class="text-white"><?= APP_NAME ?></strong> — Sistema de Catálogo y Cotizaciones.
        </div>
        <div class="d-flex align-items-center gap-3">
            <span>Versión <span class="badge bg-secondary"><?= APP_VERSION ?></span></span>
            <span class="d-none d-sm-inline">|</span>
            <span>Soporte: <a href="mailto:<?= APP_EMAIL ?>" class="text-info text-decoration-none"><?= APP_EMAIL ?></a></span>
        </div>
    </div>
</footer>

</div> <!-- /admin-main -->
</div> <!-- /admin-wrapper -->

<!-- Bootstrap 5.3.3 Bundle JS with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom Admin JS -->
<script src="<?= ASSETS_URL ?>/js/admin.js"></script>

</body>
</html>
