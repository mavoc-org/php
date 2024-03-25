
            <div id="sidebar_left" class="sidebars">
                <menu>
                    <?php $res->partial('view_sidebar_account_start'); ?>
                    <li><a href="/account">Account</a></li>
                    <?php if(ao()->env('APP_LOGIN_TYPE') == 'db'): ?>
                    <li><a href="/change-password">Change Password</a></li>
                    <?php endif; ?>
                    <li><a href="/api-keys">API Keys</a></li>
                    <li><a href="/settings">Settings</a></li>
                    <?php $res->partial('view_sidebar_account_end'); ?>
                </menu>
            </div>
