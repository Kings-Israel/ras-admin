//Project:	Alpino - Responsive Bootstrap 4 Template
//Primary use:	Alpino - Responsive Bootstrap 4 Template
$(function() {
    "use strict";
	MorrisArea();
});

$(function () {
    $('.sparkline-pie').sparkline('html', {
        type: 'pie',
        offset: 90,
        width: '138px',
        height: '138px',
        sliceColors: ['#454c56', '#61ccb7', '#5589cd']
    })

    $("#sparkline14").sparkline([8,2,3,7,6,5,2,1,4,8], {
        type: 'line',
        width: '100%',
        height: '28',
        lineColor: '#3f7dc5',
        fillColor: 'transparent',
        spotColor: '#000',
        lineWidth: 1,
        spotRadius: 2,

    });
    $("#sparkline15").sparkline([2,3,9,1,2,5,4,7,8,2], {
        type: 'line',
        width: '100%',
        height: '28',
        lineColor: '#e66990',
        fillColor: 'transparent',
        spotColor: '#000',
        lineWidth: 1,
        spotRadius: 2,
    });

    $('.sparkbar').sparkline('html', {
        type: 'bar',
        height: '100',
        width: '100%',
        barSpacing: '20',
        barColor: '#e56590',
        negBarColor: '#4ac2ae',
        responsive: true,
    });
});

//======
$(window).on('scroll',function() {
    $('.card .sparkline').each(function() {
        var imagePos = $(this).offset().top;

        var topOfWindow = $(window).scrollTop();
        if (imagePos < topOfWindow + 400) {
            $(this).addClass("pullUp");
        }
    });
});

