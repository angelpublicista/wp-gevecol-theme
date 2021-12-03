jQuery(function ($) {

	// Init items formacion
    $('.gev-form-cont').each(function(){
        var $items = $(this).find('.gev-form-cont__article')
        $items.slice(0, 4).show();

        $(this).find('.gev-form-cont__articles__showMore').on('click', function(e){
            e.preventDefault()
            var target = $(this).attr('data-items')

            if($(`#${target} .gev-form-cont__article:hidden`).length > 0){
                $(`#${target} .gev-form-cont__article:hidden`).slice(0, 4).slideDown();

                $(this).find('.gev-form-cont__articles__showMore__text').text('Ver más')
                $(this).find('i').css('transform', 'rotate(0deg)')
            } else {
                var $currItems = $(`#${target} .gev-form-cont__article:visible`).length

                if($currItems > 4){
                    $(this).find('.gev-form-cont__articles__showMore__text').text('Ver menos')
                    $(this).find('i').css('transform', 'rotate(180deg)')
                    var $slice = $currItems - 4
                    $(`#${target} .gev-form-cont__article:visible`).slice(-$slice).slideUp();
                }
            }

            // if($(`#${target} .gev-form-cont__article:hidden`).length > 0) {
            //     $(`#${target} .gev-form-cont__article:hidden`).slice(0, 4).slideDown();
            //     $(this).find('.gev-form-cont__articles__showMore__text').text('Ver menos')
            //     $(this).find('i').css('transform', 'rotate(180deg)')
            // } else {
            //     var $currItems = $(`#${target} .gev-form-cont__article:visible`).length

            //     if($currItems > 4){
            //         var $slice = $currItems - 4
            //         $(`#${target} .gev-form-cont__article:visible`).slice(-$slice).slideUp();
            //     }

            //     $(this).find('.gev-form-cont__articles__showMore__text').text('Ver más')
            //     $(this).find('i').css('transform', 'rotate(0deg)')
            // }
        })
    })
});
