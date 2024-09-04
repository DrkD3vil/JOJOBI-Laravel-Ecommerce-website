document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('search-form');
    const sliderRange = document.getElementById('slider-range');
    const amount = document.getElementById('amount');

    // Initialize the price range slider
    $(sliderRange).slider({
        range: true,
        min: 0,
        max: 1000, // Adjust this value based on your maximum price in the database
        values: [0, 1000], // Initial values
        slide: function(event, ui) {
            $(amount).val("$" + ui.values[0] + " - $" + ui.values[1]);
        },
        stop: function(event, ui) {
            fetchFilteredProducts(ui.values[0], ui.values[1]);
        }
    });

    $(amount).val("$" + $(sliderRange).slider("values", 0) +
        " - $" + $(sliderRange).slider("values", 1));

    // Function to fetch products based on price range
    function fetchFilteredProducts(minPrice, maxPrice) {
        const formData = new FormData(searchForm);
        formData.append('min_price', minPrice);
        formData.append('max_price', maxPrice);
        const queryString = new URLSearchParams(formData).toString();

        fetch(`/?${queryString}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                document.getElementById('products-container').innerHTML = data.html;
            } else {
                document.getElementById('products-container').innerHTML = '<p>No products found.</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('products-container').innerHTML = '<p>An error occurred. Please try again later.</p>';
        });
    }
});
