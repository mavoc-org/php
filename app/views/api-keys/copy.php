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
                    <h2>Copy API Key</h2>
                    <p>Your API Key has been created. Please copy the key below to a secure location. Once you leave this page, it will no longer be available to copy.</p>
                    <p><a href="/api-keys">&lt; Return To API Key List</a></p>

                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Key</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="Name"><?php esc($item->data['name']); ?></td>
                                <td data-label="Key"><?php esc($item->data['raw_key']); ?></td>
                                <td data-label="Actions">
                                    <?php $res->html->button('Copy', '', 'data-copy="' . _esc($item->data['raw_key']) . '"'); ?>
                                </td>
                            </tr>
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

