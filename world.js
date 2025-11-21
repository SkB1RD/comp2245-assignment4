document.addEventListener("DOMContentLoaded", () => {
    const lookupBtn = document.getElementById("lookup");
    const resultDiv = document.getElementById("result");

    lookupBtn.addEventListener("click", () => {
        const countryInput = document.getElementById("country").value.trim();

        // Build the URL with the GET parameter
        const url = "world.php?country=" + encodeURIComponent(countryInput);

        // Fetch from world.php
        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;  // Print data into the result div
            })
            .catch(error => {
                resultDiv.innerHTML = "Error: " + error;
            });
    });
});
