<template>
    <section>
        <h1>TODO LISTER</h1>
        <span @click="changemode" class="mode_change">
            <span class="iconbox"><i class="fas fa-user-plus"></i></span>
        </span>
        <div v-show="form" class="form">
            <div class="loginbox margin">
                <p>■ユーザー名</p>
                <input type="text" name="login-user-id" placeholder="ID">
            </div>
            <div class="loginbox margin">
                <p>■パスワード</p>
                <input type="password" name="login-user-pass" placeholder="password">
            </div>
            <div class="center">
                <input class="btn login" type="submit" name="login" value="ログイン"></input>
            </div>
            <div @click="forgetBtn" class="forget_login">
                <p>パスワードを忘れた方はコチラ</p>
            </div>
        </div>
        <div v-show="ac_create" class="ac_create">
            <div class="loginbox margin">
                <p>■ユーザー名</p>
                <input type="text" name="user-id" placeholder="ID">
            </div>
            <div class="loginbox margin">
                <p>■パスワード</p>
                <input type="text" name="user-pass" placeholder="password">
            </div>
            <div class="loginbox margin">
                <p>■メールアドレス</p>
                <input type="text" name="user-mail" placeholder="mail">
            </div>
            <div class="center">
                <input class="btn login" type="submit" name="ac_create" value="アカウント作成"></input>
            </div>
        </div>
        <div v-show="pass_forget" class="pass_forget">
            <div class="loginbox margin">
                <p>■メールアドレス</p>
                <input type="text" name="forget-user-mail" placeholder="mail">
            </div>
            <div class="center">
                <input class="btn login" type="submit" name="forget_mail" value="パスワード再設定メール送信"></input>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data(){
            return{
                modeflg:false,
                form:true,
                ac_create:false,
                pass_forget:false,
            }
        },
        methods:{
            changemode:function(){
                let iconbox = document.querySelector(".iconbox")
                if(this.modeflg){
                    iconbox.innerHTML = `<i class="fas fa-user-plus"></i>`
                    this.modeflg = false
                    this.form = true
                    this.ac_create = false
                    this.pass_forget = false
                }else{
                    iconbox.innerHTML = `<i class="fas fa-times"></i>`
                    this.modeflg = true
                    this.form = false
                    this.ac_create = true
                }
            },
            forgetBtn:function(){
                let iconbox = document.querySelector(".iconbox")
                if(!this.modeflg){
                    iconbox.innerHTML = `<i class="fas fa-times"></i>`
                    this.modeflg = true
                    this.pass_forget = true
                    this.form = false
                }
            }
        }
        
    }
</script>