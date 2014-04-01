
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo url_for('@homepage'); ?>">Quote.MN</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                  <?php if($sf_user->isAuthenticated()): ?>
                    <ul class="nav navbar-nav">
                        <li class="<?php echo $sf_params->get('module') == 'page' ? 'active' : ''; ?>"><a href="<?php echo url_for('page/index'); ?>">Цэс</a></li>
                        <?php 
                            $news_module_array = array('post', 'post_category', 'comment');
                        ?>
                        <li class="dropdown <?php echo in_array($sf_params->get('module'), $news_module_array) || $sf_params->get('model_name') == 'post' ? 'active' : ''; ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Мэдээ <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            <li><a href="<?php echo url_for('post/index'); ?>">Жагсаалт</a></li>
                            <li><a href="<?php echo url_for('post/new'); ?>">Шинэ мэдээ оруулах</a></li>
                            
                            <li class="divider"></li>
                            <li><a href="<?php echo url_for('category/index?model_name=post'); ?>">Мэдээний төрлүүд</a></li>
                            <!--
                            <li class="divider"></li>
                            <li><a href="<?php echo url_for('comments/index'); ?>">Сэтгэгдлүүд</a></li>
                            -->
                            </ul>
                        </li>
                        <?php 
                            $quote_module_array = array('quote', 'quote_category', 'quote_author', 'quote_author_type');
                        ?>
                        <li class="dropdown <?php echo in_array($sf_params->get('module'), $news_module_array)  ? 'active' : ''; ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Quote <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            <li><a href="<?php echo url_for('quote/index'); ?>">Quote</a></li>
                            <li><a href="<?php echo url_for('quote_category/index'); ?>">Quote category</a></li>
                            
                            <li class="divider"></li>
                            <li><a href="<?php echo url_for('quote_author/index'); ?>">Quote author</a></li>
                            <li><a href="<?php echo url_for('quote_author_type/index'); ?>">Quote author type</a></li>
                            
                            </ul>
                        </li>
                    </ul>
                    
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $sf_user->getId(); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo url_for('auth/logout'); ?>">Гарах</a></li>
                            </ul>
                        </li>
                    </ul>
                  <?php endif; ?>
                </div><!-- /.navbar-collapse -->
               
            </div>




        </div>
    </div>
</nav>
<?php if($sf_user->hasFlash('alert')): ?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="alert alert-<?php echo $sf_user->getFlash('alert'); ?>">
                <?php 
                     echo $sf_user->getFlash('message');
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
