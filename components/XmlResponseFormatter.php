<?php

namespace app\components;


use DOMDocument;
use DOMElement;
use DOMText;
use yii\base\Arrayable;
use yii\helpers\StringHelper;

class XmlResponseFormatter extends \yii\web\XmlResponseFormatter
{

    public $parameters;
//    public $contentType = 'application/rss+xml';

    public function format($response)
    {
        $charset = $this->encoding === null ? $response->charset : $this->encoding;
        if (stripos($this->contentType, 'charset') === false) {
            $this->contentType .= '; charset=' . $charset;
        }
        $response->getHeaders()->set('Content-Type', $this->contentType);
        if ($response->data !== null) {
            $dom = new DOMDocument($this->version, $charset);
            if (!empty($this->rootTag)) {
                $root = new DOMElement($this->rootTag);


                $dom->appendChild($root);
                if (!empty($this->parameters) && is_array($this->parameters)) {
                    foreach ($this->parameters as $name=>$value) {
                        $root->setAttribute($name, $value);
                    }
                }

                $this->buildXml($root, $response->data);
            } else {
                $this->buildXml($dom, $response->data);
            }
            $response->content = $dom->saveXML();
        }
    }


    protected function buildXml($element, $data)
    {

        if (is_array($data) ||
            ($data instanceof \Traversable && $this->useTraversableAsArray && !$data instanceof Arrayable)
        ) {

            foreach ($data as $name => $value) {

                if ($name == 'setAttributes' || $name == 'cdata' || $name == 'namespace') continue;


                if (is_int($name)) {

                    $this->buildXml($element, $value);

                } elseif ((is_array($value) || is_object($value)) && !isset($value['cdata']) && !isset($value['namespace'])) {

                    $child = new DOMElement($this->getValidXmlElementName($name));
                    $element->appendChild($child);

                    if (isset($data[$name]['setAttributes']))
                    {
                        foreach ($data[$name]['setAttributes'] as $mName=>$mValue) {
                            $child->setAttribute($mName, $mValue);
                        }

                    }

                    $this->buildXml($child, $value);
                } else {

                    if (isset($value['namespace'])) {
                        $child = $element->ownerDocument->createElementNS('1', $name);
                        $element->appendChild($child);

                    }
                    else
                    {
                            $child = new DOMElement($this->getValidXmlElementName($name));
                            $element->appendChild($child);

                    }

                        if (isset($value['cdata'])) {

                        $cdata = $element->ownerDocument->createCDATASection($value['cdata']);
                        $child->appendChild($cdata);
                    }
                        elseif (isset($value['data']))
                        {
                            $child->appendChild(new DOMText($this->formatScalarValue($value['data'])));

                        }
                    else {
                        $child->appendChild(new DOMText($this->formatScalarValue($value)));
                    }
                }

            }
        } elseif (is_object($data)) {
            if ($this->useObjectTags) {
                $child = new DOMElement(StringHelper::basename(get_class($data)));
                $element->appendChild($child);
            } else {
                $child = $element;
            }
            if ($data instanceof Arrayable) {
                $this->buildXml($child, $data->toArray());
            } else {
                $array = [];
                foreach ($data as $name => $value) {
                    $array[$name] = $value;
                }
                $this->buildXml($child, $array);
            }
        } else {
            $element->appendChild(new DOMText($this->formatScalarValue($data)));
        }
    }

}