document.addEventListener("DOMContentLoaded", function () {
  const toggleBtn = document.getElementById("theme-toggle");
  const icon = toggleBtn.querySelector("i");

  const body = document.getElementById("main-body");
  const navbar = document.getElementById("main-navbar");
  const products = document.querySelectorAll(".product");
  const navLinks = document.querySelectorAll(".nav-link, .navbar-brand, .dropdown-item");
  const dropdownMenu = document.querySelectorAll(".dropdown-menu");

  toggleBtn.addEventListener("click", function () {
    const isLight = body.classList.contains("bg-light");

    
    body.classList.toggle("bg-light", !isLight);
    body.classList.toggle("text-dark", !isLight);
    body.classList.toggle("bg-dark", isLight);
    body.classList.toggle("text-light", isLight);

    navbar.classList.toggle("bg-light", !isLight);
    navbar.classList.toggle("bg-dark", isLight);

    navLinks.forEach(link => {
      link.classList.toggle("text-dark", !isLight);
      link.classList.toggle("text-light", isLight);
    });

    products.forEach(product => {
      product.classList.toggle("bg-light", !isLight);
      product.classList.toggle("text-dark", !isLight);
      product.classList.toggle("bg-dark", isLight);
      product.classList.toggle("text-light", isLight);
    });

    dropdownMenu.forEach(menu => {
      menu.classList.toggle("bg-light", !isLight);
      menu.classList.toggle("bg-dark", isLight);
    });

    icon.classList.toggle("bi-moon-stars-fill", !isLight);
    icon.classList.toggle("bi-sun-fill", isLight);
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const colorPicker = document.getElementById("bg-color-picker");
  const body = document.getElementById("main-body");
  const navbar = document.getElementById("main-navbar");
  const productCards = document.querySelectorAll(".product");
  const navLinks = document.querySelectorAll(".nav-link, .navbar-brand, .dropdown-item");
  const productsSection = document.querySelector(".products");

  colorPicker.addEventListener("input", (e) => {
    const baseColor = e.target.value;

    body.classList.remove("bg-light", "bg-dark", "text-light", "text-dark");
    navbar.classList.remove("bg-light", "bg-dark");
    productsSection.classList.remove("bg-light", "bg-dark");

    const bodyGradient = `linear-gradient(to bottom right, ${baseColor}, ${darkenColor(baseColor, 30)})`;
    body.style.background = bodyGradient;

    productsSection.style.background = `linear-gradient(to bottom, ${lightenColor(baseColor, 20)}, ${baseColor})`;

    navbar.style.background = `linear-gradient(to right, ${darkenColor(baseColor, 10)}, ${baseColor})`;

    const brightness = getBrightness(baseColor);
    const textColor = brightness > 128 ? "black" : "white";
    body.style.color = textColor;
    navbar.style.color = textColor;
    productsSection.style.color = textColor;

    navLinks.forEach(el => {
      el.style.color = textColor;
    });

    productCards.forEach(card => {
      card.style.background = `linear-gradient(to bottom right, ${lightenColor(baseColor, 30)}, ${baseColor})`;
      card.style.color = textColor;
      card.style.border = "2px solid " + darkenColor(baseColor, 40);
    });
  });

  function getBrightness(hex) {
    const r = parseInt(hex.substr(1, 2), 16);
    const g = parseInt(hex.substr(3, 2), 16);
    const b = parseInt(hex.substr(5, 2), 16);
    return (r * 299 + g * 587 + b * 114) / 1000;
  }

  function darkenColor(hex, percent) {
    let r = parseInt(hex.substr(1, 2), 16);
    let g = parseInt(hex.substr(3, 2), 16);
    let b = parseInt(hex.substr(5, 2), 16);

    r = Math.max(0, r - Math.round((r * percent) / 100));
    g = Math.max(0, g - Math.round((g * percent) / 100));
    b = Math.max(0, b - Math.round((b * percent) / 100));

    return `rgb(${r}, ${g}, ${b})`;
  }

  function lightenColor(hex, percent) {
    let r = parseInt(hex.substr(1, 2), 16);
    let g = parseInt(hex.substr(3, 2), 16);
    let b = parseInt(hex.substr(5, 2), 16);

    r = Math.min(255, r + Math.round((255 - r) * (percent / 100)));
    g = Math.min(255, g + Math.round((255 - g) * (percent / 100)));
    b = Math.min(255, b + Math.round((255 - b) * (percent / 100)));

    return `rgb(${r}, ${g}, ${b})`;
  }
});
