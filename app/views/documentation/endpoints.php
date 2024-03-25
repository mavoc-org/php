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
                    <h2>Endpoints</h2>
                    <p>There are currently 32 endpoints that can be used to interact with the server. Public endpoints can be used by anyone with an API key. Private endpoints require the user with the API key to have a Pro account.</p>
                    <p>An API key can be created on the <a href="/api-keys">API Keys</a> page in your account. In order to upgrade to a Pro account, you can do that on the <a href="https://www.dashboardq.com/services">DashboadQ Services</a> page.</p>
                    <p>Below are the available endpoints (each of these endpoints starts with /api/v0):</p>

                    <p><strong>Public</strong></p>
                    <ul>
                        <li><a href="/documentation/endpoint/miscellaneous">GET /hello</a></li>
                        <li><a href="/documentation/endpoint/miscellaneous">POST /hello</a></li>
                        <li><a href="/documentation/endpoint/metrics">GET /metric/users</a></li>
                    </ul>

                    <p><strong>Private</strong></p>
                    <ul>
                        <li><a href="/documentation/endpoint/settings">GET /settings</a></li>
                        <li><a href="/documentation/endpoint/settings">GET /settings/timezones</a></li>
                        <li><a href="/documentation/endpoint/settings">POST /settings</a></li>
                        <li><a href="/documentation/endpoint/user">GET /user</a></li>
                        <li><a href="/documentation/endpoint/user">POST /user</a></li>
                    </ul>

                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

