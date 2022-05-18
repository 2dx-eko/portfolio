//モード選択
step1.onclick = function(){
    this.style.opacity = 0;
    this.classList.add("noclick");
    setTimeout(function(){
        step2_h2.style.display = "block";
    },1000);
    setTimeout(function(){
        mode_dif.style.display = "block";
    },5000);
}

//難易度選択
for(let i = 0; i < mode_li.length; i++){
    mode_li[i].onclick = function(){
        let child = this.firstChild; //liの子要素取得
        if(child.classList.contains("easy")){
            level = "easy";
            gameCount_Start();
        }else if(child.classList.contains("normal")){
            level = "normal";
            gameCount_Start();
        }else if(child.classList.contains("hard")){
            level = "hard";
            gameCount_Start();
        }
    }
}

//ゲーム選択がされたら下記開始のフラグ作成
quesOutput();
nextKey(quesbox,key_c);

document.onkeydown = function(e){
    if(game_flg){
        code = e.key;
        let push = otherBtn(code);
        if(!push){return false;}
        if(code == quesbox.e.charAt(key_c)){//入力が正解だったら
            
            if(key_c == quesbox.e.length-1){//問題の最後の文字が一致したらリセット
                clear_c++;//問題のクリアした数
                score_c += 10;
                score.innerHTML = "SCORE: " + score_c;
                gameEnd();
                quesOutput();//問題再出力
                key_c = 0;
                nextKey(quesbox,key_c);//次の文字を点滅
                return false;
            }
            score.innerHTML = "SCORE: " + score_c;
            key_c++;
            nextKey(quesbox,key_c);//次の文字を点滅
        }else{ //入力ミス
            score_c -= 1;
            score.innerHTML = "SCORE: " + score_c;
            miss.innerHTML += "<div class=fade-in>-1</div>";
            setTimeout(function(){
                miss.innerHTML = "";
            },300);
            
            addmiss(code); //.miss付与
        }
    }
}

document.onkeyup = function(e){
    if(game_flg){
        code = e.key;
        let pull = otherBtn(code);
        if(!pull){return false;}
        for(let i = 0; i < td.length; i++){
            if(td[i].classList.contains("miss")){
                td[i].classList.remove("miss");
            }
        }
    }
}

//ゲーム終了後送信をクリック時、name取得 → ランキング画面表示
button.onclick = function(){
    save_name = namevalue[0].value; //value取得
    String(save_name);
    //save_name.replace(/\s+/g, ""); 空白消えない
    if(save_name == ""){
        name_error.innerHTML = "名前が入力されていません";
        return false;
    }else{name_error.innerHTML = "";}
    
    //ここからplayer_box非表示 → ajaxでDB処理 → ランキング登録画面表示
    $.ajax({
        url:"https://createengineer.sakura.ne.jp/typing/ranking.php",
       data:{ //PHP側に送信するデータ
           "save_name" : save_name,
           "save_time" : save_time,
           "save_text" : save_text,
           "level" : level,
       },
       success:function(res){
        for(let i = 0; i < res.length; i++){
            if(i == res.length-1){//DBの情報をresから格納
                time_array.push({
                    "user_name":res[i].user_name,
                    "time":res[i].time,
                    "time_text":res[i].time_text,
                    "myrank":"new"
                });
            }else{
                time_array.push({
                    "user_name":res[i].user_name,
                    "time":res[i].time,
                    "time_text":res[i].time_text,
                });
            }
        }

        //res内　user_name time time_text level
        time_array.sort(function(a,b){//タイムの早い順にソート
            if(a.time > b.time){
                return 1;
            }else{
                return -1;
            }
        });
        //ランキング表示
        let html = '';
        for(let i = 0; i < time_array.length; i++){
            if(i == 0){
                html += '<tr>';
                html += '<td>RANK</td>';
                html += '<td>NAME</td>';
                html += '<td>TIME</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td>' + '<p>' + (i+1) + '</p>' + '</td>';
                html += '<td>' + time_array[i].user_name + '</td>';
                html += '<td>' + time_array[i].time_text + '</td>';
                html += '</tr>';   
            }else{
                html += '<tr class=' + time_array[i].myrank + '>';
                html += '<td>' + '<p>' + (i+1) + '</p>' + '</td>';
                html += '<td>' + time_array[i].user_name + '</td>';
                html += '<td>' + time_array[i].time_text + '</td>';
                html += '</tr>';
            }
        }
        rank.innerHTML = html;
        dif_level.innerHTML = level;
       }
    });


    
    name_input.style.opacity = 0;
    name_input.classList.add("noclick");
    setTimeout(function(){
        ranking.style.opacity = 1;
    },1000);



}

