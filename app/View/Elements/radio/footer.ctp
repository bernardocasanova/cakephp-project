<div class="footer">

    <div class="content">

        <p class="customColor">
            Todos os Direitos Reservados ®<br/>
            <a href="http://suaradionanet.com/" target="_blank">
                <span>suaradionanet</span>.com
            </a>
        </p>

        <ul class="socialIcons">

            <?php if (isset($radio['Radio']['facebook']) && !empty($radio['Radio']['facebook'])): ?>
            <li>
                <a href="<?php echo $radio['Radio']['facebook']; ?>" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if (isset($radio['Radio']['google_plus']) && !empty($radio['Radio']['google_plus'])): ?>
            <li>
                <a href="<?php echo $radio['Radio']['google_plus']; ?>" target="_blank">
                    <i class="fa fa-google-plus"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if (isset($radio['Radio']['twitter']) && !empty($radio['Radio']['twitter'])): ?>
            <li>
                <a href="<?php echo $radio['Radio']['twitter']; ?>" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if (isset($radio['Radio']['instagram']) && !empty($radio['Radio']['instagram'])): ?>
            <li>
                <a href="<?php echo $radio['Radio']['instagram']; ?>" target="_blank">
                    <i class="fa fa-instagram"></i>
                </a>
            </li>
            <?php endif; ?>

        </ul>

    </div>

</div>