const activitats = [
  {
    id: 1,
    nom: "Robòtica Creativa",
    etapa: "Primària",
    dia: "Dimarts",
    hora: "17:00 - 18:30",
    placesTotals: 15,
    placesOcupades: 11,
    preu: "28€/mes",
    monitor: "Laura Gómez",
    espai: "Aula TIC 2",
    estat: "Oberta",
    pagament: "Pendent",
    descripcio: "Programació bàsica, sensors i petits reptes de construcció."
  },
  {
    id: 2,
    nom: "Anglès Speaking Club",
    etapa: "ESO",
    dia: "Dijous",
    hora: "16:30 - 18:00",
    placesTotals: 20,
    placesOcupades: 20,
    preu: "22€/mes",
    monitor: "Daniel Ruiz",
    espai: "Aula 1.4",
    estat: "Completa",
    pagament: "Completat",
    descripcio: "Conversa oral, jocs de rol i dinàmiques per millorar la fluïdesa."
  },
  {
    id: 3,
    nom: "Teatre i Expressió",
    etapa: "Primària",
    dia: "Dilluns",
    hora: "17:00 - 18:15",
    placesTotals: 18,
    placesOcupades: 9,
    preu: "24€/mes",
    monitor: "Marta Soler",
    espai: "Sala Polivalent",
    estat: "Oberta",
    pagament: "Pendent",
    descripcio: "Expressió corporal, improvisació i treball en equip."
  },
  {
    id: 4,
    nom: "Bàsquet Escolar",
    etapa: "ESO",
    dia: "Dimecres",
    hora: "17:30 - 19:00",
    placesTotals: 16,
    placesOcupades: 14,
    preu: "26€/mes",
    monitor: "Pau Ferrer",
    espai: "Pavelló",
    estat: "Oberta",
    pagament: "Pendent",
    descripcio: "Entrenament esportiu, valors de grup i competició amistosa."
  },
  {
    id: 5,
    nom: "Dibuix i Il·lustració",
    etapa: "Primària",
    dia: "Divendres",
    hora: "16:30 - 18:00",
    placesTotals: 12,
    placesOcupades: 6,
    preu: "20€/mes",
    monitor: "Clàudia Serra",
    espai: "Aula d'Art",
    estat: "Oberta",
    pagament: "Pendent",
    descripcio: "Tècniques bàsiques de dibuix, color i creativitat visual."
  }
];

let currentViewIsAdmin = false;
let selectedActivityId = null;
let myEnrollment = null;
let filters = {
  etapa: "Totes",
  dia: "Tots"
};

const viewToggle = document.getElementById("view-toggle");
const vistaFamilia = document.getElementById("vista-familia");
const vistaSecretaria = document.getElementById("vista-secretaria");

const activitiesGrid = document.getElementById("activities-grid");
const filterEtapa = document.getElementById("filter-etapa");
const filterDia = document.getElementById("filter-dia");

const statActivitats = document.getElementById("stat-activitats");
const statPlaces = document.getElementById("stat-places");
const statInscripcions = document.getElementById("stat-inscripcions");

const myEnrollmentStatus = document.getElementById("my-enrollment-status");
const myPaymentStatus = document.getElementById("my-payment-status");

const adminTableBody = document.getElementById("admin-table-body");
const adminTotalInscrits = document.getElementById("admin-total-inscrits");
const adminObertes = document.getElementById("admin-obertes");
const adminCompletes = document.getElementById("admin-completes");

const enrollmentModal = document.getElementById("enrollment-modal");
const modalTitle = document.getElementById("modal-title");
const modalSubtitle = document.getElementById("modal-subtitle");
const modalPrice = document.getElementById("modal-price");
const enrollmentForm = document.getElementById("enrollment-form");

const modalCloseBtn = document.getElementById("modal-close-btn");
const modalCloseBackdrop = document.getElementById("modal-close-backdrop");
const cancelEnrollment = document.getElementById("cancel-enrollment");

const toast = document.getElementById("toast");
const toastMessage = document.getElementById("toast-message");

function init() {
  populateFilters();
  bindEvents();
  renderAll();
}

