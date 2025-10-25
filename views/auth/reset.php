<div class="container reset">
    <?php include_once __DIR__ . '/../templates/logo-name.php'; ?>
    <div class="container-sm">
        <p class="description-page">Enter your new Password</p>
        <form action="/reset" class="form" method="POST">
            <div class="field">
                <label for="PASSWORD">New Password</label>
                <input 
                    type="password" 
                    name="PASSWORD" 
                    id="PASSWORD"
                    placeholder="Your new Password"
                />
            </div> <!-- .field -->
            <input type="submit" value="Set Password" class="button">
        </form> <!-- .form -->
        <div class="actions">
            <a href="/">Do you have an account? Log in</a>
            <a href="/signup">Don’t you have an account? Sign up</a>
        </div> <!-- .actions -->
    </div> <!-- .container-sm -->
</div> <!-- .container reset -->