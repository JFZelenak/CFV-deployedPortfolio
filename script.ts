// display tools data
tools.forEach((tool)=>{
    let toolsResult = document.getElementById("toolsResult") as HTMLElement;
    toolsResult.innerHTML += `
    <div class="myCard">
        <div class="row myTextRow">
                <div class="col-12 fs-6">
                    ${tool.name}
                </div>
            </div>

            <div class="row myPercentageRow">
                <div class="col-12">
                    <div class="d-flex">
                        <div class="color" style="width: ${tool.percentage}%;"> </div>
                        <div class="gray" style="width: ${tool.remainder}%;"> </div>
                    </div>
                </div>
            </div>
        </div>
    `
});

// animate hero image
const myHeroImage: HTMLElement | null = document.querySelector('#myHeroImage');

if (myHeroImage) {
  myHeroImage.addEventListener('mouseenter', () => {
    if (myHeroImage.style.animationName !== 'flying') {
      myHeroImage.style.animation = 'flying 3000ms ease-in-out';
    }
  });

  myHeroImage.addEventListener('animationend', () => {
    myHeroImage.style.animation = 'none';
  });
}