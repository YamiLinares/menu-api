const categories = [
    ['todos', 'Toda la carta'], ['entradas', 'Entradas'], ['platos-fuertes', 'Platos fuertes'],
    ['ensaladas', 'Ensaladas'], ['postres', 'Postres'], ['bebidas', 'Bebidas'],
];
const filters = document.querySelector('#filters');
const grid = document.querySelector('#menu-grid');
const status = document.querySelector('#status');
const pagination = document.querySelector('#pagination');
let currentCategory = 'todos';
let currentPage = 1;

categories.forEach(([value, label]) => {
    const button = document.createElement('button');
    button.className = `filter${value === currentCategory ? ' active' : ''}`;
    button.textContent = label;
    button.type = 'button';
    button.addEventListener('click', () => {
        currentCategory = value;
        currentPage = 1;
        filters.querySelectorAll('button').forEach((filter) => filter.classList.toggle('active', filter === button));
        loadMenu();
    });
    filters.append(button);
});

async function loadMenu() {
    status.textContent = 'Cargando carta…';
    grid.replaceChildren();
    pagination.replaceChildren();
    const url = currentCategory === 'todos'
        ? `/api/menu-items?per_page=8&page=${currentPage}`
        : `/api/menu-items/category/${encodeURIComponent(currentCategory)}?page=${currentPage}`;

    try {
        const response = await fetch(url, { headers: { Accept: 'application/json' } });
        if (!response.ok) throw new Error('No fue posible cargar el menú.');
        const result = await response.json();
        const items = result.data;
        status.textContent = items.length ? `${result.meta.total} propuestas en nuestra carta` : 'No hay platillos en esta categoría.';
        items.forEach((item) => {
            const article = document.createElement('article');
            article.className = 'dish';
            const heading = document.createElement('div');
            heading.className = 'dish-top';
            const name = document.createElement('h3');
            name.textContent = item.name;
            const price = document.createElement('span');
            price.className = 'price';
            price.textContent = `$${item.price}`;
            heading.append(name, price);
            const description = document.createElement('p');
            description.textContent = item.description;
            const availability = document.createElement('span');
            availability.className = `availability${item.is_available ? '' : ' off'}`;
            availability.textContent = item.is_available ? 'Disponible hoy' : 'Temporalmente no disponible';
            article.append(heading, description, availability);
            grid.append(article);
        });
        if (result.meta.last_page > 1) {
            const previous = document.createElement('button');
            previous.textContent = '← Anterior';
            previous.disabled = result.meta.current_page === 1;
            previous.addEventListener('click', () => { currentPage -= 1; loadMenu(); });
            const next = document.createElement('button');
            next.textContent = 'Siguiente →';
            next.disabled = result.meta.current_page === result.meta.last_page;
            next.addEventListener('click', () => { currentPage += 1; loadMenu(); });
            pagination.append(previous, document.createTextNode(` Página ${result.meta.current_page} de ${result.meta.last_page} `), next);
        }
    } catch {
        status.textContent = 'No pudimos conectar con el menú. Intenta nuevamente más tarde.';
    }
}

loadMenu();
