<div class="content-wrapper">
    <div class="container-fluid">
        <?php if($status) { ?>
        <div class="alert alert-<?= $status['code'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?= $status['message'] ?>
        </div>
        <?php }  ?>
        <!-- Icon Cards-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-certificate"></i> Create Certificate
            </div>
            <div class="card-body">
                <div class="container">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'request-form',
                        'enableClientValidation'=>true,
                           'htmlOptions' => array('enctype' => 'multipart/form-data'),
                        'clientOptions'=>array(
                         'validateOnSubmit'=>true,
                        ),
                        )); 
                         ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-certificate"></i></span>
                                    <?php echo $form->textField($model,'name',array('class' => 'form-control',"placeholder"=>"Enter Certificate name ")); ?>                
                                </div>
                                <?php echo $form->error($model,'name'); ?>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-file"></i></span>
                                    <?php echo $form->fileField($model,'template_file',array('class' => 'form-control',"placeholder"=>"Enter Certificate Template")); ?>
                                </div>
                                <?php echo $form->error($model,'template_file'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-certificate"></i></span>
                                    <?php echo $form->textarea($model,'description',array('class' => 'form-control',"placeholder"=>"Enter Certificate description",'rows' => 3)); ?>
                                </div>
                                <?php echo $form->error($model,'description'); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-block" style="cursor: pointer;" type="submit">Create</button>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
        <!-- Icon Cards-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-certificate"></i> Manage Certificate
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group bg-default">
                        <button class="btn btn-primary" type="submit" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> <i class="fa fa-fw fa-plus"></i> Filters</button>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse col-md-12 <?= isset($status['code']) &&  $status['code'] == 'info' ? 'show' : ''  ?> ">
                        <div class="panel-body">
                            <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'request-form',
                                'enableClientValidation'=>true,
                                'clientOptions'=>array(
                                 'validateOnSubmit'=>true,
                                ),
                                )); 
                                 ?>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <input class="form-control"  type="text"  placeholder="Search By ID " name="filters[id]" value="<?= $filters['id'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" placeholder="Search By Certificate Name " name="filters[name]" value="<?= $filters['name'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" placeholder="Search By Certificate Name" name="filters[description]" value="<?= $filters['description'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary pull-right" style="margin-left: 10px" type="submit"> Search</button>
                                <a class="btn btn-danger pull-right" href="<?= $this->createUrl('site/index') ?>">Clear Filter</a>
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>ID</th>
                                    <th>Certificate Name</th>
                                    <th>Certificate Description</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;
                                    if(count($certificates) == 0) { ?>
                                <td colspan="5">No record found</td>
                                <?php 
                                    }
                                    foreach ($certificates as $key => $certificate) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $certificate->id ?></td>
                                    <td><?= $certificate->name ?></td>
                                    <td><?= $certificate->description ?></td>
                                    <td>
                                        <a href="<?= $this->createUrl('site/index/'.$certificate->id) ?>" class="btn btn-success"><i class="fa fa-fw fa-edit"></i> </a>
                                        <a class="btn btn-success" href="<?= $this->createUrl('site/configure/'.$certificate->id) ?>"><i class="fa fa-fw fa-cogs"></i></a>
                                        <a href="#" onclick="deleteCertificate(<?= $certificate->id  ?>)" class="btn btn-success"><i class="fa fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid-->
<script type="text/javascript">
    function deleteCertificate($id) {

        var response = confirm("Do you want to delete this certificate?");
        if (response == true) {
            window.location.href = "<?= $this->createUrl('site/delete/') ?>/"+$id;
        } else {
            console.log('cancel');
        } 
    }
</script>