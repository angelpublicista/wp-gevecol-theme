jQuery(function ($) {



	// Init items formacion
    $('.gev-form-cont').each(function(){
        $(this).find('.gev-form-cont__article').slice(0, 4).show()

        if($(this).find('.gev-form-cont__article').length > 4){
            $(this).find('.gev-form-cont__articles__showMore').show()
            $(this).find('.gev-form-cont__articles__showMore').css('display', 'block')
        }

        // Load more items
        $(this).find('.gev-form-cont__articles__showMore').on('click', function(e) {
            e.preventDefault()
            var $container = $(this).attr('data-items')
            if($("#" + $container).find(".gev-form-cont__article:hidden").length > 0){
                $("#" + $container).find(".gev-form-cont__article:hidden").slice(0, 4).slideDown('slow')

                if($("#" + $container).find(".gev-form-cont__article:hidden").length == 0){
                    $(this).find('.gev-form-cont__articles__showMore__text').text('Ver menos')
                    $(this).find('i').css('transform', 'rotate(180deg)')
                }
            } else {
                var $currItems = $("#" + $container).find(".gev-form-cont__article:visible").length
                var $slice = $currItems - 4
                if($currItems > 4){
                    $("#" + $container).find(".gev-form-cont__article").slice(-$slice).slideUp('slow')
                    $(this).find('.gev-form-cont__articles__showMore__text').text('Ver más')
                    $(this).find('i').css('transform', 'rotate(0deg)')
                }
            }
        })
    })

    // Modal video
    $('.gev-form-cont__video__cap').on('click', function(e) {
        e.preventDefault()
        var $title = $(this).attr('data-title')
        var $src = $(this).find('iframe').attr('src')

        if($title && $src){
            $('.gev-modal-video .gev-modal-video__wrapper').html(`
                <h4 class="gev-modal-video__title">${$title}</h4>
                <iframe width="1280" height="753" src="${$src}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            `)

            $('.gev-modal-video').fadeIn().css('display','flex')

            $('.gev-modal-video').click(function() {
                $('.gev-modal-video .gev-modal-video__wrapper iframe').attr('src', $src)
                $('.gev-modal-video').fadeOut();
                
            });
        
            $('.gev-modal-video__wrapper').click(function(event){
                event.stopPropagation();
            });

        }
    })

    
    
});
