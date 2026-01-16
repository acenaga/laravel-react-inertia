<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Puppy;
use App\Models\User;
use App\Actions\OptimizeWebpImageAction;
use Illuminate\Support\Facades\Storage;

class PuppySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $puppies = [
            ['name' => 'Bella', 'trait' => 'Always happy', 'image' => '10.jpg'],
            ['name' => 'Rex', 'trait' => 'Fetches everything', 'image' => '9.jpg'],
            ['name' => 'Luna', 'trait' => 'Howls at the moon', 'image' => '8.jpg'],
            ['name' => 'Yoko', 'trait' => 'Ready for anything', 'image' => '6.jpg'],
            ['name' => 'Russ', 'trait' => 'Ready to save the world', 'image' => '5.jpg'],
            ['name' => 'Pupi', 'trait' => 'Loves cheese', 'image' => '4.jpg'],
            ['name' => 'Leia', 'trait' => 'Enjoys naps', 'image' => '3.jpg'],
            ['name' => 'Chase', 'trait' => 'Very good boi', 'image' => '2.jpg'],
            ['name' => 'Frisket', 'trait' => 'Mother of all pups', 'image' => '1.jpg'],
            ['name' => 'Max', 'trait' => 'Loves to run', 'image' => '1.jpg'],
            ['name' => 'Daisy', 'trait' => 'Gentle soul', 'image' => '2.jpg'],
            ['name' => 'Rocky', 'trait' => 'Brave guard', 'image' => '3.jpg'],
            ['name' => 'Molly', 'trait' => 'Sweet and cuddly', 'image' => '4.jpg'],
            ['name' => 'Buddy', 'trait' => 'Best friend ever', 'image' => '5.jpg'],
            ['name' => 'Sadie', 'trait' => 'Playful spirit', 'image' => '6.jpg'],
            ['name' => 'Duke', 'trait' => 'Noble protector', 'image' => '7.jpg'],
            ['name' => 'Sophie', 'trait' => 'Smart learner', 'image' => '8.jpg'],
            ['name' => 'Cooper', 'trait' => 'Energetic player', 'image' => '9.jpg'],
            ['name' => 'Chloe', 'trait' => 'Graceful walker', 'image' => '10.jpg'],
            ['name' => 'Bear', 'trait' => 'Big teddy bear', 'image' => '11.jpg'],
            ['name' => 'Maggie', 'trait' => 'Loyal companion', 'image' => '12.jpg'],
            ['name' => 'Jack', 'trait' => 'Adventurous explorer', 'image' => '13.jpg'],
            ['name' => 'Bailey', 'trait' => 'Happy tail wagger', 'image' => '14.jpg'],
            ['name' => 'Riley', 'trait' => 'Loves belly rubs', 'image' => '15.jpg'],
            ['name' => 'Lucy', 'trait' => 'Curious sniffer', 'image' => '16.jpg'],
            ['name' => 'Tucker', 'trait' => 'Food motivated', 'image' => '17.jpg'],
            ['name' => 'Lola', 'trait' => 'Drama queen', 'image' => '18.jpg'],
            ['name' => 'Oliver', 'trait' => 'Calm observer', 'image' => '19.jpg'],
            ['name' => 'Zoey', 'trait' => 'Zippy runner', 'image' => '20.jpg'],
            ['name' => 'Bentley', 'trait' => 'Sophisticated pup', 'image' => '21.jpg'],
            ['name' => 'Stella', 'trait' => 'Shining star', 'image' => '22.jpg'],
            ['name' => 'Zeus', 'trait' => 'Mighty barker', 'image' => '1.jpg'],
            ['name' => 'Penny', 'trait' => 'Copper colored', 'image' => '2.jpg'],
            ['name' => 'Milo', 'trait' => 'Gentle giant', 'image' => '3.jpg'],
            ['name' => 'Ruby', 'trait' => 'Precious gem', 'image' => '4.jpg'],
            ['name' => 'Teddy', 'trait' => 'Soft and fluffy', 'image' => '5.jpg'],
            ['name' => 'Rosie', 'trait' => 'Rosy cheeks', 'image' => '6.jpg'],
            ['name' => 'Gus', 'trait' => 'Grumpy face', 'image' => '7.jpg'],
            ['name' => 'Willow', 'trait' => 'Flexible thinker', 'image' => '8.jpg'],
            ['name' => 'Oscar', 'trait' => 'Award winner', 'image' => '9.jpg'],
            ['name' => 'Lily', 'trait' => 'Delicate flower', 'image' => '10.jpg'],
            ['name' => 'Toby', 'trait' => 'Trusty sidekick', 'image' => '11.jpg'],
            ['name' => 'Zoe', 'trait' => 'Full of life', 'image' => '12.jpg'],
            ['name' => 'Winston', 'trait' => 'Distinguished gent', 'image' => '13.jpg'],
            ['name' => 'Abby', 'trait' => 'Acrobatic jumper', 'image' => '14.jpg'],
            ['name' => 'Jasper', 'trait' => 'Jazzy dancer', 'image' => '15.jpg'],
            ['name' => 'Nala', 'trait' => 'Queen of pride', 'image' => '16.jpg'],
            ['name' => 'Finn', 'trait' => 'Fearless swimmer', 'image' => '17.jpg'],
            ['name' => 'Pepper', 'trait' => 'Spicy personality', 'image' => '18.jpg'],
            ['name' => 'Leo', 'trait' => 'Lion hearted', 'image' => '19.jpg'],
            ['name' => 'Maya', 'trait' => 'Mystical aura', 'image' => '20.jpg'],
            ['name' => 'Ace', 'trait' => 'Top of the pack', 'image' => '21.jpg'],
            ['name' => 'Hazel', 'trait' => 'Nutty behavior', 'image' => '22.jpg'],
            ['name' => 'Murphy', 'trait' => 'Mischievous imp', 'image' => '1.jpg'],
            ['name' => 'Ellie', 'trait' => 'Elegant walker', 'image' => '2.jpg'],
            ['name' => 'Benji', 'trait' => 'Bouncy player', 'image' => '3.jpg'],
            ['name' => 'Coco', 'trait' => 'Chocolate lover', 'image' => '4.jpg'],
            ['name' => 'Buster', 'trait' => 'Breaks everything', 'image' => '5.jpg'],
            ['name' => 'Ivy', 'trait' => 'Climbing expert', 'image' => '6.jpg'],
            ['name' => 'Diesel', 'trait' => 'Powerful runner', 'image' => '7.jpg'],
            ['name' => 'Piper', 'trait' => 'Plays the flute', 'image' => '8.jpg'],
            ['name' => 'Bruno', 'trait' => 'Brown and proud', 'image' => '9.jpg'],
            ['name' => 'Athena', 'trait' => 'Wise goddess', 'image' => '10.jpg'],
            ['name' => 'Tank', 'trait' => 'Built like one', 'image' => '11.jpg'],
            ['name' => 'Sasha', 'trait' => 'Sassy princess', 'image' => '12.jpg'],
            ['name' => 'Henry', 'trait' => 'Royal lineage', 'image' => '13.jpg'],
            ['name' => 'Emma', 'trait' => 'Emotional support', 'image' => '14.jpg'],
            ['name' => 'Bandit', 'trait' => 'Steals hearts', 'image' => '15.jpg'],
            ['name' => 'Luna Belle', 'trait' => 'Beautiful moon', 'image' => '16.jpg'],
            ['name' => 'Harley', 'trait' => 'Rides motorcycles', 'image' => '17.jpg'],
            ['name' => 'Olive', 'trait' => 'Loves you lots', 'image' => '18.jpg'],
            ['name' => 'Scout', 'trait' => 'Always exploring', 'image' => '19.jpg'],
            ['name' => 'Phoebe', 'trait' => 'Bright light', 'image' => '20.jpg'],
            ['name' => 'Remy', 'trait' => 'Master chef', 'image' => '21.jpg'],
            ['name' => 'Kona', 'trait' => 'Coffee addict', 'image' => '22.jpg'],
            ['name' => 'Axel', 'trait' => 'Fast spinner', 'image' => '1.jpg'],
            ['name' => 'Luna Star', 'trait' => 'Celestial beauty', 'image' => '2.jpg'],
            ['name' => 'Samson', 'trait' => 'Super strong', 'image' => '3.jpg'],
            ['name' => 'Gracie', 'trait' => 'Full of grace', 'image' => '4.jpg'],
            ['name' => 'Brody', 'trait' => 'Beach bum', 'image' => '5.jpg'],
            ['name' => 'Callie', 'trait' => 'Calico colored', 'image' => '6.jpg'],
            ['name' => 'Apollo', 'trait' => 'Sun god', 'image' => '7.jpg'],
            ['name' => 'Maple', 'trait' => 'Sweet as syrup', 'image' => '8.jpg'],
            ['name' => 'Thor', 'trait' => 'Thunder paws', 'image' => '9.jpg'],
            ['name' => 'Ginger', 'trait' => 'Spicy redhead', 'image' => '10.jpg'],
            ['name' => 'Louie', 'trait' => 'Loud barker', 'image' => '11.jpg'],
            ['name' => 'Minnie', 'trait' => 'Tiny but mighty', 'image' => '12.jpg'],
            ['name' => 'Jax', 'trait' => 'Cool dude', 'image' => '13.jpg'],
            ['name' => 'Layla', 'trait' => 'Night beauty', 'image' => '14.jpg'],
            ['name' => 'Rocco', 'trait' => 'Rock solid', 'image' => '15.jpg'],
            ['name' => 'Winnie', 'trait' => 'Wins hearts', 'image' => '16.jpg'],
            ['name' => 'Moose', 'trait' => 'Big antlers', 'image' => '17.jpg'],
            ['name' => 'Poppy', 'trait' => 'Flower power', 'image' => '18.jpg'],
            ['name' => 'Duke Jr', 'trait' => 'Noble heir', 'image' => '19.jpg'],
            ['name' => 'Millie', 'trait' => 'Millionaire vibes', 'image' => '20.jpg'],
            ['name' => 'Cash', 'trait' => 'Money maker', 'image' => '21.jpg'],
            ['name' => 'Pearl', 'trait' => 'Ocean treasure', 'image' => '22.jpg'],
        ];

        $simon = User::first();

        $optimizer = new OptimizeWebpImageAction();

        foreach ($puppies as $puppy) {
            $input = public_path('images/puppies/' . $puppy['image']);
            $optimized = $optimizer->handle($input);
            $path = 'puppies/' . $optimized['fileName'];
            Storage::disk('public')->put($path, $optimized['webpString']);
            Puppy::create([
                'user_id' => $simon->id,
                'name' => $puppy['name'],
                'trait' => $puppy['trait'],
                'image_url' => Storage::url($path),
            ]);
        }
    }
}