function bindEvents() {
  viewToggle.addEventListener("click", toggleView);

  filterEtapa.addEventListener("change", (e) => {
    filters.etapa = e.target.value;
    renderActivities();
  });

  filterDia.addEventListener("change", (e) => {
    filters.dia = e.target.value;
    renderActivities();
  });

  enrollmentForm.addEventListener("submit", handleEnrollmentSubmit);

  modalCloseBtn.addEventListener("click", closeModal);
  modalCloseBackdrop.addEventListener("click", closeModal);
  cancelEnrollment.addEventListener("click", closeModal);
}

function populateFilters() {
  const etapes = [...new Set(activitats.map((a) => a.etapa))];
  const dies = [...new Set(activitats.map((a) => a.dia))];

  etapes.forEach((etapa) => {
    const option = document.createElement("option");
    option.value = etapa;
    option.textContent = etapa;
    filterEtapa.appendChild(option);
  });

  dies.forEach((dia) => {
    const option = document.createElement("option");
    option.value = dia;
    option.textContent = dia;
    filterDia.appendChild(option);
  });
}

function renderAll() {
  renderStats();
  renderActivities();
  renderMyEnrollment();
  renderAdminTable();
  renderAdminStats();
}

function toggleView() {
  currentViewIsAdmin = !currentViewIsAdmin;

  if (currentViewIsAdmin) {
    vistaFamilia.classList.add("hidden");
    vistaSecretaria.classList.remove("hidden");
    viewToggle.textContent = "Vista Família";
  } else {
    vistaSecretaria.classList.add("hidden");
    vistaFamilia.classList.remove("hidden");
    viewToggle.textContent = "Vista Secretaria";
  }
}

function getFilteredActivities() {
  return activitats.filter((activitat) => {
    const matchEtapa =
      filters.etapa === "Totes" || activitat.etapa === filters.etapa;
    const matchDia =
      filters.dia === "Tots" || activitat.dia === filters.dia;

    return matchEtapa && matchDia;
  });
}

function getPlacesLliures(activitat) {
  return activitat.placesTotals - activitat.placesOcupades;
}

function getOccupancyPercentage(activitat) {
  return Math.round((activitat.placesOcupades / activitat.placesTotals) * 100);
}

function getProgressClass(percentage) {
  if (percentage < 60) return "progress-low";
  if (percentage < 85) return "progress-medium";
  return "progress-high";
}

function renderStats() {
  statActivitats.textContent = activitats.length;

  const totalPlacesLliures = activitats.reduce(
    (acc, activitat) => acc + getPlacesLliures(activitat),
    0
  );
  statPlaces.textContent = totalPlacesLliures;

  const totalInscripcions = activitats.reduce(
    (acc, activitat) => acc + activitat.placesOcupades,
    0
  );
  statInscripcions.textContent = totalInscripcions;
}

