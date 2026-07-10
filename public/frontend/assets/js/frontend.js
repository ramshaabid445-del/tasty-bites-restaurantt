(function () {
  const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

  function toast(message, type = 'success') {
    const element = document.createElement('div');
    element.className = `ajax-toast ${type === 'error' ? 'is-error' : 'is-success'}`;
    element.textContent = message;
    document.body.appendChild(element);
    setTimeout(() => element.remove(), 3000);
  }

  window.addEventListener('load', () => {
    if (window.AOS) AOS.init({ duration: 550, once: true });
    document.querySelectorAll('[data-flash-message]').forEach((element) => setTimeout(() => element.remove(), 3500));
  });

  document.addEventListener('scroll', () => {
    document.querySelector('[data-header]')?.classList.toggle('is-sticky', window.scrollY > 20);
  });

  document.addEventListener('click', (event) => {
    if (event.target.matches('[data-qty-minus], [data-qty-plus]')) {
      const input = document.querySelector('[data-qty-input]');
      if (!input) return;
      const delta = event.target.matches('[data-qty-plus]') ? 1 : -1;
      input.value = Math.max(1, Number(input.value || 1) + delta);
      input.dispatchEvent(new Event('change'));
    }

    const quickButton = event.target.closest('[data-add-to-cart]');
    if (quickButton) {
      event.preventDefault();
      addToCart({ menu_item_id: quickButton.dataset.menuItemId, quantity: 1 }, quickButton);
    }
  });

  document.addEventListener('submit', (event) => {
    const form = event.target.closest('[data-add-to-cart-form]');
    if (!form) return;
    event.preventDefault();
    addToCart(new FormData(form), form.querySelector('button[type="submit"]'));
  });

  function addToCart(payload, button) {
    const oldText = button?.textContent;
    if (button) {
      button.disabled = true;
      button.textContent = 'Adding...';
    }

    fetch('/cart/add', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
      body: payload instanceof FormData ? payload : new URLSearchParams(payload),
    })
      .then((response) => response.ok ? response.json() : Promise.reject(response))
      .then((data) => {
        document.querySelectorAll('[data-cart-count]').forEach((element) => element.textContent = data.count);
        toast(data.message || 'Added to cart');
      })
      .catch(() => toast('Could not add item to cart.', 'error'))
      .finally(() => {
        if (button) {
          button.disabled = false;
          button.textContent = oldText;
        }
      });
  }

  function updateAddonTotal() {
    const priceTarget = document.querySelector('[data-total-price]');
    if (!priceTarget) return;
    const base = Number(priceTarget.dataset.basePrice || 0);
    const addons = Array.from(document.querySelectorAll('[data-addon-price]:checked')).reduce((sum, input) => sum + Number(input.dataset.addonPrice || 0), 0);
    const quantity = Number(document.querySelector('[data-qty-input]')?.value || 1);
    priceTarget.textContent = ((base + addons) * quantity).toFixed(2);
  }

  document.addEventListener('change', (event) => {
    if (event.target.matches('[data-addon-price], [data-qty-input]')) updateAddonTotal();
  });

  const searchInput = document.querySelector('[data-live-search-url]');
  const results = document.querySelector('[data-search-results]');
  let timer;
  searchInput?.addEventListener('input', () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      const query = searchInput.value.trim();
      if (query.length < 2) {
        results.innerHTML = '';
        return;
      }

      fetch(`${searchInput.dataset.liveSearchUrl}?q=${encodeURIComponent(query)}`, { headers: { 'Accept': 'application/json' } })
        .then((response) => response.json())
        .then((items) => {
          results.innerHTML = items.length
            ? items.map((item) => `<a class="live-search-result" href="${item.url}"><img src="${item.image}" alt="${item.name}"><span>${item.name}<br><strong>Rs. ${item.price}</strong></span></a>`).join('')
            : '<div class="live-search-result">No menu items found.</div>';
        });
    }, 300);
  });
})();
