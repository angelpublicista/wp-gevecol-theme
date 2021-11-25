const loadChartJs = (urlGoogle, element, nameSheet) => {

    const url = urlGoogle
    const id = element

    google.charts.load('current', {
        'packages': ['corechart', 'bar']
      });
      google.charts.setOnLoadCallback(initChart);
    
      function initChart() {
        // Pruebas: https://docs.google.com/spreadsheets/d/1BQuJ6mRreTJ3eZ44n93N6DXULOh5r2isbMuTTM9fnrY/edit?usp=sharing
        // https://docs.google.com/spreadsheets/d/1YFu3mEJzUXsxWVFDTVK9RhZF91VlwzDB-3F4WzHITq4/edit?usp=sharing
        let URL = url;
        if(nameSheet){
            URL = URL + '&sheet=' + nameSheet
        }
        var query = new google.visualization.Query(URL);
        query.setQuery('select *');
        query.send(function(response) {
          handleQueryResponse(response);
        });
      }
    
      function handleQueryResponse(response) {
        var data = response.getDataTable();
        var columns = data.getNumberOfColumns();
        var rows = data.getNumberOfRows();

        
        var canvas = document.getElementById(id);
        
        // Obtain settings
        const dataSettingsJson = canvas.dataset.settings

        if(dataSettingsJson){
            // Json Parse data-settings
            const dataSettings = JSON.parse(dataSettingsJson)

            const colors = dataSettings.colors;
            let dataj = JSON.parse(data.toJSON());
            const labels = [];
            for (c = 1; c < dataj.cols.length; c++) {
            if (dataj.cols[c].label != "") {
                labels.push(dataj.cols[c].label);
            }
        
            }
            const datasets = [];
            for (i = 0; i < dataj.rows.length; i++) {
                const series_data = [];
                for (j = 1; j < dataj.rows[i].c.length; j++) {
                    if (dataj.rows[i].c[j] != null) {
                        if (dataj.rows[i].c[j].v != null) {
                            series_data.push(dataj.rows[i].c[j].v);
                        } else {
                            series_data.push(0);
                        }
                    }
            
                }

                if(dataSettings.type == 'doughnut' || dataSettings.type == 'pie'){
                    var dataset = {
                        label: dataj.rows[i].c[0].v,
                        backgroundColor: colors,
                        data: series_data
                    }
                } else {
                    var dataset = {
                        label: dataj.rows[i].c[0].v,
                        backgroundColor: colors[i],
                        borderColor: colors[i],
                        data: series_data
                    }
                }
            
                datasets.push(dataset);
            
            }
        
            const chartdata = {
            labels: labels,
            datasets: datasets
            };
            
            let setup

            const bgColor = {
                id: 'bgColor',
                beforeDraw: (chart, options) =>{
                    const { ctx, width, height} = chart;
                    ctx.fillStyle = 'white';
                    ctx.fillRect(0, 0, width, height)
                    ctx.restore()
                }
            }

            if(dataSettings.type == "bar-h"){
                setup = {
                    type: "bar",
                    data: chartdata,
                    options: {
                        indexAxis: 'y',
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: false,
                                text: dataj.cols[0].label
                            },
                            legend: {
                                position: 'right',
                            }
                        },
                        responsive: true,
                    }, 
                    plugins: [bgColor]
                }
            } else {
                setup = {
                    type: dataSettings.type,
                    data: chartdata,
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: false,
                                text: dataj.cols[0].label
                            }
                        },
                        responsive: true,
                    },
                    plugins: [bgColor]
                }
            }

            chart = new Chart(canvas, setup);
        }
      }
}


function downloadPDF(id, name, meta) {
    var canvas = document.getElementById(id);
      //creates image
      var canvasImg = canvas.toDataURL("image/jpeg", 1.0);
    
      //creates PDF from img
      var doc = new jsPDF('landscape');
      doc.setFontSize(20);
      
      doc.addImage(canvasImg, 'JPEG', 10, 30, 280, 160 );
      doc.text(15, 15, `${name}`);
      doc.setFontSize(10);
      doc.text(15, 20, `${meta}`);
      doc.save(`${name}.pdf`);
}




