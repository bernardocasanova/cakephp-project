<div id="fb-root"></div>









<div id="chat" class="customBG">
    <div id="hed" class="customBG">
        Chat <?php echo $radio['Radio']['name']; ?>
    </div>
    <div id="messages">
        <div id="leaveYM" class="customColor">Participe deixando seu <b>recado!</b></div>
        <div id="" style="height: 100%;overflow:hidden;">
        <div class="loading_messages">
            <div class="center">
                Carregando mensagens...
            </div>
        </div>
        <div id="auth" class="hidden">
            <div class="center">
<!--                <button id="authFB" class="customColor"><span>Entrar com facebook</span></button>-->
                <button id="authQB" class="customColor"><span>Entrar com conta da rádio</span></button>
            </div>
        </div>

        <div id="login-form" class="">
            <form action="#" class="center">
                <fieldset>
                    <input id="login" type="text" placeholder="Login ou e-mail">
                    <input id="pass" type="password" placeholder="Senha">
                </fieldset>
                <button id="dataLogin">Entrar</button>
                <span class="not-registered">
                    <a href="#" id="signUp">Criar uma nova conta</a>
                </span>
            </form>
        </div>

        <div id="signup-form" class="hidden">
            <form action="#" class="center" enctype="multipart/form-data">
                <fieldset>
                    <input id="signup_name" type="text" placeholder="Nome completo">
                    <input id="signup_email" type="text" placeholder="E-mail">
                    <input id="signup_login" type="text" placeholder="Login">
                    <input id="signup_pass" type="password" placeholder="Senha">
                    <div class="uploader-wrap">
                        <label for="" class="selectAvatar">Selecione sua foto de avatar</label>
                        <input class="uploader-text" type="text" placeholder="Foto" class="hidden" style="display: none;">
                        <input id="signup_avatar" type="file" accept="image/*">
                    </div>
                </fieldset>
                <button id="dataSignup">Registrar-se</button>
                <div id="errr"></div>
            </form>
        </div>

       <div id="chats-wrap" class="hidden">
            <div id="chat-room" class="chat">
                <header class="chat-header">
                    <span><i class="fa fa-user"></i><span class="users-count">0</span></span>
                    <i class="fa fa-sign-out logout"></i>
                    <ul class="users-list list hidden"></ul>
                </header>

                <section class="chat-content" id="chatScroll"></section>

                <footer class="chat-footer">
                    <textarea class="send-message" placeholder="Escreva sua mensagem aqui" rows="1"></textarea>
                </footer>
            </div>

        </div>

    </div>
    </div>
    <div id="sender">
        <p>
            interaja em nosso
            <br>
            <span class="customColor">
                Mural
            </span>
        </p>
    </div>
</div>