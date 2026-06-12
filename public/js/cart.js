const cartList = document.querySelector(".history-list");
const totalArea = document.querySelector(".total-area");
const deleteAllBtn = document.querySelector(".delete-all-btn");

function toNumber(value) {
  const normalized = value
    .replace(/[^0-9０-９]/g, "")
    .replace(/[０-９]/g, (m) => String.fromCharCode(m.charCodeAt(0) - 0xFEE0));
  return Number(normalized) || 0;
}

function updateTotal() {
  const rows = Array.from(document.querySelectorAll(".history-row"));
  const total = rows.reduce((sum, row) => {
    const priceText = row.querySelector(".item-price").textContent;
    const countText = row.querySelector(".item-count").textContent;
    const price = toNumber(priceText);
    const count = toNumber(countText);
    return sum + price * count;
  }, 0);
  totalArea.textContent = `合計　${total}円`;
}

function updateButtonStates(row) {
  const countValue = toNumber(row.querySelector(".item-count").textContent);
  const minusBtn = row.querySelector(".minus-btn");
  const plusBtn = row.querySelector(".plus-btn");
  
  if (minusBtn) minusBtn.disabled = countValue <= 1;
  if (plusBtn) plusBtn.disabled = countValue >= 4;
}

function bindDeleteButtons() {
  document.querySelectorAll(".delete-item-btn").forEach((button) => {
    button.addEventListener("click", () => {
      const row = button.closest(".history-row");
      if (row) {
        row.remove();
        updateTotal();
      }
    });
  });
}

function bindQuantityButtons() {
  document.querySelectorAll(".qty-btn").forEach((button) => {
    button.addEventListener("click", () => {
      const row = button.closest(".history-row");
      const countDisplay = row.querySelector(".item-count");
      let currentCount = toNumber(countDisplay.textContent);

      if (button.classList.contains("plus-btn")) {
        if (currentCount < 4) {
          currentCount++;
        }
      } else if (button.classList.contains("minus-btn")) {
        if (currentCount > 1) {
          currentCount--;
        }
      }

      countDisplay.textContent = currentCount;
      updateButtonStates(row);
      updateTotal();
    });
  });
}

if (deleteAllBtn) {
  deleteAllBtn.addEventListener("click", () => {
    cartList.innerHTML = "";
    updateTotal();
  });
}

window.addEventListener("DOMContentLoaded", () => {
  bindDeleteButtons();
  bindQuantityButtons();
  
  // Initialize button states
  document.querySelectorAll(".history-row").forEach((row) => {
    updateButtonStates(row);
  });
  
  updateTotal();
});

// If redirected after server-side clear, remove displayed items as well
(() => {
  try {
    const params = new URLSearchParams(window.location.search);
    if (params.get('cleared') === '1') {
      if (cartList) {
        cartList.innerHTML = '';
      }
      updateTotal();
      // Optionally clear any client-side storage key named 'cart'
      try { localStorage.removeItem('cart'); } catch (e) {}
    }
  } catch (e) {}
})();
