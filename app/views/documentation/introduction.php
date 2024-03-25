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
                    <h2>API Introduction</h2>
                    <p>The <?php esc(ao()->env('APP_NAME')); ?> API is available for all public endpoints and requires a premium account to access private endpoints. The main web app uses the same API endpoints that are available to users and developers.</p>
                    <p>In order to access the API, an API key is required. An API key can be created on the <a href="/api-keys">API Keys</a> page in your account. In order to upgrade to a premium account, you can do that on the <a href="https://www.dashboardq.com/services">DashboadQ Services</a> page.</p>
                    <p>If you have any questions or problems, please do not hesitate to reach out to support on the <a href="https://www.dashboardq.com/support">DashboardQ Support</a> page.
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

