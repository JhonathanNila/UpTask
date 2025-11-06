<?php include_once __DIR__ . '/header-dashboard.php'; ?>
        <div class="container-sm">
                <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
                <a href="/changePassword" class="link">Change Password</a>
                <form class="form" method="post" action="/profile">
                        <div class="field">
                                <label for="NAME">Name: </label>
                                <input 
                                        type="text"
                                        value="<?php echo $user->NAME; ?>"
                                        name="NAME" 
                                        placeholder="Your Name"
                                />
                        </div>
                        <div class="field">
                                <label for="EMAIL">Email: </label>
                                <input 
                                        type="EMAIL"
                                        value="<?php echo $user->EMAIL; ?>"
                                        name="EMAIL" 
                                        placeholder="Your Email"
                                />
                        </div>
                        <input type="submit" value="Save Changes">
                </form>
        </div>
<?php include_once __DIR__ . '/footer-dashboard.php'; ?>