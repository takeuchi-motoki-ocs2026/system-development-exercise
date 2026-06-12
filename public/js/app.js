const menus = {

  food: [

    {
      name:"ねぎま",
      price:"150円",
      image:"/images/negima.jpg"
    },

    {
      name:"もも",
      price:"150円",
      image:"/images/momo.jpg"
    },

    {
      name:"せせり",
      price:"150円",
      image:"/images/seseri.jpg"
    }

  ],

  drink: [

    {
      name:"生ビール",
      price:"0円",
      image:"/images/beer.jpg"
    },

    {
      name:"ハイボール",
      price:"0円",
      image:"/images/highball.jpg"
    }

  ],

  service: [

    {
      name:"おしぼり",
      price:"無料",
      image:"/images/towel.jpg"
    },

    {
      name:"取り皿",
      price:"無料",
      image:"/images/plate.jpg"
    }

  ],

  limited: [

    {
      name:"限定串",
      price:"300円",
      image:"/images/limited.jpg"
    }

  ]

};


// メニュー表示
function showMenu(category, event){

  const menuList =
    document.getElementById("menu-list");

  menuList.innerHTML = "";

  menus[category].forEach(item => {

    menuList.innerHTML += `

      <a href="detail.html" class="item">

        <div class="item-text">

          <h2>${item.name}</h2>

          <p>${item.price}</p>

        </div>

        <img src="${item.image}" alt="">

      </a>

    `;

  });


  // タブ切替
  document.querySelectorAll(".tab")
    .forEach(tab => {
      tab.classList.remove("active");
  });

  event.target.classList.add("active");

}


// URLパラメータ取得
const params =
  new URLSearchParams(window.location.search);

const category =
  params.get("category") || "food";


// 初期表示
window.onload = () => {

  const tabs =
    document.querySelectorAll(".tab");

  let targetTab = tabs[0];

  if(category === "drink"){
    targetTab = tabs[1];
  }

  if(category === "service"){
    targetTab = tabs[2];
  }

  if(category === "limited"){
    targetTab = tabs[3];
  }

  showMenu(category, {
    target:targetTab
  });

};