<?php include('header.php') ?>

<?php include('sidebar.php') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style>
    .form-control::-webkit-input-placeholder { color:#595959; }

    .header_textbox .form-control::-webkit-input-placeholder { color:#808080; }
    input::placeholder {
  color: #00c053;
  font-weight: 700;
  font-style: bold;
}

    
    
     @font-face {
      font-family: Rounded_Medium;
      src: url(http://18.235.99.234/piano/Admin/upload/SF-Pro-Rounded-Medium.ttf);
    }

   input[type="text"]
    {
     font-family: 'Source Sans Pro';

      font-style: normal;

      font-weight: 700;

      font-size: 15px;
    }
    input[type="submit"]
    {
     font-family: 'Source Sans Pro';

      font-style: normal;

      font-weight: 700;

      font-size: 14px;
    }

    button[type="button"]
    {
     font-family: 'Source Sans Pro';

      font-style: normal;

      font-weight: 700;

      font-size: 14px;
    }

    label
    {
     font-family: 'Source Sans Pro';

      font-style: normal;

      font-weight: 700;

      font-size: 14px;
    }
    .font-thin {
        font-family: 'Source Sans Pro';

      font-style: normal;

      font-weight: 700;
    }

    .boxxnew_fl
    {
        width: 110px;
    }
    .boxxnew_fl_line
    {
        width: 110px;
    }
    .boxxnew_sl
    {
        width: 30px;
        margin-right: 0px;
    }
    .wrapper{
        display: inline-flex;
        /*background: #fff;
        height: 100px;
        width: 400px;*/
        align-items: center;
        justify-content: space-evenly;
        padding: 1px;
        /*border-radius: 5px;
        padding: 20px 15px;
        box-shadow: 5px 5px 30px rgba(0,0,0,0.2);*/
    }
    .wrapper .option{
        /*background: #fff;*/
        background: #474747;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        margin: 0 10px;
        border-radius: 5px;
        cursor: pointer;
        padding: 0 10px;
        /*border: 2px solid lightgrey;*/
        border: 2px solid #333333;
        transition: all 0.3s ease;
    }
    .wrapper .option .dot{
        height: 20px;
        width: 20px;
        background: #d9d9d9;
        border-radius: 50%;
        position: relative;
    }
    .wrapper .option .dot::before{
        position: absolute;
        content: "";
        top: 4px;
        left: 4px;
        width: 12px;
        height: 12px;
        background: #00c053;
        border-radius: 50%;
        opacity: 0;
        transform: scale(1.5);
        transition: all 0.3s ease;
    }
    input[type="radio"]{
        display: none;
    }
    #major:checked:checked ~ .major,
    #minor:checked:checked ~ .minor{
        border-color: #00c053;
        background: #00c053;
    }
    #major:checked:checked ~ .major .dot,
    #minor:checked:checked ~ .minor .dot{
        background: #fff;
    }
    #major:checked:checked ~ .major .dot::before,
    #minor:checked:checked ~ .minor .dot::before{
        opacity: 1;
        transform: scale(1);
    }
    .wrapper .option span{
        font-size: 14px;
        color: #ffffff;
    }
    #major:checked:checked ~ .major span,
    #minor:checked:checked ~ .minor span{
        color: #fff;
    }
    .wrapper-md {
        padding: 3px !important;
    }
    .btn-primary {
        color: #ffffff !important;
        background-color: #00c053;
        border-color: #00c053;
    }
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary {
        color: #ffffff !important;
        background-color: #00c053;
        border-color: #00c053;
    }

    .sixbox
    {
        display: flex; 
        justify-content: space-around;
    }

    .sixforbox
    {
        display: flex; 
        justify-content: 
        space-around;
    }

    @media only screen and (max-width: 768px) {
      /* For mobile phones: */
       .major{
            text-align: left !important;
            display: flex !important;
        }

        .wrapper .option{
            margin: 0 2px;
        }
    }

    @media only screen and (max-width: 1250px) {
      .overauto
      {
            overflow: auto;
            width: 100%;
      }
      .boxxnew_sl
      {
        min-width: 32px;
      }

      .boxxnew_fl
      {
        min-width: 128px;
      }
      .boxxnew_fl_line
      {
        min-width: 128px;
      }
      .sixbox
      {
            display: flex;
             justify-content: inherit;
            margin-left: 15px;
      }

      .sixforbox
        {
            justify-content: inherit;
            margin-left: 17px;
        }

        .panel-body
        {
            padding: 15px 15px 15px 0;
        }

        .sixless
        {
                margin-left: -17px !important;
                margin-right: 6px !important;
        }

        .row.marin-zero
        {
            margin-right: 0 !important;
            margin-left: 0 !important;
        }


    }
    .btn-sm, .btn-group-sm > .btn {
    padding: 5px 10px;
    font-size: 14px;
    line-height: 1.5;
    border-radius: 3px;
}

.panel-heading {
    padding: 10px 0px;
}
.badge, .label {
    text-shadow: none !important;
}

