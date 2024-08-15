<!-- JavaScript files-->
<script src="{{ asset('/adminfile/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/adminfile/vendor/popper.js/umd/popper.min.js') }}"> </script>
<script src="{{ asset('/adminfile/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/adminfile/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
<script src="{{ asset('/adminfile/vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('/adminfile/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/adminfile/js/charts-home.js') }}"></script>
<script src="{{ asset('/adminfile/js/front.js') }}"></script>

<!-- Flatpickr JS -->
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
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Sidebar navigation active state -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get current URL path
        var path = window.location.pathname;
        // Select all sidebar links
        var links = document.querySelectorAll('.sidebar-nav a');
        links.forEach(function (link) {
            // Normalize URL paths for comparison
            var linkPath = link.getAttribute('href').startsWith('http') ? new URL(link.getAttribute('href')).pathname : link.getAttribute('href');
            // Check if the href matches the current path
            if (path === linkPath) {
                link.closest('li').classList.add('active'); // Add 'active' class to the closest <li>
            } else {
                link.closest('li').classList.remove('active'); // Remove 'active' class if not matching
            }
        });
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

<!-- Category deletion confirmation -->
<script>
    // Delete Confirmation
    function confirmation(ev) {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');

        Swal.fire({
            title: 'Delete Category',
            text: 'Are you sure you want to delete this category?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // User clicked OK
                window.location.href = urlToRedirect;
            }
        });
    }
</script>
<!-- Notification Script -->
<script>

    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = <?php echo json_encode(session('success')); ?>;
        const errorMessage = <?php echo json_encode(session('error')); ?>;
        const errors = <?php echo json_encode(session($errors->all())); ?>;

        if (successMessage) {
            Swal.fire({
                toast: true,
                icon: 'success',
                title: successMessage,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        }

        if (errorMessage) {
            Swal.fire({
                toast: true,
                icon: 'error',
                title: errorMessage,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        }

        if (errors.length > 0) {
            Swal.fire({
                toast: true,
                icon: 'error',
                title: 'Validation Errors',
                position: 'top-end',
                html: `<ul>${errors.map(error => `<li>${error}</li>`).join('')}</ul>`,
                showConfirmButton: true,
                timerProgressBar: true,
            });
        }
    });
</script>