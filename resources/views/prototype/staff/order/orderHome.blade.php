<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>モバイルオーダー</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

  <header>
  </header>

  <nav class="tabs">

    <button class="tab active" onclick="showMenu('food', event)">
      料理
    </button>

    <button class="tab" onclick="showMenu('drink', event)">
      ドリンク
    </button>

    <button class="tab" onclick="showMenu('service', event)">
      サービス
    </button>

    <button class="tab" onclick="showMenu('limited', event)">
      店舗限定
    </button>
    
  </nav>

  <main id="menu-list"></main>

  <footer>
    <a href="{{ url('/prototype/staff/order/cart') }}">
      <button>注文カゴ</button>
    </a>
    <a href="{{ url('prototype/home') }}">
      <button>
        ホーム
      </button>
    </a>
  </footer>

</div>

<script>
  const menus = {
    food: [
      { name: 'ねぎま', price: '150円', image: '/images/negima.jpg' },
      { name: 'もも', price: '150円', image: '/images/momo.jpg' },
      { name: 'せせり', price: '150円', image: '/images/seseri.jpg' },
    ],
    drink: [
      { name: '生ビール', price: '500円', image: '/images/beer.jpg' },
      { name: 'ハイボール', price: '450円', image: '/images/highball.jpg' },
    ],
    service: [
      { name: 'おしぼり', price: '無料', image: '/images/towel.jpg' },
      { name: '取り皿', price: '無料', image: '/images/plate.jpg' },
    ],
    limited: [
      { name: '限定串', price: '300円', image: '/images/limited.jpg' },
    ],
  };

  function showMenu(category, event) {
    const menuList = document.getElementById('menu-list');

    if (!menuList || !menus[category]) {
      return;
    }

    menuList.innerHTML = '';

    menus[category].forEach((item) => {
      menuList.innerHTML += `
        <a href="{{ url('/prototype/staff/order/detail') }}" class="item">
          <div class="item-text">
            <h2>${item.name}</h2>
            <p>${item.price}</p>
          </div>
          <img src="${item.image}" alt="">
        </a>
      `;
    });

    document.querySelectorAll('.tab').forEach((tab) => {
      tab.classList.remove('active');
    });

    if (event && event.target) {
      event.target.classList.add('active');
    }
  }

  window.showMenu = showMenu;

  window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const category = params.get('category') || 'food';
    const tabs = document.querySelectorAll('.tab');

    let targetTab = tabs[0];

    if (category === 'drink') {
      targetTab = tabs[1];
    }

    if (category === 'service') {
      targetTab = tabs[2];
    }

    if (category === 'limited') {
      targetTab = tabs[3];
    }

    showMenu(category, {
      target: targetTab,
    });
  });
</script>

</body>
</html>