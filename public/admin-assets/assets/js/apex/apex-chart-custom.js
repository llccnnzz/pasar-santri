(function($) {
    "use strict";

    // Sales Overview JS
    var options = {
        series: [{
            name: 'Sales',
            data: [50, 60, 70, 80, 90, 100, 100, 90, 80, 70, 60, 50]
        }, {
            name: 'Earnings',
            data: [60, 70, 80, 90, 100, 110, 110, 100, 90, 80, 70, 60]
        }, {
            name: 'Revenue',
            data: [70, 80, 90, 100, 110, 120, 120, 110, 100, 90, 80, 70,]
        }],
        chart: {
            type: 'bar',
            height: 445,
            height: 350,
        },
        plotOptions: {
            bar: {
            horizontal: false,
            columnWidth: '35%',
            endingShape: 'rounded',
            borderRadius: 2,
            },
        },
        grid: {
            borderColor: '#f1f2f7', 
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left', 
            fontWeight: 500,
            labels: {
                colors: ['#8c9097'],
            },
            markers: {
                radius: 2,
                offsetX: 0,
                offsetY: 1.5
            },
        },
        dataLabels: {
            enabled: false
        },
        colors: ['#5d87ff', '#28c76f', '#ee368c'],
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent'],
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "$ " + val + " thousands"
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                plotOptions: {
                    bar: {
                        columnWidth: '100%',
                    },
                },
            },
        }]
    };
    var chart = new ApexCharts(document.querySelector("#sales_overview"), options);
    chart.render();

    // Revenue Status JS
    var options = {
        series: [
            {
                name: 'Income $',
                data: [47, 45, 56, 82, 47, 62, 38, 75, 99, 74, 57, 87] 
            },
            {
                name: "Expenses",
                data: [10, 15, 8, 6, 20, 21, 26, 33, 24, 38, 52, 45]
            },
        ],
        chart: {
            height: 230,
            type: 'line',
            zoom: {
                enabled: false
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [5, 7, 5],
            curve: 'straight',
            dashArray: [0, 8, 5]
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left', 
            fontWeight: 500,
            labels: {
                colors: ['#8c9097'],
            },
            markers: {
                radius: 2,
                offsetX: 0,
                offsetY: 1.5,
            },
        },
        colors: ['#28c76f', '#5d87ff'],
        stroke: {
            curve: 'smooth',
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        tooltip: {
            y: [
                {
                    title: {
                        formatter: function (val) {
                            return val + " (mins)"
                        }
                    }
                },
                {
                    title: {
                        formatter: function (val) {
                            return val + " per session"
                        }
                    }
                },
                {
                    title: {
                        formatter: function (val) {
                            return val;
                        }
                    }
                }
            ]
        },
        grid: {
            borderColor: '#f1f2f7', 
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
        },
    };
    var chart = new ApexCharts(document.querySelector("#revenue_status"), options);
    chart.render();

    // Website Overview
    var options = {
        series: [
            {
                name: 'Bounce Rate 37.42%',
                data: [20, 95, 40, 80, 50, 80],
            }, {
                name: 'Page Per Visit 7.56',
                data: [80, 50, 30, 40, 95, 20],
            }, {
                name: 'Avg. Visit Duration 05:48',
                data: [20, 95, 40, 80, 50, 80],
            },
        ],
        chart: {
            height: 358,
            type: 'radar',
        },
        dataLabels: {
            enabled: true
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center', 
            fontWeight: 500,
            labels: {
                colors: ['#8c9097'],
            },
            itemMargin: {
                horizontal: 5,
                vertical: 5,
            },
            markers: {
                radius: 2,
            }
        },
        plotOptions: {
            radar: {
                size: 140,
                polygons: {
                    strokeColors: '#EFEFFE',
                    fill: {
                        colors: ['#f1f2f7', '#fff']
                    }
                }
            }
        },
        colors: ['#5d87ff'],
        tooltip: {
            y: {
                formatter: function(val) {
                    return val
                }
            }
        },
        xaxis: {
            categories: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            labels: {
                style: {
                    colors: ['#d14a43', '#fff243', '#d6569b', '#52ab62', '#e08b44', '#3eb4f0', '#80589e'],
                },
            }
        },
        yaxis: {
            tickAmount: 7,
            labels: {
                formatter: function(val, i) {
                    if (i % 2 === 0) {
                    return val
                    } else {
                        return ''
                    }
                }
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#website_overview"), options);
    chart.render();
   
    // Sessions Bounce
    var options = {
        series: [{
            name: 'Sessions',
            data: [30, 20, 30, 20, 40, 30, 40, 20, 30, 20, 30, 20,]
        }, {
            name: 'Bounce',
            data: [20, 10, 20, 10, 30, 20, 30, 20, 20, 10, 20, 10,]
        }],
        chart: {
            height: 400,
            type: 'area',
            toolbar: {
                show: true,
                tools: {
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false,
                },
            },
        },
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left', 
            fontWeight: 500,
            labels: {
                colors: ['#8c9097'],
            },
            markers: {
                radius: 2,
                offsetX: 0,
                offsetY: 1.5
            },
        },
        xaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        grid: {
            borderColor: '#f1f2f7', 
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
    };
    var chart = new ApexCharts(document.querySelector("#sessions_bounce"), options);
    chart.render();

    // Audience report Chart JS
    var options = {
        series: [
            {
                name: 'Total User',
                type: 'column',
                data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 45, 35]
            },
            {
                name: 'Bounce Rate',
                type: 'line',
                data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43, 27]
            },
            {
                name: 'Live Visitors',
                type: 'column',
                data: [40, 44, 44, 60, 26, 44, 80, 42, 84, 44, 90, 70]
            },
        ],
        chart: {
            toolbar: {
                show: true,
                tools: {
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false,
                },
            },
            type: 'line',
            height: 250,
        },
        grid: {
            borderColor: '#f1f2f7', 
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
        },
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [1, 1.1],
            curve: ['straight', 'smooth'],
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left', 
            fontWeight: 500,
            labels: {
                colors: ['#8c9097'],
            },
            markers: {
                radius: 2,
                offsetX: 0,
                offsetY: 1.5
            },
        },
        xaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        plotOptions: {
            bar: {
                columnWidth: "20%",
                borderRadius: 2
            }
        },
        colors: ["#5d87ff", '#ffc107', '#28c76f'],
    };
    var chart = new ApexCharts(document.querySelector("#audience_report"), options);
    chart.render();

    // Website Device
    var options = {
        series: [60.50, 15.50, 18.50, 5.50],
        labels: ["Mobile", "Tablet", "Desktop", "Others"],
        chart: {
            height: 400,
            type: 'donut',
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'round',
            colors: "#fff",
            width: 0,
            dashArray: 0,
        },
        plotOptions: {
            pie: {
                expandOnClick: false,
                donut: {
                    size: '80%',
                    background: 'transparent',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '20px',
                            color: '#495057',
                            offsetY: -4
                        },
                        value: {
                            show: true,
                            fontSize: '20px',
                            color: undefined,
                            offsetY: 8,
                            formatter: function (val) {
                                return val + "%"
                            }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            fontSize: '20px',
                            fontWeight: 700,
                            color: '#2A3547',
                        }

                    }
                }
            }
        },
        colors: ["#5d87ff", "#28c76f", "#ffc107", "#ee368c",],
        responsive: [{
            breakpoint: 1600,
            options: {
                chart: {
                    height: 300,
                },
            },
        }],
    };
    document.querySelector("#website_device").innerHTML = " ";
    var chart = new ApexCharts(document.querySelector("#website_device"), options);
    chart.render();

    /* Earnings Overview Chart */
    var options = {
        series: [{
            name: "Earnings",
            data: [120, 110, 100, 90, 80, 60, 70, 80, 90, 100, 110, 120]
        }, {
            name: "Students",
            data: [110, 100, 90, 80, 70, 50, 60, 70, 80, 90, 100, 110]
        }],
        chart: {
            height: 445,
            type: "bar",
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [1.1, 1.1],
            show: true,
            curve: ['smooth', 'smooth'],
        },
        grid: {
            borderColor: '#f1f2f7', 
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left', 
            fontWeight: 500,
            labels: {
                colors: ['#8c9097'],
            },
            markers: {
                radius: 2,
                offsetX: 0,
                offsetY: 1.5
            },
        },
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        markers: {
            size: 0
        },
        colors: ["#5d87ff", "#28c76f"],
        plotOptions: {
            bar: {
                columnWidth: "30%",
                borderRadius: 2,
            }
        },
    };
    document.getElementById('earnings_overview').innerHTML = ''
    var chart1 = new ApexCharts(document.querySelector("#earnings_overview"), options);
    chart1.render();

    /* Performance by category chart */
    var options = {
        series: [{
            name: 'Designing',
            data: [44, 55, 41, 67, 22, 43, 44, 55, 41, 67, 22, 43]
        }, {
            name: 'Development',
            data: [13, 23, 20, 8, 13, 27, 13, 23, 20, 8, 13, 27]
        }, {
            name: 'SEO',
            data: [11, 17, 15, 15, 21, 14, 11, 17, 15, 15, 21, 14]
        }],
        chart: {
            type: 'bar',
            height: 445,
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        grid: {
            borderColor: '#f1f2f7', 
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        colors: ["rgba(93, 135, 255, 1)", "rgba(93, 135, 255, 0.5)", "rgba(93, 135, 255, 0.2)"],
        legend: {
            position: 'top',
            horizontalAlign: 'left', 
            fontWeight: 500,
            labels: {
                colors: ['#8c9097'],
            },
            markers: {
                radius: 2,
                offsetX: 0,
                offsetY: 1.5
            },
        },
        plotOptions: {
            bar: {
                columnWidth: "20%",
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        fill: {
            opacity: 1
        }
    };
    document.getElementById('performance_category').innerHTML = '';
    var chart1 = new ApexCharts(document.querySelector("#performance_category"), options);
    chart1.render();

    /* Stepline chart */
    var options = {
        series: [{
            data: [34, 44, 54, 21, 12, 43, 33, 23, 66, 66, 58]
        }],
        chart: {
            type: 'line',
            height: 350
        },
        stroke: {
            curve: 'stepline',
        },
        dataLabels: {
            enabled: false
        },
        title: {
            text: 'Stepline Chart',
            align: 'left'
        },
        markers: {
            hover: {
                sizeOffset: 4
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#stepline"), options);
    chart.render();
   
    /* Stacked Columns chart */
    var options = {
        series: [{
            name: 'PRODUCT A',
            data: [44, 55, 41, 67, 22, 43]
            }, {
                name: 'PRODUCT B',
                data: [13, 23, 20, 8, 13, 27]
            }, {
                name: 'PRODUCT C',
                data: [11, 17, 15, 15, 21, 14]
            }, {
            name: 'PRODUCT D',
            data: [21, 7, 25, 13, 22, 8]
        }],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 10,
                dataLabels: {
                    total: {
                    enabled: true,
                        style: {
                            fontSize: '13px',
                            fontWeight: 900
                        }
                    }
                }
            },
        },
        xaxis: {
            type: 'datetime',
            categories: ['01/01/2011 GMT', '01/02/2011 GMT', '01/03/2011 GMT', '01/04/2011 GMT',
                '01/05/2011 GMT', '01/06/2011 GMT'
            ],
        },
        legend: {
            position: 'right',
            offsetY: 40
        },
        fill: {
            opacity: 1
        }
    };
    var chart = new ApexCharts(document.querySelector("#stacked_columns"), options);
    chart.render();

    /* Dumbbell Chart */
    var options = {
        series: [
            {
                data: [
                    {
                        x: '2008',
                        y: [2800, 4500]
                    },
                    {
                        x: '2009',
                        y: [3200, 4100]
                    },
                    {
                        x: '2010',
                        y: [2950, 7800]
                    },
                    {
                        x: '2011',
                        y: [3000, 4600]
                    },
                    {
                        x: '2012',
                        y: [3500, 4100]
                    },
                    {
                        x: '2013',
                        y: [4500, 6500]
                    },
                    {
                        x: '2014',
                        y: [4100, 5600]
                    }
                ]
            }
        ],
        chart: {
            height: 350,
            type: 'rangeBar',
            zoom: {
                enabled: false
            }
        },
        plotOptions: {
            bar: {
                isDumbbell: true,
                columnWidth: 3,
                dumbbellColors: [['#008FFB', '#00E396']]
            }
        },
        legend: {
            show: true,
            showForSingleSeries: true,
            position: 'top',
            horizontalAlign: 'left',
            customLegendItems: ['Product A', 'Product B']
        },
        fill: {
            type: 'gradient',
            gradient: {
                type: 'vertical',
                gradientToColors: ['#00E396'],
                inverseColors: true,
                stops: [0, 100]
            }
        },
        grid: {
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        xaxis: {
            tickPlacement: 'on'
        }
    };
    var chart = new ApexCharts(document.querySelector("#dumbbell_chart"), options);
    chart.render();

    /* Column With Markers */
    var options = {
        series: [
            {
                name: 'Actual',
                data: [
                    {
                        x: '2011',
                        y: 1292,
                        goals: [
                            {
                                name: 'Expected',
                                value: 1400,
                                strokeHeight: 5,
                                strokeColor: '#775DD0'
                            }
                        ]
                    },
                    {
                        x: '2012',
                        y: 4432,
                        goals: [
                            {
                                name: 'Expected',
                                value: 5400,
                                strokeHeight: 5,
                                strokeColor: '#775DD0'
                            }
                        ]
                    },
                    {
                        x: '2013',
                        y: 5423,
                        goals: [
                            {
                                name: 'Expected',
                                value: 5200,
                                strokeHeight: 5,
                                strokeColor: '#775DD0'
                            }
                        ]
                    },
                    {
                        x: '2014',
                        y: 6653,
                        goals: [
                            {
                                name: 'Expected',
                                value: 6500,
                                strokeHeight: 5,
                                strokeColor: '#775DD0'
                            }
                        ]
                    },
                    {
                        x: '2015',
                        y: 8133,
                        goals: [
                            {
                                name: 'Expected',
                                value: 6600,
                                strokeHeight: 13,
                                strokeWidth: 0,
                                strokeLineCap: 'round',
                                strokeColor: '#775DD0'
                            }
                        ]
                    },
                    {
                        x: '2016',
                        y: 7132,
                        goals: [
                            {
                                name: 'Expected',
                                value: 7500,
                                strokeHeight: 5,
                                strokeColor: '#775DD0'
                            }
                        ]
                    },
                    {
                        x: '2017',
                        y: 7332,
                        goals: [
                            {
                                name: 'Expected',
                                value: 8700,
                                strokeHeight: 5,
                                strokeColor: '#775DD0'
                            }
                        ]
                    },
                    {
                        x: '2018',
                        y: 6553,
                        goals: [
                            {
                                name: 'Expected',
                                value: 7300,
                                strokeHeight: 2,
                                strokeDashArray: 2,
                                strokeColor: '#775DD0'
                            }
                        ]
                    }
                ]   
            }
        ],
        chart: {
            height: 350,
            type: 'bar'
        },
        plotOptions: {
            bar: {
                columnWidth: '60%'
            }
        },
        colors: ['#00E396'],
        dataLabels: {
            enabled: false
        },
        legend: {
            show: true,
            showForSingleSeries: true,
            customLegendItems: ['Actual', 'Expected'],
            markers: {
                fillColors: ['#00E396', '#775DD0']
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#column_with_markers"), options);
    chart.render();

    /* Basic Bar Charts */
    var options = {
        series: [{
            data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan',
            'United States', 'China', 'Germany'
            ],
        }
    };
    var chart = new ApexCharts(document.querySelector("#basic_bar_charts"), options);
    chart.render();

    /* Grouped */
    var options = {
        series: [{
            data: [44, 55, 41, 64, 22, 43, 21]
            }, {
            data: [53, 32, 33, 52, 13, 44, 32]
        }],
        chart: {
            type: 'bar',
            height: 430
        },
        plotOptions: {
            bar: {
            horizontal: true,
                dataLabels: {
                    position: 'top',
                },
            }
        },
        dataLabels: {
            enabled: true,
            offsetX: -6,
            style: {
                fontSize: '12px',
                colors: ['#fff']
            }
        },
        stroke: {
            show: true,
            width: 1,
            colors: ['#fff']
        },
        tooltip: {
            shared: true,
            intersect: false
        },
        xaxis: {
            categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
        },
    };
    var chart = new ApexCharts(document.querySelector("#grouped"), options);
    chart.render();

    /* Line Column */
    var options = {
        series: [{
            name: 'Website Blog',
            type: 'column',
            data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
        }, {
            name: 'Social Media',
            type: 'line',
            data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
        }],
        chart: {
            height: 350,
            type: 'line',
        },
        stroke: {
            width: [0, 4]
        },
        title: {
            text: 'Traffic Sources'
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [1]
        },
        labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
        xaxis: {
            type: 'datetime'
        },
        yaxis: [{
            title: {
            text: 'Website Blog',
            },
        
        }, {
        opposite: true,
            title: {
            text: 'Social Media'
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#line_column"), options);
    chart.render();

    /* Column */
    var options = {
        series: [
            {
            type: 'rangeArea',
            name: 'Team B Range',
                data: [
                    {
                        x: 'Jan',
                        y: [1100, 1900]
                    },
                    {
                        x: 'Feb',
                        y: [1200, 1800]
                    },
                    {
                        x: 'Mar',
                        y: [900, 2900]
                    },
                    {
                        x: 'Apr',
                        y: [1400, 2700]
                    },
                    {
                        x: 'May',
                        y: [2600, 3900]
                    },
                    {
                        x: 'Jun',
                        y: [500, 1700]
                    },
                    {
                        x: 'Jul',
                        y: [1900, 2300]
                    },
                    {
                        x: 'Aug',
                        y: [1000, 1500]
                    }
                ]
            },
            {
            type: 'rangeArea',
            name: 'Team A Range',
                data: [
                    {
                        x: 'Jan',
                        y: [3100, 3400]
                    },
                    {
                        x: 'Feb',
                        y: [4200, 5200]
                    },
                    {
                        x: 'Mar',
                        y: [3900, 4900]
                    },
                    {
                        x: 'Apr',
                        y: [3400, 3900]
                    },
                    {
                        x: 'May',
                        y: [5100, 5900]
                    },
                    {
                        x: 'Jun',
                        y: [5400, 6700]
                    },
                    {
                        x: 'Jul',
                        y: [4300, 4600]
                    },
                    {
                        x: 'Aug',
                        y: [2100, 2900]
                    }
                ]
            },
            {
            type: 'line',
            name: 'Team B Median',
                data: [
                    {
                        x: 'Jan',
                        y: 1500
                    },
                    {
                        x: 'Feb',
                        y: 1700
                    },
                    {
                        x: 'Mar',
                        y: 1900
                    },
                    {
                        x: 'Apr',
                        y: 2200
                    },
                    {
                        x: 'May',
                        y: 3000
                    },
                    {
                        x: 'Jun',
                        y: 1000
                    },
                    {
                        x: 'Jul',
                        y: 2100
                    },
                    {
                        x: 'Aug',
                        y: 1200
                    },
                    {
                        x: 'Sep',
                        y: 1800
                    },
                    {
                        x: 'Oct',
                        y: 2000
                    }
                ]
            },
            {
            type: 'line',
            name: 'Team A Median',
                data: [
                    {
                        x: 'Jan',
                        y: 3300
                    },
                    {
                        x: 'Feb',
                        y: 4900
                    },
                    {
                        x: 'Mar',
                        y: 4300
                    },
                    {
                        x: 'Apr',
                        y: 3700
                    },
                    {
                        x: 'May',
                        y: 5500
                    },
                    {
                        x: 'Jun',
                        y: 5900
                    },
                    {
                        x: 'Jul',
                        y: 4500
                    },
                    {
                        x: 'Aug',
                        y: 2400
                    },
                    {
                        x: 'Sep',
                        y: 2100
                    },
                    {
                        x: 'Oct',
                        y: 1500
                    }
                ]
            }
        ],
        chart: {
            height: 350,
            type: 'rangeArea',
            animations: {
                speed: 500
            }
        },
        colors: ['#d4526e', '#33b2df', '#d4526e', '#33b2df'],
        dataLabels: {
            enabled: false
        },
        fill: {
            opacity: [0.24, 0.24, 1, 1]
        },
        forecastDataPoints: {
            count: 2
        },
        stroke: {
            curve: 'straight',
            width: [0, 0, 2, 2]
        },
        legend: {
            show: true,
            customLegendItems: ['Team B', 'Team A'],
            inverseOrder: true
        },
        title: {
            text: 'Range Area with Forecast Line (Combo)'
        },
        markers: {
            hover: {
            sizeOffset: 5
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#combo"), options);
    chart.render();
   
    /* Funnel */
    var options = {
        series: [
            {
                name: "Funnel Series",
                data: [1380, 1100, 990, 880, 740, 548, 330, 200],
            },
        ],
        chart: {
            type: 'bar',
            height: 350,
        },
        plotOptions: {
            bar: {
                borderRadius: 0,
                horizontal: true,
                barHeight: '80%',
                isFunnel: true,
            },
        },
        dataLabels: {
            enabled: true,
            formatter: function (val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex] + ':  ' + val
            },
            dropShadow: {
                enabled: true,
            },
        },
        title: {
            text: 'Recruitment Funnel',
            align: 'middle',
        },
        xaxis: {
            categories: [
            'Sourced',
            'Screened',
            'Assessed',
            'HR Interview',
            'Technical',
            'Verify',
            'Offered',
            'Hired',
            ],
        },
        legend: {
            show: false,
        },
    };
    var chart = new ApexCharts(document.querySelector("#funnel"), options);
    chart.render();

    /* Simple Pie */
    var options = {
		series: [44, 55, 13, 43, 22],
		chart: {
			width: 380,
			type: 'pie',
	  	},
	  	labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
		responsive: [{
			breakpoint: 480,
			options: {
				chart: {
					width: 200
				},
				legend: {
					position: 'bottom'
				}
			}
		}]
	};
	var chart = new ApexCharts(document.querySelector("#simple_pie"), options);
	chart.render();

}(jQuery));