.boxxnew_fl_line {
    width: 110px;
    position: relative;
}

.boxxnew_fl_line:before {
    content: '';
    position: absolute;
    width: 5px;
    height: 23px;
    bottom: 20px;
    left: 0px;
    background: #fff;
    border-radius: 5px;
    /* margin-top: 5px; */
}
.boxxnew_fl_line input {
    position: relative;
    border-right: 1px solid black;
}

.boxxnew_fl input {
    border-right: 1px solid black;
}
.sixless
{
    margin-left: -9px;
    margin-right: 6px;
}

.addpianospace
{
    margin-top: 30px;
}

.draggable 
  { 
    
    cursor: move;
    
  }

  .form-control {
    border-color: #2E2E2E ;
    border-radius: 1px ;
    color: #D9D9D9 ;
    background-color: #2E2E2E ;
    border: none ;
    -webkit-box-shadow: none ;
     box-shadow: none ;
     border-radius: 5px;
}
.boxxnew_sl input {
    border-right: 1px solid black;
}
</style>
<style>

</style>

    <script src="<?=base_url('admintheme')?>/ckeditor/ckeditor.js"></script>

    <script src="<?=base_url('admintheme')?>/ckeditor/samples/js/sample.js"></script>

    <!-- content -->

    <div id="content" class="app-content" role="main">

        <div class="app-content-body ">

            <div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="

    app.settings.asideFolded = false;

    app.settings.asideDock = false;

  ">

            </div>

            <!-- main -->

            <div class="col">
                <div class="bg-light lter b-b wrapper-md">
                    <h1 class="m-n font-thin h3">Add Track</h1>
                </div>

                <div class="wrapper-md" ng-controller="FlotChartDemoCtrl">

                    <div class="row">

                        <div class="col-sm-12">

                            <form style="padding: 0 10px 0px 10px; background: #000;" name="tracks" id="track_form" action="<?=base_url().'track/'?><?php if($this->uri->segment('2') == "editTrack"){echo "editTrack/".$this->uri->segment('3');}else{echo "addTrack";} ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <input type="hidden" name="section_count" id="section_count" value="1" />
                                <input type="hidden" name="track_id" id="track_id" value="" />
                                <div class="panel-heading font-bold" style="background-color: #333333;color: white;margin-left: -9px;margin-right: -9px;">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="col-sm-6 header_textbox">
                                                <input type="text" style="border-color: #474747;background-color: #474747;color: #D9D9D9;"  required name="title" id="title" style="" class="form-control" placeholder="Title">
                                            </div>
                                            <div class="col-sm-3 header_textbox"> <input autocomplete="off" type="text" style="border-color: #474747;background-color: #474747;color: #D9D9D9;" required name="artist" id="artist" class="form-control" placeholder="Artist">
                                            </div>
                                            <div class="col-sm-3 header_textbox"> 
                                                <input type="text" style="border-color: #474747;background-color: #474747;color: #D9D9D9;" autocomplete="off" name="structure" id="structure" class="form-control" placeholder="Structure">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 major" style="text-align: right;">
                                            <div class="col-sm-7">
                                                <div class="wrapper">
                                                    <input type="radio" name="type" value="MAJOR" id="major" checked>
                                                    <input type="radio" name="type" value="MINOR" id="minor">
                                                    <label for="major" class="option major">
                                                        <span>MAJOR</span>
                                                    </label>
                                                    <label for="minor" class="option minor">
                                                        <span>MINOR</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-5 header_textbox" style="margin-left: -10px;"> <input type="text" style="border-color: #474747;background-color: #474747;color: #D9D9D9;" autocomplete="off"  name="original_key" class="form-control" placeholder="Original Key">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" style="background-color: #000000;color: white;">
                                    <div class="section droppable" id="section_html">
                                        <div id="sec_1" class="addpianospace draggable">
                                            <div class="row" style="margin-left:-48px;">
                                                <div class="col-sm-12" >
                                                    <div class="col-sm-6">
                                                        <div class="col-sm-4">
                                                            <!-- <input type="text" autocomplete="off" name="section[]" style="text-transform:uppercase;font-family: Rounded_Medium;" id="section_1" class="form-control" placeholder="Section (ex: Intro, Verse, Pre- Chorus, Chorus)">   -->

                                                            <select name="section[]" class="form-control" id="section_1">
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
                                                        <div class="col-sm-2">
                                                            <select name="same_as_1[]" class="form-control" id="same_as_1_1">
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
                                                            <input type="text" autocomplete="off" name="same_as_2[]" style="font-family: Rounded_Medium;" id="same_as_2" class="form-control" placeholder="1-10">
                                                        </div>
                                                        <div class="col-sm-4" style="">
                                                            <input type="text" style="font-family: Rounded_Medium;" autocomplete="off" name="repetition[]" id="repetition_1" class="form-control" placeholder="Repetition (ex: 2x)">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="col-sm-3" style="float: right;">
                                                            <a href="javascript:void(0);" onclick="add_new_section(1,'after');"><span class="label label-success" style="font-size: 14px;background-color: #00c053;">Add Section</span></a>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="overauto">
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
                                                                    <input style="text-align: center; padding: 0 5px;height: 30px;font-family: Rounded_Medium;" type="text" name="sl<?= $i ?>[]" class="form-control" id="sl<?= $i ?>_1" placeholder="<?= ($i == 1 || $i == 17 || $i == 33 || $i == 49) ? $ph : '' ?>" autocomplete="off" >
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
                                                            <input type="text" autocomplete="off" name="fl<?= $i ?>[]" id="fl<?= $i ?>_1" class="form-control" placeholder="<?= ($i==1 || $i==5 || $i==9 || $i==13) ? $ph : '' ?>" style="height: 30px;font-family: Rounded_Medium;">
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                            <!--1 to 64-->
                                           
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!-- <div style="margin-top: 15px;">
                                        <div class="row" style="margin-left: -35px;">
                                            <div class="col-sm-6">
                                                <div class="col-sm-4">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div style="margin-top: 25px;text-align: center; ">
                                        <input type="submit" name="submit" value="Submit & publish" class="btn btn-sm btn-primary"/>

                                        <button type="button" name="cancel" class="btn btn-sm btn-primary" onClick="window.location.href='<?=base_url().'track'?>'">Cancel</button>

                                        <button type="button" name="cancel" style="background-color: #333333;border-color: #333333;" class="btn btn-sm btn-primary" onClick="save_draft();">Save as a Draft</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel panel-default">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- /content -->
