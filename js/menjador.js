// ── Datos ──────────────────────────────────────────────────────────────────
const students = [
    { id: 1, name: 'Anna Puig i Jové', course: '1r Primària', status: 'Pendent' },
    { id: 2, name: 'Marc García López', course: '3r Primària', status: 'Pendent' },
    { id: 3, name: 'Sara Vila Soler', course: '2n ESO', status: 'Dinand' },
    { id: 4, name: 'Jordi Martí Ros', course: '6è Primària', status: 'Pendent' },
    { id: 5, name: 'Elena Bosch Font', course: '1r Batxillerat', status: 'Dinand' },
    { id: 6, name: 'Pol Rius Serra', course: '4t Primària', status: 'Pendent' },
];

let isCookView = false;
let userReserved = false;

// ── DOM Elements ──────────────────────────────────────────────────────────
const viewToggle = document.getElementById('view-toggle');
const vistaAlumne = document.getElementById('vista-alumne');
const vistaCuina = document.getElementById('vista-cuina');
const studentList = document.getElementById('student-list');
const reserveBtn = document.getElementById('reserve-btn');
const ticketStatus = document.getElementById('ticket-status');
const statusIcon = document.getElementById('status-icon');
const totalReservations = document.getElementById('total-reservations');
const totalPresent = document.getElementById('total-present');

// ── Inicializar ────────────────────────────────────────────────────────
function init() {
    renderStudents();
    updateDate();
}

// ── Estado ─────────────────────────────────────────────────────────────────
function updateDate() {
    const el = document.getElementById('ticket-date');
    if (el) {
        const now = new Date();
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        el.textContent = now.toLocaleDateString('ca-ES', options);
    }
}

function renderStudents() {
    if (!studentList) return;
    studentList.innerHTML = '';

    let presentCount = 0;

    students.forEach(s => {
        if (s.status === 'Dinand') presentCount++;

        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-50 transition-colors group';
        tr.innerHTML = `
            <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(s.name)}&background=random" class="w-8 h-8 rounded-lg">
                    <span class="text-sm font-semibold text-slate-700">${s.name}</span>
                </div>
            </td>
            <td class="px-6 py-4 text-xs text-slate-500">${s.course}</td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 text-[10px] font-bold rounded-full uppercase ${s.status === 'Dinand' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'}">
                    ${s.status}
                </span>
            </td>
            <td class="px-6 py-4 text-right">
                <button onclick="toggleCheckIn(${s.id})" class="text-xs font-bold ${s.status === 'Dinand' ? 'text-red-500 hover:text-red-600' : 'text-primary hover:text-blue-700'} transition-colors">
                    ${s.status === 'Dinand' ? 'Anul·lar' : 'Check-in'}
                </button>
            </td>
        `;
        studentList.appendChild(tr);
    });

    if (totalReservations) totalReservations.textContent = students.length;
    if (totalPresent) totalPresent.textContent = presentCount;
}

window.toggleCheckIn = function (id) {
    const s = students.find(x => x.id === id);
    if (s) {
        s.status = s.status === 'Dinand' ? 'Pendent' : 'Dinand';
        renderStudents();

        // Reflejar en la vista del alumno si es Marc (ID 2)
        if (id === 2) {
            updateUserTicket(s.status);
        }
    }
};

function updateUserTicket(status) {
    if (status === 'Dinand') {
        ticketStatus.textContent = 'Consumit';
        ticketStatus.className = 'text-sm font-bold text-green-600';
        statusIcon.className = 'w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600';
        statusIcon.innerHTML = '<i class="fa fa-check"></i>';
        reserveBtn.disabled = true;
        reserveBtn.className = 'w-full bg-slate-100 text-slate-400 font-bold py-4 rounded-xl cursor-not-allowed flex items-center justify-center gap-3';
        reserveBtn.textContent = 'Dinar Consumit';
    } else if (userReserved) {
        ticketStatus.textContent = 'Reservat';
        ticketStatus.className = 'text-sm font-bold text-primary';
        statusIcon.className = 'w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-primary';
        statusIcon.innerHTML = '<i class="fa fa-ticket-alt"></i>';
        reserveBtn.textContent = 'Reserva Confirmada';
        reserveBtn.disabled = true;
        reserveBtn.className = 'w-full bg-blue-50 text-primary border border-blue-200 font-bold py-4 rounded-xl flex items-center justify-center gap-3';
    }
}

// ── Eventos ────────────────────────────────────────────────────────────────
if (viewToggle) {
    viewToggle.addEventListener('click', () => {
        isCookView = !isCookView;
        if (isCookView) {
            vistaAlumne.classList.add('hidden');
            vistaCuina.classList.remove('hidden');
        } else {
            vistaCuina.classList.add('hidden');
            vistaAlumne.classList.remove('hidden');
        }
    });
}

if (reserveBtn) {
    reserveBtn.addEventListener('click', () => {
        userReserved = true;
        updateUserTicket('Reservat');
        alert('Reserva realitzada correctament! Ja pots passar pel menjador.');
    });
}

// Inicializar
init();
