<?php

namespace Domain\Model\Meetup;

use Domain\Model\MeetupGroup\MeetupGroupId;
use Domain\Model\Rsvp\Rsvp;
use Domain\Model\Rsvp\RsvpId;
use Domain\Model\Rsvp\RsvpYesOrganiserOnMeetupScheduled;
use Domain\Model\User\UserId;
use Infrastructure\DomainEvents\DomainEventRecordingCapabilities;
use Infrastructure\DomainEvents\RecordsDomainEvents;
use Ramsey\Uuid\Uuid;

final class Meetup implements RecordsDomainEvents
{
    use DomainEventRecordingCapabilities;

    private $meetupId;
    private $title;
    private $scheduledFor;
    private $meetupGroupId;
    private $organiserId;

    private function __construct()
    {
    }

    public static function schedule(
        MeetupId $meetupId,
        MeetupGroupId $meetupGroupId,
        UserId $organiserId,
        string $title, \DateTimeImmutable $scheduledFor) : Meetup
    {
        $meetup = new self();
        $meetup->meetupId = $meetupId;
        $meetup->meetupGroupId = $meetupGroupId;
        $meetup->organiserId = $organiserId;
        $meetup->title = $title;
        $meetup->scheduledFor = $scheduledFor;

        $meetup->recordThat(new MeetupScheduled($meetupId, $meetupGroupId, $organiserId, $title, $scheduledFor));

        return $meetup;
    }

    public function rsvpYes(UserId $userId)
    {
        return Rsvp::yes(RsvpId::fromString((string)Uuid::uuid4()), $this->meetupId, $userId);
    }

    public function rsvpNo(UserId $userId)
    {
        throw new \BadMethodCallException();
    }

    public function meetupId() : MeetupId
    {
        return $this->meetupId;
    }
}
