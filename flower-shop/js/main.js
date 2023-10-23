//current object formatter
const currencyFormater = new Intl.NumberFormat("de-AT", {
    style: "currency",
    currency: "EUR",
});

//select the products row and add items dynamically
let flowersRow = document.querySelector(".flowers");

for (let flower of flowers) {
    flowersRow.innerHTML += `
        <div class="card flower col my-4 myCard text-danger d-flex flex-column justify-content-between">
            <div>
                <img class="card-img-top mt-2 px-3" src="${flower.image}" alt="${flower.name}"/>
                <div class="card-body px-3 py-0">
                    <h5 class="card-title">${flower.name}</h5>
                </div>
            </div>
            <div>
                <p class="card-text h3 text-end">${currencyFormater.format(flower.price)}</p>
                <p class="card-text3 d-flex justify-content-end"><button class="btn btn-outline-danger w-75 flower-button"><i class="fs-4 bi bi-cart-plus"></i> Add to cart</button></p>
            </div>
        </div>
    `;
}

//product button selected
const addToCartBtn = document.querySelectorAll(".flower-button");

//add event to add to cart buttons
addToCartBtn.forEach((btn, i) => {
    btn.addEventListener("click", () => {
        addToCart(flowers[i]);
    });
});

//cart declared
const cart = [];

//adds product to cart
const addToCart = (flower) => {
    if (cart.find((val) => val.name == flower.name)) {
        // console.log(cart.find((val) => val.name == flower.name));
        flower.qtty++;
    } else {
        cart.push(flower);
    }
//   console.table(cart);
    createRows();
    cartTotal();
    itemsInCartTotal();
};

//updates the cart total amount
const cartTotal = () => {
    let total = 0;
    for (let item of cart) {
        total += item.price * item.qtty;
    }
    total = total + checkDiscount(total);
    document.getElementById("price").innerHTML = currencyFormater.format(total);
};

function checkDiscount(total) {
    let smallSum = document.getElementById("smallSum");
    let discount = document.getElementById("discount");
    let discountAmount = document.getElementById("discountAmount");

    if (total >= 20) {
        let dAmount = 0;
        smallSum.innerHTML = currencyFormater.format(total);
        if (total >= 100) {
            discount.innerHTML = "-10% Discount";
            dAmount = total * 0.1 * -1;   
        } else if (total >= 50) {
            discount.innerHTML = "-5% Discount";
            dAmount = total * 0.05 * -1;
        } else if (total >= 20) {
            discount.innerHTML = "-2% Discount";
            dAmount = total * 0.02 * -1;
        }
        discountAmount.innerHTML = currencyFormater.format(dAmount);
        return dAmount; 
    }
     else {
        smallSum.innerHTML = "";
        discount.innerHTML = "";
        discountAmount.innerHTML = "";
        return 0;
    }
}

const itemsInCartTotal = () => {
    let totalItems = 0;
    for (let item of cart) {
        totalItems += item.qtty;
    }
    document.getElementById("numberOfItemsInCart").innerHTML = totalItems;
    if (totalItems == 1) {
        document.getElementById("itemSingPlur").innerHTML = " item total - ";
    } else {
        document.getElementById("itemSingPlur").innerHTML = " items total - ";
    }
};

const createRows = () => {
    let result = "";
    for (let item of cart) {
        result += `
            <div class="row gx-0">
                <div class="col-6 col-sm-6 my-2 d-flex align-items-center justify-content-start ps-5">
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
    document.querySelector(".cart-items").innerHTML = result;

    const plusBtns = document.querySelectorAll(".plus" );
    const minusBtns = document.querySelectorAll(".minus");
    const deleteBtns = document .querySelectorAll(".del");

    plusBtns.forEach((btn, i) => {
        btn.addEventListener("click", () => {
            plusQtty(i);
        });
    });

    minusBtns.forEach((btn, i) => {
        btn.addEventListener("click", () => {
            minusQtty(i);
        });
    });
   
    deleteBtns.forEach((btn, i) => {
        btn.addEventListener("click", () => {
            deleteItem(i);
        });
    });
};

//increases item quantity
const plusQtty = (index) => {
    cart[index].qtty++;
    createRows();
    cartTotal();
    itemsInCartTotal();
};

//decreases item quantity
const minusQtty = (index) => {
    if (cart[index].qtty == 1) {
      cart.splice(index, 1);
    } else {
      cart[index].qtty--;
    }
    createRows();
    cartTotal();
    itemsInCartTotal();
};

//deletes item from cart
const deleteItem = (index) => {
    cart[index].qtty = 1;
    cart.splice(index, 1);
    createRows();
    cartTotal();
    itemsInCartTotal();
};