let mode_window = document.querySelector(".mode_window");
let elcount = document.querySelector(".count");
let dif_li = document.getElementsByClassName("dif");
let time = document.querySelector(".time");
let miss = document.querySelector(".miss");
let player = document.querySelector(".player");
let name_button = document.querySelector(".namebutton");
let input_name = document.querySelector(".name");
let plaer_name; //送信時名前格納用
let game_flg = false;
let level;
let end_time;
let db_time = 0;//実際にDBに登録されるタイム
let dif_array = ["EASY","NORMAL","HARD"];
let time_array = [];
//button送信時
name_button.onclick = function(){
    plaer_name = input_name.value;
    if(!plaer_name){
        document.querySelector(".error").innerHTML = "Please write your name";
        return false;
    }
    player.classList.add("out");
    setTimeout(function(){
        mode_window.classList.add("in");
    },1000);
    
}
//難易度選択
for(let i = 0; i < dif_li.length; i++){
    dif_li[i].onclick = function(){
        let child = this.firstChild; //liの子要素取得
        if(child.classList.contains("easy")){
            level = 0;
        }else if(child.classList.contains("normal")){
            level = 1;
        }else if(child.classList.contains("hard")){
            level = 2;
        }
        ModeWindowRemove();
        main();
    }
}
//窓削除用
function ModeWindowRemove(){
    mode_window.classList.add("delete");
    setTimeout(function(){
        mode_window.remove();
    },1000);
}
//スタート処理
function main(){
    setTimeout(function(){
        let c = 3;
        let setint = setInterval(function(){
            if(c == 0){
                elcount.innerHTML = "START!!";
                clearInterval(setint);
                setTimeout(function(){ //ここからゲーム始動処理
                    elcount.remove();
                    let game = new Game(level);
                    let td = document.getElementsByClassName("td");
                    let timer = setInterval(function(){
                        db_time++;
                        end_time = game.count_up();//タイマー起動+終わり際のタイム保存
                    },10);
                    for(let i = 0; i < td.length; i++){
                        td[i].onclick = function(){
                            let thisclick = this;
                            let endflg = game.panelClick(thisclick);
                            if(endflg){
                                clearInterval(timer);//タイマーストップ
                                document.querySelector(".info").classList.add("end");
                                //end_time:表記用（DB登録）
                                //db_time:これを元に順位をつける、ミリ秒で計測(DB登録)
                                //plaer_name:name(DB登録)
                                setTimeout(function(){
                                    $.ajax({
                                        url:"https://createengineer.sakura.ne.jp/touchnumbers/ranking.php",//送信先
                                        data:{ //dataはPHP側で取得させる
                                            "endtime":end_time,
                                            "dbtime":db_time,
                                            "name":plaer_name,
                                            "level":level,
                                        },
                                        success: function(res){ //resはPHPからの返り値
                                            for(let i = 0; i < res.length; i++){
                                                if(i == res.length-1){//DBの情報をresから格納
                                                    time_array.push({
                                                        "time":res[i].endtime,
                                                        "sorttime":res[i].dbtime,
                                                        "name":res[i].name,
                                                        "myrank":"new"
                                                    });
                                                }else{
                                                    time_array.push({
                                                        "time":res[i].endtime,
                                                        "sorttime":res[i].dbtime,
                                                        "name":res[i].name,
                                                    });
                                                }
                                            }
                                            time_array.sort(function(a,b){//タイムの早い順にソート(dbtime基準で)
                                                if(a.sorttime > b.sorttime){
                                                    return 1;
                                                }else{
                                                    return -1;
                                                }
                                            });
                                            console.log(time_array);
                                            let ranking = document.querySelector(".ranking");
                                            ranking.classList.add("active");
                                            //難易度ごとにDBわける
                                            setTimeout(function(){
                                                document.querySelector(".title_time").innerHTML = 'LEVEL:' + dif_array[level] + '<br>';
                                                setTimeout(function(){
                                                    document.querySelector(".title_time").innerHTML += end_time;
                                                        setTimeout(function(){
                                                            let ranktable = document.querySelector(".ranktable");
                                                            let html = '';
                                                            for(let i = 0; i < res.length; i++){
                                                                if(i == 0){
                                                                    html += '<tr>';
                                                                    html += '<td>RANK</td>';
                                                                    html += '<td>NAME</td>';
                                                                    html += '<td>TIME</td>';
                                                                    html += '</tr>';
                                                                    html += '<tr class=' + time_array[i].myrank + '>';
                                                                    html += '<td>' + '<p>' + (i+1) + '</p>' + '</td>';
                                                                    html += '<td>' + time_array[i].name + '</td>';
                                                                    html += '<td>' + time_array[i].time + '</td>';
                                                                    html += '</tr>';   
                                                                }else{
                                                                    html += '<tr class=' + time_array[i].myrank + '>';
                                                                    html += '<td>' + '<p>' + (i+1) + '</p>' + '</td>';
                                                                    html += '<td>' + time_array[i].name + '</td>';
                                                                    html += '<td>' + time_array[i].time + '</td>';
                                                                    html += '</tr>';
                                                                }
                                                            }
                                                            ranktable.innerHTML += html;
                                                            document.querySelector(".rankin").innerHTML = 'RANK IN!';
                                                            document.querySelector(".reload").innerHTML = '<a href="/touchnumbers">RETRY</a>';

                                                        },1000);
                                                },1000);
                                            },3000);
                                        }
                                    });
                                },2000);
                            }
                        };
                    }
                },2000);
                return false;
            }
            elcount.innerHTML = c;
            c--;
        },1000); 
    },4000);
}

