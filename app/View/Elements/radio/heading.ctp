<div class="heading clearfix">

    <div class="sec1">

        <div class="logo">

            <?php
            $options = array(
                'loggedIn'   => $loggedIn,
                'width'      => 300,
                'height'     => 170,
                'noLink'     => true,
                'model'      => 'Radio',
                'field'      => 'logo',
                'foreignKey' => $radio['Radio']['id'],
                'data'       => $radio
            );

            echo $this->Attachments->show($options);
            ?>

        </div>

    </div>

    <div class="sec2">

        <?php
        $options = array(
            'loggedIn'   => $loggedIn,
            'width'      => 468,
            'height'     => 60,
            'model'      => 'Banner',
            'field'      => 'header',
            'foreignKey' => isset($banners['header']['Banner']['id']) ? $banners['header']['Banner']['id'] : '',
            'link'       => isset($banners['header']['Banner']['link']) ? $banners['header']['Banner']['link'] : '',
            'data'       => isset($banners['header']) ? $banners['header'] : ''
        );

        echo $this->Attachments->show($options);
        ?>

        <div id="weather" class="clearfix" data-cidade="<?php echo $radio['Radio']['city']; ?>" data-estado="<?php echo $radio['Radio']['state']; ?>"></div>
    </div>

    <div class="sec3">
        <ul class="socialIcons">

            <?php if (isset($radio['Radio']['facebook']) && !empty($radio['Radio']['facebook'])): ?>
            <li>
                <a href="<?php echo $radio['Radio']['facebook']; ?>" target="_blank">
                    <i class="fa fa-facebook customColor"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if (isset($radio['Radio']['google_plus']) && !empty($radio['Radio']['google_plus'])): ?>
            <li>
                <a href="<?php echo $radio['Radio']['google_plus']; ?>" target="_blank">
                    <i class="fa fa-google-plus customColor"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if (isset($radio['Radio']['twitter']) && !empty($radio['Radio']['twitter'])): ?>
            <li>
                <a href="<?php echo $radio['Radio']['twitter']; ?>" target="_blank">
                    <i class="fa fa-twitter customColor"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if (isset($radio['Radio']['instagram']) && !empty($radio['Radio']['instagram'])): ?>
            <li>
                <a href="<?php echo $radio['Radio']['instagram']; ?>" target="_blank">
                    <i class="fa fa-instagram customColor"></i>
                </a>
            </li>
            <?php endif; ?>

        </ul>
    </div>

</div>