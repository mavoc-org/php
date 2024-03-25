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
                    <h2><?php esc($title); ?></h2>

                    <?php if(ao()->env('APP_LOGIN_TYPE') == 'db'): ?>
                        <?php $res->html->messages(); ?>
                        <form method="POST">
                            <?php $res->html->password('Old Password'); ?>

                            <?php $res->html->password('New Password'); ?>

                            <?php $res->html->submit('Update'); ?>
                        </form>
                    <?php else: ?>
                        <p>The password cannot be changed on the current system.</p>
                    <?php endif; ?>

                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