jQuery(function ($) {
    

    $('.gev-charts').each(function(){
        loadChartJs($(this).attr('data-url'), $(this).attr('id'), $(this).attr('data-sheet'))
    });

    function downloadGeneralReport() {
        $('.gev-general-report .gev-download-report').click(function(event) {
            event.preventDefault()
            // get size of report page
            var reportPageHeight = $('#gev-charts-section').innerHeight();
            var reportPageWidth = $('#gev-charts-section').innerWidth();

            
            
            // create a new canvas object that we will populate with all other canvas objects
            var pdfCanvas = $('<canvas />').attr({
              id: "canvaspdf",
              width: reportPageWidth,
              height: reportPageHeight
            });

            
            
            // keep track canvas position
            var pdfctx = $(pdfCanvas)[0].getContext('2d');
            var pdfctxX = 0;
            var pdfctxY = 0;
            var buffer = 100;

            
            
            // for each chart.js chart
            $("canvas").each(function(index) {
             
              // get the chart height/width
              var canvasHeight = $(this).innerHeight();
              var canvasWidth = $(this).innerWidth();
              
              // draw the chart into the new canvas
              pdfctx.drawImage($(this)[0], pdfctxX, pdfctxY, canvasWidth, canvasHeight);
              pdfctxX += canvasWidth + buffer;
              
              // our report page is in a grid pattern so replicate that in the new canvas
              if (index % 2 === 1) {
                pdfctxX = 0;
                pdfctxY += canvasHeight + buffer;
              }
            });
            
            // create new pdf and add our new canvas as an image
            var pdf = new jsPDF('l', 'pt', [reportPageWidth, reportPageHeight]);
            pdf.addImage($(pdfCanvas)[0], 'PNG', 0, 0);
            
            // download the pdf
            pdf.save('filename.pdf');
        });
    
    }

    function downloadSingleReport(){
        $('.gev-single-report').on('click', function(e) {
            e.preventDefault()
    
            var $report = $(this).attr('data-report')
            var $name = $(this).attr('data-name')
            var $meta = $(this).attr('data-meta')
            downloadPDF($report, $name, $meta)
        })
    }

    downloadSingleReport()
    downloadGeneralReport()
    // SELECT COUNTRY RESULT
    $('#countryFilter').on('change', function(){ 
        $.ajax({
            url: gev_vars.ajaxurl,
            type: 'post',
            data: {
                action: 'gev_ajax_filtercountry',
                countryId: $('#countryFilter').val(),
                sectorId: null,
                subsectorId: null
            },
            beforeSend: function(){
                $('.gev-loader').addClass('active')
            },
            success: function(res){
                var $wrapper = $('.gev-charts-section')
                $('.gev-loader').removeClass('active')
                
                if(res.response.length){
                    
                    const sectorSel = $('#sectorFilter')
                    
                    addOptions(res.term_list_sector, sectorSel, 'Sector')

                    if($('#countryFilter').val() !== null){
                        $('#sectorFilter').prop('disabled', false)
                        $('#sectorFilter').focus()
                    }
                    
                    var itemsMarkup = searchResults(res.response);
                    
                    $wrapper.html(itemsMarkup);
                    $('.gev-charts').each(function(){
                        loadChartJs($(this).attr('data-url'), $(this).attr('id'), $(this).attr('data-sheet'))
                    })

                    downloadSingleReport()
                    downloadGeneralReport()
                    

                } else {
                    $wrapper.html('<p class="gev-not-found">No se encontraron resultados para tu búsqueda. <br> Prueba con otros filtros</p>');
                }
            }
        })
    })

    // SELECT SECTOR RESULT
    $('#sectorFilter').on('change', function(){ 
        $.ajax({
            url: gev_vars.ajaxurl,
            type: 'post',
            data: {
                action: 'gev_ajax_filtercountry',
                countryId: $('#countryFilter').val(),
                sectorId: $('#sectorFilter').val(),
                subsectorId: null
            },
            beforeSend: function(){
                $('.gev-loader').addClass('active')
            },
            success: function(res){
                var $wrapper = $('.gev-charts-section')
                $('.gev-loader').removeClass('active')
                
                if(res.response.length){
                    
                    const subSectorSel = $('#subsectorFilter')
                    
                    addOptions(res.term_list_subsector, subSectorSel, 'Subsector')

                    if($('#countryFilter').val() !== null && $('#sectorFilter').val() !== null){
                        $('#subsectorFilter').prop('disabled', false)
                        $('#subsectorFilter').focus()
                    }
                    
                    var itemsMarkup = searchResults(res.response);
                    
                    $wrapper.html(itemsMarkup);
                    $('.gev-charts').each(function(){
                        loadChartJs($(this).attr('data-url'), $(this).attr('id'), $(this).attr('data-sheet'))
                    })

                } else {
                    $wrapper.html('<p class="gev-not-found">No se encontraron resultados para tu búsqueda. <br> Prueba con otros filtros</p>');
                }
            }
        })
    })

    // SELECT SUBSECTOR RESULT
    $('#subsectorFilter').on('change', function(){ 
        $.ajax({
            url: gev_vars.ajaxurl,
            type: 'post',
            data: {
                action: 'gev_ajax_filtercountry',
                countryId: $('#countryFilter').val(),
                sectorId: $('#sectorFilter').val(),
                subsectorId: $('#subsectorFilter').val()
            },
            beforeSend: function(){
                $('.gev-loader').addClass('active')
            },
            success: function(res){
                var $wrapper = $('.gev-charts-section')
                $('.gev-loader').removeClass('active')
                
                if(res.response.length){
                    
                    var itemsMarkup = searchResults(res.response);
                    
                    $wrapper.html(itemsMarkup);
                    $('.gev-charts').each(function(){
                        loadChartJs($(this).attr('data-url'), $(this).attr('id'), $(this).attr('data-sheet'))
                    })

                } else {
                    $wrapper.html('<p class="gev-not-found">No se encontraron resultados para tu búsqueda. <br> Prueba con otros filtros</p>');
                }
            }
        })
    })

    function addOptions(result, input, text){
        $(input).html(`<option selected disabled value="">${text}</option>`)
        $(result).each(function() {
            var $item = $(this)[0]

            var o = new Option($item.name, $item.term_id);
            /// jquerify the DOM object 'o' so we can use the html method
            $(o).html($item.name);
            $(input).append(o);
        })
    }
    

    function searchResults(items){

        // Arrays to string by separator
        function joinItemsTax(term, separator){
            const itemTax = term
            const itemTaxName = []
    
            for(let item of itemTax){
                itemTaxName.push(item.name)
            }
            
            const joinItemsName = itemTaxName.join(separator)
    
            return joinItemsName
        }
        var markup = '';

        markup += `<div class="gev-general-report">
            <a href="#" class="gev-download-report">
                <span class="gev-download-report__text">Descargar informe completo</span>
                <i class="fas fa-arrow-down"></i>
            </a>
        </div>`;

        items.forEach(item => {
            // Settings to JSON
            const settingsData = JSON.stringify(item.settings)

            // Names of taxonomies
            const countryNames = joinItemsTax(item.termCountry, ',')
            const sectorNames = joinItemsTax(item.termSector, ',')
            const subsectorNames = joinItemsTax(item.termSubsector, ',')

            const mesNames = joinItemsTax(item.termMes, ' - ')
            const mesAno = joinItemsTax(item.termAno, ' - ')

            markup += `
            <div class="gev-col" style="margin-top: 80px;">
                <div class="gev-row gev-meta-chart">
                    <div class="gev-col">
                        <div class="gev-tax-filters">
                            <span class="gev-tax-name">${countryNames}</span>
                            <span class="gev-tax-separator">/</span>
                            <span class="gev-tax-name">${sectorNames}</span>
                            <span class="gev-tax-separator">/</span>
                            <span class="gev-tax-name">${subsectorNames}</span>
                        </div>

                        <div class="gev-tax-date">
                            <span class="gev-tax-name">${mesNames}</span>
                            <span class="gev-tax-separator">/</span>
                            <span class="gev-tax-name">${mesAno}</span>
                        </div>

                        <h4 class="gev-chart-title">${item.title}</h4>
                    </div>

                    <div class="gev-col">
                        <a href="#" 
                            class="gev-download-report gev-single-report"
                            data-report="chart-${item.itemId}"
                            data-name="${item.title}"
                            data-meta="${countryNames} / ${sectorNames} / ${subsectorNames}"
                            >
                            <span class="gev-download-report__text">Descargar gráfica</span>
                            <i class="fas fa-arrow-down"></i>
                        </a>
                    </div>
                </div>
                
                <div class="gev-chart-container">
                    <canvas 
                        class="gev-charts" 
                        id="chart-${item.itemId}" 
                        data-url="${item.urlgs} "
                        data-sheet="${item.sheet}"
                        data-settings= '${settingsData}'
                    ></canvas>
                </div>
                <hr style="margin: 30px 0">
            </div>
            `
        });

        return markup;
    }
	
});