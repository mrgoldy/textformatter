<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2013 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Bundles;

abstract class S18 extends \s9e\TextFormatter\Bundle
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
	* @var Callback executed before render() and on each entry before renderMulti(), receives the parsed text as argument
	*/
	public static $beforeRender = 's9e\\TextFormatter\\Bundles\\S18\\Helper::applyTimeformat';

	/**
	* Return a new instance of s9e\TextFormatter\Parser
	*
	* @return s9e\TextFormatter\Parser
	*/
	public static function getParser()
	{
		$parser = unserialize("O:24:\"s9e\\TextFormatter\\Parser\":4:{s:16:\"\000*\000pluginsConfig\";a:5:{s:7:\"BBCodes\";a:5:{s:7:\"bbcodes\";a:48:{s:4:\"ABBR\";a:0:{}s:7:\"ACRONYM\";R:5;s:6:\"ANCHOR\";R:5;s:1:\"B\";R:5;s:3:\"BDO\";R:5;s:5:\"BLACK\";R:5;s:4:\"BLUE\";R:5;s:2:\"BR\";R:5;s:6:\"CENTER\";R:5;s:4:\"CODE\";a:1:{s:16:\"defaultAttribute\";s:4:\"lang\";}s:5:\"COLOR\";R:5;s:5:\"EMAIL\";a:1:{s:17:\"contentAttributes\";a:1:{i:0;s:5:\"email\";}}s:5:\"FLASH\";a:1:{s:17:\"contentAttributes\";a:1:{i:0;s:7:\"content\";}}s:4:\"FONT\";R:5;s:3:\"FTP\";a:1:{s:17:\"contentAttributes\";a:1:{i:0;s:3:\"ftp\";}}s:4:\"GLOW\";R:5;s:5:\"GREEN\";R:5;s:2:\"HR\";R:5;s:4:\"HTML\";R:5;s:1:\"I\";R:5;s:3:\"IMG\";a:2:{s:17:\"contentAttributes\";a:1:{i:0;s:3:\"src\";}s:16:\"defaultAttribute\";s:3:\"alt\";}s:4:\"IURL\";a:1:{s:17:\"contentAttributes\";a:1:{i:0;s:4:\"iurl\";}}s:4:\"LEFT\";R:5;s:2:\"LI\";R:5;s:4:\"LIST\";a:1:{s:16:\"defaultAttribute\";s:4:\"type\";}s:3:\"LTR\";R:5;s:2:\"ME\";R:5;s:4:\"MOVE\";R:5;s:5:\"NOBBC\";R:5;s:3:\"PRE\";R:5;s:5:\"QUOTE\";a:1:{s:16:\"defaultAttribute\";s:6:\"author\";}s:3:\"RED\";R:5;s:5:\"RIGHT\";R:5;s:3:\"RTL\";R:5;s:1:\"S\";R:5;s:6:\"SHADOW\";R:5;s:4:\"SIZE\";R:5;s:3:\"SUB\";R:5;s:3:\"SUP\";R:5;s:5:\"TABLE\";R:5;s:2:\"TD\";R:5;s:4:\"TIME\";a:1:{s:17:\"contentAttributes\";a:1:{i:0;s:4:\"time\";}}s:2:\"TR\";R:5;s:2:\"TT\";R:5;s:1:\"U\";R:5;s:3:\"URL\";a:1:{s:17:\"contentAttributes\";a:1:{i:0;s:3:\"url\";}}s:5:\"WHITE\";R:5;s:3:\"PHP\";a:2:{s:20:\"predefinedAttributes\";a:1:{s:4:\"lang\";s:3:\"php\";}s:7:\"tagName\";s:4:\"CODE\";}}s:10:\"quickMatch\";s:1:\"[\";s:6:\"regexp\";s:285:\"#\\[/?(A(?>BBR|CRONYM|NCHOR)|B(?>(?>R|DO|L(?>ACK|UE)))?|C(?>ENTER|O(?>DE|LOR))|EMAIL|F(?>LASH|ONT|TP)|G(?>LOW|REEN)|H(?>R|TML)|I(?>MG|URL)?|L(?:EFT|I(?>ST)?|TR)|M(?>OV)?E|NOBBC|P(?>HP|RE)|QUOTE|R(?>ED|IGHT|TL)|S(?>(?>HADOW|IZE|U[BP]))?|T(?>[DRT]|ABLE|IME)|U(?>RL)?|WHITE)(?=[\\] =:/])#iS\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:9:\"Emoticons\";a:4:{s:6:\"regexp\";s:89:\"/(?>8\\)|:(?>[DP[o]|'\\[|\\)\\)?|-[*X[\\\\]|:\\))|;[)D]|>:[D[]|\\?\\?\\?|C:-\\)|O(?>0|:-\\))|\\^-\\^)/S\";s:7:\"tagName\";s:1:\"E\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:9:\"Autoemail\";a:6:{s:8:\"attrName\";s:5:\"email\";s:10:\"quickMatch\";s:1:\"@\";s:6:\"regexp\";s:39:\"/\\b[-a-z0-9_+.]+@[-a-z0-9.]*[a-z0-9]/Si\";s:7:\"tagName\";s:5:\"EMAIL\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:8:\"Autolink\";a:6:{s:8:\"attrName\";s:3:\"url\";s:10:\"quickMatch\";s:3:\"://\";s:6:\"regexp\";s:49:\"#(?>f|ht)tps?://\\S(?>[^\\s\\[\\]]*(?>\\[\\w*\\])?)++#iS\";s:7:\"tagName\";s:3:\"URL\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}s:12:\"HTMLElements\";a:5:{s:10:\"quickMatch\";s:1:\"<\";s:6:\"prefix\";s:4:\"html\";s:6:\"regexp\";s:196:\"#<(?>/((?:[asu]|b(?>r|lockquote)?|del|em|hr|i(?>mg|ns)?|pre))|((?:[asu]|b(?>r|lockquote)?|del|em|hr|i(?>mg|ns)?|pre))((?>\\s+[a-z][-a-z]*(?>\\s*=\\s*(?>\"[^\"]*\"|'[^']*'|[^\\s\"'=<>`]+))?)*+)\\s*/?)\\s*>#i\";s:11:\"regexpLimit\";i:10000;s:17:\"regexpLimitAction\";s:4:\"warn\";}}s:14:\"registeredVars\";a:1:{s:9:\"urlConfig\";a:2:{s:14:\"allowedSchemes\";s:18:\"/^(?>f|ht)tps?\$/Di\";s:13:\"requireScheme\";b:0;}}s:14:\"\000*\000rootContext\";a:3:{s:15:\"allowedChildren\";s:2:\"_\035\";s:18:\"allowedDescendants\";s:2:\"\377\037\";s:5:\"flags\";i:0;}s:13:\"\000*\000tagsConfig\";a:61:{s:1:\"E\";a:7:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:42:\"s9e\\TextFormatter\\Parser::filterAttributes\";s:6:\"params\";a:4:{s:3:\"tag\";N;s:9:\"tagConfig\";N;s:14:\"registeredVars\";N;s:6:\"logger\";N;}}}s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:129;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\020\001\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:4:\"ABBR\";a:8:{s:10:\"attributes\";a:1:{s:4:\"abbr\";a:1:{s:8:\"required\";b:1;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:0;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:7:\"ACRONYM\";a:8:{s:10:\"attributes\";a:1:{s:7:\"acronym\";R:94;}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:97;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:6:\"ANCHOR\";a:8:{s:10:\"attributes\";a:1:{s:6:\"anchor\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:23:\"/^#?[a-z][-a-z_0-9]*\$/i\";}}}s:8:\"required\";b:1;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:97;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:1:\"B\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:2;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:3:\"BDO\";a:8:{s:10:\"attributes\";a:1:{s:3:\"bdo\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:17:\"/^(?>ltr|rtl)\$/Di\";}}}s:8:\"required\";b:1;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:97;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:5:\"BLACK\";R:125;s:4:\"BLUE\";R:125;s:2:\"BR\";R:76;s:6:\"CENTER\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:512;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:2:\"_\035\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:4:\"CODE\";a:8:{s:10:\"attributes\";a:1:{s:4:\"lang\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:57:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterSimpletext\";s:6:\"params\";a:1:{s:9:\"attrValue\";N;}}}s:8:\"required\";b:0;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:912;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:2;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:5:\"COLOR\";a:8:{s:10:\"attributes\";a:1:{s:5:\"color\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:52:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterColor\";s:6:\"params\";R:162;}}s:8:\"required\";b:1;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:127;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:5:\"EMAIL\";a:8:{s:10:\"attributes\";a:1:{s:5:\"email\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:52:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterEmail\";s:6:\"params\";R:162;}}s:8:\"required\";b:1;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:66;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:3;s:15:\"allowedChildren\";s:2:\"S\031\";s:18:\"allowedDescendants\";s:2:\"\363\033\";}s:5:\"FLASH\";a:9:{s:10:\"attributes\";a:3:{s:7:\"content\";a:2:{s:11:\"filterChain\";a:2:{i:0;a:2:{s:8:\"callback\";s:49:\"s9e\\TextFormatter\\Bundles\\S18\\Helper::prependHttp\";s:6:\"params\";R:162;}i:1;a:2:{s:8:\"callback\";s:50:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterUrl\";s:6:\"params\";a:3:{s:9:\"attrValue\";N;s:9:\"urlConfig\";N;s:6:\"logger\";N;}}}s:8:\"required\";b:1;}s:6:\"flash0\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterNumber\";s:6:\"params\";R:162;}}s:8:\"required\";b:1;}s:6:\"flash1\";R:211;}s:22:\"attributePreprocessors\";a:1:{i:0;a:2:{i:0;s:5:\"flash\";i:1;s:34:\"/^(?<flash0>\\d+),(?<flash1>\\d+)\$/D\";}}s:11:\"filterChain\";a:2:{i:0;a:2:{s:8:\"callback\";s:55:\"s9e\\TextFormatter\\Parser::executeAttributePreprocessors\";s:6:\"params\";a:2:{s:3:\"tag\";N;s:9:\"tagConfig\";N;}}i:1;R:78;}s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:86;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:3;s:15:\"allowedChildren\";s:2:\"\020\001\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:4:\"FONT\";a:8:{s:10:\"attributes\";a:1:{s:4:\"font\";a:2:{s:11:\"filterChain\";R:159;s:8:\"required\";b:1;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:127;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:3:\"FTP\";a:8:{s:10:\"attributes\";a:1:{s:3:\"ftp\";a:2:{s:11:\"filterChain\";a:2:{i:0;a:2:{s:8:\"callback\";s:48:\"s9e\\TextFormatter\\Bundles\\S18\\Helper::prependFtp\";s:6:\"params\";R:162;}i:1;R:204;}s:8:\"required\";b:1;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:192;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:3;s:15:\"allowedChildren\";s:2:\"S\031\";s:18:\"allowedDescendants\";s:2:\"\363\033\";}s:4:\"GLOW\";a:9:{s:10:\"attributes\";a:2:{s:5:\"glow0\";R:174;s:5:\"glow1\";R:211;}s:22:\"attributePreprocessors\";a:1:{i:0;a:2:{i:0;s:4:\"glow\";i:1;s:52:\"/^(?<glow0>[a-zA-Z]+|#[0-9a-fA-F]+),(?<glow1>\\d+)\$/D\";}}s:11:\"filterChain\";R:220;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:640;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:2:\"\020\001\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:5:\"GREEN\";R:125;s:2:\"HR\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:641;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:2:\"\020\001\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:4:\"HTML\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:64;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\034\";s:18:\"allowedDescendants\";s:2:\"\000\034\";}s:1:\"I\";R:125;s:3:\"IMG\";a:8:{s:10:\"attributes\";a:4:{s:3:\"alt\";a:1:{s:8:\"required\";b:0;}s:6:\"height\";a:2:{s:11:\"filterChain\";R:212;s:8:\"required\";b:0;}s:3:\"src\";a:2:{s:11:\"filterChain\";a:1:{i:0;R:204;}s:8:\"required\";b:1;}s:5:\"width\";R:285;}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:86;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\020\001\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:4:\"IURL\";a:8:{s:10:\"attributes\";a:1:{s:4:\"iurl\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:48:\"s9e\\TextFormatter\\Bundles\\S18\\Helper::filterIurl\";s:6:\"params\";R:206;}}s:8:\"required\";b:1;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:192;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:3;s:15:\"allowedChildren\";s:2:\"S\031\";s:18:\"allowedDescendants\";s:2:\"\363\033\";}s:4:\"LEFT\";R:148;s:2:\"LI\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:11:\"closeParent\";a:1:{s:2:\"LI\";i:1;}s:5:\"flags\";i:512;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:5;s:15:\"allowedChildren\";s:2:\"_\035\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:4:\"LIST\";a:8:{s:10:\"attributes\";a:1:{s:4:\"type\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:211:\"/^(?:armenian|c(?>ircle|jk-ideographic)|d(?:ecimal(?>-leading-zero)?|isc)|georgian|h(?:ebrew|iragana(?>-iroha)?)|katakana(?>-iroha)?|lower-(?>alpha|greek|latin|roman)|none|square|upper-(?>alpha|latin|roman))\$/Di\";}}}s:8:\"required\";b:0;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:672;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:2:\"0\000\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:3:\"LTR\";R:148;s:2:\"ME\";a:8:{s:10:\"attributes\";a:1:{s:2:\"me\";R:94;}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:150;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:6;s:15:\"allowedChildren\";s:2:\"\037\035\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:4:\"MOVE\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:97;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:5:\"NOBBC\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:80;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:4;s:15:\"allowedChildren\";s:2:\"\000\000\";s:18:\"allowedDescendants\";s:2:\"\000\000\";}s:3:\"PRE\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:1:{s:5:\"flags\";i:896;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:5:\"QUOTE\";a:8:{s:10:\"attributes\";a:3:{s:6:\"author\";R:283;s:4:\"date\";R:285;s:4:\"link\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:115:\"!^(?:board=\\d+;)?(?:t(?:opic|hreadid)=[\\dmsg#./]{1,40}(?:;start=[\\dmsg#./]{1,40})?|msg=\\d+?|action=profile;u=\\d+)\$!\";}}}s:8:\"required\";b:0;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:150;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:2;s:15:\"allowedChildren\";s:2:\"_\035\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:3:\"RED\";R:125;s:5:\"RIGHT\";R:148;s:3:\"RTL\";R:148;s:1:\"S\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:275;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"_\035\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:6:\"SHADOW\";a:9:{s:10:\"attributes\";a:2:{s:5:\"color\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:29:\"/^(?:[#0-9a-zA-Z\\-]{3,12})\$/D\";}}}s:8:\"required\";b:1;}s:9:\"direction\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:44:\"/^(?:left|right|top|bottom|[0123]\\d{0,2})\$/D\";}}}s:8:\"required\";b:1;}}s:22:\"attributePreprocessors\";a:1:{i:0;a:2:{i:0;s:6:\"shadow\";i:1;s:83:\"/^(?<color>[#0-9a-zA-Z\\-]{3,12}),(?<direction>left|right|top|bottom|[0123]\\d{0,2})/\";}}s:11:\"filterChain\";R:220;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:97;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:4:\"SIZE\";a:8:{s:10:\"attributes\";a:1:{s:4:\"size\";a:2:{s:11:\"filterChain\";a:1:{i:0;a:2:{s:8:\"callback\";s:53:\"s9e\\TextFormatter\\Parser\\BuiltInFilters::filterRegexp\";s:6:\"params\";a:2:{s:9:\"attrValue\";N;i:0;s:101:\"/^([1-9][\\d]?p[xt]|small(?:er)?|larger?|xx?-(?:small|large)|medium|(?:0\\.[1-9]|[1-9](\\.\\d\\d?)?)?em)\$/\";}}}s:8:\"required\";b:1;}}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:127;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:0;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:3:\"SUB\";R:341;s:3:\"SUP\";R:341;s:5:\"TABLE\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:328;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:1;s:15:\"allowedChildren\";s:2:\"\020\002\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:2:\"TD\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:11:\"closeParent\";a:2:{s:4:\"GLOW\";i:1;s:2:\"TD\";i:1;}s:5:\"flags\";i:512;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:7;s:15:\"allowedChildren\";s:2:\"_\035\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:4:\"TIME\";a:8:{s:10:\"attributes\";a:1:{s:4:\"time\";R:211;}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:86;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:8;s:15:\"allowedChildren\";s:2:\"\020\001\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:2:\"TR\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:11:\"closeParent\";a:1:{s:2:\"TR\";i:1;}s:5:\"flags\";i:672;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:9;s:15:\"allowedChildren\";s:2:\"\220\000\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:2:\"TT\";R:125;s:1:\"U\";R:125;s:3:\"URL\";a:8:{s:10:\"attributes\";a:1:{s:3:\"url\";R:200;}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:192;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:3;s:15:\"allowedChildren\";s:2:\"S\031\";s:18:\"allowedDescendants\";s:2:\"\363\033\";}s:5:\"WHITE\";R:125;s:6:\"html:a\";a:8:{s:10:\"attributes\";a:1:{s:4:\"href\";R:287;}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:15:\"requireAncestor\";a:1:{i:0;s:4:\"HTML\";}s:5:\"flags\";i:66;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:10;s:15:\"allowedChildren\";s:2:\"S\031\";s:18:\"allowedDescendants\";s:2:\"\363\033\";}s:6:\"html:b\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:15:\"requireAncestor\";R:471;s:5:\"flags\";i:2;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:11;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:15:\"html:blockquote\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:15:\"requireAncestor\";R:471;s:5:\"flags\";i:512;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:12;s:15:\"allowedChildren\";s:2:\"_\035\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:7:\"html:br\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:15:\"requireAncestor\";R:471;s:5:\"flags\";i:161;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:11;s:15:\"allowedChildren\";s:2:\"\020\000\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:8:\"html:del\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:15:\"requireAncestor\";R:471;s:5:\"flags\";i:64;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:11;s:15:\"allowedChildren\";s:2:\"_\035\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:7:\"html:em\";R:478;s:7:\"html:hr\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:15:\"requireAncestor\";R:471;s:5:\"flags\";i:673;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:12;s:15:\"allowedChildren\";s:2:\"\020\000\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:6:\"html:i\";R:478;s:8:\"html:img\";a:8:{s:10:\"attributes\";a:4:{s:3:\"alt\";R:283;s:6:\"height\";R:283;s:3:\"src\";R:287;s:5:\"width\";R:283;}s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";R:496;s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:11;s:15:\"allowedChildren\";s:2:\"\020\000\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:8:\"html:ins\";R:502;s:8:\"html:pre\";a:7:{s:11:\"filterChain\";R:77;s:12:\"nestingLimit\";i:10;s:5:\"rules\";a:2:{s:15:\"requireAncestor\";R:471;s:5:\"flags\";i:896;}s:8:\"tagLimit\";i:1000;s:9:\"bitNumber\";i:12;s:15:\"allowedChildren\";s:2:\"\031\015\";s:18:\"allowedDescendants\";s:2:\"\377\037\";}s:6:\"html:s\";R:478;s:6:\"html:u\";R:478;}}");
		S18\Helper::configureParser($parser);

		return $parser;
	}

	/**
	* Return a new instance of s9e\TextFormatter\Renderer
	*
	* @return s9e\TextFormatter\Renderer
	*/
	public static function getRenderer()
	{
		$renderer = unserialize("O:38:\"s9e\\TextFormatter\\Bundles\\S18\\Renderer\":3:{s:13:\"\000*\000htmlOutput\";b:1;s:16:\"\000*\000dynamicParams\";a:0:{}s:9:\"\000*\000params\";a:10:{s:8:\"IS_GECKO\";s:0:\"\";s:5:\"IS_IE\";s:0:\"\";s:8:\"IS_OPERA\";s:0:\"\";s:6:\"L_CODE\";s:4:\"Code\";s:13:\"L_CODE_SELECT\";s:8:\"[Select]\";s:7:\"L_QUOTE\";s:5:\"Quote\";s:12:\"L_QUOTE_FROM\";s:10:\"Quote from\";s:11:\"L_SEARCH_ON\";s:2:\"on\";s:10:\"SCRIPT_URL\";s:0:\"\";s:12:\"SMILEYS_PATH\";s:0:\"\";}}");
		S18\Helper::configureRenderer($renderer);

		return $renderer;
	}
}