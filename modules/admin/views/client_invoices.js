
$(document).ready(function() {

    $('#invoiceData').find('input, textarea, button, select').attr('disabled','disabled');

    var projectsTable = $('.invoices_table').DataTable({
        "ajax": {
            "url": "/ajax/getInvoicesList/",
            "dataSrc": "",
        },
    
        pageLength: 100,
            "paging":   true,
            "ordering": true,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'selected',
                className: ' btn btn-lg waves-effect',
                text: 'Generate XMLs',
                action: function ( e, dt, button, config ) {

                     // salvează textul original al butonului
                    var btnNode = dt.button(button).node();     // <- corect
                    var $btn = $(btnNode);
                    var originalText = $btn.text();

                    // afișează "Generating.." și dezactivează butonul
                    $btn.text('Generating..').prop('disabled', true).addClass('disabled');

                   // 1) Ia TOATE invoice_no din selecția curentă (fără projectsTable!)
                    var selectedData = dt.rows({ selected: true }).data().toArray();
                    var selectedItems = selectedData.map(function(row){ return row.invoice_number; });

                    // opțional: de-dup
                    selectedItems = Array.from(new Set(selectedItems));

                    if (!selectedItems.length) {
                      alert('Selectează cel puțin o factură.');
                      $btn.text(originalText).prop('disabled', false).removeClass('disabled');
                      return;
                    }

                    // 2) Construiește query-ul doar din ce ai deja
                    var params = selectedItems.map(function(id){
                      return "invoice[]=" + encodeURIComponent(id);
                    }).join("&");
                    // compui URL
                    var thisUrl = "/cron/verifySagaInvoiceDetails?type=4&code=&"+params;

                    // 2) Construiește query-ul doar din ce ai deja
                    var params = selectedItems.map(function(id){
                      return "invoice[]=" + encodeURIComponent(id);
                    }).join("&");
                                    // compui URL
                    var thisUrl = "/cron/verifySagaInvoiceDetails?type=4&code=&"+params;

                    fetch(thisUrl, { credentials: 'same-origin' })
                      .then(function(r){
                        if(!r.ok) throw new Error('Eroare ' + r.status);
                        return r.blob();
                      })
                      .then(function(blob){
                        // încearcă să detectezi numele din header (dacă îl pui în PHP)
                        var dispo = ''; 
                        var fname = 'F_IESIRI_' + new Date().toISOString().slice(0,19).replace(/[:T]/g,'-') + '.xml';

                        try {
                          // dacă folosești jQuery ajax, r.headers nu e accesibil ușor; pe fetch e ok:
                          // exemplu de extras numele din Content-Disposition
                          // (asigură-te că backend trimite: Content-Disposition: attachment; filename="file.xml")
                          // NOTĂ: aici e pseudo, pentru că r nu mai e accesibil. Dacă vrei nume exact, folosește fetch mai sus.
                        } catch(e) {}

                        var url = URL.createObjectURL(blob);
                        var a = document.createElement('a');
                        a.href = url;
                        a.download = fname; // va fi ignorat dacă serverul forțează alt nume prin header
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        URL.revokeObjectURL(url);
                      })
                      .catch(function(err){
                        $('.updateError').removeClass('hidden').text(err.message || 'Eroare la descărcare');
                      })
                      .finally(function(){
                        // readuce butonul la starea inițială
                        $btn.text(originalText).prop('disabled', false).removeClass('disabled');
                      });


                    // $.ajax({
                    //         url: thisUrl,
                    //         beforeSend: function() {
                    //             // Înainte de a face request-ul AJAX, afișăm preloader-ul și ascundem eventuala eroare
                    //             $('.verify_preloader').removeClass('hidden');
                    //         },
                    //     })





                   
                 }
            },
        ],
        columnDefs : [
            {
                orderable : false,
                className : 'select-checkbox',
                targets : 0
            },
        ],
         select: {
            style:    'multi',
            selector: 'td:first-child'
        },
        order: [1],
        "columns": [
            { 
                "data": null, 
                defaultContent: '' 
            }, 
            { 
                "data": "id",
                "render" : function(data, type, row) {
                    return '<a href="client-invoices/'+data+'" target="_blank">'+data+'</a>'
                  } 
            },

            { 
                "data": "status" 
            },

            { 
                "data": "quote_id",
                "render" : function(data, type, row) {
                    return '<a href="/quote/'+data+'" target="_blank">'+data+'</a>'
                  } 
            },
            { 
                "data": "invoice_number"
            },
            { 
                "data": "name"
            },
            { 
                "data": "invoice_date"
            },
            { 
                "data": "invoice_due_date"
            },
            { 
                "data": "saga_code"
            },
            { 
                "data": "status_name"
            }
        ],
        "initComplete": function(settings, json) {
           var api = this.api();
        
            // Create a header row for the filters
            var filterRow = $('<tr class="filter-row"></tr>').appendTo($(api.table().header()));

            // For each column, add a select input to the filter row
            api.columns().every(function(index) {
                var column = this;

                //sarim peste coloana 0
                if (index === 0) {
                    $('<td></td>').appendTo(filterRow); // păstrăm gol pentru aliniere
                    return; // ieșim și mergem la următoarea coloană
                }


                var select = $('<select><option value="">' + $(column.header()).text() + '</option></select>')
                    .appendTo($('<td></td>').appendTo(filterRow))
                    .on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                column.data().unique().sort().each(function(d) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });


                // Pre-select "Invoiced" for the status column
                if (index === 2) { // Assuming the status column is the second column (index 1)
                    select.val('Invoiced').trigger('change');
                }
            });
        }

    });
    


    var packageId = $('.packageId').attr('data-package-id');

    console.log(packageId);

    var invoiceItem = $('.invoice_items_table').DataTable({
        "ajax": {
            "url": "/ajax/getPackageData/",
            "dataSrc": "",
            "type": 'POST',
            "data": {'package_id': packageId}
        },
    
        pageLength: 100,
            "paging":   true,
            "ordering": true,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        order: [],
        "columns": [ 
            { 
                "data": "no_crt",
            },
            { 
                "data": "product_id", 
            },
            { 
                "data": "product_name"
            },
            { 
                "data": "quantity"
            },
            { 
                "data": "unit_price_with_exchange_rate"
            },
            { 
                "data": "green_tax"
            },
            { 
                "data": "total_novat_line_price"
            },
            { 
                "data": "total_line_vat"
            },
            { 
                "data": "total_line_price"
            }
        ],
        "initComplete": function(settings, json) {
        },
        "footerCallback": function (row, data, start, end, display) {
          var api = this.api();

          // helper: transformă orice intrare în număr (gestionează NULL, "", spații, semne, mii)
          const toNumber = (v) => {
            if (v === null || v === undefined) return 0;
            if (typeof v === "number") return v;
            let s = String(v).trim();
            if (s === "") return 0;
            // scoate spațiile și separatori de mii
            s = s.replace(/\s+/g, "").replace(/,/g, "");
            // acum ar trebui să fie ceva gen -15037.42
            const n = Number(s);
            return isNaN(n) ? 0 : n;
          };

          const sumCol = (idx) =>
            api.column(idx, { page: "current" }).data().reduce((a, b) => {
              return toNumber(a) + toNumber(b);
            }, 0);

          const fmt = (n) => toNumber(n).toFixed(2);

          // indexarea ta de coloane:
          // 0 no_crt | 1 product_id | 2 product_name | 3 quantity | 4 unit_price_with_exchange_rate
          // 5 green_tax | 6 total_novat_line_price | 7 total_line_vat | 8 total_line_price

          const totalQuantity       = sumCol(3);
          const totalGreenTax       = sumCol(5);
          const totalNovatLinePrice = sumCol(6);
          const totalLineVat        = sumCol(7);
          const totalLinePrice      = sumCol(8);

          // afișează totalurile
          $(api.column(3).footer()).html(fmt(totalQuantity));

          // pentru Unit Price NU are sens să facem sumă — lasă gol/linie
          $(api.column(4).footer()).html("—"); // sau "" dacă preferi gol

          $(api.column(5).footer()).html(fmt(totalGreenTax));
          $(api.column(6).footer()).html(fmt(totalNovatLinePrice));
          $(api.column(7).footer()).html(fmt(totalLineVat));
          $(api.column(8).footer()).html(fmt(totalLinePrice));
        }

    });


});


