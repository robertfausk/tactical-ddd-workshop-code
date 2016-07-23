<?php

namespace Domain\Model\Meetup;


use Domain\Model\MeetupGroup\MeetupGroupId;
use Domain\Model\User\UserId;

class MeetupScheduled
{
    private $workingTitle;
    /**
     * @var MeetupId
     */
    private $meetupId;
    /**
     * @var UserId
     */
    private $userId;
    /**
     * @var MeetupGroupId
     */
    private $meetupGroupId;
    /**
     * @var \DateTimeImmutable
     */
    private $scheduledFor;

    public function __construct(
        MeetupId $meetupId,
        UserId $organiserId,
        MeetupGroupId $meetupGroupId,
        string $workingTitle,
        \DateTimeImmutable $scheduledFor
    ) {
        $this->workingTitle = $workingTitle;
        $this->meetupId = $meetupId;
        $this->userId = $organiserId;
        $this->meetupGroupId = $meetupGroupId;
        $this->scheduledFor = $scheduledFor;
    }

    /**
     * @return UserId
     */
    public function organiserId()
    {
        return $this->userId;
    }

    /**
     * @return MeetupId
     */
    public function meetupId()
    {
        return $this->meetupId;
    }
}
