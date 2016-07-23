<?php

namespace Domain\Model\Meetup;

use Domain\Model\User\UserId;

final class Rsvp
{
    const YES = 'yes';
    const NO = 'no';

    /** @var UserId $userId */
    private $userId;

    /** @var MeetupId $meetupId */
    private $meetupId;

    private $answer;

    private function __construct(UserId $userId, MeetupId $meetupId, string $answer)
    {
        $this->userId = $userId;
        $this->meetupId = $meetupId;
        $this->answer = $answer;
    }

    public static function rsvpYes(UserId $userId, MeetupId $meetupId)
    {
        return new self($userId, $meetupId, self::YES);
    }
}
