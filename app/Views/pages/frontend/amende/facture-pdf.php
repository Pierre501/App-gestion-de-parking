<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture d'amende d'un parking</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 16px;
            padding: 0;
            margin: 0;
        }

        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
        }

        .header-title {
            font-size: 1.5em;
            text-align: center;
        }

        .mt-50 {
            margin-top: 50px;
        }

        .header-infos {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            height: auto;
            font-family: sans-serif;
        }

        .header-infos-left {
            width: calc(100%-300px);
        }

        .header-infos-right {
            width: calc(100%-500px);
        }

        .p-style {
            font-weight: bold;
        }

        .mt-30 {
            margin-top: 30px;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td,
        .table-thead,
        .table-tbody {
            border: 1px solid #ccc;
        }

        .table-thead tr>th {
            font-size: 18px;
            background-color: #27a9e3;
        }

        .table-thead tr>th:first-child {
            width: 70%;
            /* padding: 5px 0; */
        }

        .table-tbody tr>td {
            padding: 5px 15px;
            border-top: none;
            border-bottom: none;
        }

        .table-tbody tr:first-child>td {
            padding-top: 10px;
            padding-bottom: 15px;
        }

        .table-tbody tr:last-child>td {
            padding-bottom: 10px;
        }

        .table-tfoot tr {
            border: none;
            padding: 10px 0;
        }

        .table-tfoot tr>td:first-child {
            display: block;
            width: calc(60% + 1px);
            margin-left: 40%;
            margin-bottom: -1px;
            border-right: none;
            padding: 5px 15px;
            border-top: none;
            font-weight: bold;
        }

        .table-tfoot tr>td:last-child {
            padding: 0 15px;
            text-align: right;
            font-weight: bold;
        }

        .text-title {
            font-size: 20px;
            font-weight: bold;
            text-decoration: underline;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
            vertical-align: top;
        }

        .fw-bold {
            font-weight: 700 !important;
        }

        .py-2 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        .float-start {
            float: left !important;
        }

    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <h3 class="header-title mt-50">Facture d'amende n° <?= $infosPlace->getNumeroFactureOuTicket() ?></h3>
            <div class="mt-50">
                <p><span class="p-style">La date et l'heure de début d'infraction :</span> <?= $infosPlace->getValeurDate($infosPlace->getDateFin()) ?> à <?= $infosPlace->getHeureFin() ?></p>
                <p><span class="p-style">La date et l'heure actuelle :</span> <?= date("d/m/Y") ?> à <?= date("H:i:s") ?></p>
                <p><span class="p-style">La dure d'une tranche d'amende :</span> <?= $amende->getTranche() ?> min</p>
                <p><span class="p-style">Le montant d'une tranche d'amende :</span> <?= number_format($amende->getMontant(), 2, ",", " ") ?> Ar</p>
                <p><span class="p-style">La dure total d'infraction :</span> <?= $infosPlace->getDelais() ?> ou <?= number_format($infosPlace->getValeurDelaisEnMinute(), 0, "", " ") ?> minutes</p>
            </div>
        </header>
        <main class="mt-30">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-thead">
                        <tr>
                            <th class="fw-bold py-2">Désignation</th>
                            <th class="fw-bold py-2">Prix</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody">
                        <tr>
                            <td class="text-title">AMENDE D'INFRACTION</td>
                            <td></td>
                        </tr>
                        <?php foreach ($listeDetailsAmende as $detailsAmende) : ?>
                            <tr>
                                <td class="text-bold"><?= $detailsAmende['designation'] ?></td>
                                <td rowspan="2" class="text-right"><?= number_format($detailsAmende['prix'], 2, ",", " ") ?> Ar</td>
                            </tr>
                            <tr>
                                <td><?= $detailsAmende['dure'] ?> min</td>
                            </tr>
                        <?php endforeach ?>
                        <tr>
                            <td class="text-bold">La dure total en minutes de la tranche d'une amende</td>
                            <td rowspan="2" class="text-right"><?= number_format($infosPlace->getMontantAmende(), 2, ",", " ") ?> Ar</td>
                        </tr>
                        <tr>
                            <td><?= number_format($infosPlace->getValeurDelaisEnMinute(), 0, "", " ") ?> min</td>
                        </tr>
                    </tbody>
                    <tfoot class="table-tfoot">
                        <tr>
                            <td class="py-2 text-uppercase">Net à payé</td>
                            <td class="py-2"><?= number_format($infosPlace->getMontantAmende(), 2, ",", " ") ?> Ar</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="mt-50 float-start">
                <p>Arrêtée la présente facture à la somme de :</p>
                <p><?= $sommeMontantAmendeEnLettre ?> Ariary</p>
            </div>
        </main>
    </div>
</body>

</html>