<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#admin-navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= block('atuin_admin_navbar_title') ?>
            <a class="navbar-brand" href="<?php echo url_for('home_index') ?>"><?=SITE_TITLE?></a>
            <?= endblock() ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="admin-navbar">
            <?= block('atuin_admin_navbar_main') ?>
            <ul class="nav navbar-nav">
                <li class="<?php if (@$menuid == 'adminarea') { echo 'active'; } ?>">
                    <a href="<?php echo url_for('admin_home_index') ?>">
                        Admin area
                    </a>
                </li>
                <li class="<?php if (@$menuid == 'experiments') { echo 'active'; } ?>">
                    <a href="<?php echo url_for('admin_home_experiments') ?>">
                        Experiments lab
                    </a>
                </li>
            </ul>
            <?= endblock() ?>
            <?= block('atuin_admin_navbar_admin') ?>
            <ul class="nav navbar-nav navbar-right">
                <?= block('atuin_admin_navbar_admin_items') ?><?= endblock() ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="flag-icon flag-icon-<?=SITE_LANGUAGE?>" style="width:22px;"></span> <?= $LANG_TITLES[SITE_LANGUAGE]?><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($LANG_TITLES as $lang => $desc) { ?>
                        <li>
                            <a href="/">
                                <span class="flag-icon flag-icon-<?=$lang?>" style="width:22px;"></span> <?=$desc?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="dropdown<?php if (@$menuid == 'admin') { echo ' active'; } ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-th-list"></i> Admin</a>
                    <ul class="dropdown-menu">
                        <li class="<?php if (@$submenuid == 'users') { echo 'active'; } ?>">
                            <a href="<?php echo url_for('admin_auth_users') ?>"> Users</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a>User name User surname</a>
                        </li>
                        <li>
                            <a href="<?php echo url_for('atuin_auth_logout') ?>">Log out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <?= endblock() ?>
        </div>
    </div>
</nav>
