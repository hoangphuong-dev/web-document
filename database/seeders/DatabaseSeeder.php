<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // "hocvt/stop-words": "*",
        // "league/flysystem-aws-s3-v3": "^3.29",
        // "phuonght/converter-document": "^2.0",
        // "gumlet/php-image-resize": "^2.0",
        // "pion/laravel-chunk-upload": "^1.5",
        // "pusher/pusher-php-server": "^7.2",

        // !: Data AI summary
        // $summary = [
        //     'main_content' => [
        //         [
        //             "heading" => "1. Giới thiệu về Thương mại điện tử",
        //             "content" => "Thương mại điện tử đang ngày càng phát triển và trở thành một xu hướng tất yếu trong thời đại số.  Theo tài liệu, thương mại điện tử được định nghĩa là 'việc ứng dụng các công nghệ thông tin để tiến hành các giao dịch mua – bán các sản phẩm, dịch vụ và thông tin thông qua các mạng máy tính có sử dụng các tiêu chuẩn truyền thông chung.'  Điều này cho thấy phạm vi rộng lớn của thương mại điện tử, bao gồm cả việc trao đổi dữ liệu, chuyển tiền điện tử và các hoạt động tài chính khác.  Tài liệu cũng phân biệt hai mô hình kinh doanh chính trong thương mại điện tử là B2C (doanh nghiệp đến người tiêu dùng) và B2B (doanh nghiệp đến doanh nghiệp), mỗi mô hình có những đặc điểm và quy trình giao dịch riêng.  Mô hình B2C tập trung vào việc bán lẻ trực tiếp cho người tiêu dùng, trong khi B2B liên quan đến giao dịch giữa các tổ chức, doanh nghiệp.  Việc ứng dụng thương mại điện tử mang lại nhiều lợi ích như rút ngắn khoảng cách không gian và thời gian, tăng cường hiệu quả kinh doanh và đáp ứng nhu cầu ngày càng đa dạng của khách hàng. Ví dụ, giao dịch B2B “cho phép các công ty buôn bán với các bạn hàng hiện tại trong một môi trường kinh doanh thuận lợi mà không cần phải đi qua một số giai đoạn ban đầu”. Tuy nhiên, vấn đề an toàn bảo mật cần được đặc biệt quan tâm trong môi trường thương mại điện tử."
        //         ],
        //         [
        //             "heading" => "2. Thanh toán điện tử",
        //             "content" => "Thanh toán điện tử là một phần không thể thiếu của thương mại điện tử.  Tài liệu nhấn mạnh tầm quan trọng của an toàn trong thanh toán điện tử và chỉ ra năm khía cạnh cần được đảm bảo: tính sẵn dùng, tính xác thực, tính toàn vẹn, tính không chối bỏ và tính tin cậy.  Để đáp ứng các yêu cầu này, các kỹ thuật mã hóa thông tin, chữ ký điện tử và chứng thực điện tử được sử dụng.  Tài liệu cũng đề cập đến việc sử dụng chứng chỉ số trong thanh toán điện tử, mô tả mô hình thanh toán tổng quát sử dụng chứng chỉ và quy trình hoạt động của mô hình này.  Việc phân tách việc phân phối hàng hóa với thanh toán và sử dụng chứng chỉ được ký làm bằng chứng thanh toán giúp tăng tính linh hoạt và bảo mật cho giao dịch.  'Chứng chỉ là các khẳng định (statements) được bảo vệ bằng phương thức mã hóa' giúp đảm bảo tính xác thực và tin cậy của giao dịch.  Tuy nhiên, tài liệu chưa đi sâu vào phân tích các phương thức thanh toán điện tử cụ thể và các vấn đề thực tiễn liên quan đến việc triển khai chúng."
        //         ],
        //         [
        //             "heading" => "3. Chữ ký số và ứng dụng",
        //             "content" => "Chữ ký số đóng vai trò quan trọng trong việc xác thực và bảo mật giao dịch điện tử.  Tài liệu trình bày bài toán phân tích số nguyên và bài toán RSA, làm nền tảng cho việc hiểu về nguyên lý hoạt động của chữ ký số.  Chữ ký số được tạo ra bằng cách sử dụng khóa bí mật của người ký để mã hóa thông điệp thu gọn (message digest) được tạo ra từ hàm băm.  'Chữ ký điện tử là một đoạn dữ liệu ngắn đính kèm với văn bản gốc để chứng thực tác giả của văn bản và giúp người nhận kiểm tra tính toàn vẹn của nội dung văn bản gốc.' Quá trình kiểm tra chữ ký số sử dụng khóa công khai của người ký để giải mã chữ ký và so sánh với thông điệp thu gọn được tạo ra từ thông điệp nhận được.  Tài liệu cũng đề cập đến ứng dụng của chữ ký số trong việc xác thực email và giao dịch thương mại điện tử, giúp đảm bảo tính không chối bỏ và tin cậy. Việc sử dụng hàm băm (hash) giúp đảm bảo tính toàn vẹn của dữ liệu và phát hiện các thay đổi trái phép.  Tài liệu cũng đề cập đến chứng thư số như một phần quan trọng trong hệ thống chữ ký điện tử, giúp xác minh danh tính của người ký và tăng cường tính bảo mật cho giao dịch."
        //         ],
        //         [
        //             "heading" => "4. Mô hình hệ thống ứng dụng",
        //             "content" => "Tài liệu mô tả một mô hình hệ thống ứng dụng chữ ký số trong thương mại điện tử, bao gồm ba thành phần chính: Client (khách hàng), Server bán hàng và Server thanh toán.  Quy trình mua bán và thanh toán được thực hiện thông qua trình duyệt web, với việc sử dụng chữ ký số để đảm bảo tính bảo mật và toàn vẹn của giao dịch. Cụ thể, “User sau khi đăng ký tài khoản thành công, sẽ được cặp khóa công khai (e1, N1) và khóa bí mật (d1, N1) đã được mã hóa và lưu trong cơ sở dữ liệu của mỗi người dùng.”  Server sử dụng hàm băm SHA-1 để tạo thông điệp rút gọn và người dùng sử dụng khóa bí mật để ký lên thông điệp này.  Server sau đó kiểm tra chữ ký bằng khóa công khai của người dùng.  Mô hình này cho thấy cách thức tích hợp chữ ký số vào hệ thống thương mại điện tử để tăng cường tính bảo mật và tin cậy. Tuy nhiên, tài liệu chưa phân tích chi tiết về các khía cạnh kỹ thuật của việc triển khai hệ thống này, cũng như các vấn đề liên quan đến hiệu suất và khả năng mở rộng."
        //         ]
        //     ]
        // ];

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
