<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('solusi')->insert([
            ['No'=> 1, 'kode_solusi' => 'S01', 'solusi' => 'Dengan memberikan antibiotik, seperti penisilin atau oksitetrasiklin, akan efektif jika diberikan di awal infeksi. Namun, jika infeksi sudah parah, pengobatan sering kali tidak lagi efektif dan biasanya mati mendadak. Untuk itu dapat dilakukan pencegahan dengan rutin memberikan vaksinasi (Sterne vaccine)', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No'=> 2, 'kode_solusi' => 'S02', 'solusi' => 'Segera isolasi sapi yang terinfeksi untuk mencegah penularan lebih lanjut ke sapi lain. Cuci bagian alat kemaluan sapi dengan cairan desinfektan, dan bersihkan kandang sapi yang terinfeksi hingga benar-benar steril. Pastikan sapi yang sehat tidak diperbolehkan masuk ke dalam kandang tersebut. Untuk pencegahan, berikan vaksinasi rutin dengan vaksin RB51 atau S19 pada sapi muda sebelum mencapai usia dewasa reproduksi.', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No'=> 3, 'kode_solusi' => 'S03', 'solusi' => 'Dapat menggunakan pengobatan alami seperti penyemprotan pada bagian yang terluka dengan soda kue dan memberikan suplemen vitamin A dan antibiotik. Melakukan isolasi sapi yang terjangkit dan melakukan kebersihan pada kandang.', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No'=> 4, 'kode_solusi' => 'S04', 'solusi' => 'Dengan memberikan obat nafsu makan, pemberian obat antibiotik seperti tetrasiklin, dan memberikan obat antiparasit seperti imidocarb atau diminazene, sesuai dengan dosis yang berlaku.', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No'=> 5, 'kode_solusi' => 'S05', 'solusi' => 'Dengan memberikan minyak kelapa atau minyak lavender, agar dapat menenangkan kulit teriritasi, rusak, dan mengurangi peradangan. Mengisolasi sapi tersebut dan memberikan perawatan khusus seperti dengan memberikan obat penurun demam, jika sapi tersebut demam dan memberikan pakan yang baik untuk nutrisi penyembuhan.', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No'=> 6, 'kode_solusi' => 'S06', 'solusi' => 'Dengan memberikan obat cacing seperti obat Fenbendazole sesuai dengan dosis yang berlaku, melakukan isolasi jika sapi tersebut terjangkit parah dan dengan rutin membersihkan kandang dan pemberian nutrisi yang baik.', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No'=> 7, 'kode_solusi' => 'S07', 'solusi' => 'Dengan memberikan obat antibiotik seperti penicillin, dapat melakukan pemerahan susu secara teratur untuk menghilangkan kuman dari kelenjar susu dan membuang susu hasil dari pengobatan.', 'created_at' => now(),
            'updated_at' => now(),], 
            ]);
    }
}
