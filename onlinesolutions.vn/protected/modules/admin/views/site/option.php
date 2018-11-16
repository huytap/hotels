<?php
$this->widget('CssWidget');?>
<body>
<div class="modal fade in" tabindex="-1" role="dialog" style="display:block;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span id="close" aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Hotel Brand</h4>
      </div>
      <div class="modal-body">
       <ul class="list-group">
  
      <?php foreach($hotels as $key=>$hotel){
        echo '<li class="list-group-item" data-id="'.$key.'">'.$hotel.'</li>';
      }?>
      </ul>
      <form method="post" id="frm">
      <input type="hidden" name="hotel" id="hotel">
      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->widget('FooterWidget');?>
<style type="text/css">
  ul li{
    text-transform: uppercase;
    cursor: pointer;
  }
</style>
<script type="text/javascript">
  $('ul').find('li').click(function(){
    $('#hotel').val(($(this).attr('data-id')))
    $('#frm').submit()
  })

  $('#close').click(function(){
    location.href="<?php echo Yii::app()->createUrl('admin/site/logout')?>";
  })
</script>