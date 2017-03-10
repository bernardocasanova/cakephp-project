<div class="topTen">

    <ul id="tenList">

        <div class="half">

            <?php for ($i = 0; $i < 5; $i++): ?>

            <li <?php if ($i == 0) echo 'class="first"'; ?>>
                <span class="customBG"><?php echo $radio['TopTen'][$i]['position']; ?></span>
                <p>
                    <span class="musicName liveT" data-model="TopTen" data-field="music" data-foreign-key="<?php echo $radio['TopTen'][$i]['id']; ?>">
                        <?php echo $radio['TopTen'][$i]['music']; ?>
                    </span>
                    <i class="fa fa-chevron-right"></i>
                    <span class="artistName liveT" data-model="TopTen" data-field="artist" data-foreign-key="<?php echo $radio['TopTen'][$i]['id']; ?>">
                        <?php echo $radio['TopTen'][$i]['artist']; ?>
                    </span>
                </p>
            </li>

            <?php endfor; ?>

        </div>

        <div class="half">

            <?php for ($i = 5; $i < 10; $i++): ?>

            <li>
                <span class="customBG"><?php echo $radio['TopTen'][$i]['position']; ?></span>
                <p>
                    <span class="musicName liveT" data-model="TopTen" data-field="music" data-foreign-key="<?php echo $radio['TopTen'][$i]['id']; ?>">
                        <?php echo $radio['TopTen'][$i]['music']; ?>
                    </span>
                    <i class="fa fa-chevron-right"></i>
                    <span class="artistName liveT" data-model="TopTen" data-field="artist" data-foreign-key="<?php echo $radio['TopTen'][$i]['id']; ?>">
                        <?php echo $radio['TopTen'][$i]['artist']; ?>
                    </span>
                </p>
            </li>

            <?php endfor; ?>

        </div>

    </ul>
    
    <div id="askSound">
        <h3>Peça o seu som</h3>
        <form id="formContactTopTen" action="/pages/sendMessage">
            <label for="contactEmail">Seu nome:</label>
            <input id="contactEmail" name="name" placeholder="Digite seu nome" type="text">
            <label for="contactMessage">Nome do artista e da música:</label>
            <input type="text" name="music" placeholder="Nome do artista, e nome da música">
            <button type="submit" class="customBG">Enviar</button>
        </form>
    </div>

</div>

<div class="tenTitleLink customBG">
    <a href="javascript:void(0);" id="topToggler" class="top"></a>
</div>
