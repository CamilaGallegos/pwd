document.addEventListener('DOMContentLoaded', () => {
    const eventList = document.getElementById('event-list');
    const createEventButton = document.getElementById('create-event');
    const loginLink = document.getElementById('login-link');
    const logoutLink = document.getElementById('logout-link');

    //verifica si el usuario esta conectado
    const checkLoginStatus = async () => {
        const response = await fetch('/api.php?action=session');
        const sessionData = await response.json();
        const isLoggedIn = sessionData.isLoggedIn;

        if (isLoggedIn) {
            loginLink.style.display = 'none';
            logoutLink.style.display = 'block';
            createEventButton.style.display = 'block';
        } else {
            loginLink.style.display = 'block';
            logoutLink.style.display = 'none';
            createEventButton.style.display = 'none';
        }
    };

    const fetchEvents = async () => {
        const response = await fetch('/api.php?action=getAllTask');
        const events = await response.json();
        if (events.length === 0) {
            eventList.innerHTML = '<p>No hay eventos disponibles.</p>';
        } else {
            eventList.innerHTML = events.map(event => `
                <div class="event">
                    <strong>${event.name}</strong>: ${event.description}
                    ${isLoggedIn ? `
                        <button onclick="editEvent(${event.id})" class="btn btn-secondary">Editar</button>
                        <button onclick="deleteEvent(${event.id})" class="btn btn-danger">Eliminar</button>
                    ` : ''}
                </div>
            `).join('');
        }
    };

    checkLoginStatus();
    fetchEvents();

    loginLink.addEventListener('click', async(event) => {
        event.preventDefault();
        console.log("Login link clicked"); //para verificar que la funcion se este ejecutando
        const username = prompt('Ingrese su nombre de usuario:');
        const password = prompt('Ingrese su contraseña:');
    
        const response = await fetch('/index.php?action=login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, password })
        });

        const result = await response.json();
        if (response.ok && result.success) {
            alert('Inicio de sesión exitoso');
            location.reload(); //recarga la pag para actualizar el estado de login
        }else{
            alert(result.message || 'Error al iniciar sesión');
        }
    });

    logoutLink.addEventListener('click', async(event) => {
        event.preventDefault();

        const response = await fetch('/index.php?action=logout', {
            method: 'GET'
        });

        if (response.ok) {
            alert('Sesión cerrada exitosamente');
            location.reload();
        }else{
            alert('Error al cerrar sesión');
        }
    });

    createEventButton.addEventListener('click', async () => {
        const name = prompt('Ingrese el nombre del evento:');
        const description = prompt('Ingrese la descripción del evento:');
    
        if (name && description) {
            const response = await fetch('/api/events', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name, description })
            });
    
            if (response.ok) {
                alert('Evento creado exitosamente');
                fetchEvents(); //vuelve a cargar la lista de eventos
            } else {
                alert('Error al crear el evento');
            }
        } else {
            alert('Nombre y descripción del evento son obligatorios');
        }
    });
    
});

const editEvent = async (id) => {
    const newName = prompt('Ingrese el nuevo nombre del evento:');
    const newDescription = prompt('Ingrese la nueva descripción del evento:');
    if (newName && newDescription) {
        const response = await fetch(`/api.php?action=updateTask${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name: newName, description: newDescription })
        });
            
        if (response.ok) {
            alert('Evento editado exitosamente');
            fetchEvents(); // Volver a cargar la lista de eventos
        } else {
            alert('Error al editar el evento');
        }
    }
};

const deleteEvent = async (id) => {
    const response = await fetch(`/api.php?action=deleteTask&id=${id}`, {
        method: 'DELETE'
    });
    if (response.ok){
        alert('Evento eliminado exitosamente')
        fetchEvents();
    }else{
        alert('Error al eliminar el evento');
    }   
};
