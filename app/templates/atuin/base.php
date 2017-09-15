<!DOCTYPE html>
<html lang="<?= SITE_LANGUAGE ?>" class="<?= block('atuin_html_class') ?><?= endblock() ?>">
<head>
    <meta charset="utf-8">
    <title><?= block('atuin_title') ?><?= endblock() ?> - <?= SITE_TITLE ?></title>
    <link rel="shortcut icon" href="static/min/img/favicon.png">
    <link rel="icon" href="static/min/img/favicon.png">
    <link rel="apple-touch-icon" href="static/min/img/favicon.png" type="image/png">
    <meta name="description" content="<?= block('atuin_metadescription') ?>PHP Atuin web applicaton framework.<?= endblock() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta property="og:title" content="<?= SITE_TITLE ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:description" content=""/>

    <!-- Bootstrap/-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- FontAwesome/-->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet">
    <!-- jQuery/-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <!-- Fonts/-->
    <link href='//fonts.googleapis.com/css?family=Open+Sans:300,300,400,600%7CRaleway:300,400,500,600,700%7CLato:300,400,400italic,600,700' rel='stylesheet' type='text/css'>
    <!-- ALL CSS -->
    <link href="/static/min/css/style.css?v=<?= SITE_VERSION ?>" rel="stylesheet">
    <?= block('atuin_css') ?><?= endblock() ?>
    <!-- /ALL CSS -->
    <?= block('atuin_head_end') ?><?= endblock() ?>
</head>

<body>
    <?= block('atuin_content') ?><?= endblock() ?>
    <?php
    /**
     * JS imports order:
     *  1. JS libraries imports
     *  1.1. Atuin libraries imports
     *  1.2. Libraries imports from others application's components (i.e. Atuincms, ...)
     *  1.3. Main application js libraries imports
     *
     *  2. Specific JS files imports
     *  2.0. i18n variables (transaltions, languages of the website, current_language)
     *  2.1. Atuin specific JS files
     *  2.2. Specific JS files from other application's components  (i.e. Atuincms, ...)
     *  2.3. Main application specific JS files
     **/
    ?>

    <!-- ALL IMPORTS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment-with-langs.min.js"></script>
    <script src="https://gitcdn.link/repo/xcash/bootstrap-autocomplete/master/dist/latest/bootstrap-autocomplete.min.js"></script>
    <script src="https://cdn.rawgit.com/nyxgear/formtools/master/dist/1.1.0/formtools.min.js"></script>
    <?= block('atuin_js_imports') ?><?= endblock() ?>
    <!-- /ALL IMPORTS -->

    <!-- ALL JS -->
    <script>
        var languages = <?= json_encode($LANG_TITLES) ?>;
        var current_language = <?= json_encode(SITE_LANGUAGE)  ?>;
    </script>
    <script src="/static/min/js/all.js?v=<?= SITE_VERSION ?>"></script>
    <?= block('atuin_js') ?><?= endblock() ?>
    <!-- /ALL JS -->

    <?= block('atuin_foot_end') ?><?= endblock() ?>
</body>
</html>
