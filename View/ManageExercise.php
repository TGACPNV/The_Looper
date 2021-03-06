
    <section class="row">
        <div class="column">
            <h1>Building</h1>
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2">title</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($exercises as $exercise) {
                    if ($exercise->state == \TheLooper\Model\ExerciseState::BUILDING) {
                        ?>
                        <tr>
                            <td>
                                <p class="text"><?= $exercise->title ?></p>
                            </td>
                            <td id="iconColumn">
                                <?= (count($exercise->fields()) > 0) ? '<a class="icon" href="?action=answering&id='.$exercise->id.'"><i class="fa fa-comment"></i></a>' : "" ?>

                                <a class="icon" href="?action=showCreateField&id=<?= $exercise->id ?>"><i class="fa fa-edit"></i></a>
                                <a class="icon"  onclick="return confirm('Are you sure?');"  href="?action=deleteExercise&id=<?= $exercise->id ?>"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php }
                } ?>
                </tbody>
            </table>
        </div>
        <div class="column">
            <h1>Answering</h1>
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2">title</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($exercises as $exercise) {
                    if ($exercise->state == \TheLooper\Model\ExerciseState::ANSWERING) {
                        ?>
                        <tr>
                            <td>
                                <p class="text"><?= $exercise->title ?></p>
                            </td>
                            <td id="iconColumn">
                                <a class="icon" href="?action=showStatExercise&id=<?= $exercise->id ?>"><i class="fa fa-chart-bar"></i></a>
                                <a class="icon" href="?action=closed&id=<?= $exercise->id ?>"><i class="fa fa-minus-circle"></i></a>
                            </td>
                        </tr>
                    <?php }
                } ?>
                </tbody>
            </table>
        </div>
        <div class="column">
            <h1>Closed</h1>
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2">title</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($exercises as $exercise):
                    if ($exercise->state == \TheLooper\Model\ExerciseState::CLOSED):
                        ?>
                        <tr>
                            <td>
                                <p class="text"><?= $exercise->title ?></p>
                            </td>
                            <td id="iconColumn">
                                <a class="icon" href="?action=showStatExercise&id=<?= $exercise->id ?>"><i class="fa fa-chart-bar"></i></a>
                                <a class="icon" onclick="return confirm('Are you sure?');" href="?action=deleteExercise&id=<?= $exercise->id ?>"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endif;
                    endforeach;
                 ?>
                </tbody>
            </table>
        </div>
    </section>
