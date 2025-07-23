(function($) {
	'use strict';

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
            height: 350,
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
            height: 358,
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

    // Job Summary
    var options = {
        series: [2568, 1954, 1548, 1254],
        labels: ["Published", "Private", "Closed", "On Hold"],
        chart: {
            height: 428,
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
                            label: 'Total Jobs',
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
            breakpoint: 950,
            options: {
                chart: {
                    height: 300,
                },
            },
        }],
    };
    document.querySelector("#job_summary").innerHTML = " ";
    var chart = new ApexCharts(document.querySelector("#job_summary"), options);
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
            height: 395,
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


})(jQuery);