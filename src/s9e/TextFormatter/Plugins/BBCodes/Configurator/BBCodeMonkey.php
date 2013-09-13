<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2013 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Plugins\BBCodes\Configurator;

use DOMDocument;
use DOMXPath;
use Exception;
use InvalidArgumentException;
use RuntimeException;
use s9e\TextFormatter\Configurator;
use s9e\TextFormatter\Configurator\Helpers\RegexpBuilder;
use s9e\TextFormatter\Configurator\Helpers\TemplateHelper;
use s9e\TextFormatter\Configurator\Items\Attribute;
use s9e\TextFormatter\Configurator\Items\AttributePreprocessor;
use s9e\TextFormatter\Configurator\Items\AttributeFilter;
use s9e\TextFormatter\Configurator\Items\ProgrammableCallback;
use s9e\TextFormatter\Configurator\Items\Tag;

class BBCodeMonkey
{
	/**
	* @var Configurator Instance of Configurator;
	*/
	protected $configurator;

	/**
	* @var array List of pre- and post- filters that are explicitly allowed in BBCode definitions.
	*            We use a whitelist approach because there are so many different risky callbacks
	*            that it would be too easy to let something dangerous slip by, e.g.: unlink,
	*            system, etc...
	*/
	protected static $allowedFilters = [
		'addslashes',
		'dechex',
		'intval',
		'json_encode',
		'ltrim',
		'mb_strtolower',
		'mb_strtoupper',
		'rawurlencode',
		'rtrim',
		'str_rot13',
		'stripslashes',
		'strrev',
		'strtolower',
		'strtotime',
		'strtoupper',
		'trim',
		'ucfirst',
		'ucwords',
		'urlencode'
	];

	/**
	* @var array Regexps used in the named subpatterns generated automatically for composite
	*            attributes. For instance, "foo={NUMBER},{NUMBER}" will be transformed into
	*            'foo={PARSE=#^(?<foo0>\\d+),(?<foo1>\\d+)$#D}'
	*/
	public $tokenRegexp = [
		'COLOR'      => '[a-zA-Z]+|#[0-9a-fA-F]+',
		'EMAIL'      => '[^@]+@.+?',
		'FLOAT'      => '(?:0|-?[1-9]\\d*)(?:\\.\\d+)?(?:e[1-9]\\d*)?',
		'ID'         => '[-a-zA-Z0-9_]+',
		'IDENTIFIER' => '[-a-zA-Z0-9_]+',
		'INT'        => '0|-?[1-9]\\d*',
		'INTEGER'    => '0|-?[1-9]\\d*',
		'NUMBER'     => '\\d+',
		'RANGE'      => '\\d+',
		'SIMPLETEXT' => '[-a-zA-Z0-9+.,_ ]+',
		'UINT'       => '0|[1-9]\\d*'
	];

	/**
	* @var array List of token types that are used to represent raw, unfiltered content
	*/
	public $unfilteredTokens = [
		'ANYTHING',
		'TEXT'
	];

	/**
	* Constructor
	*
	* @param  Configurator $configurator Instance of Configurator
	* @return void
	*/
	public function __construct(Configurator $configurator)
	{
		$this->configurator = $configurator;
	}

	/**
	* Create a BBCode and its underlying tag and template(s) based on its reference usage
	*
	* @param  string $usage     BBCode usage, e.g. [B]{TEXT}[/b]
	* @param  mixed  $templates Template, or an array of [predicate => template]
	* @return array             An array containing three elements: 'bbcode', 'bbcodeName' and 'tag'
	*/
	public function create($usage, $templates)
	{
		if (!is_array($templates))
		{
			$templates = ['' => $templates];
		}

		// Parse the BBCode usage
		$config = $this->parse($usage);

		// Prepare the return array
		$return = [
			'bbcode'     => $config['bbcode'],
			'bbcodeName' => $config['bbcodeName'],
			'tag'        => $config['tag']
		];

		// Set the templates for this BBCode's tag
		foreach ($templates as $predicate => $template)
		{
			$return['tag']->templates->set(
				$predicate,
				$this->replaceTokens(
					$template,
					$config['tokens'],
					$config['passthroughToken']
				)
			);
		}

		return $return;
	}

