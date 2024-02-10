        <header>
            <div class="box">
                <h2><a href="/"><img src="/assets/images/logo.svg" class="logo" alt="Logo"><?php esc(ao()->env('APP_NAME')); ?></a></h2>
                <nav>
                    <input id="toggle_menu" type="checkbox" />
                    <label for="toggle_menu"><span class="screen_reader">Toggle Menu</span></label>
                    <menu>
                        <li><a href="/">Home</a></li>
                        <li><a href="/pricing">Pricing</a></li>
                        <li><a href="/contact">Contact</a></li>
                        <?php if($user): ?>
                        <li><a href="/account">Account</a></li>
                        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout').submit();">Logout</a></li>
                        <?php else: ?>
                        <li><a href="/login">Login</a></li>
                        <?php endif; ?>
                    </menu>
                </nav>
            </div>
        </header>
