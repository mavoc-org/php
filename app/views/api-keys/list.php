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
                    <h2>API Keys</h2>
                    <p><a href="/api-key/add" class="button">Create API Key</a>

                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Key</th>
                                <th>Issued</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($keys) == 0): ?>
                            <tr>
                                <td colspan="4">No results.</td>
                            </tr>
                            <?php endif; ?>
                            <?php foreach($keys as $key): ?>
                            <tr>
                                <td data-label="Name"><?php esc($key->data['name']); ?></td>
                                <td data-label="Key"><?php esc($key->data['display_key']); ?></td>
                                <td data-label="Issued"><?php esc($key->data['created_tz']->format('Y-m-d H:i')); ?></td>
                                <td data-label="Actions">
                                    <?php $res->html->delete('/api-key/delete/' . $key->id); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

