<aside class="sidebar">
    <div class="sidebar-container">
        <h2>UpTask</h2>
        <div class="close-menu">
            <img src="build/img/cerrar.svg" alt="Close Mobile Menu Image" id="close-menu">
        </div>
    </div>
    <nav class="sidebar-nav">
        <a class="<?php echo ($title === 'Dashboard') ? 'active' : ''; ?>" href="/dashboard">Dashboard</a>
        <a class="<?php echo ($title === 'New Project') ? 'active' : ''; ?>" href="/new-project">New Project</a>
        <a class="<?php echo ($title === 'Profile') ? 'active' : ''; ?>" href="/profile">Profile</a>
    </nav>
    <div class="logout-mobile">
        <a href="/logout" class="logout">Log out</a>
    </div>
</aside>