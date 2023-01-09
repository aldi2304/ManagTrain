<?php

header("Content-type: application/vnd-ms-excel");

header("Content-Disposition: attachment; filename=$title.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>

<table border="1" width="100%">

    <thead>
        <tr>
            <th>No Training</th>
            <th>Topik Training</th>
            <th>Instruktur/Guru</th>
            <th>Type</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Training Delivery</th>
            <th>Biaya</th>
            <th>Status</th>
        </tr>
    </thead>

    <?php

    foreach ($training as $t) :
    ?>
        <tr>
            <td><?= $t['id_training'] ?></td>
            <td><?= $t['topik'] ?></td>
            <td><?= $t['instruktur'] ?></td>
            <td><?= $t['type'] ?></td>
            <td><?= $t['tanggal'] ?></td>
            <td><?= $t['jam'] ?></td>
            <td><?= $t['training_delivery'] ?></td>
            <td><?= $t['biaya'] ?></td>
            <td><?= $t['Status'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>

</table>