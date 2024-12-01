// Function to fetch product details and update the page

function setProductDetails(productId) {
    
    fetch('product-details.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP error! Status: ${response.status}');
            }
            return response.json(); // Parse JSON data
        })
        .then(products => {
            const product = products.find(p => p.id === productId);
            console.log(product);
            if (product) {
                // Update product details on the page
            
                document.getElementById('ProductImg').src = product.image;
                document.getElementById('productName').innerText = product.name;
                document.getElementById('productPrice').innerText = product.price;
                document.getElementById('productDescription').innerText = product.description;
            }
        })
        //.catch(error => console.error('Error loading product data:', error));
        

        

}


// Example usage: load product with id 1
//setProductDetails(2);
