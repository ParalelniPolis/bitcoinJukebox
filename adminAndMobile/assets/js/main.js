$(function(){
    $("[rel='tooltip']").tooltip();

    $('.thumb').hover(
        function(){
            $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function(){
            $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
    );

    $(".file").fileinput({showUpload: false, showPreview: false, showUploadedThumbs: false});

    $('.genres .same-height').responsiveEqualHeightGrid();
    $('.songs .same-height').responsiveEqualHeightGrid();
});
