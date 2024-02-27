<style>

body{
    background-color: #f0f0f0;
    margin: 0px;
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}

#container{
    width: 100%;
    margin: 0 auto;
    background-color: #fcfcfc;
    overflow: hidden;
}

@media (max-width: 800px) {
    #container{
        width: 800px;
    }
}

::selection{
    background: #0047cc;
    color: white;
    text-shadow: 0px 2px 4px black;
}

.left{
    float: left;
}

.right{
    float: right;
}

.flex{
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.jflex{
    display: flex;
    align-items: center;
}

.jjflex{
    display: flex;
}

footer h3{
    margin: 0px;
}

footer p{
    margin: 0px;
}

.lower{
    text-transform: lowercase;
}

.lower::placeholder{
    text-transform: none;
}

.centered{
    display: flex;
    gap: 10px;
    margin: auto;
    width: 100%;
    padding: 10px;
    align-items: center;
}

.vhr{ 
    border: none;
    border-left: 1px solid hsla(200, 10%, 50%,100);
    width: 1px;       
}

a{
    color: #0047cc;
    text-decoration: none;
}

a:hover{
    text-decoration: underline;
}

.block{
    width: 100px;
    height: 60px;
    background-image: url("../assets/block_texture_v1.png");
    background-size: 100px;
}

.navbar{
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-sizing: border-box;
    padding-left: 10px;
    padding-right: 10px;
    box-shadow: 0px 2px 6px 1px #000000c0;
    user-select: none;
}

.navbar .logo{
    width: 130px;
    cursor: pointer;
}

.navbar .right{
    display: flex;
    gap: 0px;
}

.navbar .right .block{
    cursor: pointer;
    color: white;
    border: none;
    border-left: groove #90909040 2px;
    font-size: 18px;
    width: auto;
    padding-left: 20px;
    padding-right: 20px;
    transition: 0.2s;
}

.navbar .right .block:hover{
    background-image: url("../assets/block_texture_hover_v1.png");    
}

.navbar .right .block:active{
    background-image: url("../assets/block_texture_active_v1.png");    
}

.navbar .left .title{
    color: white;
    text-shadow: 0 1px 0 #c4c4c4;
}

.page{
    margin-top: 18px;
    padding-left: 20px;
    padding-right: 20px;
}

.page h1{
    margin: 0px;
}

.page h2{
    margin: 0px;
}

.page p{
    margin: 0px;
}

.page ul{
    margin: 0px;
}

.page li{
    margin: 0px;
}

.page label{
    margin: 0px;
}

.page form{
    margin: 0px;
}

.page input{
    margin: 0px;
}

.page .section{
    width: 370px;
    height: auto;
    background: #e8e8e8;
    border-radius: 6px;
    border: solid #c4c4c4 1px;
    box-shadow: 0px 2px 3px 1px #00000068;
    box-sizing: border-box;
    padding: 10px;
}

.page button{
    text-decoration: none;
    font-family: ".LucidaGrandeUI", "Lucida Grande", "Lucida sans unicode";
    color: black;
    font-size: 11px;
    padding: 1px 7px;
    border: 1px solid #9C9C9C;
    margin: 2px 2px;
    display: inline-block;
    background-image: -webkit-linear-gradient(
    #ffffff 0%, #F6F6F6 	30%, 
    #F3F3F3 45%, #EDEDED 	60%, 
    #eeeeee 100%);
    border-radius: 3px;
    cursor: pointer;
    box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.20);
    outline: none;
}

.page red{
    color: red;
}

.page button:active {
    border-color:#705ebb;
    background-image:-webkit-linear-gradient(
    #acc5e9 0%, 		#a3c0f2 18%, 
    #61a0ed 39%,		#55a3f2 70%, 
    #82c2f1 91.72%, 	#9AD2F2 100%); 
    box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.65);		
}

.page button.disabled{
    cursor: default;
    color: #999!important;
    background-image: -webkit-linear-gradient(#fbf8f8 0%, #f0f0f0 30%, #e3e3e3 45%, #d7d7d7 60%, #cbc9c9 100%);
}

.page input, textarea{
    text-decoration: none;
    font-family: ".LucidaGrandeUI", "Lucida Grande", "Lucida sans unicode";
    color: black;
    font-size: 11px;
    padding: 1px 7px;
    border: 1px solid #9C9C9C;
    margin: 2px 2px;
    display: inline-block;
    background-image: -webkit-linear-gradient(
    #ffffff 0%, #F6F6F6 	30%, 
    #F3F3F3 45%, #EDEDED 	60%, 
    #eeeeee 100%);
    border-radius: 3px;
    box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.20);
    outline: none;
}

.page .twos{
    height: 360px;
}

.updates-bar{
    align-items: center;
    justify-content: space-between;
    box-sizing: border-box;
    background: linear-gradient(#00eeee 1%, cyan 30%, darkcyan 100%);
    color: black;
    box-shadow: 0px 2px 6px 1px #000000c0;
    user-select: none;
    text-shadow: 0 1px 0 white;
}

.insights-bar{
    align-items: center;
    justify-content: space-between;
    box-sizing: border-box;
    background: linear-gradient(#0090ee 1%, blue 30%, darkblue 100%);
    color: black;
    box-shadow: 0px 2px 6px 1px #FFFFFFc0;
    user-select: none;
    text-shadow: 0 1px 0 black;
    background-image: url("../assets/paper_texture.png");
    background-size: 300px;
    box-shadow: 0px 3px 12px 1px #00000060;
}

bold{
    font-weight: bold;
}

.page .insight-post-section, .page .twist-post-section{
    width: calc(100% - 20px);
    height: auto;
    background: #d4d4d4;
    border-radius: 10px;
    background-image: url("../assets/grid_paper_texture_1.png");
    background-size: calc(100% - 20px);
    padding: 10px;
    border: 1px solid #9C9C9CA4;
    position: -webkit-sticky;
    position: sticky;
    box-shadow: 0px 3px 12px 1px #00000060;
    top: 0;
}

.page .insight-post-section .glass, .page .twist-post-section .glass{
    background: none;
    background-image: -webkit-linear-gradient(
    #ffffff70 0%, #F6F6F670 	30%, 
    #F3F3F370 45%, #EDEDED70 	60%, 
    #eeeeee70 100%);
    backdrop-filter: blur(2px);
    border: 1px solid #FFFFFFA4;
}

.page .sections{
    height: auto;
    display: flex;
}

.page .sections .part1{
    width: calc(100% * (70 / 100));
}

.page .sections .part2{
    width: calc(100% * (30 / 100));
}

.page .sections .part2._{
    margin-right: 20px;
}

.page .twists-list{
    display: grid;
}

.page .twists-list .twist{
    width: calc(100% - 16px);
    background: #f6f6f6;
    padding: 2px;
    box-sizing: border-box;
    padding: 8px;
    background-image: url("../assets/lines_texture_1.png");
    background-size: 100px;
    box-shadow: 0px 3px 12px 1px #00000060;
}

.page .twists-list .twist .pic{
    width: 70px;
    min-width: 70px;
    max-width: 70px;
    height: 70px;
    min-height: 70px;
    max-height: 70px;
}

.page .twists-list .twist .username{
    margin-top: -80px;
    margin-left: 80px;
}

.page .twists-list .twist .text{
    margin-top: -20px;
    font-size: 13px;
    margin-left: 80px;
}

.page .twists-list .twist .badge-vip{
    width: 20px;
    height: 20px;
    background-image: url("../assets/VIP.png");
    background-size: 20px;
    position: absolute;
    margin-left: 60px;
    margin-top: -20px;
}

.page .twists-list .twist .badge-certif{
    width: 20px;
    height: 20px;
    background-image: url("../assets/Certification.png");
    background-size: 20px;
    position: absolute;
    margin-left: 50px;
    margin-top: -20px;
}

.page .twists-list .twist .badge-official{
    width: 20px;
    height: 20px;
    background-image: url("../assets/Official.png");
    background-size: 20px;
    position: absolute;
    margin-left: 40px;
    margin-top: -20px;
}

.page .twists-list .twist .jjflex{
    display: flex;
}

.fullbox{
    width: calc(100% + 40px);
    height: 160px;
    background: linear-gradient(rgba(30, 180, 230, 255), rgba(0, 130, 180, 255));
    margin-left: -20px;
    margin-top: -18px;
    box-shadow: inset 0px 2px 2px 2px rgba(255, 255, 255, 0.25), inset 0px -2px 2px 2px rgba(0, 0, 0, 0.25);
    color: white;
    text-shadow: 1px 1px 0 black, -1px -1px darkcyan;
}

.fullbox .pic{
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    height: 100px;
    min-height: 100px;
    max-height: 100px;
    margin-top: 30px;
    margin-left: 30px;
    position: absolute;
}

.fullbox .username{
    font-size: 22px;
    position: absolute;
    margin-top: 30px;
    margin-left: 150px;
}

.fullbox .biography{
    font-size: 12px;
    position: absolute;
    margin-top: 60px;
    margin-left: 150px;
    width: 400px;
}

/*.fullbox .followers{
    position: absolute;
    margin-left: calc(650px - 10px);
    text-align: right;
}*/

.fullbox .follow_button{
    text-align: center;
    font-size: 16px;
}

.fullbox .flex_box_pr{
    display: grid;
    position: absolute;
    margin-left: calc(650px - 4px);
    text-align: right;
    float: right;
    margin-top: 10px;
}

.fullbox .flex_box_pr .followers{
    height: 20px;
}

.fullbox .creation_date{
    float: right;
    text-align: right;
    margin-top: 120px;
    margin-right: 30px;
    font-size: 16px;
    font-weight: 100;
}

.fullbox .badge-vip{
    width: 25px;
    height: 25px;
    background-image: url("../assets/VIP.png");
    background-size: 25px;
    position: absolute;
    margin-left: 115px;
    margin-top: 120px;
}

.fullbox .badge-certif{
    width: 25px;
    height: 25px;
    background-image: url("../assets/Certification.png");
    background-size: 25px;
    position: absolute;
    margin-left: 100px;
    margin-top: 120px;
}

.fullbox .badge-official{
    width: 25px;
    height: 25px;
    background-image: url("../assets/Official.png");
    background-size: 25px;
    position: absolute;
    margin-left: 85px;
    margin-top: 120px;
}

.side-section{
    width: calc(100% - 20px);
    height: auto;
    background: #d4d4d4;
    border-radius: 10px;
    padding: 10px;
}

.glass{
    background: none;
    background-image: -webkit-linear-gradient(
    #ffffff70 0%, #F6F6F670 	30%, 
    #F3F3F370 45%, #EDEDED70 	60%, 
    #eeeeee70 100%);
    backdrop-filter: blur(1px);
}

.accounts_list{
    width: 100%;
    height: auto;
    overflow-x: scroll;
    overflow-y: hidden;
    gap: 20px;
    display: flex;
    scroll-snap-type: x mandatory;
    padding: 12px;
}

.accounts_list .account{
    box-sizing: border-box;
    display: grid;
    text-align: center;
    width: 180px;
    height: 250px;
    box-sizing: border-box;
    padding: 12px;
    background-image: url("../assets/lines_texture_1.png");
    background-size: 100px;
    box-shadow: 0px 3px 12px 1px #00000060;
}

.accounts_list .account .pic{
    width: calc(180px - 12px * 2);
    height: calc(180px - 12px * 2);
    min-width: calc(180px - 12px * 2);
    min-height: calc(180px - 12px * 2);
    max-width: calc(180px - 12px * 2);
    max-height: calc(180px - 12px * 2);
}

.accounts_list .account .badge-vip{
    width: 25px;
    height: 25px;
    position: sticky;
    background-image: url("../assets/VIP.png");
    background-size: 25px;
    margin-top: -20px;
    margin-left: 142px;
    z-index: 10;
}

.accounts_list .account .badge-certif{
    width: 25px;
    height: 25px;
    position: sticky;
    background-image: url("../assets/Certification.png");
    background-size: 25px;
    margin-top: -25px;
    margin-left: calc(142px - 15px);
    z-index: 20;
}

.accounts_list .account .badge-official{
    width: 25px;
    height: 25px;
    position: sticky;
    background-image: url("../assets/Official.png");
    background-size: 25px;
    z-index: 100;
    margin-top: -25px;
    margin-left: calc(142px - 30px);
    z-index: 30;
}

.accounts_list .account .username{
    margin-top: 0px;
}

.searchbar{
    margin: auto;
    display: flex;
    width: 70%;
    margin-left: calc(10% - 10px);
    text-decoration: none;
    font-family: ".LucidaGrandeUI", "Lucida Grande", "Lucida sans unicode";
    color: black;
    font-size: 11px;
    padding: 1px 7px;
    border: 1px solid #9C9C9C;
    display: inline-block;
    background-image: -webkit-linear-gradient(
    #ffffff 0%, #F6F6F6 	30%,
    #F3F3F3 45%, #EDEDED 	60%,
    #eeeeee 100%);
    border-radius: 3px;
    box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.20);
    outline: none;
}

</style>