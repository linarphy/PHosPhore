<?php

/* Title of this page */
$GLOBALS['lang']['page']['doc']['faq']['title']='FAQ';
/* Description of this page */
$GLOBALS['lang']['page']['doc']['faq']['description']='Welcome to the FAQ (Frequently Asked Question)';
/* [FAQ] /*
 * 0 */
/* Question */
$GLOBALS['lang']['page']['doc']['faq']['qa'][0]['q']='Who is this framewok for?';
/* Answer */
$GLOBALS['lang']['page']['doc']['faq']['qa'][0]['a']='While it\'s obvious that anyone can use this framework, it\'s important to understand that it\'s just the result of an amateur project. This means that its performances are not good, that some PHP good practices are not applied to it (by ignorance, don\'t worry ;) ). I THEREFORE ADVISE AGAINST THIS FRAMEWORK TO ANYONE WHO WANTS TO USE IT IN PRODUCTION OR OTHER PROFESSIONAL USES.';
/* 1 */
/* Question */
$GLOBALS['lang']['page']['doc']['faq']['qa'][1]['q']='Who is this framewok for?';
/* Answer */
$GLOBALS['lang']['page']['doc']['faq']['qa'][1]['a']='This project is the result of my experience with PHP over the last five years. Building the framework itself didn\'t take all these years, but is the result of building a site five times with a different approach each time. The last one brought me to think of a certain idea, which I decided to deepen by making this framework. Of course, the project has progressed in several aspects compared to the original idea (which is mainly based on URL/file symmetry).';
/* 2 */
/* Question */
$GLOBALS['lang']['page']['doc']['faq']['qa'][2]['q']='The page does not display "It works!" when loading the site but a blank page, what happens?';
/* Answer */
$GLOBALS['lang']['page']['doc']['faq']['qa'][2]['a']='There can be several problems. First, check your configurations, you never know. If the configuration is good, no files have been modified and the database has been imported, it is possible that "mod_rewrite" is not activated in your apache configuration. Enable it with <code>sudo a2enmod rewrite</code> on linux. On window, it depends on how the server is installed. If it still doesn\'t work and if you are using a virtualHost, check the presence of code>AllowOverride All</code> in the virtualHost configuration file. If the error is still unresolved, please contact me.';
/* 3 */
/* Question */
$GLOBALS['lang']['page']['doc']['faq']['qa'][3]['q']='I found some mistakes/bad practices/other uncool things in the code! What can I do?';
/* Answer */
$GLOBALS['lang']['page']['doc']['faq']['qa'][3]['a']='Thank you for your interest in this project! Please don\'t hesitate to contact me. Criticism helps me improve, and I\'m sure the project is full of crap !';
/* 4 */
/* Question */
$GLOBALS['lang']['page']['doc']['faq']['qa'][4]['q']='I would like to contact you, how can I do that?';
/* Answer */
$GLOBALS['lang']['page']['doc']['faq']['qa'][4]['a']='Feel free to visit the "contact me" page, which lists various ways to get in touch with me.';
/* 5 */
/* Question */
$GLOBALS['lang']['page']['doc']['faq']['qa'][5]['q']='Can I use, distribute, modify this framework?';
/* Answer */
$GLOBALS['lang']['page']['doc']['faq']['qa'][5]['a']='The license is easily available on the site and Github, but to make it short: YES, whether it is associated with paid content, under commercial or free license, etc...';

?>
