const menu = document.querySelector('#mobile-menu')
const menuLinks = document.querySelector('.navbar__menu')


menu.addEventListener('click', function() {
  menu.classList.toggle('is-active');
  menuLinks.classList.toggle('active');
});


document.querySelectorAll(".like-btn").forEach(btn => {
  const postId = btn.dataset.postId;          // bere data, post, id z blog.php
  const countSpan = btn.querySelector(".like-count");

  btn.addEventListener("click", async () => {
    const fd = new FormData();
    fd.append("post_id", postId);

    const res = await fetch("blog_likes.php", {
      method: "POST",
      body: fd
    });

    if (res.status === 401) {
      showLoginMessage();
    return;
    }

    // pro jistotu, kdyby mi server vrátil chybu
    if (!res.ok) {
      console.error("Like error", await res.text());
      return;
    }

    const data = await res.json(); // { liked - true/false, likes - number }

    btn.classList.toggle("liked", data.liked);
    countSpan.textContent = data.likes;
  });
});

function showLoginMessage() {
  let msg = document.getElementById("login-popup");

  if (!msg) {
    msg = document.createElement("div");
    msg.id = "login-popup";
    msg.textContent = "Pro hodnocení článků je nutné se přihlásit.";

    Object.assign(msg.style, {
      position: "fixed",
      bottom: "20px",
      left: "50%",
      transform: "translateX(-50%)",
      background: "#111",
      color: "#fff",
      padding: "12px 20px",
      borderRadius: "8px",
      boxShadow: "0 5px 15px rgba(0,0,0,.4)",
      zIndex: "9999",
      fontSize: "14px",
      opacity: "0",
      transition: "opacity .3s"
    });

    document.body.appendChild(msg);
  }

  msg.style.opacity = "1";

  setTimeout(() => {
    msg.style.opacity = "0";
  }, 2500);
}


const dateInput = document.getElementById("reservation_date");
const timeSlots = document.getElementById("timeSlots");
const startDatetime = document.getElementById("start_datetime");
const trainerInput = document.getElementById("modalTrainerId");

if (dateInput && timeSlots && startDatetime && trainerInput) {

  dateInput.addEventListener("change", function () {

    const date = dateInput.value;
    const trainerId = trainerInput.value;

    startDatetime.value = "";

    if (!date) {
      timeSlots.innerHTML = '<div class="slots-placeholder">Vyber datum.</div>';
      return;
    }

    fetch("../get_available_slots.php?trainer_id=" + trainerId + "&date=" + date)
      .then(res => res.json())
      .then(data => {

        timeSlots.innerHTML = "";

        if (data.length === 0) {
          timeSlots.innerHTML = '<div class="slots-placeholder">Pro vybraný den nejsou volné termíny.</div>';
          return;
        }

        data.forEach(function(time){

          const btn = document.createElement("button");
          btn.type = "button";
          btn.className = "time-slot";
          btn.textContent = time;

          btn.onclick = function(){

            document.querySelectorAll(".time-slot").forEach(function(b){
              b.classList.remove("active");
            });

            btn.classList.add("active");
            startDatetime.value = date + " " + time + ":00";
          }

          timeSlots.appendChild(btn);

        });

      });

  });

}

