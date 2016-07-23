<?php

namespace Domain\Model\Rsvp;

use Domain\Model\Meetup\MeetupId;
use Domain\Model\User\UserId;

final class Rsvp
{
    const YES = 'yes';
    const NO = 'no';

    /**
     * @var RsvpId
     */
    private $rsvpId;

    /** @var UserId $userId */
    private $userId;

    /** @var MeetupId $meetupId */
    private $meetupId;

    private $answer;

    private function __construct(RsvpId $rsvpId, UserId $userId, MeetupId $meetupId, string $answer)
    {
        $this->rsvpId = $rsvpId;
        $this->userId = $userId;
        $this->meetupId = $meetupId;
        $this->answer = $answer;
    }

    public static function rsvpYes(RsvpId $rsvpId, UserId $userId, MeetupId $meetupId)
    {
        return new self($rsvpId, $userId, $meetupId, self::YES);
    }

    public static function rsvpNo(RsvpId $rsvpId, UserId $userId, MeetupId $meetupId)
    {
        return new self($rsvpId, $userId, $meetupId, self::NO);
    }

    public function changeToNo()
    {
        if ($this->answer === self::NO) {
            throw new \LogicException('You can only change to no if previous answer was not no');
        }

        $this->answer = self::NO;
    }

    public function changeToYes()
    {
        if ($this->answer === self::YES) {
            throw new \LogicException('You can only change to yes if previous answer was not yes');
        }

        $this->answer = self::YES;
    }
}
