<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?>">
        <div id="app">
            <?php $res->partial('header-private'); ?>
            <main>
                <section class="box">
                    <h2><?php esc($title); ?></h2>

                    <?php $res->html->messages(); ?>
                    <form method="POST">
                        <?php $res->html->select('Timezone', 'timezone', $timezones); ?>

                        <?php $res->html->submit('Save'); ?>
                    </form>

                </section>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
		<?php $res->partial('foot'); ?>
    </body>
</html>
