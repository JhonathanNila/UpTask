<div class="container forgot">
    <?php include_once __DIR__ . '/../templates/logo-name.php'; ?>
    <div class="container-sm">
        <p class="description-page">Don’t remember your password? Enter your email and we’ll send you the instructions</p>
        <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
        <form action="/forgot" class="form" method="POST" novalidate>
            <div class="field">
                <label for="EMAIL">Email</label>
                <input 
                    type="email" 
                    name="EMAIL" 
                    id="EMAIL"
                    placeholder="Your Email"
                />
            </div> <!-- .field -->
            <input type="submit" value="Send Instructions" class="button">
        </form> <!-- .form -->
        <div class="actions">
            <a href="/">Don’t you have an account? Log in</a>
            <a href="/signup">Don’t you have an account? Sign up</a>
        </div> <!-- .actions -->
    </div> <!-- .container-sm -->
</div> <!-- .container forgot -->