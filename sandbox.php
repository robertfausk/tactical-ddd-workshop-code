<?php
declare(strict_types = 1);

use Domain\Model\Meetup\Meetup;
use Domain\Model\Meetup\MeetupId;
use Domain\Model\Meetup\MeetupScheduled;
use Domain\Model\MeetupGroup\MeetupGroup;
use Domain\Model\Rsvp\Rsvp;
use Domain\Model\Rsvp\RsvpId;
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

$userId = $user->userId();
$meetupGroupId = $meetupGroup->meetupGroupId();

$meetup = Meetup::schedule(
    MeetupId::fromString((string)Uuid::uuid4()),
    $userId,
    $meetupGroupId,
    'symfony catalunya',
    new \DateTimeImmutable()
);

$eventDispatcher->registerSubscriber(
    MeetupScheduled::class,
    function (MeetupScheduled $event) {
        // wrap this ugly code in MeetupRepository
        $rsvp = Rsvp::rsvpYes(RsvpId::fromString((string)Uuid::uuid4()), $event->organiserId(), $event->meetupId());
    }
);

foreach ($meetup->recordedEvents() as $recordedEvent) {
    $eventDispatcher->dispatch($recordedEvent);
}

$eventDispatcher->dispatch(new DummyDomainEvent());
