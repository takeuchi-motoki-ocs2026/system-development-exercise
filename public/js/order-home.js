document.addEventListener('DOMContentLoaded', () => {
  const menus = {
    food: [
      { key: 'negima', name: 'ねぎま', price: '150円', image: '/images/negima.jpg' },
      { key: 'momo', name: 'もも', price: '150円', image: '/images/momo.jpg' },
      { key: 'seseri', name: 'せせり', price: '150円', image: '/images/seseri.jpg', soldOut: true },
    ],
    drink: [
      { key: 'beer', name: '生ビール', price: '500円', image: '/images/beer.jpg' },
      { key: 'highball', name: 'ハイボール', price: '450円', image: '/images/highball.jpg' },
    ],
    service: [
      { key: 'towel', name: 'おしぼり', price: '無料', image: '/images/towel.jpg' },
      { key: 'plate', name: '取り皿', price: '無料', image: '/images/plate.jpg' },
    ],
    limited: [
      { key: 'limited', name: '限定串', price: '300円', image: '/images/limited.jpg' },
    ],
  };

  const detailUrl = document.body.dataset.detailUrl || '/prototype/detail';

  function showMenu(category, event) {
    const menuList = document.getElementById('menu-list');

    if (!menuList || !menus[category]) {
      return;
    }

    menuList.innerHTML = '';

    menus[category].forEach((item) => {
      const wrapperTag = item.soldOut ? 'div' : 'a';
      const wrapperAttrs = item.soldOut
        ? 'class="item sold-out"'
        : `href="${detailUrl}?item=${item.key}" class="item"`;
      const soldOutLabel = item.soldOut
        ? '<span class="sold-out-label">品切れ</span>'
        : '';

      menuList.innerHTML += `
        <${wrapperTag} ${wrapperAttrs}>
          <div class="item-text">
            <h2>${item.name}</h2>
            <p>${item.price}</p>
            ${soldOutLabel}
          </div>
          <img src="${item.image}" alt="">
        </${wrapperTag}>
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
