<?php
declare(strict_types = 1);

use Domain\Model\Meetup\Meetup;
use Domain\Model\Meetup\MeetupId;
use Domain\Model\Meetup\MeetupScheduled;
use Domain\Model\MeetupGroup\MeetupGroup;
use Domain\Model\Rsvp\Rsvp;
use Domain\Model\Rsvp\RsvpId;
use Domain\Model\Rsvp\RsvpYesOrganiserOnMeetupScheduled;
use Domain\Model\User\User;
use Infrastructure\DomainEvents\DomainEventCliLogger;
use Infrastructure\DomainEvents\DomainEventDispatcher;
use Infrastructure\DomainEvents\Fixtures\DummyDomainEvent;
use Infrastructure\Persistence\InMemoryMeetupGroupRepository;
use Infrastructure\Persistence\InMemoryUserRepository;
use Ramsey\Uuid\Uuid;

require __DIR__ . '/vendor/autoload.php';

$userRepository = new InMemoryUserRepository();
$meetupGroupRepository = new InMemoryMeetupGroupRepository();

$eventDispatcher = new DomainEventDispatcher();
$eventDispatcher->subscribeToAllEvents(new DomainEventCliLogger());

$user = new User(
    $userRepository->nextIdentity(),
    'Matthias Noback',
    'matthiasnoback@gmail.com'
);
$userRepository->add($user);

$meetupGroup = new MeetupGroup(
    $meetupGroupRepository->nextIdentity(),
    'Ibuildings Events'
);
$meetupGroupRepository->add($meetupGroup);

$eventDispatcher->dispatch(new DummyDomainEvent());

// Assignment 01
$meetup = Meetup::schedule(
    MeetupId::fromString((string)Uuid::uuid4()),
    $meetupGroup->meetupGroupId(),
    $user->userId(),
    'Tactical DDD workshop',
    new \DateTimeImmutable('2016-07-04 19:00')
);

$rsvp = Rsvp::yes(
    RsvpId::fromString((string)Uuid::uuid4()),
    $meetup->meetupId(),
    $user->userId()
);

$eventDispatcher->registerSubscriber(
    MeetupScheduled::class,
    new RsvpYesOrganiserOnMeetupScheduled()
);

foreach ($meetup->recordedEvents() as $event) {
    $eventDispatcher->dispatch($event);
}
