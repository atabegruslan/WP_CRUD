(function($) {

    $(document).ready(function(){

        // Carousel 
        $('.bxSlider').bxSlider({
            //mode: 'fade',
            captions: true,
            pager: false,
            minSlides: 3,
            maxSlides: 3,
            moveSlides: 3,
            slideWidth: 1000,
            slideMargin: 50
        });

        // Gallery
        var expandImg = $("img#expandedImg");
        var initImg = $('ul.bxslider').find('li:first-child').find('img').attr('src');
        expandImg.attr('src', initImg);

        // Persist search filter checkboxes' state
        var checkboxValues = JSON.parse(localStorage.getItem('checkboxValues')) || {};
        var checkboxes = $("#header_2 :checkbox");

        checkboxes.on("change", function() {
            checkboxes.each(function() {
                if ($('#' + this.id).length === 1)
                {
                    checkboxValues[this.id] = this.checked;
                }
            });

            localStorage.setItem("checkboxValues", JSON.stringify(checkboxValues));
        });

        var checkboxVals = Object.entries(checkboxValues);

        for (const [checkbox, isChecked] of checkboxVals)
        {
            if ($('#' + checkbox).length === 1)
            {
                $('#' + checkbox).prop("checked", isChecked);
            }
        }

        footerToBottom();

        // WISIWIG Editor Input
        $('textarea#contents').froalaEditor({
            fullPage: true
        });

        // Calendar DateTime Input
        // $('.datetimepicker').datetimepicker();

        // Multi-Selector Input
        // function templateResult (obj) 
        // {
        //     if (!obj.id) { return obj.text; }
        //     return obj.text;
        // };
        // $("select#test_category").select2({
        //     templateResult: templateResult
        // }).change( function(e){
        //     $(e.target).valid();
        // });
    });

})(jQuery);

// Always keep footer to the bottom
function footerToBottom()
{
    var correctFooterTop = ( jQuery(window).height() - jQuery('#footer').height() );

    if (jQuery("#footer").offset().top < correctFooterTop)
    {
        jQuery("#footer").offset({ top: correctFooterTop });
    }
}

// For gallery single view
function changeImg(img) {
    var expandImg = jQuery("#expandedImg");
    expandImg.attr('src', img.src);
}
