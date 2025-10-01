function updateClock() {
    const now = new Date();
    const startDate = new Date('2024-04-02T00:00:00'); // Company registration date: April 2nd, 2024

    // Calculate the time difference
    const diff = now - startDate;

    // Calculate the number of years, months, days, hours, minutes, and seconds
    const years = Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25)); // Considering leap years
    const months = Math.floor((diff % (1000 * 60 * 60 * 24 * 365.25)) / (1000 * 60 * 60 * 24 * 30)); // Approximate months
    const days = Math.floor((diff % (1000 * 60 * 60 * 24 * 30)) / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

    // Conditionally display years if greater than or equal to 1
    let timeDisplay = '';
    if (years >= 1) {
        timeDisplay += `${years} `;
    }
    timeDisplay += `${months} ${days} ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

    // Display the elapsed time as just numbers (no labels)
    document.getElementById('clock').textContent = timeDisplay;
}

// Update clock every second
setInterval(updateClock, 1000);
updateClock();











// Get references to elements
const overlayButton = document.querySelector(".overlay-button");
const overlay = document.getElementById("overlay");
const closeOverlayButton = document.querySelector(".close-overlay");

// Show overlay when the button is clicked
overlayButton.addEventListener("click", () => {
    overlay.style.display = "flex";
});

// Hide overlay when the close button is clicked
closeOverlayButton.addEventListener("click", () => {
    overlay.style.display = "none";
});

// Optional: Hide overlay when clicking outside the content area
overlay.addEventListener("click", (e) => {
    if (e.target === overlay) {
        overlay.style.display = "none";
    }
});
