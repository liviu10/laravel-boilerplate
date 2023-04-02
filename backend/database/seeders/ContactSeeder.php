<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use Carbon\Carbon;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Contact::truncate();
        $records = [
            [
                'id'             => 1,
                'full_name'      => 'User Test',
                'email'          => 'webmaster@' . config('app.domain_name'),
                'phone'          => '0760123456',
                'message'        => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugiat nobis aperiam, doloremque soluta reprehenderit nisi nemo. Consequuntur tenetur eaque cumque quaerat debitis? Dicta quos est nostrum voluptatum nihil explicabo temporibus ab iusto aperiam sunt. Facere earum modi nobis culpa recusandae nostrum, perspiciatis, fugit, minima quam fuga error dolore vel eaque aspernatur quis! Ex quisquam perspiciatis voluptatem animi dicta alias doloribus, molestias illo saepe possimus! Optio autem odio atque exercitationem labore quaerat nihil aut delectus unde. Blanditiis tempora rerum ratione nulla, saepe beatae. Nulla veniam cumque, quas aut ipsam sed architecto optio modi perspiciatis earum sint inventore sequi minima, consequatur deserunt veritatis et minus libero recusandae excepturi itaque. Ut fugiat eveniet veritatis vitae deserunt, recusandae eaque iste a aspernatur tempora temporibus nemo asperiores quasi laudantium error dolorem maiores mollitia perspiciatis incidunt quia earum velit soluta consequatur. Quis delectus exercitationem sunt illo velit rerum dicta ut blanditiis commodi praesentium? Reprehenderit, atque possimus voluptates aperiam quaerat molestias dolor eaque cupiditate illum amet dolorem earum excepturi nulla provident molestiae! Ab adipisci omnis, voluptas ex autem quas perferendis consequatur. Eos dolor voluptatibus ea. Dolorem delectus rerum eveniet. Voluptatibus eius reprehenderit consectetur tenetur, ut suscipit alias veritatis, magni iste optio doloribus dicta laborum quis praesentium autem vitae? Ut iusto sint nisi labore perspiciatis corrupti non recusandae illo dolor similique accusantium consequuntur laudantium sequi, temporibus beatae sit in quas incidunt quibusdam, odio consectetur nesciunt suscipit laborum? Ipsum et repudiandae commodi atque vero, reprehenderit non architecto rerum consectetur cumque quam aut quibusdam est velit! Quo fuga facilis ducimus saepe deleniti sit. Perferendis tenetur nam illum voluptas facere magnam omnis cupiditate minus nisi laborum, reiciendis accusamus explicabo quae aspernatur reprehenderit quos harum dignissimos sint libero saepe facilis vitae voluptates labore? Quibusdam nemo fugit cumque doloremque impedit amet cupiditate officia ut optio repellat. Reiciendis ratione sed voluptas iure saepe ea temporibus praesentium consequuntur voluptates earum architecto necessitatibus delectus, beatae nostrum distinctio quaerat perferendis autem cumque fuga. Qui excepturi quae debitis exercitationem officiis commodi aspernatur molestiae eaque dolores repudiandae accusantium voluptate sunt deleniti voluptatum cum, porro ipsum, consequuntur non enim. Amet dolorum sunt non suscipit recusandae architecto facere animi mollitia iusto incidunt, doloribus ut esse beatae similique sequi voluptate vel aut corrupti sint neque facilis quo reiciendis velit provident. Adipisci, eligendi accusantium! Perspiciatis, quo corporis? Vero modi facere eos id aut? Officia minus ut voluptates facere fugiat vel, quasi reprehenderit est repellat natus autem distinctio dolores veniam molestias magnam adipisci culpa odit quaerat ipsa ratione a? Sequi, nemo voluptates doloribus quia nisi porro rem nulla, illo tempore asperiores dicta totam a aliquid aperiam? Accusamus blanditiis nihil cumque exercitationem veritatis nesciunt dignissimos accusantium quidem sed architecto illo inventore, dolores velit animi voluptates ratione tempore eligendi fugiat voluptas facilis ipsum? Error, deleniti tenetur facere neque quisquam sapiente, rem nesciunt iure corporis dignissimos minima provident veritatis et optio. Voluptas dolore aperiam harum veritatis dignissimos. Odit pariatur ex nostrum praesentium autem ea neque harum, nemo esse, earum, assumenda tenetur placeat! Sint at minus, obcaecati beatae et, impedit quas, eligendi voluptatem magnam atque blanditiis excepturi! Placeat.',
                'privacy_policy' => true,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ];
        Contact::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
