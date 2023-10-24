"use strict";
tools.forEach((tool) => {
    let toolsResult = document.getElementById("toolsResult");
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
    `;
});
