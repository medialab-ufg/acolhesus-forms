<?php $totalActivities= 5; ?>

<div id="status_board">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="reports-header">

            <?php for ($i = 1; $i < 2; $i++): ?>
                <tr class="board-header">
                    <td class="pc<?= $i ?>" width="60%"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th> Atividades </th>
                    <th> Cronograma </th>
                    <th> Status / Situação</th>
                </tr>
                <?php for ($j = 1; $j <= $totalActivities; $j++): ?>
                    <tr>
                        <td class="atividade<?= $j ?>"></td>
                        <td class="at<?= $j ?>-cronograma"></td>
                        <td class="at<?= $j ?>-status"></td>
                    </tr>
                <?php endfor; ?>
            <?php endfor; ?>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>