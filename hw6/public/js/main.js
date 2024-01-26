import { router, setupNavigation} from './router.js';


document.addEventListener('DOMContentLoaded', (event) => {
    setupNavigation();
    router();
});


function navigateTo(page, id = '') {
    window.location.hash = `#page=${page}${id ? '&id=' + id : ''}`;
    router();
}


function updateMainContent(html) {
    const mainContent = document.getElementById('main-content');
    mainContent.innerHTML = html;
}

document.addEventListener('DOMContentLoaded', () => {
    const employeeForm = document.getElementById('employee-form');
    employeeForm.addEventListener('submit', function(event) {
        if (document.activeElement.name === 'deleteButton') {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this employee?')) {
                fetch('/hw6/api/delete-employee.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${id}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Employee deleted successfully');
                            window.location.hash = '#page=employee-list';
                            window.location.reload();
                        } else {
                            alert('Failed to delete employee');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }
    });
});


document.addEventListener('click', function(event) {
    if (event.target.matches('.employee-edit-link')) {
        event.preventDefault();
        const employeeId = event.target.getAttribute('data-id');
        navigateTo('employee-form', employeeId);
    }
    else if (event.target.matches('.task-edit-link')) {
        event.preventDefault();
        const taskId = event.target.getAttribute('data-id');
        navigateTo('task-form', taskId);
    }
});



function fetchAndDisplayDashboard() {
    fetch('/hw6/api/dashboard.php')
        .then(response => response.json())
        .then(data => {
            console.log('Data received:', data);
            updateMainContent(renderDashboard(data));
        })
        .catch(error => {
            console.error('Error fetching dashboard data:', error);
        });
}

function renderDashboard(data) {

    if (!data || !Array.isArray(data.employees) || !Array.isArray(data.tasks)) {
        console.error('Invalid data', data);
        return '<p>Invalid data received from the server</p>';
    }

    let html = `<div class="dashboard">`;
    html += `<div class="dashboard-column">`;

    html += `<div class="content-card"><div class="content-card-header">Employees</div>`;
    data.employees.forEach(employee => {
        html += `
            <div class="employee-item">
                <img src="${employee.profile_picture}" alt="Profile picture of ${employee.name}"/>
                <span class="name">${employee.name}</span>
                <span class="count">${employee.task_count}</span>
                <br><span class="position">${employee.position}</span>
            </div>
        `;
    });
    html += `</div>`;
        html += ` </div>`;
    html += `<div class="dashboard-column"</div>`;
    html += `<div class="content-card"> <div class="content-card-header">Tasks</div>`;
    data.tasks.forEach(task => {
        html += `
            <div class="task ${task.status.toLowerCase()}">
               <a class="task-edit-link" data-id="${task.id}" href="#">Edit</a>
                <div class="title">
                    <div>${task.description}</div>
                </div>
                <br>
                <div class="status ${task.status.toLowerCase()}">${task.status}</div>
                ${task.estimateDots ? task.estimateDots.map(dot => `<div class="dot ${dot}"></div>`).join('') : ''}
            </div>
        `;
    });
    html += `</div>`;
    html += `</div>`;
    html += `</div>`;

    return html;
}

document.getElementById('employee-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    const isEdit = formData.get('id') !== '';

    if (isEdit) {
        updateEmployee(formData);
    } else {
        createEmployee(formData);
    }
});

function createEmployee(formData) {
    fetch('/hw6/api/create-employee.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                navigateTo('employee-list');
            } else {
                alert('Failed to create employee: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function updateEmployee(formData) {
    fetch('/hw6/api/update-employee.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                navigateTo('employee-list');
            } else {
                alert('Failed to update employee: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}




document.getElementById('task-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    const jsonObject = {};
    formData.forEach((value, key) => { jsonObject[key] = value; });
    fetch('/hw6/api/save-task.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(jsonObject)
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            // Handle response
        })
        .catch(error => {
            console.error('Error:', error);
        });
});


function fetchAndDisplayEmployeeList() {
    fetch('/hw6/api/employee-list.php')
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                updateMainContent(renderEmployeeList(data));
            } else {
                console.error('Employee list data is not an array.');
            }
        })
        .catch(error => {
            console.error('Error fetching employee list data:', error);
        });
}


function renderEmployeeList(employees) {
    setupNavigation();
    const root = document.getElementById('main-content');

    root.innerHTML = `
        <div class="content-card">
            <div class="content-card-header">Employees</div>
            <div class="content-card-content">
                ${employees.map(employee => `
                    <div class="employee-item">
                     <img class="employee-photo" src="${employee.profile_picture || 'missing.png'}" 
                        alt="Profile picture of ${employee.firstName} ${employee.lastName}" 
                      data-employee-id="${employee.id}" />
                    <span class="name" data-employee-id="${employee.id}">
                       ${employee.firstName || 'No first name'} ${employee.lastName || 'No last name'}
                     </span>
            <span class="position">${employee.position || 'No position'}</span>
            <span class="link">
                <a href="#" class="employee-edit-link" data-id="${employee.id}">Edit</a>
            </span>
        </div>
                `).join('')}
            </div>
        </div>`;
    document.getElementById('root');
    root.innerHTML = `
        <div class="content-card">
            <div class="content-card-header">Employees</div>
            <div class="content-card-content">
                <div class="employee-list">
                    ${employeeHtml}
                </div>
            </div>
        </div>`;
}

