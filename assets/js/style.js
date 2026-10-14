document.addEventListener("DOMContentLoaded", function () {
    const slider = document.getElementById('hotMovieSlider');
    const scrollDelay = 2000; // 2 giây cuộn 1 lần
    let autoScrollInterval;
    let isTransitioning = false; // Biến khóa để tránh lỗi khi đang cuộn

    // 1. CẤU HÌNH CLONE (TẠO BẢN SAO ĐỂ VÒNG LẶP VÔ TẬN)
    // Chúng ta cần clone (copy) 6 phim đầu tiên và gắn vào cuối danh sách
    // Để khi lướt qua phim số 10, người dùng sẽ thấy phim 1, 2, 3... (bản sao) hiện ra
    const cards = slider.querySelectorAll('.movie-card-hot');
    const originalCount = cards.length; // Số lượng phim gốc (ví dụ: 10)
    
    // Nếu ít phim quá thì không cần chạy script này
    if (originalCount < 6) return;

    // Thực hiện clone 6 phần tử đầu
    for (let i = 0; i < 6; i++) {
        let clone = cards[i].cloneNode(true); // Copy cả nội dung bên trong
        clone.classList.add('cloned-card');   // Đánh dấu đây là thẻ copy (để debug nếu cần)
        slider.appendChild(clone);
    }

    // 2. TÍNH TOÁN KÍCH THƯỚC
    function getCardWidth() {
        const firstCard = slider.querySelector('.movie-card-hot');
        // Chiều rộng thẻ + 15px gap (theo CSS của bạn)
        return firstCard.offsetWidth + 15; 
    }

    // 3. HÀM CUỘN THÔNG MINH
    function autoScroll() {
        if (isTransitioning) return; // Nếu đang xử lý reset thì bỏ qua nhịp này

        const step = getCardWidth();
        const maxScrollReal = step * originalCount; // Độ dài thực tế của 10 phim gốc

        // Nếu đang ở vị trí hiển thị các bản sao (tức là đã qua phim số 10)
        // Vị trí này hình ảnh giống hệt vị trí 0 đầu tiên
        // Ta sẽ "dịch chuyển tức thời" về 0 rồi mới cuộn tiếp -> Mắt người không nhận ra
        if (slider.scrollLeft >= maxScrollReal) {
            slider.style.scrollBehavior = 'auto'; // Tắt hiệu ứng mượt tạm thời
            slider.scrollLeft = slider.scrollLeft - maxScrollReal; // Nhảy lùi về vị trí tương ứng ở đầu
            
            // Buộc trình duyệt cập nhật lại giao diện ngay lập tức
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    slider.style.scrollBehavior = 'smooth'; // Bật lại hiệu ứng mượt
                    slider.scrollBy({ left: step, behavior: 'smooth' }); // Cuộn tiếp
                });
            });
        } else {
            // Trường hợp bình thường: cứ cuộn tới
            slider.scrollBy({ left: step, behavior: 'smooth' });
        }
    }

    // Bắt đầu chạy
    autoScrollInterval = setInterval(autoScroll, scrollDelay);

    // --- XỬ LÝ KHI DI CHUỘT (DỪNG LẠI ĐỂ KHÁCH BẤM) ---
    slider.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
    slider.addEventListener('mouseleave', () => autoScrollInterval = setInterval(autoScroll, scrollDelay));

    // --- HÀM CHO NÚT BẤM (PREV/NEXT) ---
    window.scrollSlider = function(direction) {
        clearInterval(autoScrollInterval); // Dừng tự động khi bấm tay
        autoScrollInterval = setInterval(autoScroll, scrollDelay); // Set lại thời gian

        const step = getCardWidth();
        slider.scrollBy({ left: direction * step, behavior: 'smooth' });
    };
    
    // Xử lý sự kiện cuộn tay để vòng lặp không bị lỗi khi người dùng kéo thanh trượt
    slider.addEventListener('scroll', function() {
        const step = getCardWidth();
        const maxScrollReal = step * originalCount;
        
        // Nếu người dùng kéo tay quá đà sang phần Clone, âm thầm đưa về đầu
        // Dùng sai số nhỏ (10px) để tránh nhảy loạn xạ
        if (slider.scrollLeft >= maxScrollReal + 10) {
             slider.style.scrollBehavior = 'auto';
             slider.scrollLeft = slider.scrollLeft - maxScrollReal;
             slider.style.scrollBehavior = 'smooth';
        }
    });
});