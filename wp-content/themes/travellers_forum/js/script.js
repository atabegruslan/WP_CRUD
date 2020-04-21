(function($) {

    $(document).ready(function(){

        // Note: Do NOT address the following 3 sliders as one by referring to them all as $('.bxSlider')
        // otherwise they will all take a long time to load
        // Address them seperately as below
        //$('#destination_sliders').hide();
        $('.bxSlider.destination').bxSlider({
            //mode: 'fade',
            captions: true,
            pager: false,
            minSlides: 3,
            maxSlides: 3,
            moveSlides: 3,
            slideWidth: 1000,
            slideMargin: 50,
            touchEnabled: false, // Mobile touch issue: https://github.com/stevenwanderski/bxslider-4/issues/1240 
            responsive: true,
            //imageWait : true,//wait while all images finished loading
            //preloadImages: 'all',//hide the slides until the page loads
            // https://stackoverflow.com/questions/23193973/bxslider-show-images-as-they-load
            // onSliderLoad: function() { // https://stackoverflow.com/questions/11658605/how-to-get-bxslider-to-hide-the-slides-until-the-page-loads
            //     $('#destination_sliders').show();
            // },
        });
        //$('#event_sliders').hide();
        $('.bxSlider.event').bxSlider({
            //mode: 'fade',
            captions: true,
            pager: false,
            minSlides: 3,
            maxSlides: 3,
            moveSlides: 3,
            slideWidth: 1000,
            slideMargin: 50,
            touchEnabled: false,
            responsive: true,
            //imageWait : true,
            //preloadImages: 'all',
            // onSliderLoad: function() {
            //     $('#event_sliders').show();
            // },
        });
        //$('#gallery_sliders').hide();
        $('.bxSlider.gallery').bxSlider({
            //mode: 'fade',
            captions: true,
            pager: false,
            minSlides: 3,
            maxSlides: 3,
            moveSlides: 3,
            slideWidth: 1000,
            slideMargin: 50,
            touchEnabled: false,
            responsive: true,
            //imageWait : true,
            //preloadImages: 'all',
            // onSliderLoad: function() {
            //     $('#gallery_sliders').show();
            // },
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

        // Gallery
        var expandImg = $("#expandedImg");

        $("img.gallery_slide").each(function() {
            var gallerySlide = new Hammer(this);

            gallerySlide.on("tap press", function(ev) {
                expandImg.attr('src', $(ev.target).attr("src"));
            });    
        });        

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
