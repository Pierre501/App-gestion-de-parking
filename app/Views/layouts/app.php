<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Gestion de parking">
    <meta name="description" content="Une application web pour gère un parking">
    <meta name="robots" content="noindex,nofollow">
    <title>Application web | <?= $title; ?></title>
    <link href="<?= base_url("css/tooltip.css"); ?>" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("images/favicon.png"); ?>">
    <link href="<?= base_url("css/float-chart.css"); ?>" rel="stylesheet">
    <link href="<?= base_url("css/style.min.css"); ?>" rel="stylesheet">
    <link href="<?= base_url("css/main.css"); ?>" rel="stylesheet">
    <link href="<?= base_url("css/multicheck.css"); ?>" rel="stylesheet">
    <link href="<?= base_url("css/dataTables.bootstrap4.css"); ?>" rel="stylesheet">
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

        <?php include_once("top-bar.php") ?>

        <?php include_once("left-bar.php") ?>

        <div class="page-wrapper">

            <div class="container-fluid">

                <?= $this->renderSection('content-app') ?>

                <?php include_once("footer.php") ?>

            </div>

        </div>
    </div>
    <script src="<?= base_url("js/jquery.min.js"); ?>"></script>
    <script src="<?= base_url("js/bootstrap.bundle.min.js"); ?>"></script>
    <script src="<?= base_url("js/chart.min.js"); ?>"></script>
    <script src="<?= base_url("js/perfect-scrollbar.jquery.min.js"); ?>"></script>
    <script src="<?= base_url("js/sparkline.js"); ?>"></script>
    <script src="<?= base_url("js/waves.js"); ?>"></script>
    <script src="<?= base_url("js/sidebarmenu.js"); ?>"></script>
    <script src="<?= base_url("js/custom.min.js"); ?>"></script>
    <script src="<?= base_url("js/script-crud.js"); ?>"></script>
    <script src="<?= base_url("js/datatable-checkbox-init.js"); ?>"></script>
    <script src="<?= base_url("js/jquery.multicheck.js"); ?>"></script>
    <script src="<?= base_url("js/datatables.js"); ?>"></script>
    <script>
        $('#zero_config').DataTable();
    </script>
    <?php if(isset($dataStatiqueChiffreAffaireMensuelle)) : ?>
        <script>
            (function($) {
                'use strict';
                $(function() {

                    Chart.defaults.global.legend.labels.usePointStyle = true;


                    if ($("#visit-sale-chart").length) {

                        Chart.defaults.global.legend.labels.usePointStyle = true;
                        var ctx = document.getElementById('visit-sale-chart').getContext("2d");

                        var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 360);
                        gradientStrokeBlue.addColorStop(0, 'rgb(39, 169, 227)');
                        gradientStrokeBlue.addColorStop(1, 'rgb(218, 84, 46)');
                        var gradientLegendBlue = 'linear-gradient(to right, rgb(39, 169, 227), rgb(218, 84, 46))';

                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                                datasets: [{
                                    label: "Pourcentage chiffre d'affaires mensuelle",
                                    borderColor: gradientStrokeBlue,
                                    backgroundColor: gradientStrokeBlue,
                                    hoverBackgroundColor: gradientStrokeBlue,
                                    legendColor: gradientLegendBlue,
                                    pointRadius: 0,
                                    fill: false,
                                    borderWidth: 1,
                                    fill: 'origin',
                                    data: <?= json_encode($dataStatiqueChiffreAffaireMensuelle) ?>
                                }]
                            },
                            options: {
                                responsive: true,
                                legend: false,
                                legendCallback: function(chart) {
                                    var text = [];
                                    text.push('<ul class="ps-0">');
                                    for (var i = 0; i < chart.data.datasets.length; i++) {
                                        text.push('<li><span class="legend-dots" style="background:' +
                                            chart.data.datasets[i].legendColor +
                                            '"></span>');
                                        if (chart.data.datasets[i].label) {
                                            text.push(chart.data.datasets[i].label);
                                        }
                                        text.push('</li>');
                                    }
                                    text.push('</ul>');
                                    return text.join('');
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            display: false,
                                            min: 0,
                                            stepSize: 20,
                                            max: 100
                                        },
                                        gridLines: {
                                            drawBorder: false,
                                            color: 'rgba(235,237,242,1)',
                                            zeroLineColor: 'rgba(235,237,242,1)'
                                        }
                                    }],
                                    xAxes: [{
                                        gridLines: {
                                            display: false,
                                            drawBorder: false,
                                            color: 'rgba(0,0,0,1)',
                                            zeroLineColor: 'rgba(235,237,242,1)'
                                        },
                                        ticks: {
                                            padding: 20,
                                            fontColor: "#9c9fa6",
                                            autoSkip: true,
                                        },
                                        categoryPercentage: 0.5,
                                        barPercentage: 0.5
                                    }]
                                }
                            },
                            elements: {
                                point: {
                                    radius: 0
                                }
                            }
                        })
                        $("#visit-sale-chart-legend").html(myChart.generateLegend());
                    }
                });
            })(jQuery);
        </script>
    <?php endif ?>
</body>

</html>