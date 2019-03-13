/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

var $ = jQuery;

function removeHeights(items) {
  items.each(function() {
    $(this).css('height','');
  });
}

function matchHeights(items) {
  var maxHeight = 0;
  items.each(function() {
    if ($(this).outerHeight() > maxHeight) {
      maxHeight = $(this).outerHeight();
    }
  });
  items.each(function() {
    $(this).css('height',maxHeight);
  });
}

$(window).resize(function() {
  removeHeights($('.not-front .triple'));
  removeHeights($('.block-nodeblock.triple'));
  removeHeights($('.front .view-states .triple')); 
  removeHeights($('.double'));
  removeHeights($('.realestate'));
  if ($(window).width() > 767) {
    matchHeights($('.double'));
    matchHeights($('.not-front .triple'));
    matchHeights($('.realestate'));
    matchHeights($('.block-nodeblock.triple'));
    matchHeights($('.front .view-states .triple'));
  }
});

$(document).ready(function () {
  if ($(window).width() > 767) {
    matchHeights($('.double'));
    matchHeights($('.not-front .triple'));
    matchHeights($('.realestate'));
    matchHeights($('.block-nodeblock.triple'));
    matchHeights($('.front .view-states .triple'));
  }
});