function fetchAndDisplayEmployeeForm(employeeId = null) {
    const endpoint = employeeId ? `/hw6/api/get-employee.php?id=${employeeId}` : '/hw6/api/employee-form.php';

    fetch(endpoint)
        .then(response => response.json())
        .then(employee => {
            if (employee) {
                renderEmployeeForm(employee);
            } else {
                console.error('Employee data not found for ID:', employeeId);
            }
        })
        .catch(error => {
            console.error('Error fetching employee data:', error);
        });
}

function renderEmployeeForm(employee = {}) {

    setupNavigation();

    const root = document.getElementById('main-content');
    const isEdit = !!employee.id;

    root.innerHTML = `
        <div class="content-card">
            <div class="content-card-header">${isEdit ? 'Edit' : 'Add'} Employee</div>
            <div class="content-card-content">
                <form id="employee-form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="${employee.id || ''}">

                    <div class="label-cell"><label for="fn">First name:</label></div>
                    <div class="input-cell">
                        <input type="text" name="firstName" id="fn" value="${employee.firstName || ''}" required>
                    </div>

                    <div class="label-cell"><label for="ln">Last name:</label></div>
                    <div class="input-cell">
                        <input type="text" name="lastName" id="ln" value="${employee.lastName || ''}" required>
                    </div>

                    <div class="label-cell"><label for="position">Position:</label></div>
                    <div class="input-cell">
                        <select id="position" name="position" required>
                            <option value=""></option>
                            <option value="Manager" ${employee.position === 'Manager' ? 'selected' : ''}>Manager</option>
                            <option value="Developer" ${employee.position === 'Developer' ? 'selected' : ''}>Developer</option>
                            <option value="Designer" ${employee.position === 'Designer' ? 'selected' : ''}>Designer</option>
                            <option value="Office Pet" ${employee.position === 'Office Pet' ? 'selected' : ''}>Office Pet</option>
                        </select>
                    </div>

                    <div class="label-cell"><label for="pic">Picture:</label></div>
                    <div class="input-cell">
                        <input id="pic" name="profile_picture" type="file"/>
                        <label id="file-input-label" for="pic">
                            ${employee.profile_picture && employee.profile_picture !== 'missing.png' ? `Current file: ${employee.profile_picture}` : 'Select a file'}
                        </label>
                    </div>

                    <div class="input-cell button-cell">
                        ${isEdit ? `<button type="button" class="button danger" id="deleteButton">Delete</button>` : ''}
                        <button type="submit" class="main" name="submitButton">${isEdit ? 'Update' : 'Create'}</button>
                    </div>
                </form>
            </div>
        </div>`;

    const employeeForm = document.getElementById('employee-form');


    employeeForm.addEventListener('submit', function(event) {
        event.preventDefault();
        handleEmployeeFormSubmit(isEdit ? 'edit' : 'create');
    });


    if (isEdit) {
        const deleteButton = document.getElementById('deleteButton');
        deleteButton.addEventListener('click', function() {
            deleteEmployee(employee.id);
        });
    }
}

