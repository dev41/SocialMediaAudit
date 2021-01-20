/**
Template Name: Ubold Dashboard
Author: CoderThemes
Email: coderthemes@gmail.com
File: Chartjs
*/


!function($) {
    "use strict";

    var ChartJs = function() {};

    ChartJs.prototype.respChart = function respChart(selector,type,data, chart, options) {
        // get selector by context
        var ctx = selector.get(0);
        if (ctx === undefined) return false;
        ctx = ctx.getContext("2d");
        // pointing parent container to make chart js inherit its width
        var container = $(selector).parent();

        // enable resizing matter
        $(window).resize( generateChart);

        // this function produce the responsive Chart JS
        function generateChart(){
            // make chart width fit with its container
            var ww = selector.attr('width', $(container).width() );
            if (Chart.instances['chart-'+chart] !== undefined) Chart.instances['chart-'+chart].destroy();
            switch(type){
                case 'Line':
                    return new Chart(ctx).Line(data, options);
                    break;
                case 'Doughnut':
                    return new Chart(ctx).Doughnut(data, options);
                    break;
                case 'Pie':
                    return new Chart(ctx).Pie(data, options);
                    break;
                case 'Bar':
                    return new Chart(ctx).Bar(data, options);
                    break;
                case 'Radar':
                    return new Chart(ctx).Radar(data, options);
                    break;
                case 'PolarArea':
                    return new Chart(ctx).PolarArea(data, options);
                    break;
            }
            // Initiate new chart or Redraw

        };
        // run function - render chart at first load
        generateChart();
    },
    //init
    ChartJs.prototype.init = function() {
        //creating lineChart

        //radar chart
        var RadarChart = {
            labels : ["Performance","SEO","UI/Mobile","Security","Social"],
            datasets : [
                {
                    fillColor : "rgba(93, 156, 236, 0.5)",
                    strokeColor : "rgba(93, 156, 236, 0.5)",
                    pointColor : "rgba(93, 156, 236, 1)",
                    pointStrokeColor : "#fff",
                    data : [0,0,0,0,0]
                },
                {
                    fillColor : "rgba(54, 64, 74, 0.5)",
                    strokeColor : "rgba(54, 64, 74, 0.8)",
                    pointColor : "rgba(54, 64, 74, 1)",
                    pointStrokeColor : "#fff",
                    data : [0,0,0,0,0]
                }
            ]
        }
        this.respChart($("#radar"),'Radar',RadarChart);

    },
    $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs

}(window.jQuery),

//initializing 
function($) {
    "use strict";
    //$.ChartJs.init()
}(window.jQuery);

