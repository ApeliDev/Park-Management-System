<!-- loader.php -->
<div id="loader" class="loader-overlay">
    <div class="loader"></div>
</div>

<style>
    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .loader {
        border: 8px solid #f3f3f3; /* Light grey */
        border-top: 8px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
    // Function to show the loader
    function showLoader() {
        document.getElementById("loader").style.display = "flex";
    }

    // Function to hide the loader
    function hideLoader() {
        document.getElementById("loader").style.display = "none";
    }

    // Trigger loader when submit button is clicked
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        const submitButton = form.querySelector("button[type='submit']");
        
        submitButton.addEventListener("click", function(event) {
            showLoader(); 
            form.submit();
        });
    });
</script>
