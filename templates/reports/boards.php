<div id="status_board">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="reports-header">

            <?php 
            $counter = 1;
            for ($i = 1; $i <= WorkPlan::$totalCriticalPoints; $i++): ?>
                <tr class="board-header">
                    <td class="pc<?= $i ?>" width="40%"></td>
                    <td></td>
                    <td width="40%"></td>
                </tr>
                <tr>
                    <th> Atividades </th>
                    <th> Cronograma </th>
                    <th> Status / Situação</th>
                </tr>
                <?php for ($j = 1; $j <= $this->totalActivityRows(); $j++): ?>
                    <tr>
                        <td class="atividade<?= $counter ?>"></td>
                        <td class="at<?= $counter ?>-cronograma"></td>
                        <td class="at<?= $counter ?>-status"></td>
                    </tr>
                    <?php $counter++; ?>
                <?php endfor; ?>                
            <?php endfor; ?>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>