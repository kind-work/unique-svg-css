<?php

namespace KindWork\UniqueSvgCss;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider {
  protected $modifiers = [
    Modifiers\UniqueSvgCssModifier::class
  ];

  public function boot() {
    parent::boot();
  }
}