function handleEmployeeFormSubmit(action) {
    const formData = new FormData(document.getElementById('employee-form'));
    const endpoint = action === 'edit' ? '/hw6/api/update-employee.php' : '/hw6/api/create-employee.php';

    fetch(endpoint, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                navigateTo('employee-list');
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}



function deleteEmployee(employeeId) {
        fetch('/hw6/api/delete-employee.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${employeeId}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    navigateTo('employee-list');
                } else {
                    alert('Failed to delete employee: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });

}



function fetchAndDisplayTaskList() {
    fetch('/hw6/api/task-list.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (Array.isArray(data)) {
                updateMainContent(renderTaskList(data));
            } else {
                console.error('Task list data is not an array.');
            }
        })
        .catch(error => {
            console.error('Error fetching task list data:', error);
        });
}



function renderTaskList(tasks) {

    setupNavigation();
    const root = document.getElementById('main-content');
    if (!tasks || tasks.length === 0) {
        root.innerHTML = '<p>No tasks available.</p>';
        return;
    }
    root.innerHTML = `
       <div class="content-card">
            <div class="content-card-header">Tasks</div>
            <div class="content-card-content">
                ${tasks.map(task => {
            const estimateDots = Array.from({length: 5}, (_, i) => i < task.estimate ? 'filled' : '');
            return `
                        <div class="task ${task.status.toLowerCase()}">
                            <span class="link">
                                <a href="#" class="task-edit-link" data-id="${task.id}">Edit</a>
                            </span>
                            <div class="title" data-task-id="${task.id}">
                                ${task.description}
                            </div>
                            <br>
                            <div class="status ${task.status.toLowerCase()}">${capitalize(task.status)}</div>
                            <div class="estimate">
                                ${estimateDots.map(dot => `<div class="dot ${dot}"></div>`).join('')}
                            </div>
                        </div>
                    `;
        }).join('')}
            </div>
        </div>`;
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }



function fetchAndDisplayTaskForm(taskId = null) {
    setupNavigation();
    const fetchTask = taskId ? fetch(`/hw6/api/get-task.php?id=${taskId}`) : Promise.resolve({ task: {} });
    fetchTask
        .then(response => response.json())
        .then(taskData => {
            if (taskData.task || !taskId) {
                fetch(`/hw6/api/employee-list.php`)
                    .then(response => response.json())
                    .then(employees => {
                        updateMainContent(renderTaskForm(taskData.task, employees));
                        attachTaskFormSubmitListener(taskId);
                    });
            } else {
                console.error('Task not found');
            }
        })
        .catch(error => {
            console.error('Error fetching task data:', error);
        });
}


function attachTaskFormSubmitListener(taskId = null) {
    const taskForm = document.getElementById('task-form');
    if (taskForm) {
        taskForm.addEventListener('submit', function(event) {
            event.preventDefault();
            handleTaskFormSubmit(taskId);
        });
    }
}

function handleTaskFormSubmit(taskId) {
    const formData = new FormData(document.getElementById('task-form'));
    const endpoint = taskId ? `/hw6/api/update-task.php` : `/hw6/api/create-task.php`;

    fetch(endpoint, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                navigateTo('task-list');
            } else {
                alert('Failed to save task: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error saving task:', error);
        });
}


function renderTaskForm(task, employees) {
         setupNavigation();

         const root = document.getElementById('main-content');

        let employeeOptions = employees.map(employee => {
            let selected = task.employeeId === employee.id ? 'selected' : '';
            return `<option value="${employee.id}" ${selected}>${employee.firstName} ${employee.lastName}</option>`;
        }).join('');

        root.innerHTML = `
    <div class="content-card">
        <div class="content-card-header">${task.id ? 'Edit' : 'Add'} Task</div>
        <div class="content-card-content">
            <form id="task-form" method="post" action="/api/create-task.php">
                <input type="hidden" value="${task.id || ''}" name="id">
                <div class="label-cell"><label for="desc">Description:</label></div>
                <div class="input-cell">
                    <textarea id="desc" name="description">${task.description || ''}</textarea>
                </div>

                <div class="label-cell">Estimate:</div>
                <div class="input-cell">
                    ${[1, 2, 3, 4, 5].map(estimate => `
                        <label>
                            <input type='radio' name='estimate' value='${estimate}' ${task.estimate === estimate ? 'checked' : ''}/>
                            ${estimate}
                        </label>
                    `).join('')}
                </div>

                <div class="label-cell">Assigned to:</div>
                <div class="input-cell">
                    <select id="employee" name="employeeId">
                        <option value=""></option>
                        ${employeeOptions}
                    </select>
                </div>

                ${task.id ? `
                    <div class="label-cell"><label for="isCompleted">Completed:</label></div>
                    <div class="input-cell">
                        <input id="isCompleted" type="checkbox" name="isCompleted" ${task.isCompleted ? 'checked' : ''}/>
                    </div>
                ` : ''}

                <button type="submit" class="main" name="saveTaskButton">Save</button>
                ${task.id ? `<button class="button danger" type="button" onclick="deleteTask('${task.id}')">Delete</button>` : ''}
            </form>
        </div>
    </div>`;
    }
document.getElementById('saveTaskButton').addEventListener('click', saveTask);

const taskForm = document.getElementById('task-form');

attachTaskFormSubmitListener(task.id);

taskForm.addEventListener('submit', function(event) {
    event.preventDefault();
    handleTaskFormSubmit(isEdit ? 'edit' : 'create');
});


if (isEdit) {
    const deleteButton = document.getElementById('deleteButton');
    deleteButton.addEventListener('click', function() {
        deleteTask(task.id);
    });
}

function deleteTask(taskId) {
    fetch(`/hw6/api/delete-task.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `taskId=${taskId}`
    })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                console.log('Task deleted successfully');

            } else {
                console.error('Failed to delete task', data.message);
            }
        })
        .catch(error => console.error('Error deleting task:', error));
}

export {
    fetchAndDisplayDashboard,
    fetchAndDisplayEmployeeList,
    fetchAndDisplayTaskList,
    fetchAndDisplayEmployeeForm,
    fetchAndDisplayTaskForm,
    renderDashboard,
    renderEmployeeList,
    renderEmployeeForm,
    renderTaskList,
    renderTaskForm,

};

