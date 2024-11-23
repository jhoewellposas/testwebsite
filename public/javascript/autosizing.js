document.addEventListener("DOMContentLoaded", function() {
    // Function to resize input fields based on content
    function autoSizeInput(input) {
        input.style.width = "auto"; // Reset width
        input.style.width = (input.scrollWidth + 2) + "px"; // Set to content width with slight padding
    }

    // Select only text inputs in the table
    const tableInputs = document.querySelectorAll(".table input[type='text']");
    
    // Initial size adjustment and event listener for each input
    tableInputs.forEach(input => {
        autoSizeInput(input); // Initial sizing based on content
        input.addEventListener("input", function() {
            autoSizeInput(input); // Resize on input
        });
    });
});