const resultDiv = document.getElementById("resultDiv");
let colorArray = []; // to save the importance colors
let importanceArray = []; // to save the importance values
let bookmarkedArray = []; // to save the bookmarked status
let importanceClass = "btn-success";
let bookmarkedClass = "bi bi-bookmark";

// parse the data from the JSON string
let obj1 = JSON.parse(tasks);

// create default arrays with correct length
for(let k = 0; k < obj1.length; k++){
    colorArray[k] = "btn-success";
    importanceArray[k] = 0;
    bookmarkedArray[k] = "bi bi-bookmark";
}

// create cards functin via loop through array length
function createCards() {
    for(let i = 0; i < obj1.length; i++) {
        resultDiv.innerHTML += `    
        <div class="card py-3 mx-2 myCard d-flex flex-column justify-content-between">
            <div>
                <div class="d-flex justify-content-between">
                    <div class="h6 rounded p-1 littleTaskText">Task</div>
                    <div class="d-flex justify-content-end">
                        <i class="${isBookmarked(i)} myBookmarkBtn"></i>
                        <i class="bi bi-three-dots-vertical ms-2 myThreeDots"></i>
                    </div>
                </div>
                <img src="${obj1[i].image}" class="img-thumbnail mb-2" alt="${obj1[i].taskName}">
                <p class="h5 card-title">${obj1[i].taskName}</p>
                <p class="h6 card-text">${obj1[i].description}</p>
            </div>
            <div>
                <hr>
                <p class="h6 card-text">
                    <i class="bi bi-exclamation-triangle-fill"></i> Importance level: <span class="btn ${checkImportance(i)} myImportanceBtn">${obj1[i].importance}</span>
                </p>
                <p class="h6 card-text">Deadline: ${obj1[i].deadline}</p>
                <hr>
                <div class="d-flex justify-content-end">
                    <span class="btn btn-danger myDeleteBtn ms-2"><i class="bi bi-trash"></i> Delete</span>
                    <span class="btn btn-success myDoneBtn ms-2"><i class="bi bi-check-circle"></i> Done</span>
                </div>
            </div>
        </div>
        `;
    }
}
// check importance & choose color accordingly
function checkImportance(i){
    if (obj1[i].importance === 2 || obj1[i].importance === 3) {
        colorArray[i] = "btn-warning";
        importanceClass = "btn-warning";
    } else if (obj1[i].importance >= 4) {
        colorArray[i] = "btn-danger";
        importanceClass = "btn-danger";
    }
    return importanceClass
}

// check if bookmarked or not
function isBookmarked(i) {
    if (obj1[i].isBookmarked == "bi bi-bookmark-fill") {
        bookmarkedArray[i] = "bi bi-bookmark-fill";
        bookmarkedClass = "bi bi-bookmark-fill";
    } else {
        bookmarkedArray[i] = "bi bi-bookmark";
        bookmarkedClass = "bi bi-bookmark";
    }
    return bookmarkedClass;
}

// call create cards function
createCards();

// sorting cards according to importance
const sortBtn = document.querySelector(".mySortingBtn");
sortBtn.addEventListener("click", function(){

    // save the arrays in the local storage
    localStorage.setItem('color', JSON.stringify(colorArray));
    localStorage.setItem('importance', JSON.stringify(importanceArray));
    localStorage.setItem('isBookmarked', JSON.stringify(bookmarkedArray));

    // go to second page
    window.location.href = './index_.html';
})

const cards = document.querySelectorAll(".myCard");
const texts1 = document.querySelectorAll(".card-title");
const importanceBtns = document.querySelectorAll(".myImportanceBtn");
const deleteBtns = document.querySelectorAll(".myDeleteBtn");
const doneBtns = document.querySelectorAll(".myDoneBtn");
const bookmarkBtns = document.querySelectorAll(".myBookmarkBtn");

// importance button
importanceBtns.forEach(function(btn, j){
    btn.addEventListener("click", function(){
        if (obj1[j].importance == 3) {
            btn.classList.remove("btn-warning");
            btn.classList.add("btn-danger");
            colorArray[j] = "btn-danger";
        } else if (obj1[j].importance == 1) {
            btn.classList.remove("btn-success");
            btn.classList.add("btn-warning");
            colorArray[j] = "btn-warning";
        } else if (obj1[j].importance == 0) {
            btn.classList.remove("btn-success");
            btn.classList.add("btn-success");
            colorArray[j] = "btn-success";
        }

        if(obj1[j].importance < 5){
            obj1[j].importance++;
            importanceArray[j] = obj1[j].importance;
            this.innerHTML = obj1[j].importance;
        } else {
            console.log(`${obj1[j].taskName} max. importance reached!`);
        }        
    })
})

// delete button
deleteBtns.forEach(function(btn, j){
    btn.addEventListener("click", function(){
        cards[j].style.opacity = "0";
        cards[j].style.transition = "700ms all linear";
        setTimeout(() => {cards[j].remove();}, 700);
    })
})

// done button
doneBtns.forEach(function(btn, j){
    btn.addEventListener("click", function(){
        if (cards[j].style.opacity == 0.5) {
            texts1[j].style.textDecoration = "none";
            cards[j].style.color = "black";
            cards[j].style.boxShadow = "0px 0px 8px rgba(102, 95, 87, 0.5)";
            cards[j].style.opacity = "1";
        } else {
            texts1[j].style.textDecoration = "line-through";
            cards[j].style.color = "grey";
            cards[j].style.boxShadow = "0px 0px 0px rgba(102, 95, 87, 0.5)";
            cards[j].style.opacity = "0.5";
        }
    })
})

// bookmark button
bookmarkBtns.forEach(function(btn, j){
    btn.addEventListener("click", function(){
        if (btn.classList.contains("bi-bookmark")) {
            btn.classList.remove("bi-bookmark");
            btn.classList.add("bi-bookmark-fill");
            bookmarkedArray[j] = "bi-bookmark-fill";
            btn.style.transform = "scaleY(3)";
            btn.style.transition = "0.5s all linear";
            btn.style.color = "#dc3545";
        } else {
            btn.classList.remove("bi-bookmark-fill");
            btn.classList.add("bi-bookmark");
            bookmarkedArray[j] = "bi-bookmark";
            btn.style.transform = "scaleY(1)";
            btn.style.transition = "0.5s all linear";
            btn.style.color = "black";
        }
    })
})

// year in copyright via Date object
const today = new Date();
document.getElementById("year").innerHTML = today.getFullYear();

// random alert counter 
let alertCount = 1;
let randomNr1 = 0;
let randomNr2 = 0;
document.getElementById("alertCount").innerHTML = alertCount;

for(let k = 1; k < 9; k++) {
    randomNr1 += randomNumber(5000,20000);
    setTimeout(() => {
        alertCount++;
        document.getElementById("alertCount").innerHTML = alertCount;
        document.getElementById("alertCount").style.transform = "rotateY(360deg)";
        document.getElementById("alertCount").style.transition = "0.5s all linear";
        setTimeout(() => {
            document.getElementById("alertCount").style.transform = "rotateY(0deg)";
            document.getElementById("alertCount").style.transition = "0.5s all linear";
        }, 500);
    }, randomNr1);
}

// random number generator
function randomNumber(min, max) {
    let randomNr = Math.floor(Math.random()*(max - min+1)+min);
    return randomNr;
}