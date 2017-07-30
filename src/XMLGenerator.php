<?php

namespace AdService;

use \DomDocument;
use \DomElement;

class XMLGenerator
    {

	/**
	 * XML document
	 *
	 * @var DOMDocument
	 */
	private $_doc;

	/**
	 * Prepare to work
	 *
	 * @param string $root root element name
	 *
	 * @return void
	 */

	public function __construct(string $root)
	    {
		$this->_doc  = new DOMDocument("1.0", "utf-8");
		$this->_root = $this->_doc->appendChild($this->_doc->createElement($root));
	    } //end __construct()


	/**
	 * Add new element
	 *
	 * @param string     $name       Name of element
	 * @param mixed      $value      value
	 * @param array      $attributes Attributes
	 * @param DomElement $element    Element to add subelement
	 * @param bool       $empty      True if need empty element
	 *
	 * @return void
	 */

	public function newElement(string $name, $value, array $attributes = [], DomElement $domelement = null, bool $empty = false):DomElement
	    {
		if(is_integer($value) === true && $value > 0 || is_bool($value) === false && (string) $value !== "")
		    {
			$main = $this->_root;
			if ($domelement !== null)
			    {
				$main = $domelement;
			    } //end if

			$element = $main->appendChild($this->_doc->createElement($name));
			$element->appendChild($this->_doc->createTextNode($value));
			if (count($attributes) > 0)
			    {
				foreach ($attributes as $atrname => $atrvalue)
				    {
					$attribute        = $this->_doc->createAttribute($atrname);
					$attribute->value = $atrvalue;
					$element->appendChild($attribute);
				    } //end foreach

			    } //end if

		    }
		else if ($empty === true)
		    {
			$main = $this->_root;
			if ($domelement !== null)
			    {
				$main = $domelement;
			    } //end if

			$element = $main->appendChild($this->_doc->createElement($name));
			if (count($attributes) > 0)
			    {
				foreach ($attributes as $atrname => $atrvalue)
				    {
					$attribute        = $this->_doc->createAttribute($atrname);
					$attribute->value = $atrvalue;
					$element->appendChild($attribute);
				    } //end foreach

			    } //end if

		    } //end if

		return $element;
	    } //end newElement()


	/**
	 * Load array to XML document
	 *
	 * @param array $load Data to load
	 *
	 * @return void
	 */

	public function loadArray(array $load)
	    {
		foreach ($load as $name => $value)
		    {
			$this->newElement($name, $value);
		    } //end foreach

	    } //end loadArray()


	/**
	 * Get XML Document
	 *
	 * @return DOMDocument doc
	 */

	public function getDoc():DOMDocument
	    {
		$this->_doc->formatOutput = true;
		return $this->_doc;
	    } //end getDoc()


    } //end class

?>
