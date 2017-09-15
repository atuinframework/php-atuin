<?php extends_template('atuin/base.php') ?>

<?= block('atuin_title') ?>Atuin home<?= endblock() ?>

<?= block('atuin_content') ?>
<div class="container">
    <div class="row" style="margin-top:80px">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <img src="/static/min/img/atuin/atuin_logo.jpg" style="max-width: 200px">
                    </div>
                    <h3 class="text-center">PHP Atuin</h3>
                    <p>
                        PHP Atuin is the PHP version of the Flask Atuin
                        framework.
                    </p>
                    <p>
                        Based on Bootstrap, jQuery, moment and other cool
                        features Atuin improves your development workflow.
                    </p>
                    <p>
                        It does so by running in a docker image
                        <code>autin-gulp</code> a rich CASE software based on
                        Gulp. This latter monitors project's static files
                        continuously and, through a series of tasks, it
                        autocompile and minify CSS, JavaScript files while
                        you're writing them!
                    </p>
                    <p>
                        Atuin also provides dynamic URL definitions thanks to
                        a powerful routing engine system.
                    </p>
                    <p>
                        Lastly, Atuin brings with it a templating engine
                        system that lets you to define templates' hierarchies
                        and to compose them dynamically by meaningful blocks
                        definitions.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <p class="text-center" style="padding-bottom: 150px">
                <?php if ($current_user['logged_in'] == true) { ?>
                    You're logged in.
                    <a class="btn btn-block btn-info" href="<?php echo url_for('admin_home_index') ?>">Admin area</a>
                <?php } else { ?>
                    <a class="btn btn-block btn-primary" href="<?php echo url_for('atuin_auth_login') ?>">Login</a>
                <?php } ?>
            </p>
        </div>
    </div>
</div>
<?= endblock() ?>
