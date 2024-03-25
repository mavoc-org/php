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
                    <h2>Response</h2>
                    <p>The response from an API call will always be JSON. The JSON response will have four primary keys: status, messages, meta, and data.</p>
                    <p>The `status` value will either be `success` or `error`.</p>
                    <p>The `messages` value will be an array of messages. Typically the `messages` value will be an empty array. It will generally be used for error responses (like validation errors) but it could also be used to send additional information during a successful response.</p>
                    <p>The `meta` value will contain additional details about the response. For example, it could include pagination information or other relevant information.</p>
                    <p>The `data` value is where the actual data for the response is found (if the endpoint returns data). Depending on the endpoint, the `data` could be an array of values or it could be a single value.</p>

                    <h3>Success</h3>
                    <p>Below is an example of a successful response:</p>
                    <div class="code">
                        <code>curl <?php esc(ao()->env('API_DOC_SITE')); ?>/api/v0/hello -u "<?php esc(ao()->env('API_DOC_USERNAME')); ?>:<?php esc(ao()->env('API_DOC_KEY')); ?>"</code>
                    </div>
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

                    <h3>Error</h3>
                    <div class="code">
                        <code>curl <?php esc(ao()->env('API_DOC_SITE')); ?>/api/v0/hello -u "<?php esc(ao()->env('API_DOC_USERNAME')); ?>:<?php esc(ao()->env('API_DOC_KEY')); ?>"</code>
                    </div>
                    <p>Below is an example of an error response:</p>
                    <div class="code">
                        <pre>
{
  "status": "error",
  "messages": [
    "The API user or key does not appear to be valid."
  ],
  "meta": {},
  "data": {}
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

