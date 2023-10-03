
<div id="sec_<?= $count ?>" class="addpianospace draggable" style="margin-top: 25px;">
    <!--  <input type="hidden" name="section[]" value="<?= $count ?>"> -->
    <div class="row" style="margin-left:-48px;">
        <div class="col-sm-12" style="margin-bottom: -10px;">
            <div class="col-sm-8">
                <div class="col-sm-3">
                    <select name="section[]" class="form-control" id="section_<?= $count ?>">
                        <option value=""></option>
                        <option value="Whole song">Whole song</option>
                        <option value="Intro">Intro</option>
                        <option value="Verse">Verse</option>
                        <option value="Pre Chorus">Pre Chorus</option>
                        <option value="Chorus">Chorus</option>
                        <option value="Bridge">Bridge</option>
                        <option value="Outro">Outro</option>
                        <option value="Interlude">Interlude</option>
                    </select>  
                </div>
                <!-- <div class="col-sm-3">                                                           
                    <input type="text" name="same_as[]" style="font-family: Rounded_Medium;" id="same_as_<?= $count ?>" class="form-control" placeholder="Same As (ex: VERSE:1-10)">
                </div> -->
                <div class="col-sm-2">
                    <select name="same_as_1[]" class="form-control" id="same_as_1_<?= $count ?>">
                        <option value="">Same As</option>
                            <option value="Whole song">Whole song</option>
                            <option value="Intro">Intro</option>
                            <option value="Verse">Verse</option>
                            <option value="Pre Chorus">Pre Chorus</option>
                            <option value="Chorus">Chorus</option>
                            <option value="Bridge">Bridge</option>
                            <option value="Outro">Outro</option>
                            <option value="Interlude">Interlude</option>
                            <option value="Above">Above</option>
                    </select>                                                           
                </div>
                <div class="col-sm-2">
                    <input type="text" autocomplete="off" name="same_as_2[]" style="font-family: Rounded_Medium;" id="same_as_<?= $count ?>" class="form-control" placeholder="1-10">
                </div>
                <div class="col-sm-2" style="">
                    <input type="text" style="font-family: Rounded_Medium;" name="repetition[]" id="repetition_<?= $count ?>" class="form-control" placeholder="Repetition (ex: 2x)">
                </div>
                <div class="col-sm-3" style="margin-top: 5px;">    
                        <!-- <ol>
                            <il> -->
                                <a href="javascript:void(0);" id="remove_section_<?= $count ?>" onclick="remove_new_section(<?= $count ?>);"><span class="label label-danger" style="font-size: 15px;">Remove Section</span></a>
                            <!-- </il>
                       </ol> -->
                    
                       
                   
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-sm-12" style="float: right;">
                    <ol style="float: right;">
                       <!--  <il style="display: inline-block;margin-top: 10px;"> 
                            <a href="javascript:void(0);" id="remove_section_<?= $count ?>" onclick="add_new_section(<?= $count ?>,'before');"><span class="label label-success" style="font-size: 15px;background-color: #2E2E2E;">Add before </span></a> 
                        </il>
                        <il style="display: inline-block;margin-top: 10px;"> 
                            <a href="javascript:void(0);" id="remove_section_<?= $count ?>" onclick="add_new_section(<?= $count ?>,'after');"><span class="label label-success" style="font-size: 15px;">Add after</span></a>
                       </il>  -->
                         <!-- <il style="display: inline-block;margin-top: 10px;">  -->
                            <a href="javascript:void(0);" id="remove_section_<?= $count ?>" onclick="add_new_section(<?= $count ?>,'before');"><span class="label label-success" style="font-size: 15px;background-color: #2E2E2E;">Add before </span></a> 
                        <!-- </il> -->
                        <!-- <il style="display: inline-block;margin-top: 10px;">  -->
                            <a href="javascript:void(0);" id="remove_section_<?= $count ?>" onclick="add_new_section(<?= $count ?>,'after');"><span class="label label-success" style="font-size: 15px;">Add after</span></a>
                       <!-- </il> --> 
                   </ol>
                </div>                
            </div>
        </div>
    </div>
    <div class="overauto">
        <!--1 to 32-->
        <!-- <div class="row marin-zero">
            <label for="title" style="margin-left: 13px;" class="control-label">Melody</label>
            <div class="sixless">
                <div class="sixforbox">
                    <?php
                    $ph = 0;
                    for ($i = 1; $i <= 64; $i++)
                    {
                        if($i == 1 || $i == 17 || $i == 33 || $i == 49)
                        {
                            $ph++;
                        }
                        ?>
                        <div class="boxxnew_sl">
                            <input style="text-align: center; padding: 0 5px;font-family: Rounded_Medium;" type="text" name="sl<?= $i ?>[]" id="sl<?= $i ?>_<?= $count ?>" class="form-control" placeholder="<?= ($i == 1 || $i == 17 || $i == 33 || $i == 49) ? $ph : '' ?>">
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div> -->
        <div class="row marin-zero">
            <label for="title" style="margin-left: 13px;" class="control-label">Progression</label>
            <div class="sixbox">
                <?php
                $ph = 0;
                for ($i = 1; $i <= 16; $i++)
                {
                    if($i == 1 || $i == 5 || $i == 9 || $i == 13)
                    {
                        $ph++;
                    }
                    if($i == 1 || $i == 5 || $i == 9 || $i == 13)
                    {
                        $c = 'boxxnew_fl_line';
                    }
                    else{
                        $c = 'boxxnew_fl';
                    }
                    ?>
                    <div class="<?= $c ?>">
                        <input type="text" name="fl<?= $i ?>[]" id="fl<?= $i ?>_<?= $count ?>" class="form-control" placeholder="<?= ($i == 1 || $i == 5 || $i == 9 || $i == 13) ? $ph : '' ?>" style="font-family: Rounded_Medium;">
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        
    </div>
</div>