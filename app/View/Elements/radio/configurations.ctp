<?php if ($loggedIn): ?>
<div id="gearStick" class="open">
    <i class="fa fa-cog fa-2x"></i>
</div>

<div id="gearBox">

    <button id="setStick"><i class="fa fa-caret-right fa-2x"></i></button>

    <h3 data-tab="configurations">
        <i class="fa fa-cog fa-2x"></i>
        Configurações
    </h3>

    <div class="separator"></div>

    <div class="section" id="configurations">

        <div class="holder clearfix">
            <div class="clearfix">
                <input type="text" class="colorPicker" value="#ee1847" max="7" min="7">
            </div>
        </div>

        <ul class="clearfix colorPalete">
            <li data-color="#1abc9c"></li>
            <li data-color="#2ecc71"></li>
            <li data-color="#3498db"></li>
            <li data-color="#8e44ad"></li>
            <li data-color="#7f8c8d"></li>
            <li data-color="#d35400"></li>
            <li data-color="#16a085"></li>
            <li data-color="#cc0e9d"></li>
        </ul>

        <div class="holder">

            <h4>Cores de fundo</h4>
            <ul class="themeColor clearfix">
                <li data-soul="white" data-model="Radio" data-field="theme_soul" data-foreign-key="<?php echo $radio['Radio']['id']; ?>">Claro</li>
                <li data-soul="dark" data-model="Radio" data-field="theme_soul" data-foreign-key="<?php echo $radio['Radio']['id']; ?>" class="dark">Escuro</li>
            </ul>

            <br>
            <br>

            <h4>Favicon</h4>

            <?php
            $options = array(
                'loggedIn'   => $loggedIn,
                'width'      => 32,
                'height'     => 32,
                'noLink'     => true,
                'model'      => 'Radio',
                'field'      => 'favicon',
                'foreignKey' => $radio['Radio']['id'],
                'data'       => $radio
            );

            echo $this->Attachments->show($options);
            ?>

            <br>
            <h4>Imagem de Fundo</h4>

            <?php
            $options = array(
                'loggedIn'    => $loggedIn,
                'width'       => 308,
                'height'      => 231,
                'noLink'      => true,
                'model'       => 'Radio',
                'field'       => 'background',
                'foreignKey'  => $radio['Radio']['id'],
                'data'        => $radio,
                'thumbPrefix' => ''
            );

            echo $this->Attachments->show($options);
            ?>

        </div>

        <div class="separator"></div>

    </div>

    <h3 data-tab="advanced">
        <i class="fa fa-database fa-2x"></i>
        Avançado
    </h3>

    <div class="separator"></div>

    <div class="section" id="advanced">

        <div class="holder">

            <div class="glock">
                <label for="inptRadioName">Título da Rádio</label>
                <input type="text" id="inptRadioName" class="liveT" data-model="Radio" data-field="name" data-foreign-key="<?php echo $radio['Radio']['id']; ?>" value="<?php echo $radio['Radio']['name']; ?>">
            </div>

            <div class="glock">
                <label for="slctRadioTimezone">
                    Fuso
                </label>
                <select id="slctRadioTimezone" class="liveT" data-model="Radio" data-field="timezone" data-foreign-key="<?php echo $radio['Radio']['id']; ?>">
                    <?php foreach ($timezones as $key => $timezone): ?>
                    <option value="<?php echo $timezone; ?>" <?php if ($timezone == $radio['Radio']['timezone']) echo 'selected'; ?>><?php echo $timezone; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="glock">
                <div class="g50 first">
                    <label for="slctRadioState">Estado</label>
                    <select id="slctRadioState" class="liveT" data-model="Radio" data-field="state" data-foreign-key="<?php echo $radio['Radio']['id']; ?>">
                        <?php foreach ($states as $key => $state): ?>
                        <option value="<?php echo $state; ?>" <?php if ($state == $radio['Radio']['state']) echo 'selected'; ?>><?php echo $state; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="g50 last">
                    <label for="inptRadioCity">Cidade</label>
                    <input type="text" id="inptRadioCity" class="liveT" data-model="Radio" data-field="city" data-foreign-key="<?php echo $radio['Radio']['id']; ?>" value="<?php echo $radio['Radio']['city']; ?>">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="glock">
                <label for="inptRadioAnalytics">ID Google Analytics</label>
                <input type="text" id="inptRadioAnalytics" class="liveT" data-model="Radio" data-field="analytics" data-foreign-key="<?php echo $radio['Radio']['id']; ?>" value="<?php echo $radio['Radio']['analytics']; ?>">
            </div>

            <div class="glock">
                <label for="inptRadioFacebook">Endereço do Facebook</label>
                <input type="text" id="inptRadioFacebook" class="liveT" data-model="Radio" data-field="facebook" data-foreign-key="<?php echo $radio['Radio']['id']; ?>" value="<?php echo $radio['Radio']['facebook']; ?>">
            </div>

            <div class="glock">
                <label for="inptRadioGooglePlus">Endereço do Google+</label>
                <input type="text" id="inptRadioGooglePlus" class="liveT" data-model="Radio" data-field="google_plus" data-foreign-key="<?php echo $radio['Radio']['id']; ?>" value="<?php echo $radio['Radio']['google_plus']; ?>">
            </div>

            <div class="glock">
                <label for="inptRadioTwitter">Endereço do Twitter</label>
                <input type="text" id="inptRadioTwitter" class="liveT" data-model="Radio" data-field="twitter" data-foreign-key="<?php echo $radio['Radio']['id']; ?>" value="<?php echo $radio['Radio']['twitter']; ?>">
            </div>

            <div class="glock">
                <label for="inptRadioInstagram">Endereço do Instagram</label>
                <input type="text" id="inptRadioInstagram" class="liveT" data-model="Radio" data-field="instagram" data-foreign-key="<?php echo $radio['Radio']['id']; ?>" value="<?php echo $radio['Radio']['instagram']; ?>">
            </div>

            <div class="glock">
                <label for="inptRadioSoundcloud">ID Soundcloud <?php echo $this->Html->link('Nao sabe seu id? Clique Aqui!', 'https://helgesverre.com/soundcloud/', array('style' => 'float: right; color: #fff;')); ?></label>
                <input type="text" id="inptRadioSoundcloud" class="liveT" data-model="Radio" data-field="soundcloud" data-foreign-key="<?php echo $radio['Radio']['id']; ?>" value="<?php echo $radio['Radio']['soundcloud']; ?>">
            </div>

            <div class="glock">
                <label for="inptRadioEmail">Seu e-mail para contato</label>
                <input type="text" id="inptRadioEmail" class="liveT" data-model="Radio" data-field="email" data-foreign-key="<?php echo $radio['Radio']['id']; ?>" value="<?php echo $radio['Radio']['email']; ?>">
            </div>
            
            <div class="glock">
                <label for="">Exibir horóscopo:</label>
                <span class="toggle">
                    <input type="checkbox" class="toggle-input" id="thang" data-model-id="<?php echo $radio['Radio']['id']; ?>" <?php echo $radio['Radio']['horoscope'] == 1 ? 'checked' : ''; ?>>
                    <label class="toggle-switch" for="thang"></label>
                </span>
            </div>

            <div class="glock">
                <label for="">Reproduzir audio automaticamente:</label>
                <span class="toggle">
                    <input type="checkbox" class="toggle-input" id="autoplay" data-model-id="<?php echo $radio['Radio']['id']; ?>" <?php echo $radio['Radio']['autoplay'] == 1 ? 'checked' : ''; ?>>
                    <label class="toggle-switch" for="autoplay"></label>
                </span>
            </div>
            
            <div class="glock">
                <button class="customBG" id="saveGearAd">
                    Salvar
                </button>
            </div>

        </div>

        <div class="separator"></div>
    </div>
    
    <h3>
        <a href="/logout">
            <i class="fa fa-sign-out fa-2x"></i>
            Sair
        </a>
    </h3>
    
    

</div>
<?php endif; ?>
