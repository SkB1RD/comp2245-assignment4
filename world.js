document.addEventListener("DOMContentLoaded", () => {
    const resultDiv = document.getElementById("result");

    
    document.getElementById("lookup").addEventListener("click", () => {
        const countryInput = document.getElementById("country").value.trim();
        const url = "world.php?country=" + encodeURIComponent(countryInput);
        fetchData(url);
    });

    
    document.getElementById("lookupCities").addEventListener("click", () => {
        const countryInput = document.getElementById("country").value.trim();
        const url = "world.php?country=" + encodeURIComponent(countryInput) + "&lookup=cities";
        fetchData(url);
    });

    function fetchData(url) {
        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error("Network response was not OK");
                return response.text();
            })
            .then(data => {
                if (data.trim() === "") {
                    resultDiv.style.display = "none";
                } else {
                    resultDiv.innerHTML = data;
                    resultDiv.style.display = "block";
                }
            })
            .catch(error => {
                resultDiv.innerHTML = "Error: " + error.message;
                resultDiv.style.display = "block";
            });
    }
});
