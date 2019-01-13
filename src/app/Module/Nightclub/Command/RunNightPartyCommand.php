<?php

namespace App\Module\Nightclub\Command;

use App\Core\Command\BaseCommand;
use App\Module\Nightclub\GuestResolver\GuestResolver;
use App\Module\Nightclub\Vo\BodyAction\BodyVo;
use App\Module\Nightclub\Vo\BodyAction\HandVo;
use App\Module\Nightclub\Vo\BodyAction\HeadVo;
use App\Module\Nightclub\Vo\BodyAction\LegVo;
use App\Module\Nightclub\Vo\Dance\DanceStyleCollection;
use App\Module\Nightclub\Vo\Dance\DanceStyleVo;
use App\Module\Nightclub\Vo\Genre\GenreVo;
use App\Module\Nightclub\Vo\GuestVo;
use App\Module\Nightclub\Vo\Paint\BarPaintVo;
use App\Module\Nightclub\Vo\Paint\BorderedBoxVo;
use App\Module\Nightclub\Vo\Paint\DanceFloorPaintVo;
use App\Module\Nightclub\Vo\Paint\DancingGuestPaintVo;
use App\Module\Nightclub\Vo\Paint\DrinkingGuestPaintVo;
use App\Module\Nightclub\Vo\TrackVo;
use Faker\Provider\Base;
use Faker\Provider\Person;

/**
 * Class RunNightPartyCommand
 * @package App\Module\Nightclub\Command
 */
