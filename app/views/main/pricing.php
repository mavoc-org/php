<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?>">
        <?php $res->partial('view_app_before'); ?>
        <div id="app">
            <?php $res->partial('header'); ?>
            <main>
                <div class="box">
                    <h1>Pricing</h1>
                    <ul>
                        <li>
                            <h2>Free</h2>
                            <h3>$0 / month</h3>
                            <a href="/login" class="button">Get Started</a>
                            <ul>
                                <li>Benefit <strong>1 listed</strong> here</li>
                            </ul>
                            <a href="/login" class="button">Get Started</a>
                        </li>
                        <li class="card -highlight">
                            <h2>Basic</h2>
                            <h3>$12 / month</h3>
                            <ul>
                                <li>Benefit <strong>1 listed</strong> here</li>
                                <li>Benefit <strong>2 listed</strong> here</li>
                            </ul>
                        </li>
                        <li class="card">
                            <h2>Intermediate</h2>
                            <h3>$48/mo</h3>
                            <a href="/login" class="button">Get Started</a>
                            <ul>
                                <li>Benefit <strong>1 listed</strong> here</li>
                                <li>Benefit <strong>2 listed</strong> here</li>
                                <li>Benefit <strong>3 listed</strong> here</li>
                            </ul>
                        </li>
                        <li class="card">
                            <h2>Advanced</h2>
                            <h3>$98 / month</h3>
                            <a href="/login" class="button">Get Started</a>
                            <ul>
                                <li>Benefit <strong>1 listed</strong> here</li>
                                <li>Benefit <strong>2 listed</strong> here</li>
                                <li>Benefit <strong>3 listed</strong> here</li>
                                <li>Benefit <strong>4 listed</strong> here</li>
                            </ul>
                        </li>
                        <li class="card">
                            <h2>Custom</h2>
                            <h3>Get In Touch</h3>
                            <a href="/login" class="button">Get Started</a>
                            <ul>
                                <li>If you are not seeing a plan that meets your needs, please feel free to reach out.</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>
