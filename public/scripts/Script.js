


$("#slider-range").slider({
range: true,
min: 0,
max: 1500,
values: [75, 300],
slide: function (event, ui) {
$("#amount").val( ui.values[0] +" DT "+ " - " + ui.values[1]+ " DT");
$("#price_range").val( ui.values[0] + " - " + ui.values[1]);
}
});
$("#amount").val( $("#slider-range").slider("values", 0) + " DT "+ 
" - " + $("#slider-range").slider("values", 1)) + " DT";
$("#price_range").val( $("#slider-range").slider("values", 0) + " - " + $("#slider-range").slider("values", 1));



$(document).ready(function(e) {
    $('.range_slider').on('change', function() {
        let left_value = $('#input_left').val();
        let right_value = $('#input_right').val();
        // alert(left_value+right_value);
        $.ajax({
            url: "{{ route('search.products') }}",
            method: "GET",
            data: {
                left_value: left_value,
                right_value: right_value
            },
            success: function(res) {
                $('.search-result').html(res);
            }
        });
    });

    $('#sort_by').on('change', function() {
        let sort_by = $('#sort_by').val();
        $.ajax({
            url: "{{ route('sort.by') }}",
            method: "GET",
            data: {
                sort_by: sort_by
            },
            success: function(res) {
                $('.search-result').html(res);
            }
        });
    });
})

$(document).ready(function() {
    /*----------------------------------------------------*/
    /*  Jquery Ui slider js
    /*----------------------------------------------------*/
    if ($("#slider-range").length > 0) {
        const max_value = parseInt($("#slider-range").data('max')) || 500;
        const min_value = parseInt($("#slider-range").data('min')) || 0;
        const currency = $("#slider-range").data('currency') || '';
        let price_range = min_value + '-' + max_value;
        if ($("#price_range").length > 0 && $("#price_range").val()) {
            price_range = $("#price_range").val().trim();
        }

        let prix = price_range.split('-');
        $("#slider-range").slider({
            range: true,
            min: min_value,
            max: max_value,
            values: prix,
            slide: function(event, ui) {
                $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
            }
        });
    }
    if ($("#amount").length > 0) {
        const m_currency = $("#slider-range").data('currency') || '';
        $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
            "  -  " + m_currency + $("#slider-range").slider("values", 1));
    }
})