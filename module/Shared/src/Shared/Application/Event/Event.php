<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.12.17
 * Time: 20:41
 */

namespace Shared\Application\Event;


use Ramsey\Uuid\UuidInterface;

class Event
{
    /**
     * @var string
     */
    private $domain;
    /**
     * @var string
     */
    private $name;
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $entityId;
    /**
     * @var array
     */
    private $data;
    /**
     * @var \DateTimeImmutable
     */
    private $occuredAt;

    /**
     * Event constructor.
     *
     * @param string                     $domain
     * @param string                     $name
     * @param \Ramsey\Uuid\UuidInterface $entityId
     * @param array                      $data
     */
    public function __construct(string $domain, string $name, UuidInterface $entityId, array $data = [])
    {
        $this->domain    = $domain;
        $this->name      = $name;
        $this->entityId  = $entityId;
        $this->data      = $data;
        $this->occuredAt = new \DateTimeImmutable();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function domain(): string
    {
        return $this->domain;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'id'         => $this->entityId->toString(),
            'data'       => $this->data,
            'occured_at' => $this->occuredAt->format(DATE_ISO8601),
        ];
    }
}