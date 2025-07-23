(function($) {
    "use strict";

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
            height: 350,
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

}(jQuery));