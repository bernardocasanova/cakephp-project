<div class="scripts">

    <?php foreach ($radio['Script'] as $key => $script): ?>

        <div id="cripta<?php echo $key; ?>">
            <?php echo $script['script']; ?>
        </div>

    <?php endforeach; ?>

</div>

<?php if ($loggedIn): ?>

<div class="edit-scripts">

    <?php foreach ($radio['Script'] as $key => $script): ?>

        <div data-index="<?php echo $key + 1; ?>" data-key="<?php echo $key; ?>">
            <button class="removeScript"><i class="fa fa-times"></i></button>
            <h3>Script <?php echo $key + 1; ?></h3>
            <textarea class="liveT" data-model="Script" data-field="script" data-foreign-key="<?php echo $script['id']; ?>" data-key="<?php echo $key; ?>"><?php echo htmlentities($script['script']); ?></textarea>
        </div>

    <?php endforeach; ?>

    <button type="button" id="addScript" class="customBG">Adicionar Script</button>

</div>

<?php endif; ?>
