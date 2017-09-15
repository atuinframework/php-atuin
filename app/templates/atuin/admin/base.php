<?php extends_template('atuin/base.php') ?>

<?= block('atuin_html_class') ?>atuin admin <?= block('atuin_html_class_admin') ?><?= endblock() ?><?= endblock() ?>
<?= block('atuin_title') ?><?= block('atuin_title_admin') ?><?= endblock() ?>  - Admin<?= endblock() ?>

<!-- CSS -->
<?= block('atuin_css_imports') ?><?= block('atuin_admin_css_imports') ?><?= endblock() ?><?= endblock() ?>
<?= block('atuin_css') ?>
<link href="/static/min/css/admin/atuin.css?v=<?= SITE_VERSION ?>" rel="stylesheet">
<?= block('atuin_admin_css') ?><?= endblock() ?>
<?= endblock() ?>

<?= block('atuin_content') ?>
    <?= block('atuin_admin_content') ?>
        <?php include('templates/atuin/admin/flash_messages.php') ?>
        <?= block('atuin_admin_navbar') ?>
            <?php include('templates/atuin/admin/navbar.php') ?>
        <?= endblock() ?>
        <?= block('atuin_admin_contentbody') ?><?= endblock() ?>
    <?= endblock() ?>
<?= endblock() ?>

<!-- JS -->
<?= block('atuin_js_imports') ?><?= block('atuin_admin_js_imports') ?><?= endblock() ?><?= endblock() ?>
<?= block('atuin_js') ?>
<script src="/static/min/js/admin/atuin.js?v=<?= SITE_VERSION ?>"></script>
<?= block('atuin_admin_js') ?><?= endblock() ?>
<?= endblock() ?>
