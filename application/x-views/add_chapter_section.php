<?php
if ($unlimited == 'yes') {
    if ($type == 'media') {
        ?>
            <div id="sec_unlimited_<?= $count ?>" class="addpianospace unlimited_draggable" style="border: 2px solid #000000;padding: 50px;margin: 15px;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <input type="file" name="key_media[]"  required accept="image/*,video/*" id="<?= $count ?>">
                            <input type="hidden" name="old_key_media[]" value="">
                        </div>
                        <div class="col-sm-8" style="margin-top: 5px;">
                            <div class="col-sm-2">
                                <img src="" style="display: none;margin-top: 10px;height: 100px;width: 150px;" class="img-thumbnail sec_<?= $count ?>" />
                            </div>
                            <div class="col-sm-7">
                                <label for="title" class="col-sm-3 control-label">Type<span class="text-primary"
                                                style="color:#a94442;">*</span></label>
                                <select class="form-control" name="image_type[]" style="width:55%" required>
                                    <option value="">Select</option>
                                    <option value="minor">Minor</option>
                                    <option value="major">Major</option>
                                </select>
                            </div>
                            <a href="javascript:void(0);" id="remove_section_<?= $count ?>" onclick="remove_unlimited_new_section(<?= $count ?>);" style="float: right;"><span class="label label-danger" style="font-size: 15px;">Remove Section</span></a>
                            
                            
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
}else if ($reco == 'yes') {
    if ($type == 'media') { ?>
            <div id="sec_reco_<?= $count ?>" class="addpianospace reco_draggable" style="border: 2px solid #000000;padding: 50px;margin: 15px;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <input type="file" name="reco_media[]"  required accept="image/*,video/*" id="<?= $count ?>">
                            <input type="hidden" name="old_reco_media[]" value="">
                        </div>
                        <div class="col-sm-6" style="margin-top: 5px;">
                            <img src="" style="display: none;margin-top: 10px;height: 100px;width: 150px;" class="img-thumbnail sec_<?= $count ?>" />
                            <a href="javascript:void(0);" id="remove_section_<?= $count ?>" onclick="remove_reco_section(<?= $count ?>);" style="float: right;"><span class="label label-danger" style="font-size: 15px;">Remove Section</span></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
}else{
    if ($type == 'media') {
        ?>
            <div id="sec_<?= $count ?>" class="addpianospace draggable" style="border: 2px solid #000000;padding: 50px;margin: 15px;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <input type="file" name="media[]"  required accept="image/*,video/*" id="<?= $count ?>">
                            <input type="hidden" name="old_media[]" value="">
                        </div>
                        <div class="col-sm-6" style="margin-top: 5px;">
                            <img src="" style="display: none;margin-top: 10px;height: 100px;width: 150px;" class="img-thumbnail sec_<?= $count ?>" />
                            <a href="javascript:void(0);" id="remove_section_<?= $count ?>" onclick="remove_new_section(<?= $count ?>);" style="float: right;"><span class="label label-danger" style="font-size: 15px;">Remove Section</span></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php }else if($type == 'metronome'){ ?>
            <div id="sec_<?= $count ?>" class="addpianospace draggable" style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <!-- <input type="text" name="metronome" class="form-control" placeholder="Metronome Name" required> -->
                            <span name="metronome" value="Metronome inside">Metronome inside</span>
                        </div>
                        <input type="hidden" name="metronome_at" id="metronome_sec_<?= $count ?>" value="<?= $count ?>">
                        <div class="col-sm-6" style="margin-top: 5px;">
                            <a href="javascript:void(0);" id="remove_section_<?= $count ?>" onclick="remove_new_section(<?= $count ?>);" style="float: right;"><span class="label label-danger" style="font-size: 15px;" onclick="someFunction('metronome')">Remove Section</span></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else if($type == 'lession_question'){ ?>
            <div id="sec_<?= $count ?>" class="addpianospace draggable" style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <!-- <input type="text" name="metronome" class="form-control" placeholder="Metronome Name" required> -->
                            <span name="metronome" value="Metronome inside">Question inside</span>
                        </div>
                        <input type="hidden" name="question_at" id="question_sec_<?= $count ?>" value="<?= $count ?>">
                        <div class="col-sm-6" style="margin-top: 5px;">
                            <a href="javascript:void(0);" id="remove_section_<?= $count ?>" onclick="remove_new_section(<?= $count ?>);" style="float: right;"><span class="label label-danger" style="font-size: 15px;" onclick="someFunction('question')">Remove Section</span></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div id="sec_<?= $count ?>" class="addpianospace draggable" style="border: 2px solid #000000;padding: 50px;margin: 15px;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <input type="text" name="button" class="form-control" placeholder="Button Name" required>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="note" class="form-control" placeholder="Note" required>
                        </div>
                        <input type="hidden" name="button_at" id="button_sec_<?= $count ?>" value="<?= $count ?>">
                        <div class="col-sm-4" style="margin-top: 5px;">
                            <!-- <ol>
                                <il> -->
                            <a href="javascript:void(0);" id="remove_section_<?= $count ?>" onclick="remove_new_section(<?= $count ?>);" style="float: right;"><span class="label label-danger" style="font-size: 15px;">Remove Section</span></a>
                            <!-- </il>
                           </ol> -->
                        </div>
                    </div>
                </div>
            </div>
        
        <?php } 
}
?>

<?php
