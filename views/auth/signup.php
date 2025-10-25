<div class="container signup">
    <?php include_once __DIR__ . '/../templates/logo-name.php'; ?>
    <div class="container-sm">
        <p class="description-page">Sign up on UpTask</p>
        <form action="/signup" class="form" method="POST">
            <div class="field">
                <label for="NAME">Name</label>
                <input 
                    type="text" 
                    name="NAME" 
                    id="NAME"
                    placeholder="Your name"
                />
            </div> <!-- .field -->
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
            <div class="field">
                <label for="PASSWORD2">Confirm Password</label>
                <input 
                    type="password" 
                    name="PASSWORD2" 
                    id="PASSWORD2"
                    placeholder="Confirm your Password"
                />
            </div> <!-- .field -->
            <input type="submit" value="Sign up" class="button">
        </form> <!-- .form -->
        <div class="actions">
            <a href="/">Do you have an account? Log in</a>
            <a href="/forgot">Forgot your password?</a>
        </div> <!-- .actions -->
    </div> <!-- .container-sm -->
</div> <!-- .container signup -->