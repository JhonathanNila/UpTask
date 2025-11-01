(function() {
    const newTaskBtn = document.querySelector('#add-task');
    newTaskBtn.addEventListener('click', showForm);

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
            console.log(result);
            showAlert(result.message, result.type, document.querySelector('.form legend'));
            if(result.type === 'success') {
                const modal = document.querySelector('.modal');
                setTimeout(() => {
                    modal.remove();
                }, 3000);
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