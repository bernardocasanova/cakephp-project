<div class="pager">

    <div class="menu customColor">
        <ul>
            <li><div class="customColor pageOpener">A RÁDIO</div></li>
            <li><div class="customColor pageOpener">PROGRAMAÇÃO</div></li>
            <li><div class="customColor pageOpener">PROMOÇÕES</div></li>
            <li><div class="customColor pageOpener">NOVIDADES</div></li>
            <li><div class="customColor pageOpener">EVENTOS</div></li>
            <li><div class="customColor pageOpener">GALERIAS</div></li>
            <li><div class="customColor pageOpener">LOCUTORES</div></li>
            <li><div class="customColor pageOpener">CONTATO</div></li>
        </ul>
    </div>

    <div class="pages">

        <div class="page about">

            <div class="head customBG">
                <h3>A RÁDIO</h3>
                <div class="closeMe">
                    <button>
                        <span>Fechar</span>
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
            </div>

            <div class="clearfix geralHolder">

                <?php
                $options = array(
                    'loggedIn'   => $loggedIn,
                    'width'      => 350,
                    'height'     => 350,
                    'noLink'     => true,
                    'model'      => 'Radio',
                    'field'      => 'about_image',
                    'foreignKey' => $radio['Radio']['id'],
                    'data'       => $radio
                );

                echo $this->Attachments->show($options);
                ?>

                <p class="liveT" data-model="Radio" data-field="about" data-foreign-key="<?php echo $radio['Radio']['id']; ?>">
                    <?php echo $radio['Radio']['about']; ?>
                </p>

            </div>

        </div>

        <div class="page">

            <div class="head customBG">
                <h3>PROGRAMAÇÃO</h3>
                <div class="closeMe">
                    <button>
                        <span>Fechar</span>
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
            </div>

            <div class="pageCore">

                <ul class="prog customColor">
                    <li>Domingo</li>
                    <li>Segunda</li>
                    <li>Terça</li>
                    <li>Quarta</li>
                    <li>Quinta</li>
                    <li>Sexta</li>
                    <li>Sábado</li>
                </ul>

                <div class="progBox customBG">

                    <div class="dateBox">
                        <div class="text">
                          <p>
                            <span class="word">Dom</span>
                            <span class="word">Seg</span>
                            <span class="word">Ter</span>
                            <span class="word">Qua</span>
                            <span class="word">Qui</span>
                            <span class="word">Sex</span>
                            <span class="word">Sab</span>
                          </p>
                        </div>
                    </div>

                    <div class="nniPlacar">

                        <?php for ($i = 0; $i < 7; $i++): ?>

                        <div id="day0<?php echo $i ;?>">

                            <?php if (isset($schedules[$i])): ?>
                                <?php foreach ($schedules[$i] as $key => $schedule): ?>

                            <div <?php if ($schedule['onAir']) echo 'class="onAir"'; ?> data-model="Schedule" data-foreign-key="<?php echo $schedule['id']; ?>">
                                <i class="fa fa-clock-o fa-2x"></i>
                                <p class="bolder">
                                    <span class="liveT" data-model="Schedule" data-field="initial_hour" data-foreign-key="<?php echo $schedule['id']; ?>">
                                        <?php echo $this->Time->format('H:i', $schedule['initial_hour']); ?>
                                    </span>
                                    às
                                    <span class="liveT" data-model="Schedule" data-field="final_hour" data-foreign-key="<?php echo $schedule['id']; ?>">
                                        <?php echo $this->Time->format('H:i', $schedule['final_hour']); ?>
                                    </span>
                                </p>
                                <p class="bolder">/</p>
                                <p class="lighter liveT" data-model="Schedule" data-field="name" data-foreign-key="<?php echo $schedule['id']; ?>">
                                    <?php echo $schedule['name']; ?>
                                </p>
                                
                                <?php if ($loggedIn): ?>
                                
                                    <button class="deleteProg"><i class="fa fa-times"></i></button>
                                
                                <?php endif; ?>
                                
                            </div>

                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($loggedIn): ?>
                            <div>
                                <button class="btnSchedule customBG" data-week-day="<?php echo $i; ?>">Adicionar Programação</button>
                            </div>
                            <?php endif; ?>

                        </div>

                        <?php endfor; ?>

                    </div>

                </div>

            </div>

        </div>

        <div class="page">

            <div class="head customBG">
                <h3>PROMOÇÕES</h3>
                <div class="closeMe">
                    <button>
                        <span>Fechar</span>
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
            </div>

            <div class="pageCore">
                <?php if ($loggedIn): ?>
                    <button id="promoAdder" data-model="Promotion" class="customBG">Adicionar Promoção</button>
                <?php endif; ?>
                <div class="nniSlider promotion multiItems">

                    <button class="nni_next customColor">
                        <i class="fa fa-chevron-right fa-3x"></i>
                    </button>

                    <button class="nni_prev customColor">
                        <i class="fa fa-chevron-left fa-3x"></i>
                    </button>

                    <div class="frame">
                        <ul class="promoCore">

                            <?php foreach ($radio['Promotion'] as $key => $promotion): ?>

                            <li data-model="Promotion" data-field="name" data-foreign-key="<?php echo $promotion['id']; ?>">
                                <h3 class="liveT" data-model="Promotion" data-field="name" data-foreign-key="<?php echo $promotion['id']; ?>"><?php echo $promotion['name']; ?></h3>

                                <div class="core">

                                    <div class="image">
                                        <?php
                                        $options = array(
                                            'loggedIn'   => $loggedIn,
                                            'width'      => 260,
                                            'height'     => 360,
                                            'noLink'     => true,
                                            'model'      => 'Promotion',
                                            'field'      => 'promotion',
                                            'foreignKey' => $promotion['id'],
                                            'data'       => $promotion
                                        );

                                        echo $this->Attachments->show($options);
                                        ?>
                                    </div>

                                    <div class="text-right">

                                        <div class="textToBeMoved">
                                            <h4 class="liveT" data-model="Promotion" data-field="title" data-foreign-key="<?php echo $promotion['id']; ?>"><?php echo $promotion['title']; ?></h4>
                                            <p class="liveT" data-model="Promotion" data-field="description" data-foreign-key="<?php echo $promotion['id']; ?>"><?php echo $promotion['description']; ?></p>
                                        </div>

                                        <div class="formToBeMoved hidden">
                                            <h4>Preencha os seus dados para participar</h4>

                                            <form class="form-promotion" action="<?php echo $this->Html->url(array("controller" => "participants", "action" => "add", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json">
                                                <input type="text" name="name" placeholder="Seu nome">
                                                <input type="text" name="email" placeholder="Seu e-mail">
                                                <div class="clearfix">
                                                    <input type="text" name="phone" placeholder="Telefone" class="halfInp">
                                                    <input type="text" name="cellphone" placeholder="Celular" class="halfInp right">
                                                </div>
                                                <input type="hidden" name="promotion_id" value="<?php echo $promotion['id']; ?>">
                                                <!-- <div class="checksquare">
                                                    <input name="accept" class="needTerm" id="StoreUserTerms" type="checkbox">
                                                    <label for="StoreUserTerms"></label>
                                                </div>
                                                <span class="fakelabel">Aceito os termos de uso</span> -->
                                                <span class="alertMessage"></span>
                                            </form>

                                        </div>

                                        <div class="messageToBeMoved hidden">
                                            <h4>Suas informações foram salvas com sucesso!</h4>
                                        </div>

                                    </div>

                                    <a href="javascript:void(0);" class="canceller">cancelar</a>
                                    <a href="javascript:void(0);" class="customBG promoInit">Participar!</a>

                                    <button class="deletePromo"><i class="fa fa-times"></i></button>
                                    
                                </div>

                            </li>

                            <?php endforeach; ?>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

        <div class="page">

            <div class="head customBG">
                <h3>NOVIDADES</h3>
                <div class="closeMe">
                    <button>
                        <span>Fechar</span>
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
            </div>

            <div class="pageCore">
                <?php if ($loggedIn): ?>
                    <button class="fractionAdder customBG" data-focus="novidades" data-model="New">Adicionar Novidade</button>
                <?php endif; ?>
                <div class="nniSlider multiItems" id="novidadePage">

                    <button class="nni_next customColor"><i class="fa fa-chevron-right fa-3x"></i></button>
                    <button class="nni_prev customColor"><i class="fa fa-chevron-left fa-3x"></i></button>

                    <div class="frame">

                        <ul class="fractionFather">

                            <li>

                            <?php foreach ($radio['News'] as $key => $news): ?>
                                
                            <?php if ($key % 3 == 0 && $key != 0): ?>
                            </li>
                            <li>
                            <?php endif; ?>
                                
                                <?php if(isset($news['AttachmentNew']['filename']) && !empty($news['AttachmentNew']['filename'])): ?>
                                    
                                    <div class="item" id="news<?php echo $news['id']; ?>"
                                        data-model="New"
                                        data-image="<?php echo $uploadsFolder . $this->Attachments->fixFilename($news['AttachmentNew']['filename'], 'modal.'); ?>"
                                        data-title="<?php echo $news['title']; ?>"
                                        data-text="<?php echo $news['description']; ?>"
                                        data-foreign-key="<?php echo $news['id']; ?>">
                                        <div class="speakerAvatar">
                                            <img src="<?php echo $uploadsFolder . $this->Attachments->fixFilename($news['AttachmentNew']['filename'], 'web.'); ?>">
                                        </div>
                                        <p><?php echo mb_strimwidth($news['title'], 0, 40, '...'); ?></p>
                                        
                                        <?php if ($loggedIn): ?>
                                    
                                            <button class="deleteFraction" data-model="New"><i class="fa fa-times"></i></button>

                                        <?php endif; ?>
                                        
                                    </div>
                                
                                <?php else: ?>

                                    <div class="item" id="news<?php echo $news['id']; ?>"
                                        data-model="New"
                                        data-image="http://placehold.it/450x500"
                                        data-title="<?php echo $news['title']; ?>"
                                        data-text="<?php echo $news['description']; ?>"
                                        data-foreign-key="<?php echo $news['id']; ?>">
                                        <div class="speakerAvatar">
                                            <img src="http://placehold.it/150x140">
                                        </div>
                                        <p><?php echo mb_strimwidth($news['title'], 0, 40, '...'); ?></p>
                                        
                                        <?php if ($loggedIn): ?>
                                    
                                            <button class="deleteFraction" data-model="New"><i class="fa fa-times"></i></button>

                                        <?php endif; ?>
                                        
                                    </div>

                                <?php endif; ?>

                            <?php endforeach; ?>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

        <div class="page">

            <div class="head customBG">
                <h3>EVENTOS</h3>
                <div class="closeMe">
                    <button>
                        <span>Fechar</span>
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
            </div>

            <div class="pageCore">
                <?php if ($loggedIn): ?>
                    <button class="fractionAdder customBG" data-focus="eventos" data-model="Event">Adicionar Evento</button>
                <?php endif; ?>
                <div class="nniSlider multiItems programation">

                    <button class="nni_next customColor">
                        <i class="fa fa-chevron-right fa-3x"></i>
                    </button>

                    <button class="nni_prev customColor">
                        <i class="fa fa-chevron-left fa-3x"></i>
                    </button>

                    <div class="frame">

                        <ul class="promoCore fractionFather">

                            <li>

                            <?php foreach ($radio['Event'] as $key => $event): ?>

                            <?php if ($key % 3 == 0 && $key != 0): ?>
                            </li>
                            <li>
                            <?php endif; ?>

                                <div class="item" data-foreign-key="<?php echo $event['id']; ?>" data-model="Event">

                                    <div class="speakerAvatar">

                                        <?php
                                        $options = array(
                                            'loggedIn'   => $loggedIn,
                                            'width'      => 150,
                                            'height'     => 140,
                                            'noLink'     => true,
                                            'model'      => 'Event',
                                            'field'      => 'event',
                                            'foreignKey' => $event['id'],
                                            'data'       => $event
                                        );

                                        echo $this->Attachments->show($options);
                                        ?>

                                    </div>

                                    <div class="dating">
                                        <div class="effect customBG"></div>
                                        <div class="texture"></div>
                                        <div class="dateHolder">
                                            <div class="dayHolder liveT" data-model="Event" data-foreign-key="<?php echo $event['id']; ?>" data-type="date" data-field="day">
                                                <?php echo $this->Time->format('d', $event['date']); ?>
                                            </div>
                                            <div class="monthHolder liveT" data-model="Event" data-foreign-key="<?php echo $event['id']; ?>" data-type="date" data-field="month">
                                                <?php echo $this->Month->short($event['date']); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="info">
                                        <div>
                                            <div class="nome liveT" data-model="Event" data-field="name" data-foreign-key="<?php echo $event['id']; ?>"><?php echo $event['name']; ?></div>
                                            <div class="local clearfix">
                                                <div>
                                                    <b>Local:</b>
                                                </div>
                                                <div class="liveT" data-model="Event" data-field="local" data-foreign-key="<?php echo $event['id']; ?>">
                                                    <?php echo $event['local']; ?>
                                                </div>
                                            </div>
                                            <div class="hora clearfix">
                                                <div>
                                                    <b>Hora:</b>
                                                </div>
                                                <div class="liveT" data-model="Event" data-field="hour" data-foreign-key="<?php echo $event['id']; ?>">
                                                    <?php echo $this->Time->format('H:i', $event['hour']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php if ($loggedIn): ?>
                                
                                        <button class="deleteFraction" data-model="Event"><i class="fa fa-times"></i></button>

                                    <?php endif; ?>

                                </div>

                            <?php endforeach; ?>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

        <div class="page gallery">
            <div class="head customBG">
                <h3>GALERIAS</h3>
                <div class="closeMe">
                    <button>
                        <span>Fechar</span>
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
            </div>

            <div class="pageCore">

               <h2>Fotos</h2>
               
                <?php if ($loggedIn): ?>
                    <button class="openGalleryTest customBG">
                        <i class="fa fa-plus"></i>
                        Adicionar álbum
                    </button>
                <?php endif; ?>

               <div class="netFlocos">

                    <button data-function="prev">
                        <i class="fa fa-chevron-left fa-2x customColor"></i>
                    </button>

                    <button data-function="next" class="right">
                        <i class="fa fa-chevron-right fa-2x customColor"></i>
                    </button>

                    <ul data-left="0" class="galleryPager">

                        <?php foreach ($radio['Gallery'] as $key => $gallery): ?>

                        <li class="albumGallery" data-model="Gallery" data-foreign-key="<?php echo $gallery['id']; ?>">
                            <?php foreach ($gallery['AttachmentGallery'] as $key => $attachment): ?>

                            <a href="<?php echo $uploadsFolder . $attachment['filename']; ?>" data-kind="image">
                                <img src="<?php echo $uploadsFolder . $this->Attachments->fixFilename($attachment['filename'], 'web.'); ?>" alt="" data-smoothzoom="<?php echo $gallery['name']; ?> Pager" class="galleryImage">
                            </a>

                            <?php endforeach; ?>

                            <?php if ($loggedIn): ?>
                                <button class="removeAlbun galleryActions customBG"><i class="fa fa-trash-o"></i></button>
                                <button class="editAlbun galleryActions customBG"><i class="fa fa-pencil"></i></button>
                            <?php endif; ?>
                        </li>

                        <?php endforeach; ?>

                    </ul>

                </div>

                <h2>Vídeos</h2>
                
                <?php if ($loggedIn): ?>
                    <button class="addNewVideo customBG">
                        <i class="fa fa-plus"></i>
                        Adicionar vídeo
                    </button>
                <?php endif; ?>

                <div class="netFlocos">

                    <button data-function="prev">
                        <i class="fa fa-chevron-left fa-2x customColor"></i>
                    </button>

                    <button data-function="next" class="right">
                        <i class="fa fa-chevron-right fa-2x customColor"></i>
                    </button>

                    <ul data-left="0" class="videoSlider <?php if ($loggedIn){ echo 'logged'; } ?>">

                        <?php foreach ($radio['Video'] as $key => $video): ?>

                            <?php echo $this->Video->show($video); ?>

                        <?php endforeach; ?>

                    </ul>

                </div>

            </div>

        </div>

        <div class="page">

            <div class="head customBG">
                <h3>LOCUTORES</h3>
                <div class="closeMe">
                    <button>
                        <span>Fechar</span>
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
            </div>

            <div class="pageCore">
                <?php if ($loggedIn): ?>
                    <button class="fractionAdder customBG" data-focus="locutores" data-model="Announcer">Adicionar Locutor</button>
                <?php endif; ?>
                <div class="nniSlider multiItems">

                    <button class="nni_next customColor">
                        <i class="fa fa-chevron-right fa-3x customColor"></i>
                    </button>

                    <button class="nni_prev customColor">
                        <i class="fa fa-chevron-left fa-3x customColor"></i>
                    </button>

                    <div class="frame">

                        <ul class="promoCore fractionFather">

                            <li>

                            <?php foreach ($radio['Announcer'] as $key => $announcer): ?>

                            <?php if ($key % 3 == 0 && $key != 0): ?>
                            </li>
                            <li>
                            <?php endif; ?>

                                <div class="item" data-foreign-key="<?php echo $announcer['id']; ?>" data-model="Announcer">
                                    <div class="speakerAvatar">
                                        <?php
                                        $options = array(
                                            'loggedIn'   => $loggedIn,
                                            'width'      => 150,
                                            'height'     => 140,
                                            'noLink'     => true,
                                            'model'      => 'Announcer',
                                            'field'      => 'announcer',
                                            'foreignKey' => $announcer['id'],
                                            'data'       => $announcer
                                        );

                                        echo $this->Attachments->show($options);
                                        ?>
                                    </div>
                                    <p class="liveT" data-model="Announcer" data-field="name" data-foreign-key="<?php echo $announcer['id']; ?>"><?php echo $announcer['name']; ?></p>
                                    
                                    <?php if ($loggedIn): ?>
                                
                                        <button class="deleteFraction" data-model="Announcer"><i class="fa fa-times"></i></button>

                                    <?php endif; ?>
                                    
                                </div>

                            <?php endforeach; ?>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

        <div class="page contato">

            <div class="head customBG">
                <h3>CONTATO</h3>
                <div class="closeMe">
                    <button>
                        <span>Fechar</span>
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
            </div>

            <div class="content">
                <form id="formContact" action="<?php echo $this->Html->url(array("controller" => "contacts", "action" => "send", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json">
                    <label for="contactName">Seu nome:</label>
                    <input type="text" id="contactName" name="name" placeholder="Digite seu nome">
                    <label for="contactEmail">Seu e-mail:</label>
                    <input type="text" id="contactEmail" name="email" placeholder="Digite seu e-mail">
                    <label for="contactMessage">Comentário:</label>
                    <textarea id="contactMessage" name="message" cols="30" rows="10" placeholder="Digite seu comentário"></textarea>
                    <button type="reset" id="reset">Cancelar</button>
                    <button type="submit" class="customBG">Enviar</button>
                </form>
            </div>

        </div>

   
   
        <div class="fractionHolder"></div>
    </div>

</div>