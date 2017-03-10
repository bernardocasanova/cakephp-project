
<div class="horoscopo customBG" style="<?php echo $radio['Radio']['horoscope'] == 1 ? 'display:block' : 'display:none'; ?>">

    <ul id="signos">

        <?php debug($horoscopes); foreach ($horoscopes as $key => $horoscope): ?>
        <li>
            <div class="leftSign">
                <img class="signo" data-src="img/signos/<?php echo $horoscope['nome']; ?>.svg"/>
                <div class="nameSign"><?php echo $horoscope['nome']; ?></div>
            </div>
            <div class="rightSign">
                <?php echo $horoscope['msg']; ?>
            </div>
        </li>
        <?php endforeach; ?>

    </ul>

    <div id="signoPrev" class="horsCtrl">
        <i class="fa fa-chevron-left fa-2x"></i>
    </div>
    <div id="signoNext" class="horsCtrl">
        <i class="fa fa-chevron-right fa-2x"></i>
    </div>

</div>