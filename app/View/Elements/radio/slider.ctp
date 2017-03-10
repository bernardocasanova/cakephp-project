<div class="slider" id="homeSlider">

    <ul id="mainSlider">

        <?php foreach ($radio['Slider'] as $key => $slider): ?>
        <li class="item">
            <?php
            $options = array(
                'loggedIn'   => $loggedIn,
                'width'      => 940,
                'height'     => 294,
                'noLink'     => true,
                'daBanner'   => true,
                'alwaysShow' => true,
                'model'      => 'Slider',
                'field'      => 'slider',
                'foreignKey' => $slider['id'],
                'data'       => $slider
            );

            echo $this->Attachments->show($options);
            ?>
            <div class="labelContent">
                <span class="liveT" data-model="Slider" data-field="title" data-foreign-key="<?php echo $slider['id']; ?>"><?php echo $slider['title']; ?></span>
            </div>
        </li>
        <?php endforeach; ?>

    </ul>

    <ul id="thumbSlider">

        <?php foreach ($radio['Slider'] as $key => $slider): ?>

            <?php
            $pathToSliderThumb = (isset($slider['AttachmentSlider']['filename']) && !empty($slider['AttachmentSlider']['filename']))
                               ? $uploadsFolder . $this->Attachments->fixFilename($slider['AttachmentSlider']['filename'], 'thumb.')
                               : 'http://placehold.it/94x85';
            ?>

        <li class="item" style="background: url('<?php echo $pathToSliderThumb; ?>') center center; background-size: cover;"></li>

        <?php endforeach; ?>

    </ul>

    <button class="mainScontrols prev">
        <i class="fa fa-chevron-left"></i>
    </button>

    <button class="mainScontrols next">
        <i class="fa fa-chevron-right"></i>
    </button>

    <?php if ($loggedIn): ?>
    <button id="addSlider" class="customBG">
        <fa class="fa fa-plus"></fa>
    </button>
    <?php endif; ?>

</div>