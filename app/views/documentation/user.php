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
                    <h2>User</h2>
                    <p>Both of the user endpoints are private and require a Premium account.</p>
					<hr>
					<h3>GET /user</h3>
					<p>Private endpoint. Provides details about the user account.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl <?php esc(ao()->env('API_DOC_SITE')); ?>/api/v0/user -u "<?php esc(ao()->env('API_DOC_USERNAME')); ?>:<?php esc(ao()->env('API_DOC_KEY')); ?>"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "user_id": 1,
    "username": "<?php esc(ao()->env('API_DOC_USERNAME')); ?>",
    "name": "<?php esc(ucwords(ao()->env('API_DOC_USERNAME'))); ?>",
    "timezone": "UTC"
  }
}
</pre>
                    </div>
					<hr>
					<h3>POST /user</h3>
					<p>Private endpoint. Updates the user with the information provided.</p>
                    <h4>Request body</h4>
                    <p><strong>name</strong>: string<br>
                    The name for the account.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>

                    <div class="code">
                        <code>curl <?php esc(ao()->env('API_DOC_SITE')); ?>/api/v0/account -u "<?php esc(ao()->env('API_DOC_USERNAME')); ?>:<?php esc(ao()->env('API_DOC_KEY')); ?>" -d "name=<?php esc(ucwords(ao()->env('API_DOC_USERNAME'))); ?> Updated"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "user_id": 1,
    "username": "<?php esc(ao()->env('API_DOC_USERNAME')); ?>",
    "name": "<?php esc(ucwords(ao()->env('API_DOC_USERNAME'))); ?> Updated",
    "timezone": "UTC"
  }
}
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

