(function() {
    getTasks();
    let tasks = [];
    let filtered = [];
    const newTaskBtn = document.querySelector('#add-task');
    newTaskBtn.addEventListener('click', function() {
        showForm(false);
    });
    const filters = document.querySelectorAll('#filters input[type="radio"]');
    filters.forEach(radio => {
        radio.addEventListener('input', filterTask);
    });
    function filterTask(e) {
        const filter = e.target.value;
        if(filter !== '') {
            filtered = tasks.filter(task => task.STATUS === filter);
        } else {
            filtered = [];
        }
        showTasks();
    }
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
        totalNew();
        totalCompleted();
        const taskArray = filtered.length ? filtered : tasks;
        if(taskArray.length === 0) {
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
        taskArray.forEach(task => {
            const containerTask = document.createElement('LI');
            containerTask.dataset.taskId = task.ID;
            containerTask.classList.add('task');

            const taskName = document.createElement('P');
            taskName.textContent = task.TASK;
            taskName.ondblclick = function() {
                showForm(true, {...task});
            }

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
            btnDeleteTask.ondblclick = function() {
                confirmDeleteTask({...task});
            }

            optionsDiv.appendChild(btnStatusTask);
            optionsDiv.appendChild(btnDeleteTask);
            containerTask.appendChild(taskName);
            containerTask.appendChild(optionsDiv);
            const taskList = document.querySelector('#tasks-list');
            taskList.appendChild(containerTask);
        });
    }
    function totalNew() {
        const totalNew = tasks.filter(task => task.STATUS === "0");
        const newRadio = document.querySelector('#new');
        if(totalNew.length === 0) {
            newRadio.disabled = true;
        } else {
            newRadio.disabled = false;
        }
    }
    function totalCompleted() {
        const totalCompleted = tasks.filter(task => task.STATUS === "1");
        const completedRadio = document.querySelector('#completed');
        if(totalCompleted.length === 0) {
            completedRadio.disabled = true;
        } else {
            completedRadio.disabled = false;
        }
    }
    function cleanTasks() {
        const tasksList = document.querySelector('#tasks-list');
        while(tasksList.firstChild) {
            tasksList.removeChild(tasksList.firstChild);
        }
    }
    function showForm(edit = false, task={}) {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        <form class="form new-task">
            <legend>${edit ? 'Edit Task' : 'Add a New Task'}</legend>
                <div class="field">
                    <label for="TASK">Task</label>
                    <input 
                        type="text" 
                        name="TASK" 
                        id="TASK"
                        placeholder="${task.TASK ? 'Edit Task' : 'Add a New Task'}"
                        value="${task.TASK ? task.TASK : ''}"
                    />
                </div>
                <div class="options">
                    <input 
                        type="submit" 
                        value="${task.TASK ? 'Save Change' : 'Add Task'}"
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
                const nameTask = document.querySelector('#TASK').value.trim();
                if(nameTask === '') {
                    showAlert('The name task is required', 'error', document.querySelector('.form legend'));
                    return;
                }
                if(edit) {
                    task.TASK = nameTask;
                    updateTask(task);
                } else {
                    addTask(nameTask);
                }
            }
        });
        document.querySelector('.dashboard').appendChild(modal);
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
                Swal.fire(
                    result.response.message,
                    '',
                    'success'
                );
                const modal = document.querySelector('.modal');
                if(modal) {
                    modal.remove();
                }
                tasks = tasks.map(memoryTask => {
                    if(memoryTask.ID === ID) {
                        memoryTask.STATUS = STATUS;
                        memoryTask.TASK = TASK;
                    }
                    return memoryTask;
                });
                showTasks();
            }
        } catch (error) {
            console.log(error);
        }
    }
    function confirmDeleteTask(task) {
        Swal.fire({
            title: "Delete tasks?",
            showCancelButton: true,
            confirmButtonText: "Yes",
            showCancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteTask(task);
            }
        });
    }
    async function deleteTask(task) {
        const {ID, STATUS, TASK} = task;
        const data = new FormData();
        data.append('ID', ID);
        data.append('STATUS', STATUS);
        data.append('TASK', TASK);
        data.append('PROJECT_ID', getProject());
        try {
            const url = 'http://localhost:3000/api/task/delete';
            const response = await fetch(url, {
                method: 'POST',
                body: data
            });
            const result = await response.json();
            if(result.result) {
                // showAlert(
                //     result.message, 
                //     result.type, 
                //     document.querySelector('.container-new-task')
                // );
                Swal.fire('Task Deleted!', result.message, 'success');
                tasks = tasks.filter(memoryTask => memoryTask.ID !== task.ID);
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