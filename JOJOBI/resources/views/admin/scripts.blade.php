<!-- JavaScript files-->
<script src="{{ asset('/adminfile/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/adminfile/vendor/popper.js/umd/popper.min.js') }}"> </script>
<script src="{{ asset('/adminfile/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/adminfile/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
<script src="{{ asset('/adminfile/vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('/adminfile/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/adminfile/js/charts-home.js') }}"></script>
<script src="{{ asset('/adminfile/js/front.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Alert display after 3 seconds -->
<script>
    // JavaScript to hide the alert after 3 seconds (3000 milliseconds)
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            var alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);
    });
</script>

<!-- Date picker -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Flatpickr for the date input
        flatpickr("#searchDate", {
            dateFormat: "Y-m-d", // Internal date format used in the request
            altInput: true, // Use an alternate input to display the selected date
            altFormat: "F d, Y", // Display format for the user
            enableTime: false, // Disable time selection
            clickOpens: true, // Allow the date picker to open on click
            allowInput: true // Allow typing in the input field
        });

        // Add event listener to open the date picker when clicking the calendar icon
        document.querySelector('.calendar-icon').addEventListener('click', function () {
            document.querySelector("#searchDate")._flatpickr.open(); // Open the date picker
        });
    });
</script>