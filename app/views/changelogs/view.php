<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>

        <link rel="alternate" type="application/rss+xml" title="PipeRiv Changelog" href="<?php uri('changelog/rss'); ?>" />
    </head>
    <body class="<?php $res->pathClass(); ?>">
        <?php $res->partial('view_app_before'); ?>
        <div id="app">
            <?php $res->partial('header'); ?>
            <main>
                <?php $res->html->messages(); ?>
                <div class="page">
                    <h1>Changelog - <?php esc($item->data['created_at']->format('l, M j, Y')); ?></h1>
                    <a href="/changelog">&lt; Back</a>
                    <article>
                        <div class="content">
                            <?php md($item->data['content']); ?>
                        </div>
                    </article>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>
