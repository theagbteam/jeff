<style>

    /* Remove the browser's default select arrow */

    .registration-field[type="select"],
    select.registration-field {

        appearance: none;

        -webkit-appearance: none;

        -moz-appearance: none;

        background-image: none !important;

        padding-right: 42px !important;

    }

    /* Dropdown wrapper */

    .registration-role-wrapper {

        position: relative;

        width: 100%;

    }

    /* Keep only one white arrow */

    .registration-role-wrapper > i.mdi-chevron-down {

        position: absolute;

        right: 14px;

        top: 50%;

        transform: translateY(-50%);

        color: #ffffff !important;

        font-size: 20px;

        pointer-events: none;

        z-index: 2;

    }

</style>

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.register-user-btn').forEach(function (button) {

        button.addEventListener('click', function (e) {

            e.preventDefault();

            const selectedRole = this.getAttribute('data-role');

            Swal.fire({

                customClass: {

                    popup: 'registration-popup',

                    title: 'registration-title',

                    htmlContainer: 'registration-html'

                },

                background: '#191c24',

                color: '#ffffff',

                width: '460px',

                padding: '28px',

                showCloseButton: true,

                showCancelButton: true,

                confirmButtonText:

                    '<i class="mdi mdi-account-plus"></i> Submit',

                cancelButtonText:

                    'Cancel',

                focusConfirm: false,

                buttonsStyling: false,

                html: `

                    <form method="POST" id="registration-form">

                        <div class="registration-header-icon">

                            <i class="mdi mdi-account-plus"></i>

                        </div>

                        <div

                            style="

                                font-size:13px;

                                color:#8e929a;

                                margin-bottom:20px;

                            "

                        >

                            Create a new user account

                            <br>

                            <span class="registration-role-display">

                                ${

                                    selectedRole === '1'

                                        ? 'Supervisor'

                                        : 'Administrator'

                                }

                            </span>

                        </div>



                        <!-- TITLE -->

                        <div>

                            <label

                                class="registration-label"

                                for="swal-title"

                            >

                                Title

                            </label>

                            <div class="registration-role-wrapper">

                                <select

                                    id="swal-title"

                                    name="title"

                                    class="registration-field"

                                >

                                    <option value="">

                                        Select title

                                    </option>

                                    <option value="Mr.">

                                        Mr

                                    </option>

                                    <option value="Mrs.">

                                        Mrs

                                    </option>

                                    <option value="Miss">

                                        Miss

                                    </option>

                                    <option value="Ms.">

                                        Ms

                                    </option>

                                    <option value="Dr.">

                                        Dr

                                    </option>

                                    <option value="Prof.">

                                        Prof

                                    </option>

                                </select>

                                <i class="mdi mdi-chevron-down"></i>

                            </div>

                        </div>



                        <!-- NAME -->

                        <div>

                            <label

                                class="registration-label"

                                for="swal-name"

                            >

                                Name

                            </label>

                            <input

                                id="swal-name"

                                name="name"

                                class="registration-field"

                                type="text"

                                placeholder="Enter full name"

                                autocomplete="off"

                            >

                        </div>



                        <!-- EMAIL -->

                        <div>

                            <label

                                class="registration-label"

                                for="swal-email"

                            >

                                Email

                            </label>

                            <input

                                id="swal-email"

                                name="email"

                                class="registration-field"

                                type="email"

                                placeholder="Enter email address"

                                autocomplete="off"

                            >

                        </div>



                        <!-- PHONE -->

                        <div>

                            <label

                                class="registration-label"

                                for="swal-phone"

                            >

                                Phone

                            </label>

                            <input

                                id="swal-phone"

                                name="phone"

                                pattern="^\\+?[0-9]+$"

                                oninput="this.value = this.value.replace(/(?!^\\+)[^0-9]/g, '')"

                                class="registration-field"

                                type="tel"

                                placeholder="Enter phone number"

                                autocomplete="off"

                            >

                        </div>



                        <!-- USER ROLE -->

                        <div>

                            <label

                                class="registration-label"

                                for="swal-role"

                            >

                                User Role

                            </label>

                            <div class="registration-role-wrapper">

                                <select

                                    id="swal-role"

                                    name="role"

                                    class="registration-field"

                                >

                                    <option value="">

                                        Select user role

                                    </option>

                                    <option value="2">

                                        Administrator

                                    </option>

                                </select>

                                <i class="mdi mdi-chevron-down"></i>

                            </div>

                        </div>



                        <!-- HIDDEN SUBMIT -->

                        <button

                            type="submit"

                            name="dev_create_admin"

                            id="dev_create_admin"

                            style="display:none;"

                        >

                            Submit

                        </button>

                    </form>

                `,



                didOpen: () => {

                    const roleField =

                        document.getElementById('swal-role');

                    if (roleField && selectedRole) {

                        roleField.value = selectedRole;

                    }

                },



                preConfirm: () => {

                    const title =

                        document

                            .getElementById('swal-title')

                            .value

                            .trim();



                    const name =

                        document

                            .getElementById('swal-name')

                            .value

                            .trim();



                    const email =

                        document

                            .getElementById('swal-email')

                            .value

                            .trim();



                    const phone =

                        document

                            .getElementById('swal-phone')

                            .value

                            .trim();



                    const role =

                        document

                            .getElementById('swal-role')

                            .value

                            .trim();



                    /* TITLE VALIDATION */

                    if (!title) {

                        Swal.showValidationMessage(

                            'Please select a title'

                        );

                        return false;

                    }



                    /* NAME VALIDATION */

                    if (!name) {

                        Swal.showValidationMessage(

                            'Please enter the name'

                        );

                        return false;

                    }



                    /* EMAIL VALIDATION */

                    if (!email) {

                        Swal.showValidationMessage(

                            'Please enter the email address'

                        );

                        return false;

                    }



                    if (!/^[^\s@]+@[^\s@]+**\.**[^\s@]+$/.test(email)) {

                        Swal.showValidationMessage(

                            'Please enter a valid email address'

                        );

                        return false;

                    }



                    /* PHONE VALIDATION */

                    if (!phone) {

                        Swal.showValidationMessage(

                            'Please enter the phone number'

                        );

                        return false;

                    }



                    if (!/^**\+**?[0-9]+$/.test(phone)) {

                        Swal.showValidationMessage(

                            'Please enter a valid phone number'

                        );

                        return false;

                    }



                    /* ROLE VALIDATION */

                    if (!role) {

                        Swal.showValidationMessage(

                            'Please select a user role'

                        );

                        return false;

                    }



                    /* SUBMIT FORM */

                    document

                        .getElementById('dev_create_admin')

                        .click();

                    return false;

                }

            });

        });

    });

});

