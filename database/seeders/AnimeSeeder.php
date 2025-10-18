<?php

namespace Database\Seeders;

use App\Models\Anime;
use App\Models\Character;
use App\Models\VoiceActor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class AnimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getData();

        $voiceActors = Collection::make($data['voice_actors'])->mapWithKeys(function (array $voiceActor, string $slug) {
            $model = VoiceActor::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $voiceActor['name'],
                    'language' => $voiceActor['language'],
                    'description' => $voiceActor['description'],
                ],
            );

            return [$slug => $model];
        });

        $animes = Collection::make($data['animes'])->mapWithKeys(function (array $anime, string $slug) {
            $model = Anime::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $anime['title'],
                    'synopsis' => $anime['synopsis'],
                    'genres' => $anime['genres'],
                ],
            );

            return [$slug => $model];
        });

        Collection::make($data['characters'])->each(function (array $character, string $slug) use ($animes, $voiceActors) {
            $model = Character::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $character['name'],
                    'role' => $character['role'],
                    'anime_id' => $animes[$character['anime_id']]->id,
                ],
            );

            $model->voiceActors()->sync(
                Collection::make($character['voice_actor_ids'])
                    ->map(fn (string $voiceActorSlug) => $voiceActors[$voiceActorSlug]->id)
                    ->all()
            );
        });
    }

    /**
     * @return array{
     *     animes: array<string, array<string, mixed>>,
     *     characters: array<string, array<string, mixed>>,
     *     voice_actors: array<string, array<string, mixed>>
     * }
     */
    private function getData(): array
    {
        return [
            'animes' => [
                'attack-on-titan' => [
                    'title' => 'Attack on Titan',
                    'synopsis' => 'Eren Yeager joins the Scout Regiment to fight against the mysterious Titans and uncover the truth behind their existence.',
                    'genres' => ['Action', 'Drama', 'Dark Fantasy'],
                ],
                'my-hero-academia' => [
                    'title' => 'My Hero Academia',
                    'synopsis' => 'In a world where most people have superpowers, Izuku Midoriya strives to become the number one hero.',
                    'genres' => ['Action', 'Superhero', 'Adventure'],
                ],
                'demon-slayer' => [
                    'title' => 'Demon Slayer: Kimetsu no Yaiba',
                    'synopsis' => 'Tanjiro Kamado becomes a demon slayer after his family is slaughtered and his sister is turned into a demon.',
                    'genres' => ['Action', 'Adventure', 'Historical Fantasy'],
                ],
            ],
            'characters' => [
                'eren-yeager' => [
                    'name' => 'Eren Yeager',
                    'role' => 'Protagonist',
                    'anime_id' => 'attack-on-titan',
                    'voice_actor_ids' => ['yuki-kaji', 'bryce-papenbrook'],
                ],
                'mikasa-ackerman' => [
                    'name' => 'Mikasa Ackerman',
                    'role' => "Elite soldier and Eren's adoptive sister",
                    'anime_id' => 'attack-on-titan',
                    'voice_actor_ids' => ['yui-ishikawa', 'trina-nishimura'],
                ],
                'armin-arlert' => [
                    'name' => 'Armin Arlert',
                    'role' => 'Strategic genius and Scout Regiment member',
                    'anime_id' => 'attack-on-titan',
                    'voice_actor_ids' => ['marina-inoue', 'josh-grelle'],
                ],
                'izuku-midoriya' => [
                    'name' => 'Izuku Midoriya',
                    'role' => 'Aspiring hero and student at U.A. High School',
                    'anime_id' => 'my-hero-academia',
                    'voice_actor_ids' => ['daiki-yamashita', 'justin-briner'],
                ],
                'shoto-todoroki' => [
                    'name' => 'Shoto Todoroki',
                    'role' => 'Dual-quirk hero-in-training',
                    'anime_id' => 'my-hero-academia',
                    'voice_actor_ids' => ['yuki-kaji', 'david-matranga'],
                ],
                'ochaco-uraraka' => [
                    'name' => 'Ochaco Uraraka',
                    'role' => 'Gravity-manipulating hero-in-training',
                    'anime_id' => 'my-hero-academia',
                    'voice_actor_ids' => ['ayane-sakura', 'lucy-christian'],
                ],
                'tanjiro-kamado' => [
                    'name' => 'Tanjiro Kamado',
                    'role' => 'Compassionate demon slayer',
                    'anime_id' => 'demon-slayer',
                    'voice_actor_ids' => ['natsuki-hanae', 'zach-aguilar'],
                ],
                'nezuko-kamado' => [
                    'name' => 'Nezuko Kamado',
                    'role' => "Tanjiro's demon sister",
                    'anime_id' => 'demon-slayer',
                    'voice_actor_ids' => ['akari-kito', 'abby-trott'],
                ],
                'zenitsu-agatsuma' => [
                    'name' => 'Zenitsu Agatsuma',
                    'role' => 'Thunder-breathing demon slayer',
                    'anime_id' => 'demon-slayer',
                    'voice_actor_ids' => ['hiro-shimono', 'alejandro-saad'],
                ],
            ],
            'voice_actors' => [
                'yuki-kaji' => [
                    'name' => 'Yuki Kaji',
                    'language' => 'Japanese',
                    'description' => 'Award-winning Japanese performer celebrated for energetic shonen leads and emotional range.',
                ],
                'bryce-papenbrook' => [
                    'name' => 'Bryce Papenbrook',
                    'language' => 'English',
                    'description' => 'Los Angeles-based voice actor known for youthful heroes across hit action franchises.',
                ],
                'yui-ishikawa' => [
                    'name' => 'Yui Ishikawa',
                    'language' => 'Japanese',
                    'description' => 'Versatile Japanese actress admired for portraying steadfast warriors and gentle heroines alike.',
                ],
                'trina-nishimura' => [
                    'name' => 'Trina Nishimura',
                    'language' => 'English',
                    'description' => 'Seasoned ADR performer bringing heartfelt intensity to English anime dubs since the 2000s.',
                ],
                'marina-inoue' => [
                    'name' => 'Marina Inoue',
                    'language' => 'Japanese',
                    'description' => 'Japanese voice talent and singer recognized for confident, strategic characters.',
                ],
                'josh-grelle' => [
                    'name' => 'Josh Grelle',
                    'language' => 'English',
                    'description' => 'Texas-based actor renowned for earnest leads and quick-witted comedic roles.',
                ],
                'daiki-yamashita' => [
                    'name' => 'Daiki Yamashita',
                    'language' => 'Japanese',
                    'description' => 'Anime award recipient beloved for high-energy portrayals of determined young heroes.',
                ],
                'justin-briner' => [
                    'name' => 'Justin Briner',
                    'language' => 'English',
                    'description' => 'Funimation regular praised for expressive, hopeful protagonists in modern shonen hits.',
                ],
                'david-matranga' => [
                    'name' => 'David Matranga',
                    'language' => 'English',
                    'description' => 'Veteran English voice actor delivering nuanced performances from stoic heroes to conflicted rivals.',
                ],
                'ayane-sakura' => [
                    'name' => 'Ayane Sakura',
                    'language' => 'Japanese',
                    'description' => 'Popular Japanese actress recognized for dynamic tsundere icons and heartfelt supporting roles.',
                ],
                'lucy-christian' => [
                    'name' => 'Lucy Christian',
                    'language' => 'English',
                    'description' => 'Prolific Houston-based performer lending warmth and wit to countless anime favorites.',
                ],
                'natsuki-hanae' => [
                    'name' => 'Natsuki Hanae',
                    'language' => 'Japanese',
                    'description' => 'Japanese seiyuu with a gentle timbre suited for compassionate yet resolute protagonists.',
                ],
                'zach-aguilar' => [
                    'name' => 'Zach Aguilar',
                    'language' => 'English',
                    'description' => 'Rising voice actor featured in blockbuster game and anime franchises with inspiring leads.',
                ],
                'akari-kito' => [
                    'name' => 'Akari Kito',
                    'language' => 'Japanese',
                    'description' => 'Singer and seiyuu cherished for balancing softness and fierce resolve in heroine roles.',
                ],
                'abby-trott' => [
                    'name' => 'Abby Trott',
                    'language' => 'English',
                    'description' => 'Bilingual performer celebrated for heartfelt, resilient characters across anime and games.',
                ],
                'hiro-shimono' => [
                    'name' => 'Hiro Shimono',
                    'language' => 'Japanese',
                    'description' => 'Veteran Japanese actor famed for comedic timing and sudden bursts of dramatic intensity.',
                ],
                'alejandro-saad' => [
                    'name' => 'Alejandro Saab',
                    'language' => 'English',
                    'description' => 'Fan-favorite voice actor and content creator with an energetic, expressive delivery.',
                ],
            ],
        ];
    }
}
