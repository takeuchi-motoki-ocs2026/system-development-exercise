const cartList = document.querySelector(".history-list");
const totalArea = document.querySelector(".total-area");
const deleteAllBtn = document.querySelector(".delete-all-btn");
const confirmBtn = document.querySelector(".confirm-btn");
const emptyCartMessage = '<div class="empty-cart-message">カゴの中身はありません</div>';

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

function updateCartState() {
  const rows = Array.from(document.querySelectorAll(".history-row"));
  const isEmpty = rows.length === 0;

  if (deleteAllBtn) {
    deleteAllBtn.disabled = isEmpty;
    const deleteLink = deleteAllBtn.closest("a");
    if (deleteLink) {
      if (isEmpty) {
        deleteLink.removeAttribute("href");
      } else {
        const originalHref = deleteAllBtn.dataset.originalHref || deleteLink.getAttribute("href");
        if (originalHref) {
          deleteLink.setAttribute("href", originalHref);
        }
      }
    }
  }

  if (confirmBtn) {
    confirmBtn.disabled = isEmpty;
    const confirmLink = confirmBtn.closest("a");
    if (confirmLink) {
      if (isEmpty) {
        confirmLink.removeAttribute("href");
      } else {
        const originalHref = confirmBtn.dataset.originalHref || confirmLink.getAttribute("href");
        if (originalHref) {
          confirmLink.setAttribute("href", originalHref);
        }
      }
    }
  }

  if (cartList) {
    if (isEmpty) {
      cartList.innerHTML = emptyCartMessage;
    } else {
      const emptyMessage = cartList.querySelector(".empty-cart-message");
      if (emptyMessage) {
        emptyMessage.remove();
      }
    }
  }

  if (totalArea) {
    totalArea.textContent = isEmpty ? "合計　0円" : `合計　${rows.reduce((sum, row) => {
      const priceText = row.querySelector(".item-price").textContent;
      const countText = row.querySelector(".item-count").textContent;
      return sum + toNumber(priceText) * toNumber(countText);
    }, 0)}円`;
  }
}

function bindDeleteButtons() {
  document.querySelectorAll(".delete-item-btn").forEach((button) => {
    button.addEventListener("click", () => {
      const row = button.closest(".history-row");
      if (row) {
        row.remove();
        updateCartState();
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
  deleteAllBtn.dataset.originalHref = deleteAllBtn.closest("a")?.getAttribute("href") || "";
  deleteAllBtn.addEventListener("click", () => {
    if (cartList) {
      cartList.innerHTML = "";
    }
    updateCartState();
  });
}

if (confirmBtn) {
  confirmBtn.dataset.originalHref = confirmBtn.closest("a")?.getAttribute("href") || "";
}

window.addEventListener("DOMContentLoaded", () => {
  bindDeleteButtons();
  bindQuantityButtons();
  
  document.querySelectorAll(".history-row").forEach((row) => {
    updateButtonStates(row);
  });

  updateCartState();
});

// If redirected after server-side clear, remove displayed items as well
(() => {
  try {
    const params = new URLSearchParams(window.location.search);
    if (params.get('cleared') === '1') {
      if (cartList) {
        cartList.innerHTML = '';
      }
      updateCartState();
      // Optionally clear any client-side storage key named 'cart'
      try { localStorage.removeItem('cart'); } catch (e) {}
    }
  } catch (e) {}
})();