</script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const counters =

        document.querySelectorAll('.dashboard-counter');



    counters.forEach(function (counter) {

        const target =

            parseInt(

                counter.getAttribute('data-target'),

                10

            ) || 0;



        const duration = 1500;



        const startTime =

            performance.now();



        function updateCounter(currentTime) {

            const elapsed =

                currentTime - startTime;



            const progress =

                Math.min(

                    elapsed / duration,

                    1

                );



            const easedProgress =

                1 - Math.pow(

                    1 - progress,

                    3

                );



            const currentValue =

                Math.floor(

                    target * easedProgress

                );



            counter.textContent =

                currentValue.toLocaleString();



            if (progress < 1) {

                requestAnimationFrame(

                    updateCounter

                );

            } else {

                counter.textContent =

                    target.toLocaleString();

            }

        }



        requestAnimationFrame(

            updateCounter

        );

    });

});

</script>

<script src="views/assets/backend/vendors/js/vendor.bundle.base.js"></script>

<script src="views/assets/backend/vendors/chart.js/chart.umd.js"></script>

<script src="views/assets/backend/vendors/progressbar.js/progressbar.min.js"></script>

<script src="views/assets/backend/vendors/jvectormap/jquery-jvectormap.min.js"></script>

<script src="views/assets/backend/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<script src="views/assets/backend/vendors/owl-carousel-2/owl.carousel.min.js"></script>

<script

    src="views/assets/backend/js/jquery.cookie.js"

    type="text/javascript"

></script>

<script src="views/assets/backend/js/off-canvas.js"></script>

<script src="views/assets/backend/js/misc.js"></script>

<script src="views/assets/backend/js/settings.js"></script>

<script src="views/assets/backend/js/todolist.js"></script>

<script src="views/assets/backend/js/proBanner.js"></script>

<script src="views/assets/backend/js/dashboard.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>

$(document).ready(function () {

    $('#dashboardDataTable').DataTable({

        pageLength: <?= $page_name != "dashboard" ? 20 : 5 ?>,

        lengthMenu: [

            [5, 10, 20, 50, -1],

            [5, 10, 20, 50, "All"]

        ],

        ordering: true,

        searching: true,

        paging: true,

        info: true,

        autoWidth: false,

        responsive: false,



        columnDefs: [

            {

                targets: 0,

                searchable: false,

                orderable: false

            },

            {

                targets: 6,

                searchable: false,

                orderable: false

            }

        ],



        order: [

            [4, 'desc']

        ],



        language: {

            search: "Search:",

            lengthMenu:

                "Show _MENU_ entries",

            info:

                "Showing _START_ to _END_ of _TOTAL_ entries",

            infoEmpty:

                "Showing 0 to 0 of 0 entries",

            zeroRecords:

                "No matching records found",

            emptyTable:

                "No data available in table",

            paginate: {

                first: "First",

                last: "Last",

                next: "›",

                previous: "‹"

            }

        },



        drawCallback: function () {

            const api = this.api();



            api.column(0, {

                search: 'applied',

                order: 'applied'

            }).nodes().each(function (cell, i) {

                cell.innerHTML = i + 1;

            });

        }

    });

});

</script>

<script>

document.addEventListener('DOMContentLoaded', function() {



<?php if (isset($showAlert) && $showAlert): ?>



    Swal.fire({

        title: 'Successful!',

        text:

            '<?= htmlspecialchars(

                $msgtext,

                ENT_QUOTES,

                'UTF-8'

            ); ?>',

        icon: 'info',

        confirmButtonText: 'OK',

        allowOutsideClick: true,

        allowEscapeKey: true

    }).then((result) => {



        if (

            result.isConfirmed ||

            result.dismiss

        ) {

            window.location.href =

                '<?= htmlspecialchars(

                    $url,

                    ENT_QUOTES,

                    'UTF-8'

                ); ?>';

        }

    });



<?php elseif (isset($showAlert) && !$showAlert): ?>



    Swal.fire({

        title: 'Error',

        text:

            '<?= htmlspecialchars(

                $msgtext,

                ENT_QUOTES,

                'UTF-8'

            ); ?>',

        icon: 'error',

        confirmButtonText: 'OK',

        allowOutsideClick: true,

        allowEscapeKey: true

    }).then((result) => {



        if (

            result.isConfirmed ||

            result.dismiss

        ) {

            window.location.href =

                '<?= htmlspecialchars(

                    $url,

                    ENT_QUOTES,

                    'UTF-8'

                ); ?>';

        }

    });



<?php endif; ?>



});

</script>

<script>

window.addEventListener("load", function () {

    const loader = document.getElementById("pageLoader");

    if (loader) {

        loader.classList.add("hide");

        setTimeout(function () {

            loader.remove();

        }, 500);

    }

});

</script>
