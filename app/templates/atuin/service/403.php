<?php extends_template('atuin/base.php') ?>

<?= block('atuin_title') ?>403 Forbidden<?= endblock() ?>

<?= block('atuin_content') ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-uppercase page-header">403 - Access denied</h1>
            <p class="lead">
                Access denied to this area.
            </p>
        </div>
    </div>
</div>
<?= endblock() ?>
