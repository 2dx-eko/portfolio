/*$(function(){
    $('.back_slider').bgSwitcher({
        images: ['/common/img/login_back.jpg','/common/img/login_back2.jpg','/common/img/login_back3.jpg','/common/img/login_back4.jpg','/common/img/login_back5.jpg'], // 切替背景画像を指定
    interval: 4000, // 背景画像を切り替える間隔を指定 3000=3秒
        loop: true, // 切り替えを繰り返すか指定 true=繰り返す　false=繰り返さない
    });
});
*/
$(function(){
    let li = $(".pic_parent li");
    
    li.click(function(){
        let url = $(this).find("img").attr("src");
        let html = '<div class="popup">';
            html += '<div class="col">';
                html += '<div>';
                    html += '<span class="pop_delete">✕</span>';
                    html += '<img src="' + url  +'">';
                    html += '<form method="post" class="popform">';
                    html += '<a href="' + url + '" download>SAVE</a>';
                    html += '<input type="hidden" name="delete_img" value="' + url +'">'
                    html += '<button class="delete_btn" name="delete_btn">DELETE</button>';
                    html += '</form>';
                html += '</div>';
            html += '</div>';
        html += '</div>';
        $(".popup_area").html(html);
        $(".popup").fadeIn();

        let span = $("span.pop_delete");
        span.click(function(){
            $(this).parents(".popup").fadeOut();
        });
        let popup = $(".popup_area .popup");
        popup.click(function(){
            $(this).fadeOut();
        });
    });

});