	/**
	* Create a BBCode based on its reference usage
	*
	* @param  string $usage BBCode usage, e.g. [B]{TEXT}[/b]
	* @return array
	*/
	public function parse($usage)
	{
		$tag    = new Tag;
		$bbcode = new BBCode;

		// This is the config we will return
		$config = [
			'tag'              => $tag,
			'bbcode'           => $bbcode,
			'passthroughToken' => null
		];

		$regexp = '#^'
		        // [BBCODE
		        . '\\[(?<bbcodeName>.+?)'
		        // ={TOKEN}
		        . '(?<defaultAttribute>=\\S+?)?'
		        // foo={TOKEN} bar={TOKEN1},{TOKEN2}
		        . '(?<attributes>(?:\\s+[^=]+=\\S+?)*?)?'
		        // ] or /] or ]{TOKEN}[/BBCODE]
		        . '(?:\\s*/?\\]|\\]\\s*(?<content>.*?)\\s*(?<endTag>\\[/\\1]))'
		        . '$#i';

		if (!preg_match($regexp, trim($usage), $m))
		{
			throw new InvalidArgumentException('Cannot interpret the BBCode definition');
		}

		// Save the BBCode's name
		$config['bbcodeName'] = BBCode::normalizeName($m['bbcodeName']);

		// Prepare the attributes definition, e.g. "foo={BAR}"
		$definitions = preg_split('#\\s+#', trim($m['attributes']), -1, PREG_SPLIT_NO_EMPTY);

		// If there's a default attribute, we prepend it to the list using the BBCode's name as
		// attribute name
		if (!empty($m['defaultAttribute']))
		{
			array_unshift($definitions, $m['bbcodeName'] . $m['defaultAttribute']);
		}

		// Append the content token to the attributes list under the name "content" if it's anything
		// but raw {TEXT} (or other unfiltered tokens)
		if (!empty($m['content']))
		{
			$regexp = '#^\\{' . RegexpBuilder::fromList($this->unfilteredTokens) . '[0-9]*\\}$#D';

			if (preg_match($regexp, $m['content']))
			{
				$config['passthroughToken'] = substr($m['content'], 1, -1);
			}
			else
			{
				$definitions[] = 'content=' . $m['content'];
				$bbcode->contentAttributes[] = 'content';
			}
		}

		// Separate the attribute definitions from the BBCode options
		$attributeDefinitions = [];
		foreach ($definitions as $definition)
		{
			$pos   = strpos($definition, '=');
			$name  = substr($definition, 0, $pos);
			$value = substr($definition, 1 + $pos);

			// If name starts with $ then it's a BBCode options, if it starts with # it's a rule and
			// otherwise it's an attribute definition
			if ($name[0] === '$')
			{
				$optionName = substr($name, 1);

				if ($value === 'true')
				{
					$value = true;
				}
				elseif ($value === 'false')
				{
					$value = false;
				}

				$bbcode->$optionName = $value;
			}
			elseif ($name[0] === '#')
			{
				$ruleName = substr($name, 1);

				// Supports #denyChild=foo,bar
				foreach (explode(',', $value) as $value)
				{
					if ($value === 'true')
					{
						$value = true;
					}
					elseif ($value === 'false')
					{
						$value = false;
					}

					$tag->rules->$ruleName($value);
				}
			}
			else
			{
				$attrName = strtolower(trim($name));
				$attributeDefinitions[] = [$attrName, $value];
			}
		}

		// Add the attributes and get the token translation table
		$tokens = $this->addAttributes($attributeDefinitions, $bbcode, $tag);

		// Test whether the passthrough token is used for something else, in which case we need
		// to unset it
		if (isset($tokens[$config['passthroughToken']]))
		{
			$config['passthroughToken'] = null;
		}

		// Add the list of known (and only the known) tokens to the config
		$config['tokens'] = array_filter($tokens);

		return $config;
	}

