<div id="status_board">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="reports-header">
            <tr class="board-header">
                <td class="pc1"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th> Atividades </th>
                <th> Cronograma </th>
                <th> Status </th>
                <th> Situação </th>
            </tr>
            <?php for ($i = 1; $i < 10; $i++): ?>
                <tr>
                    <td class="atividade<?= $i ?>"></td>
                    <td class="at<?= $i ?>-cronograma"></td>
                    <td class="at<?= $i ?>-status"></td>
                    <td class="at<?= $i ?>-situacao"></td>
                </tr>
            <?php endfor; ?>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>