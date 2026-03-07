// ── State ─────────────────────────────────────────────────────────────────
let isCentreView = false;
let unreadCount = 1;

// ── DOM Elements ──────────────────────────────────────────────────────────
const viewToggle = document.getElementById('view-toggle');
const vistaFamilia = document.getElementById('vista-familia');
const vistaCentre = document.getElementById('vista-centre');
const modalNouComunicat = document.getElementById('modal-nou-comunicat');
const openModalBtn = document.getElementById('new-msg-btn');
const closeModalBtn = document.getElementById('close-modal-btn');
const notifBadge = document.getElementById('notif-badge');
const unreadEl = document.getElementById('unread-count');

// ── Logic ─────────────────────────────────────────────────────────────────
function toggleView() {
    isCentreView = !isCentreView;
    if (isCentreView) {
        vistaFamilia.classList.add('hidden');
        vistaCentre.classList.remove('hidden');
        document.title = "Gestió de Comunicats - Escola Digital";
    } else {
        vistaCentre.classList.add('hidden');
        vistaFamilia.classList.remove('hidden');
        document.title = "Comunicació amb Famílies - Escola Digital";
    }
}

window.confirmReading = function (id) {
    const confirmBox = document.getElementById(`confirm-box-${id}`);
    const successBox = document.getElementById(`success-box-${id}`);

    if (confirmBox && successBox) {
        confirmBox.classList.add('hidden');
        successBox.classList.remove('hidden');

        // Update unread stats
        unreadCount--;
        if (unreadEl) unreadEl.textContent = unreadCount;
        if (unreadCount === 0 && notifBadge) {
            notifBadge.classList.add('hidden');
        }

        // Fake toast or alert
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-2xl z-[200] animate-bounce';
        toast.textContent = '✅ Recepció confirmada correctament';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
};

const toggleModal = (show) => {
    if (!modalNouComunicat) return;
    if (show) {
        modalNouComunicat.classList.remove('hidden');
        modalNouComunicat.classList.add('flex');
        setTimeout(() => modalNouComunicat.classList.add('active'), 10);
    } else {
        modalNouComunicat.classList.remove('active');
        setTimeout(() => {
            modalNouComunicat.classList.add('hidden');
            modalNouComunicat.classList.remove('flex');
        }, 300);
    }
};

// ── Events ────────────────────────────────────────────────────────────────
if (viewToggle) viewToggle.addEventListener('click', toggleView);
if (openModalBtn) openModalBtn.addEventListener('click', () => toggleModal(true));
if (closeModalBtn) closeModalBtn.addEventListener('click', () => toggleModal(false));

// Clic fora del modal per tancar
if (modalNouComunicat) {
    modalNouComunicat.querySelector('.modal-backdrop').addEventListener('click', () => toggleModal(false));
}

// Form submit (fake)
const form = modalNouComunicat.querySelector('form');
if (form) {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Comunicat enviat correctament a totes les famílies seleccionades.');
        toggleModal(false);
        form.reset();
    });
}
