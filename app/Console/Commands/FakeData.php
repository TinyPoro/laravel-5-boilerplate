<?php

namespace App\Console\Commands;

use App\Category;
use App\News;
use App\Summary\SummaryTool;
use Illuminate\Console\Command;

class FakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $new = new News();
//        $new->user_id = 1;
//        $new->title = "Fake Title";
//        $new->content = "Fake Content!";
//        $new->save();
//
//        $new = new News();
//        $new->user_id = 1;
//        $new->title = "Fake Title";
//        $new->content = "Fake Content!";
//        $new->save();
//
//        $new = new News();
//        $new->user_id = 2;
//        $new->title = "Fake Title";
//        $new->content = "Fake Content!";
//        $new->save();
//
//        $new = new News();
//        $new->user_id = 3;
//        $new->title = "Fake Title";
//        $new->content = "Fake Content!";
//        $new->save();
//
//        $category = new Category();
//        $category->name = "Test Category 1";
//        $category->save();
//
//        $category = new Category();
//        $category->name = "Test Category 2";
//        $category->save();
//
//        News::find(1)->categories()->attach(1);
//        News::find(2)->categories()->attach(1);
//        News::find(3)->categories()->attach(1);
//        News::find(3)->categories()->attach(2);
//        News::find(4)->categories()->attach(2);

        $content = "Do vật chất là nguồn gốc và là cái quyết định đối với ý thức, cho nên để nhận thức cái đúng đắn sự vật, hiện tượng, trước hết phải xem xét nguyên nhân vật chất, tồn tại xã hội_ để giải quyết tận gốc vấn đề chứ không phải tìm nguồn gốc, nguyên nhân từ những nguyên nhân tinh thần nào.“tính khách quan của sự xem xét” chính là ở chỗ đó .
Mặt khác, ý thức có tính độc lập tương đối, tác động trở lại đối với vật chất, cho nên trong nhận thức phải có tính toàn diện, phải xem xét đến vai trò của nhân tố tinh thần.
Trong hoạt động thực tiễn, phải xuất phát từ những điều kiện khách quan và giải quyết những nhiệm vụ của thực tiễn đặt ra trên cơ sở tôn trọng sự thật. Đồng thời cũng phải nâng cao nhận thức, sử dụng và phát huy vai trò năng động của các nhân tố tinh thần,tạo thành sức mạnh tổng hợp giúp cho hoạt động của con người đạt hiệu quả cao.
Không chỉ có vậy, việc giải quyết đúng đắn mối quan hệ trên khắc phục thái độ tiêu cực thụ động, chờ đợi, bó tay trước hoàn cảnh hoặc chủ quan, duy ý chí do tách rời và thổi từng vai trò của từng yếu tố vật chất hoặc ý thức.

Dựa trên các tri thức về quy luật khách quan,con người đề ra mục tiêu,phương hướng,xác định phương pháp,dùng ý chí để thực
hiện mục tiêu ấy.Vì vậy,ý thức tác động đến vật chất theo hai hướng chủ yếu :Nếu ý thức phản ánh đúng đắn điều kiện vật
chất,hoàn cảnh khách quan thì sẽ thúc đẩy tạo sự thuận lợi cho sự phát triển của đối tượng vật chất.Ngược lại,nếu
ý thức phản ánh sai lệch hiện thực sẽ làm cho hoạt động của con người không phù hợp với quy luật khách quan,do
đó:sẽ kìm hãm sự phát triển của vật chất.";

        $summaryTool = new SummaryTool($content);

        $summary = $summaryTool->getSummary(0.5);
        dd($summary);

    }
}
