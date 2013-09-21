<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2013 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Bundles;

abstract class Forum extends \s9e\TextFormatter\Bundle
{
	/**
	* @var s9e\TextFormatter\Parser Singleton instance used by parse()
	*/
	public static $parser;

	/**
	* @var s9e\TextFormatter\Renderer Singleton instance used by render() and renderMulti()
	*/
	public static $renderer;

	/**
	* Return a new instance of s9e\TextFormatter\Parser
	*
	* @return s9e\TextFormatter\Parser
	*/
	public static function getParser()
	{
		return unserialize("O:24:\"s9e\\TextFormatter\\Parser\":4:{s:16:\"\000*\000pluginsConfig\";a:5:{s:7:\"BBCodes\";a:5:{s:7:\"bbcodes\";a:21:{s:1:\"B\";a:0:{}s:4:\"CODE\";a:1:{s:16:\"defaultAttribute\";s:4:\"lang\";}s:5:\"COLOR\";a:0:{}s:5:\"EMAIL\";a:1:{s:17:\"contentAttributes\";a:1:{i:0;s:5:\"email\";}}s:1:\"I\";a:0:{}s:4:\"LIST\";a:1:{s:16:\"defaultAttribute\";s:4:\"type\";}s:1:\"*\";a:1:{s:7:\"tagName\";s:2:\"LI\";}s:2:\"LI\";a:0:{}s:5:\"QUOTE\";a:1:{s:16:\"defaultAttribute\";s:6:\"author\";}s:1:\"S\";a:0:{}s:4:\"SIZE\";a:0:{}s:7:\"SPOILER\";a:1:{s:16:\"defaultAttribute\";s:5:\"title\";}s:1:\"U\";a:0:{}s:3:\"URL\";a:1:{s:17:\"contentAttributes\";a:1:{i:0;s:3:\"url\";}}s:5:\"MEDIA\";a:1:{s:17:\"contentAttributes\";a:1:{i:0;s:3:\"url\";}}s:11:\"DAILYMOTION\";a:2:{s:17:\"contentAttributes\";a:1:{i:0;s:3:\"url\";}s:16:\"defaultAttribute\";s:3:\"url\";}s:8:\"FACEBOOK\";a:2:{s:17:\"contentAttributes\";a:1:{i:0;s:3:\"url\";}s:16:\"defaultAttribute\";s:3:\"url\";}s:8:\"LIVELEAK\";a:2:{s:17:\"contentAttributes\";a:1:{i:0;s:3:\"url\";}s:16:\"defaultAttribute\";s:3:\"url\";}s:6:\"TWITCH\";a:2:{s:17:\"contentAttributes\";a:1:{i:0;s:3:\"url\";}s:16:\"defaultAttribute\";s:3:\"url\";}s:5:\"VIMEO\";a:2:{s:17:\"contentAttributes\";a:1:{i:0;s:3:\"url\";}s:16:\"defaultAttribute\";s:3:\"url\";}s:7:\"YOUTUBE\";a:2:{s:17:\"contentAttributes\";a:1:{i:0;s:3:\"url\";}s:16:\"defaultAttribute\";s:3:\"url\";}}s:10:\"quickMatch\";s:1:\"[\";s:6:\"regexp\";s:143:\"#\\[/?([*BI]|CO(?>DE|LOR)|DAILYMOTION|EMAIL|FACEBOOK|LI(?>ST|VELEAK)?|MEDIA|QUOTE|S(?>IZE|POILER)?|TWITCH|U(?>RL)?|VIMEO|YOUTUBE)(?=[\\] =:/])#iS\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:9:\"Emoticons\";a:4:{s:6:\"regexp\";s:45:\"/(?>:(?>[()?DPop|]|-[()*?DPp|]|lol:)|;-?\\))/S\";s:7:\"tagName\";s:1:\"E\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:10:\"MediaEmbed\";a:4:{s:10:\"quickMatch\";s:3:\"://\";s:6:\"regexp\";s:16:\"#(https?://\\S+)#\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:9:\"Autoemail\";a:6:{s:8:\"attrName\";s:5:\"email\";s:10:\"quickMatch\";s:1:\"@\";s:6:\"regexp\";s:39:\"/\\b[-a-z0-9_+.]+@[-a-z0-9.]*[a-z0-9]/Si\";s:7:\"tagName\";s:5:\"EMAIL\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:8:\"Autolink\";a:6:{s:8:\"attrName\";s:3:\"url\";s:10:\"quickMatch\";s:3:\"://\";s:6:\"regexp\";s:43:\"#https?://\\S(?:[^\\s\\[\\]]*(?:\\[\\w*\\])?)++#iS\";s:7:\"tagName\";s:3:\"URL\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}}s:17:\"\000*\000registeredVars\";a:2:{s:9:\"urlConfig\";a:2:{s:14:\"allowedSchemes\";s:12:\"/^https?\$/Di\";s:13:\"requireScheme\";b:0;}s:10:\"mediasites\";a:7:{s:15:\"dailymotion.com\";s:11:\"dailymotion\";s:12:\"facebook.com\";s:8:\"facebook\";s:12:\"liveleak.com\";s:8:\"liveleak\";s:9:\"twitch.tv\";s:6:\"twitch\";s:9:\"vimeo.com\";s:5:\"vimeo\";s:11:\"youtube.com\";s:7:\"youtube\";s:8:\"youtu.be\";s:7:\"youtube\";}}s:14:\"\000*\000rootContext\";a:3:{s:15:\"allowedChildren\";s:1:\"7\";s:18:\"allowedDescendants\";s:1:\"?\";s:5:\"flags\";i:0;}s:13:\"\000*\000tagsConfig\";a:21:{s:1:\"B\";a:7:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:2;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:1:\"%\";s:18:\"allowedDescendants\";s:1:\"?\";}s:4:\"CODE\";a:8:{s:10:\"attributes\";a:1:{s:4:\"lang\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:57:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterIdentifier\";s:6:\"params\";a:1:{s:9:\"attrValue\";N;}}}s:8:\"required\";b:0;}}s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:912;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:1:\"\000\";s:18:\"allowedDescendants\";s:1:\"\000\";}s:5:\"COLOR\";a:8:{s:10:\"attributes\";a:1:{s:5:\"color\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:52:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterColor\";s:6:\"params\";a:1:{s:9:\"attrValue\";N;}}}s:8:\"required\";b:1;}}s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:0;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:1:\"%\";s:18:\"allowedDescendants\";s:1:\"?\";}s:5:\"EMAIL\";a:8:{s:10:\"attributes\";a:1:{s:5:\"email\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:52:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterEmail\";s:6:\"params\";a:1:{s:9:\"attrValue\";N;}}}s:8:\"required\";b:1;}}s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:66;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:2;s:15:\"allowedChildren\";s:1:\"#\";s:18:\"allowedDescendants\";s:1:\"+\";}s:1:\"I\";a:7:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:2;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:1:\"%\";s:18:\"allowedDescendants\";s:1:\"?\";}s:4:\"LIST\";a:8:{s:10:\"attributes\";a:1:{s:4:\"type\";a:2:{s:11:\"filterChain\";a:2:{i:0;a:2:{s:8:\"callback\";s:50:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterMap\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;a:5:{i:0;a:2:{i:0;s:6:\"/^1\$/D\";i:1;s:7:\"decimal\";}i:1;a:2:{i:0;s:6:\"/^a\$/D\";i:1;s:11:\"lower-alpha\";}i:2;a:2:{i:0;s:6:\"/^A\$/D\";i:1;s:11:\"upper-alpha\";}i:3;a:2:{i:0;s:6:\"/^i\$/D\";i:1;s:11:\"lower-roman\";}i:4;a:2:{i:0;s:6:\"/^I\$/D\";i:1;s:11:\"upper-roman\";}}}}i:1;a:2:{s:8:\"callback\";s:57:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterSimpletext\";s:6:\"params\";a:1:{s:9:\"attrValue\";N;}}}s:8:\"required\";b:0;}}s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:672;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:1:\"(\";s:18:\"allowedDescendants\";s:1:\"?\";}s:2:\"LI\";a:7:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:11:\"closeParent\";a:1:{s:2:\"LI\";i:1;}s:5:\"flags\";i:512;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:3;s:15:\"allowedChildren\";s:1:\"7\";s:18:\"allowedDescendants\";s:1:\"?\";}s:5:\"QUOTE\";a:8:{s:10:\"attributes\";a:1:{s:6:\"author\";a:1:{s:8:\"required\";b:0;}}s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:512;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:1:\"7\";s:18:\"allowedDescendants\";s:1:\"?\";}s:1:\"S\";a:7:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:2;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:1:\"%\";s:18:\"allowedDescendants\";s:1:\"?\";}s:4:\"SIZE\";a:8:{s:10:\"attributes\";a:1:{s:4:\"size\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:52:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRange\";s:6:\"params\";a:4:{s:9:\"attrValue\";N;i:0;i:8;i:1;i:36;s:6:\"logger\";N;}}}s:8:\"required\";b:1;}}s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:0;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:1:\"%\";s:18:\"allowedDescendants\";s:1:\"?\";}s:7:\"SPOILER\";a:8:{s:10:\"attributes\";a:1:{s:5:\"title\";a:1:{s:8:\"required\";b:0;}}s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:512;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:1:\"7\";s:18:\"allowedDescendants\";s:1:\"?\";}s:1:\"U\";a:7:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:2;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:1:\"%\";s:18:\"allowedDescendants\";s:1:\"?\";}s:3:\"URL\";a:8:{s:10:\"attributes\";a:2:{s:3:\"url\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:50:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterUrl\";s:6:\"params\";a:3:{s:9:\"attrValue\";N;s:9:\"urlConfig\";N;s:6:\"logger\";N;}}}s:8:\"required\";b:1;}s:5:\"title\";a:1:{s:8:\"required\";b:0;}}s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:66;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:2;s:15:\"allowedChildren\";s:1:\"#\";s:18:\"allowedDescendants\";s:1:\"+\";}s:1:\"E\";a:7:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:193;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:1:\" \";s:18:\"allowedDescendants\";s:1:\"?\";}s:5:\"MEDIA\";a:7:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:54:\"s9e\\TextFormatter\\Plugins\\MediaEmbed\\Parser::filterTag\";s:6:\"params\";a:3:{s:3:\"tag\";N;s:6:\"parser\";N;s:10:\"mediasites\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:81;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:5;s:15:\"allowedChildren\";s:1:\"\000\";s:18:\"allowedDescendants\";s:1:\"\000\";}s:11:\"DAILYMOTION\";a:9:{s:10:\"attributes\";a:1:{s:2:\"id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:21:\"!^(?:[A-Za-z0-9]+)\$!D\";}}}s:8:\"required\";b:1;}}s:22:\"attributePreprocessors\";a:2:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:66:\"!dailymotion\\.com/(?:video/|user/[^#]+#video=)(?'id'[A-Za-z0-9]+)!\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:24:\"!^(?'id'[A-Za-z0-9]+)\$!D\";}}s:11:\"filterChain\";a:2:{i:0;a:2:{s:8:\"callback\";s:55:\"s9e\\TextFormatter\\Parser::executeAttributePreprocessors\";s:6:\"params\";a:2:{s:3:\"tag\";N;s:9:\"tagConfig\";N;}}i:1;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:209;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:2;s:15:\"allowedChildren\";s:1:\"\000\";s:18:\"allowedDescendants\";s:1:\"\000\";}s:8:\"FACEBOOK\";a:9:{s:10:\"attributes\";a:1:{s:2:\"id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:15:\"!^(?:[0-9]+)\$!D\";}}}s:8:\"required\";b:1;}}s:22:\"attributePreprocessors\";a:2:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:43:\"!facebook\\.com/photo\\.php\\?v=(?'id'[0-9]+)!\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:18:\"!^(?'id'[0-9]+)\$!D\";}}s:11:\"filterChain\";a:2:{i:0;a:2:{s:8:\"callback\";s:55:\"s9e\\TextFormatter\\Parser::executeAttributePreprocessors\";s:6:\"params\";a:2:{s:3:\"tag\";N;s:9:\"tagConfig\";N;}}i:1;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:209;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:2;s:15:\"allowedChildren\";s:1:\"\000\";s:18:\"allowedDescendants\";s:1:\"\000\";}s:8:\"LIVELEAK\";a:9:{s:10:\"attributes\";a:1:{s:2:\"id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:19:\"!^(?:[a-f_0-9]+)\$!D\";}}}s:8:\"required\";b:1;}}s:22:\"attributePreprocessors\";a:2:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:41:\"!liveleak\\.com/view\\?i=(?'id'[a-f_0-9]+)!\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:22:\"!^(?'id'[a-f_0-9]+)\$!D\";}}s:11:\"filterChain\";a:2:{i:0;a:2:{s:8:\"callback\";s:55:\"s9e\\TextFormatter\\Parser::executeAttributePreprocessors\";s:6:\"params\";a:2:{s:3:\"tag\";N;s:9:\"tagConfig\";N;}}i:1;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:209;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:2;s:15:\"allowedChildren\";s:1:\"\000\";s:18:\"allowedDescendants\";s:1:\"\000\";}s:6:\"TWITCH\";a:9:{s:10:\"attributes\";a:3:{s:7:\"channel\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:21:\"!^(?:[A-Za-z0-9]+)\$!D\";}}}s:8:\"required\";b:0;}s:10:\"archive_id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:15:\"!^(?:[0-9]+)\$!D\";}}}s:8:\"required\";b:0;}s:10:\"chapter_id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:15:\"!^(?:[0-9]+)\$!D\";}}}s:8:\"required\";b:0;}}s:22:\"attributePreprocessors\";a:1:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:91:\"!twitch\\.tv/(?'channel'[A-Za-z0-9]+)(?:/b/(?'archive_id'[0-9]+)|/c/(?'chapter_id'[0-9]+))?!\";}}s:11:\"filterChain\";a:2:{i:0;a:2:{s:8:\"callback\";s:55:\"s9e\\TextFormatter\\Parser::executeAttributePreprocessors\";s:6:\"params\";a:2:{s:3:\"tag\";N;s:9:\"tagConfig\";N;}}i:1;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:209;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:2;s:15:\"allowedChildren\";s:1:\"\000\";s:18:\"allowedDescendants\";s:1:\"\000\";}s:5:\"VIMEO\";a:9:{s:10:\"attributes\";a:1:{s:2:\"id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:15:\"!^(?:[0-9]+)\$!D\";}}}s:8:\"required\";b:1;}}s:22:\"attributePreprocessors\";a:2:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:46:\"!vimeo\\.com/(?:channels/[^/]+/)?(?'id'[0-9]+)!\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:18:\"!^(?'id'[0-9]+)\$!D\";}}s:11:\"filterChain\";a:2:{i:0;a:2:{s:8:\"callback\";s:55:\"s9e\\TextFormatter\\Parser::executeAttributePreprocessors\";s:6:\"params\";a:2:{s:3:\"tag\";N;s:9:\"tagConfig\";N;}}i:1;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:209;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:2;s:15:\"allowedChildren\";s:1:\"\000\";s:18:\"allowedDescendants\";s:1:\"\000\";}s:7:\"YOUTUBE\";a:9:{s:10:\"attributes\";a:1:{s:2:\"id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:23:\"!^(?:[-0-9A-Z_a-z]+)\$!D\";}}}s:8:\"required\";b:1;}}s:22:\"attributePreprocessors\";a:3:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:55:\"!youtube\\.com/(?:watch\\?.*?v=|v/)(?'id'[-0-9A-Z_a-z]+)!\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:33:\"!youtu\\.be/(?'id'[-0-9A-Z_a-z]+)!\";}i:2;a:2:{i:0;s:3:\"url\";i:1;s:26:\"!^(?'id'[-0-9A-Z_a-z]+)\$!D\";}}s:11:\"filterChain\";a:2:{i:0;a:2:{s:8:\"callback\";s:55:\"s9e\\TextFormatter\\Parser::executeAttributePreprocessors\";s:6:\"params\";a:2:{s:3:\"tag\";N;s:9:\"tagConfig\";N;}}i:1;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:209;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:2;s:15:\"allowedChildren\";s:1:\"\000\";s:18:\"allowedDescendants\";s:1:\"\000\";}}}");
	}

	/**
	* Return a new instance of s9e\TextFormatter\Renderer
	*
	* @return s9e\TextFormatter\Renderer
	*/
	public static function getRenderer()
	{
		return unserialize("O:40:\"s9e\\TextFormatter\\Bundles\\Forum\\Renderer\":3:{s:13:\"\000*\000htmlOutput\";b:1;s:16:\"\000*\000dynamicParams\";a:0:{}s:9:\"\000*\000params\";a:5:{s:14:\"EMOTICONS_PATH\";s:0:\"\";s:6:\"L_HIDE\";s:4:\"Hide\";s:6:\"L_SHOW\";s:4:\"Show\";s:9:\"L_SPOILER\";s:7:\"Spoiler\";s:7:\"L_WROTE\";s:6:\"wrote:\";}}");
	}
}