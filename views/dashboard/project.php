<?php include_once __DIR__ . '/header-dashboard.php'; ?>
    <div class="container-sm">
        <div class="container-new-task">
            <button 
                type="button" 
                class="add-task"
                id="add-task"
            >&#43; New Task</button>
        </div>
        <ul id="tasks-list" class="tasks-list"></ul>
    </div>
<?php include_once __DIR__ . '/footer-dashboard.php'; ?>
<?php
    $script = '
    <script src="build/js/tasks.js"></script>
    <script src="build/js/app.js"></script>
    ';
?>
