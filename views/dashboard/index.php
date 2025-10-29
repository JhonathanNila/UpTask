<?php include_once __DIR__ . '/header-dashboard.php'; ?>
        <?php if(count($projects) === 0) : ?>
                <p class="no-projects">No projects yet<a href="/new-project">New Project</a></p>
                <?php  else : ?>
                <ul class="projects-list">
                        <?php foreach($projects as $project) : ?>
                                <li class="project">
                                        <a href="/project?id=<?php echo $project->URL; ?>">
                                                <?php echo $project->PROJECT; ?>
                                        </a>
                                </li>
                        <?php endforeach; ?>
                </ul>
        <?php endif; ?>
<?php include_once __DIR__ . '/footer-dashboard.php'; ?>