<script type="text/javascript">
     $('input').keydown(function(e) {
    if (e.keyCode==40) {
        $(this).next('input').focus();
    }
});

$('input').keydown(function(e) {
    if (e.keyCode==38) {
        $(this).prevAll('input[type=text]').first().focus();
    }
});
    function add_new_section(section,position)
    {
        var count = $('#section_count').val();
        $.ajax({
            url:'<?=base_url()?>Track/add_section',
            type: "POST",
            data: {
                'count':count
            },
            success: function(html){
                //window.location.reload();
                //document.getElementById('section_html').innerHTML += html;
                //$("#section_html").append(html);
                //$('#section_count').val(parseInt(count) + 1);

                if(section > 0){
                    // debugger;
                    // console.log(section)

                    if(position=='after'){
                        $(html).insertAfter("#sec_"+section);
                        // debugger;
                    }else if(position=='before'){
                        $(html).insertBefore("#sec_"+section);   
                        // debugger;
                    }
                    
                }else{
                    debugger;
                    $("#section_html").append(html);    
                }
                $('#section_count').val(parseInt(count) + 1);
            }
        });
    }

    function save_draft(){
       
        var title = $('#title').val();
        var author = $('#artist').val();
        var track_id = $('#track_id').val();
 
            if(title != "" && author != ""){
                $.ajax({
                url: '<?=base_url()?>Track/save_draft',
                type: 'POST',
                data: $('#track_form').serialize(),
                dattype: 'html',
                success: function(data){
                    console.log(data);
                    if(data != ""){
                        $('#track_id').val(data);
                        toastr.success('Track saved as draft successfully.');
                    }
                }
            });
        }
        else{
            toastr.error('Please fill proper detail.');
        }
    }

    function remove_new_section(section)
    {
        var count = $('#section_count').val();
        //$('#section_count').val(parseInt(count) - 1);
        $('#sec_'+section).remove();


        /*for(var i = section + 1;i <= 100;i++)
        {
            var previous = i - 1;
            if($('#sec_'+i).length){
                $("#sec_"+i).attr("id", 'sec_'+previous);

                $("#section_"+i).attr("name", 'section_'+previous);
                $("#repetition_"+i).attr("name", 'repetition_'+previous);
                $("#section_"+i).attr("id", 'section_'+previous);
                $("#repetition_"+i).attr("id", 'repetition_'+previous);


                $("#remove_section_"+i).attr("onclick", 'remove_new_section('+ previous +');');
                $("#remove_section_"+i).attr("id", 'remove_section_'+ previous);

                //change id,name of first line
                for(var fl = 1;fl <= 16;fl++)
                {
                    $("#fl"+fl+'_'+i).attr("name", 'fl'+fl+'_'+previous);
                    $("#fl"+fl+'_'+i).attr("id", 'fl'+fl+'_'+previous);
                }

                //change id,name of second line
                for(var sl = 1;sl <= 64;sl++)
                {
                    $("#sl"+sl+'_'+i).attr("name", 'sl'+sl+'_'+previous);
                    $("#sl"+sl+'_'+i).attr("id", 'sl'+sl+'_'+previous);
                }
            }else{
                break;
            }
        }*/

    }


</script>
<script>
  $(document).ready(function() {
    $(".droppable").sortable({
      update: function( event, ui ) {
        Dropped();
      }
    });
  });
    

  
    function Dropped(event, ui){
      $(".draggable").each(function(){
    //var p = $(this).position();
      });
      refresh();
    }
  
    
  
  </script>
<?php include('footer.php') ?>