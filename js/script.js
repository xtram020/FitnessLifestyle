console.log("LOADING SCRIPT.JS - DB VERSION");

function vypocitejBMI() {
    const vaha = parseFloat(document.getElementById("weight").value);
    const vyskaCm = parseFloat(document.getElementById("height").value);
  
    if (!vaha || !vyskaCm || vaha <= 0 || vyskaCm <= 0) {
      document.getElementById("result").textContent = "Zadej platné hodnoty!";
      return;
    }
  
    const vyskaM = vyskaCm / 100;
    const bmi = vaha / (vyskaM * vyskaM);
    let kategorie = "";
  
    if (bmi < 18.5) {
      kategorie = "Podváha";
    } else if (bmi < 25) {
      kategorie = "Normální váha";
    } else if (bmi < 30) {
      kategorie = "Nadváha";
    } else {
      kategorie = "Obezita";
    }
  
    document.getElementById("result").textContent = `Tvé BMI je ${bmi.toFixed(1)} (${kategorie}).`;
  }
  

const menu = document.querySelector('#mobile-menu')
const menuLinks = document.querySelector('.navbar__menu')

menu.addEventListener('click', function() {
    menu.classList.toggle('is-active')
    menuLinks.classList.toggle('active');
});



  // hodnoty 100 g, DB přes API 
let foods = [];


    const foodSelect = document.getElementById("food-select");
    const form = document.getElementById("food-form");
    if (!foodSelect || !form) {
  
} else {

    const amountInput = document.getElementById("amount");
    const amountError = document.getElementById("amount-error");
    const mealBody = document.getElementById("meal-body");

    const totalGramsEl = document.getElementById("total-grams");
    const totalKcalEl = document.getElementById("total-kcal");
    const totalProteinEl = document.getElementById("total-protein");
    const totalCarbsEl = document.getElementById("total-carbs");
    const totalFatEl = document.getElementById("total-fat");

    const totalKcalLabel = document.getElementById("total-kcal-label");
    const totalProteinLabel = document.getElementById("total-protein-label");
    const totalCarbsLabel = document.getElementById("total-carbs-label");
    const totalFatLabel = document.getElementById("total-fat-label");


async function loadFoods() {
  const res = await fetch("api/foods.php");  //stáhnutí dat 
  const data = await res.json();

  foods = data.map(f => ({
    id: Number(f.id),
    name: f.name,
    kcal: Number(f.kcal),
    protein: Number(f.protein),
    carbs: Number(f.carbs),
    fat: Number(f.fat),
  }));
}


function populateFoodSelect(list = foods) {
  foodSelect.innerHTML = ""; 
  list.forEach((food) => {
    const option = document.createElement("option");
    option.value = food.id;
    option.textContent = `${food.name} (${food.kcal} kcal / 100 g)`;
    foodSelect.appendChild(option);
  });
}


function initFoodFilter() {
  const input = document.getElementById("food-filter");
  if (!input) return;

  input.addEventListener("input", () => {
    const q = input.value.toLowerCase().trim();

    const filtered = foods
      .filter(f => f.name.toLowerCase().includes(q))
      .slice(0, 150);

    populateFoodSelect(filtered);
  });
}



    // Zaokrouhlení na 1 desetinné místo
    function round1(num) {
      return Math.round(num * 10) / 10;
    }

    function recalculateTotals() {
      let totalGrams = 0;
      let totalKcal = 0;
      let totalProtein = 0;
      let totalCarbs = 0;
      let totalFat = 0;

      
      mealBody.querySelectorAll("tr").forEach(row => {
        const grams = parseFloat(row.dataset.grams || "0");
        const kcal = parseFloat(row.dataset.kcal || "0");
        const protein = parseFloat(row.dataset.protein || "0");
        const carbs = parseFloat(row.dataset.carbs || "0");
        const fat = parseFloat(row.dataset.fat || "0");

        totalGrams += grams;
        totalKcal += kcal;
        totalProtein += protein;
        totalCarbs += carbs;
        totalFat += fat;
      });

      // nastavit text
      totalGramsEl.textContent = round1(totalGrams);
      totalKcalEl.textContent = round1(totalKcal);
      totalProteinEl.textContent = round1(totalProtein);
      totalCarbsEl.textContent = round1(totalCarbs);
      totalFatEl.textContent = round1(totalFat);

      totalKcalLabel.textContent = `${round1(totalKcal)} kcal`;
      totalProteinLabel.textContent = `${round1(totalProtein)} g`;
      totalCarbsLabel.textContent = `${round1(totalCarbs)} g`;
      totalFatLabel.textContent = `${round1(totalFat)} g`;
    }

    function addMealRow(food, grams) {
      const factor = grams / 100;

      const kcal = food.kcal * factor;
      const protein = food.protein * factor;
      const carbs = food.carbs * factor;
      const fat = food.fat * factor;

      const tr = document.createElement("tr");
      tr.dataset.grams = grams;
      tr.dataset.kcal = kcal;
      tr.dataset.protein = protein;
      tr.dataset.carbs = carbs;
      tr.dataset.fat = fat;

      tr.innerHTML = `
        <td>${food.name}</td>
        <td class="align-right">${round1(grams)}</td>
        <td class="align-right">${round1(kcal)}</td>
        <td class="align-right">${round1(protein)}</td>
        <td class="align-right">${round1(carbs)}</td>
        <td class="align-right">${round1(fat)}</td>
        <td class="align-right">
          <button type="button" class="delete-btn">Smazat</button>
        </td>
      `;

      tr.querySelector(".delete-btn").addEventListener("click", () => {
        tr.remove();
        recalculateTotals();
      });

      mealBody.appendChild(tr);
      recalculateTotals();
    }

   
  form.addEventListener("submit", (event) => {
  event.preventDefault();

  amountError.style.display = "none";

  const foodId = parseInt(foodSelect.value, 10);
  const grams = parseFloat(amountInput.value);

  if (Number.isNaN(grams) || grams <= 0) {
    amountError.textContent = "Zadej prosím množství větší než 0 g.";
    amountError.style.display = "block";
    return;
  }

  const selectedFood = foods.find(f => f.id === foodId);
  if (!selectedFood) return;

  addMealRow(selectedFood, grams);
});






      

    
 (async function init() {
  await loadFoods();
  populateFoodSelect(); 
  initFoodFilter();     
  recalculateTotals();
})();
}



