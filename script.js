

/*const restaurants = [
    {
      name: "Nasi Kukus Meranti",
      location: "Arked Meranti",
      cuisine: "Malay",
      openHour: 8,
      closeHour: 17
    },
    {
      name: "RA Catering& Cafe",
      location: "Arked Angkasa",
      cuisine: "Western",
      openHour: 10,
      closeHour: 22
    },
    {
      name: "Uncle Janggut",
      location: "Arked Meranti",
      cuisine: "Malay",
      openHour: 9,
      closeHour: 15
    }
  ];
  
  function filterRestaurants() {
    const keyword = document.getElementById('searchInput').value.toLowerCase();
    const location = document.getElementById('locationFilter').value;
    const cuisine = document.getElementById('cuisineFilter').value;
    const now = new Date();
    const currentHour = now.getHours();
  
    const filtered = restaurants.filter(r => {
      const matchKeyword = r.name.toLowerCase().includes(keyword);
      const matchLocation = location === 'all' || r.location === location;
      const matchCuisine = cuisine === 'all' || r.cuisine === cuisine;
      const isOpen = currentHour >= r.openHour && currentHour < r.closeHour;
      return matchKeyword && matchLocation && matchCuisine && isOpen;
    });
  
    renderRestaurants(filtered);
  }
  
  function renderRestaurants(list) {
    const container = document.getElementById('restaurantList');
    container.innerHTML = '';
  
    if (list.length === 0) {
      container.innerHTML = '<p>No restaurants found.</p>';
      return;
    }
  
    list.forEach(r => {
      const card = document.createElement('div');
      card.className = 'premise-card';
      card.style = `
        background-color: #c8facc;
        padding: 20px;
        border-radius: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 10px rgba(0,0,0,0.1);
      `;
      card.innerHTML = `
        <h3>${r.name}</h3>
        <p><strong>Location:</strong> ${r.location}</p>
        <p><strong>Cuisine:</strong> ${r.cuisine}</p>
        <p><strong>Open Hours:</strong> ${r.openHour}:00 - ${r.closeHour}:00</p>
      `;
      container.appendChild(card);
      
    });
  }
  
  document.addEventListener('DOMContentLoaded', filterRestaurants);

  document.getElementById('searchInput').addEventListener('input', filterRestaurants);
document.getElementById('locationFilter').addEventListener('change', filterRestaurants);
document.getElementById('cuisineFilter').addEventListener('change', filterRestaurants);

 */
const restaurants = [
  { name: "Western Delight", location: "Arked Angkasa", cuisine: "Western", hours: "10:00 - 22:00" },
  { name: "Nasi Melayu Best", location: "Arked Meranti", cuisine: "Malay", hours: "09:00 - 20:00" },
  { name: "Mee Tarik KTF", location: "Arked Lestari", cuisine: "Chinese", hours: "10:00 - 22:00" },
  { name: "ABC & Cendol Madu", location: "Arked Lestari", cuisine: "Dessert", hours: "12:00 - 18:00" },
  // ... add more restaurants here
];

function filterRestaurants() {
  const searchInput = document.getElementById("searchInput").value.toLowerCase();
  const locationFilter = document.getElementById("locationFilter").value;
  const cuisineFilter = document.getElementById("cuisineFilter").value;

  const list = document.getElementById("restaurantList");
  list.innerHTML = "";

  const filtered = restaurants.filter(r => {
    const matchName = r.name.toLowerCase().includes(searchInput);
    const matchLocation = locationFilter === "all" || r.location === locationFilter;
    const matchCuisine = cuisineFilter === "all" || r.cuisine === cuisineFilter;
    return matchName && matchLocation && matchCuisine;
  });

  if (filtered.length === 0) {
    list.innerHTML = "<p>No matching restaurants found.</p>";
  } else {
    filtered.forEach(r => {
      list.innerHTML += `
        <div class="restaurant-card">
          <h3>${r.name}</h3>
          <p><strong>Location:</strong> ${r.location}</p>
          <p><strong>Cuisine:</strong> ${r.cuisine}</p>
          <p><strong>Open Hours:</strong> ${r.hours}</p>
        </div>
      `;
    });
  }
}
