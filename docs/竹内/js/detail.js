
let count = 1;

const countText =
  document.getElementById("count");

const plusBtn =
  document.getElementById("plusBtn");

const minusBtn =
  document.getElementById("minusBtn");

const tareBtn =
  document.getElementById("tareBtn");

const shioBtn =
  document.getElementById("shioBtn");

const orderBtn =
  document.getElementById("orderBtn");


// 味選択
function enableCounter(){
  count = 1

  countText.textContent = count

  plusBtn.disabled = false;

  minusBtn.disabled = true;

  orderBtn.disabled = false;

  tareBtn.classList.remove("selected");

  shioBtn.classList.remove("selected");

}


// タレ
tareBtn.addEventListener("click", () => {

  enableCounter();

  tareBtn.classList.add("selected");

});


// 塩
shioBtn.addEventListener("click", () => {

  enableCounter();

  shioBtn.classList.add("selected");

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

  if(count > 0){

    window.location.href =
      "add.html";

  }else{

    alert("数量を選択してください");

  }

});