function renderActivities() {
  const filtered = getFilteredActivities();
  activitiesGrid.innerHTML = "";

  if (filtered.length === 0) {
    activitiesGrid.innerHTML = `
      <div class="md:col-span-2 xl:col-span-3 bg-white rounded-3xl p-10 border border-slate-200 shadow-sm text-center">
        <p class="text-lg font-semibold text-slate-800">No hi ha activitats amb aquests filtres</p>
        <p class="text-slate-500 mt-2">Prova amb una altra etapa o un altre dia.</p>
      </div>
    `;
    return;
  }

  filtered.forEach((activitat) => {
    const placesLliures = getPlacesLliures(activitat);
    const occupancy = getOccupancyPercentage(activitat);
    const isFull = placesLliures <= 0 || activitat.estat === "Completa";
    const isMyCurrentActivity = myEnrollment?.activityId === activitat.id;

    const article = document.createElement("article");
    article.className =
      "bg-white rounded-3xl p-6 border border-slate-200 shadow-sm card-hover";

    article.innerHTML = `
      <div class="flex items-start justify-between gap-4 mb-4">
        <div>
          <p class="text-sm text-slate-500">${activitat.etapa}</p>
          <h3 class="text-xl font-bold mt-1">${activitat.nom}</h3>
        </div>
        <span class="badge ${isFull ? "badge-full" : "badge-open"}">
          ${isFull ? "Completa" : "Oberta"}
        </span>
      </div>

      <p class="text-slate-600 mb-5 leading-relaxed">${activitat.descripcio}</p>

      <div class="grid grid-cols-2 gap-3 mb-5">
        <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
          <p class="text-sm text-slate-500">Dia</p>
          <p class="font-semibold">${activitat.dia}</p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
          <p class="text-sm text-slate-500">Hora</p>
          <p class="font-semibold">${activitat.hora}</p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
          <p class="text-sm text-slate-500">Preu</p>
          <p class="font-semibold">${activitat.preu}</p>
        </div>
        <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
          <p class="text-sm text-slate-500">Espai</p>
          <p class="font-semibold">${activitat.espai}</p>
        </div>
      </div>

      <div class="mb-4">
        <div class="flex items-center justify-between text-sm mb-2">
          <span class="text-slate-500">Places ocupades</span>
          <span class="font-semibold">${activitat.placesOcupades}/${activitat.placesTotals}</span>
        </div>
        <div class="progress-wrap">
          <div class="progress-bar ${getProgressClass(occupancy)}" style="width: ${occupancy}%"></div>
        </div>
        <p class="text-sm mt-2 ${isFull ? "text-red-600" : "text-teal-700"} font-medium">
          ${isFull ? "No queden places disponibles" : `${placesLliures} places lliures`}
        </p>
      </div>

      <div class="flex flex-wrap gap-2 mb-5">
        <span class="kpi-pill">Monitor: ${activitat.monitor}</span>
        <span class="kpi-pill">Pagament: ${activitat.pagament}</span>
      </div>

      <button
        class="w-full px-4 py-3 rounded-xl font-semibold transition ${
          isFull || isMyCurrentActivity
            ? "bg-slate-200 text-slate-500 cursor-not-allowed"
            : "bg-teal-600 text-white hover:bg-teal-700"
        }"
        ${isFull || isMyCurrentActivity ? "disabled" : ""}
        data-enroll-id="${activitat.id}"
      >
        ${
          isMyCurrentActivity
            ? "Ja inscrita"
            : isFull
            ? "Activitat completa"
            : "Inscriure'm"
        }
      </button>
    `;

    activitiesGrid.appendChild(article);
  });

  document.querySelectorAll("[data-enroll-id]").forEach((button) => {
    button.addEventListener("click", () => {
      const activityId = Number(button.dataset.enrollId);
      openEnrollmentModal(activityId);
    });
  });
}

function renderMyEnrollment() {
  if (!myEnrollment) {
    myEnrollmentStatus.textContent = "Encara no tens cap activitat seleccionada";
    myPaymentStatus.textContent = "Pendent";
    myPaymentStatus.className = "font-semibold text-amber-600 mt-1";
    return;
  }

  const activitat = activitats.find((a) => a.id === myEnrollment.activityId);
  if (!activitat) return;

  myEnrollmentStatus.textContent = `${activitat.nom} · ${activitat.dia} · ${activitat.hora}`;
  myPaymentStatus.textContent = myEnrollment.paymentStatus;

  if (myEnrollment.paymentStatus === "Completat") {
    myPaymentStatus.className = "font-semibold text-emerald-600 mt-1";
  } else {
    myPaymentStatus.className = "font-semibold text-amber-600 mt-1";
  }
}

function renderAdminStats() {
  const totalInscrits = activitats.reduce(
    (acc, activitat) => acc + activitat.placesOcupades,
    0
  );
  const obertes = activitats.filter((a) => a.estat === "Oberta").length;
  const completes = activitats.filter((a) => a.estat === "Completa").length;

  adminTotalInscrits.textContent = totalInscrits;
  adminObertes.textContent = obertes;
  adminCompletes.textContent = completes;
}

