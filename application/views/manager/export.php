<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
    <style>
        table {
            border: 1px solid black;
        }

        table,
        th,
        td {
            border-collapse: collapse;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <main>
        <h1>Laporan Kelola Training</h1>
        <p><a href="<?php echo base_url('export_excel') ?>">Export Kelola Training</a></p>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>No Training</th>
                    <th>Topik Training</th>
                    <th>Instruktur/Guru</th>
                    <th>Focus Area</th>
                    <th>Tanggal</th>
                    <th>Jam Training</th>
                    <th>Training Delivery</th>
                    <th>Biaya</th>
                    <th>Status Training</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($manager as $t) {
            ?>
                <tr>
                    <td><?= $t->id_training ?></td>
                    <td><?= $t->topik ?></td>
                    <td><?= $t->instruktur ?></td>
                    <td><?= $t->type ?></td>
                    <td><?= $t->gender ?></td>
                    <td><?= $t->tanggal ?></td>
                    <td><?= $t->jam ?></td>
                    <td><?= $t->training_delivery ?></td>
                    <td><?= $t->biaya ?></td>
                    <td><?= $t->Status ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </main>
</body>

</html>