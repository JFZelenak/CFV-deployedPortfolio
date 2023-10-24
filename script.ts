tools.forEach((tool)=>{
    let toolsResult = document.getElementById("toolsResult") as HTMLElement;
    toolsResult.innerHTML += `
    <div class="row myTextRow">
            <div class="col-6">
                ${tool.name}
            </div>
        </div>

        <div class="row myPercentageRow">
            <div class="col-6">
                <div class="d-flex">
                    <div class="orange" style="width: ${tool.percentage}%;"> </div>
                    <div class="gray" style="width: ${tool.remainder}%;"> </div>
                </div>
            </div>
        </div>
    `
})