	/**
	* Replace tokens in a template
	*
	* @param  string $template         Original template
	* @param  array  $tokens           Array of [tokenId => attrName]
	* @param  string $passthroughToken Token ID of the token that represents the BBCode's contents
	* @return string                   Processed template
	*/
	public function replaceTokens($template, array $tokens, $passthroughToken)
	{
		return TemplateHelper::replaceTokens(
			$template,
			'#\\{(?:[A-Z]+[A-Z_0-9]*|@[-\\w]+)\\}#',
			function ($m) use ($tokens, $passthroughToken)
			{
				$tokenId = substr($m[0], 1, -1);

				// Acknowledge {@foo} as an XPath expression even outside of attribute value
				// templates
				if ($tokenId[0] === '@')
				{
					return ['expression', $tokenId];
				}

				// Test whether this is a known token
				if (isset($tokens[$tokenId]))
				{
					// Replace with the corresponding attribute
					return ['expression', '@' . $tokens[$tokenId]];
				}

				// Test whether the token is used as passthrough
				if ($tokenId === $passthroughToken)
				{
					// Use substring() to exclude the <st/> and <et/> children
					return ['passthrough', false];
				}

				// Undefined token. If it's the name of a filter, consider it's an error
				if ($this->isFilter($tokenId))
				{
					throw new RuntimeException('Token {' . $tokenId . '} is ambiguous or undefined');
				}

				// Use the token's name as parameter name
				return ['expression', '$' . $tokenId];
			}
		);
	}

