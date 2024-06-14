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
                    <?php $res->partial('app_view_before_h1'); ?>
                    <h1>Changelog</h1>
                    <?php $res->partial('app_view_after_h1'); ?>
                    <?php foreach($items as $item): ?>
                    <article>
                        <div class="meta">
                            <a href="/changelog/<?php esc($item->id); ?>"><?php esc($item->data['created_at']->format('l, M j, Y')); ?></a> 
                        </div>
                        <div class="content">
                            <?php md($item->data['content']); ?>
                        </div>
                    </article>
                    <?php endforeach; ?>

                    <?php if($pagination): ?>
                    <div class="pagination">
                        <p>Results <?php esc($pagination['current_result'] . '-' . $pagination['current_result_last'] . ' of ' . $pagination['total_results']); ?> <?php if($pagination['page_previous'] != $pagination['page_current']): ?>&lt; <a href="<?php esc($pagination['url_previous']); ?>">Prev</a><?php endif; ?> <?php if($pagination['page_next'] != $pagination['page_current']): ?><a href="<?php esc($pagination['url_next']); ?>">Next</a> &gt;<?php endif; ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>
