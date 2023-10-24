"use strict";
tools.forEach((tool) => {
    let toolsResult = document.getElementById("toolsResult");
    toolsResult.innerHTML += `
    <div class="myCard">
        <div class="row myTextRow">
                <div class="col-12 h4">
                    ${tool.name}
                </div>
            </div>

            <div class="row myPercentageRow">
                <div class="col-12">
                    <div class="d-flex">
                        <div class="orange" style="width: ${tool.percentage}%;"> </div>
                        <div class="gray" style="width: ${tool.remainder}%;"> </div>
                    </div>
                </div>
            </div>
        </div>
    `;
});