	/**
	* Parse a string of attribute definitions and add the attributes/options to the tag/BBCode
	*
	* Attributes come in two forms. Most commonly, in the form of a single token, e.g.
	*   [a href={URL} title={TEXT}]
	*
	* Sometimes, however, we need to parse more than one single token. For instance, the phpBB
	* [FLASH] BBCode uses two tokens separated by a comma:
	*   [flash={NUMBER},{NUMBER}]{URL}[/flash]
	*
	* In addition, some custom BBCodes circulating for phpBB use a combination of token and static
	* text such as:
	*   [youtube]http://www.youtube.com/watch?v={SIMPLETEXT}[/youtube]
	*
	* Any attribute that is not a single token is implemented as an attribute preprocessor, with
	* each token generating a matching attribute. Tentatively, those  of those attributes are
	* created by taking the attribute preprocessor's name and appending a unique number counting the
	* number of created attributes. In the [FLASH] example above, an attribute preprocessor named
	* "flash" would be created as well as two attributes named "flash0" and "flash1" respectively.
	*
	* @link https://www.phpbb.com/community/viewtopic.php?f=46&t=2127991
	* @link https://www.phpbb.com/community/viewtopic.php?f=46&t=579376
	*
	* @param  array  $definitions List of attributes definitions as [[name, definition]*]
	* @param  BBCode $bbcode      Owner BBCode
	* @param  Tag    $tag         Owner tag
	* @return array               Array of [token id => attribute name] where FALSE in place of the
	*                             name indicates that the token is ambiguous (e.g. used multiple
	*                             times)
	*/
	protected function addAttributes(array $definitions, BBCode $bbcode, Tag $tag)
	{
		/**
		* @var array List of composites' tokens. Each element is composed of an attribute name, the
		*            composite's definition and an array of tokens
		*/
		$composites = [];

		/**
		* @var array Map of [tokenId => attrName]. If the same token is used in multiple attributes
		*            it is set to FALSE
		*/
		$table = [];

		foreach ($definitions as list($attrName, $definition))
		{
			// The first attribute defined is set as default
			if (!isset($bbcode->defaultAttribute))
			{
				$bbcode->defaultAttribute = $attrName;
			}

			// Parse the tokens in that definition
			$tokens = self::parseTokens($definition);

			if (empty($tokens))
			{
				throw new RuntimeException('No valid tokens found in ' . $attrName . "'s definition " . $definition);
			}

			// Test whether this attribute has one single all-encompassing token
			if ($tokens[0]['content'] === $definition)
			{
				$token = $tokens[0];

				if ($token['type'] === 'PARSE')
				{
					foreach ($token['regexps'] as $regexp)
					{
						$tag->attributePreprocessors->add($attrName, $regexp);
					}
				}
				elseif (isset($tag->attributes[$attrName]))
				{
					throw new RuntimeException("Attribute '" . $attrName . "' is declared twice");
				}
				else
				{
					// Remove the "useContent" option and add the attribute's name to the list of
					// attributes to use this BBCode's content
					if (!empty($token['options']['useContent']))
					{
						$bbcode->contentAttributes[] = $attrName;
					}
					unset($token['options']['useContent']);

					// Add the attribute
					$tag->attributes[$attrName] = $this->generateAttribute($token);

					// Record the token ID if applicable
					$tokenId = $token['id'];
					$table[$tokenId] = (isset($table[$tokenId]))
					                 ? false
					                 : $attrName;
				}
			}
			else
			{
				$composites[] = [$attrName, $definition, $tokens];
			}
		}

		foreach ($composites as list($attrName, $definition, $tokens))
		{
			$regexp  = '/^';
			$lastPos = 0;

			$usedTokens = [];

			foreach ($tokens as $token)
			{
				$tokenId   = $token['id'];
				$tokenType = $token['type'];

				if ($tokenType === 'PARSE')
				{
					// Disallow {PARSE} tokens because attribute preprocessors cannot feed into
					// other attribute preprocessors
					throw new RuntimeException('{PARSE} tokens can only be used has the sole content of an attribute');
				}

				// Ensure that tokens are only used once per definition so we don't have multiple
				// subpatterns using the same name
				if (isset($usedTokens[$tokenId]))
				{
					throw new RuntimeException('Token {' . $tokenId . '} used multiple times in attribute ' . $attrName . "'s definition");
				}
				$usedTokens[$tokenId] = 1;

				// Find the attribute name associated with this token, or create an attribute
				// otherwise
				if (isset($table[$tokenId]))
				{
					$matchName = $table[$tokenId];

					if ($matchName === false)
					{
						throw new RuntimeException('Token {' . $tokenId . "} used in attribute '" . $attrName . "' is ambiguous");
					}
				}
				else
				{
					// The name of the named subpattern and the corresponding attribute is based on
					// the attribute preprocessor's name, with an incremented ID that ensures we
					// don't overwrite existing attributes
					$i = 0;
					do
					{
						$matchName = $attrName . $i;
						++$i;
					}
					while (isset($tag->attributes[$matchName]));

					// Create the attribute that corresponds to this subpattern
					$tag->attributes[$matchName] = new Attribute;

					// Append the corresponding filter
					$filter = $this->configurator->attributeFilters->get('#' . strtolower($tokenType));
					$tag->attributes[$matchName]->filterChain->append($filter);

					// Record the attribute name associated with this token ID
					$table[$tokenId] = $matchName;
				}

				// Append the literal text between the last position and current position
				$regexp .= preg_quote(substr($definition, $lastPos, $token['pos'] - $lastPos), '/');

				// Grab the expression that corresponds to the token type, or use a catch-all
				// expression otherwise
				$expr = (isset($this->tokenRegexp[$tokenType]))
				      ? $this->tokenRegexp[$tokenType]
				      : '.+?';

				// Append the named subpattern. Its name is made of the attribute preprocessor's
				// name and the subpattern's position
				$regexp .= '(?<' . $matchName . '>' . $expr . ')';

				// Update the last position
				$lastPos = $token['pos'] + strlen($token['content']);
			}

			// Append the literal text that follows the last token and finish the regexp
			$regexp .= preg_quote(substr($definition, $lastPos), '#') . '$/D';

			// Add the attribute preprocessor to the config
			$tag->attributePreprocessors->add($attrName, $regexp);
		}

		// Now create attributes generated from attribute preprocessors. For instance, preprocessor
		// #(?<width>\\d+),(?<height>\\d+)# will generate two attributes named "width" and height
		// with a regexp filter "#^(?:\\d+)$#D", unless they were explicitly defined otherwise
		$newAttributes = [];
		foreach ($tag->attributePreprocessors as $attributePreprocessor)
		{
			foreach ($attributePreprocessor->getAttributes() as $attrName => $regexp)
			{
				if (isset($tag->attributes[$attrName]))
				{
					// This attribute was already explicitly defined, nothing else to add
					continue;
				}

				if (isset($newAttributes[$attrName])
				 && $newAttributes[$attrName] !== $regexp)
				{
					throw new RuntimeException("Ambiguous attribute '" . $attrName . "' created using different regexps needs to be explicitly defined");
				}

				$newAttributes[$attrName] = $regexp;
			}
		}

		foreach ($newAttributes as $attrName => $regexp)
		{
			$filter = $this->configurator->attributeFilters->get('#regexp');

			// Create the attribute using this regexp as filter
			$tag->attributes[$attrName] = new Attribute;
			$tag->attributes[$attrName]->filterChain->append($filter)->setRegexp($regexp);
		}

		return $table;
	}

