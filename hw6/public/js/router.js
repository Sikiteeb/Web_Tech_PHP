import {
    fetchAndDisplayDashboard,
    fetchAndDisplayEmployeeForm,
    fetchAndDisplayEmployeeList,
    fetchAndDisplayTaskForm,
    fetchAndDisplayTaskList,
} from './main.js';

document.addEventListener('DOMContentLoaded', (event) => {
    setupNavigation();
    router();
});


export function setupNavigation() {
    const navElement = document.getElementById('navigation');
    navElement.innerHTML = `
    <a href="#page=dashboard" id="dashboard-link">Dashboard</a> |
    <a href="#page=employee-list" id="employee-list-link">Employees</a> |
    <a href="#page=employee-form" id="employee-form-link">Add Employee</a> |
    <a href="#page=task-list" id="task-list-link">Tasks</a> |
    <a href="#page=task-form" id="task-form-link">Add Task</a>
    `;
}

export function router() {
    const hash = window.location.hash.substring(1);
    const params = new URLSearchParams(hash);
    const page = params.get('page') || 'dashboard';
    const id = params.get('id');

    switch (page) {
        case 'dashboard':
            fetchAndDisplayDashboard();
            break;
        case 'employee-list':
            fetchAndDisplayEmployeeList();
            break;
        case 'employee-form':
            fetchAndDisplayEmployeeForm(id);
            break;
        case 'task-list':
            fetchAndDisplayTaskList();
            break;
        case 'task-form':
            fetchAndDisplayTaskForm(id);
            break;
        default:
            fetchAndDisplayDashboard();
            break;
    }
}



window.addEventListener('hashchange', router);








