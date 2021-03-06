<?php
    $this->pageTitle=Yii::app()->name . ' - Configure Certificate';   
    ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?php if($status) { ?>
        <div class="alert alert-<?= $status['code'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?= $status['message'] ?>
        </div>
        <?php }  ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <ul>
                <li>Drag the Marker Value to place it on its position</li>
                <li>Double click on placed marker value to remove</li>
                <li>Click submit to export in PDF</li>
            </ul>
        </div>
        <!-- Icon Cards-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-certificate"></i> Configure Certificate
            </div>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'request-form',
                'enableClientValidation'=>true,
                'htmlOptions'=>array(
                   'onsubmit'=>"return confirmSubmit()"
                 ),
                'clientOptions'=>array(
                 'validateOnSubmit'=>true,
                ),
                )); 
                ?>
            <div class="card-body">
                <input type="hidden" name="markers" id="jsonData" value="">
                <input type="hidden" name="imgWidth" id="imgWidth" value="">
                <input type="hidden" name="imgHeight" id="imgHeight" value="">
                <input type="hidden" name="imgWidthOriginal" id="imgWidthOriginal" value="">
                <div class="row image-panel">
                    <div class="col-md-6">
                        <img src="<?= Yii::app()->request->baseUrl;  ?>/images/certificates/<?=$certificate->template_file ?>.png" id="certificateImage">
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body" id="divDetails"></div>
                        </div>
                    </div>
                </div>
                <div id="konvaDiv" style="position: absolute;top: 68px;width: 100%;">
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<script src="https://cdn.rawgit.com/konvajs/konva/1.7.6/konva.min.js"></script>
<script type="text/javascript">
    function drawImage() {
       var width = $('.image-panel').width();
       var height = $('#certificateImage').height();
       var imgWidthOriginal = $('#certificateImage').width();
       $('#imgWidthOriginal').val(imgWidthOriginal);
       $('#certificateImage').css('width','100%');
       var imgWidth = $('#certificateImage').width();
       $('#imgWidth').val(imgWidth);
       $('#imgHeight').val(height);
       $('#divDetails').css('height',height);
    
     
       var stage = new Konva.Stage({
          container: 'konvaDiv',
          width: width,
          height: height
       });
       var layer = new Konva.Layer();
    
       var markers = $.parseJSON('<?= json_encode($markers) ?>');
    
       var x = stage.getWidth() / 2 + 15;
       var y = 15;
       $.each(markers,function(key,val){
    
          if(key == 5) {
             x = stage.getWidth() / 1.3;
             y = 15
          }
          var label = new Konva.Text({
             x: x,
             y: y,
             text: val.label,
             fontSize: 10,
             fill: val.color,
             padding: 20,
             align: 'center'
          });
    
          y = y+30;
          var marker = new Konva.Text({
             x: x,
             y: y,
             text: val.name,
             fontSize: val.font,
             // fontFamily: val.fontFamily,
             fill: val.color,
             draggable: true,
             padding: 20,
             align: 'center'
          });
          markers[key].default_x = x;
          markers[key].default_y = y;
          
          y = y + 50;
          marker.on("dragstart", function() {
             this.moveToTop();
             layer.draw();
         });
    
         marker.on("dragmove", function() {
             document.body.style.cursor = "pointer";
             var jsonData =  $.parseJSON(marker.toJSON());
             markers[key].x = jsonData.attrs.x;
             markers[key].y = jsonData.attrs.y;
             $('#jsonData').val(JSON.stringify(markers));
         });
    
         marker.on("dblclick dbltap", function() {
             this.position({
                x: markers[key].default_x,
                y: markers[key].default_y
             });
             layer.draw();
         });
    
         marker.on("mouseover", function() {
             document.body.style.cursor = "pointer";
         });
         marker.on("mouseout", function() {
             document.body.style.cursor = "default";
         });
    
         layer.add(label);
         layer.add(marker);
    
       });
    
       // add the layer to the stage
       stage.add(layer);
     }
     
   function confirmSubmit($id) {
      var response = confirm("Have you placed all markers on position? confirm to generate the certificate.");
      return response;
   }

   $(document).ready(function(){
      drawImage();
   });
</script>