<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?> page_documentation">
        <?php $res->partial('view_app_before'); ?>
        <div id="app" class="columns_2">
            <?php $res->partial('header'); ?>
            <?php $res->partial('sidebar_documentation'); ?> 
            <main>
                <div id="content" class="page">
                    <h2>Client</h2>
                    <p>The source code for this entire project can be found on Github here: <a href="https://github.com/dashboardq">https://github.com/dashboardq</a></p>
                    <p>The source code is set up so that the code can be run either as the primary server of a social network or it can be ran as a client of another server. The code is MIT licensed so feel free to make any changes to the code that you want and use it however you want.</p>
                    <p>In order to demonstrate the client functionality, there is a server set up here: <a href"<?php esc(ao()->env('API_DOC_CLIENT_SITE')); ?>"><?php esc(ao()->env('API_DOC_CLIENT_SITE')); ?></a></p>
                    <p>This server is set up as a client of the sandbox server so all the content it displays comes from the sandbox server.</p>
                    <p>The source code at the client server has the following values set in the `.env.php` file:</p>
                    <div class="code">
                        <pre>
// API
'API_PREFIX' => '<?php esc(ao()->env('API_DOC_PREFIX')); ?>',
'API_SUFFIX' => '<?php esc(ao()->env('API_DOC_SUFFIX')); ?>',
'API_TYPE' => 'client', // client or server
// Below items only needed if client.
'API_BASE' => '<?php esc(ao()->env('API_DOC_SITE')); ?>', // https://example.com
'API_VERSION' => '/api/v0', // /api/v0
'API_REMOTE_USERNAME' => '<?php esc(ao()->env('API_DOC_USERNAME')); ?>',
'API_REMOTE_KEY' => '<?php esc(ao()->env('API_DOC_KEY')); ?>',
</pre>
                    </div>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

