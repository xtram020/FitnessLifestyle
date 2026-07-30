document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("reservationModal");
  const closeBtn = document.getElementById("closeModal");
  const cancelBtn = document.getElementById("cancelModal");
  const trainerIdInput = document.getElementById("modalTrainerId");
  const subtitle = document.getElementById("modalSubtitle");

  const dateInput = document.getElementById("reservation_date");
  const timeSlots = document.getElementById("timeSlots");
  const startDatetimeInput = document.getElementById("start_datetime");

  function openModal(trainerId, trainerName){
    trainerIdInput.value = trainerId;
    subtitle.textContent = trainerName ? `Rezervace u trenéra: ${trainerName}` : "";
    dateInput.value = "";
    startDatetimeInput.value = "";
    timeSlots.innerHTML = '<div class="slots-placeholder">Vyber datum.</div>';
    modal.classList.add("is-open");
    modal.setAttribute("aria-hidden", "false");
  }

  function closeModal(){
    modal.classList.remove("is-open");
    modal.setAttribute("aria-hidden", "true");
  }

  document.querySelectorAll("a.open-reservation").forEach(link => {
    link.addEventListener("click", (e) => {
      e.preventDefault();

      const url = new URL(link.href, window.location.origin);
      const trainerId = url.searchParams.get("trainer_id");
      const trainerName = link.dataset.trainerName || "";

      if (!trainerId) return;

      openModal(trainerId, trainerName);
    });
  });

  closeBtn.addEventListener("click", closeModal);
  cancelBtn.addEventListener("click", closeModal);

  modal.addEventListener("click", (e) => {
    if (e.target === modal) closeModal();
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && modal.classList.contains("is-open")) closeModal();
  });

  dateInput.addEventListener("change", () => {
    const trainerId = trainerIdInput.value;
    const date = dateInput.value;

    if (!trainerId || !date) {
      timeSlots.innerHTML = '<div class="slots-placeholder">Vyber datum.</div>';
      return;
    }

    timeSlots.innerHTML = '<div class="slots-placeholder">Načítám...</div>';
    startDatetimeInput.value = "";

    fetch(`get_available_slots.php?trainer_id=${trainerId}&date=${date}`)
      .then(response => response.json())
      .then(slots => {
        timeSlots.innerHTML = "";

        if (!slots.length) {
          timeSlots.innerHTML = '<div class="slots-placeholder">Žádné volné časy.</div>';
          return;
        }

       slots.forEach(slot => {
  const btn = document.createElement("button");
  btn.type = "button";
  btn.textContent = slot;
  btn.className = "slot-btn";

  btn.onclick = function () {
    document.querySelectorAll(".slot-btn").forEach(function (b) {
      b.classList.remove("selected");
    });

    btn.classList.add("selected");
    startDatetimeInput.value = date + " " + slot + ":00";

    console.log("Vybraný termín:", startDatetimeInput.value);
  };

  timeSlots.appendChild(btn);
});
      })
      .catch(() => {
        timeSlots.innerHTML = '<div class="slots-placeholder">Chyba při načítání.</div>';
      });
  });
});