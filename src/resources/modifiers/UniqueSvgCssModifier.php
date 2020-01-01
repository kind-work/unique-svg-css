<?php

namespace KindWork\UniqueSvgCss\Modifiers;

use Statamic\Modifiers\Modifier;

class UniqueSvgCssModifier extends Modifier {
  protected static $handle = 'unique_svg_css';

  public function index($value) {
    // Make a unique string by hashing the content
    $uniq = md5($value);

    // find any inline css classes and add - and uniq data attributes to the selector
    // this needs to work with spaces, without spaces on comma seperated lists of classes
    // this also needs to not find attributes that look similar in the svg
    preg_match('/(?<=<style>)(.+)(?=<\/style>)/usm', $value, $result);    

    if (count($result) > 0) {
      $replace = preg_replace('/(?<=[.]{1})([\\w_:-]+)(?=[{,\\s\\.]{1})/u', '$1[data-' . $uniq . ']', $result[0]);
      $value = preg_replace('/(?<=<style>)(.+)(?=<\/style>)/usm', $replace, $value);
    }
    
    if (count($result) < 1) {
      preg_match('/(?<=<style\stype="text\/css">)(.+)(?=<\/style>)/usm', $value, $result);

      if (count($result) > 0) {
        $replace = preg_replace('/(?<=[.]{1})([\\w_:-]+)(?=[{,\\s\\.]{1})/u', '$1[data-' . $uniq . ']', $result[0]);
        $value = preg_replace('/(?<=<style\stype="text\/css">)(.+)(?=<\/style>)/usm', $replace, $value);
      }
    }

    // append - and unique data attribute after every class attribute
    $value = preg_replace('/(class="[\\w\\s_:-]+")/u', '$1 data-' . $uniq . ' ', $value); 

    return $value;
  }
}