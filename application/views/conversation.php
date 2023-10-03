<?php include('header.php') ?>
<?php include('sidebar.php') ?>
<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!-- content -->
<style>
   /* .container {
        width: 1000px;
    }*/

    body
    {
        overflow: hidden;
    }

    @media (max-width: 767px){
        body
        {
            overflow: hidden;
            height: 100vh;
            min-height: 100vh;
        }

    }
    


    .chat
    {
        height: calc(100vh - 307px) !important;
    }

    .hbox
    {
        height: auto !important;
    }
</style>
<div id="content" class="app-content" role="main">
    
    <div class="app-content-body ">
        <div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="app.settings.asideFolded = false; app.settings.asideDock = false;">
            <div class="col">
                <div class="bg-light lter b-b wrapper-md">
                    <h1 class="m-n font-thin h3"><?=$user['name'];?></h1>
                </div>
                <div class="panel panel-default">
                    <?php
                    if ($this->session->flashdata('error')) {
                        echo '<div class="alert alert-danger">';
                        echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';
                        echo $this->session->flashdata('error');
                        echo '</div>';
                    }
                    if ($this->session->flashdata('warning')) {
                        echo '<div class="alert alert-warning">';
                        echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';
                        echo $this->session->flashdata('warning');
                        echo '</div>';
                    }
                    if ($this->session->flashdata('success')) {
                        echo '<div class="alert alert-success">';
                        echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';
                        echo $this->session->flashdata('success');
                        echo '</div>';
                    }
                    ?>
                    <?php
                    if (validation_errors() != null) {
                        echo '<div class="alert alert-danger">';
                        echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';
                        echo validation_errors();
                        echo '</div>';
                    }

                    if (isset($custome_error) && $custome_error != null) {
                        echo '<div class="alert alert-warning">';
                        echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';
                        echo $custome_error;
                        echo '</div>';
                    }
                    ?>
                    <script>
                        window.onload = function () {
                            var element = document.getElementById("chat");
                            element.scrollTop = element.scrollHeight;
                        };
                    </script>
                    <input type="hidden" name="id" id="id" value="<?=$this->uri->segment(3)?>">
                    <input type="hidden" name="user_id" id="user_id" value="<?= $user['id'] ?>">
                    <div class="table-responsive">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" style='color:black'>
                                            <span class="glyphicon glyphicon-comment"></span>
                                            Chat
                                        </div>
                                        <div class="panel-body" onload="updateScroll()">
                                            <ul class="chat" id='chat' style="overflow-y: scroll; height:100vh;">
                                                <?php
                                                $msg_id = 0;
                                                $tt = 0;
                                                foreach($messages as $d)
                                                {
                                                if($d['sent_by'] == 1)
                                                {
                                                ?>
                                                <li class="left clearfix">
                                                    <div class="chat-body clearfix">
                                                        <div class="header" style="padding:15px;">
                                                            <strong class="primary-font"><?=$user['name'];?></strong>
                                                            <small class="pull-right text-muted">
                                                                <?=$d['created_at'];?></small>
                                                        </div>
                                                        <p>
                                                            <?=nl2br($d['message']);?>
                                                        </p>
                                                    </div>
                                                </li>
                                                <hr/>
                                                <?php
                                                }
                                                else
                                                {
                                                ?>
                                                <li class="right clearfix" style="padding:15px;">
                                                    <div class="chat-body clearfix">
                                                        <div class="header">
                                                            <small class=" text-muted">
                                                                <?=$d['created_at'];?></small>
                                                            <strong class="pull-right primary-font">Admin</strong>
                                                        </div>
                                                        <p class="pull-right">
                                                            <?= nl2br($d['message']);?>
                                                        </p>
                                                    </div>
                                                </li>
                                                <hr/>
                                                <?php
                                                }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="input-group">
                                                <!-- <input id="newmsginput" type="text" class="form-control input-sm" placeholder="Type your message here..."/> -->
                                                <textarea id="newmsginput" class="form-control input-sm" rows="1" style="white-space: pre-wrap;" placeholder="Type your message here..."></textarea>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-warning btn-sm" id="btn-chat" onclick="sendmsg(<?=$user['id'];?>)">
                                                        Send</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function sendmsg(user_id) {
        var msg = document.getElementById("newmsginput").value;
        if (msg != '') {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function (data) {
                if (this.readyState == 4 && this.status == 200) {

                    var html = '<li class="right clearfix" style="padding:15px;">' +
                        '                                                        <div class="chat-body clearfix">' +
                        '                                                            <div class="header">' +
                        '                                                                <small class=" text-muted">' +
                        '                                                                    <?=date('Y-m-d H:i:s')?></small>'+
'                                                                <strong class="pull-right primary-font">Admin</strong>'+
'                                                            </div>'+
'                                                            <p class="pull-right">'+
'                                                                '+msg.replace(/\n/g, '<br/>')+
'                                                            </p>'+
'                                                        </div>'+
'                                                    </li>';
    

                    $('#chat').append(html);
                    $('#newmsginput').val('');
                    $("#chat").scrollTop($("#chat")[0].scrollHeight);
                    //location.reload();
                }
            };
            xmlhttp.open("GET", '<?php echo base_url() . "Chat/sendmsg/?user_id="; ?>' + user_id + '&msg=' + encodeURI(msg), true);
            xmlhttp.send();
        } else {
            $("#newmsginput").css('border','2px solid red');
        }
    }

    $('#newmsginput').keypress(function (e) {
        var key = e.which;
        $("#newmsginput").css('border','');
       /* if(key == 13)
        { 
            $('#btn-chat').click(); return false; 
        }*/
    });

    execComc1();

    function execComc1() {
        setTimeout(function () {
            var id = $('#user_id').val();            
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText && this.responseText != '' && this.responseText != 0) {
                        //window.location.href = "<?php echo base_url(); ?>notification/viewmsg/" + id;
                        // location.reload();
                        $('#chat').append(this.responseText);
                        $("#chat").scrollTop($("#chat")[0].scrollHeight);
                    }
                }
            };
            xmlhttp.open("GET", '<?php echo base_url() . "Chat/getnewmsg/"; ?>'+id, true);
            xmlhttp.send();
            execComc1();
        }, 5000);
        return true;
    }
</script>
<!-- /content -->
<?php include('footer.php') ?>