	/**
	* Parse and return all the tokens contained in a definition
	*
	* @param  string $definition
	* @return array
	*/
	protected static function parseTokens($definition)
	{
		// This regexp should match a regexp, including its delimiters and optionally the i, s
		// and/or u flags
		$regexpMatcher = '(.).*?(?<!\\\\)(?:\\\\\\\\)*+\\g{-1}[DSUisu]*';

		$tokenTypes = [
			'choice' => 'CHOICE[0-9]*=(?<choices>.+?)',
			'map'    => 'MAP[0-9]*=(?<map>.+?)',
			'parse'  => 'PARSE=(?<regexps>' . $regexpMatcher . '(?:,' . $regexpMatcher . ')*)',
			'range'  => 'RAN(?:DOM|GE)[0-9]*=(?<min>-?[0-9]+),(?<max>-?[0-9]+)',
			'regexp' => 'REGEXP[0-9]*=(?<regexp>' . $regexpMatcher . ')',
			'other'  => '(?<other>[A-Z_]+[0-9]*)'
		];

		// Capture the content of every token in that attribute's definition. Usually there will
		// only be one, as in "foo={URL}" but some older BBCodes use a form of composite
		// attributes such as [FLASH={NUMBER},{NUMBER}]
		preg_match_all(
			'#\\{(' . implode('|', $tokenTypes) . ')(?<options>(?:;[^;]*)*)\\}#',
			$definition,
			$matches,
			PREG_SET_ORDER | PREG_OFFSET_CAPTURE
		);

		$tokens = [];
		foreach ($matches as $m)
		{
			if (isset($m['other'][0])
			 && preg_match('#^(?:CHOICE|MAP|REGEXP|PARSE|RANDOM|RANGE)#', $m['other'][0]))
			{
				throw new RuntimeException("Malformed token '" . $m['other'][0] . "'");
			}

			$token = [
				'pos'     => $m[0][1],
				'content' => $m[0][0],
				'options' => []
			];

			// Get this token's type by looking at the start of the match
			$head = $m[1][0];
			$pos  = strpos($head, '=');

			if ($pos === false)
			{
				// {FOO}
				$token['id'] = $head;
			}
			else
			{
				// {FOO=...}
				$token['id'] = substr($head, 0, $pos);

				// Copy the content of named subpatterns into the token's config
				foreach ($m as $k => $v)
				{
					if (!is_numeric($k) && $k !== 'options' && $v[1] !== -1)
					{
						$token[$k] = $v[0];
					}
				}
			}

			// The token's type is its id minus the number, e.g. NUMBER1 => NUMBER
			$token['type'] = rtrim($token['id'], '0123456789');

			// Parse the options
			$options = (isset($m['options'][0])) ? $m['options'][0] : '';
			foreach (preg_split('#;+#', $options, -1, PREG_SPLIT_NO_EMPTY) as $pair)
			{
				$pos = strpos($pair, '=');

				if ($pos === false)
				{
					// Options with no value are set to true, e.g. {FOO;useContent}
					$k = $pair;
					$v = true;
				}
				else
				{
					$k = substr($pair, 0, $pos);
					$v = substr($pair, 1 + $pos);
				}

				$token['options'][$k] = $v;
			}

			// {PARSE} tokens can have several regexps separated with commas, we split them up here
			if ($token['type'] === 'PARSE')
			{
				// Match all occurences of a would-be regexp followed by a comma or the end of the
				// string
				preg_match_all('#' . $regexpMatcher . '(?:,|$)#', $token['regexps'], $m);

				$regexps = [];
				foreach ($m[0] as $regexp)
				{
					// remove the potential comma at the end
					$regexps[] = rtrim($regexp, ',');
				}

				$token['regexps'] = $regexps;
			}

			$tokens[] = $token;
		}

		return $tokens;
	}

