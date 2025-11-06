<?php include_once __DIR__ . '/header-dashboard.php'; ?>
        <div class="container-sm">
                <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
                <a href="/profile" class="link">Return to Profile</a>
                <form class="form" method="post" action="/changePassword">
                        <div class="field">
                                <label for="PASSWORD">Current Password: </label>
                                <input 
                                        type="password"
                                        name="PASSWORD_CURRENT" 
                                        placeholder="Your Current Password"
                                />
                        </div>
                        <div class="field">
                                <label for="">New Password: </label>
                                <input 
                                        type="PASSWORD"
                                        name="PASSWORD_NEW" 
                                        placeholder="Your New Password"
                                />
                        </div>
                        <input type="submit" value="Save Changes">
                </form>
        </div>
<?php include_once __DIR__ . '/footer-dashboard.php'; ?>