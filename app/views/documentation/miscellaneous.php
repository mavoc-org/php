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
                    <h2>Miscellaneous</h2>
                    <p>Both of the miscellaneous endpoints are public and do not require a Premium account.</p>

					<hr>
					<h3>GET /hello</h3>
					<p>Public endpoint. Provides a simple way to test a GET endpoint.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl <?php esc(ao()->env('API_DOC_SITE')); ?>/api/v0/hello -u "<?php esc(ao()->env('API_DOC_USERNAME')); ?>:<?php esc(ao()->env('API_DOC_KEY')); ?>"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "name": "World"
  }
}</pre>
                    </div>

					<hr>
					<h3>POST /hello</h3>
					<p>Public endpoint. Provides a simple way to test a POST endpoint.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl <?php esc(ao()->env('API_DOC_SITE')); ?>/api/v0/hello -u "<?php esc(ao()->env('API_DOC_USERNAME')); ?>:<?php esc(ao()->env('API_DOC_KEY')); ?>" -d "name=Friend"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "name": "Friend"
  }
}</pre>
                    </div>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

