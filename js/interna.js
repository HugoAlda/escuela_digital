// ── Estado ─────────────────────────────────────────────────────────────────
let isAdminMode = false;
let selectedColor = 'yellow';

// ── DOM Elements ──────────────────────────────────────────────────────────
const viewToggle = document.getElementById('view-toggle');
const addNoticeBtn = document.getElementById('add-notice-btn');
const modalNotice = document.getElementById('modal-notice');
const closeModalBtn = document.getElementById('close-modal');
const boardContainer = document.getElementById('board-container');
const noticeForm = modalNotice?.querySelector('form');

// ── Lògica ─────────────────────────────────────────────────────────────────
function toggleAdminMode() {
    isAdminMode = !isAdminMode;
    if (isAdminMode) {
        viewToggle.innerHTML = '<i class="fa fa-user-check mr-2"></i> Mode Profe';
        viewToggle.classList.replace('bg-slate-100', 'bg-blue-600');
        viewToggle.classList.replace('text-slate-600', 'text-white');
        addNoticeBtn.classList.remove('hidden');
    } else {
        viewToggle.innerHTML = '<i class="fa fa-user-shield mr-2"></i> Mode Admin';
        viewToggle.classList.replace('bg-blue-600', 'bg-slate-100');
        viewToggle.classList.replace('text-white', 'text-slate-600');
        addNoticeBtn.classList.add('hidden');
    }
}

window.confirmAttendance = function (id) {
    const btn = event.currentTarget;
    btn.innerHTML = '<i class="fa fa-check mr-1"></i> Assistència confirmada';
    btn.classList.replace('bg-white', 'bg-green-500');
    btn.classList.replace('text-primary', 'text-white');
    btn.classList.replace('border-blue-200', 'border-green-500');
    btn.disabled = true;
};

window.setNoteColor = function (color) {
    selectedColor = color;
    document.querySelectorAll('[data-color]').forEach(btn => {
        btn.classList.remove('active-color');
        if (btn.getAttribute('data-color') === color) {
            btn.classList.add('active-color');
        }
    });
};

function createNoticeCard(title, content, color) {
    const rot = (Math.random() * 6 - 3).toFixed(1);
    const card = document.createElement('div');
    card.className = `notice-card note-${color} p-6 shadow-xl relative`;
    card.style.transform = `rotate(${rot}deg)`;

    card.innerHTML = `
        <div class="pin absolute -top-2 left-1/2 -translate-x-1/2 w-3 h-3 bg-slate-700 rounded-full shadow-md z-10"></div>
        <h3 class="font-display font-700 text-slate-800 mb-2">${title}</h3>
        <p class="text-xs text-slate-600 leading-normal">${content}</p>
        <div class="mt-4 pt-4 border-t border-black/5 flex justify-between items-center text-[10px] text-slate-400 font-bold uppercase">
            <span>Admin</span>
            <span>Ara mateix</span>
        </div>
    `;

    boardContainer.appendChild(card);
}

const toggleModal = (show) => {
    if (!modalNotice) return;
    if (show) {
        modalNotice.classList.remove('hidden');
        modalNotice.classList.add('flex');
        setTimeout(() => modalNotice.classList.add('active'), 10);
    } else {
        modalNotice.classList.remove('active');
        setTimeout(() => {
            modalNotice.classList.add('hidden');
            modalNotice.classList.remove('flex');
        }, 300);
    }
};

// ── Eventos ────────────────────────────────────────────────────────────────
if (viewToggle) viewToggle.addEventListener('click', toggleAdminMode);
if (addNoticeBtn) addNoticeBtn.addEventListener('click', () => toggleModal(true));
if (closeModalBtn) closeModalBtn.addEventListener('click', () => toggleModal(false));

if (noticeForm) {
    noticeForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const title = document.getElementById('notice-title').value;
        const content = document.getElementById('notice-content').value;

        if (title && content) {
            createNoticeCard(title, content, selectedColor);
            toggleModal(false);
            noticeForm.reset();
        }
    });
}

// Clic fuera del modal
if (modalNotice) {
    modalNotice.querySelector('.modal-backdrop').addEventListener('click', () => toggleModal(false));
}
