<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?>">
        <?php $res->partial('view_app_before'); ?>
        <div id="app">
            <?php $res->partial('header'); ?>
            <main>
                <section class="box">
                    <h1>Create Changelog</h1>

                    <?php $res->html->messages(); ?>

                    <form method="POST">
                        <?php $res->html->textarea('Content'); ?>

                        <?php $res->html->submit('Save', 'button button_invert'); ?>
                    </form>

                </section>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

