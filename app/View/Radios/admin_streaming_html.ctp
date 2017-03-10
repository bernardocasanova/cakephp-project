<div class="form-group">

    <div class="col-sm-offset-1 col-sm-2">
        <input name="data[Streaming][<?php echo $index; ?>][name]" class="form-control" placeholder="nome do streaming" data-validate="required,maxlength[100]" data-message-required="Campo obrigatório." data-message-maxlength="O campo não pode ter mais de 100 caracteres." maxlength="100" type="text" id="StreamingName<?php echo $index; ?>">
    </div>

    <div class="col-sm-2">
        <input name="data[Streaming][<?php echo $index; ?>][url]" class="form-control" placeholder="url do streaming" data-validate="required,maxlength[200]" data-message-required="Campo obrigatório." data-message-maxlength="O campo não pode ter mais de 200 caracteres." maxlength="200" type="text" id="StreamingUr<?php echo $index; ?>">
    </div>

    <div class="col-sm-2">
        <select name="data[Streaming][<?php echo $index; ?>][type]" class="form-control" data-validate="required" data-message-required="Campo obrigatório." id="StreamingType<?php echo $index; ?>" aria-invalid="false">
            <option value="" disabled selected>tipo</option>
            <?php foreach ($types as $type): ?>
            <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-sm-2">
        <button type="button" class="btn btn-red remove-streaming"><i class="entypo-trash"></i></button>
    </div>

</div>