/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - pie chart
 *
 *  Google Visualization pie chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GooglePieBasic = function() {


    //
    // Setup module components
    //

    // Pie chart
    var _googlePieBasic = function() {
        if (typeof google == 'undefined') {
            console.warn('Warning - Google Charts library is not loaded.');
            return;
        }

        // Initialize chart
        google.charts.load('current', {
            callback: function () {

                // Draw chart
                drawPie();

                // Resize on sidebar width change
                $(document).on('click', '.sidebar-control', drawPie);

                // Resize on window resize
                var resizePieBasic;
                $(window).on('resize', function() {
                    clearTimeout(resizePieBasic);
                    resizePieBasic = setTimeout(function () {
                        drawPie();
                    }, 200);
                });
            },
            packages: ['corechart']
        });

        // Chart settings    
        // function drawPie() {
        //
        //     // Define charts element
        //     var pie_chart_element = document.getElementById('google-pie');
        //
        //     // Data
        //     var data = google.visualization.arrayToDataTable([
        //         ['Task', 'Hours per Day'],
        //         ['Work',     11],
        //         ['Eat',      2],
        //         ['Commute',  2],
        //         ['Watch TV', 2],
        //         ['Sleep',    7]
        //     ]);
        //
        //     // Options
        //     var options_pie = {
        //         fontName: 'Roboto',
        //         height: 300,
        //         width: 500,
        //         chartArea: {
        //             left: 50,
        //             width: '90%',
        //             height: '90%'
        //         }
        //     };
        //
        //     // Instantiate and draw our chart, passing in some options.
        //     var pie = new google.visualization.PieChart(pie_chart_element);
        //     pie.draw(data, options_pie);
        // }


        // Chart settings
        function drawPie() {

            // Define charts element
            var pie_chart_element = document.getElementById('google-pie');


            if (pie_chart_element) {


                $.ajax({

                    url: '/booking_free_balance_chart',
                    type: 'get',
                    datatype: 'json',
                    success: function (b_data) {
                        if (b_data === 0){
                            var data = google.visualization.arrayToDataTable([
                                ['Is the counterparty a PEP?', 'Amount'],
                                // blank first column removes legend,
                                // use object notation for formatted value (f:)
                                ['', {v: 1, f: 'No Data'}]
                            ]);

                            var options = {
                                chartArea: {
                                    // bottom: 40,
                                    // left: 70,
                                    // right: 12,
                                    // top: 2,
                                    // height: '100%',
                                    // width: '100%'
                                },
                                pieHole: 0.5,
                                colors: ['transparent'],
                                pieSliceBorderColor: '#9e9e9e',
                                // show formatted value from the data
                                pieSliceText: 'value',
                                // default text style is white
                                // won't show in center unless change color
                                pieSliceTextStyle: {
                                    color: '#9e9e9e'
                                },
                                tooltip: {
                                    trigger: 'none'
                                }
                            };

                            var pie = new google.visualization.PieChart(pie_chart_element);

                            pie.draw(data, options);
                        }else{


                            // $.each(data.notifications, function (i, item) {
                            //     console.log(item);
                            // });
                            //
                            //
                            //
                            // Data
                            // var data = google.visualization.arrayToDataTable([
                            //     ['Task', 'Hours per Day'],
                            //     ['Work',     11],
                            //     ['Eat',      2],
                            //     ['Commute',  2],
                            //     ['Watch TV', 2],
                            //     ['Sleep',    7]
                            // ]);
                            var data_pie = google.visualization.arrayToDataTable(
                                b_data
                            );
                            // Options
                            var options_pie = {
                                fontName: 'Roboto',

                                pieSliceText: 'value',
                                colors:['#F3B61A','#056867'],
                                // tooltip: { trigger: 'none' },
                                chartArea: {
                                    // bottom: 40,
                                    // left: 70,
                                    // right: 12,
                                    // top: 2,
                                    // height: '100%',
                                    // width: '100%'
                                }
                            };

                            // Instantiate and draw our chart, passing in some options.
                            var pie = new google.visualization.PieChart(pie_chart_element);
                            pie.draw(data_pie, options_pie);



                        }
                    },
                    error: function (msg) {

                    }
                });


            }


        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googlePieBasic();
        }
    }
}();


// Initialize module
// ------------------------------

GooglePieBasic.init();
