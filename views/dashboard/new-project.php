        <?php include_once __DIR__ . '/header-dashboard.php'; ?>
                <div class="container-sm">
                        <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
                        <form action="new-project" class="form" method="POST">
                                <?php include_once __DIR__ . '/project-form.php'; ?>
                                <input type="submit" value="New Project">
                        </form>
                </div>
        <?php include_once __DIR__ . '/footer-dashboard.php'; ?>