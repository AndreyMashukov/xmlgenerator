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
			    );

		$xml->loadArray($elements);

		$doc   = $xml->getDoc();
		$xpath = new DOMXPath($doc);

		foreach ($elements as $name => $value)
		    {
			$list  = $xpath->query("//Root/" . $name);
			$this->assertEquals(1, $list->length);
			$this->assertEquals($value, $list[0]->textContent);
		    } //end foreach

	    } //end testShouldGenerateXmlsFromArray()


    } //end class

?>
