$(document).ready(function () {
    $(".forecast-card").slice(0, 9).show();

    if ($(".forecast-card:hidden").length == 0) {
        $(".load-more").addClass("d-none");
    }

    $(".load-more").on("click", function (e) {
        e.preventDefault();
        if ($(".forecast-card:hidden").length != 0) {
            $(".forecast-card:hidden").slideDown();
        }
        if ($(".forecast-card:hidden").length == 0) {
            $(".load-more").addClass("d-none");
        }
    });

    $('.search-forecast').on('click.', function(){
        $(".forecast-content").addClass("d-none");
        console.log("forecast-content hidden");
    });
});

// Feather Icon
feather.replace({ fill: "none", width: 25, height: 25 });
