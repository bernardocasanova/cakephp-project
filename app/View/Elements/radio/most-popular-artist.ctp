<div class="mostPopularArtist">

    <div class="popHead customBG">
        <i class="fa fa-star"></i> Artista do mês
    </div>

    <div class="popText">
        <div class="popHolder">
            <h3 class="liveT" data-model="MonthArtist" data-field="name" data-foreign-key="<?php echo $radio['MonthArtist']['id']; ?>"><?php echo $radio['MonthArtist']['name']; ?></h3>
            <p class="liveT" data-model="MonthArtist" data-field="description" data-foreign-key="<?php echo $radio['MonthArtist']['id']; ?>"><?php echo $radio['MonthArtist']['description']; ?></p>
        </div>
    </div>

    <div class="imageHolder">

        <?php
        $options = array(
            'loggedIn'   => $loggedIn,
            'width'      => 263,
            'height'     => 175,
            'noLink'     => true,
            'model'      => 'MonthArtist',
            'field'      => 'month_artist',
            'foreignKey' => $radio['MonthArtist']['id'],
            'data'       => $radio['MonthArtist']
        );

        echo $this->Attachments->show($options);
        ?>

    </div>

</div>