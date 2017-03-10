<div class="clearfix threeBlocksAsside">

    <?php foreach ($banners['block'] as $key => $block): ?>

    <?php
    $options = array(
        'loggedIn'   => $loggedIn,
        'width'      => 300,
        'height'     => 300,
        'model'      => 'Banner',
        'field'      => 'block',
        'foreignKey' => $block['Banner']['id'],
        'link'       => $block['Banner']['link'],
        'data'       => $block
    );

    echo $this->Attachments->show($options);
    ?>

    <?php endforeach; ?>

</div>

<?php if ($loggedIn): ?>
<div class="clearfix">
    <div class="right">
        <button class="customBG addDense">
            Adicionar propaganda
        </button>
    </div>
</div>
<?php endif; ?>