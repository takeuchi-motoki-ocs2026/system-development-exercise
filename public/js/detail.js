
let count = 1;

const countText =
  document.getElementById("count");

const plusBtn =
  document.getElementById("plusBtn");

const minusBtn =
  document.getElementById("minusBtn");

const optionButtons = document.querySelectorAll(".option-btn");
let selectedOption = "";

const orderBtn =
  document.getElementById("orderBtn");


// 味選択
function enableCounter(){
  count = 1

  countText.textContent = count

  plusBtn.disabled = false;

  minusBtn.disabled = true;

  orderBtn.disabled = false;

}

optionButtons.forEach(button => {

    button.addEventListener("click", () => {

        optionButtons.forEach(btn =>
            btn.classList.remove("selected")
        );

        button.classList.add("selected");

        selectedOption = button.textContent.trim();

        count = 1;
        countText.textContent = count;

        plusBtn.disabled = false;
        minusBtn.disabled = true;
        orderBtn.disabled = false;
    });

});

// ＋
plusBtn.addEventListener("click", () => {

  if(count < 4){

    count++;

    countText.textContent = count;

    //＋無効
    if(count >= 4){
      plusBtn.disabled = true;
    }
    //－有効
    if(count > 1){
      minusBtn.disabled = false;
    }
  }
});


// －
minusBtn.addEventListener("click", () => {

  if(count > 1){

    count--;

    countText.textContent = count;

    //－無効
    if(count <= 1){
      minusBtn.disabled = true;
    }
    //＋有効
    if(count < 4){
      plusBtn.disabled = false;
    }
  }
});


// 注文確認
orderBtn.addEventListener("click", () => {

    // オプションがある商品なのに選択していない場合
    if (optionButtons.length > 0 && selectedOption === "") {
        alert("オプションを選択してください");
        return;
    }

    document.getElementById("optionInput").value = selectedOption;
    document.getElementById("quantityInput").value = count;

    document.querySelector("form").submit();

});