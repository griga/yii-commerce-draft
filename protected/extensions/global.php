<?php

/**
 * This is the shortcut to Yii::app()
 *
 * @return CWebApplication
 */
function app()
{
	return \Yii::app();
}

/**
 * This is the shortcut to Yii::app()->clientScript
 *
 * @return \CClientScript
 */
function cs()
{
	return \Yii::app()->getClientScript();
}

/**
 * This is the shortcut to Yii::app()->user.
 *
 * @return CWebUser
 */
function user()
{
	return \Yii::app()->getUser();
}

/**
 * This is the shortcut to Yii::app()->createUrl()
 *
 * @param        $route
 * @param array  $params
 * @param string $ampersand
 *
 * @return string
 */
function url($route, $params = array(), $ampersand = '&')
{
	return \Yii::app()->createUrl($route, $params, $ampersand);
}

/**
 * This is the shortcut to Yii::app()->createAbsoluteUrl()
 *
 * @param        $route
 * @param array  $params
 * @param string $schema
 * @param string $ampersand
 *
 * @return string
 */
function aUrl($route, $params = array(), $schema = '', $ampersand = '&')
{
	return \Yii::app()->createAbsoluteUrl($route, $params, $schema, $ampersand);
}

/**
 * This is shortcut to create absolute url from default url array
 *
 * @param        $url
 * @param string $schema
 * @param string $ampersand
 *
 * @return string
 */
function au($url, $schema = '', $ampersand = '&')
{
	$route = $url[0];
	unset($url[0]);

	return aUrl($route, $url, $schema, $ampersand);
}

/**
 * This is the shortcut to CHtml::encode
 *
 * @param $text
 *
 * @return string
 */
function h($text)
{
	return htmlspecialchars($text, ENT_QUOTES, \Yii::app()->charset);
}

/**
 * This is the shortcut to CHtml::link()
 *
 * @param        $text
 * @param string $url
 * @param array  $htmlOptions
 *
 * @return string
 */
function l($text, $url = '#', $htmlOptions = array())
{
	return \CHtml::link($text, $url, $htmlOptions);
}

/**
 * This is the shortcut to Yii::t() with default category = 'core'
 *
 * @param        $message
 * @param string $category
 * @param array  $params
 * @param null   $source
 * @param null   $language
 *
 * @return string
 */
function t($message, $params = array(), $category = 'core', $source = null, $language = null)
{
	return \Yii::t($category, $message, $params, $source, $language);
}

/**
 * This is the shortcut to Yii::t() with default category = 'site'
 *
 * @param        $message
 * @param string $category
 * @param array  $params
 * @param null   $source
 * @param null   $language
 *
 * @return string
 */
function ts($message, $params = array(), $category = 'site', $source = null, $language = null)
{
	return \Yii::t($category, $message, $params, $source, $language);
}

/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 *
 * @param string $name
 *
 * @return mixed
 */
function param($name)
{
	return \Yii::app()->params[$name];
}

/**
 * This is the shortcut to Yii::app()->db
 *
 * @return CDbConnection
 */
function db()
{
	return \Yii::app()->db;
}

/**
 * This is the shortcut to \Yii::app()->getRequest()
 *
 * @return CHttpRequest
 */
function r()
{
	return \Yii::app()->getRequest();
}

/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 *
 * @param string $url
 *
 * @return string
 */
function bu($url = '')
{
	static $baseUrl;
	if ($baseUrl === null)
		$baseUrl = Yii::app()->request->baseUrl;
	return $baseUrl . '/' . ltrim($url, '/');
}

/**
 * Displays a variable.
 * This method achieves the similar functionality as var_dump and print_r
 * but is more robust when handling complex objects such as Yii controllers.
 *
 * @param mixed   $target    variable to be dumped
 * @param bool    $exit
 * @param integer $depth     maximum depth that the dumper should go into the variable. Defaults to 10.
 * @param boolean $highlight whether the result should be syntax-highlighted
 */
function dump($target, $exit = true, $depth = 10, $highlight = true)
{
	echo \CVarDumper::dumpAsString($target, $depth, $highlight);
	if($exit)
	{
		exit();
	}
}

/**
 * This is the shortcut to CHtmlPurifier::purify().
 *
 * @param $text
 *
 * @return string
 */
function ph($text)
{
	static $purifier;
	if($purifier === null)
	{
		$purifier = new \CHtmlPurifier;
	}

	return $purifier->purify($text);
}

/**
 * Shortcut to Yii::app()->format (utilities for formatting structured text)
 *
 * @return \CFormatter|mixed
 */
function format()
{
	return \Yii::app()->format;
}

/**
 * Shortcut for json_encode
 *
 * @param array $json the PHP array to be encoded into json array
 * @param int   $opts Bitmask consisting of JSON_HEX_QUOT, JSON_HEX_TAG, JSON_HEX_AMP, JSON_HEX_APOS, JSON_FORCE_OBJECT.
 *
 * @return string
 */
function je($json, $opts = null)
{
	return json_encode($json, $opts);
}

/**
 * Shortcut for json_decode
 * NOTE: json_encode exists in PHP > 5.2, so it's safe to use it directly without checking
 *
 * @param string $json  the PHP array to be decoded into json array
 * @param bool   $assoc when true, returned objects will be converted into associative arrays.
 * @param int    $depth User specified recursion depth.
 * @param int    $opts  Bitmask of JSON decode options.
 *                      Currently only JSON_BIGINT_AS_STRING is supported
 *    (default is to cast large integers as floats)
 *
 * @return mixed
 */
function jd($json, $assoc = null, $depth = 512, $opts = 0)
{
	return json_decode($json, $assoc, $depth);
}

/**
 * Generates an image tag.
 * @param string $url the image URL
 * @param string $alt the alt text for the image. Images should have the alt attribute, so at least an empty one is rendered.
 * @param integer $width the width of the image. If null, the width attribute will not be rendered.
 * @param integer $height the height of the image. If null, the height attribute will not be rendered.
 * @param array $htmlOptions additional HTML attributes (see {@link tag}).
 * @return string the generated image tag
 */
function img($url, $alt = '', $width = null, $height = null, $htmlOptions = array())
{
	$htmlOptions['src'] = $url;
	if ($alt !== null)
		$htmlOptions['alt'] = $alt;
	else
		$htmlOptions['alt'] = '';
	if ($width !== null)
		$htmlOptions['width'] = $width;
	if ($height !== null)
		$htmlOptions['height'] = $height;
	return CHtml::tag('img', $htmlOptions);
}

/**
 * Generate id from class name
 *
 * @param $className
 *
 * @return string
 */
function class2id($className)
{
	return trim(strtolower(str_replace(array('_', '\\'), array('-', '_'), preg_replace('/(?<![A-Z])[A-Z]/', '-\0', $className))), '-');
}
