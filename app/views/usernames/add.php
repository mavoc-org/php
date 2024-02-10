<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?>">
        <div id="app">
            <?php $res->partial('header'); ?>
            <main>
                <div class="page">
                    <h1>Add Username</h1>
                    <p>Please choose a username. The username will be used for your account:<br>
                    <?php esc(ao()->env('APP_SITE')) ?>/<strong>Your_Username_Here</strong></p>

                    <?php $res->html->messages(); ?>
                    <form action="/username/create" method="POST">
                        <?php $res->html->text('Username', 'name'); ?>
                        <?php $res->html->submit('Add', 'button button_invert'); ?>
                    </form>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
		<?php $res->partial('foot'); ?>
    </body>
</html>
