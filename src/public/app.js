const API_URL = 'http://localhost:8080/task-manager/api/task.php';

// Function to fetch and display all tasks
function fetchTasks() {
    fetch(API_URL)
        .then(response => response.json())
        .then(tasks => {
            const taskList = document.getElementById('taskList');
            taskList.innerHTML = '';

            tasks.forEach(task => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <h3>${task.title}</h3>
                    <p>${task.description}</p>
                    <p>Status: ${task.status}</p>
                    <button onclick="deleteTask(${task.id})">Delete</button>
                    <button onclick="editTask(${task.id}, '${task.title}', '${task.description}', '${task.status}')">Edit</button>
                `;
                taskList.appendChild(li);
            });
        })
        .catch(error => console.error('Error fetching tasks:', error));
}

// Function to add a new task
function addTask() {
    const title = document.getElementById('taskTitle').value;
    const description = document.getElementById('taskDescription').value;

    if (!title) {
        alert('Task title is required');
        return;
    }

    const task = { title, description, status: 'pending' };

    fetch(API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(task)
    })
        .then(response => response.json())
        .then(() => {
            fetchTasks();  // Refresh task list
        })
        .catch(error => console.error('Error adding task:', error));
}

// Function to delete a task
function deleteTask(id) {
    fetch(`${API_URL}?id=${id}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(() => {
            fetchTasks();  // Refresh task list
        })
        .catch(error => console.error('Error deleting task:', error));
}

// Function to edit a task (this can be improved to handle updates better)
function editTask(id, title, description, status) {
    const newTitle = prompt('Edit Title:', title);
    const newDescription = prompt('Edit Description:', description);
    const newStatus = prompt('Edit Status (pending/completed):', status);

    const updatedTask = { title: newTitle, description: newDescription, status: newStatus };

    fetch(`${API_URL}?id=${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(updatedTask)
    })
        .then(response => response.json())
        .then(() => {
            fetchTasks();  // Refresh task list
        })
        .catch(error => console.error('Error updating task:', error));
}

// Initial fetch to display all tasks
fetchTasks();
