// ── Texto tipado ────────────────────────────────────────────────────────────
const words = ['futur', 'demà', 'canvi', 'progrés'];
let wi = 0, ci = 0, deleting = false;
const el = document.getElementById('typed-text');
function typeLoop() {
    if (!el) return;
    const word = words[wi];
    el.textContent = deleting ? word.slice(0, ci--) : word.slice(0, ci++);
    let delay = deleting ? 60 : 120;
    if (!deleting && ci > word.length) { delay = 1800; deleting = true; }
    if (deleting && ci < 0) { deleting = false; wi = (wi + 1) % words.length; ci = 0; delay = 300; }
    setTimeout(typeLoop, delay);
}
typeLoop();

// ── Navbar scroll ─────────────────────────────────────────────────────────
const nav = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    if (nav) nav.classList.toggle('scrolled', window.scrollY > 60);
});

// ── Menu movil ───────────────────────────────────────────────────────────
const menuBtn = document.getElementById('menu-btn');
if (menuBtn) {
    menuBtn.addEventListener('click', () => {
        const m = document.getElementById('mobile-menu');
        const icon = document.querySelector('#menu-btn i');
        if (m && icon) {
            m.classList.toggle('open');
            icon.className = m.classList.contains('open') ? 'fa fa-times' : 'fa fa-bars';
        }
    });
}

// ── Cerrar menu movil ───────────────────────────────────────────────────────────
document.querySelectorAll('#mobile-menu a').forEach(a => {
    a.addEventListener('click', () => {
        const m = document.getElementById('mobile-menu');
        const icon = document.querySelector('#menu-btn i');
        if (m) m.classList.remove('open');
        if (icon) icon.className = 'fa fa-bars';
    });
});

// ── Aparecer ─────────────────────────────────────────────────────────
const observer = new IntersectionObserver(entries => {
    entries.forEach((e, i) => {
        if (e.isIntersecting) {
            setTimeout(() => e.target.classList.add('visible'), i * 80);
            observer.unobserve(e.target);
        }
    });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// ── Contadores ─────────────────────────────────────────────────────────
function animateCounter(el) {
    const target = parseInt(el.dataset.target);
    const duration = 1800;
    const step = 16;
    const inc = target / (duration / step);
    let cur = 0;
    const t = setInterval(() => {
        cur = Math.min(cur + inc, target);
        el.textContent = Math.floor(cur);
        if (cur >= target) { el.textContent = target; clearInterval(t); }
    }, step);
}
const statObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) { animateCounter(e.target); statObs.unobserve(e.target); }
    });
}, { threshold: 0.5 });
document.querySelectorAll('.stat-counter').forEach(el => statObs.observe(el));

// ── Boton regreso ───────────────────────────────────────────────────────────
const backToTopBtn = document.getElementById('back-top');
window.addEventListener('scroll', () => {
    if (backToTopBtn) backToTopBtn.classList.toggle('show', window.scrollY > 400);
});
if (backToTopBtn) {
    backToTopBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

// ── Formulario de contacto ──────────────────────────────────────────────────────────
const contactForm = document.getElementById('contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const success = document.getElementById('form-success');
        if (success) success.classList.remove('hidden');
        const btn = this.querySelector('button[type=submit]');
        if (btn) btn.disabled = true;
        setTimeout(() => {
            if (success) success.classList.add('hidden');
            this.reset();
            if (btn) btn.disabled = false;
        }, 4000);
    });
}

// ── Modal de login ───────────────────────────────────────────────────────────
const loginModal = document.getElementById('login-modal');
const openLoginBtn = document.getElementById('open-login');
const openLoginMobileBtn = document.getElementById('open-login-mobile');
const closeLoginBtn = document.getElementById('close-login');
const loginForm = document.getElementById('login-form');

const toggleLoginModal = (show) => {
    if (!loginModal) return;
    if (show) {
        loginModal.classList.remove('hidden');
        loginModal.classList.add('flex');
        setTimeout(() => loginModal.classList.add('active'), 10);
        document.body.style.overflow = 'hidden';
    } else {
        loginModal.classList.remove('active');
        setTimeout(() => {
            loginModal.classList.add('hidden');
            loginModal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }
};

if (openLoginBtn) openLoginBtn.addEventListener('click', () => toggleLoginModal(true));
if (openLoginMobileBtn) openLoginMobileBtn.addEventListener('click', () => toggleLoginModal(true));
if (closeLoginBtn) closeLoginBtn.addEventListener('click', () => toggleLoginModal(false));

// Clic fuera para cerrar
if (loginModal) {
    loginModal.querySelector('.modal-backdrop').addEventListener('click', () => toggleLoginModal(false));
}

// Validación de Login
if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const user = document.getElementById('username').value;
        const pass = document.getElementById('password').value;
        const errorMsg = document.getElementById('login-error');
        const successMsg = document.getElementById('login-success');

        errorMsg.classList.add('hidden');
        successMsg.classList.add('hidden');

        if (user === 'director' && pass === 'asdASD123') {
            successMsg.classList.remove('hidden');
            const submitBtn = this.querySelector('button[type=submit]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner animate-spin"></i> Accedint...';

            setTimeout(() => {
                alert('Benvingut, senyor Director. Accés concedit.');
                toggleLoginModal(false);
                // Aquí se podría redirigir: window.location.href = 'admin.php';
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Entrar al sistema <i class="fa fa-arrow-right text-xs"></i>';
                this.reset();
                successMsg.classList.add('hidden');
            }, 1500);
        } else {
            errorMsg.classList.remove('hidden');
            // Shake effect
            const container = loginModal.querySelector('.modal-container');
            container.classList.add('animate-shake');
            setTimeout(() => container.classList.remove('animate-shake'), 500);
        }
    });
}
