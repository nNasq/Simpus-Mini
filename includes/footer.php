</main>

<footer class="mt-auto py-4 text-center text-secondary border-top bg-white">
  <div class="container">
    <p class="mb-0">&copy; 2026 <strong>SIGUDANG-Mini</strong> &mdash; Jobsheet 7</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $base; ?>assets/js/app.js"></script>
<?php if (!empty($extra_scripts)): foreach ($extra_scripts as $src): ?>
<script src="<?php echo e($src); ?>"></script>
<?php endforeach; endif; ?>
</body>
</html>