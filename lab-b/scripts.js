class Todo {
    constructor() {
        this.tasks = [];      // lista zadań
        this.term = "";       // fraza wyszukiwania
        this.listElement = document.getElementById("todo-list");
    }

    // Renderowanie
    draw() {
        this.listElement.innerHTML = "";
        const tasksToShow = this.getFilteredTasks();
        tasksToShow.forEach((task) => {
            const realIndex = this.tasks.indexOf(task);
            const li = document.createElement("li");
            li.className = "todo-item";
            const span = document.createElement("span");
            span.className = "todo-text";
            if (this.term.length >= 2) {
                const regex = new RegExp(`(${this.term})`, "gi");
                span.innerHTML = task.text.replace(regex, "<mark>$1</mark>");
            } else {
                span.textContent = task.text;
            }
            span.addEventListener("click", () => this.startEdit(realIndex));
            const deadlineSpan = document.createElement("span");
            deadlineSpan.className = "todo-deadline";
            deadlineSpan.textContent = task.deadline || "";
            deadlineSpan.addEventListener("click", () => this.startEdit(realIndex));
            const del = document.createElement("button");
            del.className = "todo-delete";
            del.textContent = "Usuń";
            del.addEventListener("click", () => this.remove(realIndex));
            li.appendChild(span);
            li.appendChild(deadlineSpan);
            li.appendChild(del);
            this.listElement.appendChild(li);
        });
    }

    // Dodawanie
    add(text, deadline) {
        if (text.length < 3 || text.length > 255) return;
        if (deadline) {
            const d = new Date(deadline);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (d < today) return;
        }
        this.tasks.push({ text, deadline });
        this.draw();
        this.save();
    }

    // Usuwanie
    remove(index) {
        this.tasks.splice(index, 1);
        this.draw();
        this.save();
    }

    // Edycja
    startEdit(index) {
        const task = this.tasks[index];
        // Edycja tekstu
        const newText = prompt("Edytuj treść zadania:", task.text);
        if (!newText || newText.trim().length < 3) return;
        // Edycja daty
        const newDate = prompt("Edytuj datę (RRRR-MM-DD) lub zostaw puste:", task.deadline || "");
        if (newDate) {
            const d = new Date(newDate);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (isNaN(d.getTime()) || d < today) {
                alert("Nieprawidłowa data! Zmiany nie zostały zapisane.");
                return;
            }
        }
        this.tasks[index].text = newText.trim();
        this.tasks[index].deadline = newDate || "";
        this.draw();
        this.save();
    }

    // Filtrowanie
    getFilteredTasks() {
        if (this.term.length < 2) return this.tasks;
        return this.tasks.filter(t =>
            t.text.toLowerCase().includes(this.term.toLowerCase())
        );
    }

    // Local storage
    save() {
        localStorage.setItem("todo-tasks", JSON.stringify(this.tasks));
    }
    load() {
        const data = localStorage.getItem("todo-tasks");
        if (data) {
            this.tasks = JSON.parse(data);
        }
    }
}

// Inicializacja
document.addEventListener("DOMContentLoaded", () => {
    document.todo = new Todo();
    document.todo.load();
    document.todo.draw();
    // wyszukiwarka
    document.getElementById("search").addEventListener("input", (e) => {
        document.todo.term = e.target.value;
        document.todo.draw();
    });
    // dodawanie zadania
    document.getElementById("add-form").addEventListener("submit", (e) => {
        e.preventDefault();
        const text = document.getElementById("new-task").value;
        const deadline = document.getElementById("new-deadline").value;
        document.todo.add(text, deadline);
        document.getElementById("new-task").value = "";
        document.getElementById("new-deadline").value = "";
    });
});
