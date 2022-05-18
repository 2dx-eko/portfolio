level = 0;
const LEVEL_NUM = [
    [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],//easy
    [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30],//nomarl
    [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40],//hard
]
const DIF = ["easy","normal","hard"];
class Game{
    constructor(level){ //newした段階で生成
        this.miss_c = 0;//ミスの数
        this.success_c = 0;//インクリメント用
        this.endflg = false;
        this.dif = [2,3,4];
        this.level = level; //0:easy 1:normal 2:hard
        this.level_array = []; //シャッフルさせる用の配列
        for(let i = 1; i <= this.dif[level] * 10; i++){
            this.level_array.push(i); //難易度分追加（dif）
        }
        this.level_array.sort(()=> Math.random() - 0.5); //配列シャッフル
        this.html = '<table class="' + DIF[this.level]  + '">' ;
            this.html += '<tr>';
            for(let i = 0; i < this.level_array.length; i++){
                this.html += "<td class=td>";
                    this.html += this.level_array[i];
                this.html += "</td>";
            }
            this.html += '</tr>';
        this.html += '</table>';
        this.info = '<div class=info>';
        this.info += '<div class=time></div>';
        this.info += '<div class=miss></div>';
        this.info += '</div>';
        document.body.innerHTML = "<div class=gameparent></div>";
        let gameparent = document.querySelector(".gameparent");
        gameparent.innerHTML += this.info;
        gameparent.innerHTML += this.html;
        document.body.innerHTML += "<div class=ranking><div class=inner><div class=title_time></div><div class=rank><span class=rankin></span><table class=ranktable></table></div><div class=reload></div></div></div>";
        this.c_time = 0;
        this.elmiss = document.querySelector(".miss");
        this.elmiss.innerHTML = "MISS:0";
    }
    
    panelClick(thisclick){
        let click_num = thisclick.textContent;//テキスト数字取得
        if(LEVEL_NUM[this.level][this.success_c] == click_num){
            thisclick.classList.add("active");
            this.success_c++;
            if(this.level_array.length == click_num){
                document.querySelector("table").classList.add("notouch");
                this.endflg = true;
                return true;//最後の数字クリックでtrueを返す
            }
        }else{
            if(this.endflg){
                return true;
            }
            this.miss_c++;
            this.elmiss.innerHTML = "MISS:" + this.miss_c;
        }
    }

    //タイマーsetintervalの都合上メソッドを分けてる
    count_up(){
        let eltime = document.querySelector(".time");
        // 10ミリ秒単位でカウントアップする
        ++this.c_time;
        let formatTimer = "TIME:" + this.counter_format(this.c_time);
        eltime.innerHTML = formatTimer;
        return formatTimer;
    }
    // 時間の経過を時：分：秒：10ミリ秒で表す
    counter_format(num){
        let numZan = num;	// 残りの時間(10ミリ秒単位)
        // 時を計算：100で割って秒、60秒で割り分に、さらに60分で割り残りを切り捨てで時に
        let hh = Math.floor(numZan / (100 * 60 * 60));
        // numの残り：取得した時の部分を10ミリ秒単位にして除く、
        numZan = numZan - (hh * 100 * 60 * 60);
        // 分を計算：残り時間を100で割って秒、60秒で割り残りを切り捨てて分に
        let mm = Math.floor(numZan / (100 * 60));
        // numの残り：取得した分の部分を10ミリ秒単位にして除く、
        numZan = numZan -(mm * 100 * 60);
        // 秒を計算：残り時間を100で割り残りを切り捨てて秒に
        let ss = Math.floor(numZan / 100);
        // 最後の残りが10ミリ秒部分
        numZan = numZan - (ss * 100);
        let ms = numZan;
        
        // 見やすいように二桁表示に
        if(hh < 10){hh = "0" + hh;}
        if(mm < 10){mm = "0" + mm;}
        if(ss < 10){ss = "0" + ss;}
        if(ms < 10){ms = "0" + ms;}
        return hh + ":" + mm + ":" + ss + ":" + ms;
    }

}
