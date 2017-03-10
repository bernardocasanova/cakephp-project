<div class="modal">

    <div class="layer"></div>

    <div class="container">

        <div class="content">

            <div class="imageHolder">
                <?php
                $options = array(
                    'loggedIn'   => $loggedIn,
                    'width'      => 450,
                    'height'     => 500,
                    'noLink'     => true,
                    'model'      => 'News',
                    'field'      => 'new',
                    'foreignKey' => '',
                );

                echo $this->Attachments->show($options);
                ?>
                <div class="mask"></div>
            </div>

            <div class="contentHolder hidden">
                <button id="closeModal">
                    <i class="fa fa-times customColor"></i>
                </button>
                <div class="middler" id="middleWScroll">
                    <h2 class="customColor liveT innerModal" data-model="News" data-field="title" data-foreign-key="" data-novidade-id=""></h2>
                    <hr/>
                    <p class="text liveT innerModal" data-model="News" data-field="description" data-foreign-key="" data-novidade-id=""></p>
                </div>
                <div class="sharing">
                    <p class="customColor">
                        Compartilhar
                    </p>
                    <a href="http://www.facebook.com/sharer.php?s=100&p[title]=Noticia&p[summary]=Noticia Top&p[url]=<?php echo $_SERVER['HTTP_HOST']; ?>&p[images][0]=http://www.site.com.br/images/logo.png" target="_blank">
                        <img src="img/fa-facebook.png" alt="">
                    </a>
                    <a href="JavaScript:newPopup('http://www.facebook.com/share.php?u=<?php echo $_SERVER['HTTP_HOST']; ?>&__mref=message_bubble');" target="_blank">
                        <img src="img/fa-facebook.png" alt="">
                    </a>
                    <a href="JavaScript:newPopup('https://twitter.com/home?status=<?php echo $_SERVER['HTTP_HOST']; ?>');" target="_blank">
                        <img src="img/fa-twitter.png" alt="">
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

<script type="text/javascript">
// Popup window code
function newPopup(url) {
    popupWindow = window.open(
        url,'popUpWindow','height=300,width=500,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}
</script>