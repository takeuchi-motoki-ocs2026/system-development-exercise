const cartList = document.querySelector(".history-list");
const totalArea = document.querySelector(".total-area");
const deleteAllBtn = document.querySelector(".delete-all-btn");
const confirmBtn = document.querySelector(".confirm-btn");


function toNumber(value) {

  const normalized = value
    .replace(/[^0-9０-９]/g, "")
    .replace(/[０-９]/g, (m) =>
      String.fromCharCode(m.charCodeAt(0) - 0xFEE0)
    );

  return Number(normalized) || 0;

}


// 合計計算
function updateTotal() {

  const rows = Array.from(
    document.querySelectorAll(".history-row")
  );


  const total = rows.reduce((sum, row) => {

    const price =
      toNumber(
        row.querySelector(".item-price").textContent
      );

    const count =
      toNumber(
        row.querySelector(".item-count").textContent
      );


    return sum + price * count;

  }, 0);


  if(totalArea){

    totalArea.textContent =
      `合計　${total}円`;

  }

}


// ＋－ボタン状態
function updateButtonStates(row){

  const count =
    toNumber(
      row.querySelector(".item-count").textContent
    );


  const minusBtn =
    row.querySelector(".minus-btn");

  const plusBtn =
    row.querySelector(".plus-btn");


  if(minusBtn){

    minusBtn.disabled =
      count <= 1;

  }


  if(plusBtn){

    plusBtn.disabled =
      count >= 4;

  }

}




// ゴミ箱
// Laravel側で削除するためJSでは削除しない
function bindDeleteButtons(){

  document.querySelectorAll(".delete-item-btn")
  .forEach(button=>{


    button.addEventListener("click",()=>{

      // form送信をそのまま実行

    });


  });

}



// 全削除
// Laravel側でsession削除するためJSでは何もしない
if(deleteAllBtn){

  // 何もしない

}



// 注文確定
if(confirmBtn){

  // Laravel側で処理

}



// 初期処理
window.addEventListener("DOMContentLoaded",()=>{


  bindDeleteButtons();


  document.querySelectorAll(".history-row")
  .forEach(row=>{

    updateButtonStates(row);

  });


  updateTotal();


});