<?php

namespace App\Module\Nightclub\Command;

use App\Core\Command\BaseCommand;
use App\Module\Nightclub\Vo\BodyAction\BodyVo;
use App\Module\Nightclub\Vo\BodyAction\HandVo;
use App\Module\Nightclub\Vo\BodyAction\HeadVo;
use App\Module\Nightclub\Vo\BodyAction\LegVo;
use App\Module\Nightclub\Vo\Dance\DanceStyleCollection;
use App\Module\Nightclub\Vo\Dance\DanceStyleVo;
use App\Module\Nightclub\Vo\Genre\GenreVo;
use App\Module\Nightclub\Vo\Guest\GuestResolverVo;
use App\Module\Nightclub\Vo\Guest\GuestVo;
use App\Module\Nightclub\Vo\Paint\BarPaintVo;
use App\Module\Nightclub\Vo\Paint\BorderedBoxPaintVo;
use App\Module\Nightclub\Vo\Paint\DanceFloorPaintVo;
use App\Module\Nightclub\Vo\Paint\DancingGuestPaintVo;
use App\Module\Nightclub\Vo\Paint\DebugDataPaintVo;
use App\Module\Nightclub\Vo\Paint\DrinkingGuestPaintVo;
use App\Module\Nightclub\Vo\Track\TrackVo;
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
    private const MINIMUM_TRACK_DURATION = 3;
    private const MAXIMUM_TRACK_DURATION = 10;
    private const GUEST_IN_ROW = 6;
    private const MIN_BORDER_BOW_WIDTH = 30;
    private const SIGNATURE = 'nightclub:show {--guests=5} {--tracks=5}';

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
                'name' => $hipHopGenre->getName(),
                'acceptedGenreList' => [
                    $hipHopGenre,
                    $rnbGenre,
                ],
                'headAction' => HeadVo::withActiveShaking(),
                'bodyAction' => BodyVo::withActiveBodyShaking(),
                'handAction' => HandVo::withBeltOriented(),
                'legAction' => LegVo::withFlexStyle(),
            ]),
            new DanceStyleVo([
                'name' => $electrodanceGenre->getName(),
                'acceptedGenreList' => [
                    $electrodanceGenre,
                    $electrohouseGenre,
                    $houseGenre,
                ],
                'headAction' => HeadVo::withPassiveStyle(),
                'bodyAction' => BodyVo::withActiveBodyShaking(),
                'handAction' => HandVo::withSpinStyle(),
                'legAction' => LegVo::withActiveStyle(),
            ]),
            new DanceStyleVo([
                'name' => $popGenre->getName(),
                'acceptedGenreList' => [
                    $popGenre,
                ],
                'headAction' => HeadVo::withRareShaking(),
                'bodyAction' => BodyVo::withActiveBodyShaking(),
                'handAction' => HandVo::withSpinStyle(),
                'legAction' => LegVo::withPassiveStyle(),
            ]),
        ]);

        $faker = \Faker\Factory::create('ru_RU');
        $faker->addProvider(new \RauweBieten\PhpFakerMusic\Dance($faker));

        $acceptedGenreInClub = [
            $hipHopGenre,
            $electrodanceGenre,
            $popGenre,
        ];

        $trackList = [];
        $numberOfTracks = (int)$this->option('tracks');
        for ($i = 0; $i < $numberOfTracks; $i++) {
            /** @var $faker \RauweBieten\PhpFakerMusic\Dance */
            $trackList[] = new TrackVo([
                'author' => $faker->musicDanceArtist(),
                'name' => $faker->musicDanceAlbum(),
                'duration' => random_int(self::MINIMUM_TRACK_DURATION, self::MAXIMUM_TRACK_DURATION),
                'genre' => Base::randomElement($acceptedGenreInClub),
            ]);
        }

        $guestList = [];
        $numberOfGuests = (int)$this->option('guests');
        for ($i = 0; $i < $numberOfGuests; $i++) {
            $gender = random_int(0, 1) === 1 ? Person::GENDER_MALE : Person::GENDER_FEMALE;
            $lastName = $faker->lastName;
            if ($gender === Person::GENDER_FEMALE) {
                $lastName .= 'a';
            }
            $guestList[] = new GuestVo([
                'firstName' => $faker->firstName($gender),
                'lastName' => $lastName,
                'danceGenreList' => Base::randomElements(
                    $genreList,
                    random_int(1, 3)
                ),
            ]);
        }

        $welcomeMessage = '
            Добро пожаловать на вечеринку!
            Треков: ' . \count($trackList) . ' ♪
            Посетителей: ' . \count($guestList);
        $this->showBlinkingScreen($welcomeMessage, self::WELCOME_MESSAGE_DURATION);

        $emptyDrinkBottles = 0;
        /** @var \App\Module\Nightclub\Vo\Track\TrackVo $trackVo */
        foreach ($trackList as $trackVo) {
            $totalTrackTimeInMinutes = gmdate('i:s', $trackVo->getDuration());

            $danceStyle = $danceStyleCollection->getByName($trackVo->getGenre()->getName());
            if ($danceStyle === null) {
                throw new \LogicException("Dance style for genre {$trackVo->getGenre()->getName()} not found");
            }

            $guestResolver = new GuestResolverVo(
                $guestList,
                $danceStyle
            );

            for ($i = 0; $i <= $trackVo->getDuration(); $i += self::ONE_FRAME_DURATION) {
                usleep(self::ONE_FRAME_DURATION * 1000000);
                system('clear');

                $currentTrackTimeInMinutes = gmdate('i:s', $i);
                $this->info(
                    BorderedBoxPaintVo::withRowList([
                        "{$trackVo->getCompositionName()} [{$currentTrackTimeInMinutes} / {$totalTrackTimeInMinutes}]",
                        "♪ Жанр: {$trackVo->getGenre()->getName()}",
                    ])
                );

                $danceAction = $danceStyleCollection->getByName($trackVo->getGenre()->getName());
                if ($danceAction === null) {
                    throw new \LogicException("Dance style for genre {$trackVo->getGenre()->getName()} not found");
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
                    BorderedBoxPaintVo::withStringContent(
                        new DanceFloorPaintVo($dancingGuestPaintList, self::GUEST_IN_ROW),
                        self::MIN_BORDER_BOW_WIDTH
                    )
                );

                $drinkingGuestPaintList = [];
                $guestsWannaDrink = $i % 3 === 0;
                foreach ($guestResolver->getDrinkingGuestList() as $guest) {
                    if ($guestsWannaDrink) {
                        $emptyDrinkBottles++;
                    }
                    $drinkingGuestPaintList[] = new DrinkingGuestPaintVo(
                        $guest,
                        $guestsWannaDrink
                    );
                }

                $this->info(
                    BorderedBoxPaintVo::withStringContent(
                        new BarPaintVo(
                            $drinkingGuestPaintList,
                            self::GUEST_IN_ROW
                        )
                    )
                );

                $this->info(
                    BorderedBoxPaintVo::withStringContent(
                        new DebugDataPaintVo(
                            $guestList,
                            $danceStyleCollection->getList()
                        ),
                        self::MIN_BORDER_BOW_WIDTH
                    )
                );
            }
        }

        $endPartMessage = "
            Вечеринка окончена, наступило утро!
            Выпито бутылок водки: {$emptyDrinkBottles} шт.
            
            github.com/codemistake
        ";
        $this->showBlinkingScreen($endPartMessage, self::WELCOME_MESSAGE_DURATION);
    }

    /**
     * @param string $content
     * @param int $durationInSeconds
     */
    private function showBlinkingScreen(string $content, int $durationInSeconds): void
    {
        $messageText = BorderedBoxPaintVo::withStringContent($content, self::MIN_BORDER_BOW_WIDTH, 3);
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
