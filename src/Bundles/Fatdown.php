<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2014 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Bundles;

abstract class Fatdown extends \s9e\TextFormatter\Bundle
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
		return unserialize("O:24:\"s9e\\TextFormatter\\Parser\":4:{s:16:\"\000*\000pluginsConfig\";a:9:{s:8:\"Litedown\";a:0:{}s:9:\"Autoemail\";a:6:{s:8:\"attrName\";s:5:\"email\";s:10:\"quickMatch\";s:1:\"@\";s:6:\"regexp\";s:39:\"/\\b[-a-z0-9_+.]+@[-a-z0-9.]*[a-z0-9]/Si\";s:7:\"tagName\";s:5:\"EMAIL\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:8:\"Autolink\";a:6:{s:8:\"attrName\";s:3:\"url\";s:10:\"quickMatch\";s:3:\"://\";s:6:\"regexp\";s:51:\"#(?:ftp|https?)://\\S(?>[^\\s\\[\\]]*(?>\\[\\w*\\])?)++#iS\";s:7:\"tagName\";s:3:\"URL\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:7:\"Escaper\";a:5:{s:10:\"quickMatch\";s:1:\"\\\";s:6:\"regexp\";s:26:\"/\\\\[-!#()*+.:@[\\\\\\]^_`{}]/\";s:7:\"tagName\";s:3:\"ESC\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:10:\"FancyPants\";a:2:{s:8:\"attrName\";s:4:\"char\";s:7:\"tagName\";s:2:\"FP\";}s:12:\"HTMLComments\";a:6:{s:8:\"attrName\";s:7:\"content\";s:10:\"quickMatch\";s:4:\"<!--\";s:6:\"regexp\";s:22:\"/<!--(?!\\[if).*?-->/is\";s:7:\"tagName\";s:2:\"HC\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:12:\"HTMLEntities\";a:6:{s:8:\"attrName\";s:4:\"char\";s:10:\"quickMatch\";s:1:\"&\";s:6:\"regexp\";s:38:\"/&(?>[a-z]+|#(?>[0-9]+|x[0-9a-f]+));/i\";s:7:\"tagName\";s:2:\"HE\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:12:\"HTMLElements\";a:6:{s:10:\"quickMatch\";s:1:\"<\";s:6:\"prefix\";s:4:\"html\";s:6:\"regexp\";s:290:\"#<(?>/((?:u|a(?>bbr)?|br?|code|del|em|hr|i(?>mg)?|s(?>(?>trong|u[bp]))?|t(?:[dr]|able|body|foot|h(?>ead)?)))|((?:u|a(?>bbr)?|br?|code|del|em|hr|i(?>mg)?|s(?>(?>trong|u[bp]))?|t(?:[dr]|able|body|foot|h(?>ead)?)))((?>\\s+[a-z][-a-z]*(?>\\s*=\\s*(?>\"[^\"]*\"|'[^']*'|[^\\s\"'=<>`]+))?)*+)\\s*/?)\\s*>#i\";s:7:\"aliases\";a:8:{s:1:\"a\";a:2:{s:0:\"\";s:3:\"URL\";s:4:\"href\";s:3:\"url\";}s:2:\"hr\";a:1:{s:0:\"\";s:2:\"HR\";}s:3:\"img\";a:1:{s:0:\"\";s:3:\"IMG\";}s:2:\"em\";a:1:{s:0:\"\";s:2:\"EM\";}s:1:\"s\";a:1:{s:0:\"\";s:1:\"S\";}s:6:\"strong\";a:1:{s:0:\"\";s:6:\"STRONG\";}s:3:\"sub\";a:1:{s:0:\"\";s:3:\"SUB\";}s:3:\"sup\";a:1:{s:0:\"\";s:3:\"SUP\";}}s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:10:\"MediaEmbed\";a:4:{s:10:\"quickMatch\";s:1:\":\";s:6:\"regexp\";s:209:\"#\\b(?>spotify:|https?://(?:[-.\\w]+\\.)?(?>twitch\\.tv|vi(?>meo\\.com|ne\\.co)|youtu(?>\\.be|be\\.com)|(?>bandcamp|dailymotion|facebook|grooveshark|liveleak|soundcloud|(?>open|play)\\.spotify)\\.com)/)[^[\"'\\s]+(?!\\S)#S\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}}s:14:\"registeredVars\";a:2:{s:9:\"urlConfig\";a:1:{s:14:\"allowedSchemes\";s:20:\"/^(?:ftp|https?)\$/Di\";}s:10:\"mediasites\";a:14:{s:12:\"bandcamp.com\";s:8:\"bandcamp\";s:15:\"dailymotion.com\";s:11:\"dailymotion\";s:12:\"facebook.com\";s:8:\"facebook\";s:15:\"grooveshark.com\";s:11:\"grooveshark\";s:12:\"liveleak.com\";s:8:\"liveleak\";s:14:\"soundcloud.com\";s:10:\"soundcloud\";s:16:\"open.spotify.com\";s:7:\"spotify\";s:16:\"play.spotify.com\";s:7:\"spotify\";s:8:\"spotify:\";s:7:\"spotify\";s:9:\"twitch.tv\";s:6:\"twitch\";s:9:\"vimeo.com\";s:5:\"vimeo\";s:7:\"vine.co\";s:4:\"vine\";s:11:\"youtube.com\";s:7:\"youtube\";s:8:\"youtu.be\";s:7:\"youtube\";}}s:14:\"\000*\000rootContext\";a:3:{s:15:\"allowedChildren\";s:2:\"w\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";s:5:\"flags\";i:392;}s:13:\"\000*\000tagsConfig\";a:52:{s:1:\"C\";a:7:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:18;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:4:\"CODE\";a:8:{s:10:\"attributes\";a:1:{s:4:\"lang\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:57:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterSimpletext\";s:6:\"params\";a:1:{s:9:\"attrValue\";N;}}}s:8:\"required\";b:0;}}s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:916;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:3:\"DEL\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:64;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"w\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:2:\"EM\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:2;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"q\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:2:\"H1\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:516;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:2;s:15:\"allowedChildren\";s:2:\"q\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:2:\"H2\";R:141;s:2:\"H3\";R:141;s:2:\"H4\";R:141;s:2:\"H5\";R:141;s:2:\"H6\";R:141;s:2:\"HR\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:645;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:2:\"`\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:3:\"IMG\";a:8:{s:10:\"attributes\";a:3:{s:3:\"alt\";a:1:{s:8:\"required\";b:0;}s:3:\"src\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:50:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterUrl\";s:6:\"params\";a:3:{s:9:\"attrValue\";N;s:9:\"urlConfig\";N;s:6:\"logger\";N;}}}s:8:\"required\";b:1;}s:5:\"title\";R:159;}s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:129;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"`\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:2:\"LI\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:11:\"closeParent\";a:1:{s:2:\"LI\";i:1;}s:5:\"flags\";i:520;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:3;s:15:\"allowedChildren\";s:2:\"w\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:4:\"LIST\";a:8:{s:10:\"attributes\";a:1:{s:4:\"type\";R:111;}s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:676;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:2:\"H\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:5:\"QUOTE\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:524;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:2:\"w\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:6:\"STRONG\";R:133;s:3:\"SUP\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:0;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"q\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:3:\"URL\";a:8:{s:10:\"attributes\";a:2:{s:5:\"title\";R:159;s:3:\"url\";R:161;}s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:66;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"g\000\";s:18:\"allowedDescendants\";s:2:\"\357\003\";}s:5:\"EMAIL\";a:8:{s:10:\"attributes\";a:1:{s:5:\"email\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:52:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterEmail\";s:6:\"params\";R:115;}}s:8:\"required\";b:1;}}s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:215;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"g\000\";s:18:\"allowedDescendants\";s:2:\"\357\003\";}s:3:\"ESC\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:145;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:5;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:2:\"FP\";a:8:{s:10:\"attributes\";a:1:{s:4:\"char\";a:1:{s:8:\"required\";b:1;}}s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:171;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:5;s:15:\"allowedChildren\";s:2:\"`\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:2:\"HC\";a:8:{s:10:\"attributes\";a:1:{s:7:\"content\";R:243;}s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:401;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:6;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:2:\"HE\";R:241;s:9:\"html:abbr\";a:8:{s:10:\"attributes\";a:1:{s:5:\"title\";R:159;}s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:206;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"q\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:6:\"html:b\";R:133;s:7:\"html:br\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:161;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"@\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:9:\"html:code\";R:93;s:8:\"html:del\";R:125;s:6:\"html:i\";R:133;s:11:\"html:strong\";R:133;s:8:\"html:sub\";R:204;s:8:\"html:sup\";R:204;s:10:\"html:table\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:190;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:2:\"\300\002\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:10:\"html:tbody\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:11:\"closeParent\";a:3:{s:10:\"html:tbody\";i:1;s:10:\"html:tfoot\";i:1;s:10:\"html:thead\";i:1;}s:5:\"flags\";i:672;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:7;s:15:\"allowedChildren\";s:2:\"@\002\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:7:\"html:td\";a:8:{s:10:\"attributes\";a:2:{s:7:\"colspan\";R:159;s:7:\"rowspan\";R:159;}s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:11:\"closeParent\";a:2:{s:7:\"html:td\";i:1;s:7:\"html:th\";i:1;}s:5:\"flags\";i:520;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:8;s:15:\"allowedChildren\";s:2:\"w\000\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:10:\"html:tfoot\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:11:\"closeParent\";a:2:{s:10:\"html:tbody\";i:1;s:10:\"html:thead\";i:1;}s:5:\"flags\";i:672;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:7;s:15:\"allowedChildren\";s:2:\"@\002\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:7:\"html:th\";a:8:{s:10:\"attributes\";a:3:{s:7:\"colspan\";R:159;s:7:\"rowspan\";R:159;s:5:\"scope\";R:159;}s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:295;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:8;s:15:\"allowedChildren\";s:2:\"s\000\";s:18:\"allowedDescendants\";s:2:\"\373\003\";}s:10:\"html:thead\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:672;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:7;s:15:\"allowedChildren\";s:2:\"@\002\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:7:\"html:tr\";a:7:{s:11:\"filterChain\";R:94;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:11:\"closeParent\";a:1:{s:7:\"html:tr\";i:1;}s:5:\"flags\";i:672;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:9;s:15:\"allowedChildren\";s:2:\"@\001\";s:18:\"allowedDescendants\";s:2:\"\377\003\";}s:6:\"html:u\";R:133;s:5:\"MEDIA\";a:7:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:54:\"s9e\\TextFormatter\\Plugins\\MediaEmbed\\Parser::filterTag\";s:6:\"params\";a:3:{s:3:\"tag\";N;s:6:\"parser\";N;s:10:\"mediasites\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:81;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:6;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:8:\"BANDCAMP\";a:8:{s:10:\"attributes\";a:4:{s:3:\"url\";a:2:{s:11:\"filterChain\";R:162;s:8:\"required\";b:0;}s:8:\"album_id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:12:\"!^(?:\\d+)\$!D\";}}}s:8:\"required\";b:0;}s:9:\"track_num\";R:359;s:8:\"track_id\";R:359;}s:11:\"filterChain\";a:3:{i:0;a:2:{s:8:\"callback\";s:51:\"s9e\\TextFormatter\\Plugins\\MediaEmbed\\Parser::scrape\";s:6:\"params\";a:3:{s:3:\"tag\";N;i:0;a:2:{i:0;a:3:{i:0;s:23:\"!bandcamp\\.com/album/.!\";i:1;s:25:\"!/album=(?'album_id'\\d+)!\";i:2;a:1:{i:0;s:8:\"album_id\";}}i:1;a:3:{i:0;s:23:\"!bandcamp\\.com/track/.!\";i:1;a:3:{i:0;s:29:\"!\"album_id\":(?'album_id'\\d+)!\";i:1;s:31:\"!\"track_num\":(?'track_num'\\d+)!\";i:2;s:25:\"!/track=(?'track_id'\\d+)!\";}i:2;a:3:{i:0;s:8:\"album_id\";i:1;s:8:\"track_id\";i:2;s:9:\"track_num\";}}}s:8:\"cacheDir\";N;}}i:1;R:95;i:2;a:2:{s:8:\"callback\";s:67:\"s9e\\TextFormatter\\Plugins\\MediaEmbed\\Parser::hasNonDefaultAttribute\";s:6:\"params\";a:1:{s:3:\"tag\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:235;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:11:\"DAILYMOTION\";a:9:{s:10:\"attributes\";a:2:{s:3:\"url\";R:357;s:2:\"id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:21:\"!^(?:[A-Za-z0-9]+)\$!D\";}}}s:8:\"required\";b:1;}}s:22:\"attributePreprocessors\";a:2:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:66:\"!dailymotion\\.com/(?:video/|user/[^#]+#video=)(?'id'[A-Za-z0-9]+)!\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:24:\"!^(?'id'[A-Za-z0-9]+)\$!D\";}}s:11:\"filterChain\";a:2:{i:0;a:2:{s:8:\"callback\";s:55:\"s9e\\TextFormatter\\Parser::executeAttributePreprocessors\";s:6:\"params\";a:2:{s:3:\"tag\";N;s:9:\"tagConfig\";N;}}i:1;R:95;}s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:235;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:8:\"FACEBOOK\";a:9:{s:10:\"attributes\";a:2:{s:3:\"url\";R:357;s:2:\"id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:15:\"!^(?:[0-9]+)\$!D\";}}}s:8:\"required\";b:1;}}s:22:\"attributePreprocessors\";a:2:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:59:\"!facebook\\.com/(?:photo|video/video)\\.php\\?v=(?'id'[0-9]+)!\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:18:\"!^(?'id'[0-9]+)\$!D\";}}s:11:\"filterChain\";R:415;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:235;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:11:\"GROOVESHARK\";a:9:{s:10:\"attributes\";a:3:{s:3:\"url\";R:357;s:6:\"songid\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:15:\"%^(?:[0-9]+)\$%D\";}}}s:8:\"required\";b:0;}s:10:\"playlistid\";R:450;}s:22:\"attributePreprocessors\";a:1:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:64:\"%grooveshark\\.com(?:/#!?)?/playlist/[^/]+/(?'playlistid'[0-9]+)%\";}}s:11:\"filterChain\";a:4:{i:0;R:416;i:1;a:2:{s:8:\"callback\";s:51:\"s9e\\TextFormatter\\Plugins\\MediaEmbed\\Parser::scrape\";s:6:\"params\";a:3:{s:3:\"tag\";N;i:0;a:1:{i:0;a:4:{i:0;s:47:\"%grooveshark\\.com(?:/#!?)?/s/(?'path'[^/]+/.+)%\";i:1;s:26:\"%songID=(?'songid'[0-9]+)%\";i:2;a:1:{i:0;s:6:\"songid\";}i:3;s:32:\"http://grooveshark.com/s/{@path}\";}}s:8:\"cacheDir\";N;}}i:2;R:95;i:3;R:389;}s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:235;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:8:\"LIVELEAK\";a:9:{s:10:\"attributes\";a:2:{s:3:\"url\";R:357;s:2:\"id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:19:\"!^(?:[a-f_0-9]+)\$!D\";}}}s:8:\"required\";b:1;}}s:22:\"attributePreprocessors\";a:2:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:41:\"!liveleak\\.com/view\\?i=(?'id'[a-f_0-9]+)!\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:22:\"!^(?'id'[a-f_0-9]+)\$!D\";}}s:11:\"filterChain\";R:415;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:235;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:10:\"SOUNDCLOUD\";a:9:{s:10:\"attributes\";a:5:{s:3:\"url\";R:357;s:11:\"playlist_id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:12:\"@^(?:\\d+)\$@D\";}}}s:8:\"required\";b:0;}s:8:\"track_id\";R:504;s:2:\"id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:163:\"@^(?:https?://(?:(?:api\\.soundcloud\\.com/(?:playlist|track)s/\\d+)|soundcloud\\.com/[^/]+/(?:sets/)?[^/]+)(?:(?:\\?secret_token=|/(?=s-))(?'secret_token'[-\\w]+))?)\$@D\";}}}s:8:\"required\";b:1;}s:12:\"secret_token\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:15:\"@^(?:[-\\w]+)\$@D\";}}}s:8:\"required\";b:0;}}s:22:\"attributePreprocessors\";a:2:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:163:\"@(?'id'https?://(?:(?:api\\.soundcloud\\.com/(?:playlist|track)s/\\d+)|soundcloud\\.com/[^/]+/(?:sets/)?[^/]+)(?:(?:\\?secret_token=|/(?=s-))(?'secret_token'[-\\w]+))?)@\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:166:\"@^(?'id'https?://(?:(?:api\\.soundcloud\\.com/(?:playlist|track)s/\\d+)|soundcloud\\.com/[^/]+/(?:sets/)?[^/]+)(?:(?:\\?secret_token=|/(?=s-))(?'secret_token'[-\\w]+))?)\$@D\";}}s:11:\"filterChain\";a:3:{i:0;R:416;i:1;a:2:{s:8:\"callback\";s:51:\"s9e\\TextFormatter\\Plugins\\MediaEmbed\\Parser::scrape\";s:6:\"params\";a:3:{s:3:\"tag\";N;i:0;a:1:{i:0;a:4:{i:0;s:64:\"@soundcloud\\.com/(?!playlists/|tracks/)[^/]+/(?:sets/)?[^/]+/s-@\";i:1;a:2:{i:0;s:31:\"@playlists/(?'playlist_id'\\d+)@\";i:1;s:25:\"@tracks/(?'track_id'\\d+)@\";}i:2;a:2:{i:0;s:11:\"playlist_id\";i:1;s:8:\"track_id\";}i:3;s:158:\"https://api.soundcloud.com/resolve?url={@id}&_status_code_map%5B302%5D=200&_status_format=json&client_id=b45b1aa10f1ac2941910a7f0d10f8e28&app_version=7a35847b\";}}s:8:\"cacheDir\";N;}}i:2;R:95;}s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:235;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:7:\"SPOTIFY\";a:9:{s:10:\"attributes\";a:3:{s:3:\"url\";R:357;s:3:\"uri\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:60:\"!^(?:spotify:(?:album|artist|user|track(?:set)?):[,:\\w]+)\$!D\";}}}s:8:\"required\";b:0;}s:4:\"path\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:43:\"!^(?:(?:album|artist|track|user)/[/\\w]+)\$!D\";}}}s:8:\"required\";b:0;}}s:22:\"attributePreprocessors\";a:2:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:61:\"!(?'uri'spotify:(?:album|artist|user|track(?:set)?):[,:\\w]+)!\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:73:\"!(?:open|play)\\.spotify\\.com/(?'path'(?:album|artist|track|user)/[/\\w]+)!\";}}s:11:\"filterChain\";a:3:{i:0;R:416;i:1;R:95;i:2;R:389;}s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:235;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:6:\"TWITCH\";a:9:{s:10:\"attributes\";a:4:{s:3:\"url\";R:357;s:7:\"channel\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:18:\"#^(?:(?!m/)\\w+)\$#D\";}}}s:8:\"required\";b:0;}s:10:\"archive_id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:15:\"#^(?:[0-9]+)\$#D\";}}}s:8:\"required\";b:0;}s:10:\"chapter_id\";R:597;}s:22:\"attributePreprocessors\";a:1:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:88:\"#twitch\\.tv/(?'channel'(?!m/)\\w+)(?:/b/(?'archive_id'[0-9]+)|/c/(?'chapter_id'[0-9]+))?#\";}}s:11:\"filterChain\";a:4:{i:0;R:416;i:1;a:2:{s:8:\"callback\";s:51:\"s9e\\TextFormatter\\Plugins\\MediaEmbed\\Parser::scrape\";s:6:\"params\";a:3:{s:3:\"tag\";N;i:0;a:1:{i:0;a:3:{i:0;s:21:\"!twitch\\.tv/m/[0-9]+!\";i:1;s:61:\"!channel=(?'channel'\\w+)&.*?archive_id=(?'archive_id'[0-9]+)!\";i:2;a:2:{i:0;s:10:\"archive_id\";i:1;s:7:\"channel\";}}}s:8:\"cacheDir\";N;}}i:2;R:95;i:3;R:389;}s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:235;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:5:\"VIMEO\";a:9:{s:10:\"attributes\";R:427;s:22:\"attributePreprocessors\";a:2:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:46:\"!vimeo\\.com/(?:channels/[^/]+/)?(?'id'[0-9]+)!\";}i:1;R:440;}s:11:\"filterChain\";R:415;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:235;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:4:\"VINE\";a:9:{s:10:\"attributes\";a:2:{s:3:\"url\";R:357;s:2:\"id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:14:\"!^(?:[^/]+)\$!D\";}}}s:8:\"required\";b:1;}}s:22:\"attributePreprocessors\";a:2:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:25:\"!vine\\.co/v/(?'id'[^/]+)!\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:17:\"!^(?'id'[^/]+)\$!D\";}}s:11:\"filterChain\";R:415;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:235;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:7:\"YOUTUBE\";a:9:{s:10:\"attributes\";a:4:{s:3:\"url\";R:357;s:2:\"id\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:15:\"!^(?:[-\\w]+)\$!D\";}}}s:8:\"required\";b:1;}s:1:\"t\";R:359;s:4:\"list\";a:2:{s:11:\"filterChain\";R:662;s:8:\"required\";b:0;}}s:22:\"attributePreprocessors\";a:5:{i:0;a:2:{i:0;s:3:\"url\";i:1;s:45:\"!youtube\\.com/(?:watch.*?v=|v/)(?'id'[-\\w]+)!\";}i:1;a:2:{i:0;s:3:\"url\";i:1;s:25:\"!youtu\\.be/(?'id'[-\\w]+)!\";}i:2;a:2:{i:0;s:3:\"url\";i:1;s:18:\"![#&?]t=(?'t'\\d+)!\";}i:3;a:2:{i:0;s:3:\"url\";i:1;s:23:\"!&list=(?'list'[-\\w]+)!\";}i:4;a:2:{i:0;s:3:\"url\";i:1;s:18:\"!^(?'id'[-\\w]+)\$!D\";}}s:11:\"filterChain\";R:415;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:235;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}}}");
	}

	/**
	* Return a new instance of s9e\TextFormatter\Renderer
	*
	* @return s9e\TextFormatter\Renderer
	*/
	public static function getRenderer()
	{
		return unserialize("O:42:\"s9e\\TextFormatter\\Bundles\\Fatdown\\Renderer\":3:{s:13:\"\000*\000htmlOutput\";b:1;s:9:\"\000*\000params\";a:0:{}s:18:\"metaElementsRegexp\";s:22:\"(<[eis]>[^<]*</[eis]>)\";}");
	}
}