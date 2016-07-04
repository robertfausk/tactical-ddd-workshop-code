<?php

namespace Domain\Model\Meetup;

use Domain\Model\MeetupGroup\MeetupGroupId;
use Domain\Model\User\UserId;

final class MeetupScheduled
{
    /**
     * @var MeetupId
     */
    private $meetupId;
    /**
     * @var MeetupGroupId
     */
    private $meetupGroupId;
    /**
     * @var UserId
     */
    private $organiserId;
    /**
     * @var string
     */
    private $title;
    /**
     * @var \DateTimeImmutable
     */
    private $scheduledFor;

    public function __construct(
        MeetupId $meetupId,
        MeetupGroupId $meetupGroupId,
        UserId $organiserId,
        string $title,
        \DateTimeImmutable $scheduledFor
    ) {
        $this->meetupId = $meetupId;
        $this->meetupGroupId = $meetupGroupId;
        $this->organiserId = $organiserId;
        $this->title = $title;
        $this->scheduledFor = $scheduledFor;
    }

    public function meetupId()
    {
        return $this->meetupId;
    }

    public function organiserId()
    {
        return $this->organiserId;
    }
}
