<div class="galleryTitle clearfix">

    <?php
    $options = array(
        'loggedIn'   => $loggedIn,
        'width'      => 468,
        'height'     => 60,
        'model'      => 'Banner',
        'field'      => 'gallery',
        'foreignKey' => isset($banners['gallery']['Banner']['id']) ? $banners['gallery']['Banner']['id'] : '',
        'link'       => isset($banners['gallery']['Banner']['link']) ? $banners['gallery']['Banner']['link'] : '',
        'data'       => isset($banners['gallery']) ? $banners['gallery'] : ''
    );

    echo $this->Attachments->show($options);
    ?>

    <h3 class="customColor">Galeria</h3>

</div>

<div class="gallery clearfix">

    <div class="photos">

        <ul class="images">

            <?php foreach ($radio['Gallery'] as $key => $gallery): ?>
                
                <?php if ($key == 5) break; ?>

            <li>

                <?php foreach ($gallery['AttachmentGallery'] as $key => $attachment): ?>

                <a href="<?php echo $uploadsFolder . $attachment['filename']; ?>" data-kind="image">
                    <img src="<?php echo $uploadsFolder . $this->Attachments->fixFilename($attachment['filename'], 'thumb.'); ?>" alt="" data-smoothzoom="<?php echo $gallery['name']; ?>" class="galleryImage">
                </a>

                <?php endforeach; ?>

            </li>

            <?php endforeach; ?>

        </ul>

        <a class="icon customBG"><i class="fa fa-picture-o fa-2x"></i></a>
    </div>

    <div class="videos videoSlider">

        <ul>

            <?php foreach ($radio['Video'] as $key => $video): ?>
                <?php if ($key == 5) break; ?>

                <?php echo $this->Video->show($video); ?>

            <?php endforeach; ?>

        </ul>

        <a class="icon customBG"><i class="fa fa-video-camera fa-2x"></i></a>
    </div>

</div>