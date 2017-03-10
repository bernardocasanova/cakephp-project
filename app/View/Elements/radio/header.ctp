<div class="header customBG">

    <div class="contenido" style="">

        <div class="controls">

            <button class="play">
                <i class="fa fa-play fa-lg"></i>
            </button>

            <div class="wichStation">
                <p>
                    no ar<br/>
                    <span>
                        
                    </span>
                </p>
            </div>
            
            <div id="flashContent"></div>

            <div id="bars">
                <div id="player">
                    <div id="audio_box" data-type="<?php echo $radio['Streaming'][0]['type']; ?>"></div>
                    <canvas id="analyser_render"></canvas>
                </div>

                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>

            <button id="changeRadio">
                <i class="fa fa-chevron-down fa-2x"></i>
            </button>

        </div>

        <div class="separator"></div>

        <div class="visitor">
            <p>
                <i class="fa fa-user"></i>
                visitante Nº
                <span class="liveT" data-model="Radio" data-field="visitors" data-foreign-key="<?php echo $radio['Radio']['id']; ?>">
                    <?php echo $radio['Radio']['visitors']; ?>
                </span>
            </p>
        </div>

        <div class="separator"></div>

<!--
        <div class="watch">
            <p>
                Assista
                <i class="fa fa-desktop"></i>
            </p>
        </div>

        <div class="separator"></div>
-->
        
        <div class="toApp">
            <p>
                Ouça no
                <i class="fa fa-apple fa-2x"></i>
<!--                <a href="<?php echo $radio['Radio']['android_app']; ?>">-->
                <?php if(isset($radio['Radio']['android_app']) && !empty($radio['Radio']['android_app'])){ ?>
                    <a href="<?php echo $radio['Radio']['android_app']; ?>">
                        <i class="fa fa-android fa-2x"></i>
                    </a>
                <?php }else{ ?>
                     <a href="#">
                        <i class="fa fa-android fa-2x"></i>
                    </a>
                <?php } ?>
                <i class="fa fa-windows fa-2x"></i>
            </p>
        </div>

    </div>

</div>

<div class="choiseRadio">

    <div class="contenido customBG">

        <ul class="clearfix">
            <?php foreach ($radio['Streaming'] as $key => $streaming): ?>
            <li>
                <a href="javascript:void(0);" data-sound="<?php echo $streaming['url']; ?>" data-name="<?php echo $streaming['name']; ?>" data-type="<?php echo $streaming['type']; ?>">
                    <span class="icon">
                        <i class="fa fa-play fa-lg"></i>
                    </span>
                    <span class="name" class="liveT">
                        <?php echo $streaming['name']; ?>
                    </span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

    </div>

</div>