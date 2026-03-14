// ── Data ──────────────────────────────────────────────────────────────────
const students = [
    { id: 1, name: 'Anna Puig i Jové', course: '1r Primària', status: 'Pendent', diet: 'Estandard' },
    { id: 2, name: 'Marc García López', course: '3r Primària', status: 'Pendent', diet: 'Sense Gluten' },
    { id: 3, name: 'Sara Vila Soler', course: '2n ESO', status: 'Dinand', diet: 'Vegà' },
    { id: 4, name: 'Jordi Martí Ros', course: '6è Primària', status: 'Pendent', diet: 'Estandard' },
    { id: 5, name: 'Elena Bosch Font', course: '1r Batxillerat', status: 'Dinand', diet: 'Sense Lactosa' },
    { id: 6, name: 'Pol Rius Serra', course: '4t Primària', status: 'Pendent', diet: 'Estandard' },
    { id: 7, name: 'Lluc Camps Mir', course: 'P5', status: 'Pendent', diet: 'Sense Fruits Secs' },
];

let isCookView = false;
let userReserved = false;
let userTickets = 5;

// ── DOM Elements ──────────────────────────────────────────────────────────
const viewToggle = document.getElementById('view-toggle');
const vistaAlumne = document.getElementById('vista-alumne');
const vistaCuina = document.getElementById('vista-cuina');
const studentList = document.getElementById('student-list');
const reserveBtn = document.getElementById('reserve-btn');
const buyBtn = document.getElementById('buy-btn');
const tpvModal = document.getElementById('tpv-modal');
const payConfirmBtn = document.getElementById('pay-confirm-btn');
const cancelTpv = document.getElementById('cancel-tpv');

const appTickets = document.getElementById('app-tickets');
const navTickets = document.getElementById('nav-tickets');
const appStatus = document.getElementById('app-status');
const confirmStatusIcon = document.getElementById('confirm-status-icon');
const ticketBalanceNav = document.getElementById('ticket-balance-nav');

// Stats
const totalReservations = document.getElementById('total-reservations');
const totalAllergies = document.getElementById('total-allergies');

// ── Initialization ────────────────────────────────────────────────────────
function init() {
    renderStudents();
    updateTicketDisplay();
}

// ── UI Updates ─────────────────────────────────────────────────────────────
function updateTicketDisplay() {
    if (appTickets) appTickets.innerHTML = `${userTickets} <span class="text-lg font-normal text-slate-400">Restants</span>`;
    if (navTickets) navTickets.textContent = `Saldo: ${userTickets}`;
}

function renderStudents() {
    if (!studentList) return;
    studentList.innerHTML = '';

    let allergyCount = 0;

    students.forEach(s => {
        if (s.diet !== 'Estandard') allergyCount++;

        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-50 transition-colors group';
        tr.innerHTML = `
            <td class="px-6 py-4">
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(s.name)}&background=random" class="w-10 h-10 rounded-2xl shadow-sm">
                    <div>
                        <span class="text-sm font-bold text-slate-800 block">${s.name}</span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">${s.course}</span>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4">
                <span class="px-3 py-1.5 text-[10px] font-bold rounded-xl uppercase tracking-tighter ${s.diet === 'Estandard' ? 'bg-slate-50 text-slate-400' : 'bg-orange-100 text-orange-700 border border-orange-200'}">
                    <i class="fa ${s.diet === 'Estandard' ? 'fa-check' : 'fa-exclamation-triangle'} mr-1.5 opacity-70"></i>
                    ${s.diet}
                </span>
            </td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 text-[10px] font-black rounded-md uppercase tracking-widest ${s.status === 'Dinand' ? 'text-success' : 'text-slate-300'}">
                    ${s.status}
                </span>
            </td>
            <td class="px-6 py-4 text-right">
                <button onclick="toggleCheckIn(${s.id})" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest shadow-sm transition-all active:scale-95 ${s.status === 'Dinand' ? 'bg-red-50 text-red-600 border border-red-100 hover:bg-red-100' : 'bg-success text-white hover:bg-emerald-600'}">
                    ${s.status === 'Dinand' ? 'Sortir' : 'Entrar'}
                </button>
            </td>
        `;
        studentList.appendChild(tr);
    });

    if (totalReservations) totalReservations.textContent = students.length;
    if (totalAllergies) totalAllergies.textContent = allergyCount;
}