function renderAdminTable() {
  adminTableBody.innerHTML = "";

  activitats.forEach((activitat) => {
    const placesLliures = getPlacesLliures(activitat);
    const isOpen = activitat.estat === "Oberta";

    const tr = document.createElement("tr");
    tr.className = "hover:bg-slate-50 transition-colors";

    tr.innerHTML = `
      <td class="px-6 py-4">
        <div>
          <p class="font-semibold text-slate-800">${activitat.nom}</p>
          <p class="text-sm text-slate-500">${activitat.monitor}</p>
        </div>
      </td>
      <td class="px-6 py-4 text-slate-600">${activitat.etapa}</td>
      <td class="px-6 py-4 text-slate-600">${activitat.dia} · ${activitat.hora}</td>
      <td class="px-6 py-4">
        <div>
          <p class="font-semibold">${activitat.placesOcupades}/${activitat.placesTotals}</p>
          <p class="text-sm ${placesLliures === 0 ? "text-red-600" : "text-slate-500"}">
            ${placesLliures} lliures
          </p>
        </div>
      </td>
      <td class="px-6 py-4">
        <span class="badge ${
          activitat.pagament === "Completat"
            ? "badge-payment-done"
            : "badge-payment-pending"
        }">
          ${activitat.pagament}
        </span>
      </td>
      <td class="px-6 py-4">
        <span class="badge ${isOpen ? "badge-open" : "badge-full"}">
          ${activitat.estat}
        </span>
      </td>
      <td class="px-6 py-4">
        <button
          class="admin-action-btn ${isOpen ? "close" : "open"}"
          data-toggle-status="${activitat.id}"
        >
          ${isOpen ? "Tancar inscripció" : "Reobrir"}
        </button>
      </td>
    `;

    adminTableBody.appendChild(tr);
  });

  document.querySelectorAll("[data-toggle-status]").forEach((button) => {
    button.addEventListener("click", () => {
      const activityId = Number(button.dataset.toggleStatus);
      toggleActivityStatus(activityId);
    });
  });
}

function openEnrollmentModal(activityId) {
  const activitat = activitats.find((a) => a.id === activityId);
  if (!activitat) return;

  selectedActivityId = activityId;
  modalTitle.textContent = `Inscripció a ${activitat.nom}`;
  modalSubtitle.textContent = `${activitat.etapa} · ${activitat.dia} · ${activitat.hora} · ${activitat.espai}`;
  modalPrice.textContent = activitat.preu;

  enrollmentModal.classList.remove("hidden");
}

function closeModal() {
  enrollmentModal.classList.add("hidden");
  enrollmentForm.reset();
  selectedActivityId = null;
}

function handleEnrollmentSubmit(event) {
  event.preventDefault();

  const activitat = activitats.find((a) => a.id === selectedActivityId);
  if (!activitat) return;

  const placesLliures = getPlacesLliures(activitat);
  if (placesLliures <= 0 || activitat.estat === "Completa") {
    showToast("Aquesta activitat ja no té places disponibles.");
    closeModal();
    return;
  }

  if (myEnrollment) {
    showToast("Ja tens una inscripció activa en aquesta simulació.");
    closeModal();
    return;
  }

  activitat.placesOcupades += 1;

  if (activitat.placesOcupades >= activitat.placesTotals) {
    activitat.estat = "Completa";
  }

  myEnrollment = {
    activityId: activitat.id,
    paymentStatus: "Pendent"
  };

  if (activitat.nom === "Dibuix i Il·lustració") {
    myEnrollment.paymentStatus = "Completat";
    activitat.pagament = "Completat";
  }

  showToast(`Inscripció confirmada a ${activitat.nom}.`);
  closeModal();
  renderAll();
}

function toggleActivityStatus(activityId) {
  const activitat = activitats.find((a) => a.id === activityId);
  if (!activitat) return;

  if (activitat.estat === "Oberta") {
    activitat.estat = "Completa";
    showToast(`S'ha tancat la inscripció de ${activitat.nom}.`);
  } else {
    const placesLliures = getPlacesLliures(activitat);
    activitat.estat = placesLliures > 0 ? "Oberta" : "Completa";
    showToast(`S'ha revisat l'estat de ${activitat.nom}.`);
  }

  renderAll();
}

function showToast(message) {
  toastMessage.textContent = message;
  toast.classList.remove("hidden");

  clearTimeout(showToast.timeoutId);
  showToast.timeoutId = setTimeout(() => {
    toast.classList.add("hidden");
  }, 2600);
}

init();