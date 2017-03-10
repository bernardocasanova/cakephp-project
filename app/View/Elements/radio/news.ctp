<div class="novidades">

    <h2>
        <span class="effect customBG"></span>
        <span>novidades</span>
    </h2>

    <ul id="novidadeSlider">

        <?php foreach ($radio['News'] as $key => $news): ?>

            <?php if(isset($news['AttachmentNew']['filename']) && !empty($news['AttachmentNew']['filename'])): ?>

                <li class="item link">
                    <a href="javascript:void(0);"
                        id="thenews<?php echo $news['id']; ?>"
                        data-image="<?php echo $uploadsFolder . $this->Attachments->fixFilename($news['AttachmentNew']['filename'], 'modal.'); ?>"
                        data-title="<?php echo $news['title']; ?>"
                        data-text="<?php echo $news['description']; ?>"
                        data-foreign-key="<?php echo $news['id']; ?>">
                        <p class="customColor" class="liveT">
                           <?php echo $news['title']; ?>
                        </p>
                        <img src="<?php echo $uploadsFolder . $this->Attachments->fixFilename($news['AttachmentNew']['filename'], 'banner.'); ?>" alt="">
                    </a>
                </li>

            <?php else: ?>

                <li class="item link">
                    <a href="javascript:void(0);" id="thenews<?php echo $news['id']; ?>"
                        data-image="http://placehold.it/450x500"
                        data-title="<?php echo $news['title']; ?>"
                        data-text="<?php echo $news['description']; ?>"
                        data-foreign-key="<?php echo $news['id']; ?>">
                        <p class="customColor" class="liveT">
                           <?php echo $news['title']; ?>
                        </p>
                        <img src="http://placehold.it/535x160">
                    </a>
                </li>

            <?php endif; ?>

        <?php endforeach; ?>

    </ul>

    <div class="newControls">
        <span class="effect customBG"></span>
        <div id="nPrev">
            <i class="fa fa-chevron-left"></i>
        </div>
        <div id="nNext">
            <i class="fa fa-chevron-right"></i>
        </div>
    </div>

</div>