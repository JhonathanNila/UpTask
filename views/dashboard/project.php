<?php include_once __DIR__ . '/header-dashboard.php'; ?>
    <div class="container-sm">
        <div class="container-new-task">
            <button 
                type="button" 
                class="add-task"
                id="add-task"
            >&#43; New Task</button>
        </div>
        <div class="filters" id="filters">
            <div class="inputs-filters">
                <h2>Status Filters:</h2>
                <div class="field">
                    <label for="all">All Tasks</label>
                    <input 
                        type="radio" 
                        name="filter" 
                        id="all"
                        checked
                        value=""
                    />
                </div>
                <div class="field">
                    <label for="completed">Completed Tasks</label>
                    <input 
                        type="radio" 
                        name="filter" 
                        id="completed"
                        value="1"
                    />
                </div>
                <div class="field">
                    <label for="new">New Tasks</label>
                    <input 
                        type="radio" 
                        name="filter" 
                        id="new"
                        value="0"
                    />
                </div>
            </div>
        </div>
        <ul id="tasks-list" class="tasks-list"></ul>
    </div>
<?php include_once __DIR__ . '/footer-dashboard.php'; ?>
<?php
    $script = '
    <script src="build/js/tasks.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    ';
?>
