<template>
    <section class="flex">
        <div class="left">
            <h1><i class="fas fa-th-list"></i> TODO LISTER</h1>
            <div class="select">
                <input @click="catcreate" class="btn create" type="button" name="todocreate" value="リストを作成"></input>
            </div>
        </div>
        <div class="right">
            <input class="btn login" type="submit" name="logout" value="ログアウト"></input>
        </div>
    </section>
</template>

<script>
    export default {
        data(){
            return{
                showflg : false,
            }
        },
        methods:{
            catcreate:function(){
                let btncreate = document.querySelector(".btn.create");
                let catcreatebox = document.querySelector('.catcreate_box');
                let createback = document.querySelector('.create_back');
                if(this.showflg){
                    this.showflg = false;
                    catcreatebox.innerHTML = "";
                    createback.classList.remove("active");
                }else{
                    this.showflg = true;
                    let html = `
                        <div class="catcreate_col">
                            <p>リスト名を入力してください</p>
                            <form method="post">
                                <input class="cat_text" type="text" name="cat_create" required>
                                <input class="cat_submit" type="submit" name="cat_create_submit" value="カテゴリ作成">
                            </form>
                        </div>
                    `;
                    catcreatebox.innerHTML = html;                  
                    createback.classList.add("active");
                }
   
            }
        }
    }
    document.querySelector('.create_back').onclick = function(){
        document.querySelector('.catcreate_box').innerHTML = "";
        document.querySelector('.create_back').classList.remove('active');
    }
</script>