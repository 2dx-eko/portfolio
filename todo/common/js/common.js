$(function(){
    let td = $("td.cursol");
    let edit = $(".edit");
    let i = $(".fadeout");

    //編集の箱
    td.click(function(){
        let index = td.index(this);
        
        edit.eq(index).fadeIn();
    });
    i.click(function(e){
        edit.fadeOut();
    });
    //バリデーション
    $(".edit_submit").submit(function(){
        let value = $(this).find(".edit_text").val();
        if(value == ""){
            $("form.edit_submit p.error").fadeIn();
            return false;
        }     
    });
    
});
