// ── State ─────────────────────────────────────────────────────────────────
let isCentreView = false;
let unreadCount = 2;

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
        toast.textContent = '✅ Autorització signada correctament';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);

        // Actualizar tabla de centro (Simulación Marc García)
        const progressBar = document.querySelector('.bg-secondary.h-full');
        if (progressBar) {
            progressBar.style.width = '46%';
            const countSpan = document.querySelector('.text-\\[10px\\].font-black.text-slate-600');
            if (countSpan) countSpan.textContent = '13/26';
        }
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

// ── Tab Management (Family View) ──────────────────────────────────────────
const familyTabs = document.querySelectorAll('#vista-familia .flex.gap-2 button');
familyTabs.forEach(tab => {
    tab.addEventListener('click', () => {
        familyTabs.forEach(t => {
            t.classList.remove('bg-secondary', 'text-white', 'shadow-lg', 'shadow-purple-100');
            t.classList.add('bg-white', 'text-slate-500', 'border', 'border-slate-200');
        });
        tab.classList.add('bg-secondary', 'text-white', 'shadow-lg', 'shadow-purple-100');
        tab.classList.remove('bg-white', 'text-slate-500', 'border', 'border-slate-200');
    });
});

// ── Events ────────────────────────────────────────────────────────────────
if (viewToggle) viewToggle.addEventListener('click', toggleView);
if (openModalBtn) openModalBtn.addEventListener('click', () => toggleModal(true));
if (closeModalBtn) closeModalBtn.addEventListener('click', () => toggleModal(false));

if (modalNouComunicat) {
    modalNouComunicat.querySelector('.modal-backdrop').addEventListener('click', () => toggleModal(false));
}

const form = modalNouComunicat ? modalNouComunicat.querySelector('form') : null;
if (form) {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Comunicat enviat correctament al nivell educatiu seleccionat.');
        toggleModal(false);
        form.reset();
    });
}
