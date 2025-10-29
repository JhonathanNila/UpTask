(function() {
    const newTaskBtn = document.querySelector('#add-task');
    newTaskBtn.addEventListener('click', showForm);

    function showForm() {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        <form action="" class="form new-task">
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
        });

        document.querySelector('body').appendChild(modal);
    }
})();