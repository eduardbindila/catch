$(document).ready(function() {
    var projectsTable = $('.projects_table').DataTable({
        "ajax": {
            "url": "/ajax/getSagaProcesses/",
            "dataSrc": ""
        },
        pageLength: 100,
        "paging": true,
        "ordering": false,
        "searching": true,
        rowId: 'category_slug',
        responsive: true,
        order: [1],
        rowGroup: {
            dataSrc: 'saga_process_id'
        },
        "columns": [ 
            { "data": "saga_process_id" },
            { "data": "process_status" },
            { "data": "process_start_time" },
            { "data": "request_type" },
            { 
                "data": "request",
                "render": function (data, type, row) {
                    // Return a button for viewing details
                    return '<button class="btn btn-link waves-effect view-details" data-toggle="modal" data-target="#request-modal">View Details</button>';
                },
                "className": "details-control",
                "orderable": false
            },
            { "data": "request_status" },
            { "data": "response_notification" },
            { "data": "response_error" }
        ],
        "initComplete": function(settings, json) {
           
        }
    });

    // Adaugă un eveniment pentru butonul view-details
    $('.projects_table tbody').on('click', 'button.view-details', function () {
        var data = projectsTable.row($(this).parents('tr')).data();
        var requestDetails = JSON.parse(htmlspecialchars_decode(data.request));
        var formattedDetails = JSON.stringify(requestDetails, null, 2);
        $('#request-modal-body').html('<pre>' + formattedDetails + '</pre>');
    });


    // Function to decode HTML entities
    function htmlspecialchars_decode(string) {
        var map = {
            '&amp;': '&',
            '&lt;': '<',
            '&gt;': '>',
            '&quot;': '"',
            '&#039;': "'"
        };
        return String(string).replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function (m) {
            return map[m];
        });
    }
});