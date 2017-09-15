<?php extends_template('atuin/admin/base.php') ?>

<?= block('atuin_html_class_admin') ?>home<?= endblock() ?>
<?= block('atuin_title_admin') ?>Admin area<?= endblock() ?>

<?= block('atuin_admin_contentbody') ?>
<div class="container">
    <h1>Welcome to PHP Atuin's admin area!</h1>
    <p>
        This page is protected by login and permission policies.
        <br><br>
        Only logged in users can access this page.<br>
        Moreover, the logged in user must have the <code>ADMIN</code> role.
    </p>
    <p>
        Look at:
    </p>
    <ul>
        <li><code>app/atuin/auth/admin.php</code></li>
        <li><code>app/permission_policies.php</code></li>
    </ul>
</div>
<?= endblock() ?>
