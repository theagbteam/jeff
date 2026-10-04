
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