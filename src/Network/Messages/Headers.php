<?php

namespace BitWasp\Bitcoin\Network\Messages;

use BitWasp\Bitcoin\Block\BlockHeaderInterface;
use BitWasp\Bitcoin\Network\NetworkSerializable;
use BitWasp\Bitcoin\Serializer\Block\HexBlockHeaderSerializer;
use BitWasp\Bitcoin\Serializer\Network\Message\HeadersSerializer;
use BitWasp\Buffertools\Parser;
use InvalidArgumentException;

class Headers extends NetworkSerializable implements \Countable
{
    /**
     * @var BlockHeaderInterface[]
     */
    protected $headers = [];

    /**
     * @param BlockHeaderInterface[] $headers
     */
    public function __construct(array $headers = [])
    {
        foreach ($headers as $header) {
            $this->addHeader($header);
        }
    }

    /**
     * @return string
     */
    public function getNetworkCommand()
    {
        return 'headers';
    }

    /**
     * @return \BitWasp\Bitcoin\Block\BlockHeaderInterface[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->headers);
    }

    /**
     * @param integer $index
     * @return BlockHeaderInterface
     */
    public function getHeader($index)
    {
        if (false === isset($this->headers[$index])) {
            throw new InvalidArgumentException('No header exists at this index');
        }

        return $this->headers[$index];
    }

    /**
     * @param BlockHeaderInterface $header
     * @return $this
     */
    public function addHeader(BlockHeaderInterface $header)
    {
        $this->headers[] = $header;
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Bitcoin\SerializableInterface::getBuffer()
     */
    public function getBuffer()
    {
        return (new HeadersSerializer(new HexBlockHeaderSerializer()))->serialize($this);
    }
}
