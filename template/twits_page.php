<?php if (!empty($twits)): ?>
    <table class="table" width="800px">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Twit text</th>
            <th scope="col">Save twit in the DB</th>
        </tr>
        </thead>
        <tbody>

        <? $i = 0;
        foreach ($twits as $key => $item) : ?>
            <tr>
                <td><?php echo $key; ?></td>
                <td><?php echo $item['text']; ?></td>
                <td>
                    <form action="../index.php" method="post">
                        <input type="hidden" name="id_twit" value="<?php echo $key; ?>">
                        <input type="hidden" name="text_twit" id="text_twit" class="text_twit"
                               value="<?php echo $item['text']; ?>">
                        <input type="hidden" name="hashtags_twit"
                               value="<?php echo implode(",", $item['hashtags']); ?>">
                        <i class="fa fa-star add_twit" aria-hidden="true"></i>
                    </form>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<table class="table" width="800px" id="fromDB">

    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Twit text from DB</th>
    </tr>
    </thead>
    <?php $i = 0;
    if (!empty($twitsFromDb)): ?>
        <tbody>
        <? foreach ($twitsFromDb as $item): ?>
            <tr>
                <td><?php echo $item['id_twit']; ?></td>
                <td><?php echo $item['text_twit']; ?></td>
            </tr>
        <? endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>



