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

        console.log(data)

        var canvas = document.getElementById(id);
        
        const dataSettings = canvas.dataset.settings

        if(dataSettings){
            
            const colors = ["rgb(34, 208, 164)", "rgb(36, 110, 211)", "rgb(34, 208, 164)", "rgb(255, 87, 51)", "rgb(255, 87, 51)"];
            let dataj = JSON.parse(data.toJSON());
            console.log(dataj.cols[0].label);
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
                var dataset = {
                    label: dataj.rows[i].c[0].v,
                    backgroundColor: colors[i],
                    borderColor: colors[i],
                    data: series_data
                }
            
                datasets.push(dataset);
            
            }
        
            const chartdata = {
            labels: labels,
            datasets: datasets
            };
            
            var setup = {
            type: "bar",
            data: chartdata,
            options: {
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: dataj.cols[0].label
                    }
                },
                responsive: true,
            }
            }
            chart = new Chart(canvas, setup);
        }
      }
}




jQuery(function ($) {
    $('.gev-charts').each(function(){
        loadChartJs($(this).attr('data-url'), $(this).attr('id'), $(this).attr('data-sheet'))
    });

    $('#gev-btn-filter').on('click', function(e){
        e.preventDefault();
        const countryId = $('#countryFilter').val()
        const sectorId = $('#sectorFilter').val()
        const subsectorId = $('#subsectorFilter').val()
        const mesId = $('#mesFilter').val()
        const anoId = $('#anoFilter').val()

        $.ajax({
            url: gev_vars.ajaxurl,
            type: 'post',
            data: {
                action: 'gev_ajax_filtercountry',
                countryId: countryId,
                sectorId: sectorId,
                subsectorId: subsectorId,
                mesId: mesId,
                anoId: anoId
            },
            beforeSend: function(){
                $('.gev-loader').addClass('active')
            },
            success: function(res){
                var $wrapper = $('.gev-row')
                $('.gev-loader').removeClass('active')
                
                if(res.length){
                    var itemsMarkup = searchResults(res);
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

    

    function searchResults(items){
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

        const preSettings = {
            "settings": {
                "colors": ["rgb(34, 208, 164)", "rgb(36, 110, 211)", "rgb(34, 208, 164)", "rgb(255, 87, 51)", "rgb(255, 87, 51)"],
                "type": "bar"
            }
        }

        items.forEach(item => {
            const countryNames = joinItemsTax(item.termCountry, ',')
            const sectorNames = joinItemsTax(item.termSector, ',')
            const subsectorNames = joinItemsTax(item.termSubsector, ',')

            const mesNames = joinItemsTax(item.termMes, ' - ')
            const mesAno = joinItemsTax(item.termAno, ' - ')

            markup += `
            <div class="gev-col" style="margin-top: 80px;">
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
                <div class="gev-chart-container">
                <canvas 
                    class="gev-charts" 
                    id="chart-${item.itemId}" 
                    data-url="${item.urlgs} "
                    data-sheet="${item.sheet}"
                    data-settings= "${preSettings}"
                ></canvas>
                </div>
            </div>
            `
        });

        return markup;
    }
	
});