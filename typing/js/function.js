//問題の出力用(日本語の部分のみ)
function quesOutput(){
    quesbox = QUES_ARRAY[rand(0,QUES_ARRAY.length-1)];
    j_text.innerHTML = quesbox.j;
}

//ランダム整数
function rand(min,max){
    return (Math.floor(Math.random() * (max-min+1)+min));
}

//次のキーを点滅させる（keyと問題文のスペル）
function nextKey(quesbox,key_c){
    let next_key = quesbox.e.charAt(key_c);
    /*---------↓↓↓key↓↓↓----------*/
    for(let i = 0; i < td.length; i++){//入力された物は削除
        if(td[i].classList.contains("next")){
            td[i].classList.remove("next");
        }
    }
    nextKeyClass(next_key);

    /*-------↓↓↓問題文のスペル↓↓↓-------*/
    let text_array = [];//問題文を分解して配列に格納
    let connect_text = "";
    for(let i = 0; i < quesbox.e.length; i++){
        text_array[i] = {"text":quesbox.e[i],"flg":false};
        //同じ文字が複数点滅しないようにフラグで判定
        for(let j = 0; j < quesbox.e.length; j++){
            if(key_c == i){
                text_array[i] = {"text":quesbox.e[i],"flg":true};
            }else{
                text_array[i] = {"text":quesbox.e[i],"flg":false};
            }
        }
        if(text_array[i].text == next_key && text_array[i].flg){
            //点滅させる文字にだけspanを入れる
            text_array[i].text = `<span>${next_key}</span>`;
        }
        connect_text += text_array[i].text;
    }
    e_text.innerHTML = connect_text;
}

//利用しないボタンを押した際は反応しないように
function otherBtn(code){
    let judge = EN_N_ARRAY.includes(code);
    return judge;
}

//keyを点滅させるクラス付与
function nextKeyClass(next_key){
    if(next_key == 1){
        document.querySelector(".one").classList.add("next");
    }else if(next_key == 2){
        document.querySelector(".two").classList.add("next");
    }else if(next_key == 3){
        document.querySelector(".three").classList.add("next");
    }else if(next_key == 4){
        document.querySelector(".four").classList.add("next");
    }else if(next_key == 5){
        document.querySelector(".five").classList.add("next");
    }else if(next_key == 6){
        document.querySelector(".six").classList.add("next");
    }else if(next_key == 7){
        document.querySelector(".seven").classList.add("next");
    }else if(next_key == 8){
        document.querySelector(".eight").classList.add("next");
    }else if(next_key == 9){
        document.querySelector(".nine").classList.add("next");
    }else if(next_key == 0){
        document.querySelector(".zero").classList.add("next");
    }else if(next_key == "-"){
        document.querySelector(".haifun").classList.add("next");
    }else{
        document.querySelector(`.${next_key}`).classList.add("next");
    }
}

//key入力のミス時のクラス付与
function addmiss(code){
    if(code == 1){
        document.querySelector(".one").classList.add("miss");
    }else if(code == 2){
        document.querySelector(".two").classList.add("miss");
    }else if(code == 3){
        document.querySelector(".three").classList.add("miss");
    }else if(code == 4){
        document.querySelector(".four").classList.add("miss");
    }else if(code == 5){
        document.querySelector(".five").classList.add("miss");
    }else if(code == 6){
        document.querySelector(".six").classList.add("miss");
    }else if(code == 7){
        document.querySelector(".seven").classList.add("miss");
    }else if(code == 8){
        document.querySelector(".eight").classList.add("miss");
    }else if(code == 9){
        document.querySelector(".nine").classList.add("miss");
    }else if(code == 0){
        document.querySelector(".zero").classList.add("miss");
    }else if(code == "-"){
        document.querySelector(".haifun").classList.add("miss");
    }else{
        document.querySelector(`.${code}`).classList.add("miss");
    }
}

//timer用
function timer(){
    set_int = setInterval(function(){
        save_time++;
        if(m == 99){
            m = 0;
            s++;
            if(s < 60){//未60秒
                if(s >= 10){
                    second.innerHTML = s;
                }else{
                    second.innerHTML = "0" + s;
                }
            }else{//60秒経過
                s = 0;
                second.innerHTML = "0"+ s;
                h++;
                if(h >= 10){
                    hour.innerHTML = h;
                }else{
                    hour.innerHTML = "0" + h;
                }
            }
        }
        m++;
        ml.innerHTML = m;
    },10);
}

//カウントダウン＋game開始
function gameCount_Start(){
    menu_parent.style.opacity = 0;
    menu_parent.classList.add("no_click");//モード画面非表示
    //カウント
    setTimeout(function(){
        let c = 3;
        countdown.style.display = "block";
        let start_count = setInterval(function(){
            if(c == 0){
                countdown.innerHTML = "START";
                clearInterval(start_count);
                setTimeout(function(){ //ここからgame開始
                    game_flg = true;
                    countdown.style.display = "none";
                    parent.style.display = "block";
                    timer();
                },2000);
                return false;
            }
            countdown.innerHTML = c;
            c--;
        },1000);
    },2000);
}

//ゲーム終了後の処理
function gameEnd(){
    if(level == "easy" && clear_c == 5){
        gameend();
    }else if(level == "normal" && clear_c == 10){
        gameend();
    }else if(level == "hard" && clear_c == 20){
        gameend();
    }
}

//DB登録　+　key操作できないように
function gameend(){
    clearInterval(set_int);
    game_flg = false;
    let h = hour.innerHTML;
    let s = second.innerHTML;
    let m = ml.innerHTML;
    save_text = h + ":" + s + ":" + m;
    //秒後に名前入力表示
    setTimeout(function(){
        parent.style.opacity = 0;
        parent.classList.add("noclick");
        player_box.style.opacity = 1;
        player_box.style.transition = 0.4 + "s";
        name_input.style.transition = 0.4 + "s";
        ranking.style.transition = 0.4 + "s";
        name_input.classList.remove("noclick");
    },1000);
}

