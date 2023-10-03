<footer id="footer" class="app-footer" role="footer">

    <div class="wrapper b-t bg-light">

        <span class="pull-right"><a href ui-scroll="app" class="m-l-sm text-muted"><i class="fa fa-long-arrow-up"></i></a></span>

        copyright@<?= date('Y'); ?>

    </div>

</footer>

</div>



<script src="<?= base_url('admintheme') ?>/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>

<script src="<?= base_url('admintheme') ?>/js/ui-load.js"></script>

<script src="<?= base_url('admintheme') ?>/js/ui-jp.config.js"></script>

<script src="<?= base_url('admintheme') ?>/js/ui-jp.js"></script>

<script src="<?= base_url('admintheme') ?>/js/ui-nav.js"></script>

<script src="<?= base_url('admintheme') ?>/js/ui-toggle.js"></script>

<script src="<?= base_url('admintheme') ?>/js/ui-client.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.0/moment.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>





<script type="text/javascript">

    $(function () {

        $("img.lazy").lazyload({

            event: "sporty"

        });

    });



</script>

<script type="text/javascript">
  $(function() {
// setTimeout() function will be fired after page is loaded
// it will wait for 5 sec. and then will fire
// $("#successMessage").hide() function
var timeout = 3000;
$('.alert').delay(timeout).fadeOut(300);

});
</script>





</body>

</html>