	/**
	* Generate an attribute based on a token
	*
	* @param  array  $token  Token this attribute is based on
	* @return void
	*/
	protected function generateAttribute(array $token)
	{
		$attribute = new Attribute;

		if (isset($token['options']['preFilter']))
		{
			$this->appendFilters($attribute, $token['options']['preFilter']);
			unset($token['options']['preFilter']);
		}

		if ($token['type'] === 'REGEXP')
		{
			$filter = $this->configurator->attributeFilters->get('#regexp');
			$attribute->filterChain->append($filter)->setRegexp($token['regexp']);
		}
		elseif ($token['type'] === 'RANGE')
		{
			$filter = $this->configurator->attributeFilters->get('#range');
			$attribute->filterChain->append($filter)->setRange($token['min'], $token['max']);
		}
		elseif ($token['type'] === 'RANDOM')
		{
			$attribute->generator = new ProgrammableCallback('mt_rand');
			$attribute->generator->addParameterByValue((int) $token['min']);
			$attribute->generator->addParameterByValue((int) $token['max']);
		}
		elseif ($token['type'] === 'CHOICE')
		{
			$filter = $this->configurator->attributeFilters->get('#choice');
			$attribute->filterChain->append($filter)->setValues(
				explode(',', $token['choices']),
				!empty($token['options']['caseSensitive'])
			);
			unset($token['options']['caseSensitive']);
		}
		elseif ($token['type'] === 'MAP')
		{
			// Build the map from the string
			$map = [];
			foreach (explode(',', $token['map']) as $pair)
			{
				$pos = strpos($pair, ':');

				if ($pos === false)
				{
					throw new RuntimeException("Invalid map assignment '" . $pair . "'");
				}

				$map[substr($pair, 0, $pos)] = substr($pair, 1 + $pos);
			}

			// Create the filter then append it to the attribute
			$filter = $this->configurator->attributeFilters->get('#map');
			$attribute->filterChain->append($filter)->setMap(
				$map,
				!empty($token['options']['caseSensitive']),
				!empty($token['options']['strict'])
			);

			// Remove options that are not needed anymore
			unset($token['options']['caseSensitive']);
			unset($token['options']['strict']);
		}
		elseif (!in_array($token['type'], $this->unfilteredTokens, true))
		{
			$filter = $this->configurator->attributeFilters->get('#' . $token['type']);
			$attribute->filterChain->append($filter);
		}

		if (isset($token['options']['postFilter']))
		{
			$this->appendFilters($attribute, $token['options']['postFilter']);
			unset($token['options']['postFilter']);
		}

		// Set the "required" option if "required" or "optional" is set, then remove
		// the "optional" option
		if (isset($token['options']['required']))
		{
			$token['options']['required'] = (bool) $token['options']['required'];
		}
		elseif (isset($token['options']['optional']))
		{
			$token['options']['required'] = !$token['options']['optional'];
		}
		unset($token['options']['optional']);

		foreach ($token['options'] as $k => $v)
		{
			$attribute->$k = $v;
		}

		return $attribute;
	}

	/**
	* Append a list of filters to an attribute's filterChain
	*
	* @param  Attribute $attribute
	* @param  string    $filters   List of filters, separated with commas
	* @return void
	*/
	protected function appendFilters(Attribute $attribute, $filters)
	{
		foreach (preg_split('#\\s*,\\s*#', $filters) as $filterName)
		{
			if (substr($filterName, 0, 1) !== '#'
			 && !in_array($filterName, self::$allowedFilters, true))
			{
				throw new RuntimeException("Filter '" . $filterName . "' is not allowed");
			}

			$filter = $this->configurator->attributeFilters->get($filterName);
			$attribute->filterChain->append($filter);
		}
	}

	/**
	* Test whether a token's name is the name of a filter
	*
	* @param  string $tokenId Token ID, e.g. "TEXT1"
	* @return bool
	*/
	protected function isFilter($tokenId)
	{
		$filterName = rtrim($tokenId, '0123456789');

		if (in_array($filterName, $this->unfilteredTokens, true))
		{
			return true;
		}

		// Try to load the filter
		try
		{
			if ($this->configurator->attributeFilters->get('#' . $filterName))
			{
				return true;
			}
		}
		catch (Exception $e)
		{
		}

		return false;
	}
}