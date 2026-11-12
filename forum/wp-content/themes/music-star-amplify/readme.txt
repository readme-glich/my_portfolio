=== Music Star Amplify ===
Contributors: seosbg
Tags: one-column, two-columns, left-sidebar, translation-ready, footer-widgets, theme-options, custom-header, custom-logo, custom-menu, custom-colors, custom-background, featured-images, full-width-template, sticky-post, threaded-comments, entertainment, blog, news
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.0
Stable tag: 1.0.0
License: GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A music child theme of Music Star with a live audio visualizer, a header spotlight, a release countdown and a news ticker.

== Description ==

Music Star Amplify is a child theme of Music Star for bands, DJs, labels and music blogs.

All options are in Appearance > Customize > Amplify Options:

* Live Visualizer - bars, mirrored bars or a wave line under the header (or fixed at the bottom of the screen) that move with the real music when a visitor plays an audio file of the site, for example an Audio block in a post. It uses the Web Audio API of the browser. Audio from other websites cannot be analysed by browsers, so for them a soft animation is shown and the sound is never affected. Two colors, height and an idle animation can be set.
* Stage Lights - a spotlight that follows the mouse over the header image (on touch screens it moves slowly by itself), with an adjustable size.
* Release Countdown - a live countdown to a new album, single or concert with a button, shown as a bar at the top of the page or under the header. When the time is up a custom text is shown. The time zone of the site is used. On a fresh installation a preview countdown (one year ahead) is shown until the first change of the site or of the countdown options.
* News Ticker - a scrolling line with the titles of the latest posts (all or one category), on by default. It stops when the mouse or the keyboard focus is on it and keeps the same speed whatever the length of the titles.

Also:

* Fresh installation preview - while the site is new and the footer widget areas are empty, the footer shows core widgets with the real data of the site (recent posts, categories, archives, search). They disappear by themselves after the first change.
* The remote Google Font of the parent theme is replaced with a locally hosted copy of Raleway. The theme makes no external requests.
* All animations stop for visitors who prefer reduced motion, and the page works without JavaScript.

== Installation ==

1. Install and activate the parent theme Music Star first (Appearance > Themes > Add New, search for "Music Star").
2. Install Music Star Amplify in the same way, or upload the zip file in Appearance > Themes > Add New > Upload Theme.
3. Activate Music Star Amplify.
4. Go to Appearance > Customize > Amplify Options.

== Frequently Asked Questions ==

= The visualizer does not react to my song. Why? =

Browsers allow the analysis of audio only for files from the same website (or files served with CORS headers). Upload the audio file to the Media Library and add it with the Audio block, for example in a post or a page. For audio from other websites the visualizer shows a soft animation instead.

= Does the visualizer play music on its own? =

No. It only listens to audio that the visitor starts.

== Changelog ==

= 1.0.0 - November 4 2026 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
* Initial release.

== Copyright ==

Music Star Amplify WordPress Theme, (C) 2026 seosbg.
Music Star Amplify is distributed under the terms of the GNU GPL.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

Music Star Amplify is a child theme of Music Star, (C) seosbg, GPLv2 or later.

== Resources ==

Font (bundled in assets/fonts/raleway, files from the Fontsource project https://fontsource.org/):
* Raleway - Copyright 2010 The Raleway Project Authors - SIL Open Font License, 1.1 - https://github.com/impallari/Raleway
License text: https://openfontlicense.org/ (also included as OFL.txt in the font folder)

Screenshot:
* Header image, Copyright pxhere.com, License: CC0 1.0 Universal (CC0 1.0), Source: https://pxhere.com/en/photo/684401
* Other elements in the screenshot are part of the theme, GPLv2 or later.

Unless otherwise specified, all the theme files, scripts and images are licensed under the GNU General Public License version 2 or later.
