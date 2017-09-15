<?php extends_template('atuin/base.php') ?>

<?= block('atuin_title') ?>404 Not found<?= endblock() ?>

<?= block('atuin_content') ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-uppercase page-header">404 - Content not found</h1>
            <p class="lead">
                No content found.
            </p>
            <p>
                <a onclick="window.history.back()">< Back</a>
            </p>
        </div>
    </div>
</div>
<?= endblock() ?>
