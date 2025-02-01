<?php $__env->startSection('footer'); ?>

    <script>

        function toogleOptions(){

            if($('#is_free').val()=='0'){
                $('.amount').show();
                console.log('not free');
            }
            else{
                $('.amount').hide();
                console.log('is free');
            }
        }

        $(function(){
            toogleOptions();
            $('#is_free').change(function(){
                toogleOptions();
            })
        })
    </script>
<?php $__env->stopSection(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/plans/form-logic.blade.php ENDPATH**/ ?>