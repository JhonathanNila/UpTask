<div class="container login">
    <?php include_once __DIR__ . '/../templates/logo-name.php'; ?>
    <div class="container-sm">
        <p class="description-page">Let’s get to work! Log in</p>
        <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
        <form action="/" class="form" method="POST">
            <div class="field">
                <label for="EMAIL">Email</label>
                <input 
                    type="email" 
                    name="EMAIL" 
                    id="EMAIL"
                    placeholder="Your Email"
                />
            </div> <!-- .field -->
            <div class="field">
                <label for="PASSWORD">Password</label>
                <input 
                    type="password" 
                    name="PASSWORD" 
                    id="PASSWORD"
                    placeholder="Your Password"
                />
            </div> <!-- .field -->
            <input type="submit" value="Login" class="button">
        </form> <!-- .form -->
        <div class="actions">
            <a href="/signup">Don’t have an account? Sign up</a>
            <a href="/forgot">Forgot your password?</a>
        </div> <!-- .actions -->
    </div> <!-- .container-sm -->
</div> <!-- .container login -->