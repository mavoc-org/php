<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?>">
        <?php $res->partial('view_app_before'); ?>
        <div id="app" class="columns_2">
            <?php $res->partial('header'); ?>
            <?php $res->partial('sidebar_account'); ?> 
            <main>
                <div class="page">
                    <h2>Create API Key</h2>

                    <?php $res->html->messages(); ?>
                    <form method="POST">
                        <?php $res->html->text('Name', 'name'); ?>

                        <?php $res->html->submit('Create'); ?>
                    </form>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

