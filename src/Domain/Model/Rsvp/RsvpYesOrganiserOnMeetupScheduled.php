<?php

namespace Domain\Model\Rsvp;

use Domain\Model\Meetup\MeetupScheduled;
use Ramsey\Uuid\Uuid;

final class RsvpYesOrganiserOnMeetupScheduled
{
    public function __invoke(MeetupScheduled $event)
    {
        $rsvp = Rsvp::yes(
            RsvpId::fromString((string)Uuid::uuid4()),
            $event->meetupId(),
            $event->organiserId()
        );

        // TODO persist it ;)
    }
}