window.toggleCheckIn = function (id) {
    const s = students.find(x => x.id === id);
    if (s) {
        s.status = s.status === 'Dinand' ? 'Pendent' : 'Dinand';
        renderStudents();

        // Reflect in alumno view if it's Marc (ID 2)
        if (id === 2) {
            updateUserReservedState(s.status === 'Dinand' ? 'Consumed' : (userReserved ? 'Reserved' : 'Idle'));
        }
    }
};

function updateUserReservedState(state) {
    if (state === 'Consumed') {
        appStatus.textContent = 'Dinar realitzat avui';
        appStatus.className = 'text-sm font-bold text-success';
        reserveBtn.classList.add('hidden');
        confirmStatusIcon.classList.remove('hidden');
        confirmStatusIcon.innerHTML = '<i class="fa fa-check"></i>';
    } else if (state === 'Reserved') {
        appStatus.textContent = 'Reserva confirmada';
        appStatus.className = 'text-sm font-bold text-primary';
        reserveBtn.classList.add('hidden');
        confirmStatusIcon.classList.remove('hidden');
        confirmStatusIcon.innerHTML = '<i class="fa fa-clock"></i>';
    } else {
        appStatus.textContent = 'Vols reservar el dinar?';
        appStatus.className = 'text-sm font-bold text-slate-700';
        reserveBtn.classList.remove('hidden');
        confirmStatusIcon.classList.add('hidden');
    }
}

// ── TPV & Modal ─────────────────────────────────────────────────────────────
const toggleModal = (show) => {
    if (!tpvModal) return;
    if (show) {
        tpvModal.classList.remove('hidden');
        tpvModal.classList.add('flex');
        setTimeout(() => tpvModal.classList.add('active'), 10);
    } else {
        tpvModal.classList.remove('active');
        setTimeout(() => {
            tpvModal.classList.add('hidden');
            tpvModal.classList.remove('flex');
        }, 300);
    }
};

// ── Events ────────────────────────────────────────────────────────────────
if (viewToggle) {
    viewToggle.addEventListener('click', () => {
        isCookView = !isCookView;
        if (isCookView) {
            vistaAlumne.classList.add('hidden');
            vistaCuina.classList.remove('hidden');
            ticketBalanceNav.classList.add('hidden');
            viewToggle.innerHTML = '<i class="fa fa-mobile-alt mr-2"></i> Vista App';
        } else {
            vistaCuina.classList.add('hidden');
            vistaAlumne.classList.remove('hidden');
            ticketBalanceNav.classList.remove('hidden');
            viewToggle.innerHTML = '<i class="fa fa-tablet-alt mr-2"></i> Vista Cuina';
        }
    });
}

if (reserveBtn) {
    reserveBtn.addEventListener('click', () => {
        if (userTickets > 0) {
            userTickets--;
            userReserved = true;
            updateTicketDisplay();
            updateUserReservedState('Reserved');

            // Sync with Cuina list (Marc)
            const marc = students.find(x => x.id === 2);
            if (marc) marc.status = 'Reservat';
            renderStudents();

            alert('Reserva feta correctament! S\'ha consumit 1 tiquet del teu saldo.');
        } else {
            alert('No tens prou tiquets! Cal comprar-ne més.');
            toggleModal(true);
        }
    });
}

if (buyBtn) buyBtn.addEventListener('click', () => toggleModal(true));
if (cancelTpv) cancelTpv.addEventListener('click', () => toggleModal(false));

if (payConfirmBtn) {
    payConfirmBtn.addEventListener('click', () => {
        payConfirmBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processant...';
        payConfirmBtn.disabled = true;

        setTimeout(() => {
            userTickets += 10;
            updateTicketDisplay();
            toggleModal(false);
            payConfirmBtn.innerHTML = 'Pagar ara <i class="fa fa-lock text-xs opacity-50"></i>';
            payConfirmBtn.disabled = false;
            alert('Pagament realitzat amb èxit! Hem afegit 10 tiquets al teu compte.');
        }, 2000);
    });
}

// Init
init();
