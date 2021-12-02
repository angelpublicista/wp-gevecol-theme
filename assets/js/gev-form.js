jQuery(function ($) {

	// Init items formacion
    $('.gev-form-cont').each(function(){
        var $items = $(this).find('.gev-form-cont__article')
        $items.slice(0, 4).show();
        $(this).find('.gev-form-cont__articles__showMore').on('click', function(e){
            e.preventDefault()
            var target = $(this).attr('data-items')
            $(`#${target} .gev-form-cont__article:hidden`).slice(0, 4).slideDown();

            if($(`#${target} .gev-form-cont__article:hidden`).length == 0) {
                $(this).find('.gev-form-cont__articles__showMore__text').text('Ver menos')
                $(this).find('i').css('transform', 'rotate(180deg)')
            } else {
                $(this).find('.gev-form-cont__articles__showMore__text').text('Ver más')
                $(this).find('i').css('transform', 'rotate(0deg)')
            }
        })
    })
});
