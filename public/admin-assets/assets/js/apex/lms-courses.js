(function($) {
    "use strict";

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

    // Payouts
    var options = {
        series: [2568, 1954, 1548, 1020],
        labels: ["Paid", "UnPaid", "Upcoming", "Pending"],
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
                            label: 'Total Pay',
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
    document.querySelector("#payouts").innerHTML = " ";
    var chart = new ApexCharts(document.querySelector("#payouts"), options);
    chart.render();

}(jQuery));