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
function moveAway(movingDiv) {
    const rect = movingDiv.getBoundingClientRect();
    const centerX = rect.left + rect.width / 2;
    const centerY = rect.top + rect.height / 2;
    // Define the maximum distance you want the div to move away
    const maxDistance = 100; // Adjust this value as needed
    // Get the current mouse position
    const updatePosition = (event) => {
        const mouseX = event.clientX;
        const mouseY = event.clientY;
        const deltaX = mouseX - centerX;
        const deltaY = mouseY - centerY;
        // Calculate the angle in radians
        const angle = Math.atan2(deltaY, deltaX);
        // Calculate the distance from the mouse pointer
        const distance = Math.sqrt(Math.pow(deltaX, 2) + Math.pow(deltaY, 2));
        if (distance < maxDistance) {
            // Calculate a new position
            const newX = centerX - maxDistance * Math.cos(angle);
            const newY = centerY - maxDistance * Math.sin(angle);
            // Apply CSS transformations to move the div
            movingDiv.style.transform = `translate(${newX - centerX}px, ${newY - centerY}px)`;
        }
    };
    // Attach the mousemove event listener to the entire document
    document.addEventListener('mousemove', updatePosition);
    movingDiv.addEventListener('mouseout', () => {
        // Reset the div's position when the mouse moves away
        movingDiv.style.transform = 'translate(0, 0)';
        // Remove the mousemove event listener to stop tracking the mouse
        document.removeEventListener('mousemove', updatePosition);
    });
}
