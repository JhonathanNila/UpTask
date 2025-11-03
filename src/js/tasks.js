(function() {
    getTasks();
    let tasks = [];
    const newTaskBtn = document.querySelector('#add-task');
    newTaskBtn.addEventListener('click', showForm);
    async function getTasks() {
        try {
            const id = getProject();
            const url = `/api/tasks?id=${id}`;
            const response = await fetch(url);
            const result = await response.json();
            tasks = result.tasks;
            showTasks();
        } catch (error) {
            console.log(error);
        }
    }
    function showTasks() {
        cleanTasks();
        if(tasks.length === 0) {
            const containerTasks = document.querySelector('#tasks-list');
            const textNoTasks = document.createElement('LI');
            textNoTasks.textContent = 'No tasks yet';
            textNoTasks.classList.add('no-tasks');
            containerTasks.appendChild(textNoTasks);
            return;
        }
        const status = {
            0: 'New',
            1: 'Completed'
        };
        tasks.forEach(task => {
            const containerTask = document.createElement('LI');
            containerTask.dataset.taskId = task.ID;
            containerTask.classList.add('task');
            const taskName = document.createElement('P');
            taskName.textContent = task.TASK;
            const optionsDiv = document.createElement('DIV');
            optionsDiv.classList.add('options');
            const btnStatusTask = document.createElement('BUTTON');
            btnStatusTask.classList.add('status-task');
            btnStatusTask.classList.add(`${status[task.STATUS].toLowerCase()}`);
            btnStatusTask.textContent = status[task.STATUS];
            btnStatusTask.dataset.statusTask = task.STATUS;
            btnStatusTask.ondblclick = function() {
                changeStatusTask({...task});
            }

            const btnDeleteTask = document.createElement('BUTTON');
            btnDeleteTask.classList.add('delete-task');
            btnDeleteTask.dataset.taskId = task.ID;
            btnDeleteTask.textContent = 'Delete';

            optionsDiv.appendChild(btnStatusTask);
            optionsDiv.appendChild(btnDeleteTask);
            containerTask.appendChild(taskName);
            containerTask.appendChild(optionsDiv);
            const taskList = document.querySelector('#tasks-list');
            taskList.appendChild(containerTask);
        });
    }
    function cleanTasks() {
        const tasksList = document.querySelector('#tasks-list');
        while(tasksList.firstChild) {
            tasksList.removeChild(tasksList.firstChild);
        }
    }
    function showForm() {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        <form class="form new-task">
            <legend>Add a New Task</legend>
                <div class="field">
                    <label for="TASK">Task</label>
                    <input 
                        type="text" 
                        name="TASK" 
                        id="TASK"
                        placeholder="New Task"
                    />
                </div>
                <div class="options">
                    <input 
                        type="submit" 
                        value="Add Task" 
                        class="submit-new-task"
                    />
                    <button type="button" class="close-modal">Cancel</button>
                </div>
        </form>
        `;
        setTimeout(() => {
            const form = document.querySelector('.form');
            form.classList.add('animate');
        }, 0);
        modal.addEventListener('click', function(e) {
            e.preventDefault();
            if(e.target.classList.contains('close-modal')) {
                const form = document.querySelector('.form');
                form.classList.add('close');
                setTimeout(() => {
                    modal.remove();
                }, 1000);
            }
            if(e.target.classList.contains('submit-new-task')) {
                submitNewTaskForm();
            }
        });
        document.querySelector('.dashboard').appendChild(modal);
    }
    function submitNewTaskForm() {
        const task = document.querySelector('#TASK').value.trim();
        if(task === '') {
            showAlert('The name task is required', 'error', document.querySelector('.form legend'));
            return;
        }
        addTask(task);
    }
    function showAlert(message, type, reference) {
        const previousAlert = document.querySelector('.alert');
        if(previousAlert) {
            previousAlert.remove();
        }
        const alert = document.createElement('DIV');
        alert.classList.add('alert', type);
        alert.textContent = message;
        reference.parentElement.insertBefore(alert, reference.nextElementSibling);
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
    async function addTask(task) {
        const data = new FormData();
        data.append('TASK', task);
        data.append('PROJECT_ID', getProject());
        try {
            const url = 'http://localhost:3000/api/task';
            const response = await fetch(url, {
                method: 'POST',
                body: data
            });
            const result = await response.json();
            showAlert(result.message, result.type, document.querySelector('.form legend'));
            if(result.type === 'success') {
                const modal = document.querySelector('.modal');
                setTimeout(() => {
                    modal.remove();
                }, 3000);
                const taskObj = {
                    ID: String(result.ID),
                    TASK: task,
                    STATUS: "0",
                    PROJECT_ID: result.PROJECT_ID
                };
                tasks = [...tasks, taskObj];
                showTasks();
            }
        } catch (error) {
            console.log(error);
        }
    }
    function changeStatusTask(task) {
        const newStatus = task.STATUS === "1" ? "0" : "1";
        task.STATUS = newStatus;
        updateTask(task);
    }
    async function updateTask(task) {
        const {ID, PROJECT_ID, STATUS, TASK} = task;
        const data = new FormData();
        data.append('ID', ID);
        data.append('STATUS', STATUS);
        data.append('TASK', TASK);
        data.append('PROJECT_ID', getProject());
        // for(let value of data.values()) {
        //     console.log(value);
        // }
        try {
            const url = 'http://localhost:3000/api/task/update';
            const response = await fetch(url, {
                method: 'POST',
                body: data
            });
            const result = await response.json();
            if(result.response.type === 'success') {
                showAlert(
                    result.response.message, 
                    result.response.type, 
                    document.querySelector('.container-new-task')
                );
                tasks = tasks.map(memoryTask => {
                    if(memoryTask.ID === ID) {
                        memoryTask.STATUS = STATUS;
                    }
                    return memoryTask;
                });
                showTasks();
            }
        } catch (error) {
            console.log(error);
        }
    }
    function getProject() {
        const projectParams = new URLSearchParams(window.location.search);
        const project = Object.fromEntries(projectParams.entries());
        return project.id;
    }
})();