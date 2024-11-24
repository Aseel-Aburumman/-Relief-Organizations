<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        // إضافة بوستات تجريبية
        Post::create([
            'title' => 'First Post',
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ab porro illo aspernatur ea id molestiae perspiciatis, quidem eligendi adipisci suscipit ipsa quaerat, error eum quis hic eos sed rem tenetur officiis voluptatum expedita. Adipisci, autem?',
            'lang_id' => 1,
            'organization_id' => 1,
        ]);
        Post::create([
            'title' => '2nd Post',
            'organization_id' => 1,
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ab porro illo aspernatur ea id molestiae perspiciatis, quidem eligendi adipisci suscipit ipsa quaerat, error eum quis hic eos sed rem tenetur officiis voluptatum expedita. Adipisci, autem?',
            'lang_id' => 1,
        ]);

        Post::create([
            'title' => 'بوست بالعربي 1',
            'content' => 'لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا . يوت انيم أد مينيم فينايم,كيواس نوستريد أكسير سيتاشن يللأمكو لابورأس نيسي يت أليكيوب أكس أيا كوممودو كونسيكيوات . ديواس أيوتي أريري دولار إن ريبريهينديرأيت فوليوبتاتي فيلايت أيسسي كايلليوم دولار أيو فيجايت نيولا باراياتيور. أيكسسيبتيور ساينت أوككايكات كيوبايداتات نون بروايدينت ,سيونت ان كيولبا كيو أوفيسيا ديسيريونتموليت انيم أيدي ايست لابوريوم',
            'lang_id' => 2,
            'organization_id' => 1,
        ]);
        Post::create([
            'title' => 'بوست بالعربي 2',
            'organization_id' => 1,
            'content' => 'لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا . يوت انيم أد مينيم فينايم,كيواس نوستريد أكسير سيتاشن يللأمكو لابورأس نيسي يت أليكيوب أكس أيا كوممودو كونسيكيوات . ديواس أيوتي أريري دولار إن ريبريهينديرأيت فوليوبتاتي فيلايت أيسسي كايلليوم دولار أيو فيجايت نيولا باراياتيور. أيكسسيبتيور ساينت أوككايكات كيوبايداتات نون بروايدينت ,سيونت ان كيولبا كيو أوفيسيا ديسيريونتموليت انيم أيدي ايست لابوريوم',
            'lang_id' => 2,
        ]);

        Post::create([
            'title' => '2nd Post',
            'organization_id' => 1,
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ab porro illo aspernatur ea id molestiae perspiciatis, quidem eligendi adipisci suscipit ipsa quaerat, error eum quis hic eos sed rem tenetur officiis voluptatum expedita. Adipisci, autem?',
            'lang_id' => 1,
        ]);


        Post::create([
            'title' => 'Lorem ipsum dolor sit amet.',
            'organization_id' => 2,
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ab porro illo aspernatur ea id molestiae perspiciatis, quidem eligendi adipisci suscipit ipsa quaerat, error eum quis hic eos sed rem tenetur officiis voluptatum expedita. Adipisci, autem?',
            'lang_id' => 1,
        ]);
        Post::create([
            'title' => 'Lorem ipsum dolor sit amet.',
            'organization_id' => 2,
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ab porro illo aspernatur ea id molestiae perspiciatis, quidem eligendi adipisci suscipit ipsa quaerat, error eum quis hic eos sed rem tenetur officiis voluptatum expedita. Adipisci, autem?',
            'lang_id' => 1,
        ]);
        Post::create([
            'title' => 'Lorem ipsum dolor sit amet.',
            'organization_id' => 3,
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ab porro illo aspernatur ea id molestiae perspiciatis, quidem eligendi adipisci suscipit ipsa quaerat, error eum quis hic eos sed rem tenetur officiis voluptatum expedita. Adipisci, autem?',
            'lang_id' => 1,
        ]);
    }
}
