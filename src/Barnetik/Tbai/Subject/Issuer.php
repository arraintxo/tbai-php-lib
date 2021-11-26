<?php

namespace Barnetik\Tbai\Subject;

use Barnetik\Tbai\Interfaces\TbaiXml;
use Barnetik\Tbai\ValueObject\VatId;
use DOMDocument;
use DOMNode;

class Issuer implements TbaiXml
{
    protected VatId $vatId;
    protected string $name;

    public function __construct(VatId $vatId, string $name)
    {
        $this->vatId = $vatId;
        $this->name = $name;
    }

    public function vatId(): VatId
    {
        return $this->vatId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function xml(DOMDocument $domDocument): DOMNode
    {
        $issuer = $domDocument->createElement('Emisor');
        $issuer->append(
            $domDocument->createElement('NIF', $this->vatId),
            $domDocument->createElement('ApellidosNombreRazonSocial', $this->name),
        );
        return $issuer;
    }

    public static function docJson(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'vatId' => [
                    'type' => 'string',
                    'minLength' => 9,
                    'maxLength' => 9,
                    'pattern' => '(([a-z|A-Z]{1}\d{7}[a-z|A-Z]{1})|(\d{8}[a-z|A-Z]{1})|([a-z|A-Z]{1}\d{8}))'
                ],
                'name' => [
                    'type' => 'string',
                    'maxLength' => 120
                ]
            ],
            'required' => ['vatId', 'name']
        ];
    }
}