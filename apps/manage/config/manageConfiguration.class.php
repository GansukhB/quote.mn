<?php

class manageConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    sfConfig::set('app_ckfinder_active', true);
  }
}
