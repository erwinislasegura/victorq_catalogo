</main>

<!-- ADMIN FOOTER -->
<footer class="admin-footer text-muted text-xs mt-auto">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5" style="font-size: 0.68rem;">
                <i class="bi bi-circle-fill text-success me-1" style="font-size: 0.45rem;"></i> Sistema Operativo 700 Bar
            </span>
            <span>&copy; <?= date('Y') ?> <strong class="text-dark"><?= APP_COMPANY ?></strong>. Todos los derechos reservados.</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-light text-dark border">v<?= APP_VERSION ?></span>
            <span class="d-none d-sm-inline text-muted">|</span>
            <span>Mesa de Ayuda: <a href="mailto:<?= APP_EMAIL ?>" class="text-primary text-decoration-none fw-semibold"><?= APP_EMAIL ?></a></span>
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
