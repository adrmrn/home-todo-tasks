<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.12.17
 * Time: 20:41
 */

namespace Shared\Application\Event;


use Ramsey\Uuid\UuidInterface;

class Event implements \JsonSerializable
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
    private $occurredAt;
    /**
     * @var int
     */
    private $eventId;

    /**
     * Event constructor.
     *
     * @param string                     $domain
     * @param string                     $name
     * @param \Ramsey\Uuid\UuidInterface $entityId
     * @param array                      $data
     * @param \DateTimeImmutable         $occurredAt
     */
    public function __construct(string $domain, string $name, UuidInterface $entityId, array $data = [],
                                \DateTimeImmutable $occurredAt = NULL)
    {
        $this->domain     = $domain;
        $this->name       = $name;
        $this->entityId   = $entityId;
        $this->data       = $data;
        $this->occurredAt = NULL === $occurredAt ? new \DateTimeImmutable() : $occurredAt;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function domain(): string
    {
        return $this->domain;
    }

    public function data(): array
    {
        return $this->data;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        return [
            'name'        => $this->name,
            'domain'      => $this->domain,
            'entity_id'   => $this->entityId->toString(),
            'data'        => $this->data,
            'occurred_at' => $this->occurredAt->format(DATE_ISO8601),
        ];
    }
}