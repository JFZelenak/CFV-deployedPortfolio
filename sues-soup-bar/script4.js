"use strict";
allergens.forEach((allergen) => {
    let allergenList = document.querySelector(".allergens");
    allergenList.innerHTML += `
    <p class="list-group-item">${allergen}</p>
    `;
});
//current object formatter
const currencyFormater = new Intl.NumberFormat("de-AT", {
    style: "currency",
    currency: "EUR",
});
//select the products row and add items dynamically
let productsRow = document.querySelector(".products");
for (let product of soups) {
    productsRow.innerHTML += `
        <div class="card product col my-4 mx-2 myShadow" style="width: 300px;">
            <img class="card-img-top mt-2 px-3" src="${product.image}" alt="${product.name}">
            <div class="card-body px-3 py-0">
                <h5 class="card-title">${product.name}</h5>
                <p class="card-text h3 text-end">${currencyFormater.format(product.price)}</p>
                <p class="card-text3 d-flex justify-content-end"><button class="btn w-75 product-button btn-outline-dark"><i class="fs-4 bi bi-cart-plus"></i> Add to cart</button></p>
            </div>
        </div>
    `;
}
//product button selected
const addToCartBtn = document.querySelectorAll(".product-button");
//add event to add to cart buttons
addToCartBtn.forEach((btn, i) => {
    btn.addEventListener("click", () => {
        addToCart(soups[i]);
    });
});
//cart declared
const cart = [];
const addToCart = (product) => {
    if (cart.find((val) => val.name == product.name)) {
        // console.log(cart.find((val) => val.name == product.name));
        product.qtty++;
    }
    else {
        cart.push(product);
    }
    // console.table(cart);
    createRows();
    cartTotal();
};
const createRows = () => {
    let result = "";
    for (let item of cart) {
        result += `
            <div class="cart-row row gx-0">
                <div class="cart-item col-6 col-sm-6 my-2 d-flex align-items-center justify-content-center">
                        <img class="cart-item-image" src="${item.image}" height="100" alt="${item.name}">
                        <div class="cart-item-title h5 ms-2">${item.name}</div>
                    </div>
                    <div class="cart-qtty-action col-2 d-flex justify-content-center align-items-center">
                        <div class="d-flex">
                            <i class="minus fs-5 bi bi-dash-circle-fill"></i>
                        </div>
                        <div class="text-center m-0 cart-quantity h4 w-25">${item.qtty}</div>
                        <div class="d-flex">
                            <i class="plus fs-5 bi bi-plus-circle-fill"></i>
                        </div>
                    </div>
                    <div class="col-1 d-flex justify-content-start align-items-center">
                        <i class="del fs-4 bi bi-trash3-fill text-danger"></i>
                    </div>
                <div class="cart-price col-3 h5 my-auto text-end pe-5">${currencyFormater.format(item.price)}</div>
            </div>                    
        </div>
        `;
    }
    let cartItems = document.querySelector(".cart-items");
    cartItems.innerHTML = result;
    const plusBtns = document.querySelectorAll(".plus");
    plusBtns.forEach((btn, i) => {
        btn.addEventListener("click", () => {
            plusQtty(i);
        });
    });
    const minusBtns = document.querySelectorAll(".minus");
    minusBtns.forEach((btn, i) => {
        btn.addEventListener("click", () => {
            minusQtty(i);
        });
    });
    const deleteBtns = document.querySelectorAll(".del");
    deleteBtns.forEach((btn, i) => {
        btn.addEventListener("click", () => {
            deleteItem(i);
        });
    });
};
//updates the cart total amount
const cartTotal = () => {
    let total = 0;
    for (let item of cart) {
        total += item.price * item.qtty;
    }
    const totalNumber = document.getElementById("price");
    totalNumber.innerHTML = currencyFormater.format(total);
};
//increases item quantity
const plusQtty = (index) => {
    cart[index].qtty++;
    createRows();
    cartTotal();
};
//decreases item quantity
const minusQtty = (index) => {
    if (cart[index].qtty == 1) {
        cart.splice(index, 1);
    }
    else {
        cart[index].qtty--;
    }
    createRows();
    cartTotal();
};
//deletes item from cart
const deleteItem = (index) => {
    cart[index].qtty = 1;
    cart.splice(index, 1);
    createRows();
    cartTotal();
};
