<?php

namespace Domain\Model\Rsvp;

use Domain\Model\Meetup\MeetupId;
use Domain\Model\User\UserId;

final class Rsvp
{
    const YES = 'yes';
    const NO = 'no';

    private $userId;
    private $answer;
    private $rsvpId;
    /**
     * @var MeetupId
     */
    private $meetupId;

    private function __construct(RsvpId $rsvpId, MeetupId $meetupId, UserId $userId, $answer)
    {
        $this->userId = $userId;
        $this->answer = $answer;
        $this->rsvpId = $rsvpId;
        $this->meetupId = $meetupId;
    }

    public static function yes(RsvpId $rsvpId, MeetupId $meetupId, UserId $userId) : Rsvp
    {
        return new self($rsvpId, $meetupId, $userId, self::YES);
    }
    
    public static function no(RsvpId $rsvpId, MeetupId $meetupId, UserId $userId) : Rsvp
    {
        return new self($rsvpId, $meetupId, $userId, self::NO);
    }

    public function changeToYes()
    {
        if ($this->answer !== self::NO) {
            throw new \LogicException('You can only change to yes if the current answer is no');
        }

        $this->answer = self::YES;
    }

    public function changeToNo()
    {
        if ($this->answer !== self::YES) {
            throw new \LogicException('You can only change to no if the current answer is yes');
        }

        $this->answer = self::NO;
    }
}
