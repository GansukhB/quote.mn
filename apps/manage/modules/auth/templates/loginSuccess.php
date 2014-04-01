
<div class="container">
    <div class="row">

        
        <div class="col-md-4 col-sm-6">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Нэвтрэх хэсэг</h3>
                </div>
                <div class="panel-body">
                   <form action="<?php echo url_for('auth/login') ?>" method="post" novalidate="novalidate">
                  

                    <?php
                    if ($sf_user->getFlash('error')) {
                        ?>                                
                        <div class="alert alert-danger">
                            <button class="close" data-dismiss="alert"></button>
                            <span><?php echo $sf_user->getFlash('error'); ?>
                                <?php
                                echo $form->renderGlobalErrors();
                                if ($form['username']->renderError()) {
                                    echo"<div class='error'>";
                                    echo $form['username']->getError();
                                    echo"</div>";
                                }
                                if ($form['password']->renderError()) {
                                    echo"<div class='error'>";
                                    echo $form['password']->getError();
                                    echo"</div>";
                                }
                                ?>
                            </span>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="form-group">
                        <?php echo $form['username']->render(array('value' => $sf_user->getFlash('username'))); ?>
                    </div>

                    <div class="form-group">
                        <?php echo $form['password'] ?>
                        <?php echo $form->renderHiddenFields() ?>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-danger ">
                            Нэвтрэх 
                        </button>            
                    </div>
                </form>
                </div>
            </div>

            

        </div>

        <div class="col-md-8">

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <hr />
            EasyTune.MN &copy; 2014
        </div>
    </div>
</div>
