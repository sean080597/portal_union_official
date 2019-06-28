Các phần chưa làm:
1. Report
2. Event
3. Notification
4. Change email account to mssv 
5. Create User

//Cường: (Ráng làm xong trước thứ 4 nha, xong thì làm luôn cai hướng dẫn sử dụng của phần report)
1. Tạo link report trên thanh navbar trái
- Gồm 3 link chính:
    + Kiểm tra đánh giá
    + Công việc của tôi
    + Thống kê
    ------------------------------------------------------------
    Yêu cầu:
    - Mỗi link gồm url tới 1 trang
    - <div v-if="role"> cho mổi thẻ chứa nguyên 1 cái để ứng với mối quyền thì ta thẻ link đó dc hiện
    Note: chưa cần thêm v-if trước, để tối thứ 4 (26/06) gặp nhau thống nhất lại cái role vì t đang tạo cái này. Nên cứ tạo 3 thẻ trước thôi
    ------------------------------------------------------------
    1.1 Kiểm tra đánh giá
    - Gồm 3 thẻ con: giống lúc trước.
        + Kiểm tra lớp (Thống kê xem lớp có bao nhiêu bạn chưa đánh giá).
        + Kiểm tra khoa (Thống kê xem khoa có bao nhiêu bạn chưa đánh giá).
        + Kiểm tra toàn bộ (Thống kê xem có tất cả bao nhiêu bạn chưa đánh giá).
        ----------------------
        Bảng mới: score_board, cột "confirmingStudent" - type: boolean, học sinh đã đánh giá chưa
        Note: M tự tạo các score_board để test cho mỗi lớp, vì chưa tạo ra các role, nên cái đánh giá chưa save theo người có role nào đã đánh giá nên tự gõ dữ liệu tay để test nhé
        ---------------------
        1.1.1 Kiểm tra lớp:
            - Link: gồm url có kèm theo 1 cái id lớp, dựa vào id lớp để lọc
            ( khi trang side được load, sẽ kiểm tra xem có user-student ko, có thì lấy lớp bỏ vào link)
            đừng lo khi khoa hay trường ko có user vì sau này sẽ dùng <div v-if="role">link<div> vì có điều kiện nên nếu không có role không có chức năng này sẽ ko thấy 
            - Page: lọc ra lớp đó có bao nhiêu người chưa đánh giá, đã đánh giá (UI Như cũ).
        1.1.2 Kiểm tra khoa:
            - Link: gồm url có kèm theo 1 cái id khoa, dựa vào id khoa để lọc
            - Page: tạo ra 1 trang, để lọc ra danh sách các lớp trong khoa hoàn thành hay chưa (dựa vào tổng sinh viên trong lớp/ UI như cũ), trong mỗi cái sẽ có 1 nút (cái icon con mắt lúc trước) dẫn đến trang kiểm tra lớp đã tạo bên trên kèm theo id của lớp đó để lọc
        1.1.3 Kiểm tra toàn bộ:
            - Link: dẫn đến page thôi
            - Page: lọc ra danh sách các khoa trongá trường, hoàn thành hay chưa (dựa vào tổng sinh viên trong khoa/ UI như cũ), trong mỗi ci có 1 cái nút link tới lớp đó, click vào thì hiện trang của lớp như 1.1.2
    ------------------------------------------------------------------------------------------------
    2.2 Task (Kiểm tra xem mình có những công việc gì)
    - Gồm 3 link con: 
        + Công việc của tôi (dành cho tk lớp)
        + Công việc của tôi (dành cho tk khoa)
        + Công việc của tôi (dành cho tk trường)
    ----------------------------------------------------------------
    Bảng score_board sẽ có các cột confirmingClass, confirmingFaculty, confirmingSchool
    - confirmingClass: khi tk class đã đánh giá thì cột này sẽ trả về giá trị là 1 (type: boolean)
    - Tương tự cho fac, school
    + Trong data của vue, tạo 1 variable tên là "myRole" xét cứng cho nó với 1 trong 3 role để test (cla, fac, sch)
    // t làm xong role sẽ bổ xung vào code vào variable đó sau
    ------------------------------------------------------------------
        2.2.1 Công việc của tôi (dành cho tk lớp) 
        // 
            check confirmingClass của mỗi scoreboard
            làm như sau: 
            - lấy id lớp lọc ra mssv của lớp đó,
            - với mỗi sv:
            - trong bảng scoreboard: check mssv + year để lọc, sắp xếp theo confirmingClass là ra
            -----------
            Mấy cái sau tương tự   

        //
        - Link: Url + id mã lớp (lấy từ auth)
        - Page: Lọc ra các sinh viên mà tk lớp chưa đánh giá theo id lớp của tk này
        - UI sử dụng lại cái trên, thay hoàn thành/ chưa hoàn thành thành đã đánh giá/ chưa đánh giá
        2.2.2 Công việc của tôi (dành cho tk khoa)
        - Link: Url + id khoa (lấy từ auth)
        - Page: Lọc ra các lớp trong khoa, mỗi lớp đã đánh giá xong chưa như trên, click vào sẽ dẫn đến trang lớp vs id đã tạo ở trên.
        //
            check confirmingFaculty của mỗi scoreboard
            làm như sau: 
            - lấy id khoa lọc ra các lớp của auth đó,
            - với mỗi lớp:
            - trong bảng scoreboard: dùng id khoa lọc ra lớp, mỗi lớp lọc ra sinh viên: đếm confirmingFaculty của mỗi scoreboard trong lớp đó vd (30/41) 30 confirmingFac == 1 trên 41 student trong lớp, nhấp vào lớp đó thì chạy ra trang đã làm bên trên 
            -----------
        //
        2.2.3 Công việc của tôi (dành cho tk Trường)
        - Link: Url
        - Page: Lọc ra các khoa đã đánh giá xong và chưa + id của khoa đó trong url, click vào thì mở trang khoa đã tạo bên trên
        // để dễ hơn thì lọc ra các khoa, nhập vào khoa sẽ trỏ đến cái trang khoa đã tạo 2.2.2 vs id khoa 
    ------------------------------------------------------------------------------------------------
    3.1 Thống kê dự theo điểm trung bình (average_ccore) trong score_board qua các năm
        