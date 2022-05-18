let code;//キーの入力を保管
let parent = document.querySelector(".parent");
let j_text = document.querySelector(".j_text");
let e_text = document.querySelector(".e_text");
let score = document.querySelector(".score");
let button = document.querySelector(".button");
let playername = document.querySelector(".playername");
let namevalue = document.getElementsByName("name");
let player_box = document.querySelector(".player_box");
let name_error = document.querySelector(".name_error");
let name_input = document.querySelector(".name_input");
let td = document.getElementsByClassName("td");
let miss = document.querySelector(".miss");
let ranking = document.querySelector(".ranking");
let dif_level = document.querySelector(".dif_level");
let rank = document.querySelector(".rank");

let score_c = 0;
let time_array = [];
let nextKey_c;//
let quesbox; //実際に問題が入る変数
let key_c = 0;//入力の番目

//timer用変数
let time = document.querySelector(".time");
let hour = document.querySelector(".hour");
let second = document.querySelector(".second");
let ml = document.querySelector(".ml");
let h = 0;
let s = 0;
let m = 0;

let start_flg = true;
let set_int; //timer関数の変数
let save_time = 0; //DBに保存する用(比較時に必要)
let save_text = "";//00:00:00タイムテキスト保存用
let save_name = "";

//選択画面周り
let step1 = document.querySelector(".step1");
let step2 = document.querySelector(".step2");
let step2_h2 = document.querySelector(".modetitle");
let mode_dif = document.querySelector(".mode_dif");
let mode_li = document.getElementsByTagName("li");
let menu_parent = document.querySelector(".menu_parent");
let countdown = document.querySelector(".countdown");

const EN_N_ARRAY = ["1","2","3","4","5","6","7","8","9","0","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","-"];
const QUES_ARRAY = [ //問題
    {"j":"ハブ空港","e":"habukuukou"},
    {"j":"エッダ","e":"edda"},{"j":"西洋医学","e":"seiyouigaku"},{"j":"準備運動","e":"junbiundou"},{"j":"4分33秒","e":"yonpunsanjuusanbyou"},{"j":"シャワー","e":"shawa-"},{"j":"サイバーパンク","e":"saiba-panku"},{"j":"リアル脱出ゲーム","e":"riarudasyutuge-mu"},{"j":"雪化粧","e":"yukigesyou"},{"j":"メタモルフォーゼ","e":"metamorufo-ze"},{"j":"モケーレムベンベ","e":"moke-remubennbe"},{"j":"スロットマシン","e":"surottomasin"},{"j":"盆踊り","e":"bonnodori"},{"j":"ブラック企業","e":"burakkukigyou"},{"j":"運転手","e":"untensyu"},{"j":"死後硬直","e":"sigokoucyoku"},{"j":"立ち回り","e":"tatimawari"},{"j":"拡散希望","e":"kakusankibou"},{"j":"同時多発","e":"doujitahatu"},{"j":"防弾ガラス","e":"boudangarasu"},{"j":"伝言ゲーム","e":"dengonge-mu"},{"j":"募金活動","e":"bokinkatudou"},{"j":"ゲーム依存症","e":"ge-muizonsyou"},{"j":"動脈硬化","e":"doumyakukouka"},{"j":"伝統工芸品","e":"dentoukougeihinn"},{"j":"リーダーシップ","e":"ri-da-sippu"},{"j":"間違いだらけ","e":"machigaidarake"},{"j":"セロハンテープ","e":"serohante-pu"},{"j":"塞翁が馬","e":"saiougauma"},{"j":"懲戒免職","e":"cyoukaimensyoku"},{"j":"ハシビロコウ","e":"hasibirokou"},{"j":"ゲーム実況","e":"ge-mujikkyou"},{"j":"現状維持","e":"genjouiji"},{"j":"アンダーグラウンド","e":"anda-guraunndo"},{"j":"低温やけど","e":"teionyakedo"},{"j":"白紙のページ","e":"hakusinope-ji"},{"j":"バックアタック","e":"bakkuatakku"},{"j":"コモンズの悲劇","e":"komonzunohigeki"},{"j":"コウテイペンギン","e":"kouteipengin"},{"j":"エッジワースの箱","e":"ejjiwa-sunohako"}
];

let game_flg = false;
let level; //難易度をテキストで保存（DB登録時に仕様）
let clear_c = 0; //問題のクリアした数