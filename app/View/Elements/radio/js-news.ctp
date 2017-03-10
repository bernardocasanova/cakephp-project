<div class="news customBG">

    <span class="icon">
        <i class="fa fa-bookmark"></i>
        News
    </span>

    <div class="separator"></div>

    <ul id="js-news">

        <?php foreach ($rss as $key => $item): ?>

        <li class="news-item">
            <a href="<?php echo $item['link']; ?>" target="_blank">
                <?php echo $item['title']; ?>
            </a>
        </li>

        <?php endforeach; ?>

    </ul>

</div>