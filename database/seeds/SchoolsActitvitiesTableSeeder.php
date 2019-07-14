<?php

use Illuminate\Database\Seeder;
use App\SchoolsActivity;
use Carbon\Carbon;

class SchoolsActitvitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schools_activities')->insert([
            [
                'title' => 'Có tinh thần yêu nước, yêu trường lớp, tích cực trong hoạt động sinh hoạt lớp, sinh hoạt Đoàn (0 – 10 điểm)',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Chấp hành pháp luật, đồng thời vận động gia đình, bạn bè cùng thực hiện tốt; thực hiện tốt nội quy Nhà trường, điều lệ Đoàn. (0 – 10 điểm)',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Có thái độ học tập tích cực, đi học đúng giờ, đóng góp xây dựng bài, không vi phạm quy chế học tập, quy chế thi cử. (0 – 10 điểm)',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Tích cực tham gia các hoạt động văn hóa, văn nghệ, thể dục thể thao. (0 – 10 điểm)',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Tích cực tham gia các hoạt động tình nguyện (Mùa hè xanh, Xuân tình nguyện, Hiến máu tình nguyện, các hoạt động bảo vệ môi trường…); Không xả rác bừa bãi và tự nguyện nhặt rác (0 – 10 điểm)',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Tích cực chủ động trang bị những kỹ năng, nâng cao trình độ ngoại ngữ, tin  học; đăng ký tham gia phong trào “sinh viên 5 tốt”. (0 – 10 điểm)',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Tham dự đầy đủ, tích cực và tham gia đóng góp ý kiến trong sinh hoạt chi đoàn và các hoạt động do tổ chức Đoàn các cấp tổ chức, đóng đoàn phí đầy đủ.',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
