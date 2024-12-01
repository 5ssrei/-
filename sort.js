document.addEventListener('DOMContentLoaded', () => {
    const sortingDropdown = document.getElementById('sorting'); // 獲取排序下拉選單
    const productContainer = document.querySelector('.row'); // 獲取產品列表父容器

    sortingDropdown.addEventListener('change', function () {
        const sortValue = this.value; // 獲取使用者選擇的排序方式
        const products = Array.from(productContainer.getElementsByClassName('col-4')); // 獲取所有產品卡片

        if (sortValue === 'price') {
            products.sort((a, b) => {
                const priceA = parseFloat(a.querySelector('p').textContent.replace('$', ''));
                const priceB = parseFloat(b.querySelector('p').textContent.replace('$', ''));
                return priceA - priceB; // 按價格升序排序
            });
        } else if (sortValue === 'rating') {
            products.sort((a, b) => {
                const ratingA = a.querySelectorAll('.fa-star, .fa-star-half-o').length;
                const ratingB = b.querySelectorAll('.fa-star, .fa-star-half-o').length;
                return ratingB - ratingA; // 按評分降序排序
            });
        }

        // 按新順序重新排列產品
        products.forEach(product => productContainer.appendChild(product));
    });
});
