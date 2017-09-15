<?php extends_template('atuin/admin/base.php') ?>

<?= block('atuin_html_class_admin') ?>home<?= endblock() ?>
<?= block('atuin_title_admin') ?>Experiments' lab<?= endblock() ?>

<?= block('atuin_admin_contentbody') ?>
<div class="container">
    <h1><i class="fa fa-flask"></i> Experiments' lab</h1>
    <ol type="1">
        <li><a href="<?php echo url_for('admin_home_experiments', array('string'=>'WasCamelCase')) ?>">Parametric URL <i>string</i></a></li>
        <li><a href="<?php echo url_for('admin_home_experiments', array('num1'=>10, 'num2'=>32)) ?>">Parametric URL <i>numeric</i></a></li>
        <li><a href="<?php echo url_for('admin_home_experiments', array('Hello'=>'World', 'PHP'=>'Atuin')) ?>">Query string</a></li>
        <li><a href="<?php echo url_for('home_redirect') ?>">Redirect to come back</a></li>
    </ol>

    <?php if ($injected_string) { ?>
        <div class="jumbotron text-center">
            <h2><i class="fa fa-hand-o-down"></i> CamelCasetolowercase converter ;)</h2>
            <p>
                Change the URL after <code>../string/</code> with any valid string.
            </p>
            <p>
                <code><?= $injected_string?></code>
            </p>
        </div>
    <?php } ?>


    <?php if ($cumputed_sum) { ?>
        <div class="jumbotron text-center">
            <h2><i class="fa fa-calculator"></i> An handy URL calculator</h2>
            <p>
                Change numbers in the URL to compute other sums.
            </p>
            <p>
                <code><?= $arg1 ?> + <?= $arg2 ?> = <?= $cumputed_sum ?></code>
            </p>
        </div>
    <?php } ?>

    <?php if (!empty($_GET)) { ?>
        <div class="jumbotron">
            <h2 class="text-center"><i class="fa fa-question"></i> From the URL query string that<br>has been built automatically by the <code>url_for</code> function.</h2>
            <?php pprint($_GET) ?>
        </div>
    <?php } ?>
</div>
<?= endblock() ?>
