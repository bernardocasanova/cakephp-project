<?php $options = json_decode($radio['Poll']['options'], true); ?>
<?php $answers = json_decode($radio['Poll']['answers'], true); ?>
<div class="voting">

    <h3 class="liveT" data-type="vote" data-model="Poll" data-foreign-key="<?php echo $radio['Radio']['id'];?>" data-field="question"><?php echo $radio['Poll']['question']; ?></h3>

    <form <?php if ($loggedIn) echo 'style="display:none;"' ?> id="formPoll" action="<?php echo $this->Html->url(array('controller' => 'polls', 'action' => 'submit', 'radioSlug' => $this->params['radioSlug'])); ?>.json">

        <div class="radio-group">

            <?php foreach ($options as $key => $option): ?>

            <div class="radio-listing">
                <span class="effect customBG"></span>
                <input type="radio" name="vote" value="<?php echo $key; ?>" id="vote-<?php echo $key; ?>"/>
                <label for="vote-<?php echo $key; ?>" class="liveT"><?php echo $option; ?></label>
            </div>

            <?php endforeach; ?>

        </div>

        <button type="submit" id="voteMe">
            <span class="text">Votar</span>
        </button>
        <span class="effect customBG voter"></span>

    </form>

    <div id="resultsPoll" <?php echo ($loggedIn) ? 'style="display:block;"' : 'style="display:none;"' ?>>

        <?php foreach ($answersPercentages as $key => $percentage): ?>

        <div>
            <span>
                <label 
                    for="vote-<?php echo $key; ?>" 
                    class="liveT"
                    data-model="Poll" 
                    data-foreign-key="<?php echo $radio['Poll']['id'];?>"
                    data-field="options"
                    data-type="vote"
                    data-position="<?php echo $key; ?>"
                >
                    <?php echo $options[$key]; ?>
                </label> - <b><?php echo $answers[$key]; ?> </b> (<?php echo $percentage; ?>%)
            </span>
            <div style="height: 10px;width:100%;background: #DBDADA;">
                <div style="height: 10px; width: <?php echo $percentage; ?>%;" class="customBG"></div>
            </div>
        </div>

        <?php endforeach; ?>

    </div>

</div>