class RunNightPartyCommand extends BaseCommand
{
    private const WELCOME_MESSAGE_DURATION = 5;
    private const ONE_FRAME_DURATION = 0.6;
    private const GUEST_IN_ROW = 6;
    private const MIN_BORDER_BOW_WIDTH = 30;
    private const SIGNATURE = 'nightclub:init {guests=5} {tracks=5}';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = self::SIGNATURE;

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function handle(): void
    {
        $rnbGenre = new GenreVo(['name' => 'R&B',]);
        $hipHopGenre = new GenreVo(['name' => 'Hip-hop',]);
        $electrohouseGenre = new GenreVo(['name' => 'Electrohouse',]);
        $electrodanceGenre = new GenreVo(['name' => 'Electrodance',]);
        $houseGenre = new GenreVo(['name' => 'House',]);
        $popGenre = new GenreVo(['name' => 'Pop',]);

        $genreList = [
            $rnbGenre,
            $hipHopGenre,
            $electrohouseGenre,
            $electrodanceGenre,
            $houseGenre,
            $popGenre,
        ];

        $danceStyleCollection = new DanceStyleCollection([
            new DanceStyleVo([
                'name' => $rnbGenre->getName(),
                'acceptedGenreList' => [
                    $rnbGenre,
                    $hipHopGenre,
                ],
                'headAction' => HeadVo::withPassiveStyle(),
                'bodyAction' => BodyVo::withSlowBodyShaking(),
                'handAction' => HandVo::withBeltOriented(),
                'legAction' => LegVo::withPassiveStyle(),
            ]),
            new DanceStyleVo([
                'name' => $electrohouseGenre->getName(),
                'acceptedGenreList' => [
                    $electrohouseGenre,
                    $electrodanceGenre,
                    $houseGenre,
                ],
                'headAction' => HeadVo::withPassiveStyle(),
                'bodyAction' => BodyVo::withSlowBodyShaking(),
                'handAction' => HandVo::withBeltOriented(),
                'legAction' => LegVo::withPassiveStyle(),
            ]),
            new DanceStyleVo([
                'name' => $popGenre->getName(),
                'acceptedGenreList' => [
                    $popGenre,
                ],
                'headAction' => HeadVo::withPassiveStyle(),
                'bodyAction' => BodyVo::withActiveBodyShaking(),
                'handAction' => HandVo::withBeltOriented(),
                'legAction' => LegVo::withPassiveStyle(),
            ]),
        ]);

        $faker = \Faker\Factory::create('ru_RU');
        $faker->addProvider(new \RauweBieten\PhpFakerMusic\Dance($faker));

        $acceptedGenreInClub = [
            $rnbGenre,
            $electrohouseGenre,
            $popGenre,
        ];

        $trackList = [];
        $numberOfTracks = (int)$this->argument('tracks');
        for ($i = 0; $i < $numberOfTracks; $i++) {
            /** @var GenreVo $genreName */
            $genreName = Base::randomElement($acceptedGenreInClub);

            /** @var $faker \RauweBieten\PhpFakerMusic\Dance */
            $trackList[] = new TrackVo([
                'author' => $faker->musicDanceArtist(),
                'name' => $faker->musicDanceAlbum(),
                'duration' => random_int(4, 18),
                'genreName' => $genreName->getName(),
            ]);
        }

        $guestList = [];
        $numberOfGuests = (int)$this->argument('guests');
        for ($i = 0; $i < $numberOfGuests; $i++) {
            $gender = random_int(0, 1) === 1 ? Person::GENDER_MALE : Person::GENDER_FEMALE;
            $lastName = $faker->lastName;
            if ($gender === Person::GENDER_FEMALE) {
                $lastName .= 'a';
            }
            $guestList[] = new GuestVo([
                'firstName' => $faker->firstName($gender),
                'lastName' => $lastName,
                'danceGenreNameList' => Base::randomElements(
                    $genreList,
                    random_int(1, 3)
                ),
            ]);
        }

        $welcomeMessage = '
            Добро пожаловать на вечеринку!
            Треков: ' . \count($trackList) . ' ♪
            Посетителей: ' . \count($guestList);
        $this->showBlinkingScreen(
            $welcomeMessage,
            self::WELCOME_MESSAGE_DURATION
        );

        /** @var TrackVo $trackVo */
        foreach ($trackList as $trackVo) {
            $totalTrackTimeInMinutes = gmdate('i:s', $trackVo->getDuration());

            $genreName = $trackVo->getGenreName();
            if ($genreName === null) {
                throw new \LogicException("Track doesn't have a genre");
            }

            $danceStyle = $danceStyleCollection->getByName($genreName);
            if ($danceStyle === null) {
                throw new \LogicException("Dance style for genre {$genreName} not found");
            }

            $guestResolver = new GuestResolver(
                $guestList,
                $danceStyle
            );

            for ($i = 0; $i <= $trackVo->getDuration(); $i += self::ONE_FRAME_DURATION) {
                usleep(self::ONE_FRAME_DURATION * 1000000);
                system('clear');

                $currentTrackTimeInMinutes = gmdate('i:s', $i);
                $compositionTimeTracking = "[{$currentTrackTimeInMinutes} / {$totalTrackTimeInMinutes}]";
                $this->info(
                    BorderedBoxVo::withRowList([
                        "{$trackVo->getAuthor()} - {$trackVo->getName()} {$compositionTimeTracking}",
                        "♪ Жанр: {$trackVo->getGenreName()}",
                    ])
                );

                $danceAction = $danceStyleCollection->getByName($genreName);
                if ($danceAction === null) {
                    throw new \LogicException("Dance style for genre {$genreName} not found");
                }

                $headAction = Base::randomElement($danceAction->getHeadAction()->getActionList());
                $bodyAction = Base::randomElement($danceAction->getBodyAction()->getActionList());
                $legAction = Base::randomElement($danceAction->getLegAction()->getActionList());
                $leftHandAction = Base::randomElement($danceAction->getHandAction()->getLeftHandActionList());
                $rightHandAction = Base::randomElement($danceAction->getHandAction()->getRightHandActionList());

                $dancingGuestPaintList = [];
                foreach ($guestResolver->getDancingGuestList() as $guest) {
                    $dancingGuestPaintList[] = new DancingGuestPaintVo(
                        $guest,
                        $headAction,
                        $bodyAction,
                        $legAction,
                        $leftHandAction,
                        $rightHandAction
                    );
                }
                $this->info(
                    BorderedBoxVo::withStringContent(
                        new DanceFloorPaintVo($dancingGuestPaintList, 5),
                        self::MIN_BORDER_BOW_WIDTH
                    )
                );

                $drinkingGuestPaintList = [];
                $guestsWannaDrink = $i % 3 === 0;
                foreach ($guestResolver->getDrinkingGuestList() as $guest) {
                    $drinkingGuestPaintList[] = new DrinkingGuestPaintVo(
                        $guest,
                        $guestsWannaDrink
                    );
                }
                $this->info(
                    BorderedBoxVo::withStringContent(
                        new BarPaintVo($drinkingGuestPaintList, self::GUEST_IN_ROW)
                    )
                );


                $debugDataList = [];
                /** @var GuestVo $guestVo */
                foreach ($guestList as $guestVo) {
                    $genreNameList = [];
                    foreach ($guestVo->getDancingGenreList() as $genreVo) {
                        $genreNameList[] = $genreVo->getName();
                    }

                    $debugRow = "{$guestVo->getFirstName()} {$guestVo->getLastName()}: " . implode(',', $genreNameList);
                    $debugDataList[] = $debugRow;
                }

                $debugDataList[] = ' ';
                foreach ($danceStyleCollection->getList() as $danceStyleVo) {
                    $acceptedGenreNameList = [];
                    foreach ($danceStyleVo->getAcceptedGenreList() as $genreVo) {
                        $acceptedGenreNameList[] = $genreVo->getName();
                    }
                    $debugDataList[] = "{$danceStyleVo->getName()}: " . implode(',', $acceptedGenreNameList);
                }

                $this->info(
                    BorderedBoxVo::withRowList(
                        $debugDataList,
                        self::MIN_BORDER_BOW_WIDTH
                    )
                );
            }
        }

        $this->info('Done');
    }

    /**
     * @param string $content
     * @param int $durationInSeconds
     */
    private function showBlinkingScreen(string $content, int $durationInSeconds): void
    {
        $messageText = BorderedBoxVo::withStringContent($content, self::MIN_BORDER_BOW_WIDTH, 3);
        for ($i = 0; $i < $durationInSeconds; $i++) {
            sleep(1);
            system('clear');
            if ($i % 2 === 0) {
                $this->info($messageText);
                continue;
            }
            $this->warn($messageText);
        }
    }
}
