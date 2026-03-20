
const services = [
  {
    title: "Classic Vanilla Éclair",
    description: "Delicate custard cream with natural vanilla",
    image: "images/vanilla.jpg",
    keywords: "vanilla custard",
    category: "classic"
  },
  {
    title: "Champagne & Strawberry Éclair",
    description: "Flavor with champagne and strawberry mousse",
    image: "images/strawbery.jpg",
    keywords: "strawberry champagne fruit",
    category: "fruit"
  },
  {
    title: "Chocolate Éclair",
    description: "Dark Belgian chocolate with rich chocolate cream",
    image: "images/chocolate.jpg",
    keywords: "chocolate",
    category: "chocolate"
  },
  {
    title: "Berry Éclair",
    description: "Raspberry, blueberry, and whipped cream",
    image: "images/berries.jpg",
    keywords: "berry raspberry blueberry fruit",
    category: "fruit"
  },
  {
    title: "Salted Caramel Éclair",
    description: "Caramel cream with sea salt",
    image: "images/salt_caramel.jpg",
    keywords: "caramel salted",
    category: "classic"
  },
  {
    title: "Pistachio Éclair",
    description: "Pistachio cream and nutty notes",
    image: "images/phistachew.jpg",
    keywords: "pistachio nut",
    category: "nutty"
  }
];

function renderServices(container, servicesList) {
  container.innerHTML = "";
  servicesList.forEach(service => {
    container.innerHTML += `
      <div class="col-12 col-md-4">
        <div class="card h-100 text-center border-0">
          <img src="${service.image}" class="card-img-top" alt="${service.title}">
          <div class="card-body">
            <h5 class="card-title">${service.title}</h5>
            <p class="card-text">${service.description}</p>
          </div>
        </div>
      </div>
    `;
  });
}

export function initServiceFiltering() {
  const container = document.getElementById("services-container");
  const search = document.getElementById("service-search");
  const categorySelect = document.getElementById("category-filter");

  function filterServices() {
    const term = search ? search.value.toLowerCase() : "";
    const selectedCategory = categorySelect ? categorySelect.value : "all";

    const filtered = services.filter(service => {
      const matchesCategory = selectedCategory === "all" || service.category === selectedCategory;
      const matchesSearch =
        service.title.toLowerCase().includes(term) ||
        service.description.toLowerCase().includes(term) ||
        service.keywords.toLowerCase().includes(term);

      return matchesCategory && matchesSearch;
    });

    renderServices(container, filtered);
  }

  if (search) search.addEventListener("input", filterServices);
  if (categorySelect) categorySelect.addEventListener("change", filterServices);

  if (container) renderServices(container, services);
}
