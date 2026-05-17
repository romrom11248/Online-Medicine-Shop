document.addEventListener('DOMContentLoaded', () => {
    const searchBtn = document.getElementById('searchBtn');
    const searchQuery = document.getElementById('searchQuery');
    const searchVendor = document.getElementById('searchVendor');
    const categoryLinks = document.querySelectorAll('#categoryList a');
    const medicinesContainer = document.getElementById('medicinesContainer');

    let currentGenre = '';

    function fetchMedicines() {
        const q = searchQuery.value.trim();
        const vendor = searchVendor.value.trim();

        medicinesContainer.innerHTML = '<div class="text-center" style="grid-column: 1 / -1; padding: 2rem;">Loading...</div>';
        const url = `../controllers/searchController.php?q=${encodeURIComponent(q)}&vendor=${encodeURIComponent(vendor)}&genre=${encodeURIComponent(currentGenre)}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                medicinesContainer.innerHTML = '';

                if (data.length === 0) {
                    medicinesContainer.innerHTML = '<div class="text-center" style="grid-column: 1 / -1; padding: 2rem;">No medicines found.</div>';
                    return;
                }

                data.forEach(med => {
                    const isOutOfStock = parseInt(med.availability) <= 0;
                    const stockClass = isOutOfStock ? 'stock-out' : '';
                    const stockText = isOutOfStock ? 'Out of Stock' : `${med.availability} In Stock`;
                    const imagePath = med.image_path ? `../public/uploads/${med.image_path}` : 'https://placehold.co/400x200?text=Medicine';

                    const card = `
                        <div class="medicine-card">
                            <img src="${imagePath}" alt="${med.name}" class="medicine-img">
                            <div class="medicine-info">
                                <div class="medicine-name">${med.name}</div>
                                <div class="medicine-vendor">Vendor: ${med.vendor_name}</div>
                                ${med.category_name ? `<div class="medicine-vendor">Category: ${med.category_name}</div>` : ''}
                                <div class="medicine-footer">
                                    <div class="medicine-price">$${parseFloat(med.price).toFixed(2)}</div>
                                    <div class="medicine-stock ${stockClass}">${stockText}</div>
                                </div>
                            </div>
                        </div>
                    `;
                    medicinesContainer.insertAdjacentHTML('beforeend', card);
                });
            })
            .catch(err => {
                console.error(err);
                medicinesContainer.innerHTML = '<div class="text-center" style="grid-column: 1 / -1; padding: 2rem; color: var(--error);">Error loading medicines.</div>';
            });
    }

    searchBtn.addEventListener('click', fetchMedicines);


    searchQuery.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') fetchMedicines();
    });
    searchVendor.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') fetchMedicines();
    });

    categoryLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            categoryLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');

            const genre = link.getAttribute('data-name');
            currentGenre = genre || '';
            fetchMedicines();
        });
    });


    fetchMedicines();
});
