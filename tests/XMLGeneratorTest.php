<?php

namespace Tests;

use \AdService\XMLGenerator;
use \DOMXPath;
use \PHPUnit\Framework\TestCase;

class XMLGeneratorTest extends TestCase
    {

	/**
	 * Should produce the XML Document
	 *
	 * @return void
	 */

	public function testShouldProduceXmlDocument()
	    {
		$xml = new XMLGenerator("Url");

		$elements = array(
			     "Country"   => "Россия",
			     "Region"    => "Иркутская область",
			     "City"      => "Иркутск",
			     "Site"      => "Агентзилла",
			     "Type"      => "room",
			     "Operation" => "rent",
			     "Url"       => "http://anylink.ru/example",
			    );

		foreach ($elements as $name => $value)
		    {
			$xml->newElement($name, $value);
		    } //end foreach

		$doc   = $xml->getDoc();
		$xpath = new DOMXPath($doc);

		foreach ($elements as $name => $value)
		    {
			$list  = $xpath->query("//Url/" . $name);
			$this->assertEquals(1, $list->length);
			$this->assertEquals($value, $list[0]->textContent);
		    } //end foreach

	    } //end testShouldProduceXmlDocument()


	/**
	 * Should produce the XML Document with Attributes
	 *
	 * @return void
	 */

	public function testShouldProduceXmlDocumentWithAttributes()
	    {
		$xml = new XMLGenerator("Url");

		$elements = array(
			     "Country"   => "Россия",
			     "Region"    => "Иркутская область",
			     "City"      => "Иркутск",
			     "Site"      => "Агентзилла",
			     "Type"      => "room",
			     "Operation" => "rent",
			     "Url"       => "http://anylink.ru/example",
			    );

		foreach ($elements as $name => $value)
		    {
			$xml->newElement($name, $value, ["a" => 2]);
		    } //end foreach

		$doc   = $xml->getDoc();
		$xpath = new DOMXPath($doc);

		foreach ($elements as $name => $value)
		    {
			$list  = $xpath->query("//Url/" . $name);
			$this->assertEquals(1, $list->length);
			$this->assertEquals($value, $list[0]->textContent);
			$this->assertEquals(2, $list[0]->getAttribute("a"));
		    } //end foreach

	    } //end testShouldProduceXmlDocumentWithAttributes()


	/**
	 * Should generate XMLs from array
	 *
	 * @return void
	 */

	public function testShouldGenerateXmlsFromArray()
	    {
		$xml = new XMLGenerator("Root");

		$elements = array(
			     "Country"   => "Россия",
			     "Region"    => "Иркутская область",
			     "City"      => "Иркутск",
			     "Site"      => "Агентзилла",
			     "Type"      => "room",
			     "Operation" => "rent",
			     "Url"       => "http://anylink.ru/example",
			     "notadded"  => "",
			    );

		$xml->loadArray($elements);

		unset($elements["notadded"]);

		$doc   = $xml->getDoc();
		$xpath = new DOMXPath($doc);

		foreach ($elements as $name => $value)
		    {
			$list  = $xpath->query("//Root/" . $name);
			$this->assertEquals(1, $list->length);
			$this->assertEquals($value, $list[0]->textContent);
		    } //end foreach

	    } //end testShouldGenerateXmlsFromArray()


	/**
	 * Should add subelements
	 *
	 * @return void
	 */

	public function testShouldAddSubelements()
	    {
		$xml     = new XMLGenerator("Root");
		$element = $xml->newElement("Element", "text");
		$xml->newElement("SubElement", "subtext", [], $element);

		$doc   = $xml->getDoc();
		$xpath = new DOMXPath($doc);

		$list  = $xpath->query("//Root/Element/SubElement");
		$this->assertEquals(1, $list->length);
		$this->assertEquals("subtext", $list[0]->textContent);
	    } //end testShouldAddSubelements()


	/**
	 * Should add empty elements
	 *
	 * @return void
	 */

	public function testShouldAddEmptyElements()
	    {
		$xml = new XMLGenerator("Root");
		$xml->newElement("Element", "", [], null, true);

		$doc   = $xml->getDoc();
		$xpath = new DOMXPath($doc);

		$list  = $xpath->query("//Root/Element");
		$this->assertEquals(1, $list->length);
		$this->assertEquals("", $list[0]->textContent);
	    } //end testShouldAddEmptylements()


    } //end class

?>
