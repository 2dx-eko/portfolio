let screen_w = window.innerWidth;
let screen_h = window.innerHeight;
const KAMI_MAX = 30;
const COLORS = ["#0BF7D5","#1F463E","#3BE6CA","#049B82","#2B4D48","#1C9581","#2FEACE","#1C1C1C","#1C1C1C"];
kami_array = [];
let kami_direction = ["x","y"];
let shape_array = [
    {w:30,h:30},{w:22,h:8},{w:14,h:14},{w:10,h:10},{w:12,h:4},{w:6,h:12},{w:50,h:50},{w:20,h:70},{w:40,h:20},{w:70,h:50},{w:40,h:40}
];

function rand(min,max){
    return (Math.floor(Math.random()*(max-min+1)+min));
}


class Kami{
    constructor(){
        this.elm = document.createElement("div");
        document.body.appendChild(this.elm);
        this.sty = this.elm.style;
        this.direction = kami_direction[rand(0,1)];
        this.x = rand(0,screen_w);
        this.y = rand(0,screen_h);
        this.vx = rand(0,0);
        this.vy = rand(5,10);

        this.ang = 0;
        this.spd = rand(10,35);
        if(this.direction == "x"){//縦か横どっちかに回転
            this.rX = 10;
            this.rY = 0;
        }else{
            this.rX = 0;
            this.rY = 10;
        }
        this.rZ = 0;

        this.sty.position ="fixed";
        this.sty.width = shape_array[rand(0,shape_array.length-1)].w + "px";
        this.sty.height = shape_array[rand(0,shape_array.length-1)].h + "px";
        this.sty.backgroundColor = COLORS[rand(0,COLORS.length-1)];
        if(this.sty.backgroundColor == "rgb(28, 28, 28)"){
            this.sty.border = "solid 1px";
            this.sty.borderColor = COLORS[rand(0,COLORS.length-1)];
        }
        this.sty.display ="none";
    }

    update(){
        this.x += this.vx;
        this.y += this.vy;
        if(this.y >= screen_h){//最下部までおちたら上部へリセット
            this.x = rand(0,screen_w);
            this.y = -10;
        }
        this.ang += this.spd;
        this.sty.display = "block";
        this.sty.left = this.x + "px";
        this.sty.top = this.y +  "px";
        this.sty.transform = "rotate3D("
        + this.rX + "," + this.rY + ","
        + this.rZ + "," + this.ang + "deg)";
    }
}

for(let i = 0; i < KAMI_MAX; i++){
    kami_array.push(new Kami());
}
setInterval(function(){
    for(let i = 0; i < KAMI_MAX; i++){
        kami_array[i].update();
    }
},50);
7